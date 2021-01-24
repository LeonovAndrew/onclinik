<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Стоимость услуг гинеколога в Москве");
$APPLICATION->SetPageProperty("title", "Прием гинеколога - стоимость услуг гинеколога в Москве в ОН КЛИНИК");

use Bitrix\Main\Loader,
    Bitrix\Main\Application,
    MWI\Direction,
    MWI\Service,
    MWI\Personal,
    MWI\Disease,
    MWI\Symptom,
    MWI\Program,
    MWI\Clinic;

CModule::includeModule('iblock');


$request = Application::getInstance()->getContext()->getRequest();

$code = $request->get('CODE');
$pos = strpos($code, '?');
if ($pos !== false) {
    $code = substr($code, 0, $pos);
    $_REQUEST['CODE'] = $code;
}
$params = $request->get('PARAMS');
$pos = strpos($params, '?');
if ($pos !== false) {
    $params = substr($params, 0, $pos);
    $_REQUEST['PARAMS'] = $params;
}

$arItem = CIBlockElement::getList(
    array(),
    array(
        'CODE' => $code,
        'ACTIVE' => 'Y',
		'SITE_ID' => 's2'
    ),
    false,
    array(
        'nTopCount' => 1,
    ),
    array(
        'IBLOCK_ID',
    )
)->fetch();




if ($arItem['IBLOCK_ID'] == Service::getIBlockId() && empty($params)) {
	
	
	$APPLICATION->includeFile(
        SITE_DIR . "/services/service/index.php",
        [

        ],
        [
            "MODE" => "html",
            "NAME" => "",
        ]
    );
} else if ($arItem['IBLOCK_ID'] == Direction::getIBlockId()) {
    
	$APPLICATION->includeFile(
        SITE_DIR . "/services/directions/index.php",
        [

        ],
        [
            "MODE" => "html",
            "NAME" => "",
        ]
    );
} else if ($arItem['IBLOCK_ID'] == Disease::getIblockId() && empty($params)) {
   $APPLICATION->includeFile(
        SITE_DIR . "/diseases/index.php",
        [

        ],
        [
            "MODE" => "html",
            "NAME" => "",
        ]
    );
} else if ($arItem['IBLOCK_ID'] == Symptom::getIblockId() && empty($params)) {
    $APPLICATION->includeFile(
        SITE_DIR . "/symptoms/index.php",
        [

        ],
        [
            "MODE" => "html",
            "NAME" => "",
        ]
    );
} else if ($arItem['IBLOCK_ID'] == Program::getIblockId() && empty($params)) {
    $APPLICATION->includeFile(
        SITE_DIR . "/programs/index.php",
        [

        ],
        [
            "MODE" => "html",
            "NAME" => "",
        ]
    );
} else if ($arItem['IBLOCK_ID'] == Clinic::getIblockId() && empty($params)) {
    $APPLICATION->includeFile(
        SITE_DIR . "/clinics/index.php",
        [

        ],
        [
            "MODE" => "html",
            "NAME" => "",
        ]
    );
} else if ($arItem['IBLOCK_ID'] == Personal::getIBlockId() && empty($params)) {
    $arPersonal = CIBlockElement::getList(
        array(),
        array(
            'CODE' => $code
        ),
        false,
        array(
            'nTopCount' => 1,
        ),
        array(
            'PROPERTY_ADMINISTRATOR',
        )
    )->fetch();
    if ($arPersonal['PROPERTY_ADMINISTRATOR_VALUE']) {
        $APPLICATION->includeFile(
            SITE_DIR . "/about/administration/index.php",
            array(

            ),
            array(
                "MODE" => "html",
                "NAME" => "",
            )
        );
    } else {
        $APPLICATION->includeFile(
            SITE_DIR . "/doctors/index.php",
            array(

            ),
            array(
                "MODE" => "html",
                "NAME" => "",
            )
        );
    }
} else {
    $APPLICATION->includeFile(
        SITE_DIR . "/404.php",
        array(

        ),
        array(
            "MODE" => "html",
            "NAME" => "",
        )
    );
}

