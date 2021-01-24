<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Loader,
    Bitrix\Main\Application,
    MWI\Question,
    MWI\Device;

Loader::IncludeModule('iblock');
$APPLICATION->SetTitle("Вопрос-ответ");
?>

<section class="questions">
    <div class="container">
        <div class="questions-container">
            <div class="questions-wrap1">
                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>

                <div class="questions-title">
                    <h1><?php $APPLICATION->ShowTitle();?></h1>
                    <a href="#question" class="btn3"><?php echo getMessage('ask_a_question');?></a>
                </div>
                <div id="questions-wrap">
                    <?php
                    $request = Application::getInstance()->getContext()->getRequest();
                    $getParams = $request->getQueryList();
                    $isAjax = $getParams->getRaw('ajax') == 'Y';
                    $isAjaxFilter = $getParams->getRaw('ajax_filter') == 'Y';

                    if ($isAjaxFilter) {
                        $APPLICATION->RestartBuffer();
                    }

                    $filterRes = $APPLICATION->IncludeComponent(
                        'mwi:questions.filter',
                        '',
                        array(
                            'FILTER_NAME' => 'arQuestionsFilter',
                        )
                    );
                    ?>
                    <div id="questions">
                        <?php
                        if ($isAjax) {
                            $APPLICATION->RestartBuffer();
                        }

                        $APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "questions",
                            array(
                                "IBLOCK_TYPE" => Question::getIBlockType(),
                                "IBLOCK_ID" => Question::getIBlockId(),
                                "NEWS_COUNT" => $filterRes['displayed']['value'] ? $filterRes['displayed']['value'] : Question::getDisplayed()['value'],
                                "SORT_BY1" => 'SORT',
                                "SORT_ORDER1" => 'ASC',
                                "FIELD_CODE" => array(
                                    'ID',
                                    'NAME',
                                    'DETAIL_TEXT',
                                    'DATE_ACTIVE_FROM',
                                ),
                                "PROPERTY_CODE" => array(
                                    'PATIENT_NAME',
                                    'QUESTION',
                                    'ANSWER',
                                ),
                                "SET_TITLE" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_STATUS_404" => "N",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600000",
                                "CACHE_FILTER" => "Y",
                                "CACHE_GROUPS" => "Y",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "FILTER_NAME" => 'arQuestionsFilter',
                                "PAGER_TEMPLATE" => 'show_more_questions',
                                "PAGER_BOTTOM_TEMPLATE" => "bottom",
                            ),
                            false
                        );

                        $arDisplayed = array(
                            'items' => Question::DISPLAYED,
                            'current_index' => $filterRes['displayed']['index'],
                        );
                        ?>

                        <div class="reviews-container-btn">
                            <div class="reviews-radio-wrap1">
                                <?php
                                $device = Device::isMobile() ? 'mobile' : 'desktop';
                                foreach ($arDisplayed['items'] as $index => $arItem) {
                                    ?>
                                    <label>
                                        <input <?php echo $arDisplayed['current_index'] == $index ? 'checked' : '';?> type="radio" name="quantity" value="<?php echo $index;?>">
                                        <span><?php echo $arItem['desktop'];?> <span><?php echo $arItem['mobile'];?></span> <i><?php echo getSuffix($arItem[$device], array('вопрос', 'вопроса', 'вопросов'));?></i></span>
                                    </label>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            $APPLICATION->showViewContent('pagination');
                            ?>
                        </div>

                        <?php
                        if ($isAjax) {
                            die();
                        }
                        ?>
                    </div>

                    <?php
                    if ($isAjaxFilter) {
                        die();
                    }
                    ?>
                </div>
                <?php
                $APPLICATION->IncludeComponent(
                    'mwi:question.form',
                    '',
                    array(
                        'IBLOCK_ID' => Question::getIBlockId(),
                        'EVENT_NAME' => 'REVIEW_FORM',
                        'SUCCESS_MSG' => 'Ваша заявка успешно отправлена!',
                    )
                );
                ?>

                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_RECURSIVE" => "Y",
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "",
                        "PATH" => "/include/tools/breadcrumbs_mobile.php"
                    ),
                    false,
                    array(
                        'HIDE_ICONS' => 'Y'
                    )
                );
                ?>
            </div>
        </div>
    </div>
</section>

<?php
$APPLICATION->IncludeFile(
    SITE_DIR . "/include/map.php",
    array(),
    array(
        "MODE" => "html",
        "NAME" => "Карта клиник",
    )
);
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>