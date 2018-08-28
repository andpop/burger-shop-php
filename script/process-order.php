<?php
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
// Без этих заголовков скрипт на хостинге не загружается!


require_once 'functions.php';

// =======================================================================================================

// !!!!!!!!!!!!!! При использовании AJAX нужно isDebugMode=false !!!!!!!!!!!!!!!!!!!!!!!!!!!!
$isDebugMode = false; // Включен режим отладки скрипта

$data = [];
$pdo = dbConnectPDO();
authorizeUser($_POST['email'], $_POST['name'], $_POST['phone']);

$userId = getUserId($_POST['email']);
$callbackNeed = isset($_POST['callback']) ? '0' : '1';
$orderId = addOrder($userId, $_POST['street'], $_POST['home'], $_POST['part'], $_POST['appt'], $_POST['floor'], $_POST['comment'], $_POST['payment'], $callbackNeed);
if (!$orderId) {
  $data['status'] = 'SAVE_ERROR';
  $data['message'] = 'При сохранении  заказа на сервере произошла ошибка. Извините, пожалуйста, и попробуйте отправить форму еще раз';
  echo json_encode($data);
  die();
};

$message = makeMessage($userId, $orderId);
$subject = "Заказ бургеров № {$orderId}";
$from = '<andrvpopov@gmail.com>';
if ($isDebugMode) {
    $to = 'andrey@localhost'; // В режиме тестирования посылаем сообщение на локальный адрес
} else {
    $to = $_POST['email'];
};

$headers  = "Content-type: text/html; charset=utf-8 \r\n";
$headers .= "From: Отправитель {$from}\r\n";
$mail = mail($to, $subject, $message, $headers);
if ($isDebugMode) {
    echo $message; // Режим тестирования - выводим сформированное сообщение
};

$data['status'] = 'OK';
$data['message'] = 'Информация о заказе сохранена в базе данных. Подтверждение заказа поступит на вашу электронную почту';
echo json_encode($data);