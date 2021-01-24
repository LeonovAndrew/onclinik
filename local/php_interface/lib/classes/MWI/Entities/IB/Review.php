<?php


namespace MWI;

use \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;


/**
 * Class Review
 * @package MWI
 */
class Review implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        DisplayedTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var array DISPLAYED - Array with numbers of displayed records.
     * @var string DISPLAYED_COOKIE
     * @var string DATE_SHORT
     * @var string DATE_FULL
     * @var int $id
     * @var string $patientName
     * @var string $text
     * @var string $publicationDate
     * @var int $directionId;
     * @var int $serviceId;
     * @var int $doctorId;
     * @var int $clinicId;
     */
    const IBLOCK_ID = array(
        'ru' => 11,
        'en' => 74,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'reviews',
        'en' => 'reviews_en',
    );
    const DISPLAYED = array(
        1 => array(
            'desktop' => '6',
            'mobile' => '2',
        ),
        2 => array(
            'desktop' => '12',
            'mobile' => '4',
        ),
        3 => array(
            'desktop' => '24',
            'mobile' => '6',
        ),
    );
    const DISPLAYED_COOKIE = 'reviews_displayed';
    const DATE_SHORT = 'DD.MM.YYYY';
    const DATE_FULL = 'DD MMMM YYYY HH:MI';

    public $id;
    public $patientName;
    public $text;
    public $publicationDate;
    public $directionId;
    public $serviceId;
    public $doctorId;
    public $clinicId;

    /**
     * Disease constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    /**
     *
     */
    public function makeData()
    {
        // TODO: Implement makeData() method.
    }

    /**
     * @description Get all directions linked in reviews
     * @return DirectionList
     */
    public static function getAllDirections()
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Reviews_Directions' . '_SiteId=' . SITE_ID;;
        $cachePath = '/directions/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $directionsList = $vars['directions'];
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
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Review::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDirections = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Direction::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => CIBlockElement::SubQuery(
                        "PROPERTY_DIRECTION",
                        array(
                            'IBLOCK_ID' => Review::getIBlockId(),
                            'ACTIVE' => 'Y',
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            );
            $directionsList = new DirectionList();
            while ($arDirection = $obDirections->fetch()) {
                $obDirection = new Direction($arDirection['ID']);
                $obDirection->name = $arDirection['NAME'];

                $directionsList->add($obDirection);
            }
        }

        /**
         * write pre-buffered output to the cache file
         * with additional variables
         */
        $obCache->endDataCache(
            array(
                'directions' => $directionsList,
            )
        );

        return $directionsList;
    }

    /**
     * @description Get all clinics linked in reviews
     * @return ClinicList
     */
    public static function getAllClinics()
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Reviews_Clinics' . '_SiteId=' . SITE_ID;;
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
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obClinics = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Clinic::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => CIBlockElement::SubQuery(
                        "PROPERTY_CLINIC",
                        array(
                            'IBLOCK_ID' => self::getIBlockId(),
                            'ACTIVE' => 'Y',
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            );
            $clinicsList = new ClinicList();
            while ($arClinic = $obClinics->fetch()) {
                $obClinic = new Clinic($arClinic['ID']);
                $obClinic->name = $arClinic['NAME'];

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

    /**
     * @description Get all doctors linked in reviews
     * @return PersonalList
     */
    public static function getAllDoctors()
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Reviews_Doctors/' . CUR_LANG . '_SiteId=' . SITE_ID;;
        $cachePath = '/doctors_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $doctorsList = $vars['doctors'];
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
            $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDoctors = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => Personal::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => CIBlockElement::SubQuery(
                        "PROPERTY_DOCTOR",
                        array(
                            'IBLOCK_ID' => self::getIBlockId(),
                            'ACTIVE' => 'Y',
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            );
            $doctorsList = new PersonalList();
            while ($arDoctor = $obDoctors->fetch()) {
                $obDoctor = new Personal($arDoctor['ID']);
                $obDoctor->name = $arDoctor['NAME'];

                $doctorsList->add($obDoctor);
            }
        }

        /**
         * write pre-buffered output to the cache file
         * with additional variables
         */
        $obCache->endDataCache(
            array(
                'doctors' => $doctorsList,
            )
        );

        return $doctorsList;
    }
}