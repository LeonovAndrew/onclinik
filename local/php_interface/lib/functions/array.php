<?php
/**
 * for PHP versions prior to 7.3.0
 */
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return null;
    }
}

/**
 * @param $key
 * @return Closure
 */
function build_assoc_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}