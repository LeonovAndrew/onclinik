<?php


namespace MWI;

use \Bitrix\Main\Loader as Loader,
    \Bitrix\Main\Application as Application,
    \CIBlockElement as CIBlockElement,
    \CPHPCache as CPHPCache;

/**
 * Class Question
 * @package MWI
 */
class Question implements IBEntityInterface
{
    use IBEntityValidatorTrait,
        LangIBInfoTrait,
        DisplayedTrait;

    /**
     * @var array IBLOCK_ID
     * @var array IBLOCK_TYPE
     * @var array DISPLAYED
     * @var string DISPLAYED_COOKIE
     * @var string DATE_SHORT
     * @var string DATE_FULL
     * @var int $id
     * @var string $name
     * @var string $question
     * @var string $answer
     * @var string $publicationDate
     */
    const IBLOCK_ID = array(
        'ru' => 31,
        'en' => 48,
    );
    const IBLOCK_TYPE = array(
        'ru' => 'FAQ',
        'en' => 'FAQ_en',
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
    const DISPLAYED_COOKIE = 'questions_displayed';
    const DATE_SHORT = 'DD.MM.YYYY';
    const DATE_FULL = 'DD MMMM YYYY HH:MI';

    public $id;
    public $name;
    public $question;
    public $answer;
    public $publicationDate;

    /**
     * Question constructor.
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
     * @return QuestionList
     */
    public static function getAll()
    {
        Loader::IncludeModule('iblock');

        /**
         * cache params
         */
        $cacheTtl = 360000;
        $obCache = new CPHPCache();
        $cacheId = '/MWI/Questions';
        $cachePath = '/questions_' . CUR_LANG . '/';

        if ($obCache->InitCache($cacheTtl, $cacheId, $cachePath)) {
            /**
             * cache is exist
             */

            /**
             * get data from cache
             */
            $vars = $obCache->GetVars();
            $questionsList = $vars['questions'];
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
            $obQuestions = CIBlockElement::getList(
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

            $questionsList = new QuestionList();
            while ($arQuestion = $obQuestions->fetch()) {
                $question = new self($arQuestion['ID']);

                $questionsList->add($question);
            }

            /**
             * write pre-buffered output to the cache file
             * with additional variables
             */
            $obCache->endDataCache(
                array(
                    'questions' => $questionsList,
                )
            );
        }

        return $questionsList;
    }
}
