<?php
require_once 'connect-params.php';

/**
 * Подключение к базе данных
 * @return PDO - главный объект PDO
 */
function dbConnectPDO()
{
    $dsn = "mysql:host=localhost;dbname=".MYSQL_DB.";charset=utf8";
    $pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
};

/**
 * Возвращает ассоциативный массив со списком всех клиентов
 * @return array
 */
function getAllUsers()
{
    global $pdo;
    $result = $pdo->query('SELECT * FROM `users`');
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
};

/**
 * Возвращает ассоциативный массив со списком всех клиентов
 * @return array
 */
function getAllOrders()
{
    global $pdo;
    $result = $pdo->query('SELECT name, street, home, part, appt, floor, comment FROM `users`, `orders` WHERE users.id=orders.id_user');
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
};

