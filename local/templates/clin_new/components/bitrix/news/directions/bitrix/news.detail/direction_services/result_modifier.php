<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction;

/**
 * @var $arParams
 * @var $arResult
 */

$obDirection = new Direction($arResult['ID']);
$obDirection->makeData();
$obOffers = $obDirection->getOffers();
$obOffers->getMinimumPrice();

$arResult['offers'] = $obOffers->getList();

if (!empty($arResult['PROPERTIES']['FILE_SERVICES']['VALUE'])) {
    $arResult['FILE_SERVICES'] = CFile::getPath($arResult['PROPERTIES']['FILE_SERVICES']['VALUE']);
}
$arResult['SEO'] = array(
    'TITLE' => $arResult['PROPERTIES']['PRICE_TITLE']['VALUE'],
    'DESCRIPTION' => $arResult['PROPERTIES']['PRICE_DESCRIPTION']['VALUE'],
    'KEYWORDS' => $arResult['PROPERTIES']['PRICE_KEYWORDS']['VALUE'],
    'H1' => $arResult['PROPERTIES']['PRICE_H1']['VALUE'],
);

$this->__component->SetResultCacheKeys(
    array(
        'DETAIL_PAGE_URL',
        'SEO',
    )
);
