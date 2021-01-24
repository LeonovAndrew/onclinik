function sendForm($form) {
    let query = {
            c: 'mwi:vacancy.form',
            action: 'sendMessage',
            mode: 'class'
        },
        url = '/bitrix/services/main/ajax.php?' + $.param(query, true),
        request,
        formData = new FormData($form[0]);

    formData.append('json', JSON.stringify({
        'name': $form.find('input[name=name]').val(),
        'phone': $form.find('input[name=phone]').val(),
		'email': $form.find('input[name=email]').val(),
        'vacancy': $form.find('input[name=vacancy]').val(),
        'text': $form.find('textarea[name=text]').val(),
        'agreement': $form.find('#personal-data').prop('checked'),
        //'recaptcha': $form.find('#g-recaptcha-response').val(),
    }));
    formData.append('sessid', BX.bitrix_sessid());
    formData.append('signedParameters', vacancyFormParams.signedParameters);

    request = $.ajax({
        url: url,
        method: 'POST',
        processData: false,
        contentType: false,
        data: formData,
    });

    request.done(function (response) {
        let form = new FormErrors($form);

        if (response.status == 'error') {
            form.setErrors(response.errors);
        } else {
		
			gtag('event','Submit',{'event_category':'Vacancy-Form'});
			ym(2120464,'reachGoal','Vacancy-Form-Submit');
		
            form.removeErrors();
            showPopupMsg(response.data.message);
        }
        //grecaptcha.reset();
    });

    request.fail(function (jqXHR, textStatus) {
        //grecaptcha.reset();
    });
}

$(document).ready(function () {

    let $form = $('.vacancy-form');

    $form.on('submit', function (e) {
        e.preventDefault();

        sendForm($form);
    });
});