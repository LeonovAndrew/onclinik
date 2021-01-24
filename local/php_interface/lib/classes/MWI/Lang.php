<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \Bitrix\Main\Web\Uri as Uri;

/**
 * Class Lang
 * @package MWI
 */
class Lang
{
    /**
     * @var array $arLangs Available languages. Array containing the following fields:
     *      $arLangs = [
     *          'ID' => (string) id.
     *          'NAME' => (string) name.
     *          'VALUE' => (string) value.
     *      ]
     */
    private static $arLangs = array(
        array(
            'ID' => 'ru',
            'NAME' => 'eng',
            'VALUE' => '',
        ),
        array(
            'ID' => 'en',
            'NAME' => 'ru',
            'VALUE' => 'en',
        ),
    );

    /**
     * @return array Current language.
     */
    public static function getCurrent()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $uriString = $request->getRequestUri();
        $uri = new Uri($uriString);

        return self::getUriLang($uri->GetPath());
    }

    private static function getUriLang($uri)
    {
        $arLangs = self::getList();
        $uriLang = explode('/', $uri, 3)[1];
        foreach ($arLangs as $arLang) {
            if ($arLang['VALUE'] == $uriLang) {
                return $arLang;
            }
        }

        return $arLangs[0];
    }

    /**
     * @return array Available languages.
     */
    public static function getList()
    {
        return self::$arLangs;
    }
}