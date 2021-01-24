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
$arSizes = Version::getSizes();

foreach ($arSizes as $size) {
    $uri = new Uri($uriString);
    $uri->addParams(
        array(
            'size' => $size['value']
        )
    );
    $aMenuLinksExt[] = array(
        '',
        $uri,
        array(),
        array(
            'class' => $size['class'],
            'value' => $size['value'],
            'msg_code' => $size['msg_code'],
        ),
        ''
    );
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
