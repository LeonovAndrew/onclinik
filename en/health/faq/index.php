<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Loader,
    Bitrix\Main\Application,
    MWI\FAQ;

$APPLICATION->SetTitle("FAQ");
?>

<section class="faq">
    <div class="container">
        <div class="faq-container">
            <div class="section-wrap1">
                <nav class="section-nav">
                    <h2><?php $APPLICATION->ShowTitle('menu_title');?></h2>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "left",
                        array(
                            "COMPONENT_TEMPLATE" => "left",
                            "ROOT_MENU_TYPE" => "left",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => "",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                        )
                    )
                    ?>
                </nav>
                <div class="menu-btn"></div>
            </div>
            <div class="faq-wrap2">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>
                <h1><?php $APPLICATION->ShowTitle();?></h1>
                <?php
                $request = Application::getInstance()->getContext()->getRequest();
                $getParams = $request->getQueryList();
                $isAjax = $getParams->getRaw('ajax') == 'Y';
                ?>

                <?php
                $APPLICATION->IncludeComponent (
                    "mwi:catalog.filter",
                    "faq",
                    Array(
                        "IBLOCK_TYPE" => FAQ::getIBlockType(),
                        "IBLOCK_ID" => FAQ::getIBlockId(),
                        "FILTER_NAME" => "arFaqFilter",
                        "FIELD_CODE" => array(
                            "SECTION_ID"
                        ),
                        "PROPERTY_CODE" => array(

                        ),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "Y",
                        "SAVE_IN_SESSION" => "N",
                    ),
                    false
                );
                ?>
                <div id="faq" class="faq-list-wrap">
                    <h3>Ответы на частозадаваемые вопросы:</h3>
                    <?php
                    if ($isAjax) {
                        $APPLICATION->RestartBuffer();
                    }

                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "faq",
                        array(
                            "IBLOCK_TYPE" => FAQ::getIBlockType(),
                            "IBLOCK_ID" => FAQ::getIBlockId(),
                            "NEWS_COUNT" => 1,
                            "SORT_BY1" => 'SORT',
                            "SORT_ORDER1" => 'ASC',
                            "FIELD_CODE" => array(
                                'ID',
                                'NAME',
                                'PREVIEW_TEXT',
                                'DETAIL_TEXT',
                            ),
                            "PROPERTY_CODE" => array(

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
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "PAGER_TEMPLATE" => 'show_more',
                            "FILTER_NAME" => "arFaqFilter",
                        ),
                        false
                    );
                    ?>

                    <?php
                    if ($isAjax) {
                        die();
                    }
                    ?>
                </div>

                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs_mobile.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>
            </div>
        </div>
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

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>