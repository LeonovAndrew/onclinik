<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Alphabet,
    MWI\Direction,
    MWI\DirectionList;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$arLetters = Alphabet::getList();

$arGroupedByLetter = array();
foreach ($arLetters as $arLetter) {
    $arGroupedByLetter[$arLetter['XML_ID']]['name'] = strtoupper($arLetter['NAME']);
}



$arGroupedByDirection = array();
$arDirectionsId = array();

foreach ($arResult['ITEMS'] as $arItem) {


    if (!empty($arItem['PROPERTIES']['LETTER']['VALUE'])) {
        $arGroupedByLetter[$arItem['PROPERTIES']['LETTER']['VALUE']]['items'][] = array(
            'id' => $arItem['ID'],
            'name' => $arItem['NAME'],
            'url' => $arItem['DETAIL_PAGE_URL'],
        );
    }

    if (!empty($arItem['PROPERTIES']['DIRECTIONS']['VALUE'])) {
        foreach ($arItem['PROPERTIES']['DIRECTIONS']['VALUE'] as $directionId) {
            $arDirectionsId[$directionId] = $directionId;
            $arGroupedByDirection[$directionId]['items'][] = array(
                'id' => $arItem['ID'],
                'name' => $arItem['NAME'],
                'url' => $arItem['DETAIL_PAGE_URL'],
            );
        }
    }
}




//remove empty letters
foreach ($arGroupedByLetter as $key => $arGroup) {
    if (empty($arGroup['items'])) {
        unset($arGroupedByLetter[$key]);
    }
}

//get directions names
$directionList = new DirectionList();
foreach ($arDirectionsId as $directionId) {
    $direction = new Direction($directionId);

    $directionList->add($direction);
}
$directionList->makeData();

foreach ($arGroupedByDirection as $directionId => &$arGroup) {
    $arGroup['name'] = $directionList->getById($directionId)->name;
}

$arResult['letter_groups'] = $arGroupedByLetter;
$arResult['direction_groups'] = $arGroupedByDirection;
