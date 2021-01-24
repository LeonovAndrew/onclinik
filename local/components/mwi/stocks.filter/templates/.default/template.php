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

<form class="stock-filter">
    <div class="stock-radio-wrap">
        <?php
        foreach ($arResult['departments'] as $arDepartment) {
            ?>
            <label>
                <input <?php if ($arDepartment['SELECTED']) {?> checked<?php }?> value="<?php echo $arDepartment['XML_ID'];?>" type="radio" name="department">
                <span><?php echo $arDepartment['NAME'];?></span>
            </label>
            <?php
        }
        ?>
    </div>
    <div class="stock-select-wrap stock-select-wrap1">
        <select name="direction" id="directionSelect">
            <?php
            foreach ($arResult['directions'] as $arDirection) {
                ?>
                <option <?php if ($arDirection['SELECTED']) {?> selected<?php }?> value="<?php echo $arDirection['ID'];?>"><?php echo $arDirection['NAME'];?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="stock-select-wrap stock-select-wrap2">
        <select name="clinics" id="clinicSelect">
            <?php
            foreach ($arResult['clinics'] as $arClinic) {
                ?>
                <option <?php if ($arClinic['SELECTED']) {?> selected<?php }?> value="<?php echo $arClinic['ID'];?>"><?php echo $arClinic['NAME'];?></option>
                <?php
            }
            ?>
        </select>
    </div>
</form>

<?php
if (!$arResult['ajax_mode']) {
    ?>
    <script>
        let ajaxPath = <?php echo json_encode($arResult['ajax_path']);?>;
    </script>
    <?php
}
?>