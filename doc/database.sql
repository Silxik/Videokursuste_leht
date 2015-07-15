-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Loomise aeg: Juuli 15, 2015 kell 04:54 PL
-- Serveri versioon: 5.6.24
-- PHP versioon: 5.6.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Andmebaas: `videokursuste leht`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(155) unsigned NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `video_id` int(11) unsigned NOT NULL,
  `person_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(10) unsigned NOT NULL,
  `course_name` varchar(128) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id` int(10) unsigned NOT NULL,
  `course_desc` varchar(512) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `date_added`, `person_id`, `course_desc`) VALUES
  (1, 'Test', '2015-07-14 16:56:35', 1, 'TESTTEST'),
  (2, 'Test2', '2015-07-14 17:59:51', 2, 'test');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int(10) unsigned NOT NULL,
  `username` varchar(25) NOT NULL,
  `person_firstname` varchar(30) NOT NULL,
  `person_lastname` varchar(50) NOT NULL,
  `person_first_visit` datetime NOT NULL,
  `person_last_visit` datetime NOT NULL,
  `person_SID` varchar(64) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `setup` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `person`
--

INSERT INTO `person` (`person_id`, `username`, `person_firstname`, `person_lastname`, `person_first_visit`, `person_last_visit`, `person_SID`, `is_admin`, `password`, `active`, `email`, `setup`, `deleted`) VALUES
  (1, 'demo', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1, 'demo', 1, '', 0, 0),
  (2, 'henno.taht', 'Henno', 'Täht', '2015-07-06 15:02:15', '2015-07-06 18:05:18', '2e07cc7', 0, '', 0, '', 0, 0),
  (3, 'demo2', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 'demo2', 1, '', 0, 0);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(10) unsigned NOT NULL,
  `tag_name` varchar(155) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (1, 'php'),
  (2, 'tutorial'),
  (3, 'learn'),
  (4, 'basic');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int(10) unsigned NOT NULL,
  `title` varchar(155) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `link` varchar(155) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id` int(10) unsigned NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `linktype` tinyint(4) NOT NULL DEFAULT '0',
  `course_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `video`
--

INSERT INTO `video` (`video_id`, `title`, `desc`, `link`, `date_added`, `person_id`, `public`, `linktype`, `course_id`) VALUES
  (1, 'Learn PHP in 15 minutes', 'PHP is one of the most useful languages to know and is used everywhere you look online. In this tutorial, I start from the beginning and show you how to start writing PHP scripts.\r\n\r\nThe video covers the software you need to get started, data types, outpu', 'ZdP0KM49IVk', '2015-07-15 14:38:51', 1, 1, 0, 1),
  (3, 'PHP Programming', 'Get the Cheat Sheet Here : http://goo.gl/aQbQ4F\r\n\r\nLearn HTML in 15 Minutes : http://goo.gl/UoSoVm\r\n\r\nBest PHP book : http://goo.gl/wNMdWf\r\n\r\nIn this video tutorial I''ll teach pretty much the whole PHP programming language in one video. I have received th', '7TF00hJI78Y', '2015-07-15 14:40:41', 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `video_tags`
--

DROP TABLE IF EXISTS `video_tags`;
CREATE TABLE IF NOT EXISTS `video_tags` (
  `video_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `video_tags`
--

INSERT INTO `video_tags` (`video_id`, `tag_id`) VALUES
  (1, 1),
  (3, 1),
  (1, 2),
  (3, 2),
  (1, 3),
  (3, 3),
  (1, 4),
  (3, 4);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `comment`
--
ALTER TABLE `comment`
ADD PRIMARY KEY (`comment_id`), ADD KEY `video_id` (`video_id`), ADD KEY `user_id` (`person_id`);

--
-- Indeksid tabelile `course`
--
ALTER TABLE `course`
ADD PRIMARY KEY (`course_id`), ADD KEY `person_id` (`person_id`);

--
-- Indeksid tabelile `person`
--
ALTER TABLE `person`
ADD PRIMARY KEY (`person_id`), ADD UNIQUE KEY `UNIQUE` (`username`);

--
-- Indeksid tabelile `tag`
--
ALTER TABLE `tag`
ADD PRIMARY KEY (`tag_id`);

--
-- Indeksid tabelile `video`
--
ALTER TABLE `video`
ADD PRIMARY KEY (`video_id`), ADD KEY `person_id` (`person_id`), ADD KEY `course_id` (`course_id`);

--
-- Indeksid tabelile `video_tags`
--
ALTER TABLE `video_tags`
ADD PRIMARY KEY (`video_id`,`tag_id`), ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `comment`
--
ALTER TABLE `comment`
MODIFY `comment_id` int(155) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabelile `course`
--
ALTER TABLE `course`
MODIFY `course_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT tabelile `person`
--
ALTER TABLE `person`
MODIFY `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT tabelile `tag`
--
ALTER TABLE `tag`
MODIFY `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT tabelile `video`
--
ALTER TABLE `video`
MODIFY `video_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tõmmistatud tabelite piirangud
--

--
-- Piirangud tabelile `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

--
-- Piirangud tabelile `course`
--
ALTER TABLE `course`
ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

--
-- Piirangud tabelile `video`
--
ALTER TABLE `video`
ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`),
ADD CONSTRAINT `video_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Piirangud tabelile `video_tags`
--
ALTER TABLE `video_tags`
ADD CONSTRAINT `video_tags_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
ADD CONSTRAINT `video_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`);
SET FOREIGN_KEY_CHECKS=1;
