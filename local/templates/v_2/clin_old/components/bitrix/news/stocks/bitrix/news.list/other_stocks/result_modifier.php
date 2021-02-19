<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Stock;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

foreach ($arResult['ITEMS'] as &$arItem) {
    if (!empty($arItem['DATE_ACTIVE_TO'])) {
        $arItem['expire_date'] = FormatDateFromDB($arItem['DATE_ACTIVE_TO'], Stock::DATE_FULL);
    }
}
