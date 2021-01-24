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

<form class="videos-filter">
    <div class="videos-filter-radio-wrap">
        <?php
        foreach ($arResult['types'] as $arType) {
            ?>
            <label>
                <input<?php if ($arType['SELECTED']) {?> checked<?php }?> value="<?php echo $arType['XML_ID'];?>" type="radio" name="type">
                <span><?php echo $arType['NAME'];?></span>
            </label>
            <?php
        }
        ?>
    </div>
    <div class="videos-filter-select-wrap">
        <select name="direction" id="directionSelect">
            <?php
            foreach ($arResult['directions'] as $arDirection) {
                ?>
                <option<?php if ($arDirection['SELECTED']) {?> selected<?php }?> value="<?php echo $arDirection['ID'];?>"><?php echo $arDirection['NAME'];?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="videos-filter-select-wrap">
        <select name="clinics" id="clinicSelect">
            <?php
            foreach ($arResult['clinics'] as $arClinic) {
                ?>
                <option<?php if ($arClinic['SELECTED']) {?> selected<?php }?> value="<?php echo $arClinic['ID'];?>"><?php echo $arClinic['NAME'];?></option>
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