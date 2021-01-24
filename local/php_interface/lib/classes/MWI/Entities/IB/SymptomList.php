<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \CIBlockElement as CIBlockElement,
    \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class SymptomList
 * @package MWI
 */
class SymptomList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Symptom';

    /**
     * SymptomList constructor.
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
            $cacheId = '/MWI/Symptoms_' . 'Id=' . implode("-", $arIds);
            $cachePath = '/symptoms_' . CUR_LANG . '/';

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
                $obTaggedCache->registerTag('iblock_id_' . Disease::getIBlockId());
                $obTaggedCache->registerTag('iblock_id_' . Symptom::getIBlockId());
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
                        'IBLOCK_ID' => Symptom::getIBlockId(),
                        'ID' => $arIds,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    array(),
                    array(
                        'ID',
                        'NAME',
                        'DETAIL_PAGE_URL',
                    )
                );

                $arItems = array();
                while ($arItem = $obItems->getNext()) {
                    /**
                     * set data for collection items
                     */
                    $this->arItems[$arItem['ID']]->name = $arItem['NAME'];
                    $this->arItems[$arItem['ID']]->url = $arItem['DETAIL_PAGE_URL'];

                    /**
                     * collect data for cache
                     */
                    $arItems[$arItem['ID']] = array(
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
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
     * @return StockList
     */
    public function getStocks()
    {
        Loader::IncludeModule('iblock');

        global $DB;

        $arIds = $this->getIds();
        sort($arIds);

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stock_SymptomsId=' . implode("-", $arIds);
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
            $obTaggedCache->registerTag('iblock_id_' . Symptom::getIBlockId());
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
                                'PROPERTY_SYMPTOMS' => $arIds,
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