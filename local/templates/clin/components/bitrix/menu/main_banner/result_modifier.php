<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 */

$arTabs = array();

/*
foreach ($arResult as $arItem) {
    foreach ($arItem['PARAMS']['departments'] as $department) {
        if (!isset($arTabs[$department]['cnt'])) {
            $arTabs[$department]['cnt'] = 0;
        }
        $index = $arTabs[$department]['cnt'] / 8;
        $arTabs[$department]['section'][$index]['items'][] = $arItem;
        $arTabs[$department]['cnt']++;
    }
}
*/
$k = 0;
$line = 0;
foreach ($arResult as $arItem) {

	$arTabs['section'][$line]['items'][] = $arItem;
    $k++;
	if ( $k == 8 ){
		$k = 0;
		$line++;
	}
}


$arResult['tabs'] = $arTabs;
