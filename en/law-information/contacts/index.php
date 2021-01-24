<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Application;

$APPLICATION->SetTitle("Контактная информация");

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$isAjax = $getParams->getRaw('ajax') == 'Y';
?>

    <section class="contact1">
        <div class="container">
            <div class="contact1-container">
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
                <div class="contact1-wrap2">
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
                    <div class="contact1-title1">
                        <h2><?php $APPLICATION->ShowTitle();?></h2>
                        <a href="<?php echo getMessage('clinics_link');?>"><?php echo getMessage('clinics_contacts');?></a>
                    </div>
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.detail",
                        'contacts',
                        array(
                            "IBLOCK_TYPE" => 'contacts_info',
                            "IBLOCK_ID" => '19',
                            "ELEMENT_ID" => '67',
                            "FIELD_CODE" => array(
                                "NAME",
                            ),
                            "PROPERTY_CODE" => array(
                                "ADDRESS",
                                "PHONES",
                                "WORKING_HOURS",
                                "EMAILS",
                                "MAP",
                            ),
                            "SET_TITLE" => "N",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_CANONICAL_URL" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_STATUS_404" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_ELEMENT_CHAIN" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "3600",
                            "CACHE_GROUPS" => "Y",
                            "MAP_ID" => 'map1',
                        )
                    );
                    ?>

                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "department_contacts",
                        array(
                            "IBLOCK_TYPE" => "contacts_info",
                            "IBLOCK_ID" => "20",
                            "PARENT_SECTION" => "8",
                            "NEWS_COUNT" => "3",
                            "SORT_BY1" => "SORT",
                            "SORT_ORDER1" => "ASC",
                            "SORT_BY2" => "ACTIVE_FROM",
                            "SORT_ORDER2" => "DESC",
                            "FIELD_CODE" => array(
                                0 => "NAME",
                                1 => "",
                            ),
                            "PROPERTY_CODE" => array(
                                0 => "FULL_NAME",
                                1 => "POST",
                                2 => "PHONE",
                                3 => "PHONE_ADDITIONAL",
                                4 => "EMAIL",
                                5 => "",
                            ),
                            "SET_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_STATUS_404" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "CACHE_TYPE" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "Y",
                            "CACHE_GROUPS" => "Y",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "PAGER_TEMPLATE" => "show_more_fancy",
                            "FILTER_NAME" => "",
                            "IS_AJAX" => $isAjax,
                            "COMPONENT_TEMPLATE" => "department_contacts",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_META_DESCRIPTION" => "Y",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "PARENT_SECTION_CODE" => "",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "STRICT_SECTION_CHECK" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
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