<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache;

/**
 * Class Cities
 * @package MWI
 */
class Cities implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . CitiesTable::getTableName();
        clearCacheByTag($tag);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/' . CitiesTable::getTableName();
        $cachePath = CitiesTable::getTableName();
        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arCities = $vars['cities'];
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
            $obTaggedCache->registerTag('hlblock_table_' . CitiesTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arCities = CitiesTable::getList(
                array(
                    "select" => array(
                        'ID',
                        'NAME' => 'UF_NAME',
                        'XML_ID' => 'UF_XML_ID',
                    ),
                    "order" => array(
                        'UF_SORT' => 'ASC',
                    ),
                    "filter" => array(

                    ),
                )
            )->fetchAll();

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'cities' => $arCities,
                )
            );
        }

        return $arCities;
    }
}