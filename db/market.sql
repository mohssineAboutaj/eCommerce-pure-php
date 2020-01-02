-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2020 at 07:33 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id6481295_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `ordering` mediumint(9) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 0,
  `allowComments` tinyint(1) NOT NULL DEFAULT 0,
  `allowAds` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `ordering`, `visibility`, `allowComments`, `allowAds`) VALUES
(1, 'phones', 'mobile category', 1, 1, 1, 1),
(2, 'computers', 'computers category', 2, 0, 0, 1),
(3, 'toys', 'toys category', 3, 1, 1, 0),
(4, 'cars', 'cars category', 2, 1, 0, 1),
(5, 'books', 'books category', 3, 0, 0, 1),
(6, 'electronic', 'electronic category', 0, 0, 0, 0),
(7, 'vehicle', 'vehicle category for think has a wheels or used to transport ex: pike, car, bus ...', 4, 0, 0, 0),
(8, 'clothers', 'clothers categories', 0, 0, 1, 1),
(9, 'Food', 'food category', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `cmntDate` datetime NOT NULL,
  `itemId` int(11) NOT NULL,
  `memId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `status`, `cmntDate`, `itemId`, `memId`) VALUES
(1, 'good', 1, '2017-12-20 20:14:45', 4, 1),
(2, 'yes', 1, '2017-12-20 20:15:36', 4, 1),
(22, 'new member', 0, '2017-12-23 15:02:14', 4, 4),
(23, 'new member', 0, '2017-12-23 15:02:51', 4, 4),
(39, 'hello hhh', 1, '2017-12-23 15:42:37', 4, 50),
(48, '1sss', 1, '2017-12-31 15:09:02', 1, 50),
(49, '1sss', 1, '2017-12-31 15:10:27', 1, 50),
(50, 'sss', 1, '2017-12-31 15:10:53', 1, 50),
(51, 'ssss', 1, '2017-12-31 15:14:04', 1, 50),
(52, 'salam\r\n', 1, '2017-12-31 15:14:21', 1, 50),
(53, 'salam\r\n', 1, '2017-12-31 15:14:36', 1, 50),
(54, 'salam\r\n', 1, '2017-12-31 15:15:14', 1, 50),
(55, 'slam', 1, '2017-12-31 15:15:38', 2, 50),
(56, 'slam', 1, '2017-12-31 15:15:47', 2, 50),
(57, 'slam', 1, '2017-12-31 15:17:40', 2, 50),
(58, 'slam', 1, '2017-12-31 15:18:51', 2, 50),
(59, 'slam', 1, '2017-12-31 15:21:35', 2, 50),
(60, 'slam', 1, '2017-12-31 15:22:14', 2, 50),
(63, 'hhhh', 1, '2017-12-31 17:38:46', 2, 50),
(64, 'hhhh', 1, '2017-12-31 17:38:58', 2, 50),
(65, 'sss', 1, '2017-12-31 17:41:18', 2, 50),
(66, 'sss', 1, '2017-12-31 17:42:29', 2, 50),
(67, 'qqqqq', 1, '2017-12-31 17:42:50', 2, 50),
(68, 'qqqqq', 1, '2017-12-31 17:54:39', 2, 50),
(69, 'ss', 1, '2017-12-31 18:29:52', 22, 50),
(70, 'ss', 1, '2017-12-31 18:30:27', 22, 50),
(71, 'ss', 1, '2017-12-31 18:32:01', 22, 50),
(72, 'mm', 1, '2017-12-31 18:32:24', 22, 50),
(73, 'www', 1, '2017-12-31 18:35:57', 22, 50),
(142, 'wach 4ali', 1, '2018-05-03 23:17:39', 4, 1),
(143, 'makayn li ychri had l3jb', 1, '2018-05-03 23:17:53', 4, 1),
(144, 'how are you\r\n', 1, '2018-05-09 13:30:45', 2, 1),
(145, 'fine', 1, '2018-05-09 13:30:54', 2, 1),
(146, 'what???', 1, '2018-05-09 13:31:10', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(22) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `price` varchar(255) NOT NULL,
  `addDate` datetime NOT NULL,
  `countryMade` varchar(255) NOT NULL,
  `image` varchar(355) NOT NULL,
  `status` varchar(255) NOT NULL,
  `views` tinyint(10) NOT NULL DEFAULT 0,
  `appr` tinyint(1) NOT NULL DEFAULT 0,
  `catId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `addDate`, `countryMade`, `image`, `status`, `views`, `appr`, `catId`, `memberId`, `tags`) VALUES
