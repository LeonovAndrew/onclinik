<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);


if (!empty($arResult['OFFERS'])) {
    $priceSmall=array_shift($arResult['OFFERS']);
    $priceBig=end($arResult['OFFERS']);

    $priceSmall=priceFormat($priceSmall->discountPrice);
    $priceBig=priceFormat($priceBig->discountPrice);
}
?>
<!--<pre>
    <?/*print_r($arResult);*/?>
</pre>-->
<div class="service1-text1" id="start" data-page="detail_servise">
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
	<?if ( strlen($arResult['PROPERTIES']['H1']['~VALUE']) > 1 ):?>
		<h1><?php echo $arResult['PROPERTIES']['H1']['~VALUE'];?></h1>
	<?endif;?>
    <div class="menu_list">
        <?$tabsI=0;?>
        <ul class="menu_list_ul">
            <?foreach ($arResult['ANCHOR_MENU'] as $menItem):?>
                <?if($menItem["LINK"]!="#start"):?>
                <li>
                    <a <?if($tabsI!=0):?>data-is-tab="1"<?endif;?> href="<?=$menItem["LINK"]?>">
                        <?=$menItem["TEXT"]?>
                        <?if($menItem["LINK"] == "#price"):?>
                            <?=$priceSmall?> ₽ - <?=$priceBig?> ₽
                        <?endif;?>
                        <?$tabsI++;?>
                    </a>
                </li>
                <?endif;?>
            <?endforeach;?>
        </ul>

    </div>
    <div class="service1-text1-wrap readmore">
        <?php
        if (!empty($arResult['DETAIL_PICTURE']['SRC'])) {
            ?>
            <img src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
            <?php
        }

        if (!empty($arResult['DETAIL_TEXT'])) {
            echo $arResult['~DETAIL_TEXT'];
        }
        ?>
    </div>
</div>

