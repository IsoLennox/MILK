-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 19, 2015 at 03:32 PM
-- Server version: 5.5.42-37.1
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ilennox_milk`
--

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE IF NOT EXISTS `claims` (
  `id` int(11) NOT NULL,
  `status_id` int(7) NOT NULL,
  `datetime` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(999) COLLATE utf8_unicode_ci NOT NULL,
  `claim_type` int(7) NOT NULL,
  `user_id` int(7) NOT NULL,
  `updated` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`id`, `status_id`, `datetime`, `title`, `notes`, `claim_type`, `user_id`, `updated`) VALUES
(3, 4, '13/05/2015 13:22', 'Robbery', '(uploaded police report)<hr/>fs <br><hr/><br><strong>Claim Adjuster Notes: </strong> Needs more information. Please write out a detailed description.<hr/><hr/><br/>', 4, 2, '16/05/2015'),
(8, 1, '15/05/2015 20:46', 'They Broke it!', 'Vandals came in and broke my romulan necklace. Specists.', 2, 2, ''),
(9, 0, '16/05/2015 17:34', 'Tornado', 'Lost the pieces to my monopoly set.', 1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `claims_img`
--

CREATE TABLE IF NOT EXISTS `claims_img` (
  `id` int(11) NOT NULL,
  `claim_id` int(7) NOT NULL,
  `filepath` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `claim_items`
--

CREATE TABLE IF NOT EXISTS `claim_items` (
  `id` int(11) NOT NULL,
  `item_id` int(7) NOT NULL,
  `claim_id` int(7) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `claim_items`
--

INSERT INTO `claim_items` (`id`, `item_id`, `claim_id`) VALUES
(1, 7, 3),
(2, 2, 3),
(6, 13, 9);

-- --------------------------------------------------------

--
-- Table structure for table `claim_types`
--

CREATE TABLE IF NOT EXISTS `claim_types` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `claim_types`
--

INSERT INTO `claim_types` (`id`, `name`) VALUES
(1, 'Natural Disaster'),
(2, 'Vandalism'),
(3, 'Fire/Arson'),
(4, 'Theft'),
(5, 'Flood'),
(6, 'Other (Add to notes)');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE IF NOT EXISTS `company_details` (
  `id` int(11) NOT NULL,
  `logo` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `logo`, `name`, `address`, `city`, `state`, `zip`, `phone`, `content`) VALUES
(4, 'img/green_round.png', 'Under My Roof', '1234 Main St.', 'Vancouver', 'Washington', '98664', '(360) 992-9999', 'Comprehensive protection for the things you treasure');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL,
  `user_id` int(7) NOT NULL,
  `content` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `content`, `datetime`) VALUES
(12, 2, 'Added item: <a href="item_details.php?id=12">Romulan Necklacce</a>', '14/05/2015 18:22'),
(2, 2, 'Added item: <a href="item_details.php?id=10">testing history</a>', '12052015'),
(3, 2, 'Removed item: <a href="item_details.php?id=10">testing history</a>', ''),
(11, 2, 'Removed item: <a href="item_details.php?id=11">sfdsf</a>', '14/05/2015 18:17'),
(10, 2, 'Added item: <a href="item_details.php?id=11">sfdsf</a>', '14/05/2015 17:41'),
(9, 2, 'Removed item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '14/05/2015 17:28'),
(8, 2, 'Filed Claim: <a href="claim_details.php?id=3">Robbery</a>', '13/05/2015 13:22'),
(13, 1, 'Updated <a href="item_details.php?id=3">Claim #</a>', '16/05/2015 14:37'),
(14, 1, 'Updated <a href="item_details.php?id=3">Claim #</a>', '16/05/2015 14:38'),
(15, 2, 'Filed Claim: <a href="claim_details.php?id=3">Robbery</a>', '16/05/2015 15:15'),
(16, 1, 'Updated <a href="item_details.php?id=3">Claim #</a>', '16/05/2015 15:21'),
(17, 2, 'Added item: <a href="item_details.php?id=13">Vintage Monopoly Set</a>', '16/05/2015 16:10'),
(18, 2, 'Filed Claim: <a href="claim_details.php?id=9">Tornado</a>', '16/05/2015 17:35'),
(19, 2, 'Restored item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 18:52'),
(20, 2, 'Edited item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 19:28'),
(21, 2, 'Edited item: <a href="item_details.php?id=6">SheepSkin Banjo</a>', '18/05/2015 19:29'),
(22, 2, 'Edited item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 19:37'),
(23, 2, 'Edited item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 19:37'),
(24, 2, 'Added item: <a href="item_details.php?id=14">Old Book</a>', '05/18/2015 20:12'),
(25, 2, 'Added item: <a href="item_details.php?id=15">PHP</a>', '05/18/2015 20:14');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `user_id` int(7) DEFAULT NULL,
  `category` int(7) DEFAULT NULL,
  `room_id` int(7) DEFAULT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_date` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_price` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `declared_value` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(999) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_date` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `in_trash` int(2) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `category`, `room_id`, `name`, `purchase_date`, `purchase_price`, `declared_value`, `notes`, `upload_date`, `updated`, `in_trash`) VALUES
