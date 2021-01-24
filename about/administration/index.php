<?php

use MWI\Personal;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Администрация. ММЦ ОН КЛИНИК осуществляет прием без выходных и праздников с 9 утра до 9 вечера в 4 филиалах: Цветной бульвар, Таганская, Арбат, Трехгорный вал");
$APPLICATION->SetPageProperty("title", "Администрация международного медицинского центра ОН КЛИНИК");

$APPLICATION->SetTitle("Администрация");
?>

<?php
$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"administration", 
	array(
		"IBLOCK_TYPE" => "stocks",
		"IBLOCK_ID" => Personal::getIBlockId(),
		"COMPONENT_TEMPLATE" => "administration",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"STRICT_SECTION_CHECK" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "clinics",
			2 => "",
		),
		"FIELD_CODE" => "",
		"PROPERTY_CODE" => array(
			0 => "position",
			1 => "clinics",
			2 => "experience",
			3 => "price",
			4 => "services",
			5 => "specialization",
			6 => "certificates",
			7 => "education",
		),
		"NEWS_COUNT" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TEMPLATE" => "show_more",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "administration",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "CLINICS",
			2 => "",
		),
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"USE_PERMISSIONS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OTHER_NEWS_COUNT" => "",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE_TOP" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"FILE_404" => "",
		"SEF_URL_TEMPLATES" => array(
			"news" => "about/administration/",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>