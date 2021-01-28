<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Loader,
    MWI\Service;
use MWI\Direction,
    MWI\ServiceList,
    MWI\ServiceOffer,
    MWI\Stock,
    MWI\StockList,
    MWI\Personal,
    MWI\Disease,
    MWI\Symptom,
    MWI\Question,
    MWI\Recommendation,
    MWI\Review;

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
?>

<section class="doctors">
    <div class="container">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "",
                "PATH" => "/en/include/tools/breadcrumbs.php"
            ),
            false,
            array(
                'HIDE_ICONS' => 'Y'
            )
        );

        /*******************************/
        $sectionID=$arResult["VARIABLES"]["SECTION_ID"];
        $iblockId=$arParams["IBLOCK_ID"];
        $razdelId=false;
        $arSelect=array("UF_RAZDEL","UF_PAGE");
        $arFilter = array('IBLOCK_ID' => $iblockId, 'ID' => $sectionID); // выберет потомков без учета активности
        $rsSect = CIBlockSection::GetList(array(),$arFilter,false,$arSelect);
        if ($arSect = $rsSect->GetNext())
        {
            $razdelId=$arSect["UF_RAZDEL"];
            $pageId=$arSect["UF_PAGE"];
            $sectionDescr=$arSect["DESCRIPTION"];
            $sectionode="/doctors/".$arSect["CODE"]."/";
        }


        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($iblockId,$sectionID);
        $IPROPERTY  = $ipropValues->getValues();

        /*echo "<pre>";
            print_r($IPROPERTY);
        echo "</pre>";*/

        if(!empty($IPROPERTY["ELEMENT_META_TITLE"])){
            $APPLICATION->SetPageProperty('title', $IPROPERTY["ELEMENT_META_TITLE"]);
        }

        $APPLICATION->SetTitle($arSect["NAME"]);



        $APPLICATION->AddChainItem($arSect["NAME"], $sectionode);

        if(!empty($pageId)){
            $obService = new Service($pageId);
            $obService->makeData();
            $obServiceList = new ServiceList();
            $obServiceList->add($obService);
            $obOffers = $obService->getOffers();
            $arPrice = $obOffers->getMinimumPrice();
            $obService->minimumPrice = $arPrice['price'];
            $obService->minimumDiscountPrice = $arPrice['discount_price'];
            $arResult['OFFERS'] = $obOffers->getList();



            if (!$obOffers->isEmpty()) {
                $arAnchorMenu[] = array(
                    'TEXT' => "Цены",
                    'LINK' => '#price',
                    'DEPTH_LEVEL' => 100,
                    'IS_PARENT' => false,
                );
            }



            /**
             * get doctors
             */
            $obDoctors = $obService->getDoctors();
            $obDoctors->makeData();
            $arResult['DOCTORS'] = $obDoctors->getList();

            $firstTab = true;
            $arResult['BOTTOM_TABS'] = array();
            /**
             * get diseases
             */
            $obDiseases = $obService->getDiseases(18);
            if (!$obDiseases->isEmpty()) {
                $arResult['BOTTOM_TABS']['DISEASES'] = array(
                    'NAME' => "Заболевания",
                    'ITEMS' => $obDiseases->getList(),
                    'SELECTED' => $firstTab,
                );
                $firstTab = false;

                $arAnchorMenu[] = array(
                    'TEXT' => 'Заболевания',
                    'LINK' => '#diseases',
                    'DEPTH_LEVEL' => $menuSort,
                    'IS_PARENT' => true,
                );
                $menuSort += 10;
            }

            /**
             * get symptoms
             */
            $obSymptoms = $obService->getSymptoms(18);
            if (!$obSymptoms->isEmpty()) {
                $arResult['BOTTOM_TABS']['SYMPTOMS'] = array(
                    'NAME' => "Симптомы",
                    'ITEMS' => $obSymptoms->getList(),
                    'SELECTED' => $firstTab,
                );
                $firstTab = false;

                $arAnchorMenu[] = array(
                    'TEXT' => 'Симптомы',
                    'LINK' => '#symptoms',
                    'DEPTH_LEVEL' => $menuSort,
                    'IS_PARENT' => true,
                );
                $menuSort += 10;
            }

            /**
             * get questions
             */
            $obQuestions = $obService->getQuestions(2);
            if (!$obQuestions->isEmpty()) {
                $arQuestions = $obQuestions->getList();
                foreach ($arQuestions as &$obQuestion) {
                    if (!empty($obQuestion->publicationDate)) {
                        $obQuestion->publicationDate = FormatDateFromDB($obQuestion->publicationDate, Question::DATE_SHORT);
                    }
                }
                $arResult['BOTTOM_TABS']['QUESTIONS'] = array(
                    'NAME' => "Вопросы-ответы",
                    'ITEMS' => $arQuestions,
                    'SELECTED' => $firstTab,
                );
                $firstTab = false;

                $arAnchorMenu[] = array(
                    'TEXT' => 'Вопросы',
                    'LINK' => '#questions',
                    'DEPTH_LEVEL' => $menuSort,
                    'IS_PARENT' => true,
                );
                $menuSort += 10;
            }

            /**
             * get recommendations
             */
            $obRecommendations = $obService->getRecommendations(2);
            if (!$obRecommendations->isEmpty()) {
                $arResult['BOTTOM_TABS']['RECOMMENDATIONS'] = array(
                    'NAME' => "Рекомендации врачей",
                    'ITEMS' => $obRecommendations->getList(),
                    'SELECTED' => $firstTab,
                );
                $firstTab = false;

                $arAnchorMenu[] = array(
                    'TEXT' => 'Рекомендации',
                    'LINK' => '#recommendations',
                    'DEPTH_LEVEL' => $menuSort,
                    'IS_PARENT' => true,
                );
                $menuSort += 10;
            }

            /**
             * get reviews
             */
            $obReviews = $obService->getReviews();
            if (!$obReviews->isEmpty()) {
                $arReviews = $obReviews->getList();
                foreach ($arReviews as &$obReview) {
                    if (!empty($obReview->publicationDate)) {
                        $obReview->publicationDate = FormatDateFromDB($obReview->publicationDate, Review::DATE_SHORT);
                    }
                }
                $arResult['BOTTOM_TABS']['REVIEWS'] = array(
                    'NAME' => "Отзывы",
                    'ITEMS' => $obReviews->getList(),
                    'SELECTED' => $firstTab,
                );
                $firstTab = false;

                $arAnchorMenu[] = array(
                    'TEXT' => 'Отзывы',
                    'LINK' => '#reviews',
                    'DEPTH_LEVEL' => $menuSort,
                    'IS_PARENT' => true,
                );
                $menuSort += 10;
            }

            /*$arAnchorMenu[] = array(
                'TEXT' => "В начало",
                'LINK' => '#start',
                'DEPTH_LEVEL' => 1000,
                'IS_PARENT' => false,
            );*/



            $stockList = $obServiceList->getStocks( $arResult['PROPERTIES']['DIRECTION']['VALUE'] );
            $arResult['STOCKS'] = $stockList->getList();

            if (!empty($arResult['DETAIL_PICTURE']['SRC'])) {
                $pic = CFile::ResizeImageGet($arResult['DETAIL_PICTURE'], array('width'=>600, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL);
                $arResult['DETAIL_PICTURE']['SRC'] = $pic['src'];
            }

            /**
             * add tags to cache
             */
            $arTags = array(
                'iblock_id_' . Stock::getIBlockId(),
                'iblock_id_' . Service::getIBlockId(),
                'iblock_id_' . ServiceOffer::getIBlockId(),
                'iblock_id_' . Personal::getIBlockId(),
                'iblock_id_' . Disease::getIBlockId(),
                'iblock_id_' . Symptom::getIBlockId(),
            );
            addTagsToComponentCache($this->__component, $arTags);

            $arResult['ANCHOR_MENU'] = $arAnchorMenu;
        }


        ?>


        <h1><?php $APPLICATION->ShowTitle(false);?></h1>
        <?php
        $request = Application::getInstance()->getContext()->getRequest();
        $getParams = $request->getQueryList();
        $isAjax = $getParams->getRaw('ajax') == 'Y';
        $isAjaxFilter = $getParams->getRaw('ajax_filter') == 'Y';




        if (!empty($arResult['OFFERS'])) {
            $priceSmall=array_shift($arResult['OFFERS']);
            $priceBig=end($arResult['OFFERS']);

            $priceSmall=priceFormat($priceSmall->discountPrice);
            $priceBig=priceFormat($priceBig->discountPrice);
        }
        ?>

        <div class="menu_list">
            <?$tabsI=0;?>
            <ul class="menu_list_ul">
                <?foreach ($arResult['ANCHOR_MENU'] as $menItem):?>
                    <li>
                        <a <?if($tabsI!=0):?>data-is-tab="1"<?endif;?> href="<?=$menItem["LINK"]?>">
                            <?=$menItem["TEXT"]?>
                            <?if($menItem["LINK"] == "#price"):?>
                                <?=$priceSmall?> ₽ - <?=$priceBig?> ₽
                            <?endif;?>
                            <?$tabsI++;?>
                        </a>
                    </li>
                <?endforeach;?>
            </ul>

        </div>



        <div id="doctors-wrap" data-razdel="<?=$razdelId?>">
            <?php
            if ($isAjaxFilter) {
                $APPLICATION->RestartBuffer();
            }

            $APPLICATION->IncludeComponent(
                'mwi:doctors.filter',
                '',
                array(
                    'FILTER_NAME' => 'arDoctorsFilter',
                    "DIRECTION_ID"=>$razdelId,
                    "SEC_DESCR"=>$sectionDescr,
                )
            );

            if ($isAjax) {
                $APPLICATION->RestartBuffer();
            }


            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => "5",
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
                    "SET_TITLE" => "N",
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
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
                    "FILTER_NAME" => 'arDoctorsFilter',
                    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                ),
                $component
            );

            if ($isAjax || $isAjaxFilter) {
                die();
            }
            ?>
        </div>



        <div class="service1-btn-block-wrap readmore">
            <?php
            if (!empty($arResult['OFFERS'])) {
                ?>
                <div class="cost1" id="price">
                    <h2>Стоимость</h2>
                    <ul class="cost1-list">
                        <?php
                        $i = 0;
                        foreach ($arResult['OFFERS'] as $obOffer) {
                            ?>
                            <li>
                                <i><?php echo $obOffer->name;?></i>
                                <?php
                                if ($obOffer->price != $obOffer->discountPrice) {
                                    ?>
                                    <b><?php echo priceFormat($obOffer->discountPrice);?> ₽</b>
                                    <span><?php echo priceFormat($obOffer->price);?> ₽</span>
                                    <?php
                                } else {
                                    ?>
                                    <b><?php echo priceFormat($obOffer->price);?> ₽</b>
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                            $i++;
                            if ( $i > 9 ){
                                break;
                            }
                        }
                        ?>
                    </ul>
                </div>
                <p class="price_info_text"><small><?php echo getMessage('PRICE_TEXT')?></small></p><br>
                <?php
            }
            ?>
        </div>

        <div class="service1-tabs">
            <ul class="tab_list service1-tab_list">
                <?php
                if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
                    ?>
                    <li>
                        <a<?php if ($arResult['BOTTOM_TABS']['DISEASES']['SELECTED']) {;?> class="active"<?php }?> href="#diseases"><?php echo $arResult['BOTTOM_TABS']['DISEASES']['NAME'];?></a>
                    </li>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['SYMPTOMS'])) {
                    ?>
                    <li>
                        <a<?php if ($arResult['BOTTOM_TABS']['SYMPTOMS']['SELECTED']) {;?> class="active"<?php }?> href="#symptoms"><?php echo $arResult['BOTTOM_TABS']['SYMPTOMS']['NAME'];?></a>
                    </li>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['QUESTIONS'])) {
                    ?>
                    <li>
                        <a<?php if ($arResult['BOTTOM_TABS']['QUESTIONS']['SELECTED']) {?> class="active"<?php }?> href="#questions"><?php echo $arResult['BOTTOM_TABS']['QUESTIONS']['NAME'];?></a>
                    </li>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])) {
                    ?>
                    <li>
                        <a<?php if ($arResult['BOTTOM_TABS']['RECOMMENDATIONS']['SELECTED']) {?> class="active"<?php }?> href="#recommendations"><?php echo $arResult['BOTTOM_TABS']['RECOMMENDATIONS']['NAME'];?></a>
                    </li>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['REVIEWS'])) {
                    ?>
                    <li>
                        <a<?php if ($arResult['BOTTOM_TABS']['REVIEWS']['SELECTED']) {?> class="active"<?php }?> href="#reviews"><?php echo $arResult['BOTTOM_TABS']['REVIEWS']['NAME'];?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>

            <div class="service1-tabs-wrap">
                <?php
                if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
                    ?>
                    <div<?php if (!$arResult['BOTTOM_TABS']['DISEASES']['SELECTED']) {?> style="display:none"<?php }?> class="service1-tab block_content" id="diseases">
                        <div class="service1-tab-wrap">
                            <?php
                            if (!empty($arResult['PROPERTIES']['DISEASES_TAB_TEXT']['~VALUE']['TEXT'])) {
                                ?>
                                <p><?php echo $arResult['PROPERTIES']['DISEASES_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                                <?php
                            }

                            $k = 0;
                            $pageSize = 6;
                            foreach ($arResult['BOTTOM_TABS']['DISEASES']['ITEMS'] as $obItem) {
                                if ($k == 0) {
                                    ?>
                                    <ul class="service1-tab-list">
                                    <?php
                                }
                                ?>
                                <li>
                                    <a href="<?php echo $obItem->url;?>"><?php echo $obItem->name;?></a>
                                </li>
                                <?php
                                $k++;
                                if  ($k == $pageSize) {
                                    $k = 0;
                                    ?>
                                    </ul>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            if ($k != 0) {
                                ?>
                                </ul>
                                <?php
                            }
                            ?>
                            <div class="service1-tab-link-wrap">
                                <?php
                                //TODO: scroll to tab
                                ?>
                                <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_DISEASES_LINK');?>"><?php echo getMessage('ND_DIRECTIONS_ALL_DISEASES');?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['SYMPTOMS'])) {
                    ?>
                    <div<?php if (!$arResult['BOTTOM_TABS']['SYMPTOMS']['SELECTED']) {?> style="display:none"<?php }?> class="service1-tab block_content" id="symptoms">
                        <div class="service1-tab-wrap">
                            <?php
                            if (!empty($arResult['PROPERTIES']['SYMPTOMS_TAB_TEXT']['~VALUE']['TEXT'])) {
                                ?>
                                <p><?php echo $arResult['PROPERTIES']['SYMPTOMS_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                                <?php
                            }

                            $k = 0;
                            $pageSize = 6;
                            foreach ($arResult['BOTTOM_TABS']['SYMPTOMS']['ITEMS'] as $obItem) {
                                if ($k == 0) {
                                    ?>
                                    <ul class="service1-tab-list">
                                    <?php
                                }
                                ?>
                                <li>
                                    <a href="<?php echo $obItem->url;?>"><?php echo $obItem->name;?></a>
                                </li>
                                <?php
                                $k++;
                                if  ($k == $pageSize) {
                                    $k = 0;
                                    ?>
                                    </ul>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            if ($k != 0) {
                                ?>
                                </ul>
                                <?php
                            }
                            ?>
                            <div class="service1-tab-link-wrap">
                                <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_SYMPTOMS_LINK');?>"><?php echo getMessage('ND_DIRECTIONS_ALL_SYMPTOMS');?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['QUESTIONS'])) {
                    ?>
                    <div<?php if (!$arResult['BOTTOM_TABS']['QUESTIONS']['SELECTED']) {?> style="display:none"<?php }?> class="service1-tab block_content" id="questions">
                        <?php
                        if (!empty($arResult['PROPERTIES']['QUESTIONS_TAB_TEXT']['~VALUE']['TEXT'])) {
                            ?>
                            <p><?php echo $arResult['PROPERTIES']['QUESTIONS_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                            <?php
                        }

                        foreach ($arResult['BOTTOM_TABS']['QUESTIONS']['ITEMS'] as $obItem) {
                            ?>
                            <div class="questions-item">
                                <h3>
                                    <i><?php echo $obItem->name;?></i>
                                    <b><?php echo $obItem->publicationDate;?></b>
                                </h3>
                                <span><?php echo $obItem->question;?></span>
                                <p><?php echo $obItem->answer;?></p>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="service1-tab-link-wrap">
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_QUESTIONS_LINK');?>"><?php echo getMessage('ND_DIRECTIONS_ALL_QUESTIONS');?></a>
                        </div>
                    </div>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])) {
                    ?>
                    <div<?php if (!$arResult['BOTTOM_TABS']['RECOMMENDATIONS']['SELECTED']) {?> style="display:none"<?php }?> class="service1-tab block_content" id="recommendations">
                        <?php
                        if (!empty($arResult['PROPERTIES']['RECOMMENDATIONS_TAB_TEXT']['~VALUE']['TEXT'])) {
                            ?>
                            <p><?php echo $arResult['PROPERTIES']['RECOMMENDATIONS_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                            <?php
                        }

                        foreach ($arResult['BOTTOM_TABS']['RECOMMENDATIONS']['ITEMS'] as $obItem) {
                            ?>
                            <div class="doctor_info">
                                <div class="doctor-info-title">
                                    <?if ( $obItem->doctor ):?>
                                        <span><a href="<?php echo $obItem->doctor->url;?>"><?php echo $obItem->doctor->name;?></a>, <?php echo $obItem->doctor->position;?></span>
                                    <?else:?>
                                        <span>ММЦ ОН КЛИНИК</span>
                                    <?endif;?>
                                </div>

                                <p><?php echo $obItem->text;?></p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }

                if (!empty($arResult['BOTTOM_TABS']['REVIEWS'])) {
                    ?>
                    <div<?php if (!$arResult['BOTTOM_TABS']['REVIEWS']['SELECTED']) {?> style="display:none"<?php }?> class="service1-tab block_content" id="reviews">
                        <?php
                        if (!empty($arResult['PROPERTIES']['REVIEWS_TAB_TEXT']['~VALUE']['TEXT'])) {
                            ?>
                            <p><?php echo $arResult['PROPERTIES']['REVIEWS_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                            <?php
                        }

                        foreach ($arResult['BOTTOM_TABS']['REVIEWS']['ITEMS'] as $obItem) {
                            ?>
                            <div class="review_tab">
                                <div class="top">
                                    <div class="name"><?php echo $obItem->patientName;?></div>

                                    <div class="date">
                                        <b><?php echo $obItem->publicationDate;?></b>
                                    </div>
                                </div>

                                <div class="text">
                                    <p><?php echo $obItem->text;?></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="service1-tab-link-wrap">
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_REVIEWS_LINK');?>"><?php echo getMessage('ND_DIRECTIONS_ALL_REVIEWS');?></a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "",
                "PATH" => "/en/include/tools/breadcrumbs_mobile.php"
            ),
            false,
            array(
                'HIDE_ICONS' => 'Y'
            )
        );
        ?>
    </div>
</section>
