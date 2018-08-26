<?php
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
// Без этих заголовков скрипт на хостинге не загружается!

$outMessage = '';
$data = [];

// Проверка обязательных полей
$isError = false;
if (empty($_POST['name'])) {
  $isError = true;
  $outMessage .= 'Не указано имя.<br>';
};
if (empty($_POST['tel'])) {
  $isError = true;
  $outMessage .= 'Не указан телефон.<br>';
};
if (empty($_POST['street'])) {
  $isError = true;
  $outMessage .= 'Не указана улица.<br>';
};
if (empty($_POST['house'])) {
  $isError = true;
  $outMessage .= 'Не указан дом.<br>';
};
if (empty($_POST['payment'])) {
  $isError = true;
  $outMessage .= 'Не выбран способ оплаты.<br>';
};

// var_dump($_POST);
// die();

if ($isError) {
  $data['status'] = 'VALIDATE_ERROR';
  $data['message'] = '<b>Вы не заполнили необходимые поля:</b> <br>'.$outMessage;
  echo json_encode($data);
  die();
}


$to = 'andrey@localhost'; // Режим тестирования - шлем на локальный адрес
// $to = 'andpop@mail.ru'; 
$subject = 'Заказ бургера'; 

$name = '<b>'.$_POST['name'].'</b>';
$tel = '<b>'.$_POST['tel'].'</b>';
$street = '<b>'.(empty($_POST['street']) ? 'Не указана' : $_POST['street']).'</b>';
$house = '<b>'.(empty($_POST['house']) ? 'Не указан' : $_POST['house']).'</b>';
$block = '<b>'.(empty($_POST['block']) ? 'Не указан' : $_POST['block']).'</b>';
$flat = '<b>'.(empty($_POST['flat']) ? 'Не указан' : $_POST['flat']).'</b>';
$floor = '<b>'.(empty($_POST['floor']) ? 'Не указан' : $_POST['floor']).'</b>';
$comment = '<i>'.(empty($_POST['comment']) ? 'Не указан' : $_POST['comment']).'</i>';
$callback_need = isset($_POST['nocallback']) ? 'Нет' : 'Да';
$callback_need = '<b>'.$callback_need.'</b>';
if ($_POST['payment'] == 'cashback') {
  $payment = '<b>Потребуется сдача</b>';
} elseif ($_POST['payment'] == 'card') {
  $payment = '<b>Оплата картой</b>';
} else {
  $payment = '<b>Параметры не указаны</b>';
};

$message = '
  <html>
      <head>
          <title>'.$subject.'</title>
      </head>
      <body>
          <p>Имя: '.$name.'</p>
          <p>Телефон: '.$tel.'</p>   
          <hr>
          <p>Улица: '.$street.'</p>                        
          <p>Дом: '.$house.'</p>                        
          <p>Корпус: '.$block.'</p>                        
          <p>Квартира: '.$flat.'</p>  
          <p>Этаж: '.$floor.'</p>  
          <hr>
          <p>Комментарий: '.$comment.'</p>  
          <hr>
          <p>Оплата: '.$payment.'</p>  
          <hr>
          <p>Перезвонить: '.$callback_need.'</p>     						
      </body>
  </html>'; 
$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
$headers .= "From: Отправитель <andrvpopov@gmail.com>\r\n"; 
$mail = mail($to, $subject, $message, $headers); 
if ($mail) {
  $data['status'] = 'OK';
  $data['message'] = 'Заказ отправлен. Менеджер свяжется с Вами в ближайшее время';
} else {
  $data['status'] = 'SEND_ERROR';
  $data['message'] = 'При отправке заказа на сервере произошла ошибка. <br>Извините, пожалуйста, и попробуйте отправить форму еще раз';
};
echo json_encode($data);
// echo $message; // Режим тестирования - выводим сформированное сообщение