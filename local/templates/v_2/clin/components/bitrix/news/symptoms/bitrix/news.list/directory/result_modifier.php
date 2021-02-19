<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Alphabet,
    MWI\BodyParts,
    MWI\Direction,
    MWI\DirectionList;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$arLetters = Alphabet::getList();
$arBodyParts = BodyParts::getList();

$arGroupedByLetter = array();
foreach ($arLetters as $arLetter) {
    $arGroupedByLetter[$arLetter['XML_ID']]['name'] = strtoupper($arLetter['NAME']);
}
$arGroupedByBodyPart = array();
foreach ($arBodyParts as $arBodyPart) {
    $arGroupedByBodyPart[$arBodyPart['XML_ID']]['name'] = $arBodyPart['NAME'];
    $arGroupedByBodyPart[$arBodyPart['XML_ID']]['css_top'] = $arBodyPart['CSS_TOP'];
    $arGroupedByBodyPart[$arBodyPart['XML_ID']]['css_left'] = $arBodyPart['CSS_LEFT'];
}

foreach ($arResult['ITEMS'] as $arItem) {
    if (!empty($arItem['PROPERTIES']['LETTER']['VALUE'])) {
        $arGroupedByLetter[$arItem['PROPERTIES']['LETTER']['VALUE']]['items'][] = array(
            'id' => $arItem['ID'],
            'name' => $arItem['NAME'],
            'url' => $arItem['DETAIL_PAGE_URL'],
        );
    }

    if (!empty($arItem['PROPERTIES']['BODY_PARTS']['VALUE'])) {
        foreach ($arItem['PROPERTIES']['BODY_PARTS']['VALUE'] as $bodyPart) {
            $arGroupedByBodyPart[$bodyPart]['items'][] = array(
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

//remove empty body parts
foreach ($arGroupedByBodyPart as $key => $arGroup) {
    if (empty($arGroup['items'])) {
        unset($arGroupedByBodyPart[$key]);
    }
}

$arResult['letter_groups'] = $arGroupedByLetter;
$arResult['body_part_groups'] = $arGroupedByBodyPart;
