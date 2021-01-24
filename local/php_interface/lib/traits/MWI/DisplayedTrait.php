<?php


namespace MWI;

use \Bitrix\Main\Application as Application,
    \Bitrix\Main\Web\Cookie as Cookie;

/**
 * Trait DisplayedTrait
 * @package MWI
 */
trait DisplayedTrait
{
    /**
     * @var array DISPLAYED
     * @var string DISPLAYED_COOKIE
     * @return array displayed number from cookie or the first one from DISPLAYED if it's not exist. Array containing the following fields:
     *      $arResult = [
     *          'index' => displayed index
     *          'value' => array of displayed values
     *      ]
     */
    public static function getDisplayed()
    {
        $cookie = Application::getInstance()->getContext()->getRequest()->getCookie(self::DISPLAYED_COOKIE);
        $displayedIndex = $cookie ? $cookie : \array_key_first(self::DISPLAYED);
        $device = Device::isMobile() ? 'mobile' : 'desktop';
        if (($displayedIndex !== null) && (!empty(self::DISPLAYED[$displayedIndex]))) {
            return array(
                'index' => $displayedIndex,
                'value' => self::DISPLAYED[$displayedIndex][$device],
            );
        }
        $arDisplayed = self::DISPLAYED;

        return array(
            'index' => $displayedIndex,
            'value' => reset($arDisplayed)[$device],
        );
    }

    /**
     * @param $index
     * @var array DISPLAYED
     * @var string DISPLAYED_COOKIE
     * @return array
     */
    public static function updateDisplayed($index)
    {
        if (!empty(self::DISPLAYED[$index])) {
            $device = Device::isMobile() ? 'mobile' : 'desktop';
            $cookie = new Cookie(self::DISPLAYED_COOKIE, $index);
            $response = Application::getInstance()->getContext()->getResponse();
            $response->addCookie($cookie);
            $response->flush("");

            return array(
                'index' => $index,
                'value' => self::DISPLAYED[$index][$device],
            );
        }

        return self::getDisplayed();
    }
}