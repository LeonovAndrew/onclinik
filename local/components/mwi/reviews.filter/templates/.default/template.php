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
<div class="reviews-select-wrap" id="directionSelectWrap">
    <select name="direction" id="directionSelect">
        <?php
        foreach ($arResult['directions'] as $arItem) {
            ?>
            <option<?php if ($arItem['SELECTED']) {?> selected<?php }?> value="<?php echo $arItem['ID'];?>"><?php echo $arItem['NAME'];?></option>
            <?php
        }
        ?>
    </select>
</div>

<div class="reviews-select-wrap" id="clinicSelectWrap">
    <div class="costsection-select">
        <select name="clinic" id="clinicSelect">
            <?php
            foreach ($arResult['clinics'] as $arItem) {
                ?>
                <option<?php if ($arItem['SELECTED']) {?> selected<?php }?> value="<?php echo $arItem['ID'];?>"><?php echo $arItem['NAME'];?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<div class="reviews-input-wrap">
    <label>
        <span class="flex_search search__inner">
            <input type="text" placeholder="<?php echo getMessage('SEARCH_PLACEHOLDER');?>" name="name" id="doctorSearch" autocomplete="off" value="<?php echo $arResult['search_query'];?>">
            <button type="submit"><?php echo getMessage('SEARCH');?></button>
        </span>
    </label>
</div>

<?php
if (!$arResult['ajax_mode']) {
    ?>
    <script>
        let ajaxPath = <?php echo json_encode($arResult['ajax_path']);?>;
    </script>
    <?php
}
?>

<script>
    var hintsDoctorsFilter = <?php echo json_encode($arResult['hints_doctors']);?>;
</script>
