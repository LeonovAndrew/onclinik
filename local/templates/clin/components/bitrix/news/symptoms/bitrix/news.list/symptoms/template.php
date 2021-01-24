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
    <div class="disease-wrap">
        <h2><?php echo getMessage('DISEASE_SIMILAR_TITLE');?></h2>
        <div class="disease-slider">
            <div class="swiper-container swiper-container18">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['ITEMS'] as $arItem) {
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                            <div class="disease-item">
                                <div class="disease-img-wrap">
                                    <div class="disease-img">
<?if(empty($arItem['PREVIEW_PICTURE']['SRC'])){?>                   
	<img src="/disease-item-img.jpg" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
<?}else{?>
	 <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT']; ?>">
<?}?>
                                    </div>
                                    <div class="disease-link-wrap">
                                        <a href="<?php echo $arItem['DETAIL_PAGE_URL']; ?>"
                                           class="btn4"><?php echo getMessage('LEARN_MORE'); ?></a>
                                    </div>
                                </div>
                                <div class="disease-text">
                                    <h3><?php echo $arItem['NAME']; ?></h3>
                                    <p><?php echo $arItem['~PREVIEW_TEXT']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next18 swiper-button-next-style2"></div>
            <div class="swiper-button-prev swiper-button-prev18 swiper-button-prev-style2"></div>
        </div>
    </div>
    <?php
}
?>
