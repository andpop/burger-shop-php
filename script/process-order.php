<?php
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
// Без этих заголовков скрипт на хостинге не загружается!

/**
 * Проверка заполненности полей формы заказа
 */
function checkFields()
{
    // Проверка обязательных полей
    $outMessage = '';
    $isError = false;
    if (empty($_POST['name'])) {
        $isError = true;
        $outMessage .= 'Не указано имя.<br>';
    };
    if (empty($_POST['phone'])) {
        $isError = true;
        $outMessage .= 'Не указан телефон.<br>';
    };
    if (empty($_POST['email'])) {
        $isError = true;
        $outMessage .= 'Не указан email.<br>';
    };
    if (empty($_POST['street'])) {
        $isError = true;
        $outMessage .= 'Не указана улица.<br>';
    };
    if (empty($_POST['home'])) {
        $isError = true;
        $outMessage .= 'Не указан дом.<br>';
    };
    if (empty($_POST['part'])) {
        $isError = true;
        $outMessage .= 'Не указан корпус.<br>';
    };
    if (empty($_POST['appt'])) {
        $isError = true;
        $outMessage .= 'Не указана квартира.<br>';
    };
    if (empty($_POST['floor'])) {
        $isError = true;
        $outMessage .= 'Не указан этаж.<br>';
    };
    if (empty($_POST['payment'])) {
        $isError = true;
        $outMessage .= 'Не выбран способ оплаты.<br>';
    };

    if ($isError) {
      $data['status'] = 'VALIDATE_ERROR';
      $data['message'] = '<b>Вы не заполнили необходимые поля:</b> <br>'.$outMessage;
      echo json_encode($data);
      die();
    }
};

function db_connect()
{
    define('MYSQL_SERVER', 'localhost');
    define('MYSQL_USER', 'root');
    define('MYSQL_PASSWORD', '12345678');
    define('MYSQL_DB', 'burgers');

    $mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);

    if ($mysqli->connect_errno) {
        exit("Ошибка при подключении к БД: ".$mysqli->connect_error);
    }

    if (!$mysqli->set_charset("utf8")){
        printf("Error: ".$mysqli->error);
    }

    return $mysqli;
}

function authorization($email)
{
    $query = "SELECT * FROM users WHERE `email`='$email''";
    echo $query;
};

function addUser($email, $name, $phone)
{
    $query = "INSERT INTO users (email, name, phone) VALUES ('{$email}', '{$name}', '{$phone}')";
    echo $query;
};
//$outMessage = '';
//$data = [];

//checkFields();

// Подключение к БД
$mysqli = db_connect();
$mysqli->set_charset("utf8");

authorization($_POST['email']);
addUser($_POST['email'], $_POST['name'], $_POST['phone']);


$to = 'andrey@localhost'; // Режим тестирования - шлем на локальный адрес
// $to = 'andpop@mail.ru'; 
$subject = 'Заказ №';

$name = '<b>'.$_POST['name'].'</b>';
$phone = '<b>'.$_POST['phone'].'</b>';
$street = '<b>'.(empty($_POST['street']) ? 'Не указана' : $_POST['street']).'</b>';
$home = '<b>'.(empty($_POST['house']) ? 'Не указан' : $_POST['house']).'</b>';
$part = '<b>'.(empty($_POST['part']) ? 'Не указан' : $_POST['part']).'</b>';
$appt = '<b>'.(empty($_POST['appt']) ? 'Не указан' : $_POST['appt']).'</b>';
$floor = '<b>'.(empty($_POST['floor']) ? 'Не указан' : $_POST['floor']).'</b>';
$comment = '<i>'.(empty($_POST['comment']) ? 'Не указан' : $_POST['comment']).'</i>';
//$callback_need = isset($_POST['nocallback']) ? 'Нет' : 'Да';
//$callback_need = '<b>'.$callback_need.'</b>';
//if ($_POST['payment'] == 'cashback') {
//  $payment = '<b>Потребуется сдача</b>';
//} elseif ($_POST['payment'] == 'card') {
//  $payment = '<b>Оплата картой</b>';
//} else {
//  $payment = '<b>Параметры не указаны</b>';
//};

$message = '
  <html>
      <head>
          <title>'.$subject.'</title>
      </head>
      <body>
          <p>Имя: '.$name.'</p>
          <p>Телефон: '.$phone.'</p>
          <hr>
          <p>Ваш заказ будет доставлен по адресу:</p>
          <p>Улица: '.$street.'</p>
          <p>Дом: '.$home.'</p>
          <p>Корпус: '.$part.'</p>
          <p>Квартира: '.$appt.'</p>
          <p>Этаж: '.$floor.'</p>
          <hr>
          <p>Комментарий: '.$comment.'</p>
          <hr>
      </body>
  </html>';
//$headers  = "Content-type: text/html; charset=utf-8 \r\n";
//$headers .= "From: Отправитель <andrvpopov@gmail.com>\r\n";
//$mail = mail($to, $subject, $message, $headers);
//if ($mail) {
//  $data['status'] = 'OK';
//  $data['message'] = 'Заказ отправлен. Менеджер свяжется с Вами в ближайшее время';
//} else {
//  $data['status'] = 'SEND_ERROR';
//  $data['message'] = 'При отправке заказа на сервере произошла ошибка. <br>Извините, пожалуйста, и попробуйте отправить форму еще раз';
//};
//echo json_encode($data);
echo $message; // Режим тестирования - выводим сформированное сообщение