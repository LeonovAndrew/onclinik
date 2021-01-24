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

<div class="reviews-list" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        ?>
        <div class="reviews-item readmore ajax-item">
            <div class="reviews-item-text1">
                <span><?php echo $arItem['PROPERTIES']['PATIENT_NAME']['VALUE'];?></span>
                <b><?php echo $arItem['DISPLAY_ACTIVE_FROM'];?></b>
            </div>
            <div class="reviews-item-text2">
                <p><?php echo $arItem['~DETAIL_TEXT'];?></p>
                <ul class="reviews-list2">
                    <li class="reviews-item2 reviews-item21"><?php echo $arItem['DOCTOR']->name;?></li>
                    <li class="reviews-item2 reviews-item22"><?php echo $arItem['CLINIC']->name;?></li>
                </ul>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
$this->setViewTarget('pagination');
    echo $arResult['NAV_STRING'];
    echo $arResult['NAV_STRING_BOTTOM'];
$this->endViewTarget();
?>