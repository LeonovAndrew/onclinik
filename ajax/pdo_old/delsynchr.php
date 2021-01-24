<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use MWI\ServiceOffer;

CModule::IncludeModule('iblock');

$arIBlockServiceId = ServiceOffer::IBLOCK_ID;
$arSelect = array(
    'ID',
);
foreach ($arIBlockServiceId as $lang => $iBlockId) {
    $arFilter = array(
        'IBLOCK_ID' => $iBlockId,
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
        CIBlockElement::SetPropertyValuesEx(
            $arItem['ID'],
            $iBlockId,
            array(
                'PRICE_LIST' => array(
                    'VALUE' => array()
                )
            )
        );
    }
    echo 'Синхронизация ' . $lang . ' версии удалена.<br>';
}
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>