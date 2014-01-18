-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Jan 2014 um 20:41
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `bti7054`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `billing_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `card_type` int(11) DEFAULT NULL,
  `card_number` int(11) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`billing_id`),
  KEY `fk_billing_user_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `billing`
--

INSERT INTO `billing` (`billing_id`, `user_id`, `card_id`, `card_type`, `card_number`, `expire_date`) VALUES
(3, 3, 1234, 1234, 1234, '1970-01-01'),
(4, 3, 2, 123, 123, '1970-01-01'),
(5, 3, 2, 123, 123, '1970-01-01'),
(6, 3, 2, 123, 123, '1970-01-01'),
(7, NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, NULL, NULL),
(9, 3, NULL, NULL, NULL, NULL),
(10, 3, NULL, NULL, NULL, NULL),
(11, 3, NULL, NULL, NULL, NULL),
(12, 3, NULL, NULL, NULL, NULL),
(13, 3, NULL, NULL, NULL, NULL),
(14, 3, NULL, NULL, NULL, NULL),
(15, 3, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cake`
--

CREATE TABLE IF NOT EXISTS `cake` (
  `cake_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cake_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `cake`
--

INSERT INTO `cake` (`cake_id`, `name`, `description`) VALUES
(1, 'Vanille', 'Vanille Geschmack'),
(2, 'Schokolade', 'Schoko Geschmack'),
(3, 'Zitrone', 'Zitronen Geschmack');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Saisonal'),
(2, 'Hochzeit'),
(3, 'Geburtstag'),
(4, 'Heimkreationen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `custom_item`
--

CREATE TABLE IF NOT EXISTS `custom_item` (
  `custom_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `cake_id` int(11) DEFAULT NULL,
  `topping_id` int(11) DEFAULT NULL,
  `deco_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`custom_item_id`),
  KEY `fk_custom_item_order_idx` (`order_id`),
  KEY `fk_custom_item_cake_idx` (`cake_id`),
  KEY `fk_custom_item_topping_idx` (`topping_id`),
  KEY `fk_custom_item_deco_idx` (`deco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `custom_item`
--

INSERT INTO `custom_item` (`custom_item_id`, `name`, `order_id`, `cake_id`, `topping_id`, `deco_id`) VALUES
(1, 'Dominiks', 9, 1, 1, 1),
(2, 'Dominiks', 10, 1, 1, 1),
(3, 'asd', 11, 3, 1, 1),
(4, 'asd', 12, 3, 1, 1),
(5, 'asd', 13, 3, 1, 1),
(6, 'gagi', 15, 2, 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `decoration`
--

CREATE TABLE IF NOT EXISTS `decoration` (
  `deco_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`deco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `decoration`
--

INSERT INTO `decoration` (`deco_id`, `name`, `description`) VALUES
(1, 'Sterne', 'Sterne Beschreibung'),
(2, 'Perlen', 'Perlen Beschreibung'),
(3, 'Herze', 'Herze Beschreibung');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `available` tinyint(1) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_item_category_idx` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `item`
--

INSERT INTO `item` (`item_id`, `name`, `price`, `image`, `available`, `category_id`) VALUES
(1, 'saison 1', 2, 'img/saison1.bmp', 1, 1),
(2, 'saison 2', 3, 'img/saison2.bmp', 1, 1),
(3, 'saison 3', 2.5, 'img/saison3.bmp', 1, 1),
(4, 'hochzeit 1', 2.5, 'img/hochzeit1.bmp', 1, 2),
(5, 'hochzeit set 1', 15, 'img/hochzeit2.bmp', 1, 2),
(6, 'geburtstag 1', 2, 'img/geburi1.bmp', 1, 3),
(7, 'geburtstag 2', 3.5, 'img/geburi2.bmp', 0, 3),
(8, 'geburtstag 3', 2.1, 'img/geburi3.bmp', 1, 3),
(9, 'heimkreation set1', 13.5, 'img/creation1.bmp', 1, 4),
(10, 'heimkreation 2', 2, 'img/creation2.bmp', 1, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `item_description`
--

CREATE TABLE IF NOT EXISTS `item_description` (
  `item_desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(45) NOT NULL,
  `text` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`item_desc_id`),
  KEY `fk_item_description_item_idx` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `item_description`
--

INSERT INTO `item_description` (`item_desc_id`, `language`, `text`, `item_id`) VALUES
(1, 'DE', 'saison 1 beschreibung', 1),
(2, 'DE', 'saison 2 beschreibung', 2),
(3, 'DE', 'saison 3 beschreibung', 3),
(4, 'DE', 'hochzeit 1 beschreibung', 4),
(5, 'DE', 'hochzeit 2 beschreibung', 5),
(6, 'DE', 'geburtstag 1 beschreibung', 6),
(7, 'DE', 'geburtstag 2 beschreibung', 7),
(8, 'DE', 'geburtstag 3 beschreibung', 8),
(9, 'DE', 'heimkreation 1 beschreibung', 9),
(10, 'DE', 'heimkreation 2 beschreibung', 10),
(11, 'EN', 'saison 1 description', 1),
(12, 'EN', 'saison 2 description', 2),
(13, 'EN', 'saison 3 description', 3),
(14, 'EN', 'wedding 1 description', 4),
(15, 'EN', 'wedding2 description', 5),
(16, 'EN', 'birthday 1 description', 6),
(17, 'EN', 'birthday 2 description', 7),
(18, 'EN', 'birthday 3 description', 8),
(19, 'EN', 'homecreation 1 description', 9),
(20, 'EN', 'homecreation 2 description', 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `total` float NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `shipping_id` int(11) DEFAULT NULL,
  `billing_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_order_user_idx` (`user_id`),
  KEY `fk_order_billing_idx` (`billing_id`),
  KEY `fk_order_shipping_idx` (`shipping_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`order_id`, `total`, `order_date`, `user_id`, `shipping_id`, `billing_id`) VALUES
(4, 104, '2013-12-22 22:55:40', 3, 8, 3),
(5, 19, '2013-12-23 19:47:36', 3, 9, 4),
(6, 19, '2013-12-23 19:49:34', 3, 10, 5),
(7, 19, '2013-12-23 20:11:45', 3, 11, 6),
(8, 218.5, '2013-12-27 18:58:36', NULL, 13, 8),
(9, 218.5, '2013-12-27 18:59:42', 3, 14, 9),
(10, 218.5, '2013-12-27 19:29:19', 3, 15, 10),
(11, 38, '2014-01-03 21:36:33', 3, 16, 11),
(12, 38, '2014-01-03 21:37:15', 3, 17, 12),
(13, 38, '2014-01-03 21:41:06', 3, 18, 13),
(14, 2, '2014-01-03 21:42:08', 3, 19, 14),
(15, 1667.5, '2014-01-15 22:04:45', 3, 20, 15);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `order_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`order_items_id`),
  KEY `fk_order_items_item_idx` (`item_id`),
  KEY `fk_order_items_order_idx` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Daten für Tabelle `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_id`, `item_id`, `amount`) VALUES
(1, 4, 1, 7),
(2, 4, 5, 6),
(3, 5, 4, 4),
(4, 5, 2, 3),
(5, 6, 4, 4),
(6, 6, 2, 3),
(7, 7, 4, 4),
(8, 7, 2, 3),
(9, 9, 7, 12),
(10, 9, 5, 5),
(11, 9, 3, 33),
(12, 9, 10, 5),
(13, 10, 7, 12),
(14, 10, 5, 5),
(15, 10, 3, 33),
(16, 10, 10, 5),
(17, 11, 1, 3),
(18, 11, 7, 4),
(19, 12, 1, 3),
(20, 12, 7, 4),
(21, 13, 1, 3),
(22, 13, 7, 4),
(23, 14, 1, 1),
(24, 15, 5, 100),
(25, 15, 2, 5),
(26, 15, 4, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shipping_address`
--

CREATE TABLE IF NOT EXISTS `shipping_address` (
  `shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`shipping_id`),
  KEY `fk_shipping_address_user_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `shipping_address`
--

INSERT INTO `shipping_address` (`shipping_id`, `name`, `street`, `zip`, `city`, `country`, `user_id`) VALUES
(8, 'Domi', 'Domi', 1234, 'Domi', 'Domi', 3),
(9, 'Domi Reubi', 'Jurastrasse 9', 1234, 'Bern', 'Schweiz', 3),
(10, 'Domi Reubi', 'Jurastrasse 9', 1234, 'Bern', 'Schweiz', 3),
(11, 'Domi Reubi', 'Jurastrasse 9', 1234, 'Bern', 'Schweiz', 3),
(12, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL, 3),
(15, NULL, NULL, NULL, NULL, NULL, 3),
(16, NULL, NULL, NULL, NULL, NULL, 3),
(17, NULL, NULL, NULL, NULL, NULL, 3),
(18, NULL, NULL, NULL, NULL, NULL, 3),
(19, NULL, NULL, NULL, NULL, NULL, 3),
(20, NULL, NULL, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topping`
--

CREATE TABLE IF NOT EXISTS `topping` (
  `topping_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`topping_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `topping`
--

INSERT INTO `topping` (`topping_id`, `name`, `description`) VALUES
(1, 'Erdbeer-Mascarpone', 'Erdbeer-Mascarpone Topping Beschreibung'),
(2, 'Erdnuss-Buttercreme', 'Erdnuss-Buttercreme Topping Beschreibung'),
(3, 'Caramel-Mascarpone', 'Caramel-Mascarpone Topping Beschreibung'),
(4, 'Zitronencreme', 'Zitronencreme Topping Beschreibung');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`) VALUES
(3, 'reubd1', '8431b3cbfd60fc498c147319874a7411', 'reubd1@abab.ab');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `fk_billing_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
