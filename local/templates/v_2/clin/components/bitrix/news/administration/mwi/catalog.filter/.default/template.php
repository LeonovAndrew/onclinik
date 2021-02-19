<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
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

<div class="administration-filter">
    <form id="<?echo $arResult["FILTER_NAME"] . "_form"?>" class="administration-select-wrap" name="<?echo $arResult["FILTER_NAME"] . "_form"?>" action="<?echo $arResult["FORM_ACTION"];?>" method="get">
        <?php
        foreach ($arResult['ITEMS'] as $arProp) {
            if (array_key_exists("HIDDEN", $arProp)) {
                echo $arProp["INPUT"];
            }

            if ($arProp['TYPE'] == 'SELECT') {
                ?>
                <select name="<?php echo $arProp['INPUT_NAME'];?>">
                    <?php
                    foreach ($arProp['LIST'] as $val => $name) {
                        ?>
                        <option<?php if ($arProp['INPUT_VALUE'] == $val) { echo ' disabled selected'; }?> value="<?php echo $val;?>"><?php echo $name;?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php
            }
        }
        ?>
        <input type="hidden" name="set_filter" value="Y" />
    </form>
</div>

<script>
    var adminFilterSelector = "#<?php echo $arResult["FILTER_NAME"] . "_form"?>";
</script>