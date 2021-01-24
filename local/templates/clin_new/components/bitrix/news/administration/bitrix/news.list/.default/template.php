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

<div class="administration-list" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="administration-item ajax-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="administration-item-img-wrap">
                <div class="administration-item-img">

<?if(empty($arItem['PREVIEW_PICTURE']['SRC'])){?>                   
<img src="/no-photo.jpg" alt="<?php echo $arResult['DETAIL_PICTURE']['ALT'];?>">
<?}else{?>
    <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
<?}?>

                </div>
                <div class="administration-item-feedback">
                    <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="btn4"><?php echo getMessage('NL_ADM_DETAIL_BTN');?></a>
                </div>
            </div>
            <div class="administration-item-text">
                <h3><?php echo $arItem['NAME'];?></h3>
                <span><?php echo $arItem['PROPERTIES']['POSITION']['VALUE']['TEXT'];?></span>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
    echo $arResult['NAV_STRING'];
}
?>