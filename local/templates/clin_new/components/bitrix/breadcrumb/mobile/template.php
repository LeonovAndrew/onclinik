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

$strReturn .= '<div class="breadcrumbs-wrap breadcrumbs-wrap-mobile">';
$strReturn .= '<ul class="breadcrumbs-list">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if ($arResult[$index]["LINK"] <> "" && $index != $itemSize-1) {
		if (!$index) {
			$strReturn .= '
				<li>
					<a href="/">
						<img src="' . SITE_TEMPLATE_PATH . '/assets/img/home-icon.svg" alt="">
					</a>
					
				</li>
			';
		} else {
			$strReturn .= '
				<li id="bx_breadcrumb_'.$index.'">
					<a href="' . $arResult[$index]["LINK"] . '" title="' . $title . '"">
						<span>' . $title . '</span>
					</a>
					
				</li>
			';
		}
	} else {
		$strReturn .= '
			<li >
				<span>' . $title . '</span>
			</li>';
	}
}

$strReturn .= '</ul></div>';

return $strReturn;
