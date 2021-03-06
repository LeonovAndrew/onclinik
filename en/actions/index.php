<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use MWI\Stock;
?>

<?php
$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"stocks", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => Stock::getIBlockId(),
		"NEWS_COUNT" => "2",
		"COMPONENT_TEMPLATE" => "stocks",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"STRICT_SECTION_CHECK" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/en/actions/",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DATE_ACTIVE_TO",
			5 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "CLINICS",
			2 => "AMOUNT",
			3 => "PERCENTAGE",
			4 => "CLIENTS_TYPE",
			5 => "",
		),
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "DATE_ACTIVE_TO",
		),
		"PROPERTY_CODE" => array(
			0 => "AMOUNT",
			1 => "PERCENTAGE",
		),
		"PAGER_TEMPLATE" => "show_more",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
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
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"FILE_404" => "",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
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