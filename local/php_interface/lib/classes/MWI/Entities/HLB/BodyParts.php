<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache;

/**
 * Class BodyParts
 * @package MWI
 */
class BodyParts implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . BodyPartsTable::getTableName();
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
        $cacheId = '/MWI/' . BodyPartsTable::getTableName();
        $cachePath = BodyPartsTable::getTableName();
        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arBodyParts = $vars['body_parts'];
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
            $obTaggedCache->registerTag('hlblock_table_' . BodyPartsTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obBodyParts = BodyPartsTable::getList(
                array(
                    "select" => array(
                        'ID',
                        'NAME' => 'UF_NAME',
                        'XML_ID' => 'UF_XML_ID',
                        'CSS_TOP' => 'UF_CSS_TOP',
                        'CSS_LEFT' => 'UF_CSS_LEFT',
                    ),
                    "order" => array(
                        'UF_SORT' => 'ASC',
                    ),
                    "filter" => array(

                    ),
                )
            );
            $arBodyParts = array();
            while ($arBodyPart = $obBodyParts->fetch()) {
                $arBodyParts[$arBodyPart['XML_ID']] = $arBodyPart;
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'body_parts' => $arBodyParts,
                )
            );
        }

        return $arBodyParts;
    }
}