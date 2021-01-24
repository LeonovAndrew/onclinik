<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
    Bitrix\Main\Web\Uri,
    Bitrix\Main\Loader,
    MWI\Clinic;

$request = Application::getInstance()->getContext()->getRequest();

$clinicId = intVal($request->getPost('clinicId'));

if ($clinicId) {
    Loader::IncludeModule('iblock');

    /**
     * cache params
     */
    $cacheTtl = 360000;
    $obCache = new CPHPCache();
    $cacheId = '/MWI/Clinic_' . 'CId=' . $clinicId . '_tour';
    $cachePath = '/clinics/';

    if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
        /**
         * cache is exist
         */

        /**
         * get data from cache
         */
        $vars = $obCache->GetVars();
        $arClinic = $vars['clinic'];
    } else {
        /**
         * start buffering the output
         */
        $obCache->startDataCache();

        /**
         * get data from database
         */
        $arClinic = CIBlockElement::getList(
            [],
            [
                'IBLOCK_ID' => Clinic::getIBlockId(),
                'ACTIVE'    => 'Y',
                'ID'        => $clinicId,
            ],
            false,
            [
                'nTopCount' => 1,
            ],
            [
                'PROPERTY_TOUR',
            ]
        )->fetch();

        /**
         * write pre-buffered output to the cache file
         * with additional variables
         */
        $obCache->endDataCache(
            [
                'clinic' => $arClinic,
            ]
        );
    }

    echo json_encode(
        [
            'success' => true,
            'data'    => [
                'tour' => $arClinic['PROPERTY_TOUR_VALUE']['TEXT'],
            ],
        ]
    );
} else {
    echo json_encode(
        [
            'success' => false,
            'errors'  => [
                'Неверный ID клиники',
            ],
        ]
    );
}