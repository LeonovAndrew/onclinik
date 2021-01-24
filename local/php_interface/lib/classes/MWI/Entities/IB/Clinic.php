<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class Clinic
 * @package MWI
 */
class Clinic implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var string $url
     * @var string $previewText
     * @var array $previewPicture Array containing the following fields:
     *      $previewPicture = [
     *          'SRC' => (string) src.
     *          'ALT' => (string) alt.
     *      ]
     * @var string $address
     * @var string $metro
     * @var string $phone
     * @var array $directionsId
     * @var array $coords
     */
    const IBLOCK_ID = array(
        'ru' => 8,
        'en' => 15,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'clinics',
        'en' => 'clinics_en',
    );

    public $id;
    public $name;
    public $url;
    public $previewText;
    public $previewPicture;
    public $address;
    public $metro;
    public $phone;
	public $mapIcon;
    public $directionsId = array();
    public $coords = array();

    /**
     * Clinic constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    /**
     * @description - get data from database
     */
    public function makeData()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Clinic_' . 'CId=' . $this->id;
        $cachePath = '/clinics/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arClinic = $vars['clinic'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * get data from database
             */
            $arClinic = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => $this->id,
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            )->fetch();

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'clinic' => $arClinic,
                )
            );
        }

        /**
         * set data
         */
        $this->name = $arClinic['NAME'];
    }

    /**
     * @return ReviewList
     */
    public function getReviews($limit = 2)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Clinic_Reviews' . 'CId=' . $this->id;
        $cachePath = '/reviews_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $reviewsList = $vars['reviews'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Review::getIBlockId());
            //TODO: check dependent tags for this cache
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obReviews = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Review::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_CLINIC' => $this->id,
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                    'PROPERTY_PATIENT_NAME',
                    'DATE_ACTIVE_FROM',
                    'PROPERTY_DOCTOR',
                )
            );

            $reviewsList = new ReviewList();
            while ($arReview = $obReviews->fetch()) {
                $review = new Review($arReview['ID']);
                $review->patientName = $arReview['PROPERTY_PATIENT_NAME_VALUE'];
                $review->publicationDate = $arReview['DATE_ACTIVE_FROM'];
                $review->doctorId = $arReview['PROPERTY_DOCTOR_VALUE'];
                $review->clinicId = $this->id;

                $reviewsList->add($review);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'reviews' => $reviewsList,
                )
            );
        }

        return $reviewsList;
    }

    /**
     * @return PersonalList
     */
    public function getDoctors()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Clinic_Doctors_' . 'CId=' . $this->id;
        $cachePath = '/doctors/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obDoctorsList = $vars['doctors'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
            //TODO: check dependent tags for this cache
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDoctors = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Personal::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_CLINICS' => $this->id,
                    'PROPERTY_DOCTOR' => true,
                ),
                false,
                array(),
                array(
                    'ID',
                )
            );

            $obDoctorsList = new PersonalList();
            while ($arDoctor = $obDoctors->fetch()) {
                $obDoctor = new Personal($arDoctor['ID']);

                $obDoctorsList->add($obDoctor);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'doctors' => $obDoctorsList,
                )
            );
        }

        return $obDoctorsList;
    }

    /**
     * @return PersonalList
     */
    public function getAdministration()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Clinic_Administration_' . 'CId=' . $this->id;
        $cachePath = '/administration/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obAdministrationList = $vars['administration'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
            //TODO: check dependent tags for this cache
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obAdministrators = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Personal::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_CLINICS' => $this->id,
                    'PROPERTY_ADMINISTRATOR' => true,
                ),
                false,
                array(),
                array(
                    'ID',
                )
            );

            $obAdministrationList = new PersonalList();
            while ($arAdministrator = $obAdministrators->fetch()) {
                $obAdministrator = new Personal($arAdministrator['ID']);

                $obAdministrationList->add($obAdministrator);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'administration' => $obAdministrationList,
                )
            );
        }

        return $obAdministrationList;
    }

    /**
     * @param int $limit
     * @param array $arFilter
     * @return ClinicList
     */
    public static function getList($limit = 18, $arFilter = array())
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Clinics_Limit=' . $limit . '_' . implode('-', $arFilter);
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
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            //TODO: check dependent tags for this cache
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obClinics = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array_merge(
                    array(
                        'IBLOCK_ID' => self::getIBlockId(),
                        'ACTIVE' => 'Y',
                    ),
                    $arFilter
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                )
            );

            $clinicsList = new ClinicList();
            while ($arClinic = $obClinics->fetch()) {
                $clinic = new self($arClinic['ID']);

                $clinicsList->add($clinic);
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
        }

        return $clinicsList;
    }
}