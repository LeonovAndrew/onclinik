<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class ServiceOfferList
 * @package MWI
 */
class ServiceOfferList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\ServiceOffer';

    /**
     * ServiceOfferList constructor.
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
        // TODO: Implement makeData() method.
    }

    /**
     * @return array Minimum price of all offers. Array containing the following fields:
     *      $arPrice = [
     *          'price' => (float) minimum price.
     *          'discount_price' => (float) minimum discount price.
     *      ]
     */
    public function getMinimumPrice()
    {
        $minimumPrice = 0;
        $minimumDiscountPrice = 0;
        if (!$this->isEmpty()) {
            $arOffers = $this->getList();
            reset($arOffers);
            $minimumPrice = current($arOffers)->price;
            $minimumDiscountPrice = current($arOffers)->discountPrice;
			$count = 0;
            foreach ($arOffers as $obOffer) {
                if ($obOffer->price < $minimumPrice) {
                    $minimumPrice = $obOffer->price;
                }
                if ($obOffer->discountPrice < $minimumDiscountPrice) {
                    $minimumDiscountPrice = $obOffer->discountPrice;
                }
				$count++;
            }
        }

        $arPrice = array(
            'price' => $minimumPrice,
            'discount_price' => $minimumDiscountPrice
        );
		
		if ( $count == 1 ){
			$arPrice['simple'] = 'Y';
		}

        return $arPrice;
    }

    /**
     * @return ServiceList
     */
    public function getServices()
    {
        if ($this->isEmpty()) {
            return new ServiceList();
        }

        Loader::IncludeModule('iblock');

        $arOffersId = $this->getIds();
        sort($arOffersId);

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/ServiceOffer_Services_' . 'OffersId=' . implode("-", $arOffersId);
        $cachePath = '/services/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obServicesList = $vars['services'];
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
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obOffers = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => ServiceOffer::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => $arOffersId,
                ),
                false,
                array(),
                array(
                    'ID',
                    'PROPERTY_SERVICE',
                )
            );
            $obServicesList = new Servicelist();
            while ($arOffer = $obOffers->fetch()) {
                if (is_array($arOffer['PROPERTY_SERVICE_VALUE'])) {
                    foreach ($arOffer['PROPERTY_SERVICE_VALUE'] as $serviceId) {
                        $obService = new Service($serviceId);

                        $obServicesList->add($obService);
                    }
                } else {
                    $obService = new Service($arOffer['PROPERTY_SERVICE_VALUE']);

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

        return $obServicesList;
    }

    /**
     * @return DirectionList
     */
    public function getDirections()
    {
        Loader::IncludeModule('iblock');

        $arOffersId = $this->getIds();
        sort($arOffersId);

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/ServiceOffer_Directions_' . 'OffersId=' . implode("-", $arOffersId);
        $cachePath = '/directions/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obDirectionsList = $vars['directions'];
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
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obOffers = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => ServiceOffer::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => $arOffersId,
                ),
                false,
                array(),
                array(
                    'ID',
                    'PROPERTY_SERVICE',
                )
            );
            $obServicesList = new ServiceList();
            while ($arOffer = $obOffers->fetch()) {
                foreach ($arOffer['PROPERTY_SERVICE_VALUE'] as $serviceId) {
                    if (!$obServicesList->contains($serviceId)) {
                        $obService = new Service($serviceId);
                        $obServicesList->add($obService);
                    }
                }
            }
            $obDirectionsList = new DirectionList();

            if (!$obServicesList->isEmpty()) {
                $obDirections = CIBlockElement::getList(
                    array(),
                    array(
                        'IBLOCK_ID' => Direction::getIBlockId(),
                        'ACTIVE' => 'Y',
                        'ID' => $obServicesList->getIds(),
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                    )
                );

                while ($arDirection = $obDirections->fetch()) {
                    $obDirection = new Direction($arDirection['ID']);
                    $obDirectionsList->add($obDirection);
                }
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'directions' => $obDirectionsList,
                )
            );
        }

        return $obDirectionsList;
    }

    /**
     * @return StockList
     */
    public function getStocks()
    {
        Loader::IncludeModule('iblock');

        global $DB;

        $arOffersId = $this->getIds();
        sort($arOffersId);

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stock_OffersId=' . implode("-", $arOffersId);
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
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->endTagCache();

            $obStocksList = new StockList();
            if (!$this->isEmpty()) {
                $obServices = $this->getServices();
                $arServicesId = $obServices->getIds();

                $obDirections = $this->getDirections();
                $arDirectionsId = $obDirections->getIds();

                $curDate = date($DB->DateFormatToPHP(CLang::GetDateFormat()), time());
                $arFilterLinks = array(
                    'LOGIC' => 'AND',
                    'PROPERTY_OFFERS' => $arOffersId,
                );
                if ($arServicesId) {
                    $arFilterLinks[] = array(
                        'PROPERTY_SERVICES' => $arServicesId,
                    );
                }
                if ($arDirectionsId) {
                    $arFilterLinks[] = array(
                        'PROPERTY_DIRECTIONS' => $arDirectionsId,
                    );
                }

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
                            $arFilterLinks,
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
                        $picture = array(
                            'SRC' => File::GetPath($arStock['PREVIEW_PICTURE']),
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