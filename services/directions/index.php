<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Loader,
    MWI\Direction;
?>
<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "directions",
    array(
        "IBLOCK_TYPE" => Direction::getIBlockType(),
        "IBLOCK_ID" => Direction::getIBlockId(),
        "COMPONENT_TEMPLATE" => "directions",
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
        "SEF_FOLDER" => "/",
        "SEF_URL_TEMPLATES" => array(
            "news" => "#ELEMENT_CODE#/",
            "detail" => "#ELEMENT_CODE#/price/",
        ),
        "FIELD_CODE" => array(
            "ID",
            "NAME",
            "DETAIL_TEXT",
        ),
        "PROPERTY_CODE" => array(
            "PROCESS_TEXT",
        ),
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TEMPLATE" => 'bottom',
        "DISPLAY_TOP_PAGER" => "Y",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_STATUS_404" => "Y",
        "SHOW_404" => "Y",
    ),
    false
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>