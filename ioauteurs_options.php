<?php
/**
 * Options du plugin Import/Export d&#039;auteursau chargement
 *
 * @plugin     Import/Export d&#039;auteurs
 * @copyright  2014
 * @author     Vertige (Didier)
 * @licence    GNU/GPL
 * @package    SPIP\Ioauteurs\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

// Délimiteur , par défaut
if (!defined(_IOAUTEUR_CSV_DELIMITEUR))
    define(_IOAUTEUR_CSV_DELIMITEUR, ',');