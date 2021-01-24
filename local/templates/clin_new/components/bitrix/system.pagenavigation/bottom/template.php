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

$arrowPath = $templateFolder . '/images/arrow2.png';
?>

<div class="pagination-wrap">
    <ul class="pagination-list pagination">
        <?php
        /**
         * arrow preview
         */
        if ($arResult["NavPageNomer"] > 1) {
            ?>
            <li>
                <a href="<?php echo $arResult['prev_uri']; ?>">
                    <img src="<?php echo $arrowPath;?>" alt="<?php echo getMessage("nav_sm_prev");?>">
                </a>
            </li>
            <?php
        } else {
            ?>
            <li>
                <a href="#" class="arrow-disabled">
                    <img src="<?php echo $arrowPath;?>" alt="<?php echo getMessage("nav_sm_prev");?>">
                </a>
            </li>
            <?php
        }

        /**
         * pages
         */
        foreach ($arResult['pages'] as $arPage) {
            if ($arPage['active']) {
                ?>
                <li class="active">
                    <a><?php echo $arPage['value']; ?></a>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <a href="<?php echo $arPage['uri']; ?>"><?php echo $arPage['value']; ?></a>
                </li>
                <?php
            }
        }

        /**
         * arrow next
         */
        if ($arResult["NavPageNomer"] < $arResult['NavPageCount']) {
            ?>
            <li>
                <a href="<?php echo $arResult['next_uri']; ?>">
                    <img src="<?php echo $arrowPath;?>" alt="<?php echo getMessage("nav_sm_next");?>">
                </a>
            </li>
            <?php
        } else {
            ?>
            <li>
                <a href="#" class="arrow-disabled">
                    <img src="<?php echo $arrowPath;?>" alt="<?php echo getMessage("nav_sm_next");?>">
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
