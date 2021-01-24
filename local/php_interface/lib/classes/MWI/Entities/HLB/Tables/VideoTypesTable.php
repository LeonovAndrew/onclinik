<?php


namespace MWI;

use \Bitrix\Main as Main,
    \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

/**
 * Class VideoTypesTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_XML_ID string optional
 * <li> UF_NAME string optional
 * <li> UF_DESCRIPTION string optional
 * <li> UF_FULL_DESCRIPTION string optional
 * <li> UF_SORT int optional
 * </ul>
 *
 * @package VideoTypes
 **/

class VideoTypesTable extends Main\Entity\DataManager
{
    use LangHLBInfoTrait;

    /**
     * @var array TABLE_NAME
     * @var array HLBLOCK_ID
     */
    const TABLE_NAME = array(
        'ru' => 'video_types',
        'en' => 'video_types_en',
    );
    const HLBLOCK_ID = array(
        'ru' => 11,
        'en' => 15,
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
            'UF_DESCRIPTION' => array(
                'data_type' => 'text',
                'title' => '',
            ),
            'UF_FULL_DESCRIPTION' => array(
                'data_type' => 'text',
                'title' => '',
            ),
            'UF_SORT' => array(
                'data_type' => 'integer',
                'title' => '',
            ),
        );
    }
}