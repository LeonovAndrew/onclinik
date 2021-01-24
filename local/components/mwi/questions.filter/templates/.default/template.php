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

<form class="questions-filter">
    <div class="questions-select-wrap">
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
    <div class="questions-input-wrap search__inner">
        <input type="text" placeholder="<?php echo getMessage('SEARCH_PLACEHOLDER');?>" name="name" id="questionSearch" value="<?php echo $arResult['search_query'];?>">
        <button type="submit"><?php echo getMessage('SEARCH');?></button>
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