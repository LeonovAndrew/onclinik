<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "ММЦ ОН КЛИНИК: кредит на лечение и обследование. Где взять кредит или рассрочку в Москве на выгодных условиях.");
$APPLICATION->SetPageProperty("title", "Лечение в кредит или рассрочку");

use MWI\Bank;

$APPLICATION->SetTitle("Лечение в кредит");
?>

<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "credit",
    array(
        "IBLOCK_TYPE" => Bank::getIBlockType(),
        "IBLOCK_ID" => Bank::getIBlockId(),
        "COMPONENT_TEMPLATE" => "credit",
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "STRICT_SECTION_CHECK" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_TITLE" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_ELEMENT_CHAIN" => "Y",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/payment/credit/",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "detail" => "#ELEMENT_CODE#/",
        ),
        "LIST_FIELD_CODE" => array(
            "ID",
            "NAME",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
        ),
        "LIST_PROPERTY_CODE" => array(

        ),
        "FIELD_CODE" => array(
            "ID",
            "NAME",
            "DETAIL_TEXT",
            "DETAIL_PICTURE",
        ),
        "PROPERTY_CODE" => array(
            "TITLE",
        ),
        "NEWS_COUNT" => 20,
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TEMPLATE" => 'bottom',
        "DISPLAY_TOP_PAGER" => "N",
        "PAGER_TEMPLATE_TOP" => 'arrows',
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
    ),
    false
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>