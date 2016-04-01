-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2016 at 01:58 PM
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
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(10) unsigned NOT NULL,
  `course_name` varchar(128) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id` int(10) unsigned NOT NULL,
  `course_desc` varchar(512) NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `date_added`, `person_id`, `course_desc`) VALUES
  (1, 'Kursuseta videod', '2015-07-14 16:56:35', 1, ''),
  (2, 'Test', '2016-04-01 14:19:00', 1, 'TestKirjeldus'),
  (3, 'Muusika', '2016-04-01 14:47:02', 1, 'MuusikaMuusika');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `username`, `person_firstname`, `person_lastname`, `person_first_visit`, `person_last_visit`, `person_SID`, `is_admin`, `password`, `active`, `email`, `setup`, `deleted`) VALUES
  (1, 'demo', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1, 'demo', 1, '', 0, 0),
  (2, 'henno.taht', 'Henno', 'Täht', '2015-07-06 15:02:15', '2015-07-06 18:05:18', '2e07cc7', 0, '', 0, '', 0, 0),
  (3, 'demo2', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 'demo2', 1, '', 0, 0),
  (4, 'riivo.stolts', 'Riivo', 'Stolts', '2015-07-17 16:34:55', '2015-07-17 17:11:12', 'ba02393', 0, '', 0, '', 0, 0),
  (5, 'tarmo.teekivi', 'Tarmo', 'Teekivi', '2015-07-17 16:36:31', '2015-07-17 16:36:57', 'e585916', 0, '', 0, '', 0, 0),
  (6, 'silver.kalda', 'Silver', 'Kalda', '2015-07-20 10:59:18', '2015-07-20 11:00:49', '0ea7e5a', 0, '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(10) unsigned NOT NULL,
  `tag_name` varchar(155) NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 40
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (1, 'php'),
  (2, 'tutorial'),
  (3, 'learn'),
  (4, 'basic'),
  (7, 'PHP'),
  (8, 'php tut'),
  (9, ''),
  (10, 'Electric Wizard (Musical Group)'),
  (11, 'Witchcult Today (Musical Recording)'),
  (12, 'Album'),
  (13, 'Witchcult Today'),
  (14, 'Dunwich'),
  (15, 'Satanic Rites of Drugula'),
  (16, 'Raptus'),
  (17, 'The Chosen Few'),
  (18, 'Torquemada ''71'),
  (19, 'sleep'),
  (20, 'dopesmoker'),
  (21, 'al cisneros'),
  (22, 'stoner rock'),
  (23, 'butterlove'),
  (24, 'Thoughty2'),
  (25, 'Facts'),
  (26, 'Interesting Facts'),
  (27, 'Fun Facts'),
  (28, 'Amazing Facts'),
  (29, 'list'),
  (30, 'top facts'),
  (31, 'animal'),
  (32, 'animals'),
  (33, 'amazing'),
  (34, 'ability'),
  (35, 'animal abilities'),
  (36, 'special'),
  (37, 'function'),
  (38, 'creative'),
  (39, 'immortality');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `video_id`    int(10) unsigned NOT NULL,
  `filename`    VARCHAR(256)              DEFAULT NULL,
  `title`       varchar(155)     NOT NULL,
  `video_desc`  varchar(512)     NOT NULL,
  `link`        varchar(155)     NOT NULL,
  `date_added`  timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `person_id`   int(10) unsigned NOT NULL,
  `public`      tinyint(1)       NOT NULL DEFAULT '1',
  `linktype`    tinyint(4)       NOT NULL DEFAULT '0',
  `course_id`   INT(10) UNSIGNED NOT NULL DEFAULT '1',
  `sub_fname`   VARCHAR(256)     NOT NULL,
  `uploader_ip` VARCHAR(50)      NOT NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 14
  DEFAULT CHARSET = utf8;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `filename`, `title`, `video_desc`, `link`, `date_added`, `person_id`, `public`, `linktype`, `course_id`, `sub_fname`, `uploader_ip`)
VALUES
  (4, 'Wildlife.mp4', '', '', '', '2016-04-01 10:06:54', 1, 1, 0, 0, '', '::1'),
  (5, 'Wildlife.mp4', '', '', '', '2016-04-01 10:09:53', 1, 1, 0, 0, '', '::1'),
  (6, 'Wildlife.mp4', '', '', '', '2016-04-01 10:18:37', 1, 1, 0, 0, '', '::1'),
  (7, 'Wildlife.mp4', '', '', '', '2016-04-01 10:20:36', 1, 1, 0, 0, '', '::1'),
  (8, 'Wildlife.mp4', '', '', '', '2016-04-01 10:38:59', 1, 1, 0, 1, '', '::1'),
  (9, NULL, 'Electric Wizard - Witchcult Today (Full Album)',
      'Witchcult Today 2007\r\n\r\nsetlist:\r\n1. Witchcult Today\r\n2. Dunwich\r\n3. Satanic Rites of Drugula\r\n4. Raptus\r\n5. The Chosen Few\r\n6. Torquemada ''71\r\n7. Black Magic Rituals & Perversions\r\n8. Saturnine',
      'Jzem_-At6F4', '2016-04-01 11:47:02', 1, 1, 0, 3, '', '::1'),
  (10, 'Wildlife.mp4', '', '', '', '2016-04-01 11:52:33', 1, 1, 1, 1, '', '::1'),
  (11, NULL, 'Sleep - Dopesmoker',
       'Drop out of life with bong in hand, follow the smoke to the Riff Filled Land.\r\n\r\nArtwork by Arik Roper from the Dopesmoker Reissue.',
       'hIw7oeZKpZc', '2016-04-01 11:54:09', 1, 1, 0, 3, '', '::1'),
  (12, 'Wildlife.mp4', 'Wildlife.mp4', '', '', '2016-04-01 11:54:34', 1, 0, 1, 2, '', '::1'),
  (13, NULL, '7 Amazing Animal Abilities',
       'You won''t believe what amazing abilities some animals possess. Thoughty2 reveals seven amazing party tricks from the animal kingdom.\r\nSUBSCRIBE - New Vids Mon & Thurs: http://bit.ly/thoughty2\r\n\r\nAsk a Question on Thoughty2.com: http://thoughty2.com/ask\r\nSupport me on Patreon: https://www.patreon.com/thoughty2\r\nThoughty2 Facebook: http://bit.ly/thoughtyfb\r\nThoughty2 Twitter: http://bit.ly/thoughty2twt\r\nThoughty2 Merchandise: http://thoughty2.spreadshirt.com\r\n\r\nWith Special Thanks To:\r\nMisha A-Wilson, Katrina',
       'M2-0zly1GmY', '2016-04-01 11:56:30', 1, 1, 0, 2, '', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `video_tags`
--

DROP TABLE IF EXISTS `video_tags`;
CREATE TABLE IF NOT EXISTS `video_tags` (
  `video_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `video_tags`
--

INSERT INTO `video_tags` (`video_id`, `tag_id`) VALUES
  (12, 9),
  (9, 10),
  (9, 11),
  (9, 12),
  (9, 13),
  (9, 14),
  (9, 15),
  (9, 16),
  (9, 17),
  (11, 19),
  (11, 20),
  (11, 21),
  (11, 22),
  (11, 23),
  (13, 24),
  (13, 25),
  (13, 26),
  (13, 27),
  (13, 28),
  (13, 29),
  (13, 30),
  (13, 31),
  (13, 32),
  (13, 33),
  (13, 34),
  (13, 35),
  (13, 36),
  (13, 37),
  (13, 38),
  (13, 39);

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
ADD PRIMARY KEY (`course_id`), ADD KEY `person_id` (`person_id`);

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
ADD PRIMARY KEY (`video_id`), ADD KEY `person_id` (`person_id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `video_tags`
--
ALTER TABLE `video_tags`
ADD PRIMARY KEY (`video_id`, `tag_id`), ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
MODIFY `comment_id` INT(155) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
MODIFY `course_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 4;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
MODIFY `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
MODIFY `tag_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 40;
--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
MODIFY `video_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 14;
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
-- Constraints for table `course`
--
ALTER TABLE `course`
ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`);

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
