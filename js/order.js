// console.log("Обрабатываем заказ");
const formOrder = $('#order-form');

// Обработка отправки формы
formOrder.on('submit', e => {
    e.preventDefault();
    console.log("Form submitting...");
});