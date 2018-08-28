<?php
require_once 'connect-params.php';

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
