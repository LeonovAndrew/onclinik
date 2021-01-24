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

<div class="reviews-feedback" id="feedback">
    <h2><?php echo getMessage('form_title');?></h2>
    <form action="" method="POST" class="reviews-feedback-form review-form" novalidate>
        <?php echo bitrix_sessid_post();?>
        <input class="input-checkbox" type="checkbox" name="personal-data" required id="personal-data">
        <input class="radio-checkbox" type="checkbox" name="accommodation" required id="consent-accommodation">
        <div class="reviews-feedback-form-wrap1">
            <label>
                <span style="color: #e31e23;">*</span>
                <input type="text" name="name" placeholder="<?php echo getMessage('name_placeholder');?>" required>
            </label>
            <label>
                <span style="color: #e31e23;">*</span>
                <input type="email" name="email" placeholder="<?php echo getMessage('email_placeholder');?>" required>
            </label>
            <label>
                <span style="color: #e31e23;">*</span>
                <input type="tel" name="phone" placeholder="<?php echo getMessage('phone_placeholder');?>" required>
            </label>
        </div>
        <div class="reviews-feedback-form-wrap2">
            <select name="direction">
                <?php
                foreach ($arResult['directions'] as $arDirection) {
                    ?>
                    <option value="<?php echo $arDirection['id'];?>"<?php echo $arDirection['selected'] ? ' selected' : '';?>><?php echo $arDirection['name'];?></option>
                    <?php
                }
                ?>
            </select>
            <select name="clinic">
                <?php
                foreach ($arResult['clinics'] as $arClinic) {
                    ?>
                    <option value="<?php echo $arClinic['id'];?>"<?php echo $arClinic['selected'] ? ' selected' : '';?>><?php echo $arClinic['name'];?></option>
                    <?php
                }
                ?>
            </select>
            <label>
                <input type="text" name="nameDoctor" id="nameDoctor" autocomplete="off" placeholder="<?php echo getMessage('doctor_name_placeholder');?>" value="<?php echo $arResult['doctor'];?>" required>
            </label>
        </div>
        <div class="reviews-textarea-wrap">
            <span>*</span>
            <textarea name="text" required placeholder="<?php echo getMessage('comment_placeholder');?>"></textarea>
        </div>
        <div class="reviews-feedback-form-wrap3">
            <div class="reviews-feedback-checkbox-container">
                <div class="reviews-feedback-checkbox-wrap">
                    <label for="personal-data" class="label-checkbox personal-data">
                        <span><?php echo getMessage('personal_data_agreement');?></span>
                        <i></i>
                    </label>
                </div>
                <div class="reviews-feedback-checkbox-wrap">
                    <label for="consent-accommodation" class="radio-label accommodation">
                        <span><?php echo getMessage('accommodation_consent');?></span>
                        <i></i>
                    </label>
                </div>
            </div>
            <div class="reviews-feedback-btn-wrap">
                <button type="submit" class="btn2" onclick="gtag('event','Submit',{'event_category':'Feedback-Form'});ym(9386503,'reachGoal','Feedback-Form-Submit'); return true;">
<?php echo getMessage('send_request');?></button>
            </div>
        </div>
    </form>
</div>

<script>
    var vacancyFormParams = <?php echo json_encode([
        'signedParameters' => $this->getComponent()->getSignedParameters()
    ]);?>,
        hintsDoctors = <?php echo json_encode($arResult['hints_doctors']);?>;
</script>
