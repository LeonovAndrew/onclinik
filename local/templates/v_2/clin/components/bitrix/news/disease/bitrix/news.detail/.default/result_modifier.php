<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Service,
    MWI\ServiceList,
    MWI\Symptom,
    MWI\SymptomList,
    MWI\Disease;

/**
 * @var $arParams
 * @var $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

$obDisease = new Disease($arResult['ID']);

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
$arResult['STOCKS'] = $obDisease->getStocks( $arResult['PROPERTIES']['DIRECTIONS']['VALUE'] )->getList();
/**
 * symptoms
 */
if (!empty($arResult['PROPERTIES']['SYMPTOMS']['VALUE'])) {
    $symptomsList = new SymptomList();
    foreach ($arResult['PROPERTIES']['SYMPTOMS']['VALUE'] as $symptomId) {
        $symptom = new Symptom($symptomId);

        $symptomsList->add($symptom);
    }
    $symptomsList->makeData();

    $arTabs['SYMPTOMS'] = array(
        'selected' => $firstTab,
        'name' => getMessage('SYMPTOMS_TAB'),
        'items' => $symptomsList->getList(),
        'preview_text' => $arResult['PROPERTIES']['SYMPTOMS_TAB_PREVIEW_TEXT']['~VALUE']['TEXT'],
        'detail_text' => $arResult['PROPERTIES']['SYMPTOMS_TAB_DETAIL_TEXT']['~VALUE']['TEXT'],
    );
    $firstTab = false;

    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_SYMPTOMS'),
        'LINK' => '#symptoms',
        'DEPTH_LEVEL' => $menuSort,
        'IS_PARENT' => true,
    );
    $menuSort += 10;
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
$obRecommendations = $obDisease->getRecommendations(2);
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
        'ANCHOR_MENU',
		'PROPERTIES'
    )
);