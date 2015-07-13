-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Loomise aeg: Juuli 13, 2015 kell 12:22 PL
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `rating`, `date_added`, `video_id`, `person_id`) VALUES
  (1, 'Lahe video!', 5, '2015-07-11 16:26:10', 2, 3),
  (2, 'Huvitav video!', 5, '2015-07-11 16:26:10', 1, 1),
  (3, 'Animators UNITE!!!', 5, '2015-07-11 16:26:10', 2, 1),
  (4, 'Good to know!', 5, '2015-07-11 16:26:10', 2, 1),
  (5, 'I wish to be such good animator', 5, '2015-07-11 16:26:10', 2, 1),
  (6, 'Animator test', 5, '2015-07-11 16:26:10', 2, 1),
  (7, 'ALL BOW TO MASTER ANIMATOR!', 5, '2015-07-11 16:27:04', 2, 1),
  (8, 'I am here to troll and chew bubblegum... And I am all out of bubble gum! THIS VIDEO SUCKS, YOU ARE JUST LAZY!', 5, '2015-07-11 16:30:35', 2, 1),
  (9, 'half-life 3 confirmed', 5, '2015-07-11 17:33:34', 2, 3),
  (10, 'Kommentaar', 5, '2015-07-13 07:24:26', 2, 1),
  (11, 'Test2', 5, '2015-07-13 07:28:59', 2, 1),
  (12, 'kolm', 5, '2015-07-13 07:30:24', 2, 1),
  (13, 'neljas katse', 5, '2015-07-13 07:53:17', 2, 1),
  (14, 'Mina ka!', 5, '2015-07-13 07:53:47', 2, 3);

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
  `tag_name` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (1, 'Top 10'),
  (2, 'Animator'),
  (3, 'WatchMojo'),
  (4, 'TomSka');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `link` varchar(155) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id` int(10) unsigned NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `tags` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `video`
--

INSERT INTO `video` (`video_id`, `title`, `desc`, `link`, `date_added`, `person_id`, `public`, `tags`) VALUES
  (1, 'Top 10 SyFy Channel Shows', 'Blurring the line between fantasy and reality, natural and supernatural, normal and paranormal, these are the shows that defined a network. ', 'https://www.youtube.com/watch?v=CPSI9sLxIew', '2015-07-02 12:52:21', 1, 1, ''),
  (2, 'I''M NOT AN ANIMATOR', 'TOMSKA YOU ARE MY FAVOURITE ANIMATOR! NOOOO.', 'https://www.youtube.com/watch?v=mcrsyXyd34A', '2015-07-02 13:14:02', 1, 1, ''),
  (3, 'asdfmovie 1-8 (Complete Collection)', 'every asdfmovie so far! oh my!!!', 'http://www.youtube.com/watch?v=PF9z-kEmic4', '2015-07-13 10:04:18', 3, 1, '');

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
  (2, 2),
  (3, 2),
  (1, 3),
  (2, 4),
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
MODIFY `comment_id` int(155) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT tabelile `person`
--
ALTER TABLE `person`
MODIFY `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT tabelile `tag`
--
ALTER TABLE `tag`
MODIFY `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
