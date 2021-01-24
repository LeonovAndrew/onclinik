<?php
/**
 * @param CDBResult $data
 * @return array
 */
function fetchAll(CDBResult $data)
{
    $result = array();
    while ($arData = $data->fetch()) {
        $result[] = $arData;
    }

    return $result;
}