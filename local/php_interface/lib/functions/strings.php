<?php
/**
 * @description Delete extra characters from phone number
 * @param $phone
 * @return string
 */
function getNumericalPhone($phone)
{
    return preg_replace('![^0-9+]!', '', $phone);
}

/**
 * @description get the right suffix depending on quantity
 * @param int $quantity
 * @param array $arSuffix Array of options 3 elements long
 * @return string
 */
function getSuffix($quantity, $arSuffix)
{
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $quantity % 100;
    $suffixKey = ($mod > 7 && $mod < 20) ? 2 : $keys[min($mod % 10, 5)];

    return $arSuffix[$suffixKey];
}

/**
 * @param $url
 * @param $varName
 * @return string
 */
function removeGetVar($url, $varName) {
    return preg_replace('/([?&])' . $varName . '=[^&]+(&|$)/','$1', $url);
}

/**
 * @param string $phone
 * @return bool
 */
function isCorrectPhone($phone) {
    return strlen(preg_replace('/[^0-9]/', '', $phone)) === 11;
}