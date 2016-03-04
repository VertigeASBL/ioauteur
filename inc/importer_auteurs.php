<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Fonction d'importation d'auteur
 * @param  array $auteurs_list tableau associatif contenant
 *                             les auteurs: array(
 *                                            array(id_auteur => X,
 *                                            'nom' => 'nom_auteur,
 *                                             ...'))
 * @param  string $statut       statut pour les auteurs importé
 * @param  bool $delete         Si il faut supprimer les auteurs qui ne sont pas dans le fichier
 *
 * @return string               Eventuel message d'erreur.
 */
function inc_importer_auteurs_dist($auteurs_list, $statut = '6forum', $delete = false) {
    // API de modification d'auteur
    include_spip('action/editer_auteur');

    $erreur = '';

    // On commence par faire le ménage si c'est demander
    if ($delete) {
        // On n'a besoin que des id_auteur pour cela
        $id_liste = array_column($auteurs_list, 'id_auteur');
        // les id_auteurs de la base de donnée. On ne peux prend que les 6forums, les autres sont protégé
        $id_base = sql_allfetsel('id_auteur', 'spip_auteurs', 'statut='.sql_quote('6forum'));
        $id_base = array_column($id_base, 'id_auteur');

        // On cherche les différences entre la base de donnée et le fichier.
        $to_delete = array_diff($id_base, $id_liste);

        // On va mettre les auteurs à la poubelle.
        include_spip('action/editer_auteur');
        foreach($to_delete as $id_delete)
            auteur_instituer($id_delete, array('statut' => '5poubelle'));
    }


    // On boucle sur les auteurs du tableau $auteurs_list.
    foreach ($auteurs_list as $ligne => $auteurs) {

        /**
         * Le fichier CSV ne commence pas à 0 mais à 1.
         * De plus la première ligne contient les entêtes de colonnes.
         * Du coup, le numéro de ligne doit être incrémenté de 2.
         */
        $ligne += 2;

        /**
         * Avant de commencer à inserer/modifier des éléments,
         * on vérifie qu'on a bien le minimum pour créer un auteur,
         * à savoir:
         * - Un nom
         * - Un email valide
         */
        $auteurs['nom'] = trim($auteurs['nom']);
        if (empty($auteurs['nom'])
        or empty($auteurs['email'])
        or !email_valide($auteurs['email']))
            $erreur .= _T('ioauteurs:erreur_ligne_csv', array('ligne' => $ligne));
        else {
            // Par défaut ce n'est pas un nouvel auteur
            $new = false;

            // On vérifie si l'id_grepa est déjà connu ou non
            $id_auteur = sql_getfetsel('id_auteur', 'spip_auteurs', 'id_grepa='.intval($auteurs['id_grepa']));

            // S'il n'y a pas d'id_auteur, on va en ajouter un
            if (empty($id_auteur)) {
                $id_auteur = auteur_inserer();
                // On change le flag pour signaler que c'est une création d'auteur.
                $new = true;
                // Si le plugin Auteur2newsletter est actif, on passe l'adresse email et le nom
                // dans request pour ajouter l'auteur à la newsletter
                if (test_plugin_actif('auteur2newsletter')) {
                    $auteur2newsletter = charger_fonction('auteur2newsletter', 'inc');
                    $auteur2newsletter($auteurs, $auteurs['lang']);
                }
            }

            // On modifie les informations de l'auteur
            auteur_modifier($id_auteur, $auteurs, true);

            // Si c'est un nouvel auteur, on l'institue
            if ($new) {
                // On va générer un nouveau password
                include_spip('inc/acces');
                $password = creer_pass_aleatoire();
                $insti = auteur_instituer($id_auteur,
                array(
                    'statut' => $statut,
                    'login' => $auteurs['nom'],
                    'pass' => $password)
                );

                // On envoie un mail à la personne pour la notifier de son nouveau compte.
                $envoyer_mail = charger_fonction('envoyer_mail', 'inc');
                $lang = $auteurs['lang'];
                $data_lang = array(
                    'nom' => $auteurs['nom'],
                    'nom_site_spip' => extraire_multi($GLOBALS['meta']['nom_site'], $lang),
                    'login' => $auteurs['nom'],
                    'password' => $password,
                    'spip_lang' => $lang
                );
                $email = array(
                    'texte' => _T('ioauteurs:email_texte', $data_lang),
                    'from' => $GLOBALS['meta']['email_webmaster'],
                    'nom_envoyeur' => extraire_multi($GLOBALS['meta']['nom_site'], $lang)
                );

                spip_log($email, 'ioauteur_send');

                $send = $envoyer_mail(
                    $auteurs['email'],
                    _T('ioauteurs:email_sujet', $data_lang),
                    $email
                );

                spip_log($send, 'ioauteur_send');
            }
        }
    }

    return $erreur;
}