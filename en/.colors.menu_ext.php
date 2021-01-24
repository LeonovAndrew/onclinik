<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Web\Uri,
    MWI\Version;

$request = Application::getInstance()->getContext()->getRequest();
$uriString = $request->getRequestUri();

$aMenuLinksExt = array();
$arColors = Version::getColors();

foreach ($arColors as $color) {
    $uri = new Uri($uriString);
    $uri->addParams(
        array(
            'color' => $color['value'],
        )
    );
    $aMenuLinksExt[] = array(
        '',
        $uri,
        array(),
        array(
            'class' => $color['class'],
            'value' => $color['value'],
            'msg_code' => $color['msg_code'],
        ),
        ''
    );
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
