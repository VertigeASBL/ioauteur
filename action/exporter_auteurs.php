<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_exporter_auteurs_dist($arg=null) {
  if (is_null($arg)){
    $securiser_action = charger_fonction('securiser_action', 'inc');
    $arg = $securiser_action();
  }

  $exporter_auteurs = charger_fonction('exporter_auteurs', 'inc');
  $exporter_auteurs($arg);
}