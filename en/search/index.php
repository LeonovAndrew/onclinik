<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Page\Asset as Asset,
    \Bitrix\Main\Application as Application,
    \Bitrix\Main\Web\Uri,
    MWI\Clinic,
    MWI\Direction,
    MWI\DepartmentsTable,
    MWI\VideoTable,
    MWI\Service;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/searchpage.js');

Loader::IncludeModule('iblock');
Loader::IncludeModule('highloadblock');
Loader::IncludeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$searchQuery = htmlspecialchars($getParams->getRaw('search'));

$APPLICATION->SetTitle("Результаты поиска");
?>
    <section class="search">
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

            <?php $APPLICATION->ShowTitle(); ?>

            <?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"search_m", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEFAULT_SORT" => "date",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILTER_NAME" => "",
		"NO_WORD_LOGIC" => "N",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGE_RESULT_COUNT" => "50",
		"RESTART" => "Y",
		"SHOW_WHEN" => "N",
		"SHOW_WHERE" => "Y",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"USE_TITLE_RANK" => "Y",
		"arrFILTER" => array(
			0 => "main",
			1 => "iblock_catalog",
			2 => "iblock_content",
			3 => "iblock_health",
			4 => "iblock_personal",
			5 => "iblock_clinics",
			6 => "iblock_documents",
		),
		"arrWHERE" => array(
		),
		"COMPONENT_TEMPLATE" => "search_m",
		"arrFILTER_main" => array(
		),
		"arrFILTER_iblock_catalog" => array(
			0 => "all",
		),
		"arrFILTER_iblock_content" => array(
			0 => "all",
		),
		"arrFILTER_iblock_health" => array(
			0 => "all",
		),
		"arrFILTER_iblock_personal" => array(
			0 => "all",
		),
		"arrFILTER_iblock_clinics" => array(
			0 => "all",
		),
		"arrFILTER_iblock_documents" => array(
			0 => "all",
		)
	),
	false
);?>


			<!--
            <div class="search-list search-list1">
            </div> 
			
            <div class="search-list search-list2">
            </div>
                       <div class="search-btn-wrap">-->
            <!--                <span class="btn2 search-btn">Показать еще</span>-->
            <!--            </div>-->

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
            <div class="breadcrumbs-wrap breadcrumbs-wrap-mobile">
                <ul class="breadcrumbs-list">
                    <li>
                        <a href="#">
                            <img src="img/home-icon.svg" alt="">
                        </a>
                    </li>
                    <li>Результаты поиска</li>
                </ul>
            </div>
        </div>
    </section>


<?php
//print_r(VideoTable::getTableName());
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