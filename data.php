<?php
// 10.05.2015
// leonhard.melzer@studieren-ohne-grenzen.org
//
// Diese Script entstand für die Förder-Kampagne im Mai 2015
// Es liest die Summe aller Beiträge von allen ordentlichen Mitgliedern
// aus der CiviCRM Datenbank, sowie die Anzahl der Mitglieder.
//
// Für die Kampagne sind wir an der Differenz interessiert, daher hier
// die Werte vom xx.05.2015
$start = array(
  'member_count' => 1040, // TODO: fix values
  'fee_sum' => 13430.00
);
// Jetzt das Script:

// no cache
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

// include civi components
require_once $_SERVER['DOCUMENT_ROOT'] . 'civi4/sites/default/civicrm.settings.php';
require_once 'CRM/Core/Config.php';
$config = CRM_Core_Config::singleton();

// construct query
$query = CRM_Core_DAO::executeQuery('
SELECT COUNT(`member`.`id`) AS `members`, SUM(`zahlung`.`betrag_37`) as `total`
FROM `civicrm_membership` AS `member`
LEFT JOIN `civicrm_value_zahlungen_9` AS `zahlung`
ON `member`.`id`=`zahlung`.`entity_id`
WHERE
  `member`.`membership_type_id`=1 AND
  `member`.`is_test`=0 AND
  `member`.`status_id` IN (1,2,3,4)
');
// execute query
$result = $query->fetch();

$output = array();
if ($result) {
  $output['member_count'] = (int) $query->members - $start['member_count'];
  $output['fee_sum'] = ((int) $query->total) -  $start['fee_sum'];
}

// output as json and exit!
echo json_encode($output);