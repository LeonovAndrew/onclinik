<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    array(
        'CustomTypeMenu',
        'GetUserTypeDescription'
    )
);
