<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>


<div class="ajax_service_form">
	<h2><?=$arResult["FORM_TITLE"]?></h2>

	<?if ($arResult["isFormNote"] != "Y"):?>
		<?=$arResult["FORM_HEADER"]?>
	<?endif;?>
	
	<?if ($arResult["isFormErrors"] == "Y"):?>
	
		<?=$arResult["FORM_ERRORS_TEXT"];?>
	<?endif;?>

	<?=$arResult["FORM_NOTE"]?>
	

	<?=$arResult["FORM_DESCRIPTION"]?>

<form action="" method="POST" class="creditFeedback-form reviews-feedback-form">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
		
		$name = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['FIELD_ID'];
		$type = $arQuestion['STRUCTURE'][0]['FIELD_TYPE'];
		$value = $arResult['arrVALUES'][$name];
	?>
	<div class="reviews-textarea-wrap">
		<?if ($arQuestion["REQUIRED"] == "Y"):?><span>*</span><?endif;?>
		<input type="<?=$type?>" value="<?=$value?>" class="input" name="<?=$name?>" placeholder="<?=$arQuestion['CAPTION']?>">
	</div>
	

	
	<?
		}
	} //endwhile
	?>
	
	<?
if($arResult["isUseCaptcha"] == "Y")
{
?>

	<div class="reviews-textarea-wrap">
		<span>*</span>
		<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
		<input type="text" placeholder="<?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?>" name="captcha_word" size="30" maxlength="50" value="" class="input" style="width: 50%; float: left;"/>
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" style="height: 54px;width: 200px;margin-left: 10px;">
	</div>

	
<?
} // isUseCaptcha
?>
	
	<div class="reviews-textarea-wrap">
		<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" class="btn2" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
	</div>
<p>
<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<?=$arResult["FORM_FOOTER"]?>
</div>