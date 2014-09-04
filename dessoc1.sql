-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 04 2014 г., 17:30
-- Версия сервера: 5.5.33
-- Версия PHP: 5.4.30

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `myexg`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc`
--

CREATE TABLE IF NOT EXISTS `dessoc` (
`id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `stage` tinyint(4) NOT NULL,
  `accept_rule` text NOT NULL,
  `result_text` text NOT NULL
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc_admins`
--

CREATE TABLE IF NOT EXISTS `dessoc_admins` (
`id` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc_answers`
--

CREATE TABLE IF NOT EXISTS `dessoc_answers` (
`id` int(11) NOT NULL,
  `dessoc_hashes_id` int(11) NOT NULL,
  `dessoc_questions_id` int(11) NOT NULL,
  `dessoc_reg_id` int(11) NOT NULL,
  `answer` int(11) NOT NULL
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc_hashes`
--

CREATE TABLE IF NOT EXISTS `dessoc_hashes` (
`id` int(11) NOT NULL,
  `passwrd` varchar(50) NOT NULL,
  `dessoc_id` int(11) NOT NULL,
  `activate_at` int(11) NOT NULL DEFAULT '0',
  `all_done` tinyint(4) NOT NULL,
  `accept` tinyint(4) NOT NULL
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc_questions`
--

CREATE TABLE IF NOT EXISTS `dessoc_questions` (
`id` int(11) NOT NULL,
  `question` varchar(250) NOT NULL,
  `qdesc` text NOT NULL,
  `individual` tinyint(4) NOT NULL DEFAULT '0',
  `dessoc_reg_id` int(11) NOT NULL,
  `answers` text NOT NULL,
  `aproved` tinyint(4) NOT NULL DEFAULT '0',
  `dessoc_id` int(11) NOT NULL DEFAULT '1',
  `dessoc_questions_block_id` int(11) NOT NULL
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc_questions_block`
--

CREATE TABLE IF NOT EXISTS `dessoc_questions_block` (
`id` int(11) NOT NULL,
  `block_name` varchar(250) NOT NULL
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessoc_reg`
--

CREATE TABLE IF NOT EXISTS `dessoc_reg` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `hsh` varchar(34) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo_link` varchar(100) NOT NULL,
  `pdesc` varchar(250) NOT NULL,
  `hash_sended` tinyint(4) NOT NULL,
  `result_sended` tinyint(4) NOT NULL,
  `show_my_result` tinyint(4) NOT NULL
) TYPE=MyISAM ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dessoc`
--
ALTER TABLE `dessoc`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dessoc_admins`
--
ALTER TABLE `dessoc_admins`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dessoc_answers`
--
ALTER TABLE `dessoc_answers`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `dessoc_hashes_id` (`dessoc_hashes_id`,`dessoc_questions_id`,`dessoc_reg_id`);

--
-- Indexes for table `dessoc_hashes`
--
ALTER TABLE `dessoc_hashes`
 ADD PRIMARY KEY (`id`), ADD KEY `passwrd` (`passwrd`);

--
-- Indexes for table `dessoc_questions`
--
ALTER TABLE `dessoc_questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dessoc_questions_block`
--
ALTER TABLE `dessoc_questions_block`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dessoc_reg`
--
ALTER TABLE `dessoc_reg`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `hsh` (`hsh`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dessoc`
--
ALTER TABLE `dessoc`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dessoc_admins`
--
ALTER TABLE `dessoc_admins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dessoc_answers`
--
ALTER TABLE `dessoc_answers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dessoc_hashes`
--
ALTER TABLE `dessoc_hashes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dessoc_questions`
--
ALTER TABLE `dessoc_questions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dessoc_questions_block`
--
ALTER TABLE `dessoc_questions_block`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dessoc_reg`
--
ALTER TABLE `dessoc_reg`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
