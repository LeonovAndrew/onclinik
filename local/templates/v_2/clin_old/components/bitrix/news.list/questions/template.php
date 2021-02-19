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

$this->setFrameMode(true);
?>

<div class="questions-list" id="ajax-items-list">
    <?php
    if (empty($arResult['ITEMS'])) {
        ?>
        <div class="questions-item ajax-item">
            <p><?php echo getMessage('SEARCH_EMPTY');?></p>
        </div>
        <?php
    } else {
        foreach ($arResult['ITEMS'] as $arItem) {
            ?>
            <div class="questions-item ajax-item">
                <h3>
                    <i><?php echo $arItem['PROPERTIES']['PATIENT_NAME']['VALUE']; ?></i>
                    <b><?php echo $arItem['DISPLAY_ACTIVE_FROM']; ?></b>
                </h3>
                <span><?php echo $arItem['PROPERTIES']['QUESTION']['VALUE']['TEXT']; ?></span>
                <p><?php echo $arItem['PROPERTIES']['ANSWER']['~VALUE']['TEXT']; ?></p>
            </div>
            <?php
        }
    }
    ?>
</div>

<?php
$this->setViewTarget('pagination');
    echo $arResult['NAV_STRING'];
    echo $arResult['NAV_STRING_BOTTOM'];
$this->endViewTarget();
?>