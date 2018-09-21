var currentPrize = {id: null, type: null};

function gamble() {
    var myBlock = $(this).closest('.roulette');
    $(this).prop('disabled', true);

    $.post('/api/v1/prize/get', {}, function (data) {
        if (!data.success) {
            alert('Произошла какая-то ошибка. Попробуйте перезагрузить страницу и попробовать ещё раз.');
            return;
        }

        currentPrize.id = data.prize.id;
        currentPrize.type = data.type.name;

        $('.specific-' + currentPrize.type, myBlock).removeClass('hidden');
        $('.result .title', myBlock).html(data.type.title);
        $('.result .description', myBlock).html(data.type.description);
        $('.result .value', myBlock).html(data.prize.value);
        if (data.item) {
            $('.result .item-name', myBlock).html(data.item.name);
        }

        $('.promo', myBlock).hide();
        $('.result', myBlock).removeClass('hidden');

    }, 'json');
}

function cancelPrize() {
    var myBlock = $(this).closest('.roulette');
    $.post('/api/v1/prize/cancel?id=' + currentPrize.id, {}, function (data) {
        if (!data.success) {
            alert('Произошла какая-то ошибка при отказе от подарка. Попробуйте перезагрузить страницу и попробовать ещё раз.');
            return;
        }

        $('.specific-item', myBlock).html('<div class="alert alert-danger">Вы отказались от подарка!</div>');

    }, 'json');
}

function sendNotes(evt) {
    var form = $(this);
    var myBlock = form.closest('.roulette');

    $.post('/api/v1/prize/update-data?id=' + currentPrize.id, form.serialize(), function (data) {
        if (!data.success) {
            alert('Произошла какая-то ошибка при отказе от подарка. Попробуйте перезагрузить страницу и попробовать ещё раз.');
            return;
        }

        form.html('<div class="alert alert-info">Модератор в скором времени проверит и отправит ваш приз!</div>');

    }, 'json');

    return false;
}

$(function () {
    $('.roulette .gamble').on('click', gamble);
    $('.roulette .result .cancel').on('click', cancelPrize);
    $('.roulette .result .userNotes').on('submit', sendNotes);
});