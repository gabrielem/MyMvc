-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2012 at 03:32 PM
-- Server version: 5.1.62
-- PHP Version: 5.3.5-1ubuntu7.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_admin_menu`
--

CREATE TABLE IF NOT EXISTS `a_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posizione` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin` int(11) NOT NULL DEFAULT '0',
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `a_admin_menu`
--

INSERT INTO `a_admin_menu` (`id`, `posizione`, `nome`, `admin`, `url`) VALUES
(3, 0, 'admin', 1, ''),
(4, 50, 'exit', 0, '$rootBaseAdmin/url/_logout'),
(6, -1, 'home', 0, '$rootBaseAdmin'),
(11, 0, 'data', 0, '#');

-- --------------------------------------------------------

--
-- Table structure for table `a_admin_menu_items`
--

CREATE TABLE IF NOT EXISTS `a_admin_menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_menu` int(11) NOT NULL DEFAULT '0',
  `selettore` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_s` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `a_admin_menu_items`
--

INSERT INTO `a_admin_menu_items` (`id`, `nome`, `id_menu`, `selettore`, `id_s`) VALUES
(8, 'menu', 3, 'tab', 'admin_menu'),
(7, 'utenti', 3, 'tab', 'admin_users'),
(9, 'test', 3, 'tab', 'test'),
(13, 'schema', 3, 'url', '_schema_generate'),
(15, 'relazioni', 3, 'url', '_relazioni_db'),
(16, 'test cat', 3, 'tab', 'test_cat'),
(17, 'logout', 4, 'url', '_logout'),
(18, 'img per le tabelle', 3, 'url', '_img_tab'),
(19, 'allinea DB', 3, 'url', '_allinea'),
(25, 'tab contenuti', 3, 'url', '_tab_contenuti'),
(26, 'mod&comp', 3, 'url', '_mod_comp'),
(27, 'testing', 3, 'tab', 'testing'),
(28, 'testing cat', 3, 'tab', 'testing_cat'),
(40, 'routes', 3, 'tab', 'routes'),
(51, 'Pages', 11, 'tab', 'sezioni'),
(57, 'Country', 11, 'tab', 'paesi');

-- --------------------------------------------------------

--
-- Table structure for table `a_admin_users`
--

CREATE TABLE IF NOT EXISTS `a_admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cognome` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attivo` int(11) NOT NULL DEFAULT '0',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `a_admin_users`
--

INSERT INTO `a_admin_users` (`id`, `nome`, `cognome`, `email`, `attivo`, `password`, `admin`) VALUES
(1, 'q', 'q', 'gabriele.marazzi@gmail.com', 1, 'q', 1),
(8, 'a', 'a', 'pubblicitae@gmail.com', 1, 'a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `a_utenti`
--

CREATE TABLE IF NOT EXISTS `a_utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_a_utenti_cat` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cognome` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `data_iscrizione` int(11) NOT NULL DEFAULT '0',
  `attivo` int(11) NOT NULL DEFAULT '0',
  `bannato` int(11) NOT NULL DEFAULT '0',
  `data_nascita` int(11) NOT NULL DEFAULT '0',
  `indirizzo` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `citta` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `provincia` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regione` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `paese` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cap` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cf` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `piva` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=214 ;

--
-- Dumping data for table `a_utenti`
--

INSERT INTO `a_utenti` (`id`, `id_a_utenti_cat`, `nome`, `cognome`, `email`, `password`, `data_iscrizione`, `attivo`, `bannato`, `data_nascita`, `indirizzo`, `citta`, `provincia`, `regione`, `paese`, `cap`, `cf`, `piva`) VALUES
(1, 2, 'Gabriele', 'Marazzi', 'gabriele.marazzi@gmail.com', '7694f4a66316e53c8cdd9d9954bd611d', 1318903622, 1, 0, 0, 'via giacomo matteotti, 14', 'Capena', 'Roma', 'Lazio', 'Italia', '00015', 'MRZGRL78C01H501D', ''),
(212, 2, 'p', 'b', 'pubblicitae@gmail.com', '7694f4a66316e53c8cdd9d9954bd611d', 1319358566, 1, 0, 1319358566, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `a_utenti_cat`
--

CREATE TABLE IF NOT EXISTS `a_utenti_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nome_uri` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `testo` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `testo2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `visibile` int(1) NOT NULL DEFAULT '0',
  `posizione` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `a_utenti_cat`
--

INSERT INTO `a_utenti_cat` (`id`, `nome`, `nome_uri`, `testo`, `testo2`, `visibile`, `posizione`) VALUES
(1, 'gruppo1', 'gruppo1', '...', '...', 1, 0),
(2, 'gruppo2', 'gruppo2', '...', '...', 1, 0),
(3, 'admin', 'admin', 'admin', 'admin', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `login` int(11) NOT NULL DEFAULT '0',
  `login_set` int(11) NOT NULL DEFAULT '0',
  `login_tab` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `name`, `slug`, `model`, `login`, `login_set`, `login_tab`) VALUES
(1, 'admin', 'admin', 'admin', 1, 0, '');
