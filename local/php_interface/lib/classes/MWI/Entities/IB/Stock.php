<?php

namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class Stock
 * @package MWI
 */
class Stock implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var string DATE_SHORT
     * @var string DATE_FULL
     * @var int $id
     * @var string $name
     * @var int $amount
     * @var bool $percentage
     * @var string $url
     * @var string $previewText
     * @var string $detailText
     * @var array $previewPicture Array containing the following fields:
     *      $previewPicture = [
     *          'SRC' => (string) src.
     *          'ALT' => (string) alt.
     *      ]
     * @var array $detailPicture Array containing the following fields:
     *      $detailPicture = [
     *          'SRC' => (string) src.
     *          'ALT' => (string) alt.
     *      ]
     * @var string $expireDate
     * @var string $expireDateCounter
     */
    const IBLOCK_ID = array(
        'ru' => 28,
        'en' => 63,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'stocks',
        'en' => 'stocks_en',
    );
    const DATE_SHORT = 'DD MMMM YYYY';
    const DATE_FULL = 'DD MMMM YYYY HH:MI';

    public $id;
    public $name;
    public $amount;
    public $percentage = false;
    public $url;
    public $previewText;
    public $detailText;
    public $previewPicture;
    public $detailPicture;
    public $expireDate;
    public $expireDateCounter;

    /**
     * Stock constructor.
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
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stock_Id=' . $this->id;
        $cachePath = '/actions_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $arStock = $vars['stock'];
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
            $obStock = CIBlockElement::getList(
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
                    'PREVIEW_PICTURE',
                    'DETAIL_TEXT',
                    'DETAIL_PICTURE',
                    'DATE_ACTIVE_TO',
                    'PROPERTY_AMOUNT',
                    'PROPERTY_PERCENTAGE',
                    'DETAIL_PAGE_URL',
                )
            );

            $arStock = $obStock->getNext();
            $previewPicture = array(
                'SRC' => File::GetPath($arStock['PREVIEW_PICTURE']),
                'ALT' => $arStock['NAME'],
            );
            $detailPicture = array(
                'SRC' => File::GetPath($arStock['DETAIL_PICTURE']),
                'ALT' => $arStock['NAME'],
            );
            $arStock['PREVIEW_PICTURE'] = $previewPicture;
            $arStock['DETAIL_PICTURE'] = $detailPicture;

            $obCache->endDataCache(
                array(
                    'stock' => $arStock,
                )
            );
        }

        $this->name = $arStock['NAME'];
        $this->amount = $arStock['PROPERTY_AMOUNT_VALUE'];
        $this->percentage = $arStock['PROPERTY_PERCENTAGE_VALUE'];
        $this->url = $arStock['DETAIL_PAGE_URL'];
        $this->previewText = $arStock['~PREVIEW_TEXT'];
        $this->detailText = $arStock['~DETAIL_TEXT'];
        $this->previewPicture = $arStock['PREVIEW_PICTURE'];
        $this->detailPicture = $arStock['DETAIL_PICTURE'];
        $this->expireDate = FormatDateFromDB($arStock['DATE_ACTIVE_TO'], self::DATE_FULL);
        $this->expireDateCounter = trim($arStock['DATE_ACTIVE_TO']);
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
        $cacheId = '/MWI/Stock_Clinics_' . 'SId=' . $this->id;
        $cachePath = '/clinics_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obClinics = $vars['clinics'];
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
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obStock = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => $this->id,
                ),
                false,
                array(),
                array(
                    'ID',
                    'PROPERTY_CLINICS',
                )
            );
            $obClinics = new ClinicList();
            $arStock = $obStock->fetch();

            if (!empty($arStock['PROPERTY_CLINICS_VALUE'])) {
                foreach ($arStock['PROPERTY_CLINICS_VALUE'] as $clinicId) {
                    $obClinic = new Clinic($clinicId);

                    $obClinics->add($obClinic);
                }

                if ($obClinics->size()) {
                    $obClinics->makeData();
                }
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'clinics' => $obClinics,
                )
            );
        }

        return $obClinics;
    }

    /**
     * @return ProgramList
     */
    public function getPrograms()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stock_Programs_' . 'SId=' . $this->id;
        $cachePath = '/programs_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $obPrograms = $vars['programs'];
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
            $obTaggedCache->registerTag('iblock_id_' . Program::getIBlockId());
            $obTaggedCache->endTagCache();

            /**
             * get data from database
             */
            $obStock = CIBlockElement::getList(
                array(
                    'SORT' => 'ASC',
                ),
                array(
                    'IBLOCK_ID' => self::getIBlockId(),
                    'ACTIVE' => 'Y',
                    'ID' => $this->id,
                ),
                false,
                array(),
                array(
                    'ID',
                    'PROPERTY_PROGRAMS',
                )
            );
            $obPrograms = new ProgramList();
            $arStock = $obStock->fetch();

            if (!empty($arStock['PROPERTY_PROGRAMS_VALUE'])) {
                foreach ($arStock['PROPERTY_PROGRAMS_VALUE'] as $programId) {
                    $obProgram = new Program($programId);

                    $obPrograms->add($obProgram);
                }

                if ($obPrograms->size()) {
                    $obPrograms->makeData();
                }
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'programs' => $obPrograms,
                )
            );
        }

        return $obPrograms;
    }

    /**
     * @description Get all directions linked in stocks
     * @return DirectionList
     */
    public static function getAllDirections()
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stocks_Directions';
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
             * add tags for cache
             */
            $obTaggedCache = Application::getInstance()->getTaggedCache();
            $obTaggedCache->startTagCache($cachePath);
            $obTaggedCache->registerTag('iblock_id_' . Direction::getIBlockId());
            $obTaggedCache->registerTag('iblock_id_' . self::getIBlockId());
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
     * @description Get all clinics linked in stocks
     * @return ClinicList
     */
    public static function getAllClinics()
    {
        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Stocks_Clinics';
        $cachePath = '/clinics_' . CUR_LANG . '/';

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
}