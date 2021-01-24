<?php


namespace MWI;

use \Bitrix\Main as Main,
    \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

/**
 * Class ServicesTypesTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_XML_ID string optional
 * <li> UF_NAME string optional
 * <li> UF_CODE string optional
 * <li> UF_DESCRIPTION string optional
 * <li> UF_FULL_DESCRIPTION string optional
 * </ul>
 *
 * @package ServicesTypes
 **/

class ServicesTypesTable extends Main\Entity\DataManager
{
    use LangHLBInfoTrait;

    /**
     * @var array TABLE_NAME
     * @var array HLBLOCK_ID
     */
    const TABLE_NAME = array(
        'ru' => 'services_types',
        'en' => 'services_types_en',
    );
    const HLBLOCK_ID = array(
        'ru' => 4,
        'en' => 22,
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
            'UF_CODE' => array(
                'data_type' => 'text',
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