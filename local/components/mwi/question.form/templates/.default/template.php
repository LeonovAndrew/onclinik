<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<form action="#" id="question" class="vacancy-form" novalidate>
    <?php echo bitrix_sessid_post();?>
    <input checked class="input-checkbox" type="checkbox" id="personal-data">
    <h2><?php echo getMessage('form_title');?></h2>
    <label class="label">
        <span>*</span>
        <input class="input" type="text" name="name" placeholder="<?php echo getMessage('name_placeholder');?>">
    </label>
    <label class="label">
        <span>*</span>
        <input class="input" type="email" name="email" placeholder="<?php echo getMessage('email_placeholder');?>">
    </label>
    <div class="vacancy-select-wrap">
        <select name="direction">
            <?php
            foreach ($arResult['directions'] as $arDirection) {
                ?>
                <option value="<?php echo $arDirection['id'];?>"<?php echo $arDirection['selected'] ? ' selected' : '';?>><?php echo $arDirection['name'];?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="textarea-wrap">
        <span>*</span>
        <textarea class="textarea" name="text" placeholder="<?php echo getMessage('comment_placeholder');?>"></textarea>
    </div>
    <label for="personal-data" class="label-checkbox">
        <span><?php echo getMessage('personal_data_agreement');?></span>
        <i></i>
    </label>
    <div class="vacancy-form-wrap">
        <div class="vacancy-captcha">
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY;?>"></div>
        </div>
        <button type="submit" class="btn2" onclick="gtag('event','Open',{'event_category':'QuestionForm','event_label':'Question-Form-Open'});ym(9386503,'reachGoal','Question-Form-Open'); return true;"><?php echo getMessage('send_request');?></button>
    </div>
</form>

<script>
    var questionFormParams = <?php echo json_encode([
        'signedParameters' => $this->getComponent()->getSignedParameters()
    ]);?>;
</script>
