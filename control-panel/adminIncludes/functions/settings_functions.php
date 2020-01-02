<?php
/*
** file for the website settings
*/

function settings($settingsName) {
  global $connect;
  $tableName = 'settings';
  $stmt = $connect->prepare("SELECT * FROM $tableName WHERE settings = ?");
  $stmt->execute(array($settingsName));
  $settings = $stmt->fetchAll();
  return $settings[0]['value'];
}