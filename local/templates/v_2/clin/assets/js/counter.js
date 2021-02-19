function initCounter(selector, date, words)
{
    $(selector).countdown(date).on('update.countdown', function(event) {
        let totalHours = event.offset.totalDays * 24 + event.offset.hours;

        $(this).html(event.strftime(''
            + '<div class="clock-wrap"><div class="clock-text-wrap"><span>' + totalHours + '</span><b>' + getSuffix(totalHours, words.hours) + '</b></div></div> '
            + '<div class="clock-wrap"><div class="clock-text-wrap"><span>%M</span><b>' + getSuffix(event.offset.minutes, words.minutes) + '</b></div></div> '));
        });
}

function getSuffix(number, arWords)
{
    var keys = [2, 0, 1, 1, 1, 2],
        mod = number % 100,
        suffixKey = (mod > 7 && mod < 20) ? 2 : keys[Math.min(mod % 10, 5)];

    return arWords[suffixKey];
}

function setCountersParams(words) {
    if (typeof(words) !== undefined && ($('.stock-timer').length > 0 || $('.service1-action-timer-wrap').length > 0)) {
        $('.service1-action-timer').not('.active-timer').each(function() {
            let date = $(this).data('date');

            if (date.length > 0) {
                let selector = '.clock' + $(this).data('id');

                $(this).addClass('active-timer');
                initCounter(selector, date, words);
            }
        });
    }
}

$(document).ready(function() {
    setCountersParams(counterWords);
});

$(document).ajaxSuccess(function() {
    setCountersParams(counterWords);
});