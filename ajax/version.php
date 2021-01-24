<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
    Bitrix\Main\Web\Uri,
    MWI\Version;

//Version::update();	
	
	
$request = Application::getInstance()->getContext()->getRequest();

$action = $request->getPost('action');

switch ($action) {
    case ('update') :
        Version::update();

        break;

    case ('toggle') :
        Version::toggle();

        break;
}

echo json_encode(
    [
        'success' => true,
        'action' => $action,
    ]
);
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");