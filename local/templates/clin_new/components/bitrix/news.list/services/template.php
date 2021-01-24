<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
$isAjax = !empty($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
?>
	<?if ( !$isAjax ):?>
		<h3><?php echo getMessage('NL_SERVICES_TITLE');?></h3>
	<?endif;?>

<?php
foreach ($arResult['TABLE'] as $arTable) {
    ?>
    <ul class="costsection-list2">
        <?php
        foreach ($arTable['ITEMS'] as $arItem) {
            ?>
            <li>
                <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>"><?php echo $arItem['NAME'];?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
}
?>

<?php
if ($arParams["PAGER_TEMPLATE"] == 'direction' ) {
    echo $arResult['NAV_STRING'];
}
?>
