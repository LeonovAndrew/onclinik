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
?>
<?php
$isAjax = !empty($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
?>
	<?if ( !$isAjax ):?>
		<h3><?php echo getMessage('NL_DIRECTIONS_TITLE');?></h3>
	<?endif;?>
	<ul class="costsection-list2">
		<?php
		foreach ($arResult['ITEMS'] as $arItem) {
			?>
			<li>
				<a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="direction-item"><?php echo $arItem['NAME'];?></a>
			</li>
			<?php
		}

		//TODO: move it to db
		?>

	</ul>
	
<?php
if ($arParams["PAGER_TEMPLATE"] == 'direction' ) {
    echo $arResult['NAV_STRING'];
}
?>	
	
