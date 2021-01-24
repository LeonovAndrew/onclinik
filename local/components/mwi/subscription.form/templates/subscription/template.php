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

<section class="modal" id="subscription_modal">
    <button class="close_modal">
        <span></span>
        <span></span>
    </button>

    <div class="modal_title"><?php echo getMessage('subscribe_form_title');?></div>

    <form action="#" class="reviews-feedback-form ajax_submit subscription-form" novalidate>
        <?php echo bitrix_sessid_post();?>
        <input checked class="input-checkbox" type="checkbox" required id="personal-data-subscribe">

        <div class="reviews-feedback-form-wrap1">
            <label>
                <input type="email" name="email" placeholder="<?php echo getMessage('subscribe_email_placeholder');?>" required class="center_text">
            </label>
        </div>

        <div class="vacancy-form-wrap">
            <button type="submit" class="btn2"><?php echo getMessage('subscribe_send_request');?></button>
        </div>

        <label for="personal-data-subscribe" class="label-checkbox">
            <span><?php echo getMessage('subscribe_personal_data_agreement');?></span>
            <i></i>
        </label>
    </form>
</section>

<script>
    var subscriptionFormParams = <?php echo json_encode([
        'signedParameters' => $this->getComponent()->getSignedParameters()
    ]);?>;
</script>