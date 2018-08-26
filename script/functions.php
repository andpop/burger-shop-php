<?php
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

