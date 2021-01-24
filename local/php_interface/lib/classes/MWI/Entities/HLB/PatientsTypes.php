<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache;

/**
 * Class PatientsTypes
 * @package MWI
 */
class PatientsTypes implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . PatientsTypesTable::getTableName();
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
        $cacheId = '/MWI/' . PatientsTypesTable::getTableName();
        $cachePath = PatientsTypesTable::getTableName();

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arPatientsTypes = $vars['patients_types'];
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
            $obTaggedCache->registerTag('hlblock_table_' . PatientsTypesTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arPatientsTypes = PatientsTypesTable::getList(
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
                    'patients_types' => $arPatientsTypes,
                )
            );
        }

        return $arPatientsTypes;
    }
}