<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader,
    MWI\Price,
    MWI\Service,
    MWI\ServiceOffer,
    MWI\Direction,
    MWI\DirectionList;

Loader::includeModule('iblock');

//TODO: add en sync if needed.
$obServices = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID'          => ServiceOffer::getIBlockId(),
        'ACTIVE'             => 'Y',
        '!PROPERTY_MIS_CODE' => false,
    ],
    false,
    [],
    [
        'ID',
        'PROPERTY_MIS_CODE',
    ]
);
$arServices = [];
while ($arService = $obServices->fetch()) {
    if (!empty($arService['PROPERTY_MIS_CODE_VALUE'])) {
        $arServices[$arService['PROPERTY_MIS_CODE_VALUE']] = [
            'id'       => $arService['ID'],
            'mis_code' => $arService['PROPERTY_MIS_CODE_VALUE'],
        ];
    }
}

$obPrices = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => Price::getIBlockId(),
        'ACTIVE'    => 'Y',
    ],
    false,
    [],
    [
        'ID',
        'NAME',
        'PROPERTY_CODE',
        'PROPERTY_PRICE',
        'PROPERTY_PRICEDET',
        'PROPERTY_SPEC',
        'PROPERTY_SPECCODE',
        'PROPERTY_GROUP',
        'PROPERTY_GROUPCODE',
        'PROPERTY_SERVICE',
    ]
);
$arPrices = [];
while ($arPrice = $obPrices->fetch()) {
    $price = intval($arPrice['PROPERTY_PRICE_VALUE']);
    $arPrices[$arPrice['PROPERTY_CODE_VALUE']] = [
        'price' => $price ? $price : intval($arPrice['PROPERTY_PRICEDET_VALUE']),
        'code'  => $arPrice['PROPERTY_CODE_VALUE'],
        'name'  => $arPrice['PROPERTY_SERVICE_VALUE'],
    ];
}

foreach ($arServices as $misCode => $service) {
    if (empty($arPrices[$misCode])) {
        CIBlockElement::Delete($service['id']);
    } else {
        $arProps = [
            'PRICE' => $arPrices[$misCode]['price'],
        ];

        CIBlockElement::SetPropertyValuesEx(
            $service['id'],
            false,
            $arProps
        );
    }

    unset($arPrices[$misCode]);
}

$arService = CIBlockElement::getList(
    [
        'SORT' => 'ASC',
    ],
    [
        'IBLOCK_ID' => Service::getIBlockId(),
        'ACTIVE'    => 'Y',
    ],
    false,
    [
        'nTopCount' => 1,
    ],
    [
        'ID',
    ]
)->fetch();

foreach ($arPrices as $arPrice) {
    $arProps = [
        'MIS_CODE' => $arPrice['code'],
        'PRICE'    => $arPrice['price'],
        'SERVICE'  => $arService['ID'],
    ];
    $arFields = [
        "MODIFIED_BY"       => $USER->GetID(),
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID"         => ServiceOffer::getIBlockId(),
        "PROPERTY_VALUES"   => $arProps,
        "NAME"              => $arPrice['name'],
        "ACTIVE"            => "N",
    ];

    $service = new CIBlockElement;
    if ($serviceId = $service->Add($arFields)) {
        //printData("New ID: " . $serviceId);
    } else {
        //printData("Error: " . $service->LAST_ERROR);
    }
}

//price generation
$path = $_SERVER['DOCUMENT_ROOT'] . $APPLICATION->GetCurDir();
if (Loader::includeModule("nkhost.phpexcel")) {
    global $PHPEXCELPATH;
    require_once($PHPEXCELPATH . '/PHPExcel.php');
    require_once($PHPEXCELPATH . '/PHPExcel/Writer/Excel5.php');

    $obDirections = CIBlockElement::getList(
        [],
        [
            'ACTIVE'    => 'Y',
            'IBLOCK_ID' => Direction::getIBlockId(),
        ],
        false,
        [],
        [
            'ID',
            'NAME',
        ]
    );
    $directionList = new DirectionList();
    while ($arDirection = $obDirections->fetch()) {
        $directionList->add(new Direction($arDirection['ID']));
    }

    foreach ($directionList->getList() as $direction) {
        $document = new \PHPExcel();
        $sheet = $document->setActiveSheetIndex(0);
        $columnPosition = 0;
        $startLine = 1;

        $offersList = $direction->getOffers();
        foreach ($offersList->getList() as $offer) {
            $currentColumn = $columnPosition;

            $sheet->setCellValueByColumnAndRow($currentColumn++, $startLine, $offer->name);
            $sheet->setCellValueByColumnAndRow($currentColumn++, $startLine, $offer->price);
            ++$startLine;
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($document, 'Excel5');
        $objWriter->save('price.xls');

        $filePath = $path . 'price.xls';

        $prop['FILE_SERVICES'] = ['VALUE' => CFile::MakeFileArray($filePath)];
        CIBlockElement::SetPropertyValuesEx($direction->id, Direction::getIBlockId(), $prop);
    }
}

echo 'Синхронизация выполнена' . '<br>';
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php"); ?>