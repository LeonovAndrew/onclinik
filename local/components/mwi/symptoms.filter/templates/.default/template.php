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


<form class="directory-filter">
    <ul class="tab_list">
        <li>
            <a class="active" href="#directory-tab2"><?php echo getMessage('BY_REGIONS');?></a>
        </li>
        <li>
            <a href="#directory-tab1"><?php echo getMessage('ALPHABETICALLY');?></a>
        </li>
    </ul>
    <div class="directory-input-wrap search__inner">
        <input name="search" type="text" id="symptomSearch" placeholder="<?php echo getMessage('SEARCH_PLACEHOLDER');?>" autocomplete="off" value="<?php echo $arResult['search_query'];?>">
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
    var hintsSymptoms = <?php echo json_encode($arResult['hints_symptoms']);?>;
</script>
