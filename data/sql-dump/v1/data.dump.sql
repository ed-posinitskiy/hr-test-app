-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 24 2013 г., 21:52
-- Версия сервера: 5.5.23
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `hrtest`
--

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(2, 'PHP Development'),
(3, 'C# Development'),
(4, 'Java Development'),
(5, 'HR Service');

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `locale`, `title`) VALUES
(2, 'fr', 'Français'),
(3, 'es', 'Español'),
(4, 'de', 'Deutsch'),
(5, 'it', 'Italiano');

--
-- Дамп данных таблицы `translations`
--

INSERT INTO `translations` (`id`, `language_id`, `vacancy_id`, `title`, `description`) VALUES
(4, 4, 3, 'Senior C # Entwickler', 'Beschreibung der Leerstand auf Italienisch'),
(5, 4, 6, 'Senior PHP Entwickler', 'Beschreibung der Leerstand in Deutsch'),
(6, 3, 6, 'Senior programador PHP', 'Descripción de la vacante en español'),
(7, 3, 7, 'Director del Servicio de Recursos Humanos', 'Descripción de la vacante en español'),
(8, 2, 8, 'Développeur Java', 'Description de l''offre d''emploi en français');

--
-- Дамп данных таблицы `vacancy`
--

INSERT INTO `vacancy` (`id`, `department_id`, `title`, `description`) VALUES
(3, 3, 'Senior C# Developer', 'Description of the vacancy on in a base language (en)'),
(4, 2, 'Junior PHP Developer', 'Description of the vacancy on in a base language (en)'),
(5, 4, 'Java Architect', 'Description of the vacancy on in a base language (en)'),
(6, 2, 'Senior PHP Developer', 'Description of the vacancy on in a base language (en)'),
(7, 5, 'HR Service manager', 'Description of the vacancy on in a base language (en)'),
(8, 4, 'Java developer', 'Description of the vacancy on in a base language (en)');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
