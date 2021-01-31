<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction,
    MWI\Service,
    MWI\ServiceList,
    MWI\ServiceOffer,
    MWI\Stock,
    MWI\StockList,
    MWI\Personal,
    MWI\Disease,
    MWI\Symptom,
    MWI\Question,
    MWI\Recommendation,
    MWI\Review;

/**
 * @var $arParams
 * @var $arResult
 */

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

$obService = new Service($arResult['ID']);
$obService->makeData();
$obServiceList = new ServiceList();
$obServiceList->add($obService);
$obOffers = $obService->getOffers();
$arPrice = $obOffers->getMinimumPrice();
$obService->minimumPrice = $arPrice['price'];
$obService->minimumDiscountPrice = $arPrice['discount_price'];
$arResult['OFFERS'] = $obOffers->getList();

if (!$obOffers->isEmpty()) {
    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_PRICES'),
        'LINK' => '#price',
        'DEPTH_LEVEL' => 100,
        'IS_PARENT' => false,
    );
}



/**
 * get doctors
 */
$obDoctors = $obService->getDoctors();
$obDoctors->makeData();
$arResult['DOCTORS'] = $obDoctors->getList();

$firstTab = true;
$arResult['BOTTOM_TABS'] = array();
/**
 * get diseases
 */
$obDiseases = $obService->getDiseases(18);
if (!$obDiseases->isEmpty()) {
    $arResult['BOTTOM_TABS']['DISEASES'] = array(
        'NAME' => getMessage('ND_DIRECTIONS_DISEASES_TAB'),
        'ITEMS' => $obDiseases->getList(),
        'SELECTED' => $firstTab,
    );
    $firstTab = false;

    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_DISEASES'),
        'LINK' => '#diseases',
        'DEPTH_LEVEL' => $menuSort,
        'IS_PARENT' => true,
    );
    $menuSort += 10;
}

/**
 * get symptoms
 */
$obSymptoms = $obService->getSymptoms(18);
if (!$obSymptoms->isEmpty()) {
    $arResult['BOTTOM_TABS']['SYMPTOMS'] = array(
        'NAME' => getMessage('ND_DIRECTIONS_SYMPTOMS_TAB'),
        'ITEMS' => $obSymptoms->getList(),
        'SELECTED' => $firstTab,
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
 * get questions
 */
$obQuestions = $obService->getQuestions(2);
if (!$obQuestions->isEmpty()) {
    $arQuestions = $obQuestions->getList();
    foreach ($arQuestions as &$obQuestion) {
        if (!empty($obQuestion->publicationDate)) {
            $obQuestion->publicationDate = FormatDateFromDB($obQuestion->publicationDate, Question::DATE_SHORT);
        }
    }
    $arResult['BOTTOM_TABS']['QUESTIONS'] = array(
        'NAME' => getMessage('ND_DIRECTIONS_QUESTIONS_TAB'),
        'ITEMS' => $arQuestions,
        'SELECTED' => $firstTab,
    );
    $firstTab = false;

    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_QUESTIONS'),
        'LINK' => '#questions',
        'DEPTH_LEVEL' => $menuSort,
        'IS_PARENT' => true,
    );
    $menuSort += 10;
}

/**
 * get recommendations
 */
$obRecommendations = $obService->getRecommendations(2);
if (!$obRecommendations->isEmpty()) {
    $arResult['BOTTOM_TABS']['RECOMMENDATIONS'] = array(
        'NAME' => getMessage('ND_DIRECTIONS_RECOMMENDATIONS_TAB'),
        'ITEMS' => $obRecommendations->getList(),
        'SELECTED' => $firstTab,
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

/**
 * get reviews
 */
$obReviews = $obService->getReviews();
if (!$obReviews->isEmpty()) {
    $arReviews = $obReviews->getList();
    foreach ($arReviews as &$obReview) {
        if (!empty($obReview->publicationDate)) {
            $obReview->publicationDate = FormatDateFromDB($obReview->publicationDate, Review::DATE_SHORT);
        }
    }
    $arResult['BOTTOM_TABS']['REVIEWS'] = array(
        'NAME' => getMessage('ND_DIRECTIONS_REVIEWS_TAB'),
        'ITEMS' => $obReviews->getList(),
        'SELECTED' => $firstTab,
    );
    $firstTab = false;

    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_REVIEWS'),
        'LINK' => '#reviews',
        'DEPTH_LEVEL' => $menuSort,
        'IS_PARENT' => true,
    );
    $menuSort += 10;
}

$arAnchorMenu[] = array(
    'TEXT' => getMessage('MENU_TO_START'),
    'LINK' => '#start',
    'DEPTH_LEVEL' => 1000,
    'IS_PARENT' => false,
);

/**
 * get other services
 */
 
/* 
$arResult['OTHER_SERVICES'] = array();
$obServices = new ServiceList();
if (!empty($arResult['PROPERTIES']['DIRECTION']['VALUE'])) {
    foreach ($arResult['PROPERTIES']['DIRECTION']['VALUE'] as $directionId) {
        $obDirection = new Direction($arResult['PROPERTIES']['DIRECTION']['VALUE']);
        $obDirection->makeData();

        $obDirServices = $obDirection->getServices();
        foreach ($obDirServices->getList() as $obService) {
            if (!$obServices->contains($obService->id)) {
                $obServices->add($obService);
            }
        }
    }

    foreach ($obServices->getList() as $obService) {
        $obOffers = $obService->getOffers();
        $arPrice = $obOffers->getMinimumPrice();
        $obService->minimumPrice = $arPrice['price'];
        $obService->minimumDiscountPrice = $arPrice['discount_price'];
    }
    $obServices->makeData();

    foreach ($obServices->getList() as $obOtherService) {
        if ($obOtherService->id != $arResult['ID']) {
            $arResult['OTHER_SERVICES'][] = array(
                'NAME' => $obOtherService->name,
                'PRICE' => $obOtherService->minimumPrice,
                'PREVIEW_TEXT' => $obOtherService->previewText,
                'URL' => $obOtherService->url,
            );
        }
    }
}
*/

/**
 * get stocks
 */


$stockList = $obServiceList->getStocks( $arResult['PROPERTIES']['DIRECTION']['VALUE'] );
$arResult['STOCKS'] = $stockList->getList();

if (!empty($arResult['DETAIL_PICTURE']['SRC'])) {
	$pic = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>600, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL);
	$arResult['DETAIL_PICTURE']['SRC'] = $pic['src'];			
}

/**
 * add tags to cache
 */
$arTags = array(
    'iblock_id_' . Stock::getIBlockId(),
    'iblock_id_' . Service::getIBlockId(),
    'iblock_id_' . ServiceOffer::getIBlockId(),
    'iblock_id_' . Personal::getIBlockId(),
    'iblock_id_' . Disease::getIBlockId(),
    'iblock_id_' . Symptom::getIBlockId(),
);
addTagsToComponentCache($this->__component, $arTags);

$arResult['ANCHOR_MENU'] = $arAnchorMenu;

$this->__component->SetResultCacheKeys(
    array(
        'ANCHOR_MENU'
    )
);
