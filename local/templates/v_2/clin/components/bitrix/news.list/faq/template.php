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

<div class="faq-list" id="ajax-items-list">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        ?>
        <div class="faq-item ajax-item">
            <div class="open_toggle"><?php echo $arItem['~PREVIEW_TEXT'];?></div>
            <div class="block_toggle" style="display:none">
                <?php echo $arItem['~DETAIL_TEXT'];?>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
echo $arResult['NAV_STRING'];
?>
