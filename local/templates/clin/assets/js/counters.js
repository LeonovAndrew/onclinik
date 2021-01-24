//SM настройки целей со старого сайта. 
//После правки - удалить комментарий
//Задать вопрос
    $('.specialistQuest').click(function (e) {
		gtag('event','Open',{'event_category':'QuestionForm','event_label':'Question-Form-Open'});
		ym(2120464,'reachGoal','QUESTION_CLICK');
    });
//Записаться на приём header
    $('.appointment-top').click(function (e) {
        gtag('config', 'UA-65776847-1', {'page_path': '/virtual/zapis-click'});		
		yaCounter2120464.reachGoal('record');
		
		gtag('event','Open',{'event_category':'AppointmentForm','event_label': 'Click-button- zapis-na-priem-header'});
		ym(2120464,'reachGoal','record');
    });
//Записаться на приём body
    $('.bl-appoitment a').click(function (e) {
		gtag('event','Open',{'event_category':'AppointmentForm','event_label': 'Click-button-zapis-na-priem-body'});
		ym(2120464,'reachGoal','Appointment-Form-Body-Open');
    });
//Телефоны header
    $('#menu .phone').click(function (e) {
		gtag('event','Click_button',{'event_category':'Click','event_label': 'Click-tell-number-header'});
		ym(2120464,'reachGoal','Click-tell-number');
    });
//Телефоны footer
    $('#footer .phone .phone').click(function (e) {
		gtag('event','Click_button',{'event_category':'Click','event_label': 'Click-tell-number-footer'});
		ym(2120464,'reachGoal','Click-tell-number');
    });
//Социальные сети
    $('#footer .phone .btn-twitter').click(function (e) {
		gtag('event','Click_button',{'event_category':'Click','event_label': 'Click-social-buttons'});
		ym(2120464,'reachGoal','Click-social-buttons');
    })
//Ссылки на скачивание
    $('.download_files').click(function (e) {
		gtag('event','Click_button',{'event_category':'Click','event_label': 'Programmy-godovogo-obsluzhivaniya-download'});
		ym(2120464,'reachGoal','Programmy-download'); 
    })
});
/** metrica goals and error handler **/
$(window).on('message', function (e) {
    if (e.originalEvent.data === 'send-order') yaCounter2120464.reachGoal('PRIEM');


    /** metrica goals and error handler **/
});




$(function () {

})

window.addEventListener('message', function (event) {
    'use strict';
    var data = event.data;
    try {
        var messageEvent = JSON.parse(data);
        /*console.log(
            'Message  received  event  "' + messageEvent.name + '":', messageEvent.data
        );*/
        switch (messageEvent.name) {
            case  'widget.init' : // сюда добавить скрипт событий для каждого виджета
                break;
            case 'business.select' :
                gtag('config', 'UA-65776847-1', {'page_path': '/virtual/address-zapis-click'});
                yaCounter2120464.reachGoal('adress_zapis_click');
                //console.log("business.select");
                break;
            case 'service.group.select':
                gtag('config', 'UA-65776847-1', {'page_path': '/virtual/vibor-uslugi-click'});
                yaCounter2120464.reachGoal('vibor_uslugi_click');
                //console.log("service.group.select");
                break;
            case 'service.select':
                gtag('config', 'UA-65776847-1', {'page_path': '/virtual/vibor-priem-click'});
                yaCounter2120464.reachGoal('vibor_priem_click');
                //console.log("service.select");
                break;
            case 'resource.select':
                //console.log("resource.select");
                break;
            case 'datetime.select':
                gtag('config', 'UA-65776847-1', {'page_path': '/virtual/vibor-daytime-click'});
                yaCounter2120464.reachGoal('vibor_day_time_click');
                //console.log("datetime.select");
                break;
            case 'appointment.confirm':
                gtag('config', 'UA-65776847-1', {'page_path': '/virtual/record-send'});
                yaCounter2120464.reachGoal('record_send');
                //console.log("appointment.confirm");
                break;
        }
    }
    catch (e) {
        console.error('Error  on  message  data  parsing:', e);
    }
});