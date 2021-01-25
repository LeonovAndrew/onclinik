<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);

use \Bitrix\Main\Application as Application,
    MWI\Program,
    MWI\Stock;
?>

<section class="programs">
	<div class="container">
		<div class="programs-container">
			<div class="programs-wrap2">
				<?php
				$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
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
                <div class="section-wrap1 before_stale">
                    <nav class="section-nav">
                        <!--<h2><?php /*$APPLICATION->ShowTitle('patient_info_menu_title');*/?></h2>-->
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "right",
                            array(
                                "COMPONENT_TEMPLATE" => "left",
                                "ROOT_MENU_TYPE" => "patient_info",
                                "MENU_CACHE_TYPE" => "N",
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
                        <!--<ul class="service1-list2">
                <?/*foreach ($arResult["ANCHOR_MENU"] as $menus):*/?>
                    <?/*if($menus["LINK"]!="#start"):*/?>
                        <li>
                            <a href="<?/*=$menus["LINK"]*/?>"><?/*=$menus["TEXT"]*/?></a>
                        </li>
                    <?/*endif;*/?>
                <?/*endforeach;*/?>
            </ul>-->
                    </nav>
                    <div class="menu-btn"></div>
                </div>
                <h1><?php $APPLICATION->ShowTitle(false);?></h1>
                <?php
                $APPLICATION->IncludeFile(
                    SITE_DIR . "/include/programs/preview_text.php",
                    array(),
                    array(
                        "MODE" => "html",
                        "NAME" => "Текст анонса",
                    )
                );
                ?>

                <?php
                $request = Application::getInstance()->getContext()->getRequest();
                $getParams = $request->getQueryList();
                $isAjax = $getParams->getRaw('ajax') == 'Y';
                $isAjaxFilter = $getParams->getRaw('ajax_filter') == 'Y';
                ?>
                <div id="programs-wrap">
                    <?php
                    if ($isAjaxFilter) {
                        $APPLICATION->RestartBuffer();
                    }

                    $APPLICATION->IncludeComponent(
                        'mwi:programs.filter',
                        '',
                        array(
                            'FILTER_NAME' => 'arProgramsFilter',
                            'CACHE_TYPE' => 'N',
                        )
                    );
                    ?>
                    <div class="programs-tabs" id="programs">
                        <?php
                        if ($isAjax) {
                            $APPLICATION->RestartBuffer();
                        }

                        $APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "programs_list",
                            array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                                "SORT_BY1" => $arParams["SORT_BY1"],
                                "SORT_ORDER1" => $arParams["SORT_ORDER1"],
                                "SORT_BY2" => $arParams["SORT_BY2"],
                                "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                                "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                                "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                                "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                                "SET_TITLE" => $arParams["SET_TITLE"],
                                "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                                "MESSAGE_404" => $arParams["MESSAGE_404"],
                                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                                "SHOW_404" => $arParams["SHOW_404"],
                                "FILE_404" => $arParams["FILE_404"],
                                "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                                "PAGER_TEMPLATE_TOP" => $arParams['PAGER_TEMPLATE_TOP'],
                                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                                "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                                "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                                "DISPLAY_NAME" => "Y",
                                "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                                "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                                "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                                "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                                "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                                "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                                "FILTER_NAME" => 'arProgramsFilter',
                                "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                                "CHECK_DATES" => $arParams["CHECK_DATES"],
                            ),
                            $component
                        );

                        if ($isAjax) {
                            die();
                        }
                        ?>
                    </div>

                    <?php
                    if ($isAjaxFilter) {
                        die();
                    }
                    ?>

                    <?php
                    $APPLICATION->IncludeFile(
                        SITE_DIR . "/include/programs/bottom_text.php",
                        array(

                        ),
                        array(
                            "MODE" => "html",
                            "NAME" => "Текст",
                        )
                    );
                    ?>
                </div>
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
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

                <?php $APPLICATION->showViewContent('stocks_mobile');?>
			</div>
            <div class="programs-wrap1">
                <?php
                $obProgramsList = Program::getList();
                $obStocksList = $obProgramsList->getStocks();
                if (!$obStocksList->isEmpty()) {
                    $GLOBALS['arStocksFilter'] = array(
                        'ID' => $obStocksList->getIds(),
                    );

                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "stocks",
                        array(
                            "IBLOCK_TYPE" => Stock::getIBlockType(),
                            "IBLOCK_ID" => Stock::getIBlockId(),
                            "NEWS_COUNT" => 100,
                            "SORT_BY1" => 'SORT',
                            "SORT_ORDER1" => 'ASC',
                            "FIELD_CODE" => array(
                                'ID',
                                'NAME',
                                'DATE_ACTIVE_TO',
                                'PREVIEW_TEXT',
                                'PREVIEW_PICTURE',
                            ),
                            "PROPERTY_CODE" => array(
                                'AMOUNT',
                                'PERCENTAGE',
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
                            "FILTER_NAME" => 'arStocksFilter',
                        ),
                        $component
                    );
                }
                ?>
                <div class="service1-info new_servis">
                    <!--<h3><?php //$APPLICATION->ShowTitle('menu_title');?></h3>-->
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "left",
                        array(
                            "COMPONENT_TEMPLATE" => "left",
                            "ROOT_MENU_TYPE" => "patient_info",
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
                    );
                    ?>
                </div>
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