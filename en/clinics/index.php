<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "ММЦ ОН КЛИНИК: адреса клиник в Москве. 4 медицинских центра: Цветной бульвар, Таганская, Арбат, Трехгорный вал (1905 года).");
$APPLICATION->SetPageProperty("title", "Адреса медицинских центров ОН КЛИНИК на Таганке, Цветном бульваре, Арбате и Трехгорном Валу (М 1905 года)");
$APPLICATION->SetTitle("АДРЕСА КЛИНИК");

use MWI\Clinic;
?>
 
<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "clinics",
    array(
        "IBLOCK_TYPE" => Clinic::getIBlockType(),
        "IBLOCK_ID" => Clinic::getIBlockId(),
        "COMPONENT_TEMPLATE" => "clinics",
        "CACHE_TYPE" => "Y",
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
        "SEF_FOLDER" => "/en/",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "detail" => "#ELEMENT_CODE#/",
        ),
        "FIELD_CODE" => array(
            "ID",
            "NAME",
            "PREVIEW_PICTURE",
        ),
        "PROPERTY_CODE" => array(
            "ADDRESS",
            "METRO",
            "PHONE",
            "WORK_TIME",
        ),
        "LIST_PROPERTY_CODE" => array(
            "CITY",
            "TYPE",
        ),
        "NEWS_COUNT" => 100,
        "PAGER_SHOW_ALWAYS" => "N",
        "DISPLAY_TOP_PAGER" => "Y",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_STATUS_404" => "Y",
        "SHOW_404" => "Y",
        "MESSAGE_404" => "",
        "SEF_URL_TEMPLATES" => array(
            "news" => "clinics/",
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