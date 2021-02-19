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

$nPageWindow = 1; //количество отображаемых страниц
if ($arResult["NavPageNomer"] > floor($nPageWindow/2) + 1 && $arResult["NavPageCount"] > $nPageWindow) {
    $nStartPage = $arResult["NavPageNomer"] - floor($nPageWindow / 2);
} else {
    $nStartPage = 1;
}
if ($arResult["NavPageNomer"] <= $arResult["NavPageCount"] - floor($nPageWindow/2) && $nStartPage + $nPageWindow-1 <= $arResult["NavPageCount"]) {
    $nEndPage = $nStartPage + $nPageWindow - 1;
} else {
    $nEndPage = $arResult["NavPageCount"];
    if ($nEndPage - $nPageWindow + 1 >= 1) {
        $nStartPage = $nEndPage - $nPageWindow + 1;
    }
}
$arResult["nStartPage"] = $arResult["nStartPage"] = $nStartPage;
$arResult["nEndPage"] = $arResult["nEndPage"] = $nEndPage;

if ($arResult["NavPageCount"] > 1) {
    if ($arResult["NavPageNomer"]+1 <= $arResult["NavPageCount"]) {
        $plus = $arResult["NavPageNomer"] + 1;
        $url = $arResult["sUrlPathParams"] . "PAGEN_" . $arResult["NavNum"] . "=" . $plus . '&ajax=Y';
        ?>

        <div class="reviews-wrap-btn1 more_all">
            <span class="btn2 administration-btn load_more" data-url="<?php echo $url;?>"><?php echo getMessage('nav_sm_more');?></span>
        </div>
        <?php
    }
}
?>