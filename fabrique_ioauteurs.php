<?php

/**
 *  Fichier généré par la Fabrique de plugin v5
 *   le 2014-04-25 10:37:25
 *
 *  Ce fichier de sauvegarde peut servir à recréer
 *  votre plugin avec le plugin «Fabrique» qui a servi à le créer.
 *
 *  Bien évidemment, les modifications apportées ultérieurement
 *  par vos soins dans le code de ce plugin généré
 *  NE SERONT PAS connues du plugin «Fabrique» et ne pourront pas
 *  être recréées par lui !
 *
 *  La «Fabrique» ne pourra que régénerer le code de base du plugin
 *  avec les informations dont il dispose.
 *
**/

if (!defined("_ECRIRE_INC_VERSION")) return;

$data = array (
  'fabrique' => 
  array (
    'version' => 5,
  ),
  'paquet' => 
  array (
    'nom' => 'Import/Export d\'auteurs',
    'slogan' => 'Importer et exporter facilement des auteurs SPIP',
    'description' => '',
    'prefixe' => 'ioauteurs',
    'version' => '1.0.0',
    'auteur' => 'Vertige (Didier)',
    'auteur_lien' => 'http://www.vertige.org',
    'licence' => 'GNU/GPL',
    'categorie' => 'maintenance',
    'etat' => 'dev',
    'compatibilite' => '[3.0.16;3.0.*]',
    'documentation' => '',
    'administrations' => '',
    'schema' => '1.0.0',
    'formulaire_config' => '',
    'formulaire_config_titre' => '',
    'fichiers' => 
    array (
      0 => 'autorisations',
      1 => 'fonctions',
      2 => 'options',
      3 => 'pipelines',
    ),
    'inserer' => 
    array (
      'paquet' => '',
      'administrations' => 
      array (
        'maj' => '',
        'desinstallation' => '',
        'fin' => '',
      ),
      'base' => 
      array (
        'tables' => 
        array (
          'fin' => '',
        ),
      ),
    ),
    'scripts' => 
    array (
      'pre_copie' => '',
      'post_creation' => '',
    ),
    'exemples' => 'on',
  ),
  'objets' => 
  array (
  ),
  'images' => 
  array (
    'paquet' => 
    array (
      'logo' => 
      array (
        0 => 
        array (
          'extension' => 'png',
          'contenu' => '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',
        ),
      ),
    ),
    'objets' => 
    array (
    ),
  ),
);

?>