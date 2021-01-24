<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \CIBlockElement as CIBlockElement,
    \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class ServiceList
 * @package MWI
 */
class ServiceList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Service';

    /**
     * ServiceList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
    }

    /**
     * @description - make data from database for all items in collection.
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
            $cacheId = '/MWI/Services_' . 'Id=' . implode("-", $arIds);
            $cachePath = '/services/';

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
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];
                    $this->arItems[$arItem['ID']]->previewText = $arItem['PREVIEW_TEXT'];
                    $this->arItems[$arItem['ID']]->type = $arItem['TYPE'];
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
                $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
                $obTaggedCache->registerTag('hlblock_table_' . ServicesTypesTable::getTableName());
                //TODO: check dependent tags for this cache
                $obTaggedCache->endTagCache();

                /**
                 * get data from database
                 */

                /**
                 * get services
                 */
                $obItems = CIBlockElement::getList(
                    array(),
                    array(
                        'IBLOCK_ID' => Service::getIBlockId(),
                        'ID' => $arIds,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'DETAIL_PAGE_URL',
                        'PREVIEW_TEXT',
                        'PROPERTY_TYPE',
                    )
                );

                /**
                 * get services types
                 */
                $obServiceTypes = ServicesTypesTable::getList(
                    array(
                        "select" => array(
                            'ID',
                            'NAME' => 'UF_NAME',
                            'XML_ID' => 'UF_XML_ID',
                            'CODE' => 'UF_CODE',
                        ),
                        "order" => array(),
                    )
                );

                $arServiceTypes = array();
                while ($arServiceType = $obServiceTypes->fetch()) {
                    $arServiceTypes[$arServiceType['XML_ID']] = array(
                        'ID' => $arServiceType['ID'],
                        'NAME' => $arServiceType['NAME'],
                        'CODE' => $arServiceType['CODE'],
                    );
                }

                $arItems = array();
                while ($arItem = $obItems->getNext()) {
                    $arType = $arItem['PROPERTY_TYPE_VALUE'] ? $arServiceTypes[$arItem['PROPERTY_TYPE_VALUE']] : array();
                    /**
                     * set data for collection items
                     */
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];
                    $this->arItems[$arItem['ID']]->previewText = $arItem['~PREVIEW_TEXT'];
                    $this->arItems[$arItem['ID']]->type = $arType;

                    /**
                     * collect data for cache
                     */
                    $arItems[$arItem['ID']] = array(
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'DETAIL_PAGE_URL' => $arItem['DETAIL_PAGE_URL'],
                        'PREVIEW_TEXT' => $arItem['~PREVIEW_TEXT'],
                        'TYPE' => $arType,
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
     * @return array Services grouped by their types.
     */
    public function getListGroupedByTypes()
    {
        $arResult = array();
        foreach ($this->arItems as $item) {
            if (!empty($item->type) ) {
                if (!isset($arResult[$item->type['ID']])) {
                    $arResult[$item->type['ID']]['NAME'] = $item->type['NAME'];
                    $arResult[$item->type['ID']]['CODE'] = $item->type['CODE'];
                }
				if ( $item->minimumPrice ){
					$arResult[$item->type['ID']]['ITEMS'][$item->id] = $item;
				}
            }
        }

        return $arResult;
    }

    /**
     * @return array Minimum price of all services. Array containing the following fields:
     *      $arPrice = [
     *          'price' => (float) minimum price.
     *          'discount_price' => (float) minimum discount price.
     *      ]
     */
    public function getMinimumPrice()
    {
        if (!$this->isEmpty()) {
            $price = reset($this->arItems)->minimumPrice;
            $discountPrice = reset($this->arItems)->minimumDiscountPrice;
            foreach ($this->arItems as $item) {
                if ($item->minimumPrice < $price) {
                    $price = $item->minimumPrice;
                }
                if ($item->minimumDiscountPrice < $discountPrice) {
                    $discountPrice = $item->minimumDiscountPrice;
                }
            }
        } else {
            $price = 0;
            $discountPrice = 0;
        }

        $arPrice = array(
            'price' => $price,
            'discount_price' => $discountPrice
        );

        return $arPrice;
    }

    /**
     * @return StockList
     */
    public function getStocks( $directionIds = Array() )
    {
        Loader::IncludeModule('iblock');

        global $DB;

        $arServicesId = $this->getIds();
        sort($arServicesId);

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stock_ServicesId=' . implode("-", $arServicesId);
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
            $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
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
							array(
                                'LOGIC' => 'OR',
                                array(
                                    'PROPERTY_SERVICES' => $this->getIds()
                                ),
                                array(
                                    'PROPERTY_DIRECTIONS' => $directionIds
                                )
                            ),
							
                            
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