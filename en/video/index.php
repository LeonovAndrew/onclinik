<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Video");

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Page\Asset as Asset,
    \Bitrix\Main\Application as Application,
    MWI\Video;

$APPLICATION->SetTitle("Video");

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

            <h1><?php $APPLICATION->ShowTitle(); ?></h1>
            <?php
            $request = Application::getInstance()->getContext()->getRequest();
            $getParams = $request->getQueryList();
            $isAjax = $getParams->getRaw('ajax') == 'Y';
            $isAjaxFilter = $getParams->getRaw('ajax_filter') == 'Y';
            ?>
            <div id="videos-wrap">
                <?php
                if ($isAjaxFilter) {
                    $APPLICATION->RestartBuffer();
                }

                $APPLICATION->IncludeComponent(
                    'mwi:videos.filter',
                    '',
                    array(
                        'FILTER_NAME' => 'arVideosFilter',
                    )
                );
                ?>


                <?php
                if ($isAjax) {
                    $APPLICATION->RestartBuffer();
                }

                $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"videos", 
	array(
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => Video::getIBlockId(),
		"NEWS_COUNT" => "12",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "DETAIL_PICTURE",
			3 => "DETAIL_PAGE_URL",
			4 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "LINK",
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
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"FILTER_NAME" => "arVideosFilter",
		"PAGER_TEMPLATE" => "show_more_fancy",
		"PAGER_BOTTOM_TEMPLATE" => "bottom",
		"COMPONENT_TEMPLATE" => "videos",
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
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
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