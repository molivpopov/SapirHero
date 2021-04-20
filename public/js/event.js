$(document).ready(function () {

    let count = 25;
    const $actual = $('#actual-turn');
    const $progress = $actual.find('progress');

    let id = setInterval(function () {
        $progress.val(100 - count * 4);
        count--;
        if (count < 0) {
            clearInterval(id);
            $actual.find('td[data]').each(function (){
                $(this).text($(this).attr('data'))
            });
            $actual.find('.hidden-damage').show()
            $actual.find('.attacker-name').removeClass('attacker-name')
            $progress.val(0)
        }
    }, 60);

});
