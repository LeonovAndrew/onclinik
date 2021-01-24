<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use MWI\Dbconnect;
use MWI\Price;
use MWI\ServiceOffer;

CModule::IncludeModule("iblock");

$iblock_prices_id = Price::getIBlockId();
$iblock_service_id = ServiceOffer::getIBlockId();

$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_SERVICE");
$arFilter = Array("IBLOCK_ID" => $iblock_prices_id, "ACTIVE" => "Y",);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
$countPRICE = $res->SelectedRowsCount();
$i = 0;
while ($ob = $res->Fetch()) {
    $i++;
    CIBlockElement::Delete($ob['ID']);
    if ($i == 2000): break; endif;
}
if ($i >= $countPRICE):
    echo 'Элементы удалены';
else:
    echo($i + $_POST['ID']);
endif;

?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>