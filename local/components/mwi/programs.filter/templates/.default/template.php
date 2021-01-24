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

<form class="clinics-filter costsection-form" action="#">
    <div class="clinics-filter-radio-wrap">
        <?php
        foreach ($arResult['patients_types'] as $arPatientsType) {
            ?>
            <label>
                <input <?php echo $arPatientsType['SELECTED'] ? 'checked' : '';?> type="radio" value="<?php echo $arPatientsType['XML_ID'];?>" name="patientsType">
                <span><?php echo $arPatientsType['NAME'];?></span>
            </label>
            <?php
        }
        ?>
    </div>
    <div class="clinics-filter-select-wrap">
        <div class="costsection-select">
            <select name="programType" id="programTypeSelect">
                <?php
                foreach ($arResult['programs_types'] as $arProgramsType) {
                    ?>
                    <option <?php echo $arProgramsType['SELECTED'] ? 'selected' : '';?> value="<?php echo $arProgramsType['XML_ID'];?>"><?php echo $arProgramsType['NAME'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
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