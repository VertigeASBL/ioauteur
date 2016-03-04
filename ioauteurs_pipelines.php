<?php
/**
 * Utilisations de pipelines par Import/Export d&#039;auteurs
 *
 * @plugin     Import/Export d&#039;auteurs
 * @copyright  2014
 * @author     Vertige (Didier)
 * @licence    GNU/GPL
 * @package    SPIP\Ioauteurs\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

// Un pipeline pour modifier l'affichage de la colonne de gauche sur la page auteur.
function ioauteurs_affiche_gauche($flux) {

  // Liste des pages sur lequel doit s'afficher les options d'import/export
  $page_auteur = array('auteurs', 'visiteurs');

  if (in_array($flux['args']['exec'], $page_auteur)) {
    $flux['data'] .= recuperer_fond('navigation/exporter');
  }

  return $flux;
}