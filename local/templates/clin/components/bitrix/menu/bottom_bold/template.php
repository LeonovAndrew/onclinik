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
    <ul class="main-footer-list1">
        <?php
        foreach ($arResult as $arItem) {
            ?>
            <li>
                <a href="<?php echo $arItem['LINK'];?>"><?php echo $arItem['TEXT'];?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
}
?>

