-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 14, 2022 at 01:16 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `alarm_oorzaak`
--

DROP TABLE IF EXISTS `alarm_oorzaak`;
CREATE TABLE IF NOT EXISTS `alarm_oorzaak` (
  `id` int NOT NULL AUTO_INCREMENT,
  `oorzaak` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alarm_oorzaak`
--

INSERT INTO `alarm_oorzaak` (`id`, `oorzaak`) VALUES
(1, '11 Fire general'),
(2, '12 Arson'),
(3, '21 Operating error'),
(4, '22 Malice/Mischief');

-- --------------------------------------------------------

--
-- Table structure for table `alarm_soort`
--

DROP TABLE IF EXISTS `alarm_soort`;
CREATE TABLE IF NOT EXISTS `alarm_soort` (
  `id` int NOT NULL AUTO_INCREMENT,
  `soort` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alarm_soort`
--

INSERT INTO `alarm_soort` (`id`, `soort`) VALUES
(1, 'Fire'),
(2, 'Wrong call Fire Alarm'),
(3, 'False Fire ALarm'),
(4, 'Panel/group Shutdown');

-- --------------------------------------------------------

--
-- Table structure for table `alarm_storing`
--

DROP TABLE IF EXISTS `alarm_storing`;
CREATE TABLE IF NOT EXISTS `alarm_storing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `storing` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alarm_storing`
--

INSERT INTO `alarm_storing` (`id`, `storing`) VALUES
(1, 'Central Malfunction'),
(3, 'Fault in detectors'),
(4, 'Auxiliary Equipment Failures'),
(5, 'Report Failure');

-- --------------------------------------------------------

--
-- Table structure for table `alarm_werkzaamheden`
--

DROP TABLE IF EXISTS `alarm_werkzaamheden`;
CREATE TABLE IF NOT EXISTS `alarm_werkzaamheden` (
  `id` int NOT NULL AUTO_INCREMENT,
  `werkzaamheid` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alarm_werkzaamheden`
--

INSERT INTO `alarm_werkzaamheden` (`id`, `werkzaamheid`) VALUES
(1, 'Periodic Maintenance Manager'),
(2, 'Periodic Maintenance OD'),
(3, 'System Customization');

-- --------------------------------------------------------

--
-- Table structure for table `reg_alarm`
--

DROP TABLE IF EXISTS `reg_alarm`;
CREATE TABLE IF NOT EXISTS `reg_alarm` (
  `alarm_ID` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datum2` varchar(20) DEFAULT 'n.v.t.',
  `melding_soort` varchar(40) NOT NULL,
  `gebouw` varchar(50) NOT NULL,
  `ruimte` varchar(20) DEFAULT NULL,
  `oorzaak` varchar(40) DEFAULT NULL,
  `storing` varchar(40) DEFAULT NULL,
  `medewerker` varchar(40) NOT NULL,
  `br_tel` varchar(3) DEFAULT 'nee',
  `br_bhv` varchar(3) DEFAULT 'nee',
  `br_br` varchar(3) DEFAULT 'nee',
  `inb_meld` varchar(3) DEFAULT 'nee',
  `inb_zelf` varchar(3) DEFAULT 'nee',
  `inb_bev` varchar(3) DEFAULT 'nee',
  `opmerking` text,
  `voortgang` text,
  `controle` varchar(3) NOT NULL DEFAULT 'nee',
  `medew_controle` varchar(40) DEFAULT NULL,
  `werk` text,
  `werk_tot` varchar(20) DEFAULT NULL,
  `BMC` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`alarm_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=673 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_alarm`
--

INSERT INTO `reg_alarm` (`alarm_ID`, `datum`, `datum2`, `melding_soort`, `gebouw`, `ruimte`, `oorzaak`, `storing`, `medewerker`, `br_tel`, `br_bhv`, `br_br`, `inb_meld`, `inb_zelf`, `inb_bev`, `opmerking`, `voortgang`, `controle`, `medew_controle`, `werk`, `werk_tot`, `BMC`) VALUES
(0001, '2009-01-08 09:39:22', '17-03-2009 14:30', 'CV storing', 'pav 2 - 201', 'test jurgen', 'n.v.t.', 'n.v.t.', 'Shilpa', 'nee', 'nee', 'nee', 'nee', 'nee', 'nee', 'test test', '', 'ja', 'Ronny de Hullu', '52 periodiek onderhoud OD', 'ww11', NULL),
(0002, '2009-01-19 14:54:55', '17-03-2009 14:30', 'loos inbraakalarm', 'Hoofdgebouw BG - 120', 'MM', '21 bedieningsfout', 'n.v.t.', 'Amit', 'nee', 'nee', 'nee', 'nee', 'nee', 'nee', 'zelf de deur te snel afgesloten en toen alarm...\r\nsorry', '', 'ja', 'Ronny de Hullu', 'n.v.t.', NULL, NULL),
(0003, '2009-02-17 11:20:26', '17-02-2009 12:22', 'Onechte brandmelding', 'School - 000', 'gang', '22 kwaadwilligheid / kattekwaad', 'n.v.t.', 'Neha', 'nee', 'ja', 'nee', 'nee', 'nee', 'nee', 'handmelder ingedrukt door kind', '', 'ja', 'Ronny de Hullu', 'n.v.t.', NULL, NULL),
(0004, '2009-03-05 08:39:57', '17-03-2009 14:30', 'Ongewenste brandmelding', 'Ketelhuis - 131', NULL, '27 bouwkundige werkzaamheden', '47 storing overige', 'Neha', 'ja', 'nee', 'nee', 'nee', 'nee', 'nee', '5 maart 2009 :storing en brandalarm door kapotgetrokken voedingkabels tijdens graafwerkzaamheden aan de hellingbaan naar de muziekkelder', '', 'ja', 'Ronny de Hullu', '56 uitschakelen i.v.m. kortstondige wzh', NULL, NULL),
(0672, '2022-11-13 17:30:09', '13-11-2022 18:33', 'Fire', 'pav 3 Woody Woodpecker - 103', '15', 'n.v.t.', 'n.v.t.', 'Neha Hanamsagar', 'nee', 'nee', 'nee', 'nee', 'nee', 'nee', 'adsfasdfasdfasdf', NULL, 'nee', 'n.v.t.', 'n.v.t.', NULL, NULL),
(0671, '2022-11-13 17:29:49', 'n.v.t.', 'Wrong call Fire Alarm', 'pav 1 Lady marian - 102', NULL, NULL, 'n.v.t.', 'Neha Hanamsagar', 'nee', 'nee', 'nee', 'nee', 'nee', 'nee', 'asdffgasdfasdgsdfg', NULL, 'nee', NULL, NULL, NULL, NULL),
(0670, '2022-11-13 14:59:16', '13-11-2022 14:59', 'Onechte brandmelding', 'pav 1 Lady marian - 102', '14', '12 brandstichting', '41 storing in centrale', 'Neha Hanamsagar', 'nee', 'nee', 'nee', 'nee', 'nee', 'nee', 'asdfasdfasdfsdf', NULL, 'nee', 'n.v.t.', 'n.v.t.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reg_bedrijven`
--

DROP TABLE IF EXISTS `reg_bedrijven`;
CREATE TABLE IF NOT EXISTS `reg_bedrijven` (
  `bedrijf_ID` int NOT NULL AUTO_INCREMENT,
  `bedrijf` varchar(40) NOT NULL,
  `telefoon` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `omschr` text,
  `cont_pers1` varchar(40) DEFAULT NULL,
  `cont_pers1_omsch` text,
  `cont_pers2` varchar(40) DEFAULT NULL,
  `cont_pers2_omsch` text,
  `zichtbaar` enum('Ja','Nee') NOT NULL DEFAULT 'Ja',
  PRIMARY KEY (`bedrijf_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_bedrijven`
--

INSERT INTO `reg_bedrijven` (`bedrijf_ID`, `bedrijf`, `telefoon`, `fax`, `email`, `omschr`, `cont_pers1`, `cont_pers1_omsch`, `cont_pers2`, `cont_pers2_omsch`, `zichtbaar`) VALUES
(27, 'Fire Department', '33333', '33333', 'asdf@dsfg.com', 'asdfasdfsa', 'Someone', 'asdfasdf', 'who', 'asdfasdfs', 'Nee'),
(4, 'Kroon', '546765', '876856767', 'sadfdsf', 'fasdfsdfsadfsd', 'aasdfsdaf', 'asdfsadfas', 'asdfasdf', 'asdfasdf', 'Nee'),
(5, 'Leo Leo', '4354434', '345354', '435435', '3454345345345', 'sfgsdg', 'sdffgsdfg', 'sdffgsdf', 'sdfgsdfg', 'Ja'),
(6, 'Point Taken', '345345', '325435', 'hjh@jasd.coasdf', 'asdfsdgdfsgfg', 'This', 'kajsdjkffkas', 'that', 'asdfsdafs', 'Ja'),
(59, 'Coffee Cafe', '23232323', '12121212', 'this@that.com', 'This is a good coffee cafe, makes good coffee at a good price', 'Neel', 'Makes a good coffee', 'Paul', 'Makes a good coffee too', 'Nee');

-- --------------------------------------------------------

--
-- Table structure for table `reg_bmc`
--

DROP TABLE IF EXISTS `reg_bmc`;
CREATE TABLE IF NOT EXISTS `reg_bmc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `BMC` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_bmc`
--

INSERT INTO `reg_bmc` (`id`, `BMC`) VALUES
(1, 'Monthly Check');

-- --------------------------------------------------------

--
-- Table structure for table `reg_gebouw`
--

DROP TABLE IF EXISTS `reg_gebouw`;
CREATE TABLE IF NOT EXISTS `reg_gebouw` (
  `gebouw_ID` int NOT NULL AUTO_INCREMENT,
  `gebouw` varchar(40) NOT NULL,
  `kostenpl` varchar(10) DEFAULT 'invullen',
  `omschrijving` text NOT NULL,
  PRIMARY KEY (`gebouw_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_gebouw`
--

INSERT INTO `reg_gebouw` (`gebouw_ID`, `gebouw`, `kostenpl`, `omschrijving`) VALUES
(1, 'pav 1 Robin Hood - 101', '', ''),
(2, 'pav 1 Lady marian - 102', '', ''),
(3, 'pav 2 - Speedy Gonzalez 201', '', ''),
(4, 'pav 3 Woody Woodpecker - 103', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `reg_incident`
--

DROP TABLE IF EXISTS `reg_incident`;
CREATE TABLE IF NOT EXISTS `reg_incident` (
  `Incident_ID` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datum2` date DEFAULT NULL,
  `locatie` varchar(50) DEFAULT NULL,
  `melder` varchar(50) DEFAULT NULL,
  `medewerker` varchar(40) DEFAULT NULL,
  `aard_incident` varchar(50) DEFAULT NULL,
  `anders_NL_aard` varchar(50) DEFAULT NULL,
  `alarmeren_int` varchar(50) DEFAULT NULL,
  `anders_NL_alm_int` varchar(50) DEFAULT NULL,
  `alarmeren_ext` varchar(50) DEFAULT NULL,
  `anders_NL_alm_ext` varchar(50) DEFAULT NULL,
  `ontruimingsignal` varchar(10) DEFAULT NULL,
  `gebeurd_data` varchar(500) DEFAULT NULL,
  `onder_actie_wie` varchar(500) DEFAULT NULL,
  `aktie_afgehan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Incident_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_incident`
--

INSERT INTO `reg_incident` (`Incident_ID`, `datum`, `datum2`, `locatie`, `melder`, `medewerker`, `aard_incident`, `anders_NL_aard`, `alarmeren_int`, `anders_NL_alm_int`, `alarmeren_ext`, `anders_NL_alm_ext`, `ontruimingsignal`, `gebeurd_data`, `onder_actie_wie`, `aktie_afgehan`) VALUES
(0001, '2022-11-13 14:05:32', NULL, 'asdfasdf', 'asdfasdf', 'Neha Hanamsagar', 'Brand', NULL, 'Central Punt / Receptioniste', NULL, '112', NULL, 'Ja', 'asdfasdfasdf', 'asdfasdfasdfd', 'Ja'),
(0002, '2022-11-13 17:30:27', NULL, 'asdfasf', 'sdafsadf', 'Neha Hanamsagar', 'Incident Met Gevaarlijk Stoffen', NULL, 'Central Punt / Receptioniste', NULL, '112', NULL, 'Ja', 'asdfasdf', 'asdfasdff', 'Ja'),
(0004, '2022-11-13 17:51:50', NULL, 'werrtwerrt', 'wertwert', 'Neha Hanamsagar', 'Anders NL', NULL, 'BHV\'s', NULL, '112', NULL, 'Ja', 'werrtwert', 'wertwertewrt', 'Ja');

-- --------------------------------------------------------

--
-- Table structure for table `reg_medew`
--

DROP TABLE IF EXISTS `reg_medew`;
CREATE TABLE IF NOT EXISTS `reg_medew` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `user_type` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `actief` varchar(3) DEFAULT 'nee',
  `functie` text,
  `TelIntern` varchar(15) DEFAULT NULL,
  `TelExtern` varchar(15) DEFAULT NULL,
  `RegControl` varchar(3) DEFAULT 'nee',
  `AlarmControl` varchar(3) DEFAULT 'nee',
  `zichtbaar` varchar(3) DEFAULT 'ja',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_medew`
--

INSERT INTO `reg_medew` (`id`, `username`, `name`, `email`, `user_type`, `password`, `actief`, `functie`, `TelIntern`, `TelExtern`, `RegControl`, `AlarmControl`, `zichtbaar`) VALUES
(64, 'neha', 'Neha Hanamsagar', 'neha@gmail.com', 'admin', '262f5bdd0af9098e7443ab1f8e435290', 'nee', NULL, NULL, NULL, 'ja', 'nee', 'ja'),
(106, 'user', 'User', 'user@user.user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'nee', 'Visitor', '12334567', '123456', 'nee', 'nee', 'ja'),
(105, 'frank', 'Frank M', 'frank@f.c', 'user', '26253c50741faa9c2e2b836773c69fe6', 'nee', 'Plumber', '53535353535353', '34', 'nee', NULL, 'ja'),
(104, 'shilpa', 'Shilpa ', 'shil@shil.com', 'admin', '02a08433d06bdd4161f27179de60584c', 'nee', 'Arrangement Coordinator', '12345678', '1', 'ja', NULL, 'ja'),
(103, 'amit', 'amit dixit', 'amit@g.com', 'user', '0cb1eb413b8f7cee17701a37a1d74dc3', 'nee', 'technical person', '12121212', '121212', 'nee', 'nee', 'ja');

-- --------------------------------------------------------

--
-- Table structure for table `reg_prioriteit`
--

DROP TABLE IF EXISTS `reg_prioriteit`;
CREATE TABLE IF NOT EXISTS `reg_prioriteit` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `prioriteit` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_prioriteit`
--

INSERT INTO `reg_prioriteit` (`id`, `prioriteit`) VALUES
(1, 'URGENT'),
(2, 'High'),
(3, 'Normal'),
(4, 'Low');

-- --------------------------------------------------------

--
-- Table structure for table `reg_storing`
--

DROP TABLE IF EXISTS `reg_storing`;
CREATE TABLE IF NOT EXISTS `reg_storing` (
  `reg_ID` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datum2` varchar(20) NOT NULL DEFAULT 'n.v.t.',
  `gebouw` varchar(100) NOT NULL,
  `ruimte` varchar(30) DEFAULT NULL,
  `app` varchar(100) NOT NULL,
  `omsch_kort` varchar(40) NOT NULL,
  `omschrijving` text,
  `td` varchar(50) DEFAULT 'n.t.b.',
  `td_new` varchar(50) DEFAULT '',
  `bedrijf` varchar(50) DEFAULT NULL,
  `bedrijf_plan` text,
  `bedrijf_opdr` varchar(30) DEFAULT NULL,
  `bedrijf_datum` varchar(10) DEFAULT NULL,
  `prioriteit` varchar(50) DEFAULT NULL,
  `afgehandeld` varchar(3) NOT NULL DEFAULT 'nee',
  `medew` varchar(30) NOT NULL,
  `medew_actie` varchar(30) DEFAULT NULL,
  `medew_controle` varchar(30) DEFAULT NULL,
  `melder` varchar(30) DEFAULT NULL,
  `meld_org` varchar(30) DEFAULT NULL,
  `meld_tel` varchar(15) DEFAULT NULL,
  `controle` varchar(3) NOT NULL DEFAULT 'nee',
  PRIMARY KEY (`reg_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3347 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_storing`
--

INSERT INTO `reg_storing` (`reg_ID`, `datum`, `datum2`, `gebouw`, `ruimte`, `app`, `omsch_kort`, `omschrijving`, `td`, `td_new`, `bedrijf`, `bedrijf_plan`, `bedrijf_opdr`, `bedrijf_datum`, `prioriteit`, `afgehandeld`, `medew`, `medew_actie`, `medew_controle`, `melder`, `meld_org`, `meld_tel`, `controle`) VALUES
(3345, '2022-11-13 14:58:47', 'n.v.t.', 'pav 2 - Speedy Gonzalez 201', '4', 'Mirror is unclean.Do This urgent', 'Mirror is unclean', 'It is super dirty. Please clean it', 'n.t.b.', '', NULL, NULL, NULL, NULL, NULL, 'nee', 'Neha Hanamsagar', 'Neha Hanamsagar', NULL, NULL, 'cleaning', '121212121', 'nee'),
(3344, '2022-11-13 14:57:29', '13-11-2022 14:57', 'pav 1 Lady marian - 102', '2', 'Drawer broken', 'Drawer broken', 'It was already broken. Please fix it.', 'n.t.b.', 'amit dixit', NULL, 'We are looking into it', NULL, NULL, 'URGENT', 'nee', 'Neha Hanamsagar', 'amit dixit', NULL, NULL, 'This', '12121212', 'nee'),
(3322, '2019-11-04 09:31:15', 'n.v.t.', 'Baloe - 208', 'asdfasdfsadf', 'asfawefea', 'asdfadsfdas', 'fasdfasdfasdfafa', 'n.t.b.', NULL, NULL, NULL, NULL, NULL, 'Spoed', 'nee', 'Amit', 'Koos Overweel', NULL, 'sdfasdf', 'asdfasdf', '12121212', 'nee'),
(3323, '2019-11-04 09:35:13', '04-11-2019 9:35', 'pav 10 Knorretje - 205', '123', 'fdgsdfg', 'sdfgsdfg', 'sdfgsdfg', 'n.t.b.', NULL, 'Coffee Fresch Westerhof', NULL, NULL, NULL, 'Spoed', 'nee', 'Amit', 'Koos Overweel', ' ', 'dfgdsgf', 'sfdgsdfg', '12345', 'nee'),
(3324, '2019-11-04 09:38:24', '04-11-2019 9:57', 'pav 10 Poeh - 205', '1234', 'XDFGSDFGS', 'asdfasdf', 'asdfasdfadsf', 'n.t.b.', 'Neha', NULL, NULL, NULL, NULL, 'Spoed', 'nee', 'Neha', 'Anja Tazelaar', ' ', 'asdfasdf', 'asdfasdf', '12344', 'nee'),
(3325, '2019-11-05 09:37:47', 'n.v.t.', 'pav 10 Tijgetje - 205', NULL, 'asdfasdf', 'asdfasdfasdf', NULL, 'n.t.b.', NULL, NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Amit', NULL, NULL, NULL, NULL, NULL, 'nee'),
(3326, '2019-11-05 09:38:09', 'n.v.t.', 'pav 10 Tijgetje - 205', NULL, 'asfsdfasdfadsfbbbbb', 'asdfasdfasdf', NULL, 'n.t.b.', NULL, NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'This', NULL, NULL, NULL, NULL, NULL, 'nee'),
(3327, '2019-11-05 09:39:01', '19-11-2019 11:36', 'pav 10 Tijgetje - 205', NULL, 'asdfasdfsdafnnnn', 'adsfasdfasdf', NULL, 'n.t.b.', NULL, NULL, NULL, NULL, NULL, 'Spoed', 'nee', 'Harry', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3328, '2019-11-07 12:35:17', '07-11-2019 12:35', 'pav 10 Poeh - 205', NULL, 'apppp', 'google ', NULL, 'n.t.b.', 'Shilpa', '', NULL, NULL, NULL, 'Laag', 'nee', 'Sally', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3329, '2019-11-08 10:04:12', '08-11-2019 10:04', 'Baloe - 208', NULL, 'xyz', 'this is a problem', NULL, 'n.t.b.', 'Mr. X', NULL, NULL, NULL, NULL, 'Spoed', 'nee', 'Frank', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3330, '2019-11-08 11:56:06', '08-11-2019 12:16', '16 Sleeping Beauty - 209', NULL, 'table', 'there is some problem', NULL, 'n.t.b.', 'Mr. Y', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Harry', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3331, '2019-11-08 12:29:09', '08-11-2019 12:29', '16 Sleeping Beauty - 209', NULL, 'xyz', 'xyz', NULL, 'n.t.b.', 'Nobody', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Sally', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3332, '2019-11-08 12:40:35', '08-11-2019 13:42', 'Baronie -110', NULL, 'ghfgh', 'dghfg', NULL, 'n.t.b.', 'Anybody', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Nobody', 'J R', ' ', NULL, NULL, NULL, 'nee'),
(3333, '2019-11-08 12:42:05', '08-11-2019 13:10', 'Baloe - 208', NULL, 'gggggg', 'ggggggg', NULL, 'n.t.b.', 'This', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Fred', 'Johan van der Sluis', ' ', NULL, NULL, NULL, 'nee'),
(3334, '2019-11-11 15:18:41', '11-11-2019 15:18', 'pav 10 Tijgetje - 205', NULL, 'rrrrr', 'rrrrrrr', NULL, 'n.t.b.', 'Not this', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Amit', 'Koos Overweel', ' ', NULL, NULL, NULL, 'nee'),
(3335, '2019-11-11 15:20:26', '11-11-2019 15:20', '16 Sleeping Beauty - 209', NULL, '4556788', '12345678', NULL, 'n.t.b.', 'Amit', NULL, NULL, NULL, NULL, 'Spoed', 'nee', 'Neha', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3336, '2019-11-11 15:21:35', '11-11-2019 15:21', 'pav 2 - Speedy Gonzalez 201', NULL, '23445676', '12345', NULL, 'n.t.b.', 'Neha Hanamsagar', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Neha Hanamsagar', NULL, ' ', NULL, NULL, NULL, 'nee'),
(3337, '2019-11-12 08:52:50', '13-11-2022 15:48', 'Baloe - 208', '45', 'ffff', 'ffffff', 'gdghghddghdhdhfdhdh', 'n.t.b.', ' ', NULL, 'dghdghdhdfdghh', 'Shilpa ', 'dfghfgh', 'URGENT', 'nee', 'Neha', NULL, NULL, NULL, '3453455454', '4534534', 'nee'),
(3338, '2019-11-12 08:56:32', '14-11-2019 13:16', 'Hoofdgebouw VIR - 206', NULL, 'gdsfgsdfgds', 'sdfgsdfgdsg', NULL, 'n.t.b.', 'Amit', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'SRK', 'Ilse van Woerkom', ' ', NULL, NULL, NULL, 'nee'),
(3339, '2019-11-12 08:56:54', '12-11-2019 8:58', '16 Sleeping Beauty - 209', NULL, 'dfgsfdgfdg', 'sdfgsdfgdsg', NULL, 'n.t.b.', 'This name', NULL, NULL, NULL, NULL, 'URGENT', 'ja', 'SRK', 'Johan van der Sluis', ' ', NULL, NULL, NULL, 'ja'),
(3340, '2019-11-15 08:09:24', '15-11-2019 8:12', 'pav 2 - Speedy Gonzalez 201', NULL, 'apparatus', 'kapot', NULL, 'n.t.b.', 'Amit', '', NULL, 'Amit', NULL, 'URGENT', 'ja', 'SRK', 'Jurgen Rooijackers', ' ', NULL, NULL, NULL, 'ja'),
(3346, '2022-11-13 17:29:36', '13-11-2022 18:35', 'pav 1 Lady marian - 102', '23', 'sdgdfgdsffg', 'sdfgsfdgsfgdfg', 'asdfasdfasdfafasdf', 'n.t.b.', 'Frank M', 'Coffee Cafe', 'asdfadsfasdfasdfsafafaf', 'Neha Hanamsagar', NULL, 'URGENT', 'nee', 'Neha Hanamsagar', NULL, 'Shilpa ', 'dfadsfasdfas', 'asdfasdf', '12323432', 'ja'),
(3341, '2019-11-15 09:38:52', '15-11-2019 13:39', '16 Sleeping Beauty - 209', '123', 'gggg', 'sdfgsdfgsfdg', NULL, 'n.t.b.', 'Amit', NULL, NULL, NULL, NULL, 'URGENT', 'nee', 'Neha Hanamsagar', NULL, ' ', NULL, NULL, '12345', 'nee'),
(3342, '2019-11-19 10:16:20', '13-11-2022 15:49', 'Hoofdgebouw BG - 120', '12', 'asdfsdafdsaf', 'asdfadfasfas', 'adfasdfasdfsaf', 'n.t.b.', ' ', NULL, NULL, 'Neha Hanamsagar', NULL, 'URGENT', 'nee', 'Neha Hanamsagar', NULL, NULL, NULL, NULL, NULL, 'nee'),
(3343, '2022-10-04 23:01:32', '13-11-2022 14:04', 'Bioscoop - 135', '12', 'sdfgdsg', 'sdfgsdfg', 'sdfgsdfgsdfgdfsg', 'n.t.b.', ' ', NULL, 'sdfgsdfgsdfgsdfgdf\r\nsdfgsdfg\r\nsdfgsgdsfg\r\nsdfgg\r\n\r\n\r\n\r\n\r\n', NULL, NULL, 'URGENT', 'nee', 'Neha Hanamsagar', NULL, NULL, NULL, 'sdfgsdfg', '12121212', 'nee');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
