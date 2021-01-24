<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Врачи медицинского центра ОН КЛИНИК - в наших медцентрах работают квалифицированные доктора различных специальностей и профилей: врачи высшей категории, кандидаты медицинских наук и профессора.");
$APPLICATION->SetPageProperty("title", "Врачи в медицинском центре ОН КЛИНИК");
use MWI\Personal;
use Bitrix\Main\Page\Asset;

$APPLICATION->SetTitle("Врачи");
?>
<?php
$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"doctors", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => Personal::getIBlockId(),
		"COMPONENT_TEMPLATE" => "doctors",
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
			0 => "SORT",
			1 => "ACTIVE_FROM",
			2 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "POSITION",
			2 => "CLINICS",
			3 => "EXPERIENCE",
			4 => "PRICE",
			5 => "SERVICES",
			6 => "SPECIALIZATION",
			7 => "CERTIFICATES",
			8 => "EDUCATION",
			9 => "",
		),
		"FIELD_CODE" => "",
		"PROPERTY_CODE" => array(
			0 => "POSITION",
			1 => "CLINICS",
			2 => "EXPERIENCE",
			3 => "PRICE",
			4 => "SERVICES",
			5 => "SPECIALIZATION",
			6 => "CERTIFICATES",
			7 => "EDUCATION",
		),
		"NEWS_COUNT" => "15",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TEMPLATE" => "show_more",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"USE_FILTER" => "Y",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
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
		"FILTER_NAME" => "",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FILE_404" => "",
		"SEF_URL_TEMPLATES" => array(
			"news" => "doctors/",
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