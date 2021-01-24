<?php


namespace MWI;

/**
 * Trait LangHLBInfoTrait
 * @package MWI
 */
trait LangHLBInfoTrait
{
    /**
     * @var array HLBLOCK_ID
     * @return int hlblock id based on current language
     */
    public static function getHLBId()
    {
        $curLang = Lang::getCurrent()['ID'];

        return self::HLBLOCK_ID[$curLang];
    }

    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        $curLang = Lang::getCurrent()['ID'];

        return self::TABLE_NAME[$curLang];
    }
}