<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application,
    Bitrix\Main\Loader,
    CIBlockElement,
    CPHPCache,
    MWI\Departments,
    MWI\Clinic,
    MWI\ClinicList,
    MWI\Service,
    MWI\ServiceList,
    MWI\Direction,
    MWI\DirectionList;

/**
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APPLICATION
 */
global $DB;
global $USER;
global $APPLICATION;

Loader::includeModule('search');

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList();
$departmentId = htmlspecialchars($getParams->getRaw('departmentId'));
$directionId = htmlspecialchars($getParams->getRaw('directionId'));
$clinicId = htmlspecialchars($getParams->getRaw('clinicId'));
$searchQuery = htmlspecialchars($getParams->getRaw('search'));

$arDepartments = Departments::getList();
if (empty($departmentId)) {
    $departmentId = reset($arDepartments)['XML_ID'];
}
$obClinicsList = Departments::getClinics($departmentId);
$obClinicsList->makeData();

$arDepartments = Departments::getList();

foreach ($arDepartments as &$arDepartment) {
    $arDepartment['SELECTED'] = $departmentId == $arDepartment['XML_ID'];
}
	
$obDirectionsList = new DirectionList();

if (!$obClinicsList->getById($clinicId)) {
	
    foreach ($obClinicsList->getList() as $obClinic) {
        foreach ($obClinic->directionsId as $dirId) {
            $obDirection = new Direction($dirId);
            $obDirectionsList->add($obDirection);
        }
    }
    $clinicId = '';
} else {

    $obClinic = $obClinicsList->getById($clinicId);
    foreach ($obClinic->directionsId as $dirId) {
        $obDirection = new Direction($dirId);

        $obDirectionsList->add($obDirection);
    }
}

$obDirectionsList->makeData();
//отсеиваем направления по привязке взрослый детский
$obDirectionsList->getDirectionList( $departmentId );
$arDirectionsId = $obDirectionsList->getIds();


	$obSelectedDirectionsList = new DirectionList();
	if ($directionId) {
		$obDirection = new Direction($directionId);
		$obSelectedDirectionsList->add($obDirection);
	} else {
		$obSelectedDirectionsList = $obDirectionsList;
	}

	$arSelectedDirectionsId = $obSelectedDirectionsList->isEmpty() ? false : $obSelectedDirectionsList->getIds();




/**
 * cache params
 */
$cacheTtl = 360000;
$obCache = new CPHPCache();
$cacheId = '/MWI/SD_S_DId=' . implode("-", $arSelectedDirectionsId);
$cachePath = '/services/';

if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
    $vars = $obCache->GetVars();
    $obServicesList = $vars['services'];
} else {
    /**
     * start buffering the output
     */
    $obCache->startDataCache();

    /**
     * add tags for cache
     */
    $obTaggedCache = Application::getInstance()->getTaggedCache();
    $obTaggedCache->startTagCache($cachePath);
    $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
    $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
    $obTaggedCache->endTagCache();

    /**
     * get data from database
     */
	

	 
	 
    $obServices = CIBlockElement::getList(
        array(
            'SORT' => 'ASC',
        ),
        array(
            'IBLOCK_ID' => Service::getIBlockId(),
            'ACTIVE' => 'Y',
            'PROPERTY_SHOW_ON_SERVICE_PAGE' => 1,
            'PROPERTY_DIRECTION' => $arSelectedDirectionsId,
        ),
        false,
        array(),
        array(
            'ID',
            'NAME',
        )
    );
    $obServicesList = new ServiceList();
    while ($arService = $obServices->fetch()) {
        if (!$obServicesList->contains($arService['ID'])) {
            $obService = new Service($arService['ID']);
            $obService->name = $arService['NAME'];
            $obServicesList->add($obService);
        }
    }

    /**
     * write pre-buffered output to the cache file
     * with additional variables
     */
    $obCache->endDataCache(
        array(
            'services' => $obServicesList,
        )
    );
}

$arSearchHints = [];
foreach ($obDirectionsList->getList() as $obDirection) {
	$arSearchHints[$obDirection->name] = $obDirection->name;
}
foreach ($obServicesList->getList() as $obService) {
    $arSearchHints[$obService->name] = $obService->name;
}





