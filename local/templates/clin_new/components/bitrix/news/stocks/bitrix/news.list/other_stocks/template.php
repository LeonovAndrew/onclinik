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

<?php
if (!empty($arResult['ITEMS'])) {
    ?>
    <div class="action-other">
        <h2><?php echo getMessage('other_stocks');?></h2>
        <div class="action-other-slider">
            <div class="swiper-container swiper-container21">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['ITEMS'] as $arItem) {
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                            <div class="stock-item stock-item-1">
                                <?php
                                if (!empty($arItem['DATE_ACTIVE_TO'])) {
                                    ?>
                                    <div class="promo-ends">
                                        <b><?php echo getMessage('before_expire');?>:</b>
                                        <div class="stock-timer">
                                            <span class="service1-action-timer clock<?php echo $arItem['ID'];?>" data-date="<?php echo $arItem['DATE_ACTIVE_TO'];?>" data-id="<?php echo $arItem['ID'];?>"></span>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="stock-img-wrap">
                                    <i><?php echo $arItem['PROPERTIES']['AMOUNT']['VALUE'];?><?php echo $arItem['PROPERTIES']['PERCENTAGE']['VALUE'] ? ' %' : ' р';?></i>
                                    <div class="stock-img">
                                        <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
                                    </div>
                                    <div class="stock-btn">
                                        <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('stock_detail');?></a>
                                    </div>
                                </div>
                                <div class="stock-text">
                                    <h3><?php echo $arItem['NAME'];?></h3>
                                    <?php
                                    if (isset($arItem['EXPIRE_DATE'])) {
                                        ?>
                                        <b><?php echo getMessage('to');?> <?php echo $arItem['EXPIRE_DATE'];?></b>
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
            <div class="swiper-button-next swiper-button-next21 swiper-button-next-style2"></div>
            <div class="swiper-button-prev swiper-button-prev21 swiper-button-prev-style2"></div>
        </div>
    </div>
    <?php
}
?>
