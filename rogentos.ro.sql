-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2012 at 09:10 AM
-- Server version: 5.5.24-7-log
-- PHP Version: 5.4.4-4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rogentos.ro`
--

-- --------------------------------------------------------

--
-- Table structure for table `ITEMS`
--

CREATE TABLE IF NOT EXISTS `ITEMS` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `type` char(40) NOT NULL,
  `name_ro` text NOT NULL,
  `name_en` text NOT NULL,
  `new` char(3) NOT NULL,
  `description` text,
  `SEO` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ITEMS`
--

INSERT INTO `ITEMS` (`id`, `type`, `name_ro`, `name_en`, `new`, `description`, `SEO`) VALUES
(1, 'single', 'Acasa', 'Home', '', NULL, ''),
(2, 'single', 'Despre', 'Despre', '', NULL, ''),
(3, 'single', 'Descarca', 'Download', '', NULL, 'a:1:{s:2:"en";a:4:{s:9:"title_tag";s:0:"";s:10:"title_meta";s:0:"";s:16:"description_meta";s:0:"";s:13:"keywords_meta";s:0:"";}}'),
(4, 'webchat', 'Webchat', 'Webchat', '', NULL, ''),
(5, 'contact', 'Contact', 'Contact', '', NULL, ''),
(6, 'single', 'Bugs', 'Implica-te', '', NULL, ''),
(7, 'simpleGallery', 'Galerie', 'Galerie', '', NULL, 'a:1:{s:2:"en";a:4:{s:9:"title_tag";s:18:"Galerie de imagini";s:10:"title_meta";s:18:"Galerie de imagini";s:16:"description_meta";s:37:"Galerie de imagini Rogentos GNU/Linux";s:13:"keywords_meta";s:0:"";}}'),
(8, 'single', 'Echipa', 'Echipa', '', NULL, 'a:1:{s:2:"en";a:4:{s:9:"title_tag";s:0:"";s:10:"title_meta";s:0:"";s:16:"description_meta";s:0:"";s:13:"keywords_meta";s:0:"";}}'),
(9, 'none', 'Wiki', 'Wiki', '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `MENUS`
--

CREATE TABLE IF NOT EXISTS `MENUS` (
  `id` int(3) NOT NULL,
  `idM` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MENUS`
--

INSERT INTO `MENUS` (`id`, `idM`) VALUES
(1, 1),
(2, 1),
(9, 1),
(7, 1),
(3, 1),
(6, 1),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TREE`
--

CREATE TABLE IF NOT EXISTS `TREE` (
  `Pid` int(3) NOT NULL,
  `Cid` int(3) NOT NULL,
  `poz` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TREE`
--

INSERT INTO `TREE` (`Pid`, `Cid`, `poz`) VALUES
(0, 1, 0),
(0, 2, 1),
(2, 8, 0),
(0, 9, 2),
(0, 7, 3),
(0, 3, 4),
(0, 6, 5),
(0, 4, 6),
(0, 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(5) NOT NULL AUTO_INCREMENT,
  `username` char(30) DEFAULT NULL,
  `user_rfirst` char(25) DEFAULT NULL,
  `user_rlast` char(30) DEFAULT NULL,
  `dept` char(100) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `level` char(1) DEFAULT NULL,
  `lastlogin` char(10) DEFAULT NULL,
  `lastip` char(15) DEFAULT '0.0.0.0',
  `lastbrowser` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- --------------------------------------------------------

--
-- Stand-in structure for view `view_TREE`
--
CREATE TABLE IF NOT EXISTS `view_TREE` (
`Pid` int(3)
,`Cid` int(3)
,`type` char(40)
,`name_ro` text
,`name_en` text
,`poz` int(2)
,`new` char(3)
);
-- --------------------------------------------------------

--
-- Structure for view `view_TREE`
--
DROP TABLE IF EXISTS `view_TREE`;

CREATE ALGORITHM=UNDEFINED DEFINER=`koltzu_rgnts-www`@`localhost` SQL SECURITY DEFINER VIEW `view_TREE` AS select `TREE`.`Pid` AS `Pid`,`TREE`.`Cid` AS `Cid`,`ITEMS`.`type` AS `type`,`ITEMS`.`name_ro` AS `name_ro`,`ITEMS`.`name_en` AS `name_en`,`TREE`.`poz` AS `poz`,`ITEMS`.`new` AS `new` from (`TREE` join `ITEMS` on((`TREE`.`Cid` = `ITEMS`.`id`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
