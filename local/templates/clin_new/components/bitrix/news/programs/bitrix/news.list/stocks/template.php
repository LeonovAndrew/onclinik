<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
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

<div class="service1-action-slider service1-action-slider1">
    <div class="swiper-container swiper-container10">
        <div class="swiper-wrapper">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>

                <div class="swiper-slide">
                    <div class="service1-action service1-action1 promo-action">
                        <?php
                        if (!empty($arItem['DATE_ACTIVE_TO'])) {
                            ?>
                            <div class="promo-ends">
                                <b><?php echo getMessage('PROMOTION_ENDS');?></b>
                                <div class="service1-action-timer-wrap">
                                    <span class="service1-action-timer clock<?php echo $arItem['ID'];?>" data-date="<?php echo $arItem['DATE_ACTIVE_TO'];?>" data-id="<?php echo $arItem['ID'];?>"></span>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="service1-action-img">
                            <p class="service1-action-discont">
                                <b><?php echo $arItem['PROPERTIES']['AMOUNT']['VALUE'];?><?php echo $arItem['PROPERTIES']['PERCENTAGE']['VALUE'] ? ' %' : ' р';?></b>
                            </p>
                            <?php
                            if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) {
                                ?>
                                <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                                <?php
                            }
                            ?>
                            <div class="service1-action-text-btn-wrap">
                                <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('LEARN_MORE');?></a>
                            </div>
                        </div>
                        <div class="service1-action-text">
                            <h2><?php echo $arItem['NAME'];?></h2>
                            <b><?php echo getMessage('FROM');?> <?php echo $arItem['expire_date'];?></b>
                            <p><?php echo $arItem['~PREVIEW_TEXT'];?></p>
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
if (!empty($arResult['ITEMS'])) {
    $this->setViewTarget('stocks_mobile');
    ?>
    <div class="service1-action-slider service1-action-slider1">
        <div class="swiper-container swiper-container11">
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['ITEMS'] as $arItem) {
                    ?>
                    <div class="swiper-slide">
                        <div class="service1-action service1-action1 promo-action">
                            <?php
                            if (!empty($arItem['DATE_ACTIVE_TO'])) {
                                ?>
                                <div class="promo-ends">
                                    <b><?php echo getMessage('PROMOTION_ENDS');?></b>
                                    <div class="service1-action-timer-wrap">
                                        <span class="service1-action-timer clock<?php echo $arItem['ID'];?>" data-date="<?php echo $arItem['DATE_ACTIVE_TO'];?>" data-id="<?php echo $arItem['ID'];?>"></span>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="service1-action-img">
                                <p class="service1-action-discont">
                                    <b><?php echo $arItem['PROPERTIES']['AMOUNT']['VALUE'];?><?php echo $arItem['PROPERTIES']['PERCENTAGE']['VALUE'] ? ' %' : ' р';?></b>
                                </p>
                                <?php
                                if (!empty($arItem['PREVIEW_PICTURE']['SRC'])) {
                                    ?>
                                    <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                                    <?php
                                }
                                ?>
                                <b><?php echo $arItem['PROPERTIES']['AMOUNT']['VALUE'];?><?php echo $arItem['PROPERTIES']['PERCENTAGE']['VALUE'] ? ' %' : ' р';?></b>
                                <div class="service1-action-text-btn-wrap">
                                    <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('LEARN_MORE');?></a>
                                </div>
                            </div>
                            <div class="service1-action-text">
                                <h2><?php echo $arItem['NAME'];?></h2>
                                <?php
                                if (!empty($arItem['expire_date'])) {
                                    ?>
                                    <b><?php echo getMessage('FROM') . ' ' . $arItem['expire_date'];?></b>
                                    <?php
                                }
                                ?>
                                <p><?php echo $arItem['~PREVIEW_TEXT'];?></p>
                            </div>
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
    $this->endViewTarget();
}
?>