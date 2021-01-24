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
if (!empty($arResult['sections'])) {
    if (!empty($arParams['TITLE'])) {
        ?>
        <h3><?php echo $arParams['TITLE'];?></h3>
        <?php
    }

    foreach ($arResult['sections'] as $arSection) {
        ?>
        <ul class="main-footer-list">
            <?php
            foreach ($arSection['items'] as $arItem) {
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
}
?>

