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

<div class="service1-text1" id="start">
	<?if ( strlen($arResult['PROPERTIES']['H1']['~VALUE']) > 1 ):?>
		<h1><?php echo $arResult['PROPERTIES']['H1']['~VALUE'];?></h1>
	<?endif;?>
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

<div class="service1-btn-block-wrap readmore">
    <div class="service1-action-slider service1-action-slider1">
        <div class="swiper-container swiper-container10">
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['STOCKS'] as $obStock) {
                    ?>
					
                    <div class="swiper-slide">
                        <div class="service1-action service1-action1 promo-action">
                            <div class="promo-title">
								<span><?php echo $obStock->name;?></span>
							</div>
							<?php
                            if (!empty($obStock->expireDateCounter)) {
                                ?>
                                <div class="promo-ends">
                                   <?php echo getMessage('before_expire');?>
                                        <div class="stock-timer">
                                            <?php
                                if (!empty($obStock->expireDate)) {
                                    ?>
                                    <?php echo getMessage('to') . ' ' . $obStock->expireDate; ?>
                                    <?php
                                }
                                ?>
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
									<div class="actionImg">
										<img src="<?php echo $obStock->previewPicture['SRC'];?>" alt="<?php echo $obStock->previewPicture['ALT'];?>">
									</div>
									<?php
								}
								?>
								<div class="service1-action-text-btn-wrap">
									<a href="<?php echo $obStock->url;?>" class="btn4"><?php echo getMessage('ND_DIRECTIONS_SHOW_MORE');?></a>
								</div>
							</div>
							

                            <div class="service1-action-text">
                                
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
    <div class="cost1-slider">
        <div class="swiper-container swiper-container11">
            <div class="swiper-wrapper">
                <?php
                if ($arResult['SERVICES']['TYPES_CNT'] > 1) {
                    foreach ($arResult['SERVICES']['TYPES'] as $key => $arServiceType) {
                        ?>
                        <div class="swiper-slide">
                            <h3><?php echo $arServiceType['NAME'];?></h3>
                            <div class="cost1">
                                <ul class="cost1-list">
                                    <?php
                                    foreach ($arServiceType['ITEMS'] as $obService) {
                                        ?>
                                        <li>
                                            <i><a href="<?php echo $obService->url;?>"><?php echo $obService->name;?></a></i>
                                            <b><a class="price_link" href="<?php echo $obService->url;?>"><?php echo getMessage('ND_DIRECTIONS_PRICE');?></a></b>
											<?/*
											<?php
                                            if ($obService->minimumPrice != $obService->minimumDiscountPrice) {
                                                ?>
                                                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumDiscountPrice);?> ₽</b>
                                                <span><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</span>
                                                <?php
                                            } else {
                                                ?>
                                                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</b>
                                                <?php
                                            }
											*/
                                            ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="service1-tab-link-wrap">
                                <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES_LINK') . $arResult['CODE'] . '/price/';?>/"><?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES');?></a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="swiper-slide">
                        <h3><?php echo getMessage('ND_DIRECTIONS_PRICES_TAB');?></h3>
                        <div class="cost1">
                            <ul class="cost1-list">
                                <?php
                                reset($arResult['SERVICES']['TYPES']);
                                foreach (current($arResult['SERVICES']['TYPES'])['ITEMS'] as $obService) {
                                    ?>
                                    <li>
                                        <i><a href="<?php echo $obService->url;?>"><?php echo $obService->name;?></a></i>
                                        <b><a class="price_link" href="<?php echo $obService->url;?>"><?php echo getMessage('ND_DIRECTIONS_PRICE');?></a></b>
											<?/*
											<?php
                                            if ($obService->minimumPrice != $obService->minimumDiscountPrice) {
                                                ?>
                                                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumDiscountPrice);?> ₽</b>
                                                <span><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</span>
                                                <?php
                                            } else {
                                                ?>
                                                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</b>
                                                <?php
                                            }
											*/
                                            ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="service1-tab-link-wrap">
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES_LINK') . $arResult['CODE'] . '/price/';?>/"><?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES');?></a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="swiper-button-next swiper-button-next11 swiper-button-next-style2"></div>
        <div class="swiper-button-prev swiper-button-prev11 swiper-button-prev-style2"></div>
    </div>
    <?php
    if (!empty($arResult['SERVICES']['TYPES'])) {
        ?>
        <div class="service1-tabs" id="price">
            <ul class="tab_list1 service1-tab_list">
                <?php
                if ($arResult['SERVICES']['TYPES_CNT'] > 1) {
                    $first = true;
                    foreach ($arResult['SERVICES']['TYPES'] as $key => $arServiceType) {
                        ?>
                        <li>
                            <a<?php if ($first) {?> class="active"<?php $first = false;}?> href="#s<?php echo $key?>"><?php echo $arServiceType['NAME'];?></a>
                        </li>
                        <?php
                    }
                } else {
                    ?>
                    <li>
                        <a class="active" href="#sd"><?php echo getMessage('ND_DIRECTIONS_PRICES_TAB');?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="service1-tabs-wrap">
                <?php
				
                if ($arResult['SERVICES']['TYPES_CNT'] > 1) {
                    $first = true;
					
                    foreach ($arResult['SERVICES']['TYPES'] as $key => $arServiceType) {
                        ?>
                        <div<?php if (!$first) {?> style="display: none;"<?php } else { $first = false; }?> class="service1-tab block_content1" id="s<?php echo $key;?>">
                            <div class="service1-tab-wrap">
                                <div class="cost1">
                                    <ul class="cost1-list">
                                        <?php
										$count = 0;
                                        foreach ($arServiceType['ITEMS'] as $obService) {
                                            ?>
                                            <li>
                                                <i><a href="<?php echo $obService->url;?>"><?php echo $obService->name;?></a></i>
                                                <b><a class="price_link" href="<?php echo $obService->url;?>"><?php echo getMessage('ND_DIRECTIONS_PRICE');?></a></b>
												<?/*
												<?php
												if ($obService->minimumPrice != $obService->minimumDiscountPrice) {
													?>
													<b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumDiscountPrice);?> ₽</b>
													<span><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</span>
													<?php
												} else {
													?>
													<b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</b>
													<?php
												}
												*/
												?>
                                            </li>
                                            <?php
											$count++;
											if ( $count  > 9 ){
												break;
											}
                                        }
                                        ?>
                                    </ul>
                                </div>
								<p class="price_info_text"><small><?php echo getMessage('PRICE_TEXT')?></small></p>
                                <div class="service1-tab-link-wrap">
                                    <a href="price/"><?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES');?></a>
                                </div>
                            </div>
                        </div>
                        <?php
						
                    }
                } else {
                    ?>
                    <div class="service1-tab block_content1" id="sd">
                        <div class="service1-tab-wrap">
                            <div class="cost1">
                                <ul class="cost1-list">
                                    <?php
									$i = 0;
                                    reset($arResult['SERVICES']['TYPES']);
                                    foreach (current($arResult['SERVICES']['TYPES'])['ITEMS'] as $key => $obService) {
                                        ?>
                                        <li>
                                            <i><a href="<?php echo $obService->url;?>"><?php echo $obService->name;?></a></i>
                                            <b><a class="price_link" href="<?php echo $obService->url;?>"><?php echo getMessage('ND_DIRECTIONS_PRICE');?></a></b>
											<?/*
											<?php
                                            if ($obService->minimumPrice != $obService->minimumDiscountPrice) {
                                                ?>
                                                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumDiscountPrice);?> ₽</b>
                                                <span><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</span>
                                                <?php
                                            } else {
                                                ?>
                                                <b><?php echo getMessage('ND_DIRECTIONS_PRICE_FROM');?> <?php echo priceFormat($obService->minimumPrice);?> ₽</b>
                                                <?php
                                            }
											*/
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
							<p class="price_info_text"><small><?php echo getMessage('PRICE_TEXT')?></small></p>
                            <div class="service1-tab-link-wrap">
                                <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES_LINK') . $arResult['CODE'] . '/price/';?>"><?php echo getMessage('ND_DIRECTIONS_ALL_SERVICES');?></a>
                            </div>
                        </div>
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

<?if ( $arResult['PROPERTIES']['PROCESS_TEXT']['~VALUE']['TEXT'] ):?>
	<div class="service1-reception readmore">
		<h2><?php echo getMessage('ND_DIRECTIONS_RECEPTION_TITLE');?></h2>
		<div class="service1-reception-wrap">
			<?php echo $arResult['PROPERTIES']['PROCESS_TEXT']['~VALUE']['TEXT'];?>
		</div>
	</div>
<?endif;?>

<div class="service1-tabs">
    <ul class="tab_list service1-tab_list">
        <?php
        if (!empty($arResult['BOTTOM_TABS']['DISEASES'])) {
            ?>
            <li>
                <a<?php if ($arResult['BOTTOM_TABS']['DISEASES']['SELECTED']) {;?> class="active"<?php }?> href="#diseasestab"><?php echo $arResult['BOTTOM_TABS']['DISEASES']['NAME'];?></a>
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
            <div <?php if (!$arResult['BOTTOM_TABS']['DISEASES']['SELECTED']) {?> style="display:none"<?php }?> class="service1-tab block_content" id="diseasestab">
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
                    <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_QUESTIONS_LINK') . '?directionId=' . $arResult['ID'];;?>"><?php echo getMessage('ND_DIRECTIONS_ALL_QUESTIONS');?></a>
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
                    <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_REVIEWS_LINK') . '?directionId=' . $arResult['ID'];?>"><?php echo getMessage('ND_DIRECTIONS_ALL_REVIEWS');?></a>
                </div>
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
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_QUESTIONS_LINK') . '?directionId=' . $arResult['ID'];?>"><?php echo getMessage('ND_DIRECTIONS_ALL_QUESTIONS');?></a>
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
                            <a href="<?php echo getMessage('ND_DIRECTIONS_ALL_REVIEWS_LINK') . '?directionId=' . $arResult['ID'];?>"><?php echo getMessage('ND_DIRECTIONS_ALL_REVIEWS');?></a>
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

<?php
//TODO: form
?>
<div class="service1-feedback">
    <div class="service1-feedback-wrap">
        <h2>Запишитесь на консультацию к специалистам Он Клиник!</h2>
        <p>Запись ведется по телефону <a href="tel:+74952668571">+7 495 266-85-71</a>. <br> Или заполните форму онлайн записи</p>
									<?php
									$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										array(
											"AREA_FILE_RECURSIVE" => "Y",
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"PATH" => "/include/order_direction.php"
										),
										false,
										array(
											'HIDE_ICONS' => 'Y'
										)
									);
									?>
    </div>
</div>

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
                                        <?php echo getMessage('before_expire');?>
                                        <div class="stock-timer">
                                            <?php
                                if (!empty($obStock->expireDate)) {
                                    ?>
                                    <?php echo getMessage('to') . ' ' . $obStock->expireDate; ?>
                                    <?php
                                }
                                ?>
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
										<div class="actionImg">
											<img src="<?php echo $obStock->previewPicture['SMALL_SRC'];?>" alt="<?php echo $obStock->previewPicture['ALT'];?>">
                                        </div>
										<?php
                                    }
                                    ?>
                                    <div class="service1-action-text-btn-wrap">
                                        <a href="<?php echo $obStock->url;?>" class="btn4"><?php echo getMessage('ND_DIRECTIONS_SHOW_MORE');?></a>
                                    </div>
                                </div>
                                <div class="service1-action-text">
                                    <span><?php echo $obStock->name;?></span>
                                    
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
        <!--<pre style="display: none">
            <?/*
            print_r($arResult['DOCTORS'])
            */?>
        </pre>-->


        <div class="service1-doctors service1-doctors-services-style">
            <h3><?php echo getMessage('ND_DIRECTIONS_DOCTORS');?></h3>
            <div class="service1-doctors-slider">
                <div class="swiper-container swiper-container7">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($arResult['DOCTORS'] as $obDoctor) {
                            ?>

                            <div class="swiper-slide">

                                <?php
                                if (!empty($obDoctor->previewPicture['SRC'])) {
                                    ?>
                                    <div class="service1-doctors-img">
                                        <img src="<?php echo $obDoctor->previewPicture['SMALL_SRC'];?>" alt="<?php echo $obDoctor->previewPicture['ALT'];?>">
                                    </div>
                                    <?php
                                }else{?>
                                    <div class="service1-doctors-img">
                                        <img src="/no-photo.jpg" alt="<?php echo $obDoctor->previewPicture['ALT'];?>">
                                    </div>

				<? }
                                ?>
                                <div class="service1-doctors-text">
                                    <h4><?php echo $obDoctor->name;?></h4>
                                    <p><?php echo $obDoctor->position;?></p>
                                    <a href="<?php echo $obDoctor->url;?>" class="btn3"><?php echo getMessage('ND_DIRECTIONS_DOCTOR_DETAIL');?></a>
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
                <a href="<?php echo getMessage('ALL_DOCTORS_LINK') . '?directionId=' . $arResult['ID'];?>"><?php echo getMessage('ND_DIRECTIONS_ALL_DOCTORS_DIRECTION');?></a>
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