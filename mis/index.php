<?php
use Bitrix\Main;
use Bitrix\Main\Application;
use \Bitrix\Main\Localization\Loc as Loc;
use \Bitrix\Main\Data\Cache;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/prolog.php");

Loc::loadMessages(__FILE__);

if (!Main\Loader::includeModule('iblock')) {
    die('Module `iblock` is not installed');
}

CJSCore::Init(array('jquery'));
$APPLICATION->SetTitle('Обработчик цен');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php"); ?>
    <div>
        Процесс следует выполнять последовательно по пунктам.
    </div>
    <div>
        В конце каждого из процессов появится инфомация о том, что процесс закончен ("Элементы удалены" / "Синхронизация удалена" / "Синхронизация выполнена" / "Выгрузка окончена").
    </div>
    <div>
        Только после этого следует переходить к следующему пункту.
    </div>
    <br>
    <div>
        <b>Пункт 1</b> производит удаление всех элементов из инфоблока цен для исключения конфликтных ситуаций.
    </div>
   
    <div>
        <b>Пункт 2</b> производит выгрузку цен из базы данных МИС и создает новые элементы инфоблока цен.
    </div>
    <div>
        <b>Пункт 3</b> производит добавление элементам инфоблока услуг привязку к элементам инфоблока цен.
    </div>
    <br>
    <div class="warning">
        Пункт <b>3</b> выполняются в несколько этапов для меньшей нагрузки на базу данных.
    </div>

    <ul class="pdo_ul">
        <li>
            <input type=button value="Начать удаление цен" id="del_start"/>
            <input type=button value="Удалить следующий пакет цен" id="del_continue"/>
            <div class="pdo_del_price"><span id="result_del"></span></div>
        </li>
		<?/*
		<li>
            <input type=button value="Удалить синхронизацию инфоблоков с ценами" id="del_synchr"/>
            <div class="pdo_del_synchr"><span id="result_del_synchr"></span></div>
        </li>
		*/?>
        <li>
            <input type=button value="Cтарт обмена" id="price_start"/>
            <input type=button value="Выгрузить следующий пакет элементов" id="price_continue"/>
            <div class="pdo_add_price"><span id="result"></span></div>
        </li>

        <li>
            <input type=button value="Cтарт синхронизации с инфоблоками" id="synchr_start"/>
            <div><span id="result2"></span></div>
        </li>
    </ul>
    <div id="loading">
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");