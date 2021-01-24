<?php
if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'Y') ||
    (isset ($_REQUEST['ajax_filter']) && $_REQUEST['ajax_filter'] == 'Y')) {
    require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
} else {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
}

use Bitrix\Main\Loader,
    Bitrix\Main\Application,
    MWI\Review,
    MWI\Device;

Loader::IncludeModule('iblock');

$APPLICATION->SetTitle("Reviews");
?>

    <section class="reviews">
        <div class="container">
            <div class="reviews-container">
                <div class="section-wrap1">
                    <nav class="section-nav">
                        <h2><?php $APPLICATION->ShowTitle('menu_title'); ?></h2>
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
                        );
                        ?>
                    </nav>
                    <div class="menu-btn"></div>
                </div>
                <div class="reviews-wrap2">
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
                    <div id="reviews-wrap">
                        <?php
                        if ($isAjaxFilter) {
                            $APPLICATION->RestartBuffer();
                        }
                        ?>
                        <form action="#" class="reviews-filter">
                            <?php
                            $filterRes = $APPLICATION->IncludeComponent(
                                'mwi:reviews.filter',
                                '',
                                array(
                                    'FILTER_NAME' => 'arReviewsFilter',
                                    'CACHE_TYPE' => 'N',
                                )
                            );
                            ?>
                        </form>

                        <div id="reviews">
                            <?php
                            if ($isAjax) {
                                $APPLICATION->RestartBuffer();
                            }

                            $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "reviews",
                                array(
                                    "IBLOCK_TYPE" => Review::getIBlockType(),
                                    "IBLOCK_ID" => Review::getIBlockId(),
                                    "NEWS_COUNT" => $filterRes['displayed']['value'] ? $filterRes['displayed']['value'] : Review::getDisplayed()['value'],
                                    "SORT_BY1" => 'SORT',
                                    "SORT_ORDER1" => 'ASC',
                                    "FIELD_CODE" => array(
                                        'ID',
                                        'NAME',
                                        'DETAIL_TEXT',
                                        'DATE_ACTIVE_FROM',
                                    ),
                                    "PROPERTY_CODE" => array(
                                        'PATIENT_NAME',
                                        'DOCTOR',
                                        'CLINIC',
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
                                    "FILTER_NAME" => 'arReviewsFilter',
                                    "PAGER_TEMPLATE" => 'show_more-reviews',
                                    "PAGER_BOTTOM_TEMPLATE" => "bottom",
                                ),
                                false
                            );

                            $arDisplayed = array(
                                'items' => Review::DISPLAYED,
                                'current_index' => $filterRes['displayed']['index'],
                            );
                            ?>

                            <div class="reviews-container-btn">
                                <div class="reviews-radio-wrap1">
                                    <?php
                                    $device = Device::isMobile() ? 'mobile' : 'desktop';
                                    foreach ($arDisplayed['items'] as $index => $arItem) {
                                        ?>
                                        <label>
                                            <input <?php echo $arDisplayed['current_index'] == $index ? 'checked' : ''; ?>
                                                type="radio" name="quantity" value="<?php echo $index; ?>">
                                            <span><?php echo $arItem['desktop']; ?> <span><?php echo $arItem['mobile']; ?></span> <i><?php echo getSuffix($arItem[$device], array('отзыв', 'отзыва', 'отзывов')); ?></i></span>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                $APPLICATION->showViewContent('pagination');
                                ?>
                            </div>
                            <?php
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
                    </div>
                    <?php
                    $APPLICATION->IncludeComponent(
                        'mwi:review.form',
                        '',
                        array(
                            'IBLOCK_ID' => Review::getIBlockId(),
                            'EVENT_NAME' => 'REVIEW_FORM',
                            'SUCCESS_MSG' => 'Ваш отзыв успешно отправлен!',
                            'CLINIC_ID' => htmlspecialchars($getParams['reviewClinicId']),
                        )
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