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

<form enctype="multipart/form-data" action="" method="POST" class="vacancy-form">
    <?php echo bitrix_sessid_post();?>
    <input name="vacancy" type="hidden" value="<?php echo $arParams['vacancy_id'];?>">
    <input checked class="input-checkbox" name="personal-data" type="checkbox" required id="personal-data">
    <h2><?php echo getMessage('form_title');?></h2>
    <label class="label">
        <span>*</span>
        <input class="input" type="text" name="name" placeholder="<?php echo getMessage('name_placeholder');?>" value="">
    </label>
    <label class="label">
        <span>*</span>
        <input class="input" type="tel" name="phone" placeholder="<?php echo getMessage('phone_placeholder');?>" value="">
    </label>
    <label class="label label-no-required">
        <input class="input" type="email" name="email" placeholder="<?php echo getMessage('email_placeholder');?>">
    </label>
    <textarea name="text" class="textarea" placeholder="<?php echo getMessage('comment_placeholder');?>"></textarea>
    <div class="vacancy-form-input-file">
        <input class="file" name="file" type="file">
    </div>
    <label for="personal-data" class="label-checkbox">
        <span><?php echo getMessage('personal_data_agreement');?></span>
        <i></i>
    </label>
    <div class="vacancy-form-wrap">
        <div class="vacancy-captcha">
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY;?>"></div>
        </div>
        <button type="submit" class="btn2"onclick="gtag('event','Submit',{'event_category':'Vacancy-Form'});ym(9386503,'reachGoal','Vacancy-Form-Submit'); return true;">
<?php echo getMessage('send_request');?></button>
    </div>
</form>

<script>
    var vacancyFormParams = <?php echo json_encode([
        'signedParameters' => $this->getComponent()->getSignedParameters()
    ]);?>;
</script>