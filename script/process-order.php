<?php
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
// Без этих заголовков скрипт на хостинге не загружается!

require "../vendor/autoload.php";
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

$body = makeMessage($userId, $orderId);
$subject = "Заказ бургеров № {$orderId}";
$from = ['andrivan0580@mail.ru' => 'Andrey Ivanov'];

// Create the Transport
$transport = (new Swift_SmtpTransport('ssl://smtp.mail.ru', 465))
    ->setUsername('andrivan0580@mail.ru')
    ->setPassword('!QAZ2wsx')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message($subject))
    ->setFrom($from)
    ->setTo([$_POST['email'] => 'name'])
    ->setBody($body, 'text/html')
;

// Send the message
$result = $mailer->send($message);

if (!$result) {
    $data['status'] = 'MESSAGE_ERROR';
    $data['message'] = 'Информация о заказе сохранена в базе данных. При отправке подтверждения заказа на вашу электронную почту произошла ошибка.';
} else {
    $data['status'] = 'OK';
    $data['message'] = 'Информация о заказе сохранена в базе данных. Подтверждение заказа поступит на вашу электронную почту';
};
echo json_encode($data);

//if ($isDebugMode) {
//    $to = 'andrey@localhost'; // В режиме тестирования посылаем сообщение на локальный адрес
//} else {
//    $to = $_POST['email'];
//};
//
//$headers  = "Content-type: text/html; charset=utf-8 \r\n";
//$headers .= "From: Отправитель {$from}\r\n";
//$mail = mail($to, $subject, $message, $headers);

if ($isDebugMode) {
    echo $body.PHP_EOL; // Режим тестирования - выводим сформированное сообщение
    echo $result;
};
