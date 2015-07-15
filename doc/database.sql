-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2015 at 09:15 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `videokursused`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
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
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(128) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id` int(16) NOT NULL,
  `course_desc` varchar(512) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `date_added`, `person_id`, `course_desc`) VALUES
  (1, 'Test', '2015-07-14 16:56:35', 1, 'TESTTEST'),
  (2, 'Test2', '2015-07-14 17:59:51', 0, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `person`
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
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `username`, `person_firstname`, `person_lastname`, `person_first_visit`, `person_last_visit`, `person_SID`, `is_admin`, `password`, `active`, `email`, `setup`, `deleted`) VALUES
  (1, 'demo', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1, 'demo', 1, '', 0, 0),
  (2, 'henno.taht', 'Henno', 'Täht', '2015-07-06 15:02:15', '2015-07-06 18:05:18', '2e07cc7', 0, '', 0, '', 0, 0),
  (3, 'demo2', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 'demo2', 1, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(10) unsigned NOT NULL,
  `tag_name` varchar(155) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (49, 'php'),
  (50, 'tutorial'),
  (51, 'learn'),
  (52, 'simple'),
  (53, 'basic'),
  (54, 'quick'),
  (55, 'easy'),
  (56, 'program'),
  (57, 'programming'),
  (58, 'code'),
  (59, 'web'),
  (60, 'app'),
  (61, 'application'),
  (62, 'script'),
  (63, 'windows'),
  (64, 'mac'),
  (65, 'os x'),
  (66, 'pc'),
  (67, 'internet'),
  (68, 'language'),
  (69, 'website'),
  (70, 'jake'),
  (71, 'wright'),
  (72, 'howto'),
  (73, 'how to'),
  (74, 'write'),
  (75, 'site'),
  (76, 'beginner'),
  (77, 'Selenium (Software)'),
  (78, 'Mink (Software)'),
  (79, 'Behavior-driven Development (Software Genre)'),
  (80, 'Software Testing (Software)'),
  (81, 'Behat (Software)'),
  (82, 'PHP'),
  (83, 'PHP (Programming Language)'),
  (84, 'Web Design (Interest)'),
  (85, 'php video tutorialphp tutorial'),
  (86, 'php mysql tutorial'),
  (87, 'php tutorial for beginnersmysql php tutorialphp tutorial videobeginning php tutorial'),
  (88, 'php game programming tutorial'),
  (89, 'php paypal tutorial'),
  (90, 'php beginners tutorial'),
  (91, 'mysql with php tutorialphp socket programming tutorial'),
  (92, 'php tutorial download'),
  (93, 'Tutorial (Media Genre)'),
  (94, 'Web Page'),
  (95, 'PayPal (Venture Funded Company)'),
  (96, 'PHP for Web Designers'),
  (97, 'Web Designers');

-- --------------------------------------------------------

--
-- Table structure for table `video`
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
  `course_id` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `title`, `desc`, `link`, `date_added`, `person_id`, `public`, `linktype`, `course_id`) VALUES
  (7, 'Learn PHP in 15 minutes', 'PHP is one of the most useful languages to know and is used everywhere you look online. In this tutorial, I start from the beginning and show you how to start writing PHP scripts.\r\n\r\nThe video covers the software you need to get started, data types, outpu', 'ZdP0KM49IVk', '2015-07-14 12:17:13', 1, 1, 0, 0),
  (8, 'PHP Tutorial 1 - Introduction (PHP For Beginners).mp4', '', '8.mp4', '2015-07-14 12:19:40', 1, 1, 1, 0),
  (9, 'Quickstart to testing your website with Behat, Mink, and Selenium', 'It is easy to test your website''s functionality using Behat, a PHP framework for BDD (behavior driven development). This video quickly goes through the configuration of Behat, Mink, and Selenium.', '9cYhnTojaHU', '2015-07-14 12:20:45', 1, 1, 0, 0),
  (10, 'PHP for Web Designers | PHP Video Tutorial for Beginners | The Complete Guide to Learn PHP', 'PHP for Web Designers 2015 | PHP Video Tutorial for Beginners | \r\nThe Complete Guide to Learn PHP \r\n\r\nMust Watch : New PHP with MYSQL Tutorial in HD(https://www.youtube.com/watch?v=WG6cMci6X50)\r\n\r\nThere are many great reasons to learn PHP. You can reduce ', 'UvGs9zhfPEE', '2015-07-14 15:03:23', 1, 1, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `video_tags`
--

DROP TABLE IF EXISTS `video_tags`;
CREATE TABLE IF NOT EXISTS `video_tags` (
  `video_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `video_tags`
--

INSERT INTO `video_tags` (`video_id`, `tag_id`) VALUES
  (7, 49),
  (8, 49),
  (9, 49),
  (7, 50),
  (7, 51),
  (7, 52),
  (7, 53),
  (7, 54),
  (7, 55),
  (7, 56),
  (7, 57),
  (7, 58),
  (7, 59),
  (7, 60),
  (7, 61),
  (7, 62),
  (7, 63),
  (7, 64),
  (7, 65),
  (7, 66),
  (7, 67),
  (7, 68),
  (7, 69),
  (7, 70),
  (7, 71),
  (7, 72),
  (7, 73),
  (7, 74),
  (7, 75),
  (8, 76),
  (9, 77),
  (9, 78),
  (9, 79),
  (9, 80),
  (9, 81),
  (10, 83),
  (10, 84),
  (10, 85),
  (10, 86),
  (10, 87),
  (10, 88),
  (10, 89),
  (10, 90),
  (10, 91),
  (10, 92),
  (10, 93),
  (10, 94),
  (10, 95),
  (10, 96),
  (10, 97);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
ADD PRIMARY KEY (`comment_id`), ADD KEY `video_id` (`video_id`), ADD KEY `user_id` (`person_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
ADD PRIMARY KEY (`person_id`), ADD UNIQUE KEY `UNIQUE` (`username`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
ADD PRIMARY KEY (`video_id`), ADD KEY `user_id` (`person_id`);

--
-- Indexes for table `video_tags`
--
ALTER TABLE `video_tags`
ADD PRIMARY KEY (`video_id`,`tag_id`), ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
MODIFY `comment_id` int(155) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
MODIFY `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
MODIFY `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
MODIFY `video_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

--
-- Constraints for table `video_tags`
--
ALTER TABLE `video_tags`
ADD CONSTRAINT `video_tags_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
ADD CONSTRAINT `video_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`);
SET FOREIGN_KEY_CHECKS=1;
