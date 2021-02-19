<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
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
<script src="https://api-maps.yandex.ru/2.1/?apikey=870293a8-8ba5-4fd8-9948-dbc7ed29b9a7&lang=ru_RU"></script>
<div class="contact1-map">
    <div class="contact1-text">
        <h3><?php echo $arResult['NAME'];?></h3>
        <ul class="contact1-list2">
            <?php
            if (!empty($arResult['PROPERTIES']['ADDRESS']['~VALUE'])) {
                ?>
                <li>
                    <h4><?php echo getMessage('ND_CONTACTS_ADDRESS');?>:</h4>
                    <span><?php echo $arResult['PROPERTIES']['ADDRESS']['~VALUE'];?></span>
                </li>
                <?php
            }

            if (!empty($arResult['PROPERTIES']['PHONES']['VALUE'])) {
                ?>
                <li>
                    <h4><?php echo getMessage('ND_CONTACTS_PHONE');?>:</h4>
                    <?php
                    foreach ($arResult['PROPERTIES']['PHONES']['VALUE'] as $phone) {
                        ?>
                        <a href="tel:<?php echo getNumericalPhone($phone);?>"><?php echo $phone;?></a>
                        <?php
                    }
                    ?>
                </li>
                <?php
            }

            if (!empty($arResult['PROPERTIES']['WORKING_HOURS']['~VALUE'])) {
                ?>
                <li>
                    <h4><?php echo getMessage('ND_CONTACTS_WORKING_HOURS');?>:</h4>
                    <?php echo $arResult['PROPERTIES']['WORKING_HOURS']['~VALUE'];?>
                </li>
                <?php
            }

            if (!empty($arResult['PROPERTIES']['EMAILS']['VALUE'])) {
                ?>
                <h4><?php echo getMessage('ND_CONTACTS_EMAIL');?>:</h4>
                <?php
                foreach ($arResult['PROPERTIES']['EMAILS']['VALUE'] as $email) {
                    ?>
                    <a href="mailto:<?php echo $email;?>"><?php echo $email;?></a>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
    <div class="contact1-map-wrap">
        <div class="contact1-map-container">
            <div id="<?php echo $arParams['MAP_ID'];?>"></div>
        </div>
        <a class="link" href="<?php echo getMessage('clinics_link');?>"><?php echo getMessage('ND_CONTACTS_CLINICS');?></a>
    </div>
</div>

<?php
$arCoords = explode(',', $arResult['PROPERTIES']['MAP']['VALUE'], 2);
$arMapData = array(
    'mapId' => $arParams['MAP_ID'],
    'params' => array(
        'center' => $arCoords,
        'zoom' => 15,
    ),
    'placemarkParams' => array(
        'coords' => $arCoords,
        'hintContent' => $arResult['NAME'],
    )
);
?>
<script>
    var mapData = <?php echo json_encode($arMapData);?>;
</script>
