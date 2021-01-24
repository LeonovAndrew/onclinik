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
?>

<div class="service1-text1">
	<?if ( $arResult['PROPERTIES']['H1']['~VALUE'] ):?>
		<h1><?php echo $arResult['PROPERTIES']['H1']['~VALUE'];?></h1>
	<?endif;?>
    <div class="service1-text1-wrap readmore">
        <img src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
        <?php echo $arResult['~DETAIL_TEXT'];?>
    </div>
</div>
<?php
if (!empty($arResult['PROPERTIES']['KINDS']['~VALUE']['TEXT'])) {
    ?>
    <div class="service1-reception">
        <h2><?php echo getMessage('TYPES_OF_DISEASE');?></h2>
        <div class="service1-reception-wrap">
            <?php echo $arResult['PROPERTIES']['KINDS']['~VALUE']['TEXT'];?>
        </div>
    </div>
    <?php
}
?>

<div class="service1-tabs">
    <ul class="tab_list service1-tab_list">
        <?php
        if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
            ?>
            <li>
                <a<?php if ($arResult['BOTTOM_TABS']['DISEASES']['selected']) {;?> class="active"<?php }?> href="#diseases"><?php echo $arResult['BOTTOM_TABS']['DISEASES']['name'];?></a>
            </li>
            <?php
        }

        if (!empty($arResult['BOTTOM_TABS']['SERVICES'])) {
            foreach ($arResult['BOTTOM_TABS']['SERVICES'] as $key => $arService) {
                ?>
                <li>
                    <a<?php if ($arService['selected']) {;?> class="active"<?php }?> href="#<?php echo $arService['id'];?>"><?php echo $arService['name'];?></a>
                </li>
                <?php
            }
        }

        if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])) {
            ?>
            <li>
                <a<?php if ($arResult['BOTTOM_TABS']['RECOMMENDATIONS']['selected']) {;?> class="active"<?php }?> href="#recommendations"><?php echo $arResult['BOTTOM_TABS']['RECOMMENDATIONS']['name'];?></a>
            </li>
            <?php
        }
        ?>
    </ul>

    <div class="service1-tabs-wrap">
        <?php
        if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
            ?>
            <div class="service1-tab block_content" id="diseases">
                <div class="service1-tab-wrap">
                    <?php echo $arResult['BOTTOM_TABS']['DISEASES']['preview_text'];?>
                    <?php
                    $k = 0;
                    $pageSize = 6;
                    foreach ($arResult['BOTTOM_TABS']['DISEASES']['items'] as $obItem) {
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
                        <a href="<?php echo getMessage('all_diseases_link');?>"><?php echo getMessage('all_diseases');?></a>
                    </div>
                    <div class="service1-tab-text1">
                        <?php echo $arResult['BOTTOM_TABS']['DISEASES']['detail_text'];?>
                    </div>
                </div>
            </div>
            <?php
        }

        foreach ($arResult['BOTTOM_TABS']['SERVICES'] as $key => $arService) {
            ?>
            <div<?php if (!$arService['selected']) {?> style="display: none;"<?php }?> class="service1-tab block_content" id="<?php echo $arService['id'];?>">
                <div class="service1-tab-wrap">
                    <div class="cost1">
                        <ul class="cost1-list">
                            <?php
                            echo $arService['text'];

                            foreach ($arService['items'] as $obService) {
                                ?>
                                <li>
                                    <a href="<?=$obService->url;?>"><?=$obService->name;?></a>
                                    <?php
                                    if ($obService->minimumDiscountPrice != $obService->minimumPrice) {
                                        ?>
                                        <b><?php echo getMessage('from');?> <?php echo priceFormat($obService->minimumDiscountPrice);?> ₽</b>
                                        <span><?php echo getMessage('from');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</span>
                                        <?php
                                    } else {
                                        ?>
                                        <b><?php echo getMessage('from');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</b>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
					<p class="price_info_text"><small><?php echo getMessage('PRICE_TEXT')?></small></p>
                    <div class="service1-tab-link-wrap">
                        <a href="<?php echo getMessage('all_services_link');?>"><?php echo getMessage('all_services');?></a>
                    </div>
                </div>
            </div>
            <?php
        }

        if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])) {
            ?>
            <div<?php if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS']['selected'])) {?> style="display: none;"<?php }?> class="service1-tab block_content" id="recommendations">
                <?php
                foreach ($arResult['BOTTOM_TABS']['RECOMMENDATIONS']['items'] as $obRecommendation) {
                    ?>
                    <div class="doctor_info">
							<div class="doctor-info-title">
								<?if ( $obItem->doctor ):?>
									<span><a href="<?php echo $obItem->doctor->url;?>"><?php echo $obItem->doctor->name;?></a>, <?php echo $obItem->doctor->position;?></span>
								<?else:?>
									<span>ММЦ ОН КЛИНИК</span>
								<?endif;?>
							</div>

                        <p><?php echo $obRecommendation->text;?></p>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<div class="service1-tabs-slider service1-tabs-slider-services-style">
    <div class="swiper-container swiper-container9">
        <div class="swiper-wrapper">
            <?php
            if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['DISEASES']['name'];?></h3>
                        <ul class="service1-tab-list">
                            <?php
                            foreach ($arResult['BOTTOM_TABS']['DISEASES']['items'] as $obItem) {
                                ?>
                                <li>
                                    <a href="<?php echo $obItem->url;?>"><?php echo $obItem->name;?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="service1-tab-link-wrap">
                            <a href="<?php echo getMessage('all_diseases_link');?>"><?php echo getMessage('all_diseases');?></a>
                        </div>
                        <div class="service1-tab-text1">
                            <?php echo $arResult['BOTTOM_TABS']['DISEASES']['preview_text'];?>
                            <?php echo $arResult['BOTTOM_TABS']['DISEASES']['detail_text'];?>
                        </div>
                    </div>
                </div>
                <?php
            }

            if (!empty($arResult['BOTTOM_TABS']['SERVICES'])) {
                foreach ($arResult['BOTTOM_TABS']['SERVICES'] as $arService) {
                    ?>
                    <div class="swiper-slide">
                        <div class="service1-tabs-item">
                            <h3><?php echo $arService['name'];?></h3>
                            <div class="cost1">
                                <ul class="cost1-list">
                                    <?php
                                    foreach ($arService['items'] as $obService) {
                                        ?>
                                        <li>
                                            <a href="<?=$obService->url;?>"><?=$obService->name;?></a>
                                            <?php
                                            if ($obService->minimumDiscountPrice != $obService->minimumPrice) {
                                                ?>
                                                <b><?php echo getMessage('from');?> <?php echo $obService->minimumDiscountPrice;?> ₽</b>
                                                <span><?php echo getMessage('from');?> <?php echo $obService->minimumPrice;?> ₽</span>
                                                <?php
                                            } else {
                                                ?>
                                                <b><?php echo getMessage('from');?> <?php echo $obService->minimumPrice;?> ₽</b>
                                                <?php
                                            }
                                            ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="service1-tab-link-wrap">
                                <a href="<?php echo getMessage('all_services_link');?>"><?php echo getMessage('all_services');?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

            if (!empty($arResult['BOTTOM_TABS']['RECOMMENDATIONS'])) {
                ?>
                <div class="swiper-slide">
                    <div class="service1-tabs-item">
                        <h3><?php echo $arResult['BOTTOM_TABS']['RECOMMENDATIONS']['name'];?></h3>
                        <?php
                        foreach ($arResult['BOTTOM_TABS']['RECOMMENDATIONS']['items'] as $obRecommendation) {
                            ?>
                            <div class="doctor_info">
                                <div class="doctor-info-title">
                                    <span><a href="<?php echo $obRecommendation->doctor->url;?>"><?php echo $obRecommendation->doctor->name;?></a>, <?php echo $obRecommendation->doctor->position;?></span>
                                </div>

                                <p><?php echo $obRecommendation->text;?></p>
                            </div>
                            <?php
                        }
                        ?>
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

<?php
if (!empty($arResult['STOCKS'])) {
    $this->setViewTarget('stocks_mobile');
        ?>
        <div class="service1-action-slider service1-action-slider1">
            <div class="swiper-container swiper-container10">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['STOCKS'] as $obStock) {
                        ?>
                        <div class="swiper-slide">
                            <div class="service1-action service1-action1 promo-action">
                                <?php
                                if (!empty($obStock->expireDateCounter)) {
                                    ?>
                                    <div class="promo-ends">
                                        <div class="title_for_action_slide"><?php echo $obStock->name;?></div>
                                        <b><?php echo getMessage('PROMOTION_ENDS');?></b>
                                        <div class="service1-action-timer-wrap">
                                            <span class="service1-action-timer clock<?php echo $obStock->id;?>" data-date="<?php echo $obStock->expireDateCounter;?>" data-id="<?php echo $obStock->id;?>"></span>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="service1-action-img">
                                    <?php
                                    if (!empty($obStock->previewPicture)) {
                                        ?>
                                        <img src="<?php echo $obStock->previewPicture['SRC'];?>" alt="<?php echo $obStock->previewPicture['ALT'];?>">
                                        <?php
                                    }
                                    ?>
                                    <b><?php echo $obStock->amount;?> <?php echo $obStock->percentage ? '%' : 'Р';?></b>
                                    <div class="service1-action-text-btn-wrap">
                                        <a href="<?php echo $obStock->url;?>" class="btn4"><?php echo getMessage('DISEASE_DETAILS');?></a>
                                    </div>
                                </div>
                                <div class="service1-action-text">
                                    <!--<h2><?php /*echo $obStock->name;*/?></h2>-->
                                    <?php
                                    if (!empty($obStock->expireDate)) {
                                        ?>
                                        <b><?php echo getMessage('to') . ' ' . $obStock->expireDate;?></b>
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
    $this->endViewTarget();

    $this->setViewTarget('stocks_desktop');
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
                                        <div class="title_for_action_slide"><?php echo $obStock->name; ?></div>
                                        <b><?php echo getMessage('PROMOTION_ENDS');?></b>
                                        <div class="service1-action-timer-wrap">
                                            <span class="service1-action-timer clock<?php echo $obStock->id; ?>" data-date="<?php echo $obStock->expireDateCounter;?>" data-id="<?php echo $obStock->id;?>"></span>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="service1-action-img">
                                    <?php
                                    if (!empty($obStock->previewPicture)) {
                                        ?>
                                        <img src="<?php echo $obStock->previewPicture['SRC']; ?>"
                                             alt="<?php echo $obStock->previewPicture['ALT']; ?>">
                                        <?php
                                    }
                                    ?>
                                    <b><?php echo $obStock->amount; ?><?php echo $obStock->percentage ? '%' : 'Р'; ?></b>
                                    <div class="service1-action-text-btn-wrap">
                                        <a href="<?php echo $obStock->url; ?>"
                                           class="btn4"><?php echo getMessage('DISEASE_DETAILS'); ?></a>
                                    </div>
                                </div>
                                <div class="service1-action-text">
                                    <!--<h2><?php /*echo $obStock->name; */?></h2>-->
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
    $this->endViewTarget();
}
?>

<script>
    var counterWords = <?php echo json_encode($arResult['counter']['words']);?>;
</script>
