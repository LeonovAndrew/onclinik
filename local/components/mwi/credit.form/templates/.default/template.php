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

<form action="" method="POST" class="creditFeedback-form">
    <?php echo bitrix_sessid_post();?>
    <input name="bank" type="hidden" value="<?php echo $arParams['bank_id'];?>">
    <input checked class="input-checkbox" type="checkbox" id="personal-data">
    <h2><?php echo getMessage('form_title');?></h2>
    <label class="label">
        <span>*</span>
        <input class="input" type="text" name="name" placeholder="<?php echo getMessage('name_placeholder');?>">
    </label>
    <label class="label">
        <span>*</span>
        <input class="input" type="tel" name="phone" placeholder="<?php echo getMessage('phone_placeholder');?>">
    </label>
    <label class="label label-no-required">
        <span>*</span>
        <input class="input" type="email" name="email" placeholder="<?php echo getMessage('email_placeholder');?>">
    </label>
    <label for="personal-data" class="label-checkbox">
        <span><?php echo getMessage('personal_data_agreement');?></span>
        <i></i>
    </label>
    <div class="creditFeedback-form-wrap">
        <div class="vacancy-captcha">
            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY;?>"></div>
        </div>
        <button type="submit" class="btn2"><?php echo getMessage('send_request');?></button>
    </div>
</form>

<script>
    var vacancyFormParams = <?php echo json_encode([
        'signedParameters' => $this->getComponent()->getSignedParameters()
    ]);?>;
</script>