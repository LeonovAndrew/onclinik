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
<a href="<?php echo $arResult['all_link'];?>"><?php echo $arParams['TITLE'];?></a>
<?php
if (!$arResult['use_tabs']) {
    if (!empty($arResult['tabs'])) {
        ?>
        <div class="submenu-container">
            <ul class="submenu">
                <?php
                foreach ($arResult['tabs'] as $arTab) {
                    foreach ($arTab['items'] as $arItem) {
                    ?>
                        <li>
                            <a <?if ( $arItem['PARAMS']['open'] ):?>target="<?=$arItem['PARAMS']['open']?>"<?endif;?> href="<?php echo $arItem['LINK'];?>"><?php echo $arItem['TEXT'];?></a>
                        </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
        <?php
    }
} else {
    ?>
    <div class="submenu-container tabs_container">
        <?php
        if (count($arResult['tabs']) > 1) {
            ?>
            <ul class="submenu_tab_list tab_listAll">
                <?php
                $k = 0;
                foreach ($arResult['tabs'] as $tabName => $arTab) {
                    ?>
                    <li>
                        <a <?php echo $k == 0 ? 'class="active"' : '';?> href="#<?php echo $arResult['id'] . '-' . $k++;?>"><?php echo $tabName;?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }

        $k = 0;
        foreach ($arResult['tabs'] as $arTab) {
            ?>
            <div <?php echo $k != 0 ? 'style="display:none" ' : '';?>class="submenu-tab-wrap block_content" id="<?php echo $arResult['id'] . '-' . $k++;?>">
                <ul class="submenu">
                    <?php
                    foreach ($arTab['items'] as $arItem) {
                        ?>
                        <li>
                            <a <?if ( $arItem['PARAMS']['open'] ):?>target="<?=$arItem['PARAMS']['open']?>"<?endif;?> href="<?php echo $arItem['LINK'];?>"><?php echo $arItem['TEXT'];?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                if (!empty($arResult['all_link']) && !empty($arResult['all_title'])) {
                    ?>
                    <div class="banner-link-wrap1">
                        <a href="<?php echo $arResult['all_link'];?>"><?php echo $arResult['all_title'];?></a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>

