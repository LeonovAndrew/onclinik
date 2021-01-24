<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Service,
    MWI\ServiceList,
    MWI\Symptom,
    MWI\SymptomList;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$obSymptom = new Symptom($arResult['ID']);

/**
 * anchor menu
 * ! Check component_epilog for fields description.
 */
$menuSort = 500;
$arAnchorMenu = array();
foreach ($arResult['PROPERTIES']['MENU']['VALUE'] as $menu) {
    $arAnchorMenu[] = array(
        'TEXT' => $menu['name'],
        'LINK' => $menu['link'],
        'DEPTH_LEVEL' => $menu['sort'],
        'IS_PARENT' => false,
    );
}

/**
 * tabs
 */
$arTabs = array();
//for selected tab
$firstTab = true;

/**
 * stocks
 */
$arResult['STOCKS'] = $obSymptom->getStocks()->getList();

/**
 * stock counters params
 */
$arResult['counter'] = array(
    'words' => array(
        'hours' => getMessage('ND_WORDS_HOURS'),
        'minutes' => getMessage('ND_WORDS_MINUTES'),
    ),
);

/**
 * diseases
 */
$diseasesList = $obSymptom->getDiseases();
if (!$diseasesList->isEmpty()) {
    $arTabs['DISEASES'] = array(
        'selected' => $firstTab,
        'name' => getMessage('DISEASES_TAB'),
        'items' => $diseasesList->getList(),
        'preview_text' => $arResult['PROPERTIES']['DISEASES_TAB_PREVIEW_TEXT']['~VALUE']['TEXT'],
        'detail_text' => $arResult['PROPERTIES']['DISEASES_TAB_DETAIL_TEXT']['~VALUE']['TEXT'],
    );

    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_DISEASES'),
        'LINK' => '#diseases',
        'DEPTH_LEVEL' => $menuSort,
        'IS_PARENT' => true,
    );
    $menuSort += 10;

    $firstTab = false;
}

/**
 * services
 */
if (!empty($arResult['PROPERTIES']['SERVICES']['VALUE'])) {
    $servicesList = new ServiceList();

    foreach ($arResult['PROPERTIES']['SERVICES']['VALUE'] as $serviceId) {
        $service = new Service($serviceId);

        $servicesList->add($service);
    }
    $servicesList->makeData();
    foreach ($servicesList->getList() as $obService) {
        $serviceOffersList = $obService->getOffers();
        $arPrice = $serviceOffersList->getMinimumPrice();
        $obService->minimumPrice = $arPrice['price'];
        $obService->minimumDiscountPrice = $arPrice['discount_price'];
    }

    $arTypes = $servicesList->getListGroupedByTypes();

    foreach ($arTypes as $arType) {
        $arTabs['SERVICES'][] = array(
            'selected' => $firstTab,
            'name' => $arType['NAME'],
            'items' => $arType['ITEMS'],
            'text' => $arResult['PROPERTIES'][$arType['CODE'] . '_TAB_TEXT']['~VALUE']['TEXT'],
            'id' => strtolower($arType['CODE']),
        );
        $firstTab = false;

        $arAnchorMenu[] = array(
            'TEXT' => $arType['NAME'],
            'LINK' => '#' . strtolower($arType['CODE']),
            'DEPTH_LEVEL' => $menuSort,
            'IS_PARENT' => true,
        );
        $menuSort += 10;
    }
}

/**
 * recommendations
 */
$obRecommendations = $obSymptom->getRecommendations(2);
if (!$obRecommendations->isEmpty()) {
    $arTabs['RECOMMENDATIONS'] = array(
        'selected' => $firstTab,
        'name' => getMessage('ND_DIRECTIONS_RECOMMENDATIONS_TAB'),
        'items' => $obRecommendations->getList(),
    );
    $firstTab = false;

    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_RECOMMENDATIONS'),
        'LINK' => '#recommendations',
        'DEPTH_LEVEL' => $menuSort,
        'IS_PARENT' => true,
    );
    $menuSort += 10;
}

$arResult['BOTTOM_TABS'] = $arTabs;

$arAnchorMenu[] = array(
    'TEXT' => getMessage('menu_to_start'),
    'LINK' => '#start',
    'DEPTH_LEVEL' => 1000,
    'IS_PARENT' => false,
);

$arResult['ANCHOR_MENU'] = $arAnchorMenu;

$this->__component->SetResultCacheKeys(
    array(
        'ANCHOR_MENU'
    )
);

