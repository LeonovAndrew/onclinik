function alertObj(obj) { 
    var str = ""; 
    for(k in obj) { 
        str += k+": "+ obj[k]+"\r\n"; 
    } 
    alert(str); 
} 
function sendForm() {
    let $form = $('.review-form'),
        query = {
            c : 'mwi:review.form',
            action : 'sendMessage',
            mode : 'class'
        },
        url = '/bitrix/services/main/ajax.php?' + $.param(query, true),
        request,
        formData = new FormData();

		
    formData.append('json', JSON.stringify({
        'name' : $form.find('input[name=name]').val(),
        'phone' : $form.find('input[name=phone]').val(),
        'email' : $form.find('input[name=email]').val(),
        'text' : $form.find('textarea[name=text]').val(),
        'doctorName' : $form.find('input[name=nameDoctor]').val(),
        'clinicId' : $form.find('select[name=clinic]').val(),
        'directionId' : $form.find('select[name=direction]').val(),
        'agreement' : $form.find('#personal-data').prop('checked'),
        'accommodation' : $form.find('#consent-accommodation').prop('checked'),
    }));
    formData.append('sessid', BX.bitrix_sessid());
    formData.append('signedParameters', vacancyFormParams.signedParameters);

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

			gtag('event','Submit',{'event_category':'Feedback-Form'});
			ym(2120464,'reachGoal','Feedback-Form-Submit');
		
            form.removeErrors();
            showPopupMsg(response.data.message);
        }
    });

    request.fail(function(jqXHR, textStatus) {

    });
}

$(document).ready(function() {

    let $form = $('.review-form');

    autocomplete($("#nameDoctor")[0], hintsDoctors, sendForm);

    $form.on('submit', function(e) {
        e.preventDefault();

        sendForm();
    });
});