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

<div class="program-list-wrap">
    <h2><?php echo getMessage('OTHER_PROGRAMS_TITLE');?></h2>
    <div class="program-list">
        <?php
        foreach ($arResult['ITEMS'] as $arItem) {
            ?>
            <div class="program-item">
                <h3><?php echo $arItem['NAME'];?></h3>
                <p><?php echo $arItem['PREVIEW_TEXT'];?></p>
                <div class="program-item-btn-wrap">
                    <span><?php echo $arItem['DISPLAY_PROPERTIES']['TYPE']['DISPLAY_VALUE'];?></span>
                    <div class="program-item-btn">
                        <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>"><?php echo getMessage('LEARN_MORE');?></a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>