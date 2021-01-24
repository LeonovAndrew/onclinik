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
                    <a href="#question" class="btn3" onclick="gtag('event','Open',{'event_category':'QuestionForm','event_label':'Question-Form-Open'});ym(2120464,'reachGoal','Question-Form-Open'); return true;"><?php echo getMessage('ask_a_question');?></a>
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
		"IBLOCK_TYPE" => "-",
		"IBLOCK_ID" => Question::getIBlockId(),
		"NEWS_COUNT" => $filterRes["displayed"]["value"]?$filterRes["displayed"]["value"]:Question::getDisplayed()["value"],
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "DETAIL_TEXT",
			3 => "DATE_ACTIVE_FROM",
			4 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "PATIENT_NAME",
			2 => "QUESTION",
			3 => "ANSWER",
			4 => "",
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
		"FILTER_NAME" => "arQuestionsFilter",
		"PAGER_TEMPLATE" => "show_more_questions",
		"PAGER_BOTTOM_TEMPLATE" => "bottom",
		"COMPONENT_TEMPLATE" => "questions",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
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
                        'EVENT_NAME' => 'QUESTION_FORM',
                        'SUCCESS_MSG' => 'Ваш вопрос успешно отправлен!',
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