<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "ММЦ ОН КЛИНИК: стоимость услуг в медицинском центре.");
$APPLICATION->SetPageProperty("title", "Стоимость услуг в медицинском центре ОН КЛИНИК");

use Bitrix\Main\Application,
    MWI\Direction,
    MWI\Service;

$APPLICATION->SetTitle("Services");
?>

    <section class="costsection">
        <div class="container">
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
            $isAjaxFilter = $getParams->getRaw('ajax_filter') == 'Y';
            ?>

            <div id="services-wrap">
                <?php
                if ($isAjaxFilter) {
                    $APPLICATION->RestartBuffer();
                }
                ?>
                <div class="costsection-filter">
                    <?php
                    $APPLICATION->IncludeComponent(
                        'mwi:services.filter',
                        '',
                        array(
                            'FILTER_NAME_DIRECTIONS' => 'arDirectionsFilter',
                            'FILTER_NAME_SERVICES' => 'arServicesFilter',
                            'CACHE_TYPE' => 'N',
                        )
                    );
                    ?>
                </div>

                <?php
                if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }
                ?>
                    <div class="costsection-list1">
                        <div class="costsection-item costsection-item-1" id="directions">
                            
						
							<?php
                            $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"directions", 
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => Direction::getIBlockId(),
		"NEWS_COUNT" => "9",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"PAGER_TEMPLATE" => "direction",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "DETAIL_PAGE_URL",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
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
		"FILTER_NAME" => "arDirectionsFilter",
		"COMPONENT_TEMPLATE" => "directions",
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
                        <div class="costsection-item costsection-item-2" id="services">
                            <?php
                            $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"services", 
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => Service::getIBlockId(),
		"NEWS_COUNT" => "30",
		"PAGER_TEMPLATE" => "services",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "DETAIL_PAGE_URL",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
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
		"FILTER_NAME" => "arServicesFilter",
		"COMPONENT_TEMPLATE" => "services",
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
					
					
					<div class="administration-btn-wrap">
						<span class="btn2 load_more_service" data-url="/actions/?PAGEN_1=2&ajax=Y">Показать ещё</span>
						<input id="direction_page" value="2" type="hidden">
						<input id="services_page" value="2" type="hidden">
						<input id="direction_all" value="<?=ceil(count($arDirectionsFilter['ID']) / 10)?>" type="hidden">
						<input id="services_all" value="<?=ceil(count($arServicesFilter['ID']) / 30)?>" type="hidden">
						<input id="arDirectionsFilter" value='<?=serialize($arDirectionsFilter)?>' type="hidden">
						<input id="arServicesFilter" value='<?=serialize($arServicesFilter)?>' type="hidden">
					</div>
					
					
                <?php
                if ($isAjax || $isAjaxFilter) {
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