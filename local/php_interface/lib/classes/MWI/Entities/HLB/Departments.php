<?php

namespace MWI;

use \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \Bitrix\Main\Loader;

Loader::includeModule('iblock');

/**
 * Class Departments
 * @package MWI
 */
class Departments implements TaggedCacheInterface
{
    public static function clearTaggedCache()
    {
        $tag = 'hlblock_table_' . DepartmentsTable::getTableName();
        clearCacheByTag($tag);
    }

    /**
     * @return array
     */
    public static function getList()
    {
	   /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/' . DepartmentsTable::getTableName();
        $cachePath = DepartmentsTable::getTableName();
        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arDepartments = $vars['departments'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * add tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('hlblock_table_' . DepartmentsTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arDepartments = array();
            $obDepartments = DepartmentsTable::getList(
                array(
                    "select" => array(
                        'ID',
                        'NAME' => 'UF_NAME',
                        'XML_ID' => 'UF_XML_ID',
                    ),
                    "order" => array(
                        'UF_SORT' => 'ASC',
                    ),
                    "filter" => array(

                    ),
                )
            );
            while ($arDepartment = $obDepartments->fetch()) {
                $arDepartments[$arDepartment['XML_ID']] = $arDepartment;
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'departments' => $arDepartments,
                )
            );
        }

        return $arDepartments;
    }

    /**
     * @param int $departmentId
     * @return ClinicList
     */
    public static function getClinics($departmentId)
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Departments_Clinics_' . 'DId=' . $departmentId;
        $cachePath = '/clinics/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $clinicsList = $vars['clinics'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * add tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
            $obTaggedCache->registerTag('hlblock_table_' . DepartmentsTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obClinics = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Clinic::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_DEPARTMENTS' => $departmentId,
                ),
                false,
                array(),
                array(
                    'ID',
                )
            );
            $clinicsList = new ClinicList();
            while ($arClinic = $obClinics->fetch()) {
                $obClinic = new Clinic($arClinic['ID']);

                $clinicsList->add($obClinic);
            }
        }

        /**
         * write pre-buffered output to the cache file
         * with additional variables
         */
        $obCache->endDataCache(
            array(
                'clinics' => $clinicsList,
            )
        );

        return $clinicsList;
    }
}