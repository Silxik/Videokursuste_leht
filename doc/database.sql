-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Loomise aeg: Juuli 13, 2015 kell 09:32 PL
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (1, 'Twitter Bootstrap'),
  (2, 'Bootstrap 3'),
  (3, 'Web Design'),
  (4, 'Web Design Tutorial'),
  (5, 'Udemy'),
  (6, 'Udemy course'),
  (7, 'udemy web design'),
  (8, 'bootstrap tutorial'),
  (9, 'responsive web design'),
  (10, 'PHP (Programming Language)'),
  (11, 'learn to code'),
  (12, 'brad hussey'),
  (13, 'udemy courses'),
  (14, 'free tutorials'),
  (15, 'free programming tutorial'),
  (16, 'freebie'),
  (17, 'learn php'),
  (18, 'web development'),
  (19, 'Dynamic Web Page'),
  (20, 'Free'),
  (21, 'Helping develop'),
  (22, 'php'),
  (23, 'search'),
  (24, 'php search'),
  (25, 'make'),
  (26, 'custom'),
  (27, 'helpingdevelop'),
  (28, 'free'),
  (29, 'source'),
  (30, 'mysql'),
  (31, 'html'),
  (32, 'Joe'),
  (33, 'Smith'),
  (34, 'tutor'),
  (35, 'tutorial'),
  (36, 'PHP MySQL Tutorial'),
  (37, 'MySQL Prepared Statements'),
  (38, 'PHP Prepared Statements'),
  (39, 'MySQL (Software)'),
  (40, 'jquery'),
  (41, 'ajax'),
  (42, 'javascript'),
  (43, 'iviewsource'),
  (44, 'front end development');

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
  (1, 'Code a Responsive Website with Bootstrap 3 - [Lecture 1] Welcome & What is Bootstrap 3?', 'LECTURE 1\r\nIn this lecture, we briefly cover what Bootstrap 3 is and why it is different than the older versions of Twitter Bootstrap.\r\n\r\nDOWNLOAD FINAL COURSE FILES\r\nhttp://bradhussey.ca/bootstrap-course-files\r\n\r\nBUY ME A LATTÉ\r\nIf this course has helped', 'https://www.youtube.com/watch?v=oepmLGQP1m4', '2015-07-13 19:20:52', 1, 1),
  (2, 'Code Dynamic Websites with PHP [#1]', 'Hey everybody, welcome to Code Dynamic Websites with PHP!\r\n\r\nMy name is Brad Hussey and for the next little while, I''m going to be your personal instructor, and I will be teaching you how to hand code PHP!\r\n\r\nThis course is a Total Beginner''s Guide to Cod', 'https://www.youtube.com/watch?v=vJfXVAYSw04', '2015-07-13 19:21:28', 1, 1),
  (3, 'Creating a PHP Search', 'This is a tutorial which goes over how to create a PHP search which filters out results from a database table. Sorry for the mistakes made in this video, the video following this goes over how to take this and make it instant with jQuery\r\n\r\nTutor Facebook', 'https://www.youtube.com/watch?v=PBLuP2JZcEg', '2015-07-13 19:22:41', 1, 1),
  (4, 'PHP MySQL Tutorial', 'Get the Code Here : http://goo.gl/Aocylf\r\n\r\nPHP Tutorial : https://www.youtube.com/watch?v=7TF00hJI78Y\r\n\r\nMySQL Tutorial : https://www.youtube.com/watch?v=yPu6qV5byu4\r\n\r\nPreviously I covered the vast majority of both PHP and MySQL in 2 videos. This time I', 'https://www.youtube.com/watch?v=mpQts3ezPVg', '2015-07-13 19:25:18', 1, 1),
  (5, 'Learning how to use jQuery AJAX with PHP', 'Getting started with AJAX is super easy when you use the jQuery library. That works well for the client side, but how do you work with a server side language like PHP? It''s easier than you think.', 'https://www.youtube.com/watch?v=TR0gkGbMwW0', '2015-07-13 19:25:47', 1, 1);

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
  (1, 1),
  (1, 2),
  (1, 3),
  (1, 4),
  (1, 5),
  (1, 6),
  (1, 7),
  (1, 8),
  (1, 9),
  (2, 10),
  (4, 10),
  (2, 11),
  (2, 12),
  (2, 13),
  (2, 14),
  (2, 15),
  (2, 16),
  (2, 17),
  (2, 18),
  (2, 19),
  (2, 20),
  (3, 20),
  (3, 21),
  (3, 22),
  (5, 22),
  (3, 23),
  (3, 24),
  (3, 25),
  (3, 26),
  (3, 27),
  (3, 29),
  (3, 30),
  (3, 31),
  (3, 32),
  (3, 33),
  (3, 34),
  (3, 35),
  (5, 35),
  (4, 36),
  (4, 37),
  (4, 38),
  (4, 39),
  (5, 40),
  (5, 41),
  (5, 42),
  (5, 43),
  (5, 44);

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
MODIFY `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
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
