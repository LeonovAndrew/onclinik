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
 * get doctors
 */

/*$obDoctors = $obService->getDoctors();
$obDoctors->makeData();
$arResult['DOCTORS'] = $obDoctors->getList();*/




$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PICTURE", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "DATE_ACTIVE_FROM", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>IntVal(5), "ACTIVE_DATE"=>"Y","PROPERTY_DIRECTION"=>$arResult['PROPERTIES']["DIRECTIONS"]["VALUE"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){
    $arDoctor=array();
    $arFields = $ob->GetFields();
    // print_r($arFields);
    $arProps = $ob->GetProperties();
    //print_r($arProps);POSITION
    $arDoctor["NAME"]=$arFields["NAME"];
    $arDoctor["POSITION"]=$arProps["POSITION"]["~VALUE"]["TEXT"];
    $arDoctor["URL"]=$arFields["DETAIL_PAGE_URL"];
    if($arFields["PREVIEW_PICTURE"]){
        $arDoctor["IMG"]=CFile::GetPath($arFields["PREVIEW_PICTURE"]);
    }elseif($arFields["DETAIL_PICTURE"]){
        $arDoctor["IMG"]=CFile::GetPath($arFields["DETAIL_PICTURE"]);
    }else{
        $arDoctor["IMG"]="/no-photo.jpg";
    }
    $arResult['DOCTOR'][]=$arDoctor;
}

?>

