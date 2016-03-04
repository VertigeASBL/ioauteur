<?php
function formulaires_importer_auteurs_charger_dist() {
  // Contexte du formulaire.
  $contexte = array();

  return $contexte;
}

/*
*   Fonction de vérification, cela fonction avec un tableau d'erreur.
*   Le tableau est formater de la sorte:
*   if (!_request('NomErreur')) {
*       $erreurs['message_erreur'] = '';
*       $erreurs['NomErreur'] = '';
*   }
*   Pensez à utiliser _T('info_obligatoire'); pour les éléments obligatoire.
*/
function formulaires_importer_auteurs_verifier_dist() {
  $erreurs = array();

  // Si ce n'est pas un fichier CSV on renvoie une erreur.
  if ($_FILES['fichier']['type'] != 'text/csv')
    $erreurs['message_erreur'] = _T('ioauteurs:erreur_csv');

  // Erreur d'upload
  if ($_FILES['fichier']['type'] != 0)
    $erreurs['message_erreur'] = _T('erreur_technique_enregistrement_impossible');

  return $erreurs;
}

function formulaires_importer_auteurs_traiter_dist() {
  //Traitement du formulaire.
  $res = array('editable' => true);

  // On va lire le csv
  $importer_csv = charger_fonction('importer_csv', 'inc');
  $csv = $importer_csv($_FILES['fichier']['tmp_name'], true, _IOAUTEUR_CSV_DELIMITEUR);

  $csv = pipeline('pre_import_auteur', $csv);

  $importer_auteurs = charger_fonction('importer_auteurs', 'inc');
  $res['message_erreur'] = $importer_auteurs($csv, '6forum', false);

  if (empty($res['message_erreur']))
    $res['message_ok'] = _T('ioauteurs:succes_importation');

  // Donnée de retour.
  return $res;
}