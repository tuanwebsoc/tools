-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2015 at 04:50 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `itebooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `it_ebooks_categories`
--

CREATE TABLE IF NOT EXISTS `it_ebooks_categories` (
`category_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `search_text` varchar(45) NOT NULL,
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `it_ebooks_category_item`
--

CREATE TABLE IF NOT EXISTS `it_ebooks_category_item` (
`category_item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `it_ebooks_items`
--

CREATE TABLE IF NOT EXISTS `it_ebooks_items` (
`item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `introtext` varchar(45) NOT NULL,
  `link` varchar(45) DEFAULT NULL,
  `text` tinytext,
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `it_ebooks_categories`
--
ALTER TABLE `it_ebooks_categories`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `it_ebooks_category_item`
--
ALTER TABLE `it_ebooks_category_item`
 ADD PRIMARY KEY (`category_item_id`);

--
-- Indexes for table `it_ebooks_items`
--
ALTER TABLE `it_ebooks_items`
 ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `it_ebooks_categories`
--
ALTER TABLE `it_ebooks_categories`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `it_ebooks_category_item`
--
ALTER TABLE `it_ebooks_category_item`
MODIFY `category_item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `it_ebooks_items`
--
ALTER TABLE `it_ebooks_items`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
