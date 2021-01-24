<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Main');

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
                    'MENU_CACHE_TYPE' => 'A',
                    'MENU_CACHE_TIME' => '3600',
                    'MENU_CACHE_USE_GROUPS' => 'Y',
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
                    "IBLOCK_TYPE" => BannerMain::getIBlockType(),
                    "IBLOCK_ID" => BannerMain::getIBlockId(),
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