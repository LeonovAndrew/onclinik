<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use MWI\Price,
    MWI\ServiceOffer;

CModule::IncludeModule('iblock');

$iBlockPriceId = Price::getIBlockId();
$arIBlockServiceId = ServiceOffer::IBLOCK_ID;

$arSelect = array(
    'ID',
    'NAME',
    'PROPERTY_SERVICE'
);
$arFilter = array(
    'IBLOCK_ID' => $iBlockPriceId,
    'ACTIVE' => 'Y'
);
$obItems = CIBlockElement::GetList(
    array(),
    $arFilter,
    false,
    array(),
    $arSelect
);
while ($arItem = $obItems->fetch()) {
    $arResult['PRICES'][$arItem['PROPERTY_SERVICE_VALUE']][] = $arItem['NAME'];
}

foreach ($arIBlockServiceId as $lang => $iBlockId) {
    $arSelect = array(
        'ID',
        'NAME'
    );
    $arFilter = array(
        'IBLOCK_ID' => $iblock_service_id,
        'ACTIVE' => 'Y'
    );
    $res = CIBlockElement::GetList(
        array(),
        $arFilter,
        false,
        array(),
        $arSelect
    );
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arResult['SERVICE'][] = $arFields;
    }

    foreach ($arResult['SERVICE'] as $k => $service) {
        $PROPERTY_CODE = "PRICE_LIST";
        $PROPERTY_VALUE = $arResult['PRICES'][$service['NAME']]['ID'];
        CIBlockElement::SetPropertyValuesEx(
            $service['ID'],
            false,
            array(
                $PROPERTY_CODE => $PROPERTY_VALUE
            )
        );
    }

    echo 'Синхронизация выполнена';
}
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>