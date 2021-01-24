<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use MWI\Direction,
    MWI\DirectionList,
    MWI\Stock,
    MWI\ServiceOffer,
    MWI\Service,
    MWI\Personal,
    MWI\Disease,
    MWI\Symptom,
    MWI\Question,
    MWI\StockList,
    MWI\Recommendation,
    MWI\Review;

/**
 * @var $arParams
 * @var $arResult
 */

/**
 * SEO
 */
$ipropValues = new Bitrix\Iblock\InheritedProperty\ElementValues($arResult["IBLOCK_ID"], $arResult["ID"]);
$arResult['SEO'] = $ipropValues->getValues();

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
//print_r($arResult);
$obDirection = new Direction($arResult['ID']);
$obDirectionList = new DirectionList();
$obDirectionList->add($obDirection);

/**
 * get stocks
 */
$stocksList = $obDirectionList->getStocks();
$stocksList->makeData();
$arResult['STOCKS'] = $stocksList->getList();

/**
 * get doctors
 */
$obDoctors = $obDirection->getDoctors();
$obDoctors->makeData();
$arResult['DOCTORS'] = $obDoctors->getList();
//dump( $arResult['DOCTORS'] );
/**
 * get services
 */
$obServices = $obDirection->getServices();
$obServices->makeData();


foreach ($obServices->getList() as $obService) {
    $obService->directionId = $obDirection->id;
    $obServiceOffers = $obService->getOffers();
    $arPrice = $obServiceOffers->getMinimumPrice();

	
	
    $obService->minimumPrice = $arPrice['price'];
    $obService->minimumDiscountPrice = $arPrice['discount_price'];
}



$arTypes = $obServices->getListGroupedByTypes();




$arResult['SERVICES'] = array(
    'TYPES_CNT' => count($arTypes),
    'TYPES' => $arTypes,
);
if (!empty($arResult['SERVICES']['TYPES'])) {
    $arAnchorMenu[] = array(
        'TEXT' => getMessage('MENU_PRICES'),
        'LINK' => '#price',
        'DEPTH_LEVEL' => 100,
        'IS_PARENT' => false,
    );
}

$firstTab = true;
$arResult['BOTTOM_TABS'] = array();
/**
 * get diseases
 */
$obDiseases = $obDirection->getDiseases(18);
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
$obSymptoms = $obDirection->getSymptoms(18);
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
$obQuestions = $obDirection->getQuestions(2);
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
$obRecommendations = $obDirection->getRecommendations(2);
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
$obReviews = $obDirection->getReviews();
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

/***********get doctors new********************/
/*echo "<pre>";
print_r($arResult["PROPERTIES"]);
echo "</pre>";*/
$doctorsArr=array();
$arSelect = Array("ID", "IBLOCK_ID", "NAME","PREVIEW_PICTURE", "DETAIL_PAGE_URL", "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>IntVal(5),"PROPERTY_DIRECTION"=>$arResult["ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){
    $doctorsItems=array();
    $arFields = $ob->GetFields();
    //print_r($arFields);
    $arProps = $ob->GetProperties();
    //print_r($arProps);
    $doctorsItems["ID"]=$arFields["ID"];
    $doctorsItems["URL"]=$arFields["DETAIL_PAGE_URL"];
    $doctorsItems["NAME"]=$arFields["NAME"];
    $img["PREVIEW_PICTURE"]=CFile::GetFileArray($arFields["PREVIEW_PICTURE"]);
    $renderImage = CFile::ResizeImageGet($img["PREVIEW_PICTURE"], Array("width" => 300, "height" => 380), BX_RESIZE_IMAGE_EXACT, false);
    $doctorsItems["IMG"]=array(
        "ALT"=>$arFields["NAME"],
        "SRC"=>$img["PREVIEW_PICTURE"]["SRC"],
        "SRC_SMALL"=>$renderImage["src"],
    );
    $doctorsItems["POSITION"]=$arProps["POSITION"]["~VALUE"]["TEXT"];
    $doctorsArr[]=$doctorsItems;
}
$arResult["DOCTORS"]=$doctorsArr;

/*********************************************/

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
