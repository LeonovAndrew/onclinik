function sendSubscribeForm($form) {
    let query = {
            c : 'mwi:subscription.form',
            action : 'subscribe',
            mode : 'class'
        },
        url = '/bitrix/services/main/ajax.php?' + $.param(query, true),
        request,
        formData = new FormData();

    formData.append('json', JSON.stringify({
        'email' : $form.find('input[name=email]').val(),
        'agreement' : $form.find('#personal-data-subscribe').prop('checked'),
    }));
    formData.append('sessid', BX.bitrix_sessid());
    formData.append('signedParameters', subscriptionFormParams.signedParameters);

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
            form.removeErrors();
            showPopupMsg(response.data.message);
			
			gtag('event','Submit',{'event_category':'SubscribeForm','event_label':'Subscribe-Form-Submit'});
			ym(2120464,'reachGoal','Subscribe-Form-Submit'); 
        }
    });

    request.fail(function(jqXHR, textStatus) {
    });
}

$(document).ready(function() {

    let $form = $('.subscription-form');

    $form.on('submit', function(e) {
        e.preventDefault();

        sendSubscribeForm($form);
    });


    $('.close_modal').click(function(e){
        e.preventDefault()

        $.fancybox.close()
    })
});