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

<div class="costsection-select">
    <select name="clinic" id="clinicSelect">
        <?php
        foreach ($arResult['ITEMS'] as $arItem) {
            ?>
            <option<?php if ($arItem['SELECTED']) {?> selected<?php }?> value="<?php echo $arItem['ID'];?>"><?php echo $arItem['NAME'];?></option>
            <?php
        }
        ?>
    </select>
</div>