if (!empty($searchQuery)) {
    $foundDirectionsList = new DirectionList();
    $foundServicesList = new ServiceList();

    $obItems = CIBlockElement::getList(
        [],
        [
            'IBLOCK_ID' => Direction::getIBlockId(),
            'ACTIVE' => 'Y',
            '%NAME' => $searchQuery,
			'ID' 	=> $arSelectedDirectionsId
			
        ],
        false,
        [],
        [
            'ID',
            'IBLOCK_ID',
        ]
    );
    $arItems = [];
    while ($arItem = $obItems->fetch()) {
        $obDirection = new Direction($arItem['ID']);
        $foundDirectionsList->add($obDirection);
    }
	//////////////////
	$obItems = CIBlockElement::getList(
        [],
        [
            'IBLOCK_ID' => Service::getIBlockId(),
            'ACTIVE' => 'Y',
            '%NAME' => $searchQuery,
			array(
                'PROPERTY_DIRECTIONS' => $arSelectedDirectionsId,
            ),
        ],
        false,
        [],
        [
            'ID',
            'IBLOCK_ID',
        ]
    );
    $arItems = [];
    while ($arItem = $obItems->fetch()) {
        $obService = new Service($arItem['ID']);
        $foundServicesList->add($obService);
    }
	
	

	
    $arServicesId = $obServicesList->getIds();
    if ($foundServicesList->isEmpty() && $foundDirectionsList->isEmpty()) {
        
		echo 'poipo';
		printData('not found');
        //directions
        $obSearch = new CSearch();
        $obSearch->Search(
            array(
                'QUERY' => $searchQuery,
                'SITE_ID' => SITE_ID,
                'MODULE_ID' => 'iblock',
                'PARAM1' => Direction::getIBlockType(),
                'PARAM2' => Direction::getIBlockId(),
                'ITEM_ID' => $obDirectionsList->size() == 1 ? reset($arDirectionsId) : $arDirectionsId,
            )
        );
        $obSearch->NavStart();

        while ($arSearch = $obSearch->Fetch()) {
			

			
            $obDirection = new Direction($arSearch['ITEM_ID']);

            $foundDirectionsList->add($obDirection);
        }

        //services
        $obSearch = new CSearch();
        $obSearch->Search(
            array(
                'QUERY' => $searchQuery,
                'SITE_ID' => SITE_ID,
                'MODULE_ID' => 'iblock',
                'PARAM1' => Service::getIBlockType(),
                'PARAM2' => Service::getIBlockId(),
                'ITEM_ID' => $obServicesList->size() == 1 ? reset($arServicesId) : $arServicesId,
            )
        );
        $obSearch->NavStart();

        while ($arSearch = $obSearch->Fetch()) {
		
	
            $obService = new Service($arSearch['ITEM_ID']);

            $foundServicesList->add($obService);
        }
    }
	

    foreach (array_diff($arDirectionsId, $foundDirectionsList->getIds()) as $directionId2) {
		$obDirectionsList->remove($directionId2);
    }
	
	

    foreach (array_diff($arServicesId, $foundServicesList->getIds()) as $serviceId) {
        $obServicesList->remove($serviceId);
    }
}


foreach ($arDepartments as &$arDepartment) {
    $arDepartment['SELECTED'] = $departmentId == $arDepartment['XML_ID'];
}







$arClinics = array();
$clinicSelected = false;
foreach ($obClinicsList->getList() as $obClinic) {
    if ($clinicId == $obClinic->id) {
        $clinicSelected = true;
    }
    $arClinics[] = array(
        'ID' => $obClinic->id,
        'NAME' => $obClinic->name,
        'SELECTED' => $clinicId == $obClinic->id ? true : false,
    );
}
array_unshift(
    $arClinics,
    array(
        'ID' => '',
        'NAME' => getMessage('ALL_CLINICS'),
        'SELECTED' => !$clinicSelected,
    )
);

$arDirections = array();
$directionSelected = false;
foreach ($obDirectionsList->getList() as $obDirection) {
    if ($directionId == $obDirection->id) {
        $directionSelected = true;
    }
    $arDirections[] = array(
        'ID' => $obDirection->id,
        'NAME' => $obDirection->name,
        'SELECTED' => $directionId == $obDirection->id ? true : false,
    );
}
array_unshift(
    $arDirections,
    array(
        'ID' => '',
        'NAME' => getMessage('ALL_DIRECTIONS'),
        'SELECTED' => !$directionSelected,
    )
);


$arResult = array(
    'departments' => $arDepartments,
    'clinics' => $arClinics,
	'directions' => $arDirections,
    'search_query' => $searchQuery,
    'search_hints' => array_values($arSearchHints),
    'ajax_path' => $APPLICATION->GetCurPage(),
    'ajax_mode' => $getParams->getRaw('ajax_filter') == 'Y',
);


foreach ($obDirectionsList->getList() as $obDirection) {
    if ($directionId && $directionId !== $obDirection->id) {
        $obDirectionsList->remove( $obDirection->id );
    }
}

if (!empty($arParams['FILTER_NAME_DIRECTIONS'])) {
    $GLOBALS[$arParams['FILTER_NAME_DIRECTIONS']] = array(
        'ID' => $obDirectionsList->isEmpty() ? false : $obDirectionsList->getIds(),
    );

}

if (!empty($arParams['FILTER_NAME_SERVICES'])) {
    $GLOBALS[$arParams['FILTER_NAME_SERVICES']] = array(
        'ID' => $obServicesList->isEmpty() ? false : $obServicesList->getIds(),
    );
}

$this->IncludeComponentTemplate();
