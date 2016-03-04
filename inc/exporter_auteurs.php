<?php
if (!defined('_ECRIRE_INC_VERSION')) return;
/**
 * Fonction d'export d'auteur
 * @param  string $statut Filtrer selon un auteur précis
 * @return void
 */
function inc_exporter_auteurs_dist($statut = 'all') {

  // On exclus d'office
  $where = array('statut != '.sql_quote('5poubelle'));

  // Si on passe un statut d'auteur, on limite l'export à ce statut
  if ($statut and $statut != 'all')
    $where[] = 'statut = '.sql_quote($statut);

  // On récupère la table auteurs et ces informations.
  $table_auteur = table_objet_sql('auteurs');
  $table_auteur_info = lister_tables_objets_sql($table_auteur);

  // On ajoute l'id_auteur, on en aura besoin pour les mises à jours
  $table_auteur_info['champs_editables'] = array_merge(array('id_auteur'), $table_auteur_info['champs_editables']);

  // On fait la requête SQL pour avoir tous les auteurs
  $auteurs_spip = sql_allfetsel($table_auteur_info['champs_editables'], $table_auteur, $where);

  // La première ligne du csv est la liste des champs que l'on exporte.
  $auteurs_spip = array_merge(array($table_auteur_info['champs_editables']), $auteurs_spip);

  // Créer le fichier csv
  $exporter_csv = charger_fonction('exporter_csv', 'inc/');
  $exporter_csv('auteur_spip', $auteurs_spip);
}