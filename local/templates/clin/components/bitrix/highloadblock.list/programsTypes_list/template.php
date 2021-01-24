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
?>

<div class="costsection-select">
    <select name="programType" id="programTypeSelect">
        <?php
        foreach ($arResult['rows'] as $arItem) {
            ?>
            <option<?php if ($arItem['SELECTED']) {?> selected<?php }?> value="<?php echo $arItem['UF_XML_ID'];?>"><?php echo $arItem['UF_NAME'];?></option>
            <?php
        }
        ?>
    </select>
</div>
