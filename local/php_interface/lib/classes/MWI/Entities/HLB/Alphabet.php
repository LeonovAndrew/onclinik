<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache;

/**
 * Class Alphabet
 * @package MWI
 */
class Alphabet implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . AlphabetTable::getTableName();
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
        $cacheId = '/MWI/' . AlphabetTable::getTableName();
        $cachePath = AlphabetTable::getTableName();
        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arLetters = $vars['letters'];
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
            $obTaggedCache->registerTag('hlblock_table_' . AlphabetTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obLetters = AlphabetTable::getList(
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
            );
            $arLetters = array();
            while ($arLetter = $obLetters->fetch()) {
                $arLetters[$arLetter['XML_ID']] = $arLetter;
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'letters' => $arLetters,
                )
            );
        }

        return $arLetters;
    }
}