(1, 'lumia', 'nokia lumia 510', '100', '2017-12-18 23:50:04', 'usa', '', '1', 3, 1, 1, 1, 'smart,cam,connexion'),
(2, 'samsung', 'samsung galaxy very long description is very very very very long description  description description ', '20', '2017-12-18 23:50:48', 'usa', '', '3', 17, 1, 1, 1, 'smart,cam,connexion,ram,wifi,blutot,bluetot,3g,android'),
(4, 'pheonix server x 20', 'pheonix server x 20', '10000000', '2017-12-18 23:52:51', 'morocco', '', '2', 3, 1, 2, 1, 'pc,connexion'),
(16, 'htc one x', 'htc one x pro', '20', '2017-12-25 00:54:40', 'morocco', '', '1', 37, 1, 1, 50, 'smart,cam'),
(22, 'motor', 'motor\r\nmazot\r\nnitro', '100', '2017-12-31 18:03:14', 'morocco', 'Xshop_2017-12-31_07-12-34_-437386929_IMG-20170124-WA0344.jpg', '2', 1, 1, 7, 50, 'nitro, pikala'),
(32, 'cake', 'yami cake for happy birthday and all party&#39;s', '10$', '2018-04-30 21:48:41', 'morocco', 'Xshop_2018-04-30_10-04-41_-158936785_cake-3163117_1920.jpg', '1', 8, 1, 9, 60, 'food, cake,birthday,happy'),
(33, 'TV MAF', 'TV MAF\r\n- HDMI\r\n- 4 USB\r\n- solar energy', '29$', '2018-07-12 11:51:12', 'morocco', 'Xshop_2018-07-12_12-07-12_-425844034_electron.jpg', '1', 0, 0, 6, 74, 'tv,hdmi,usb,solar energy');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `value` varchar(50) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings`, `value`) VALUES
('sorting', '1'),
('defaultLimit', '10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `regStatus` int(1) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `groupId` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `regStatus`, `date`, `image`, `groupId`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'mohssine aboutaj', 'mohssineaboutajtemplates@gmail.ma', 1, '2017-11-18', 'Xshop_2018-05-04_12-05-37_-714150034_Maroc.JPG', 1),
(50, 'xmohssine', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'mohssine aboutaj', 'mohssineaboutajtemplates@gmail.ma', 1, '2017-12-20', 'Xshop_2017-12-27_04-12-47_-515856417_1d3c8d5ae6265b02ee2982a7dd82fae9.jpg', 0),
(55, 'saad', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'saad aboutaj', 'saadmaroc@gmail.ma', 1, '2017-12-26', 'Xshop_2017-12-31_05-12-31_-269437806_login.jpg', 0),
(60, 'new-member', 'de271790913ea81742b7d31a70d85f50a3d3e5ae', '.loginPage form input:not([type=&#39;submit&#39;]) {', 'mohssinemoney@gmail.com', 1, '2018-04-26', '', 0),
(63, 'said', '94d53fbe11fa48a71877301d104e2b0409ba9822', 'said najar', 'said@s.c', 1, '2018-05-07', '', 0),
(64, 'Bret', '1-770-736-8031 x56442', 'Leanne Graham', 'Sincere@april.biz', 1, '2018-05-09', '', 0),
(65, 'Antonette', '010-692-6593 x09125', 'Ervin Howell', 'Shanna@melissa.tv', 1, '2018-05-09', '', 0),
(66, 'Samantha', '1-463-123-4447', 'Clementine Bauch', 'Nathan@yesenia.net', 1, '2018-05-09', '', 0),
(67, 'Karianne', '493-170-9623 x156', 'Patricia Lebsack', 'Julianne.OConner@kory.org', 1, '2018-05-09', '', 0),
(68, 'Kamren', '(254)954-1289', 'Chelsey Dietrich', 'Lucio_Hettinger@annie.ca', 1, '2018-05-09', '', 0),
(69, 'Leopoldo_Corkery', '1-477-935-8478 x6430', 'Mrs. Dennis Schulist', 'Karley_Dach@jasper.info', 1, '2018-05-09', '', 0),
(70, 'Elwyn.Skiles', '210.067.6132', 'Kurtis Weissnat', 'Telly.Hoeger@billy.biz', 1, '2018-05-09', '', 0),
(71, 'Maxime_Nienow', '586.493.6943 x140', 'Nicholas Runolfsdottir V', 'Sherwood@rosamond.me', 1, '2018-05-09', '', 0),
(72, 'Delphine', '(775)976-6794 x41206', 'Glenna Reichert', 'Chaim_McDermott@dana.io', 1, '2018-05-09', '', 0),
(73, 'Moriah-Stanton', '94d05d39504197850966c09725fc6a6012fef430', 'Clementina DuBuque', 'Rey.Padberg@karina.biz', 1, '2018-05-09', '', 0),
(74, 'ajax-user', '94d53fbe11fa48a71877301d104e2b0409ba9822', 'mohssine', 'mohssineaboutaj1995@gmail.com', 1, '2018-07-12', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_comments` (`itemId`),
  ADD KEY `user_comments` (`memId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_items` (`catId`),
  ADD KEY `user_items` (`memberId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_comments` FOREIGN KEY (`itemId`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_items` FOREIGN KEY (`catId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_items` FOREIGN KEY (`memberId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
