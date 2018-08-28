// console.log("Обрабатываем заказ");
const formOrder = $('#order-form');

// Обработка отправки формы
formOrder.on('submit', e => {
    e.preventDefault();
    console.log("Form submitting...");

// AJAX-запрос

    let message = '';
    const form = $(e.target),
        dataXHR = form.serialize(),
        urlXHR = form.attr('action'),
        typeXHR = form.attr('method');

    const ajax = $.ajax({
        type: typeXHR,
        url: urlXHR,
        dataType: 'JSON',
        data: dataXHR,
    });

    ajax.done(msg => {
        let status = msg.status,
            message = msg.message;
        alert(message);
        console.log(status, message);
    }).fail(function(jqXHR, textStatus) {
        alert(message);
        console.log(`Ошибка при формировании заказа. Статус: ${textStatus}`);
    });

});
