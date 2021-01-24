<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['PROPERTIES']['DOCTOR']['VALUE'])) {
        $arItem['doctor'] = array(
            'name' => $arItem['DISPLAY_PROPERTIES']['DOCTOR']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DOCTOR']['VALUE']]['NAME']
        );
    }

    if (!empty($arItem['PROPERTIES']['CLINIC']['VALUE'])) {
        $arItem['clinic'] = array(
            'name' => $arItem['DISPLAY_PROPERTIES']['CLINIC']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['CLINIC']['VALUE']]['NAME']
        );
    }
}
