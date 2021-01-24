<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class Symptom
 * @package MWI
 */
class Symptom implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var string $url
     */
    const IBLOCK_ID = array(
        'ru' => 3,
        'en' => 47,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'health',
        'en' => 'health_en',
    );

    public $id;
    public $name;
    public $url;

    /**
     * Symptom constructor.
     * @param $id
     */
    public function __construct($id)
    {
        if ($this->isValidId($id)) {
            $this->id = $id;
        }
    }

    public function makeData()
    {
        // TODO: Implement makeData() method.
    }

    /**
     * @return SymptomList
     */
    public static function getList()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Symptoms';
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
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obSymptoms = CIBlockElement::getList(
                array(),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'DETAIL_PAGE_URL',
                )
            );
            $obSymptomsList = new DiseaseList();
            while ($arSymptom = $obSymptoms->getNext()) {
                $obSymptom = new Disease($arSymptom['ID']);
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
        $cacheId = '/MWI/Symptom_Recommendations_' . 'DId=' . $this->id . '_limit=' . $limit;
        $cachePath = '/symptoms_recommendations_' . CUR_LANG . '/';

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
                    'PROPERTY_SYMPTOM' => $this->id,
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
     * @param int $limit
     * @return DiseaseList
     */
    public function getDiseases($limit = 8)
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Symptom_Diseases_' . 'SId=' . $this->id . '_limit=' . $limit;
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
                    'PROPERTY_SYMPTOMS' => $this->id,
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
     * @return StockList
     */
    public function getStocks()
    {
        Loader::IncludeModule('iblock');

        global $DB;

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stocks_SymptomId=' . $this->id;
        $cachePath = '/stocks_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obStocksList = $vars['stocks'];
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
            $obTaggedCache->registerTag('iblock_id_' . Stock::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
            $obTaggedCache->endTagCache();

            $obStocksList = new StockList();

            $curDate = date($DB->DateFormatToPHP(CLang::GetDateFormat()), time());

            /**
             * get data from database
             */
            $obStocks = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => Stock::getIBlockId(),
                    'ACTIVE' => 'Y',
                    array(
                        'LOGIC' => 'AND',
                        array(
                            'LOGIC' => 'OR',
                            array(
                                'DATE_ACTIVE_TO' => false,
                            ),
                            array(
                                '>DATE_ACTIVE_TO' => $curDate,
                            )
                        ),
                        array(
                            'PROPERTY_SYMPTOMS' => $this->id,
                        )
                    ),
                ),
                false,
                array(),
                array(
                    'ID',
                    'NAME',
                    'PREVIEW_TEXT',
                    'PREVIEW_PICTURE',
                    'DATE_ACTIVE_TO',
                    'PROPERTY_AMOUNT',
                    'PROPERTY_PERCENTAGE',
                    'DETAIL_PAGE_URL',
                )
            );
            while ($arStock = $obStocks->getNext()) {
                if ($arStock['PREVIEW_PICTURE']) {
                    $picture = array(
                        'SRC' => File::GetPath($arStock['PREVIEW_PICTURE']),
                        'ALT' => $arStock['NAME'],
                    );
                } else {
                    $picture = array();
                }
                $obStock = new Stock($arStock['ID']);
                $obStock->name = $arStock['NAME'];
                $obStock->amount = $arStock['PROPERTY_AMOUNT_VALUE'];
                $obStock->percentage = $arStock['PROPERTY_PERCENTAGE_VALUE'];
                $obStock->url = $arStock['DETAIL_PAGE_URL'];
                $obStock->previewText = $arStock['~PREVIEW_TEXT'];
                $obStock->previewPicture = $picture;
                $obStock->expireDate = $arStock['DATE_ACTIVE_TO'] ? FormatDateFromDB($arStock['DATE_ACTIVE_TO'], Stock::DATE_FULL) : '';
                $obStock->expireDateCounter = trim($arStock['DATE_ACTIVE_TO']);

                $obStocksList->add($obStock);
            }

            $obCache->endDataCache(
                array(
                    'stocks' => $obStocksList,
                )
            );
        }

        return $obStocksList;
    }
}