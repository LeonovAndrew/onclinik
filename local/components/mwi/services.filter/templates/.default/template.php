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

<form action="#" class="costsection-form">
    <div class="costsection-radio-wrap">
        <?php
        foreach ($arResult['departments'] as $arDepartment) {
            ?>
            <label class="costsection-label">
                <input<?php echo $arDepartment['SELECTED'] ? ' checked' : '';?> type="radio" value="<?php echo $arDepartment['XML_ID'];?>" name="department">
                <span><?php echo $arDepartment['NAME'];?></span>
            </label>
            <?php
        }
        ?>
    </div>
    <div class="costsection-select-wrap">
        <div class="costsection-select">
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
    </div>
    <div class="costsection-search-wrap search__inner">
        <input type="search" autocomplete="off" placeholder="<?php echo getMessage('SEARCH_PLACEHOLDER');?>" name="search" id="servicesSearch" value="<?php echo $arResult['search_query'];?>">
        <i class="clean_search">+</i>
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

<script>
    var searchHints = <?php echo json_encode($arResult['search_hints']);?>;
</script>