<?php
if (!empty($arResult['STOCKS'])) {
    ?>
    <div class="service1-action-slider service1-action-slider1">
        <div class="swiper-container swiper-container10">
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['STOCKS'] as $obStock) {
                    ?>
                    <div class="swiper-slide">
                        <div class="service1-action service1-action1 promo-action">
                            <div class="promo-title">
								<h3><?php echo $obStock->name;?></h3>
							</div>
							<?php
                            if (!empty($obStock->expireDateCounter)) {
                                ?>
                                <div class="promo-ends">
                                    <b><?php echo getMessage('before_expire'); ?></b>
                                    <div class="service1-action-timer-wrap">
                                        <span class="service1-action-timer clock<?php echo $obStock->id; ?>"
                                              data-date="<?php echo $obStock->expireDateCounter; ?>"
                                              data-id="<?php echo $obStock->id; ?>"></span>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="service1-action-img">
                                <?php
                                if (!empty($obStock->previewPicture)) {
                                    ?>
                                    <img src="<?php echo $obStock->previewPicture['SMALL_SRC']; ?>"
                                         alt="<?php echo $obStock->previewPicture['ALT']; ?>">
                                    <b><?php echo $obStock->amount; ?><?php echo $obStock->percentage ? '%' : 'Р'; ?></b>
                                    <?php
                                }
                                ?>
                                <div class="service1-action-text-btn-wrap">
                                    <a href="<?php echo $obStock->url; ?>"
                                       class="btn4"><?php echo getMessage('DISEASE_DETAILS'); ?></a>
                                </div>
                            </div>
                            <div class="service1-action-text">
                                
                                <?php
                                if (!empty($obStock->expireDate)) {
                                    ?>
                                    <b><?php echo getMessage('to') . ' ' . $obStock->expireDate; ?></b>
                                    <?php
                                }
                                ?>
                                <p><?php echo $obStock->previewText; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
        <div class="swiper-button-next swiper-button-next10 swiper-button-next-style2"></div>
        <div class="swiper-button-prev swiper-button-prev10 swiper-button-prev-style2"></div>
    </div>
    <?php
}
?>
<?if (!empty($arResult['OFFERS'])):?>
    <div class="service1-btn-block-wrap readmore">
        <?php
        if (!empty($arResult['OFFERS'])) {
            ?>
            <div class="cost1" id="price">
                <h2><?php echo getMessage('ND_DIRECTIONS_PRICE_TITLE');?></h2>
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
								<div>
									<b><?php echo priceFormat($obOffer->discountPrice);?> ₽</b>
									<span><?php echo priceFormat($obOffer->price);?> ₽</span>
                                </div>
								<?php
                            } else {
                                ?>
								<div class="no_discount">
									<b><?php echo priceFormat($obOffer->price);?> ₽</b>
                                </div>
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
<?endif;?>
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
<?
if (!empty($arResult['BOTTOM_TABS']['DISEASES'])
    || !empty($arResult['BOTTOM_TABS']['SYMPTOMS'])
    || !empty($arResult['BOTTOM_TABS']['QUESTIONS'])
    || !empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])
    || !empty($arResult['BOTTOM_TABS']['REVIEWS'])
):
?>
<div class="service1-tabs-slider service1-tabs-slider-services-style">
    <div class="swiper-container swiper-container9">
        <div class="swiper-wrapper">
            <?php
            if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['DISEASES']['NAME'];?></h3>
                        <?php
                        if (!empty($arResult['PROPERTIES']['DISEASES_TAB_TEXT']['~VALUE']['TEXT'])) {
                            ?>
                            <p><?php echo $arResult['PROPERTIES']['DISEASES_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                            <?php
                        }
                        ?>
                        <ul class="service1-tab-list">
                            <?php
                            foreach ($arResult['BOTTOM_TABS']['DISEASES']['ITEMS'] as $obItem) {
                                ?>
                                <li>
                                    <a href="<?php echo $obItem->url;?>"><?php echo $obItem->name;?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="service1-tab-link-wrap">
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_DISEASES_LINK');?>"><?php echo getMessage('ND_DIRECTIONS_ALL_DISEASES');?></a>
                        </div>
                    </div>
                </div>
                <?php
            }

            if (!empty($arResult['BOTTOM_TABS']['SYMPTOMS'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['SYMPTOMS']['NAME'];?></h3>
                        <?php
                        if (!empty($arResult['PROPERTIES']['SYMPTOMS_TAB_TEXT']['~VALUE']['TEXT'])) {
                            ?>
                            <p><?php echo $arResult['PROPERTIES']['SYMPTOMS_TAB_TEXT']['~VALUE']['TEXT'];?></p>
                            <?php
                        }
                        ?>
                        <ul class="service1-tab-list">
                            <?php
                            foreach ($arResult['BOTTOM_TABS']['SYMPTOMS']['ITEMS'] as $obItem) {
                                ?>
                                <li>
                                    <a href="<?php echo $obItem->url;?>"><?php echo $obItem->name;?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="service1-tab-link-wrap">
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_SYMPTOMS_LINK');?>"><?php echo getMessage('ND_DIRECTIONS_ALL_SYMPTOMS');?></a>
                        </div>
                    </div>
                </div>
                <?php
            }

            if (!empty($arResult['BOTTOM_TABS']['QUESTIONS'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['QUESTIONS']['NAME'];?></h3>
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
                </div>
                <?php
            }

            if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['RECOMMENDATIONS']['NAME'];?></h3>
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
                </div>
                <?php
            }

            if (!empty($arResult['BOTTOM_TABS']['REVIEWS'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['REVIEWS']['NAME'];?></h3>
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
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="swiper-button-next swiper-button-next9 swiper-button-next-style2"></div>
    <div class="swiper-button-prev swiper-button-prev9 swiper-button-prev-style2"></div>
</div>
<?endif;?>
<?php
if (!empty($arResult['PROPERTIES']['RESULTS']['VALUE'])) {
    ?>
    <div class="service1-results">
        <h2><?php echo getMessage('RESULTS_TITLE');?></h2>
        <div class="service1-results-slider">
            <div class="swiper-container swiper-container5">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['PROPERTIES']['RESULTS']['~VALUE'] as $arRes) {
                        ?>
                        <div class="swiper-slide">
                            <div class="service1-results-item">
                                <?php echo $arRes['TEXT'];?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next5 swiper-button-next-style2"></div>
            <div class="swiper-button-prev swiper-button-prev5 swiper-button-prev-style2"></div>
        </div>
    </div>
    <?php
}
?>

<?php
$this->setViewTarget('stocks_desktop');
    if (!empty($arResult['STOCKS'])) {
        ?>
        <div class="service1-action-slider">
            <div class="swiper-container swiper-container10">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['STOCKS'] as $obStock) {
                        ?>
                        <div class="swiper-slide">
                            <div class="service1-action">
                                <?php
                                if (!empty($obStock->expireDateCounter)) {
                                    ?>
                                    <div class="promo-ends">
                                        <div class="title_for_action_slide"><?php echo $obStock->name;?></div>
                                        <b><?php echo getMessage('before_expire');?></b>
                                        <div class="stock-timer">
                                            <div class="service1-action-timer-wrap">
                                                <span class="service1-action-timer clock<?php echo $obStock->id;?>" data-date="<?php echo $obStock->expireDateCounter;?>" data-id="<?php echo $obStock->id;?>"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="service1-action-img">
                                    <p class="service1-action-discont">
                                        <b><?php echo $obStock->amount;?> <?php echo $obStock->percentage ? '%' : 'Р';?></b>
                                    </p>
                                    <?php
                                    if (!empty($obStock->previewPicture)) {
                                        ?>
                                        <img src="<?php echo $obStock->previewPicture['SMALL_SRC'];?>" alt="<?php echo $obStock->previewPicture['ALT'];?>">
                                        <?php
                                    }
                                    ?>
                                    <div class="service1-action-text-btn-wrap">
                                        <a href="<?php echo $obStock->url;?>" class="btn4"><?php echo getMessage('ND_DIRECTIONS_SHOW_MORE');?></a>
                                    </div>
                                </div>
                                <div class="service1-action-text">
                                    <!--<h2><?php /*echo $obStock->name;*/?></h2>-->
                                    <?php
                                    if (!empty($obStock->expireDate)) {
                                        ?>
                                        <b><?php echo getMessage('ND_DIRECTIONS_UNTIL') . ' ' . $obStock->expireDate;?></b>
                                        <?php
                                    }
                                    ?>
                                    <p><?php echo $obStock->previewText;?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next10 swiper-button-next-style2"></div>
            <div class="swiper-button-prev swiper-button-prev10 swiper-button-prev-style2"></div>
        </div>
        <?php
    }
$this->endViewTarget();

$this->setViewTarget('doctors_list');
    if (!empty($arResult['DOCTORS'])) {
        ?>
        <div class="service1-doctors service1-doctors-services-style services_detail__">
            <h3><?php echo getMessage('ND_DIRECTIONS_DOCTORS');?></h3>
            <div class="service1-doctors-slider">
                <div class="swiper-container swiper-container7">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['DOCTORS'] as $obDoctor) {
                            ?>
                            <div class="swiper-slide">
                                <?php
                                if (!empty($obDoctor["IMG"]['SRC'])) {
                                    ?>
                                    <div class="service1-doctors-img">
                                        <img src="<?php echo $obDoctor["IMG"]['SRC_SMALL'];?>" alt="<?php echo $obDoctor["IMG"]['ALT'];?>">
                                    </div>
                             <?}else{?>
                                    <div class="service1-doctors-img">
                                        <img src="/no-photo.jpg" alt="<?php echo $obDoctor["IMG"]['ALT'];?>">
                                    </div>
				<?}?>
                                <div class="service1-doctors-text">
                                    <h4><?php echo $obDoctor["NAME"];?></h4>
                                    <p><?php echo $obDoctor["POSITION"];?></p>
                                    <a href="<?php echo $obDoctor["URL"];?>" class="btn3"><?php echo getMessage('ND_DIRECTIONS_DOCTOR_DETAIL');?></a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="swiper-button-next swiper-button-next7 swiper-button-next-style2"></div>
                <div class="swiper-button-prev swiper-button-prev7 swiper-button-prev-style2"></div>
            </div>
            <div class="service1-doctors-link-wrap">
                <?if($arResult["PROPERTIES"]["URL_DOCTOR"]["VALUE"]!=""):?>
                    <a href="<?php echo $arResult["PROPERTIES"]["URL_DOCTOR"]["VALUE"];?>">
                        <?if($arResult["PROPERTIES"]["URL_DOCTOR"]["DESCRIPTION"]!=""):?>
                            <?php echo $arResult["PROPERTIES"]["URL_DOCTOR"]["DESCRIPTION"];?>
                        <?else:?>
                            <?php echo getMessage('ALL_DOCTORS');?>
                        <?endif;?>
                    </a>
                <?else:?>
                    <a href="<?php echo getMessage('ALL_DOCTORS_LINK');?>"><?php echo getMessage('ALL_DOCTORS');?></a>
                <?endif;?>
            </div>
        </div>
        <?php
    }else{?>
        <?if($arResult["PROPERTIES"]["URL_DOCTOR"]["VALUE"]!=""):?>
            <div class="service1-doctors service1-doctors-services-style services_detail__">
                <div class="service1-doctors-link-wrap">
                        <a href="<?php echo $arResult["PROPERTIES"]["URL_DOCTOR"]["VALUE"];?>">
                            <?if($arResult["PROPERTIES"]["URL_DOCTOR"]["DESCRIPTION"]!=""):?>
                                <?php echo $arResult["PROPERTIES"]["URL_DOCTOR"]["DESCRIPTION"];?>
                            <?else:?>
                                <?php echo getMessage('ALL_DOCTORS');?>
                            <?endif;?>
                        </a>
                </div>
            </div>
        <?endif;
    }
$this->endViewTarget();

$this->setViewTarget('other_services');
    if (!empty($arResult['OTHER_SERVICES'])) {
        ?>
        <div class="service1-other">
            <h3><?php echo getMessage('other_services');?></h3>
            <div class="service1-other-slider">
                <div class="swiper-container swiper-container8">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['OTHER_SERVICES'] as $arService) {
                            ?>
                            <div class="swiper-slide">
                                <div class="service1-other-item">
                                    <h4><?php echo $arService['NAME'];?></h4>
									<?if ( $arService['PRICE'] ):?>
										<b><?php echo priceFormat($arService['PRICE']);?> ₽</b>
                                    <?endif;?>
									<p><?php echo $arService['PREVIEW_TEXT'];?></p>
                                    <a href="<?php echo $arService['URL'];?>" class="btn2">Подробнее</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="swiper-button-next swiper-button-next8 swiper-button-next-style2"></div>
                <div class="swiper-button-prev swiper-button-prev8 swiper-button-prev-style2"></div>
            </div>
        </div>
        <?php
    }
$this->endViewTarget();
?>


<script type='application/ld+json'> 
{
  "@context": "http://www.schema.org",
  "@type": "Offer",
  "name": "<?=$arResult['NAME']?>",
  "url": "https://<?=$_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPageParam("", Array("CODE", "PARAMS", "search", "PAGEN_2") )?>",
  "image": "https://<?=$_SERVER['HTTP_HOST'] . $arResult['DETAIL_PICTURE']['SRC']?>"
}
</script>

