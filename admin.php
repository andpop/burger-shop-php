<?php
require_once 'script/functions-admin.php';

$pdo = dbConnectPDO();
?>
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
    echo '<table>'.PHP_EOL;
    echo '<tr><td>Имя</td><td>Email</td><td>Телефон</td></tr>'.PHP_EOL;
    $clients = getAllUsers();
    foreach ($clients as $client) {
        echo "<tr><td>{$client['name']}</td><td>{$client['email']}</td><td>{$client['phone']}</td></tr>".PHP_EOL;
    };
    echo '</table>'.PHP_EOL;
};

if ($_GET['show']=='orders') {
echo "Формируем список заказов";
?>
<h2>Выводим список заказов</h2>
<?php
};
?>
</body>
