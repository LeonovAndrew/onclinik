<?php
/**
 * @param $number
 * @return string
 */
function splitIntoDigits($number)
{
    return number_format($number, 0, '', ' ');
}

/**
 * @param $number
 * @return string
 */
function priceFormat($number)
{
    return number_format($number, 0, ',', ' ');
}