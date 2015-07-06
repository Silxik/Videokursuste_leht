-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Loomise aeg: Juuli 06, 2015 kell 11:40 EL
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
-- Tabeli struktuur tabelile `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(25) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `user`
--

INSERT INTO `user` (`user_id`, `username`, `is_admin`, `password`, `active`, `email`, `deleted`) VALUES
  (1, 'demo', 0, 'demo', 1, '', 0);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `link` varchar(155) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Andmete tõmmistamine tabelile `video`
--

INSERT INTO `video` (`video_id`, `title`, `description`, `link`, `date_added`, `user_id`) VALUES
  (1, 'Top 10 SyFy Channel Shows', 'Blurring the line between fantasy and reality, natural and supernatural, normal and paranormal, these are the shows that defined a network. ', 'https://www.youtube.com/watch?v=CPSI9sLxIew', '2015-07-02 12:52:21', 1),
  (2, 'I''M NOT AN ANIMATOR', 'TOMSKA YOU ARE MY FAVOURITE ANIMATOR! NOOOO.', 'https://www.youtube.com/watch?v=mcrsyXyd34A', '2015-07-02 13:14:02', 1);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `UNIQUE` (`username`);

--
-- Indeksid tabelile `video`
--
ALTER TABLE `video`
ADD PRIMARY KEY (`video_id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT tabelile `video`
--
ALTER TABLE `video`
MODIFY `video_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Tõmmistatud tabelite piirangud
--

--
-- Piirangud tabelile `video`
--
ALTER TABLE `video`
ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
SET FOREIGN_KEY_CHECKS=1;
