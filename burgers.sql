-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 28 2018 г., 23:18
-- Версия сервера: 5.7.23-0ubuntu0.16.04.1
-- Версия PHP: 7.0.25-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `burgers`
--
CREATE DATABASE IF NOT EXISTS `burgers` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `burgers`;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `home` char(20) DEFAULT NULL,
  `part` char(10) DEFAULT NULL,
  `appt` char(10) DEFAULT NULL,
  `floor` char(10) DEFAULT NULL,
  `comment` varchar(300) DEFAULT NULL,
  `payment` char(20) NOT NULL DEFAULT 'cashback' COMMENT 'cashback or card',
  `callback` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - callback need, 0 - no callback need'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `orders`
--

TRUNCATE TABLE `orders`;
--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `street`, `home`, `part`, `appt`, `floor`, `comment`, `payment`, `callback`) VALUES
(1, 2, 'Nostrud do laborum', '1', '2', '3', '4', 'I need burger!', 'cashback', 1),
(2, 2, 'Nostrud do laborum', '1', '2', '3', '4', 'I need burger! sdsdsdsdsdsd', 'cashback', 1),
(4, 2, 'Nostrud do laborum', '1', '2', '3', '4', 'Хочу бургер', 'cashback', 1),
(5, 2, 'Nostrud do laborum', '1', '2', '3', '4', 'Хочу бургер', 'cashback', 1),
(6, 2, 'Nostrud do laborum', '1', '2', '3', '4', 'Хочу бургер', 'cashback', 1),
(7, 3, 'Lorem ipsum', '10', '11', '12', '3', 'Ненавижу бургеры', 'cashback', 1),
(8, 3, 'Lorem ipsum', '10', '11', '12', '3', 'Ненавижу бургеры', 'cashback', 1),
(9, 3, 'Lorem ipsum', '10', '11', '12', '3', 'Ненавижу бургеры', 'cashback', 1),
(10, 3, 'Lorem ipsum', '10', '11', '12', '3', 'Ненавижу бургеры', 'cashback', 1),
(11, 4, 'Sit quod incidunt qui irure', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'cashback', 1),
(12, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(13, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(14, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(15, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(16, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(17, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(18, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(19, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(20, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(21, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(22, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(23, 4, 'Ленина', '1', '2', '3', '4', 'Atque minim et quos voluptas quas sapiente id nesciunt sed veniam sed dicta sit', 'card', 0),
(24, 5, 'Dolor aut', '10', '11', '12', '2', 'Consequatur tempor amet nulla mollitia saepe excepturi aut ea ullam dolore quam', 'card', 1),
(25, 6, 'Qui vero', '20', '1', '2', '3', 'Aliqua Aut qui exercitationem rem ut architecto ut eveniet cum pariatur Veritatis sint incidunt', 'cashback', 1),
(26, 7, 'Ut non in nisi voluptas aut sapiente dolore cupidatat labore laboriosam officia nostrum tenetur fuga', '1', '2', '3', '4', 'Officiis voluptas quam voluptas aut praesentium dolor ad perferendis ducimus', 'cashback', 0),
(27, 8, 'Cum et sint eos ullam sit doloremque consequatur Voluptas autem excepteur sunt reprehenderit voluptate ea', '45', '45', '47', '1', 'Mollitia rerum dolorum voluptas expedita inventore non veritatis pariatur Possimus ut provident iusto omnis elit', 'cashback', 1),
(28, 8, 'Cum et sint eos ullam sit doloremque consequatur Voluptas autem excepteur sunt reprehenderit voluptate ea', '45', '45', '47', '1', 'Mollitia rerum dolorum voluptas expedita inventore non veritatis pariatur Possimus ut provident iusto omnis elit', 'cashback', 1),
(29, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0),
(30, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0),
(31, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0),
(32, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0),
(33, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0),
(34, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0),
(35, 9, 'Ullamco deleniti elit aliquip ', '1', '2', '3', '4', 'Magna in ipsa tempora qui duis vel temporibus voluptate optio quia est', 'cashback', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `email` char(60) NOT NULL,
  `name` char(80) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `users`
--

TRUNCATE TABLE `users`;
--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `phone`) VALUES
(1, 'aaa@mail.ru', 'klop', '1234'),
(2, 'syzajodydu@mailinator.net', 'Hunter Stephenson', '+7 (966) 287 37 69'),
(3, 'cuwywuta@mailinator.net', 'Kenyon Mcmahon', '+7 (499) 564 18 07'),
(4, 'zisisymyb@mailinator.net', 'Georgia Koch', '+7 (254) 554 60 24'),
(5, 'wyjyg@mailinator.net', 'Tallulah Drake', '+7 (647) 701 60 45'),
(6, 'fetyjah@mailinator.net', 'Brenna Shaw', '+7 (482) 277 92 29'),
(7, 'goba@mailinator.com', 'Acton Frye', '+7 (137) 832 76 37'),
(8, 'cavuzecyn@mailinator.net', 'Jessica Frank', '+7 (518) 819 38 65'),
(9, 'fogatedo@mailinator.com', 'Rajah Christian', '+7 (144) 844 90 63');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_uindex` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
