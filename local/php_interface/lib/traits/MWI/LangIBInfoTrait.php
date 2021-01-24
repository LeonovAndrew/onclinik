<?php


namespace MWI;

/**
 * Trait LangIBInfoTrait
 * @package MWI
 */
trait LangIBInfoTrait
{
    /**
     * @var array IBLOCK_TYPE
     * @return string iblock type based on current language
     */
    public static function getIBlockType()
    {
        $curLang = Lang::getCurrent()['ID'];

        return self::IBLOCK_TYPE[$curLang];
    }

    /**
     * @var array IBLOCK_ID
     * @return int iblock id based on current language
     */
    public static function getIBlockId()
    {
        $curLang = Lang::getCurrent()['ID'];

        return self::IBLOCK_ID[$curLang];
    }
}