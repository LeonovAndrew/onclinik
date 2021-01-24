<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \CIBlockElement as CIBlockElement,
    \Bitrix\Main\Application as Application,
    \CPHPCache as CPHPCache;

/**
 * Class Service
 * @package MWI
 */
class Service implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var int $directionId
     * @var string $name
     * @var string $previewText
     * @var string $url
     * @var array $type Array containing the following fields:
     *      $type = [
     *          'ID' => (int) id.
     *          'NAME' => (string) name.
     *          'CODE' => (string) code.
     *      ]
     * @var int $minimumPrice
     * @var int $minimumDiscountPrice
     */
    const IBLOCK_ID = array(
        'ru' => 1,
        'en' => 46,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'catalog',
        'en' => 'catalog_en',
    );

    public $id;
    public $directionId;
    public $name;
    public $previewText;
    public $url;
    public $type;
    public $minimumPrice = 0;
    public $minimumDiscountPrice = 0;

    /**
     * Service constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
        $this->directionId = 0;
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
        $cacheId = '/MWI/Service_' . 'SId=' . $this->id . '_DId=' . $this->directionId;
        $cachePath = '/services/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arType = $vars['type'];
            $arService = $vars['service'];
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
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->registerTag('hlblock_table_' . ServicesTypesTable::getTableName());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arType = array();
            $arService = CIBlockElement::getList(
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
                    'PREVIEW_TEXT',
                    'PROPERTY_TYPE',
                    'PROPERTY_DIRECTION',
                    'DETAIL_PAGE_URL',
                )
            )->getNext();

            if (!empty($arService['PROPERTY_TYPE_VALUE'])) {
                $arServiceType = ServicesTypesTable::getList(
                    array(
                        "select" => array(
                            'ID',
                            'NAME' => 'UF_NAME',
                            'XML_ID' => 'UF_XML_ID',
                            'CODE' => 'UF_CODE',
                        ),
                        "order" => array(),
                        "filter" => array(
                            'UF_XML_ID' => $arService['PROPERTY_TYPE_VALUE']
                        ),
                    )
                )->fetch();

                $arType = array(
                    'ID' => $arServiceType['ID'],
                    'NAME' => $arServiceType['NAME'],
                    'CODE' => $arServiceType['CODE'],
                );
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'type' => $arType,
                    'service' => $arService,
                )
            );
        }

        $this->type = $arType;
        $this->name = $arService['NAME'];
        $this->previewText = $arService['~PREVIEW_TEXT'];
        $this->url = $arService['DETAIL_PAGE_URL'];
        $this->directionId = $arService['PROPERTY_DIRECTION_VALUE'];
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
        $cacheId = '/MWI/Service_Offers_' . 'SId=' . $this->id . '_DId=' . $this->directionId;
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
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obOffersList = new ServiceOfferList();
            $arFilter = array(
                'IBLOCK_ID' => ServiceOffer::getIBlockId(),
                'ACTIVE' => 'Y',
                'PROPERTY_SERVICE' => $this->id,
            );

            $obOffers = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                $arFilter,
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'PROPERTY_PRICE',
                )
            );

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
     * @param int $limit
     * @return DiseaseList
     */
    public function getDiseases($limit = 18)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Service_Diseases_' . 'SId=' . $this->id . '_limit=' . $limit;
        $cachePath = '/diseases/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obDiseasesList = $vars['diseases'];
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
            $obTaggedCache->registerTag('iblock_id_' . Disease::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDiseases = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Disease::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_SERVICES' => $this->id,
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                    'NAME',
                    'DETAIL_PAGE_URL',
                )
            );
            $obDiseasesList = new DiseaseList();
            while ($arDisease = $obDiseases->getNext()) {
                $obDisease = new Disease($arDisease['ID']);
                $obDisease->name = $arDisease['NAME'];
                $obDisease->url = $arDisease['DETAIL_PAGE_URL'];

                $obDiseasesList->add($obDisease);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'diseases' => $obDiseasesList,
                )
            );
        }

        return $obDiseasesList;
    }

    /**
     * @param int $limit
     * @return SymptomList
     */
    public function getSymptoms($limit = 18)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Service_Symptoms_' . 'SId=' . $this->id . '_limit=' . $limit;
        $cachePath = '/symptoms/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obSymptomsList = $vars['symptoms'];
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
            $obTaggedCache->registerTag('iblock_id_' . Symptom::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obSymptoms = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Symptom::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_SERVICES' => $this->id,
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                    'NAME',
                    'DETAIL_PAGE_URL',
                )
            );
            $obSymptomsList = new SymptomList();
            while ($arSymptom = $obSymptoms->getNext()) {
                $obSymptom = new Symptom($arSymptom['ID']);
                $obSymptom->name = $arSymptom['NAME'];
                $obSymptom->url = $arSymptom['DETAIL_PAGE_URL'];

                $obSymptomsList->add($obSymptom);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'symptoms' => $obSymptomsList,
                )
            );
        }

        return $obSymptomsList;
    }

    /**
     * @param int $limit
     * @return QuestionList
     */
    public function getQuestions($limit = 2)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Service_Questions_' . 'SId=' . $this->id . '_limit=' . $limit;
        $cachePath = '/questions/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obQuestionsList = $vars['questions'];
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
            $obTaggedCache->registerTag('iblock_id_' . Question::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obQuestions = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Question::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_SHOW_ON_SERVICE_PAGE' => true,
					'PROPERTY_SERVICES' => $this->id,
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                    'PROPERTY_PATIENT_NAME',
                    'PROPERTY_QUESTION',
                    'PROPERTY_ANSWER',
                )
            );
            $obQuestionsList = new QuestionList();
            while ($arQuestion = $obQuestions->getNext()) {
                $obQuestion = new Question($arQuestion['ID']);
                $obQuestion->name = $arQuestion['PROPERTY_PATIENT_NAME_VALUE'];
                $obQuestion->question = $arQuestion['PROPERTY_QUESTION_VALUE']['TEXT'];
                $obQuestion->answer = $arQuestion['PROPERTY_ANSWER_VALUE']['TEXT'];

                $obQuestionsList->add($obQuestion);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'questions' => $obQuestionsList,
                )
            );
        }

        return $obQuestionsList;
    }

    /**
     * @param int $limit
     * @return RecommendationList
     */
    public function getRecommendations($limit = 2)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Service_Recommendations_' . 'SId=' . $this->id . '_limit=' . $limit;
        $cachePath = '/services_recommendations_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obRecommendationsList = $vars['recommendations'];
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
            $obTaggedCache->registerTag('iblock_id_' . Recommendation::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obRecommendations = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Recommendation::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_SERVICES' => $this->id,
                    //'PROPERTY_DOCTOR.ACTIVE' => 'Y',
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                    'NAME',
                    'PREVIEW_TEXT',
                )
            );
            $obRecommendationsList = new RecommendationList();
            while ($arRecommendation = $obRecommendations->getNext()) {
                $obRecommendation = new Recommendation($arRecommendation['ID']);
                $obRecommendation->name = $arRecommendation['NAME'];
                $obRecommendation->text = $arRecommendation['PREVIEW_TEXT'];

                $obRecommendationsList->add($obRecommendation);
            }
            $obRecommendationsList->makeData();

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'recommendations' => $obRecommendationsList,
                )
            );
        }

        return $obRecommendationsList;
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
        $cacheId = '/MWI/Service_Reviews' . 'SId=' . $this->id;
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
                    'PROPERTY_SERVICE' => $this->id,
                    'PROPERTY_SHOW_ON_SERVICE_PAGE' => true,
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
                    'DETAIL_TEXT',
                )
            );

            $reviewsList = new ReviewList();
            while ($arReview = $obReviews->fetch()) {
                $review = new Review($arReview['ID']);
                $review->patientName = $arReview['PROPERTY_PATIENT_NAME_VALUE'];
                $review->text = $arReview['DETAIL_TEXT'];
                $review->publicationDate = $arReview['DATE_ACTIVE_FROM'];
                $review->doctorId = $arReview['PROPERTY_DOCTOR_VALUE'];
                $review->serviceId = $this->id;

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
        $cacheId = '/MWI/Service_Doctors_' . 'SId=' . $this->id;
        $cachePath = '/doctors_' . CUR_LANG . '/';

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
            $obTaggedCache->registerTag('iblock_id_' . Personal::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDoctors = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Personal::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_SERVICES' => $this->id,
                    'PROPERTY_DOCTOR' => true,
                    'PROPERTY_DIRECTION' => $this->directionId ? $this->directionId : '',
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'DETAIL_PAGE_URL',
                    'PREVIEW_PICTURE',
                    'PROPERTY_POSITION',
                )
            );
            $obDoctorsList = new PersonalList();
            while ($arDoctor = $obDoctors->getNext()) {
                $previewPicture = array(
                    'SRC' => $arDoctor['PREVIEW_PICTURE'] ? File::GetPath($arDoctor['PREVIEW_PICTURE']) : '',
                    'ALT' => $arDoctor['NAME'],
                );
	            $obDoctor = new Personal($arDoctor['ID']);
                $obDoctor->name = $arDoctor['NAME'];
                //$obDoctor->position = $arDoctor['PROPERTY_POSITION_VALUE']['TEXT'];
				$obDoctor->position = '123123123';
                $obDoctor->previewPicture = $previewPicture;
                $obDoctor->url = $arDoctor['DETAIL_PAGE_URL'];

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
}