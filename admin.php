<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заказ бургеров - администрирование</title>
</head>
<body>
<h1>Бургеры на заказ</h1>
<a href="admin.php?show=clients">Список клиентов</a>
<a href="admin.php?show=orders">Список заказов</a>
<hr>
<?php
if (!isset($_GET['show'])) {
    die();
}

if ($_GET['show']=='clients') {
    echo "Формируем список клиентов";
?>
<h2>Выводим список клиентов</h2>
<?php
};

if ($_GET['show']=='orders') {
echo "Формируем список заказов";
?>
<h2>Выводим список заказов</h2>
<?php
};
?>
</body>
