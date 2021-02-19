<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult)) {
    return "";
}

$strReturn = '';

$strReturn .= '<div class="breadcrumbs-wrap" itemscope="" itemtype="https://schema.org/BreadcrumbList">';
$strReturn .= '<ul class="breadcrumbs-list">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if ($arResult[$index]["LINK"] <> "" && $index != $itemSize-1) {
		if (!$index) {
			$strReturn .= '
				<li itemscope="" itemprop="itemListElement" itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="/">
							<img src="' . SITE_TEMPLATE_PATH . '/assets/img/home-icon.svg" alt="Главная" title="Главная">
							<meta itemprop="name" content="Главная">
							<meta itemprop="position" content="0"/>
						</a>
						
					
				</li>
			';
		} else {
			$strReturn .= '
				<li id="bx_breadcrumb_'.$index.'" itemscope="" itemprop="itemListElement" itemtype="https://schema.org/ListItem">
					
						<a  href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" itemprop="item">
							<span itemprop="name">' . $title . '</span>
							<meta itemprop="position" content="' . $index . '"/>
						</a>
					
				</li>
			';
		}
	} else {
		$strReturn .= '
			<li itemscope="" itemprop="itemListElement" itemtype="https://schema.org/ListItem">
				
					<meta itemprop="url" content="'. $arResult[$index]["LINK"] . '">
					<span itemprop="name">' . $title . '</span>
					<meta itemprop="position" content="' . $index . '"/>
				
			</li>';
	}
}

$strReturn .= '</ul></div>';

return $strReturn;
