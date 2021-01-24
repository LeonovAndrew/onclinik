<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache;

/**
 * Class VideoTypes
 * @package MWI
 */
class VideoTypes implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . VideoTypesTable::getTableName();
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
        $cacheId = '/MWI/' . VideoTypesTable::getTableName();
        $cachePath = VideoTypesTable::getTableName();
        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arTypes = $vars['types'];
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
            $obTaggedCache->registerTag('hlblock_table_' . VideoTypesTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arTypes = VideoTypesTable::getList(
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
                    'types' => $arTypes,
                )
            );
        }

        return $arTypes;
    }
}