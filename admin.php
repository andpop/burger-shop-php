<?php
require 'vendor/autoload.php';
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

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache' => 'compilation_cache',
    'auto_reload' => true
));

if ($_GET['show']=='clients') {
    $clients = getAllUsers();
    echo $twig->render('clients.twig', array('clients' => $clients));
};

if ($_GET['show']=='orders') {
    $orders = getAllOrders();
    echo $twig->render('orders.twig', array('orders' => $orders));
};
?>
</body>
