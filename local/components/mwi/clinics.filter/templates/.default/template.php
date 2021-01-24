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

<form action="#" class="clinics-filter">
    <div class="clinics-filter-radio-wrap">
        <?php
        foreach ($arResult['cities'] as $arCity) {
            ?>
            <label>
                <input <?php echo $arCity['SELECTED'] ? 'checked' : '';?> value="<?php echo $arCity['XML_ID'];?>" type="radio" name="city">
                <span><?php echo $arCity['NAME'];?></span>
            </label>
            <?php
        }
        ?>
    </div>
    <div class="clinics-filter-select-wrap" id="clinicsTypeSelectWrap">
        <select name="clinics" id="clinicsTypeSelect">
            <?php
            foreach ($arResult['clinics_types'] as $arType) {
                ?>
                <option <?php echo $arType['SELECTED'] ? 'selected' : '';?> value="<?php echo $arType['XML_ID'];?>"><?php echo $arType['NAME'];?></option>
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