(7, 2, 1, 5, 'Diamond Watch', '12/23/1989', '15,000', '16,000', 'In the safe', '0', '', 0),
(2, 2, 2, 2, 'Sampsung Television', '12/23/1989', '2000.00', '1800.00', 'Family heirloom!', '0', '', 0),
(6, 2, 4, 1, 'Sheep Skin Banjo', '10/01/1929', '5.00', '21,000', 'Appraised 10/07/1997', '18/03/2015 19:37', '18/05/2015 19:37', 0),
(8, 2, 1, 1, 'test', '12052015', '2000', '2100', 'tet', '12052015', '', 1),
(9, 2, 1, 1, 'Test again', '12052015', '2000', '2100', 'lorem', '12052015', '', 1),
(10, 2, 1, 1, 'testing history', '12052015', '2000', '2100', 'stuff', '12052015', '', 1),
(11, 2, 1, 1, 'sfdsf', '14/05/2015 17:41', '76', '6786', 'dfdasgfg', '14/05/2015 17:41', '14/05/2015 17:41', 1),
(12, 2, 1, 5, 'Romulan Necklacce', '14/05/2015 18:22', '50', '200', 'My prized posession', '14/05/2015 18:22', '14/05/2015 18:22', 0),
(13, 2, 7, 1, 'Vintage Monopoly Set', '16/05/2015 16:10', '15', '200', 'Keeping this safe', '16/05/2015 16:10', '16/05/2015 16:10', 0),
(14, 2, 10, 5, 'Old Book', '05/18/2015 20:12', '0.05', '950.50', 'Priceless antique', '05/18/2015 20:12', '05/18/2015 20:12', 0),
(15, 2, 5, 1, 'PHP', '05/18/2015 20:14', '5.00', '2100', 'Lorem', '05/18/2015 20:14', '05/18/2015 20:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE IF NOT EXISTS `item_category` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `name`) VALUES
(1, 'Jewelry'),
(2, 'Electronics'),
(3, 'Furniture'),
(4, 'Musical Instruments'),
(5, 'Artwork'),
(6, 'Sporting Goods'),
(7, 'Memorabilia'),
(8, 'Large Appliances'),
(9, 'Small Appliances'),
(10, 'Other (specify in notes)');

-- --------------------------------------------------------

--
-- Table structure for table `item_img`
--

CREATE TABLE IF NOT EXISTS `item_img` (
  `id` int(11) NOT NULL,
  `item_id` int(7) NOT NULL,
  `file_path` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `datetime` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `thread_id` int(7) NOT NULL,
  `sent_from` int(7) NOT NULL,
  `sent_to` int(7) NOT NULL,
  `viewed` int(1) NOT NULL,
  `content` varchar(999) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `datetime`, `thread_id`, `sent_from`, `sent_to`, `viewed`, `content`) VALUES
(1, '17/05/2015 15:18', 1, 1, 6, 1, 'YAY MESSAGES!'),
(2, '17/05/2015 16:03', 1, 1, 6, 1, 'another message thread test'),
(3, '17/05/2015 16:03', 1, 6, 1, 1, 'then why!?'),
(4, '17/05/2015 16:08', 1, 6, 1, 1, 'I hacked LaRheas Account!'),
(5, '17/05/2015 16:13', 1, 6, 1, 1, 'yes''s'),
(6, '17/05/2015 16:44', 1, 1, 6, 1, 'FIX THESE SCROLL BRS!!!   \r\n\r\nhttp://webdesign.tutsplus.com/articles/quick-tip-styling-scrollbars-to-match-your-ui-design--webdesign-9430'),
(7, '17/05/2015 16:54', 1, 6, 1, 1, 'New message thread test'),
(8, '17/05/2015 16:56', 1, 6, 1, 1, 'I don''t want claim 9 take it!'),
(9, '17/05/2015 17:01', 2, 6, 9, 0, 't'),
(10, '17/05/2015 17:02', 3, 6, 7, 0, 'string''s test''s #9'),
(11, '17/05/2015 17:05', 2, 6, 9, 0, 'gfdg3&amp;quot;''$'),
(12, '17/05/2015 17:07', 2, 6, 9, 0, 'tgrtge54'),
(13, '17/05/2015 17:08', 2, 6, 9, 0, 'dfgdsfgerg4'),
(14, '17/05/2015 17:08', 2, 6, 9, 0, 'gdfgdfgd'),
(15, '17/05/2015 17:09', 2, 6, 9, 0, 'dfgdsfg'),
(16, '17/05/2015 17:10', 2, 6, 9, 0, 'fgdsdfg'),
(17, '17/05/2015 17:10', 2, 6, 9, 0, 'dfgdfg'),
(18, '17/05/2015 17:11', 2, 6, 9, 0, 'fg3g34'),
(19, '17/05/2015 17:18', 2, 6, 9, 0, 'hello! &amp;amp; i''s');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Can edit company details'),
(2, 'Can edit employees'),
(3, 'Can edit roles'),
(4, 'Can update claims');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Super User'),
(2, 'Claims Adjuster');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(7) NOT NULL,
  `permission_id` int(7) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(6, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(7) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `notes`, `user_id`) VALUES
(1, 'Zora''s Bedroom', 'Upstairs in main house', 2),
(2, 'Upstairs Bathroom', 'Upstairs Bathroom', 2),
(5, 'Master Bedroom', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL,
  `name` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `name`, `code`) VALUES
(1, 'Alabama', 'AL'),
(2, 'Alaska', 'AK'),
(3, 'American Sa', 'AS'),
(4, 'Arizona', 'AZ'),
(5, 'Arkansas', 'AR'),
(6, 'California', 'CA'),
(7, 'Colorado', 'CO'),
(8, 'Connecticut', 'CT'),
(9, 'Delaware', 'DE'),
(10, 'District of', 'DC'),
(11, 'Federated S', 'FM'),
(12, 'Florida', 'FL'),
(13, 'Georgia', 'GA'),
(14, 'Guam', 'GU'),
(15, 'Hawaii', 'HI'),
(16, 'Idaho', 'ID'),
(17, 'Illinois', 'IL'),
(18, 'Indiana', 'IN'),
(19, 'Iowa', 'IA'),
(20, 'Kansas', 'KS'),
(21, 'Kentucky', 'KY'),
(22, 'Louisiana', 'LA'),
(23, 'Maine', 'ME'),
(24, 'Marshall Is', 'MH'),
(25, 'Maryland', 'MD'),
(26, 'Massachuset', 'MA'),
(27, 'Michigan', 'MI'),
(28, 'Minnesota', 'MN'),
(29, 'Mississippi', 'MS'),
(30, 'Missouri', 'MO'),
(31, 'Montana', 'MT'),
(32, 'Nebraska', 'NE'),
(33, 'Nevada', 'NV'),
(34, 'New Hampshi', 'NH'),
(35, 'New Jersey', 'NJ'),
(36, 'New Mexico', 'NM'),
(37, 'New York', 'NY'),
(38, 'North Carol', 'NC'),
(39, 'North Dakot', 'ND'),
(40, 'Northern Ma', 'MP'),
(41, 'Ohio', 'OH'),
(42, 'Oklahoma', 'OK'),
(43, 'Oregon', 'OR'),
(44, 'Palau', 'PW'),
(45, 'Pennsylvani', 'PA'),
(46, 'Puerto Rico', 'PR'),
(47, 'Rhode Islan', 'RI'),
(48, 'South Carol', 'SC'),
(49, 'South Dakot', 'SD'),
(50, 'Tennessee', 'TN'),
(51, 'Texas', 'TX'),
(52, 'Utah', 'UT'),
(53, 'Vermont', 'VT'),
(54, 'Virgin Isla', 'VI'),
(55, 'Virginia', 'VA'),
(56, 'Washington', 'WA'),
(57, 'West Virgin', 'WV'),
(58, 'Wisconsin', 'WI'),
(59, 'Wyoming', 'WY');

-- --------------------------------------------------------

--
-- Table structure for table `status_types`
--

CREATE TABLE IF NOT EXISTS `status_types` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status_types`
--

INSERT INTO `status_types` (`id`, `name`) VALUES
(1, 'Draft'),
(2, 'Approved'),
(3, 'Denied'),
(4, 'Pending Changes'),
(0, 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `id` int(11) NOT NULL,
  `user1` int(7) NOT NULL,
  `user2` int(7) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`id`, `user1`, `user2`) VALUES
(1, 1, 6),
(2, 6, 9),
(3, 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `is_employee` int(1) NOT NULL,
  `role` int(7) NOT NULL,
  `is_verified` int(1) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(7) NOT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `theme` int(1) NOT NULL,
  `policy_number` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `profile_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `account_disabled` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_employee`, `role`, `is_verified`, `email`, `password`, `first_name`, `last_name`, `address`, `city`, `state`, `zip`, `phone`, `theme`, `policy_number`, `profile_content`, `avatar`, `account_disabled`) VALUES
(1, 1, 1, 0, 'isolennox@gmail.com', '$2y$10$yR2UgcSME9HNaAVXl4GPouD0FyHNThuTw382F6YjsDwnoc.hgSQ7q', 'Isobel C', 'Lennox', '', '', 0, '', '', 0, '', 'Hi Kris!', 'profile_img/1/regina.gif', 0),
(2, 0, 0, 0, 'lennoxfiles@gmail.com', '$2y$10$m9raYcb0d8nZdvNL1dBs9.L3hKNlKqp2mSA0mUEzUPeyYRoYeIUpu', 'Izzy', 'Bee', '987 Mullberry Lane', 'Anchorage', 1, '96544', '6098404145', 1, '9898785-545-654001', 'kjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjg', 'profile_img/2/bruce.gif', 0),
(6, 1, 1, 0, 'larhea@gmail.com', '$2y$10$WCI96qcP1mfOI7hz0/Gq0eRh4dbSub0hE.svLWGChJFyXjVfKXmde', 'LaRhea', 'Phillips', '', '', 0, '', '', 0, '', '', '', 0),
(7, 1, 1, 0, 'matt@gmail.com', '$2y$10$XTxBelwLV6o9lIF9nOBSieAyP5KbQeAqNBpjnZ1dJGkwi87eU.PLG', 'Matt', 'Browne', '', '', 0, '', '', 0, '', '', '', 0),
(8, 0, 0, 0, 'g@me.com', '$2y$10$Ukl2SMPPgyj6MuBJE7YSt.8Ucmq.QvvMEq8eema309l9RG2C.0gue', 'Guest', 'guy', '', '', 0, '', '', 0, '', '', '', 0),
(9, 1, 2, 0, 'claims@gmail.com', '$2y$10$CnniO89AgDVYEfwS1hkoZuOdCqcxfEaBmsVfMfQzjIgkhpj2XKXj6', 'Claims', 'Adjuster', '', '', 0, '', '', 0, '', '', '', 0),
(10, 1, 1, 0, 'kris@gmail.com', '$2y$10$PhcrvpzYeXWveR88g5XemuPamyvciUfym5ZSZo/w69kNNAWFlVuDS', 'Kris', 'Kuchinka', '', '', 0, '', '', 0, '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claims_img`
--
ALTER TABLE `claims_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claim_items`
--
ALTER TABLE `claim_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claim_types`
--
ALTER TABLE `claim_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_img`
--
ALTER TABLE `item_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_types`
--
ALTER TABLE `status_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `claims_img`
--
ALTER TABLE `claims_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `claim_items`
--
ALTER TABLE `claim_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `claim_types`
--
ALTER TABLE `claim_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `item_img`
--
ALTER TABLE `item_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `status_types`
--
ALTER TABLE `status_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
