<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);

if (!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
        return;
    }
}
?>

<div class="publications-link-wrap">
    <?php
    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");

    if ($arResult["NavPageNomer"] > 1) {
        $prevDisabled = false;
        if ($arResult['NavPageNomer'] > 2) {
            $sPrevHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] - 1);
        } else {
            $sPrevHref = $arResult["sUrlPath"];
        }
    } else {
        $prevDisabled = true;
    }
    ?>
    <a class="publications-link publications-link-1<?php if ($prevDisabled) {?> arrow-disabled<?php }?>" href="<?php echo $sPrevHref;?>"></a>

    <?php
    if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
        $nextDisabled = false;
        $sNextHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"]+1);
    } else {
        $nextDisabled = true;
    }
    ?>
    <a class="publications-link publications-link-2<?php if ($nextDisabled) {?> arrow-disabled<?php }?>" href="<?php echo $sNextHref;?>"></a>
</div>