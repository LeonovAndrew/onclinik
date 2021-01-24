<?php
use \Bitrix\Main\EventManager as EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    '',
    'AlphabetOnBeforeAdd',
    array(
        'MWI\Alphabet',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'AlphabetOnBeforeUpdate',
    array(
        'MWI\Alphabet',
        'clearTaggedCache'
    )
);

$eventManager->addEventHandler(
    '',
    'AlphabetOnBeforeDelete',
    array(
        'MWI\Alphabet',
        'clearTaggedCache'
    )
);