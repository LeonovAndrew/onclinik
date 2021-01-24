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

<form action="" method="POST" class="housecall-form" novalidate>
    <?php echo bitrix_sessid_post();?>
    <input checked class="input-checkbox" type="checkbox" required id="personal-data">
    <h3><?php echo getMessage('form_title');?></h3>
    <label class="label">
        <span>*</span>
        <input type="text" class="input" name="name" placeholder="<?php echo getMessage('name_placeholder');?>">
    </label>
    <label class="label">
        <span>*</span>
        <input type="tel" class="input" name="phone" placeholder="<?php echo getMessage('phone_placeholder');?>">
    </label>
    <textarea class="textarea" name="text" placeholder="<?php echo getMessage('comment_placeholder');?>"></textarea>
    <div class="housecall-form-wrap2">
        <label for="personal-data" class="label-checkbox">
            <span><?php echo getMessage('personal_data_agreement');?></span>
            <i></i>
        </label>
        <button type="submit" class="btn2"><?php echo getMessage('send_request');?></button>
    </div>
    <div class="housecall-captcha-wrap">
        <div class="housecall-captcha">
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY;?>"></div>
        </div>
        <button type="submit" class="btn2" onclick="gtag('event','Submit',{'event_category':'Housecall-Form'});ym(9386503,'reachGoal','Housecall-Form-Submit'); return true;"><?php echo getMessage('send_request');?></button>
    </div>
</form>

<script>
    var housecallFormParams = <?php echo json_encode([
        'signedParameters' => $this->getComponent()->getSignedParameters()
    ]);?>;
</script>