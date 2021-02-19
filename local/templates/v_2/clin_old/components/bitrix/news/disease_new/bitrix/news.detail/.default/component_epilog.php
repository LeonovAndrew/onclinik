<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
global $arDiseaseFilter;
$arDiseaseFilter = Array('ID' => $arResult['PROPERTIES']['DISEASES']['VALUE']);


/**
 * Thx bitrix for params field in custom menu.
 *
 * IS_PARENT - type. "N" - simple link. "Y" - Tab link.
 * DEPTH_LEVEL - sort.
 */
foreach ($arResult['ANCHOR_MENU'] as $arMenu) {
    $GLOBALS['BX_MENU_CUSTOM']->AddItem(
        'anchor',
        array(
            'TEXT' => $arMenu['TEXT'],
            'LINK' => $arMenu['LINK'],
            'DEPTH_LEVEL' => $arMenu['DEPTH_LEVEL'],
            'IS_PARENT' => $arMenu['IS_PARENT'],
        )
    );
}

$APPLICATION->AddChainItem(getMessage('DISEASES'), getMessage('DISEASES_URI'));