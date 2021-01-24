<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CFile as CFile;

/**
 * Class Doctor
 * @package MWI
 */
class Personal implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var string $position
     * @var string $url
     * @var array $previewPicture Array containing the following fields:
     *      $previewPicture = [
     *          'SRC' => (string) src.
     *          'ALT' => (string) alt.
     *      ]
     * @var bool $administrator
     * @var bool $doctor
     * @var int $price
     */
    const IBLOCK_ID = array(
        'ru' => 5,
        'en' => 42,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'personal',
        'en' => 'staff_en',
    );

    public $id;
    public $name;
    public $position;
    public $url;
    public $previewPicture;
    public $administrator;
    public $doctor;
    public $price;

    /**
     * Doctor constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    /**
     * @description make data from database
     */
    public function makeData()
    {
        Loader::IncludeModule('iblock');
		
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Personal_' . 'DId=' . $this->id . '_SiteId=' . SITE_ID;
        $cachePath = '/personal' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arDoctor = $vars['doctor'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * get data from database
             */
            $arDoctor = CIBlockElement::getList(
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
                    'DETAIL_PAGE_URL',
                    'PREVIEW_PICTURE',
                    'PROPERTY_POSITION',
                    'PROPERTY_ADMINISTRATOR',
                    'PROPERTY_DOCTOR',
                )
            )->getNext();

			if ( $arDoctor['PREVIEW_PICTURE'] )
				$pic = File::ResizeImageGet($arDoctor['PREVIEW_PICTURE'], array('width'=>285, 'height'=>380), BX_RESIZE_IMAGE_PROPORTIONAL);
				
			
            $arDoctor['PREVIEW_PICTURE'] = array(
                'SRC' => $arDoctor['PREVIEW_PICTURE'] ? CFile::GetPath($arDoctor['PREVIEW_PICTURE']) : '',
                'SMALL_SRC' => $arDoctor['PREVIEW_PICTURE'] ? $pic['src'] : '',
				'ALT' => $arDoctor['NAME'],
            );
            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'doctor' => $arDoctor,
                )
            );
        }

        /**
         * set data
         */
        $this->name = $arDoctor['NAME'];
        $this->url = $arDoctor['DETAIL_PAGE_URL'];
        $this->position = $arDoctor['PROPERTY_POSITION_VALUE']['TEXT'];
        $this->previewPicture = $arDoctor['PREVIEW_PICTURE'];
        $this->administrator = $arDoctor['PROPERTY_ADMINISTRATOR_VALUE'];
        $this->doctor = $arDoctor['PROPERTY_DOCTOR_VALUE'];
    }

    /**
     * make url based on post
     */
    public function makeUrl()
    {
        /*if ($this->administrator && $this->url) {
            $this->url = str_replace('/doctors/', '/about/administration/', $this->url);
        }*/
        return $this->url;
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
        $cacheId = '/MWI/Doctor_Reviews' . 'DId=' . $this->id . '_SiteId=' . SITE_ID;
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
                    'PROPERTY_DOCTOR' => $this->id,
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                    'PROPERTY_PATIENT_NAME',
                    'DATE_ACTIVE_FROM',
                    'PROPERTY_DIRECTION',
                    'PROPERTY_SERVICE',
                    'PROPERTY_DOCTOR',
                    'PROPERTY_CLINIC',
                )
            );

            $reviewsList = new ReviewList();
            while ($arReview = $obReviews->fetch()) {
                $review = new Review($arReview['ID']);
                $review->patientName = $arReview['PROPERTY_PATIENT_NAME_VALUE'];
                $review->publicationDate = $arReview['DATE_ACTIVE_FROM'];
                $review->directionId = $arReview['PROPERTY_DIRECTION_VALUE'];
                $review->serviceId = $arReview['PROPERTY_SERVICE_VALUE'];
                $review->doctorId = $arReview['PROPERTY_DOCTOR_VALUE'];
                $review->clinicId = $arReview['PROPERTY_CLINIC_VALUE'];

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
     * @return ClinicList
     */
    public function getClinics()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Doctor_Clinics' . 'DId=' . $this->id . '_SiteId=' . SITE_ID;
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
            $obTaggedCache->registerTag('iblock_id_' . Clinic::getIBlockId());
            //TODO: check dependent tags for this cache
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obClinics = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Clinic::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => CIBlockElement::SubQuery(
                        "PROPERTY_CLINICS",
                        array(
                            'IBLOCK_ID' => self::getIBlockId(),
                            'ACTIVE' => 'Y',
                            'ID' => $this->id,
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'DETAIL_PAGE_URL',
                )
            );

            $clinicsList = new ClinicList();
            while ($arClinic = $obClinics->getNext()) {
                $clinic = new Clinic($arClinic['ID']);
                $clinic->name = $arClinic['NAME'];
                $clinic->url = $arClinic['DETAIL_PAGE_URL'];

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

    /**
     * @return ServiceList
     */
    public function getServices()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Doctor_Services_' . 'DId=' . $this->id . '_SiteId=' . SITE_ID;
        $cachePath = '/services/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obServicesList = $vars['services'];
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
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arDoctor = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ID' => $this->id,
                ),
                false,
                array(),
                array(
                    'ID',
                    'PROPERTY_SERVICES',
                    'PROPERTY_OFFERS',
                )
            )->fetch();
            $obOffersList = new ServiceOfferList();
            foreach ($arDoctor['PROPERTY_OFFERS_VALUE'] as $offerId) {
                $obOffer = new ServiceOffer($offerId);
                $obOffersList->add($obOffer);
            }
            $obServicesList = $obOffersList->getServices();
            foreach ($arDoctor['PROPERTY_SERVICES_VALUE'] as $serviceId) {
                $obService = new Service($serviceId);
                $obServicesList->add($obService);
            }
            $obServicesList->makeData();
            foreach ($obServicesList->getList() as $obService) {
                $obServiceOffers = $obService->getOffers();
                $serviceOffersId = $obServiceOffers->getIds();
                $arSameOffersId = array_intersect($serviceOffersId, $arDoctor['PROPERTY_OFFERS_VALUE']);
                if (!empty($arSameOffersId)) {
                    foreach (array_diff($serviceOffersId, $arSameOffersId) as $offerId) {
                        $obServiceOffers->remove($offerId);
                    }
                }
                $arPrice = $obServiceOffers->getMinimumPrice();
                $obService->minimumPrice = $arPrice['price'];
                $obService->minimumDiscountPrice = $arPrice['discount_price'];
                $obServicesList->update($obService);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'services' => $obServicesList,
                )
            );
        }

        return $obServicesList;
    }

    /**
     * @return ServiceOfferList
     */
    public function getOffers()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Doctor_Offers_' . 'DId=' . $this->id . '_SiteId=' . SITE_ID;
        $cachePath = '/offers/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obOffersList = $vars['offers'];
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
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obOffers = CIBlockElement::getList(
                array('PROPERTY_SORT' => 'ASC', 'SORT' => 'ASC'),
                array(
                    'IBLOCK_ID' => ServiceOffer::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => CIBlockElement::SubQuery(
                        "PROPERTY_OFFERS",
                        array(
                            'IBLOCK_ID' => self::getIBlockId(),
                            'ACTIVE' => 'Y',
                            'ID' => $this->id,
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'PROPERTY_PRICE',
                )
            );
            $obOffersList = new ServiceOfferList();
            while ($arOffer = $obOffers->fetch()) {
                $obOffer = new ServiceOffer($arOffer['ID']);
                $obOffer->name = $arOffer['NAME'];
                $obOffer->price = $arOffer['PROPERTY_PRICE_VALUE'];
                if ($obOffer->price) {
                    $obOffer->makeDiscountPrice();
                }

                $obOffersList->add($obOffer);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'offers' => $obOffersList,
                )
            );
        }

        return $obOffersList;
    }

    /**
     * @return PersonalList
     */
    public static function getDoctors()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Doctors' . '_SiteId=' . SITE_ID;
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
             * add tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDoctors = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_DOCTOR' => true,
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                )
            );
            $obDoctorsList = new PersonalList();
            while ($arDoctor = $obDoctors->fetch()) {
                $obDoctor = new Personal($arDoctor['ID']);
                $obDoctor->name = $arDoctor['NAME'];

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
     * return int Id
     */
    public function getByName($name)
    {
        if (empty($name)) {
            return 0;
        }

        Loader::IncludeModule('iblock');

        $arPersonal = CIBlockElement::getList(
            array(),
            array(
                'IBLOCK_ID' => self::getIBlockId(),
                'ACTIVE' => 'Y',
                '=NAME' => $name,
            ),
            false,
            array(
                'nTopCount' => 1,
            ),
            array(
                'ID',
            )
        )->fetch();

        return $arPersonal['ID'] ? $arPersonal['ID'] : 0;
    }
}