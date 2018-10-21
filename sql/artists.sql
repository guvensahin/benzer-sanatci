-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 21 Kasım 2011 saat 23:08:01
-- Sunucu sürümü: 5.5.8
-- PHP Sürümü: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `game`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `artist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(250) NOT NULL,
  `artist_datetime` datetime NOT NULL,
  PRIMARY KEY (`artist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Tablo döküm verisi `artists`
--

