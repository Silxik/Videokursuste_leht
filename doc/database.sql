-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Loomise aeg: Juuli 13, 2015 kell 04:09 PL
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (5, 'mysql'),
  (6, 'php'),
  (7, 'tutorial'),
  (8, 'Software'),
  (9, 'Helping develop'),
  (10, 'search'),
  (11, 'php search'),
  (12, 'make'),
  (13, 'custom'),
  (14, 'helpingdevelop'),
  (15, 'free'),
  (16, 'source'),
  (17, 'html'),
  (18, 'Joe'),
  (19, 'Smith'),
  (20, 'tutor'),
  (21, 'Twitter Bootstrap'),
  (22, 'Bootstrap 3'),
  (23, 'Web Design'),
  (24, 'Web Design Tutorial'),
  (25, 'Udemy'),
  (26, 'Udemy course'),
  (27, 'udemy web design'),
  (28, 'bootstrap tutorial'),
  (29, 'responsive web design'),
  (30, 'PHP (Programming Language)'),
  (31, 'learn to code'),
  (32, 'brad hussey'),
  (33, 'udemy courses'),
  (34, 'free tutorials'),
  (35, 'free programming tutorial'),
  (36, 'freebie'),
  (37, 'learn php'),
  (38, 'web development'),
  (39, 'Dynamic Web Page'),
  (40, 'Free');

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
  `public` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `video`
--

INSERT INTO `video` (`video_id`, `title`, `desc`, `link`, `date_added`, `person_id`, `public`) VALUES
  (2, 'PHP Tutorials: How to filter data from a MySQL Database Table with PHP', 'Hello everyone. This is another PHP / MySQL tutorial about how to filter data from a MySQL Database Table using PHP. As always, i have to apologize for my bad English. Feel free to mute the audio and watch the tutorial instead. I hope you find this tutori', 'https://www.youtube.com/watch?v=9J3S60VRYlE', '2015-07-13 14:03:28', 1, 1),
  (3, 'Creating a PHP Search', 'This is a tutorial which goes over how to create a PHP search which filters out results from a database table. Sorry for the mistakes made in this video, the video following this goes over how to take this and make it instant with jQuery\r\n\r\nTutor Facebook', 'https://www.youtube.com/watch?v=PBLuP2JZcEg', '2015-07-13 14:04:30', 1, 1),
  (4, 'Code a Responsive Website with Bootstrap 3 - [Lecture 1] Welcome & What is Bootstrap 3?', 'LECTURE 1\r\nIn this lecture, we briefly cover what Bootstrap 3 is and why it is different than the older versions of Twitter Bootstrap.\r\n\r\nDOWNLOAD FINAL COURSE FILES\r\nhttp://bradhussey.ca/bootstrap-course-files\r\n\r\nBUY ME A LATTÉ\r\nIf this course has helped', 'https://www.youtube.com/watch?v=oepmLGQP1m4', '2015-07-13 14:04:59', 1, 1),
  (5, 'Code Dynamic Websites with PHP [#1]', 'Hey everybody, welcome to Code Dynamic Websites with PHP!\r\n\r\nMy name is Brad Hussey and for the next little while, I''m going to be your personal instructor, and I will be teaching you how to hand code PHP!\r\n\r\nThis course is a Total Beginner''s Guide to Cod', 'https://www.youtube.com/watch?v=vJfXVAYSw04', '2015-07-13 14:05:09', 1, 1);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `video_tags`
--

DROP TABLE IF EXISTS `video_tags`;
CREATE TABLE IF NOT EXISTS `video_tags` (
  `video_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `video_tags`
--

INSERT INTO `video_tags` (`video_id`, `tag_id`) VALUES
  (2, 5),
  (3, 5),
  (2, 6),
  (3, 6),
  (2, 7),
  (3, 7),
  (2, 8),
  (3, 9),
  (3, 10),
  (3, 11),
  (3, 12),
  (3, 13),
  (3, 14),
  (3, 15),
  (5, 15),
  (3, 16),
  (3, 17),
  (3, 18),
  (3, 19),
  (3, 20),
  (4, 21),
  (4, 22),
  (4, 23),
  (4, 24),
  (4, 25),
  (4, 26),
  (4, 27),
  (4, 28),
  (4, 29),
  (5, 30),
  (5, 31),
  (5, 32),
  (5, 33),
  (5, 34),
  (5, 35),
  (5, 36),
  (5, 37),
  (5, 38),
  (5, 39);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `comment`
--
ALTER TABLE `comment`
ADD PRIMARY KEY (`comment_id`), ADD KEY `video_id` (`video_id`), ADD KEY `user_id` (`person_id`);

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
ADD PRIMARY KEY (`video_id`), ADD KEY `user_id` (`person_id`);

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
-- AUTO_INCREMENT tabelile `person`
--
ALTER TABLE `person`
MODIFY `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT tabelile `tag`
--
ALTER TABLE `tag`
MODIFY `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT tabelile `video`
--
ALTER TABLE `video`
MODIFY `video_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
-- Piirangud tabelile `video`
--
ALTER TABLE `video`
ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

--
-- Piirangud tabelile `video_tags`
--
ALTER TABLE `video_tags`
ADD CONSTRAINT `video_tags_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
ADD CONSTRAINT `video_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`);
SET FOREIGN_KEY_CHECKS=1;
