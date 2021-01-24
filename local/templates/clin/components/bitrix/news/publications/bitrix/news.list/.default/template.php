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
$this->setViewTarget('pagination_top');
    if ($arParams["DISPLAY_TOP_PAGER"]) {
        echo $arResult['NAV_STRING_TOP'];
    }
$this->endViewTarget();
?>

<div class="publications-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="publications-item publications-item-1" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="publications-item-img">
                <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT'];?>">
            </div>
            <div class="publications-item-text">
                <h3><?php echo $arItem['NAME'];?></h3>
                <p><?php echo $arItem['~PREVIEW_TEXT'];?></p>
                <div class="publications-item-text-info">
                    <span><?php echo getMessage('NL_PUBLISHED');?>:</span>
                    <b><?php echo $arItem['DISPLAY_ACTIVE_FROM'];?></b>
                </div>
            </div>
        </a>
        <?php
    }
    ?>
</div>

<?php
if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
    echo $arResult['NAV_STRING'];
}
?>