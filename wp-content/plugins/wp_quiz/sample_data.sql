-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2014 at 11:47 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wordpress`
--
CREATE DATABASE IF NOT EXISTS `wordpress` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wordpress`;

-- --------------------------------------------------------

--
-- Table structure for table `wp_quiz`
--

DROP TABLE IF EXISTS `wp_quiz`;
CREATE TABLE IF NOT EXISTS `wp_quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `instruction` mediumtext,
  `randomized` tinyint(1) NOT NULL DEFAULT '1',
  `questions_count` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `show_instruction` tinyint(1) NOT NULL DEFAULT '0',
  `show_contact_form` tinyint(1) NOT NULL,
  `contact_redirect` mediumtext,
  `hint` int(11) NOT NULL DEFAULT '0',
  `effect` enum('slide','fade') DEFAULT 'slide',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wp_quiz`
--

INSERT INTO `wp_quiz` (`id`, `title`, `instruction`, `randomized`, `questions_count`, `created`, `show_instruction`, `show_contact_form`, `contact_redirect`, `hint`, `effect`, `published`) VALUES
(2, 'Javascript', 'Most of the questions are about JavaScript basics merely wrapped around oddly annoying code for the sake of being interesting. This is just a fun quiz, not the developer equivalent of the bar or the MCATs! So relax and have fun! :)', 1, 5, '2013-06-18 08:57:13', 0, 1, '', 3, 'slide', 1),
(3, 'PHP', 'Absolute Basics of PHP', 0, 6, '2013-06-18 09:52:43', 0, 0, '', 0, 'fade', 1),
(4, 'Football Quiz', '', 0, 2, '2014-06-04 09:07:39', 0, 0, '', 2, 'fade', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_quiz_answers`
--

DROP TABLE IF EXISTS `wp_quiz_answers`;
CREATE TABLE IF NOT EXISTS `wp_quiz_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `weight` float NOT NULL DEFAULT '0' COMMENT '1: correct answer',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=147 ;

--
-- Dumping data for table `wp_quiz_answers`
--

INSERT INTO `wp_quiz_answers` (`id`, `question_id`, `answer`, `weight`) VALUES
(31, 9, 'Meow', 0),
(32, 9, 'Error', 1),
(33, 8, '510', 1),
(34, 8, '15', 0),
(35, 8, '105', 0),
(36, 8, '50', 0),
(41, 10, '5', 0),
(42, 10, '20', 0),
(43, 10, '4', 0),
(44, 10, '25', 1),
(49, 11, 'zz', 1),
(50, 11, 'False', 0),
(51, 11, 'undefined', 0),
(52, 11, 'TypeError', 0),
(57, 12, '5', 0),
(58, 12, '20', 0),
(59, 12, '4', 1),
(60, 12, '30', 0),
(119, 18, 'ss', 1),
(120, 18, 'rr', 3),
(121, 17, 'a2', 0),
(122, 17, 'aa', 1),
(123, 17, '2a', 0),
(124, 17, 'xa', 0),
(125, 16, '$variable', 0),
(126, 16, '$_variable', 0),
(127, 16, '$my-variable', 1),
(128, 16, '$my_variable', 0),
(129, 15, '$x = $x * 1', 0),
(130, 15, '$x = $x + 1', 1),
(131, 15, '$x = $x + $x', 0),
(132, 15, '$x = $x * $x', 0),
(133, 14, 'A coma [,]', 0),
(134, 14, 'Full stop [.]', 0),
(135, 14, 'Colon [:]', 0),
(136, 14, 'Semicolon [;]', 1),
(137, 13, 'True', 0),
(138, 13, 'False', 1),
(139, 19, '1990', 0),
(140, 19, '1994', 1),
(141, 19, '1998', 0),
(142, 19, '2006', 0),
(143, 20, 'England', 0),
(144, 20, 'Germany', 0),
(145, 20, 'Brazil', 1),
(146, 20, 'Italy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_quiz_questions`
--

DROP TABLE IF EXISTS `wp_quiz_questions`;
CREATE TABLE IF NOT EXISTS `wp_quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `explain` text,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `foreignIdx` (`quiz_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `wp_quiz_questions`
--

INSERT INTO `wp_quiz_questions` (`id`, `quiz_id`, `title`, `explain`, `published`) VALUES
(8, 2, 'var x="5", y="10";\r\nconsole.log(x+y);', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 1),
(9, 2, '(function() {\r\nvar kittySays = "Meow";\r\n})();\r\nconsole.log(kittySays);', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 1),
(10, 2, 'var x = 15, y = 10;\r\nconsole.log(x+++y);', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 1),
(11, 2, 'console.log (foo());\r\nfunction foo() { return "zz";}', NULL, 1),
(12, 2, 'var x = 15, y = 10;\r\nconsole.log(x++-++y);', NULL, 1),
(13, 3, 'PHP code can not be embedded within regular HTML code. This statement is...', NULL, 1),
(14, 3, 'Each statement in PHP needs to be ended with..', NULL, 1),
(15, 3, '$x += 1 is the same as..;', NULL, 1),
(16, 3, 'Which of these is an invalid variable name?', NULL, 1),
(17, 3, 'What will be the output for the following code:\r\n<code>&lt;?php\r\n$x = ''a'';\r\n$x .=$x;\r\necho $x;\r\n?&gt;</code>', NULL, 1),
(19, 4, 'What years did Brazil win the world cup?<iframe src="//www.youtube.com/embed/KIXlPp_t21k" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>', 'Visit here to check <a href="http://en.wikipedia.org/wiki/FIFA_World_Cup" target="_blank">http://en.wikipedia.org/wiki/FIFA_World_Cup</a>', 1),
(20, 4, 'Which is the only country to have played in every World Cup since it started in 1930?<img class="alignnone" src="http://static.tumblr.com/pke4pim/21Kn6n1b1/wc2014banner.jpg" alt="" width="600" height="200" />', 'Visit here to check <a href="http://en.wikipedia.org/wiki/FIFA_World_Cup" target="_blank">http://en.wikipedia.org/wiki/FIFA_World_Cup</a>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_quiz_questions_stat`
--

DROP TABLE IF EXISTS `wp_quiz_questions_stat`;
CREATE TABLE IF NOT EXISTS `wp_quiz_questions_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_stats_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL DEFAULT '0',
  `score` float NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `wp_quiz_questions_stat`
--

INSERT INTO `wp_quiz_questions_stat` (`id`, `quiz_stats_id`, `question_id`, `answer_id`, `score`, `created`) VALUES
(1, 1, 13, 137, 0, '2013-06-25 08:48:17'),
(2, 1, 14, 133, 0, '2013-06-25 08:48:17'),
(3, 1, 15, 129, 0, '2013-06-25 08:48:17'),
(4, 1, 16, 125, 0, '2013-06-25 08:48:17'),
(5, 1, 17, 121, 0, '2013-06-25 08:48:17'),
(6, 2, 13, 138, 1, '2013-06-25 08:48:39'),
(7, 2, 14, 136, 1, '2013-06-25 08:48:39'),
(8, 2, 15, 132, 0, '2013-06-25 08:48:39'),
(9, 2, 16, 128, 0, '2013-06-25 08:48:39'),
(10, 2, 17, 124, 0, '2013-06-25 08:48:39'),
(11, 3, 13, 138, 1, '2013-06-25 08:49:20'),
(12, 3, 14, 136, 1, '2013-06-25 08:49:20'),
(13, 3, 15, 130, 1, '2013-06-25 08:49:20'),
(14, 3, 16, 127, 1, '2013-06-25 08:49:20'),
(15, 3, 17, 122, 1, '2013-06-25 08:49:20'),
(16, 4, 13, 138, 1, '2013-06-25 08:49:49'),
(17, 4, 14, 136, 1, '2013-06-25 08:49:49'),
(18, 4, 15, 131, 0, '2013-06-25 08:49:49'),
(19, 4, 16, 126, 0, '2013-06-25 08:49:49'),
(20, 4, 17, 122, 1, '2013-06-25 08:49:49'),
(21, 5, 13, 138, 1, '2013-06-25 09:19:18'),
(22, 5, 14, 136, 1, '2013-06-25 09:19:18'),
(23, 5, 15, 130, 1, '2013-06-25 09:19:18'),
(24, 5, 16, 127, 1, '2013-06-25 09:19:18'),
(25, 5, 17, 123, 0, '2013-06-25 09:19:18'),
(26, 6, 13, 138, 1, '2013-06-25 09:19:41'),
(27, 6, 14, 136, 1, '2013-06-25 09:19:41'),
(28, 6, 15, 130, 1, '2013-06-25 09:19:41'),
(29, 6, 16, 127, 1, '2013-06-25 09:19:41'),
(30, 6, 17, 122, 1, '2013-06-25 09:19:41'),
(31, 7, 9, 32, 1, '2013-06-25 09:23:37'),
(32, 7, 8, 33, 1, '2013-06-25 09:23:37'),
(33, 7, 12, 59, 1, '2013-06-25 09:23:37'),
(34, 7, 10, 42, 0, '2013-06-25 09:23:37'),
(35, 7, 11, 49, 1, '2013-06-25 09:23:37'),
(36, 8, 11, 49, 1, '2013-06-25 09:24:13'),
(37, 8, 10, 41, 0, '2013-06-25 09:24:13'),
(38, 8, 8, 33, 1, '2013-06-25 09:24:13'),
(39, 8, 9, 31, 0, '2013-06-25 09:24:13'),
(40, 8, 12, 60, 0, '2013-06-25 09:24:13'),
(41, 9, 12, 60, 0, '2013-06-25 09:24:30'),
(42, 9, 10, 44, 1, '2013-06-25 09:24:30'),
(43, 9, 9, 32, 1, '2013-06-25 09:24:30'),
(44, 9, 11, 49, 1, '2013-06-25 09:24:30'),
(45, 9, 8, 36, 0, '2013-06-25 09:24:30'),
(46, 10, 10, 42, 0, '2013-06-25 09:26:17'),
(47, 10, 11, 52, 0, '2013-06-25 09:26:17'),
(48, 10, 12, 60, 0, '2013-06-25 09:26:17'),
(49, 10, 8, 34, 0, '2013-06-25 09:26:17'),
(50, 10, 9, 31, 0, '2013-06-25 09:26:17'),
(51, 11, 11, 52, 0, '2013-06-25 09:35:24'),
(52, 11, 9, 32, 1, '2013-06-25 09:35:24'),
(53, 11, 12, 60, 0, '2013-06-25 09:35:24'),
(54, 11, 8, 36, 0, '2013-06-25 09:35:24'),
(55, 11, 10, 41, 0, '2013-06-25 09:35:24'),
(56, 12, 10, 44, 1, '2013-06-25 09:42:13'),
(57, 12, 8, 36, 0, '2013-06-25 09:42:13'),
(58, 12, 9, 32, 1, '2013-06-25 09:42:13'),
(59, 12, 11, 50, 0, '2013-06-25 09:42:13'),
(60, 12, 12, 59, 1, '2013-06-25 09:42:13'),
(61, 13, 13, 137, 0, '2013-06-26 03:28:19'),
(62, 13, 14, 133, 0, '2013-06-26 03:28:19'),
(63, 13, 15, 129, 0, '2013-06-26 03:28:19'),
(64, 13, 16, 125, 0, '2013-06-26 03:28:19'),
(65, 13, 17, 121, 0, '2013-06-26 03:28:19'),
(66, 14, 13, 137, 0, '2013-06-26 03:29:15'),
(67, 14, 14, 136, 1, '2013-06-26 03:29:15'),
(68, 14, 15, 130, 1, '2013-06-26 03:29:15'),
(69, 14, 16, 126, 0, '2013-06-26 03:29:15'),
(70, 14, 17, 122, 1, '2013-06-26 03:29:15'),
(71, 0, 19, 140, 1, '2014-06-04 09:41:34'),
(72, 0, 20, 146, 0, '2014-06-04 09:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `wp_quiz_statistic`
--

DROP TABLE IF EXISTS `wp_quiz_statistic`;
CREATE TABLE IF NOT EXISTS `wp_quiz_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `wp_quiz_statistic`
--

INSERT INTO `wp_quiz_statistic` (`id`, `quiz_id`, `ip_address`, `score`, `created`) VALUES
(1, 3, '127.0.0.1', 0, '2013-06-25 08:48:17'),
(2, 3, '127.0.0.1', 2, '2013-06-25 08:48:39'),
(3, 3, '127.0.0.1', 5, '2013-06-25 08:49:20'),
(4, 3, '127.0.0.1', 3, '2013-06-25 08:49:49'),
(5, 3, '127.0.0.1', 4, '2013-06-25 09:19:18'),
(6, 3, '127.0.0.1', 5, '2013-06-25 09:19:41'),
(7, 2, '127.0.0.1', 4, '2013-06-25 09:23:37'),
(8, 2, '127.0.0.1', 2, '2013-06-25 09:24:13'),
(9, 2, '127.0.0.1', 3, '2013-06-25 09:24:30'),
(10, 2, '127.0.0.1', 0, '2013-06-25 09:26:17'),
(11, 2, '127.0.0.1', 1, '2013-06-25 09:35:24'),
(12, 2, '127.0.0.1', 3, '2013-06-25 09:42:13'),
(13, 3, '127.0.0.1', 0, '2013-06-26 03:28:19'),
(14, 3, '127.0.0.1', 3, '2013-06-26 03:29:15');
