<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Международный медицинский центр ОН КЛИНИК - официальный сайт компании. Более 26 лет мы помогаем людям, большой выбор врачей, стационар, собственная лаборатория и новейшее оборудование. Все клиники находятся рядом с метро в ЦАО г. Москвы, работаем без выходных");
$APPLICATION->SetPageProperty("title", "Медицинский центр ОН КЛИНИК - сеть многопрофильных клиник. г.Москва");
$APPLICATION->SetTitle("Главная");

use MWI\BannerMain,
    MWI\Advantage;
?>

<section class="banner">
    <div class="banner-container">
        <div class="banner-wrap1">
            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:menu',
                'main_banner',
                array(
                    'COMPONENT_TEMPLATE' => 'main_banner',
                    'ROOT_MENU_TYPE' => 'main_banner',
                    'MENU_CACHE_TYPE' => 'Y',
                    'MENU_CACHE_TIME' => '3600',
                    'MENU_CACHE_USE_GROUPS' => 'N',
                    'MENU_CACHE_GET_VARS' => '',
                    'MAX_LEVEL' => '1',
                    'CHILD_MENU_TYPE' => '',
                    'USE_EXT' => 'Y',
                    'DELAY' => 'N',
                    'ALLOW_MULTI_SELECT' => 'N',
                )
            );
            ?>
        </div>
        <div class="banner-wrap2">
            <?php
            $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"banner_main", 
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => BannerMain::getIBlockId(),
		"NEWS_COUNT" => "10",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "image",
			2 => "",
		),
		"SET_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"FILTER_NAME" => "",
		"COMPONENT_TEMPLATE" => "banner_main",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "Y/m/d",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);
            ?>
        </div>
    </div>
</section>
<section class="services1">
    <div class="container">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "advantages",
            array(
                "IBLOCK_TYPE" => Advantage::getIBlockType(),
                "IBLOCK_ID" => Advantage::getIBlockId(),
                "NEWS_COUNT" => 6,
                "SORT_BY1" => 'SORT',
                "SORT_ORDER1" => 'ASC',
                "FIELD_CODE" => array(
                    'ID',
                    'NAME',
                    'PREVIEW_TEXT',
                ),
                "PROPERTY_CODE" => array(
                    'image',
                ),
                "SET_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_STATUS_404" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600000",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "FILTER_NAME" => '',
            ),
            false
        );
        ?>
    </div>
</section>

<?php
$APPLICATION->IncludeFile(
    SITE_DIR . "/include/map.php",
    array(),
    array(
        "MODE" => "html",
        "NAME" => "Карта клиник",
    )
);
?>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>