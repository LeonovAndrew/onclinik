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

<?if ( $arResult['PROPERTIES']['H1']['~VALUE'] ):?>
	<h1><?php echo $arResult['PROPERTIES']['H1']['~VALUE'];?></h1>
<?endif;?>
<div class="vacancy-list1">
    <?php
    if (!empty($arResult['PROPERTIES']['DUTIES']['VALUE'])) {
        ?>
        <div class="vacancy-item">
            <h2><?php echo getMessage("ND_VACANCY_DUTIES_TITLE");?>:</h2>
            <?php echo $arResult['PROPERTIES']['DUTIES']['~VALUE']['TEXT'];?>
        </div>
        <?php
    }

    if (!empty($arResult['PROPERTIES']['REQUIREMENTS']['VALUE'])) {
        ?>
        <div class="vacancy-item">
            <h2><?php echo getMessage("ND_VACANCY_REQUIREMENTS_TITLE");?>:</h2>
            <?php echo $arResult['PROPERTIES']['REQUIREMENTS']['~VALUE']['TEXT'];?>
        </div>
        <?php
    }

    if (!empty($arResult['PROPERTIES']['CONDITIONS']['VALUE'])) {
        ?>
        <div class="vacancy-item">
            <h2><?php echo getMessage("ND_VACANCY_CONDITIONS_TITLE");?>:</h2>
            <?php echo $arResult['PROPERTIES']['CONDITIONS']['~VALUE']['TEXT'];?>
        </div>
        <?php
    }
    ?>
</div>
<div class="vacancy-list2">
    <?php
    if (!empty($arResult['PROPERTIES']['FULL_NAME']['VALUE'])) {
        ?>
        <div class="vacancy-item2 vacancy-item21">
            <p>
                <span><?php echo getMessage("ND_VACANCY_FULL_NAME_TITLE");?>:</span>
                <b><?php echo $arResult['PROPERTIES']['FULL_NAME']['VALUE'];?></b>
            </p>
        </div>
        <?php
    }

    if (!empty($arResult['PROPERTIES']['PHONE']['VALUE'])) {
        ?>
        <div class="vacancy-item2 vacancy-item22">
            <p>
                <span><?php echo getMessage("ND_VACANCY_PHONE_TITLE");?>:</span>
                <a href="tel:<?php echo getNumericalPhone($arResult['PROPERTIES']['PHONE']['VALUE']);?>">
                    <?php echo $arResult['PROPERTIES']['PHONE']['VALUE'];?><?php if (!empty($arResult['PROPERTIES']['PHONE_ADDITIONAL']['VALUE'])) {?> (доб. <?php echo $arResult['PROPERTIES']['PHONE_ADDITIONAL']['VALUE'];?>)<?php }?>
                </a>
            </p>
        </div>
        <?php
    }

    if (!empty($arResult['PROPERTIES']['EMAIL']['VALUE'])) {
        ?>
        <div class="vacancy-item2 vacancy-item23">
            <p>
                <span><?php echo getMessage("ND_VACANCY_EMAIL_TITLE");?>:</span>
                <a href="mailto:<?php echo $arResult['PROPERTIES']['EMAIL']['VALUE'];?>"><?php echo $arResult['PROPERTIES']['EMAIL']['VALUE'];?></a>
            </p>
        </div>
        <?php
    }
    ?>
</div>
