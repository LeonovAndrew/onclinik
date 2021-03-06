<?php


namespace MWI;

use \Bitrix\Main as Main,
    \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

/**
 * Class CitiesTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_XML_ID string optional
 * <li> UF_NAME string optional
 * <li> UF_SORT int optional
 * <li> UF_DESCRIPTION string optional
 * <li> UF_FULL_DESCRIPTION string optional
 * </ul>
 *
 * @package Cities
 **/

class CitiesTable extends Main\Entity\DataManager
{
    use LangHLBInfoTrait;

    /**
     * @var array TABLE_NAME
     * @var array HLBLOCK_ID
     */
    const TABLE_NAME = array(
        'ru' => 'cities',
        'en' => 'cities_en',
    );
    const HLBLOCK_ID = array(
        'ru' => 10,
        'en' => 17,
    );

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => '',
            ),
            'UF_XML_ID' => array(
                'data_type' => 'text',
                'title' => '',
            ),
            'UF_NAME' => array(
                'data_type' => 'text',
                'title' => '',
            ),
            'UF_SORT' => array(
                'data_type' => 'integer',
                'title' => '',
            ),
            'UF_DESCRIPTION' => array(
                'data_type' => 'text',
                'title' => '',
            ),
            'UF_FULL_DESCRIPTION' => array(
                'data_type' => 'text',
                'title' => '',
            ),
        );
    }
}