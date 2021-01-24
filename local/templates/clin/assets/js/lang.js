function replaceLang(url, curLang, newLang) {
    curLang = curLang == '' ? curLang : curLang + '/';
    newLang = newLang == '' ? newLang : newLang + '/';

    return url.replace(window.location.origin + '/' + curLang, window.location.origin + '/' + newLang);
}

function changeLang(newLang) {
    let curLang = getLang(),
        curUrl = window.location.origin + window.location.pathname,
        newUrl;

    if (curLang != newLang) {
        newUrl = replaceLang(curUrl, curLang, newLang);
        location.href = newUrl;
    }
}

function getLang() {
    let curPath = window.location.pathname,
        arPath = curPath.split('/', 2),
        lang = arPath[1] == 'en' ? arPath[1] : '';

    return lang;
}

$(document).ready(function() {
    $('.langChange').on('click', function() {
        let lang = $(this).data('id') == 'ru' ? 'en' : '';
        changeLang(lang);
    });
});