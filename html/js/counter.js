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