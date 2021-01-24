<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class DiseaseList
 * @package MWI
 */
class DiseaseList extends AbstractCollection
{
    /**
     * @var string ITEMS_CLASS
     */
    const ITEMS_CLASS = 'MWI\Disease';

    /**
     * DiseaseList constructor.
     */
    public function __construct()
    {
        parent::__construct(self::ITEMS_CLASS);
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
        $cacheId = '/MWI/Stock_DiseasesId=' . implode("-", $arIds);
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
            $obTaggedCache->registerTag('iblock_id_' . Disease::getIBlockId());
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
                                'PROPERTY_DISEASES' => $arIds,
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
						'PROPERTY_DIRECTIONS',
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
					$obStock->direction = $arStock['PROPERTY_DIRECTIONS_VALUE'];
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