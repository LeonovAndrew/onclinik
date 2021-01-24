<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */
?>

<?php
if (!empty($arResult)) {
    ?>
    <div class="main-footer-versions-list">
        <?php
        foreach ($arResult as $arItem) {
            ?>
            <div class="width main-footer-versions-item <?php echo $arItem['PARAMS']['class'];?>">
                <button class="<?php echo $arItem['SELECTED'] ? ' active' : '';?>" data-value="<?php echo $arItem['PARAMS']['value'];?>"><?php echo getMessage($arItem['PARAMS']['msg_code']);?></button>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>