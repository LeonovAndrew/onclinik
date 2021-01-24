<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 */

$arTabs = array();
foreach ($arResult as $arItem) {
    $tabName = !empty($arItem['PARAMS']['tab']) ? $arItem['PARAMS']['tab'] : 'default';
    if (is_array($tabName)) {
        foreach ($tabName as $tab) {
            $arTabs[$tab]['items'][] = $arItem;
        }
    } else {
        $arTabs[$tabName]['items'][] = $arItem;
    }
}
$arResult['tabs'] = $arTabs;
$arResult['use_tabs'] = count($arResult['tabs']) > 1;
$arResult['all_title'] = $arParams['ALL_TITLE'] ? $arParams['ALL_TITLE'] : '';
$arResult['all_link'] = $arParams['ALL_LINK'] ? $arParams['ALL_LINK'] : '';
$arResult['id'] = md5(implode('', $arParams));
