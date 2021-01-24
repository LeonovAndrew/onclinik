function sendForm($form) {
    let query = {
            c : 'mwi:housecall.form',
            action : 'sendMessage',
            mode : 'class'
        },
        url = '/bitrix/services/main/ajax.php?' + $.param(query, true),
        request,
        formData = new FormData();

    formData.append('json', JSON.stringify({
        'name' : $form.find('input[name=name]').val(),
        'phone' : $form.find('input[name=phone]').val(),
        'text' : $form.find('textarea[name=text]').val(),
        'agreement' : $form.find('#personal-data').prop('checked'),
        'recaptcha' : $form.find('#g-recaptcha-response').val(),
    }));
    formData.append('sessid', BX.bitrix_sessid());
    formData.append('signedParameters', housecallFormParams.signedParameters);

    request = $.ajax({
        url: url,
        method: 'POST',
        processData : false,
        contentType: false,
        data: formData,
    });

    request.done(function(response) {
        let form = new FormErrors($form);

        if (response.status == 'error') {
            form.setErrors(response.errors);
        } else {
		
			ym(2120464,'reachGoal','Housecall-Form-Submit');	
			gtag('event','Submit',{'event_category':'Housecall-Form'});
			
		
            form.removeErrors();
            showPopupMsg(response.data.message);
        }
        grecaptcha.reset();
    });

    request.fail(function(jqXHR, textStatus) {
        grecaptcha.reset();
    });
}

$(document).ready(function() {

    let $form = $('.housecall-form');

    $form.on('submit', function(e) {
        e.preventDefault();

        sendForm($form);
    });
});