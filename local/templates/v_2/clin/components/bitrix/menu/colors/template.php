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
    <div class="colors">
        <?php
        foreach ($arResult as $arItem) {
            ?>
            <button class="<?php echo $arItem['PARAMS']['class']; echo $arItem['SELECTED'] ? ' active' : '';?>" data-value="<?php echo $arItem['PARAMS']['value'];?>"><?php echo getMessage($arItem['PARAMS']['msg_code']);?></button>
            <?php
        }
        ?>
    </div>
    <?php
}
?>