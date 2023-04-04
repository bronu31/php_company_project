-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 04 2023 г., 07:27
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `company`
--

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_to_shop`
--

CREATE TABLE `delivery_to_shop` (
  `id` int(11) NOT NULL,
  `delivery_name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `product_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `delivery_to_shop`
--

INSERT INTO `delivery_to_shop` (`id`, `delivery_name`, `product_id`, `volume`, `cost`, `date`) VALUES
(1, '222', 1, 50, 500, '2023-04-30'),
(2, '555', 3, 10, 400, '2021-01-13'),
(3, '555', 3, 2, 300, '2021-01-14');

--
-- Триггеры `delivery_to_shop`
--
DELIMITER $$
CREATE TRIGGER `SEND_TO_SHOP` AFTER INSERT ON `delivery_to_shop` FOR EACH ROW UPDATE warehouse
SET on_hands=on_hands-NEW.volume
WHERE warehouse.id=NEW.product_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_to_warehouse`
--

CREATE TABLE `delivery_to_warehouse` (
  `id` int(11) NOT NULL,
  `delivery_name` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `delivery_to_warehouse`
--

INSERT INTO `delivery_to_warehouse` (`id`, `delivery_name`, `product_id`, `volume`, `cost`, `order_date`) VALUES
(1, '111', 1, 100, 50, '2023-04-06'),
(2, '555', 3, 22, 22, '2023-04-01'),
(3, 'awdca32gsx-324', 3, 500, 600, '2020-12-02');

--
-- Триггеры `delivery_to_warehouse`
--
DELIMITER $$
CREATE TRIGGER `add_to_warehouse` AFTER INSERT ON `delivery_to_warehouse` FOR EACH ROW UPDATE warehouse
SET on_hands=on_hands+NEW.volume
WHERE warehouse.id=NEW.product_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `prod_name` text NOT NULL,
  `on_hands` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `warehouse`
--

INSERT INTO `warehouse` (`id`, `prod_name`, `on_hands`) VALUES
(1, 'Колбаса', 50),
(2, 'Пармезан', 0),
(3, 'Левый носок', 510);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `delivery_to_warehouse`
--
ALTER TABLE `delivery_to_warehouse`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
