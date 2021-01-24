<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader,
    Bitrix\Main\Application,
    Bitrix\Main\Web\Uri,
    Bitrix\Main\Data\Cache,
    MWI\Service;

Loader::IncludeModule('iblock');
Loader::IncludeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$searchQuery = htmlspecialchars($getParams->getRaw('searchQuery'));
$arNoSearchIblocks = Array();

if (!empty($searchQuery)) {
    $obSearch = new CSearch();
    $obSearch->Search(
        array(
            'QUERY' => $searchQuery,
            'SITE_ID' => SITE_ID,
            'MODULE_ID' => 'iblock',
//            'PARAM1' => Service::getIBlockType(),
//            'PARAM2' => Service::getIBlockId(),
//            'ITEM_ID' => count($arServicesId) == 1 ? reset($arServicesId) : $arServicesId,
        )
    );
    $obSearch->NavStart();
    $arServicesId = array();

    while ($arSearch = $obSearch->Fetch()) {
	
		
	
		if ( $arSearch['ITEM_ID'] ){
			$arServicesId[] = $arSearch['ITEM_ID'];
		}
    }

    $GLOBALS['arServicesFilter']['ID'] = $arServicesId;
}

if (isset($GLOBALS['arServicesFilter']['ID']) && empty($GLOBALS['arServicesFilter']['ID'])) {
    $GLOBALS['arServicesFilter']['ID'] = false;
}


//"PROPERTY_search_text"

$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PREVIEW_TEXT");
$arFilter = Array("ID" => $GLOBALS['arServicesFilter']['ID'], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");


	
$res = CIBlockElement::GetList(Array('ID' => $arServicesId), $arFilter, false, Array("nPageSize" => 50), $arSelect);
while ($ob = $res->GetNextElement()) {

	
    $arFields = $ob->GetFields();


	
	if ( $arFields['DETAIL_PAGE_URL'] ){
	
		if ( $arFields['PROPERTY_SEARCH_TEXT_VALUE'] ){
			$arFields['NAME'] .= ' (' . $arFields['PROPERTY_SEARCH_TEXT_VALUE'] . ')';
		}
		echo "<div class='search-item'>
                    <div class='search-item-link'>
                        <a href='".$arFields['DETAIL_PAGE_URL']."'>".$arFields['NAME']."</a>
                    </div>
                    <p>".$arFields['PREVIEW_TEXT']."</p>
                </div>";
	}

//    echo '<pre>' . print_r($arFields, true) . '</pre>';
}


//$APPLICATION->IncludeComponent(
//    "bitrix:news.list",
//    "services",
//    array(
//        "IBLOCK_TYPE" => "clinics",
////        "IBLOCK_ID" => Service::getIBlockId(),
//        "NEWS_COUNT" => 100,
//        "SORT_BY1" => 'SORT',
//        "SORT_ORDER1" => 'ASC',
//        "FIELD_CODE" => array(
//            'ID',
//            'NAME',
//            'DETAIL_PAGE_URL',
//        ),
//        "PROPERTY_CODE" => array(
//
//        ),
//        "SET_TITLE" => "N",
//        "SET_LAST_MODIFIED" => "N",
//        "SET_STATUS_404" => "N",
//        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
//        "ADD_SECTIONS_CHAIN" => "N",
//        "CACHE_TYPE" => "A",
//        "CACHE_TIME" => "3600000",
//        "CACHE_FILTER" => "Y",
//        "CACHE_GROUPS" => "Y",
//        "FILTER_NAME" => 'arServicesFilter',
//    ),
//    false
//);