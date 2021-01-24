<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'CitiesOnBeforeAdd',
    array(
        'MWI\Cities',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'CitiesOnBeforeUpdate',
    array(
        'MWI\Cities',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'CitiesOnBeforeDelete',
    array(
        'MWI\Cities',
        'clearTaggedCache'
    )
);