<?php


namespace MWI;

/**
 * Class Device
 * @package MWI
 */
class Device
{
    /**
     * @return bool
     */
    public static function isMobile()
    {
        return (bool) preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}