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

<div class="partnership-list">
    <?php
    foreach ($arResult['ITEMS'] as $key => $arItem) {
        ?>
        <div class="partnership-item partnership-item-<?php echo $key + 1;?>">
            <h3><?php echo $arItem['NAME'];?></h3>
            <div class="partnership-img">
                <img src="<?php echo $arItem['PICTURE']['SRC'];?>" alt="<?php echo $arItem['PICTURE']['ALT'];?>">
            </div>
            <div class="partnership-btn-wrap">
                <a href="<?php echo $arItem['LIST_PAGE_URL'];?>" class="btn3"><?php echo getMessage('DETAILS_BTN');?></a>
            </div>
        </div>
        <?php
    }
    ?>
</div>