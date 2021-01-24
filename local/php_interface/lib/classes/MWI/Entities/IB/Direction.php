<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class Direction
 * @package MWI
 */
class Direction implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var array $departments
     * @var string $url
     */

    const IBLOCK_ID = array(
        'ru' => 2,
        'en' => 43,
    );
	const MENU_IBLOCK_ID = array(
        'ru' => 75,
        'en' => 76,
    );
	
    const IBLOCK_TYPE = array(
        'ru' => 'catalog',
        'en' => 'catalog_en',
    );

    public $id;
    public $name;
    public $departments;
	public $departmentsIds;
    public $url;
	

    /**
     * Direction constructor.
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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_' . 'DId=' . $id;
        $cachePath = '/directions_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arDirection = $vars['direction'];
        } else {
            /**
             * start buffering the output
             */
            $obCache->startDataCache();

            /**
             * get data from database
             */
            $arDirection = CIBlockElement::getList(
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
                )
            )->getNext();

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'direction' => $arDirection,
                )
            );
        }

        /**
         * set data
         */
		 
        $this->name = $arDirection['NAME'];
        $this->url = $arDirection['DETAIL_PAGE_URL'];
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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_' . 'DId=' . $id;
        $cachePath = '/directions_offers_' . CUR_LANG . '/';

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
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . ServiceOffer::getIBlockId());
            $obTaggedCache->endTagCache();

            $obOffersList = new ServiceOfferList();
            $obServicesList = self::getServices();
            if (!$obServicesList->isEmpty()) {
                /**
                 * get data from database
                 */
                $obOffers = CIBlockElement::getList(
                    array(
                        'SORT' => 'ASC',
                    ),
                    array(
                        'IBLOCK_ID' => ServiceOffer::getIBlockId(),
                        'ACTIVE' => 'Y',
                        'PROPERTY_SERVICE' => $obServicesList->getIds(),
                    ),
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

                    $obOffer->makeDiscountPrice();
                    $obOffersList->add($obOffer);
                }
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
     * @return ServiceList
     */
    public function getServices( $limit = 10000 )
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
		 
		 
        if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_' . 'DId=' . $id . '_limit=' . $limit;
		
        $cachePath = '/directions_services_' . CUR_LANG . '/';

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
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Service::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obServices = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Service::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'PROPERTY_DIRECTION' => $this->id,
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'ID',
                )
            );
            $obServicesList = new ServiceList();
            while ($arService = $obServices->fetch()) {
                $obService = new Service($arService['ID']);
                $obServicesList->add($obService);
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
     * @param int $limit
     * @return DiseaseList
     */
    public function getDiseases($limit = 18)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
	    $cacheId = '/MWI/Direction_Diseases_' . 'DId=' .  $id . '_limit=' . $limit;
        $cachePath = '/directions_diseases_' . CUR_LANG . '/';

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
             * register tags for cache
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
                    'PROPERTY_DIRECTIONS' => $this->id,
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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		} 
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_Symptoms_' . 'DId=' .  $id . '_limit=' . $limit;
        $cachePath = '/directions_symptoms_' . CUR_LANG . '/';

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
             * register tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . Disease::getIBlockId());
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
                    'PROPERTY_DIRECTIONS' => $this->id,
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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		} 
		 
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_Questions_' . 'DId=' .  $id . '_limit=' . $limit;
        $cachePath = '/directions_questions_' . CUR_LANG . '/';

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
             * register tags for cache
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
                    'PROPERTY_SHOW_ON_DIRECTION_PAGE' => true,
                    'PROPERTY_DIRECTIONS' => $this->id,
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
                    'DATE_ACTIVE_FROM',
                )
            );
            $obQuestionsList = new QuestionList();
            while ($arQuestion = $obQuestions->getNext()) {
                $obQuestion = new Question($arQuestion['ID']);
                $obQuestion->name = $arQuestion['PROPERTY_PATIENT_NAME_VALUE'];
                $obQuestion->question = $arQuestion['PROPERTY_QUESTION_VALUE']['TEXT'];
                $obQuestion->answer = $arQuestion['PROPERTY_ANSWER_VALUE']['TEXT'];
                $obQuestion->publicationDate = $arQuestion['DATE_ACTIVE_FROM'];

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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}  
		
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_Recommendations_' . 'DId=' .  $id . '_limit=' . $limit;
        $cachePath = '/directions_recommendations_' . CUR_LANG . '/';

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
                    'PROPERTY_DIRECTION' => $this->id,
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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}   
		 
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_Reviews' . 'DId=' .  $id;
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
                    'PROPERTY_DIRECTION' => $this->id,
                    'PROPERTY_SHOW_ON_DIRECTION_PAGE' => true,
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
                $review->directionId = $this->id;

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
		if ( is_array( $this->id )){
			$id =  implode('_', $this->id);
		}
		else {
			$id =  $this->id;
		}   
		  
		 
		 
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Direction_Doctors_' . 'DId=' .  $id;
        $cachePath = '/directions_doctors_' . CUR_LANG . '/';

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
                    'PROPERTY_DIRECTION' => $this->id,
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
                $obDoctor = new Personal($arDoctor['ID']);
				if ( $arDoctor['PREVIEW_PICTURE'] )
					$pic = File::ResizeImageGet($arDoctor['PREVIEW_PICTURE'], array('width'=>285, 'height'=>380), BX_RESIZE_IMAGE_PROPORTIONAL);
				
				
				
                $previewPicture = array(
                    //'SMALL_SRC' => $arDoctor['PREVIEW_PICTURE'] ? File::GetPath($arDoctor['PREVIEW_PICTURE']) : '',
                    'SRC' => $arDoctor['PREVIEW_PICTURE'] ? $pic['src'] : '',
					'ALT' => $arDoctor['NAME'],
                );
                $obDoctor->name = $arDoctor['NAME'];
                $obDoctor->position = $arDoctor['PROPERTY_POSITION_VALUE']['TEXT'];
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

    /**
     * @param int $limit
     * @param array $arFilter
     * @return DirectionList
     */
    public static function getList($limit = 18, $arFilter = array())
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Directions_Limit=' . $limit . '_' . implode('-', $arFilter);
        $cachePath = '/directions_' . CUR_LANG . '/';

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
            $obDirections = CIBlockElement::getList(
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

            $directionsList = new DirectionList();
            while ($arDirection = $obDirections->fetch()) {
                $direction = new self($arDirection['ID']);

                $directionsList->add($direction);
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
        }

        return $directionsList;
    }

    /**
     * @return DirectionList
     */
    public static function getAll()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Directions';
        $cachePath = '/directions_' . CUR_LANG . '/';

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
            $obDirections = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                ),
                false,
                array(),
                array(
                    'ID',
                )
            );

            $directionsList = new DirectionList();
            while ($arDirection = $obDirections->fetch()) {
                $direction = new self($arDirection['ID']);

                $directionsList->add($direction);
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
        }

        return $directionsList;
    }
	
	
	public static function getMenu($limit = 18, $arFilter = array())
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
        
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/DirectionsMenu_Limit=' . $limit;
        $cachePath = '/directions_menu_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {

            $vars = $obCache->GetVars();
            $directionsList = $vars['directions'];
        } else {

            $obCache->startDataCache();


            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_75');
            //TODO: check dependent tags for this cache
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obDirections = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
					'NAME' => 'ASC',
                ),
                array_merge(
                    array(
                        'IBLOCK_ID' => 75,
                        'ACTIVE' => 'Y',
                    ),
                    $arFilter
                ),
                false,
                array(
                    'nTopCount' => $limit,
                ),
                array(
                    'NAME',
					'PROPERTY_link',
					'PROPERTY_blank',
                )
            );
			$arMenu = Array();
			
			
            while ($arDirection = $obDirections->fetch()) {
			

			
				$arMenu[] = Array(
					'NAME' => $arDirection['NAME'],
					'URL'  => $arDirection['PROPERTY_LINK_VALUE'],
					'BLANK'  => $arDirection['PROPERTY_BLANK_VALUE'],
				);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             
            $obCache->endDataCache(
                array(
                    'directions' => $arMenu,
                )
            );
        }*/

        return $arMenu;
    }
	
	
	
	
}