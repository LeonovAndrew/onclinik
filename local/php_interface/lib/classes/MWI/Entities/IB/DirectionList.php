<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \Bitrix\Main\Loader as Loader,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class DirectionList
 * @package MWI
 */
class DirectionList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Direction';

    /**
     * DirectionList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }

    /**
     * @description - make data for all items in collection.
     */
    public function makeData()
    {
        Loader::IncludeModule('iblock');

        if (!$this->isEmpty()) {
            /**
             * get id's
             */
            $arIds = $this->getIds();
            sort($arIds);

            /**
             * cache params
             */
            $cacheTtl = 360000;
            $obCache = new CPHPCache();
            $cacheId = '/MWI/Directions_' . 'Id=' . implode("-", $arIds);
            $cachePath = '/directions/';

            if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
                /**
                 * cache is exist
                 */

                /**
                 * get data from cache
                 */
                $vars = $obCache->GetVars();
                $arItems = $vars['items'];

                /**
                 * set data for collection items
                 */
                foreach ($arItems as $arItem) {
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->departments = $arItem['DEPARTMENTS'];
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];
					$this->arItems[$arItem['ID']]->departmentsIds = $arItem['DEPARTMENTS_IDS'];
                }
				
            } else {
                /**
                 * start buffering the output
                 */
                $obCache->startDataCache();

                /**
                 * register tags for cache
                 */
                $obTaggedCache = Application::getInstance()->getTaggedCache();
                $obTaggedCache->startTagCache($cachePath);
                $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
                //TODO: check dependent tags for this cache
                $obTaggedCache->endTagCache();

                /**
                 * get data from database
                 */
                $obItems = CIBlockElement::getList(
                    array(),
                    array(
                        'IBLOCK_ID' => Direction::getIBlockId(),
                        'ID' => $arIds,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'DETAIL_PAGE_URL',
                        'PROPERTY_DEPARTMENTS',
                    )
                );
                $arDepartments = Departments::getList();
				
			
                $arItems = array();
                while ($arItem = $obItems->getNext()) {
				
				
                    $arDirectionDepartments = array();
					$arDirectionDepartmentsIds = array();
					if ( is_array($arItem['PROPERTY_DEPARTMENTS_VALUE']) ){
						foreach ($arItem['PROPERTY_DEPARTMENTS_VALUE'] as $departmentId) {
							$arDirectionDepartments[] = $arDepartments[$departmentId]['NAME'];
							$arDirectionDepartmentsIds[] = $departmentId;
						}
					}
					else {
						$departmentId = $arItem['PROPERTY_DEPARTMENTS_VALUE'];
						$arDirectionDepartments[] = $arDepartments[$departmentId]['NAME'];
						$arDirectionDepartmentsIds[] = $departmentId;
					}
                    /**
                     * set data for collection items
                     */
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->departments = $arDirectionDepartments;
					$this->arItems[$arItem['ID']]->departmentsIds = $arDirectionDepartmentsIds;
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];

                    /**
                     * collect data for cache
                     */
                    $arItems[$arItem['ID']] = array(
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'DEPARTMENTS' => $arDirectionDepartments,
						'DEPARTMENTS_IDS' => $arDirectionDepartmentsIds,
                        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
                    );
                }

                /**
                 * write pre-buffered output to the cache file
                 * with additional variables
                 */
                $obCache->endDataCache(
                    array(
                        'items' => $arItems,
                    )
                );
            }
        }
    }
	
	
	
	

    /**
     * @description Get all clinics linked with items in collection
     * @return ClinicList
     */
    public function getClinics()
    {
        $clinicsList = new ClinicList();
        if (!$this->isEmpty()) {
            /**
             * get id's
             */
            $arIds = $this->getIds();
            sort($arIds);

            /**
             * cache params
             */
            $cacheTtl = 360000;
            $obCache = new CPHPCache();
            $cacheId = '/MWI/Directions_Clinics_' . 'DId=' . implode("-", $arIds);
            $cachePath = '/clinics/';

            if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
                /**
                 * cache is exist
                 */

                /**
                 * get data from cache
                 */
                $vars = $obCache->GetVars();
                $clinicsList = $vars['clinics'];
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
                $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
                $obTaggedCache->endTagCache();

                /**
                 * get data from database
                 */
                $obClinics = CIBlockElement::getList(
                    array(
                        'SORT' => 'ASC',
                    ),
                    array(
                        'IBLOCK_ID' => Clinic::getIBlockId(),
                        'ACTIVE' => 'Y',
                        'PROPERTY_DIRECTIONS' => $this->isEmpty() ? false : $this->getIds(),
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                    )
                );
                while ($arClinic = $obClinics->fetch()) {
                    $obClinic = new Clinic($arClinic['ID']);
                    $obClinic->name = $arClinic['NAME'];

                    $clinicsList->add($obClinic);
                }
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'clinics' => $clinicsList,
                )
            );
        }

        return $clinicsList;
    }
	
	public function getItems(){
		return $this->arItems;
	}
	
	/**
     * @return Направления с отделениями (взрослое/детское)
     */
	public function getDirectionList( $departmentId )
    {
	

		foreach ($this->arItems as $direction ) {
			if ( !in_array($departmentId, $direction->departmentsIds ) ){
				$this->remove( $direction->id );
			}
		}
	}

    /**
     * @return StockList
     */
    public function getStocks()
    {
        Loader::IncludeModule('iblock');

        global $DB;

        $arDirectionsId = $this->getIds();
        sort($arDirectionsId);

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stock_DirectionsId=' . implode("-", $arDirectionsId);
        $cachePath = '/actions/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obStocksList = $vars['stocks'];
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
            $obTaggedCache->registerTag('iblock_id_' . Stock::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->endTagCache();

            $obStocksList = new StockList();
            if (!$this->isEmpty()) {
			
			
                $curDate = date($DB->DateFormatToPHP(CLang::GetDateFormat()), time());

                /**
                 * get data from database
                 */
                $obStocks = CIBlockElement::getList(
                    array(
                        'SORT' => 'ASC',
                    ),
                    array(
                        'IBLOCK_ID' => Stock::getIBlockId(),
                        'ACTIVE' => 'Y',
                        array(
                            'LOGIC' => 'AND',
                            array(
                                'LOGIC' => 'OR',
                                array(
                                    'DATE_ACTIVE_TO' => false,
                                ),
                                array(
                                    '>DATE_ACTIVE_TO' => $curDate,
                                )
                            ),
                            'PROPERTY_DIRECTIONS' => $this->getIds(),
                        ),
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'PREVIEW_TEXT',
                        'PREVIEW_PICTURE',
                        'DATE_ACTIVE_TO',
                        'PROPERTY_AMOUNT',
                        'PROPERTY_PERCENTAGE',
                        'DETAIL_PAGE_URL',
                    )
                );
                while ($arStock = $obStocks->getNext()) {
					
					
                    if ($arStock['PREVIEW_PICTURE']) {
					
						$pic = File::ResizeImageGet($arStock['PREVIEW_PICTURE'], array('width'=>365, 'height'=>156), BX_RESIZE_IMAGE_PROPORTIONAL);
				
                        $picture = array(
                            'SRC' => File::GetPath($arStock['PREVIEW_PICTURE']),
							'SMALL_SRC' => $pic['src'],
                            'ALT' => $arStock['NAME'],
                        );
                    } else {
                        $picture = array();
                    }
                    $obStock = new Stock($arStock['ID']);
                    $obStock->name = $arStock['NAME'];
                    $obStock->amount = $arStock['PROPERTY_AMOUNT_VALUE'];
                    $obStock->percentage = $arStock['PROPERTY_PERCENTAGE_VALUE'];
                    $obStock->url = $arStock['DETAIL_PAGE_URL'];
                    $obStock->previewText = $arStock['~PREVIEW_TEXT'];
                    $obStock->previewPicture = $picture;
                    $obStock->expireDate = $arStock['DATE_ACTIVE_TO'] ? FormatDateFromDB($arStock['DATE_ACTIVE_TO'], Stock::DATE_FULL) : '';
                    $obStock->expireDateCounter = trim($arStock['DATE_ACTIVE_TO']);

                    $obStocksList->add($obStock);
                }
            }

            $obCache->endDataCache(
                array(
                    'stocks' => $obStocksList,
                )
            );
        }

        return $obStocksList;
    }
}