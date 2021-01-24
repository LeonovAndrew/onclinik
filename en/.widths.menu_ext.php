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
$arWidths = Version::getWidths();

foreach ($arWidths as $width) {
    $uri = new Uri($uriString);
    $uri->addParams(
        array(
            'width' => $width['value'],
        )
    );
    $aMenuLinksExt[] = array(
        '',
        $uri,
        array(),
        array(
            'class' => $width['class'],
            'value' => $width['value'],
            'msg_code' => $width['msg_code'],
        ),
        ''
    );
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
