<?php
class CustomTypeMenu
{
    function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'custommenu',
            "DESCRIPTION" => 'Меню',
            'GetPropertyFieldHtml' => array(__CLASS__, 'GetPropertyFieldHtml'),
            'ConvertToDB' => array(__CLASS__, 'ConvertToDB'),
            'ConvertFromDB' => array(__CLASS__, 'ConvertFromDB'),
        );
    }

    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        return '<div style="margin-bottom: 10px">' .
                   '<div>Название: </div><input type="text" name="' . $strHTMLControlName['VALUE'] . '[]" value="' . $value['VALUE']['name'] . '">' .
                   '<div>Ссылка: </div><input type="text" name="' . $strHTMLControlName['VALUE'] . '[]" value="' . $value['VALUE']['link'] . '">' .
                   '<div>Сортировка: </div><input type="text" name="' . $strHTMLControlName['VALUE'] . '[]" value="' . $value['VALUE']['sort'] . '">' .
               '</div>';
    }

    function ConvertToDB($arProperty, $value)
    {
        if (!empty($value['VALUE'][1]) && !empty($value['VALUE'][2])) {
            $sort = intval($value['VALUE'][2]);
            $sort = $sort > 0 ? $sort : 0;

            $value = array(
                'VALUE' => serialize(
                    array(
                        'name' => $value['VALUE'][0],
                        'link' => $value['VALUE'][1],
                        'sort' => $sort,
                    )
                ),
                'DESCRIPTION' => '',
            );
        }

        return $value;
    }

    function ConvertFromDB($arProperty, $value)
    {
        $value['VALUE'] = unserialize($value['VALUE']);

        return $value;
    }
}