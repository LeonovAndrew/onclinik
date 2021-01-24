<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache,
    \CLang as CLang;

/**
 * Class Disease
 * @package MWI
 */
class Disease implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var int $id
     * @var string $name
     * @var string $url
     * @var string $letter
     */
    const IBLOCK_ID = array(
        'ru' => 4,
        'en' => 51,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'health',
        'en' => 'health_en',
    );

    public $id;
    public $name;
    public $url;
    public $letter;

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
     * @return DiseaseList
     */
    public static function getList()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Diseases';
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
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $arLetters = Alphabet::getList();

            $obDiseases = CIBlockElement::getList(
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
                    'PROPERTY_LETTER',
                    'DETAIL_PAGE_URL',
                )
            );
            $obDiseasesList = new DiseaseList();
            while ($arDisease = $obDiseases->getNext()) {
                $obDisease = new Disease($arDisease['ID']);
                $obDisease->name = $arDisease['NAME'];
                $obDisease->url = $arDisease['DETAIL_PAGE_URL'];
                $obDisease->letter = $arLetters[$arDisease['PROPERTY_LETTER_VALUE']]['NAME'];

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
        $cacheId = '/MWI/Disease_Recommendations_' . 'DId=' . $this->id . '_limit=' . $limit;
        $cachePath = '/diseases_recommendations_' . CUR_LANG . '/';

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
                    'PROPERTY_DISEASE' => $this->id,
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
     * @return StockList
     */
    public function getStocks( $directionID = '' )
    {
        Loader::IncludeModule('iblock');

        global $DB;

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stocks_DiseaseId=' . $this->id;
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
                            'LOGIC' => 'OR',
                            array(
								'PROPERTY_DISEASES' => $this->id,
							),
                            array(
								'PROPERTY_DIRECTIONS' => $directionID,
							),
                        ),
                      

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
					'PROPERTY_DIRECTIONS',
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
				$obStock->direction = $arStock['PROPERTY_DIRECTIONS_VALUE'];
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