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
<b>Наши сайты</b>
<ul style="display: none;" class="main-header-link1-list">
    <?php
    foreach ($arResult as $arItem) {
        ?>
        <li>
            <?php
            if ($arItem['SELECTED']) {
                echo $arItem['TEXT'];
            } else {
                ?>
                <a target="_blank" href="<?php echo $arItem['LINK']?>"><?php echo $arItem['TEXT']?></a>
                <?php
            }
            ?>
        </li>
        <?php
    }
    ?>
</ul>
