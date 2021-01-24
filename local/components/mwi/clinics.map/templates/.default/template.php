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

<section class="map">
    <div class="container">
        <div class="map-container">
            <div class="map-wrap">
                <i class="map-bg"></i>
                <div id="clinics-map"></div>
            </div>
            <div class="map-btn">
                <span><?php echo getMessage('clinics_map_title');?></span>
            </div>
        </div>
    </div>
</section>

<script>
    let features = <?php echo json_encode(
        array(
            'type' => 'FeatureCollection',
            'features' => $arResult['features'],
        )
    );?>;
</script>
