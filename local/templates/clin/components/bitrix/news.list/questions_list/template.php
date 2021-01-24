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

<?php
if (!empty($arResult['ITEMS'])) {
    ?>
    <div class="health-question">
        <h2><?php echo getMessage('QUESTIONS_TITLE');?></h2>

        <div class="health-question-list">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="questions-item" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                    <h3>
                        <i><?php echo $arItem['PROPERTIES']['PATIENT_NAME']['VALUE'];?></i>
                        <b><?php echo $arItem['DISPLAY_ACTIVE_FROM'];?></b>
                    </h3>
                    <span><?php echo $arItem['PROPERTIES']['QUESTION']['~VALUE']['TEXT'];?></span>
                    <p><?php echo $arItem['PROPERTIES']['ANSWER']['~VALUE']['TEXT'];?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="health-link-wrap">
            <a href="/health/questions/"><?php echo getMessage('ALL_QUESTIONS');?></a>
        </div>
    </div>
    <?php
}
?>
