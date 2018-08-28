<?php
require_once 'connect-params.php';

function dump($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
};


/**
 * Проверка заполненности полей формы заказа.
 * Обязательными считаем поля name, phone, email, street, home, payment
 * Если обязательные поля не заполнены, то и возвращаем сообщение об этом и выходим.
 */
function checkFields()
{
    $outMessage = '';
    $data = [];

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

/**
 * Подключение к базе данных
 * @return PDO - главный объект PDO
 */
function dbConnectPDO()
{
    $dsn = "mysql:host=localhost;dbname=burgers;charset=utf8";
    $pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
};

/**
 * Проверка наличия email клиента в таблице клиентов
 * @param $email - email проверяемого пользователя (должен быть уникальным)
 * @return bool - true = клиента не было в базе
 */
function isNewUser($email)
{
    global $pdo;
    $prepare = $pdo->prepare('SELECT * FROM users where `email` = :email');
    $prepare->execute(['email' => $email]);
    $data = $prepare->fetchAll(PDO::FETCH_OBJ);

    return (count($data) == 0);
};

/**
 * Добавление нового клиента в таблицу users
 * @param $email
 * @param $name
 * @param $phone
 */
function addUser($email, $name, $phone)
{
    global $pdo;
    $prepare = $pdo->prepare('INSERT INTO `users` (email, name, phone) VALUES (:email, :name, :phone)');
    $prepare->execute(['email' => $email, 'name' => $name, 'phone' => $phone]);
};

/**
 * Авторизация клиента - если его email нет в базе, то информация о нем добавляется в таблицу клиентов
 * @param $email
 * @param $name
 * @param $phone
 */
function authorizeUser($email, $name, $phone)
{
    if (isNewUser($email)) {
        addUser($email, $name, $phone);
    }
};

/**
 * Возвращает id клиента по его email
 * @param $email
 * @return mixed - id клиента из таблицы users
 */
function getUserId($email)
{
    global $pdo;
    $prepare = $pdo->prepare('SELECT id FROM users where `email` = :email');
    $prepare->execute(['email' => $email]);
    $data = $prepare->fetch(PDO::FETCH_ASSOC);
    return $data['id'];
//    $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
//    return $data[0]['id'];
};

/**
 * Возвращает количество заказов клиентв по его email
 * @param $userId
 * @return mixed - id клиента из таблицы users
 */
function getOrderCount($userId)
{
    global $pdo;
    $prepare = $pdo->prepare('SELECT COUNT(id) FROM orders where `id_user` = :idUser');
    $prepare->execute(['idUser' => $userId]);
    $data = $prepare->fetch(PDO::FETCH_ASSOC);
    return $data['COUNT(id)'];
//    $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
//    return $data[0]['COUNT(id)'];
};

/**
 * Добавляет заказ из формы ввода в таблицу orders
 * @param $idUser - вычисляется заранее через функцию getIdUser
 * @param $street - приходит из формы
 * @param $home - приходит из формы
 * @param $part - приходит из формы
 * @param $appt - приходит из формы
 * @param $floor - приходит из формы
 * @param $comment - приходит из формы
 * @param $payment - приходит из формы (radiobutton)
 * @param $callback - приходит из формы (checkbox)
 * @return string - id добавленной записи в таблице orders
 */
function addOrder($idUser, $street, $home, $part, $appt, $floor, $comment, $payment, $callback)
{
    global $pdo;
    $query = 'INSERT INTO `orders` (id_user, street, home, part, appt, floor, comment, payment, callback) '.
        'VALUES (:idUser, :street, :home, :part, :appt, :floor, :comment, :payment, :callback)';
    $prepare = $pdo->prepare($query);
    $prepare->execute(['idUser' => $idUser, 'street' => $street, 'home' => $home, 'part' => $part, 'appt' => $appt,
        'floor' => $floor, 'comment' => $comment, 'payment' => $payment, 'callback' => $callback]);
    return $pdo->lastInsertId();
};

/**
 * Формирование сообщения для отправки клиенту на почту
 * @param $userId
 * @param $orderId
 * @return string
 */
function makeMessage($userId, $orderId) {
    $name = '<b>'.$_POST['name'].'</b>';
    $phone = '<b>'.$_POST['phone'].'</b>';
    $street = '<b>'.(empty($_POST['street']) ? 'Не указана' : $_POST['street']).'</b>';
    $home = '<b>'.(empty($_POST['home']) ? 'Не указан' : $_POST['home']).'</b>';
    $part = '<b>'.(empty($_POST['part']) ? 'Не указан' : $_POST['part']).'</b>';
    $appt = '<b>'.(empty($_POST['appt']) ? 'Не указан' : $_POST['appt']).'</b>';
    $floor = '<b>'.(empty($_POST['floor']) ? 'Не указан' : $_POST['floor']).'</b>';
    $comment = '<i>'.(empty($_POST['comment']) ? 'Не указан' : $_POST['comment']).'</i>';
    if ($_POST['payment'] == 'cashback') {
        $paymentInfo = "<b>Потребуется сдача</b>";
    } elseif ($_POST['payment'] == 'card') {
        $paymentInfo = "<b>Оплата по карте</b>";
    } else {
        $paymentInfo = "<b>Не указано</b>";
    };

    $thanks = '';
    $orderCount = getOrderCount($userId);
    if ($orderCount == 1) {
        $thanks = 'Спасибо - это ваш первый заказ';
    } elseif ($orderCount > 1) {
        $thanks = "Спасибо! Это уже Ваш $orderCount заказ";
    };

    $message = '
      <html>
          <head>
              <title>Заказ № '.$orderId.'</title>
          </head>
          <body>
              <p>Заказ № '.$orderId.'</p>
              <p>Имя: '.$name.' &nbsp;&nbsp;&nbsp;Телефон: '.$phone.'</p>
              <hr>
              <p>Ваш заказ будет доставлен по адресу:</p>
              <p>Улица: '.$street.' Дом: '.$home.' Корпус: '.$part.' Кв.: '.$appt.'</p>
              <hr>
              <p>Вы заказали:</p>
              <p><b>DarkBeefBurger - 500 руб - 1 шт</b></p>
              <hr>
              <p>Комментарий: '.$comment.'</p>
              <hr>
              <p>Оплата заказа: '.$paymentInfo.'</p>
              <hr>
              <p>'.$thanks.'</p>
              <hr>
          </body>
      </html>';
    return $message;
};

