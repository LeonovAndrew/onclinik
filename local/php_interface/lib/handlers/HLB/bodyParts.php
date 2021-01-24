<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'BodyPartsOnBeforeAdd',
    array(
        'MWI\BodyParts',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'BodyPartsOnBeforeUpdate',
    array(
        'MWI\BodyParts',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'BodyPartsOnBeforeDelete',
    array(
        'MWI\BodyParts',
        'clearTaggedCache'
    )
);