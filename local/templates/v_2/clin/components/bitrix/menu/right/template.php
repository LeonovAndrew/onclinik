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

<ul class="service1-list2">
    <?php
    foreach ($arResult as $arItem) {
        ?>
        <li>
            <?php
            if ($arItem['SELECTED']) {
                echo $arItem['TEXT'];
            } else {
                ?>
                <a href="<?php echo $arItem['LINK']?>"><?php echo $arItem['TEXT']?></a>
                <?php
            }
            ?>
        </li>
        <?php
    }
    ?>
</ul>
