-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2015 at 05:55 PM
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
  `updated` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`id`, `status_id`, `datetime`, `title`, `notes`, `claim_type`, `user_id`, `updated`, `hidden`) VALUES
(3, 4, '13/05/2015 13:22', 'Robbery', '(uploaded police report)<hr/>fs <br><hr/><br><strong>Claim Adjuster Notes: </strong> Needs more information. Please write out a detailed description.<hr/><hr/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>', 4, 2, '16/05/2015', 0),
(8, 1, '15/05/2015 20:46', 'They Broke it!', 'Vandals came in and broke my romulan necklace. Specists.', 2, 2, '', 0),
(9, 2, '16/05/2015 17:34', 'Tornado', 'Lost the pieces to my monopoly set. <br><hr/><br><strong>Claim Adjuster Notes: </strong> Your Claims has been approved!', 1, 2, '25/05/2015', 1),
(10, 1, '22/05/2015 17:02', '', '', 3, 12, '', 0),
(12, 0, '26/05/2015 13:56', 'yo man', 'my stuff is burned', 3, 12, '', 0),
(13, 3, '27/05/2015 19:40', 'It broke', 'My daughter jumped on it, give me money to replace it. <br><hr/><br><strong>Claim Adjuster Notes: </strong> This is not covered in our policy.', 6, 2, '05/27/2015', 0),
(14, 0, '28/05/2015 16:43', 'Antique Shower Curtain', 'Police Report# 1234\r\n\r\nBurglars broke in and took the shower curtain.', 4, 16, '', 0),
(15, 4, '28/05/2015 19:35', 'blah', 'my stuff was burned <br><hr/><br><strong>Claim Adjuster Notes: </strong> You need to add images of your damages', 3, 17, '05/28/2015', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `claim_items`
--

INSERT INTO `claim_items` (`id`, `item_id`, `claim_id`) VALUES
(15, 14, 3),
(14, 7, 3),
(23, 18, 13),
(6, 13, 9),
(26, 23, 15),
(25, 22, 14),
(24, 15, 3),
(22, 19, 12);

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
  `datetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `is_employee` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `content`, `datetime`, `is_employee`) VALUES
(12, 2, 'Added item: <a href="item_details.php?id=12">Romulan Necklacce</a>', '14/05/2015 18:22', 0),
(2, 2, 'Added item: <a href="item_details.php?id=10">testing history</a>', '12052015', 0),
(3, 2, 'Removed item: <a href="item_details.php?id=10">testing history</a>', '', 0),
(11, 2, 'Removed item: <a href="item_details.php?id=11">sfdsf</a>', '14/05/2015 18:17', 0),
(10, 2, 'Added item: <a href="item_details.php?id=11">sfdsf</a>', '14/05/2015 17:41', 0),
(9, 2, 'Removed item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '14/05/2015 17:28', 0),
(8, 2, 'Filed Claim: <a href="claim_details.php?id=3">Robbery</a>', '13/05/2015 13:22', 0),
(40, 1, 'Reactivated <a href="profile.php?user=13">Guest  Employee</a>s Account', '25/05/2015 22:12', 1),
(15, 2, 'Filed Claim: <a href="claim_details.php?id=3">Robbery</a>', '16/05/2015 15:15', 0),
(39, 1, 'Disabled <a href="profile.php?user=13">Guest  Employee</a>s Account', '25/05/2015 22:12', 1),
(17, 2, 'Added item: <a href="item_details.php?id=13">Vintage Monopoly Set</a>', '16/05/2015 16:10', 0),
(18, 2, 'Filed Claim: <a href="claim_details.php?id=9">Tornado</a>', '16/05/2015 17:35', 0),
(19, 2, 'Restored item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 18:52', 0),
(20, 2, 'Edited item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 19:28', 0),
(21, 2, 'Edited item: <a href="item_details.php?id=6">SheepSkin Banjo</a>', '18/05/2015 19:29', 0),
(22, 2, 'Edited item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 19:37', 0),
(23, 2, 'Edited item: <a href="item_details.php?id=6">Sheep Skin Banjo</a>', '18/05/2015 19:37', 0),
(24, 2, 'Added item: <a href="item_details.php?id=14">Old Book</a>', '05/18/2015 20:12', 0),
(25, 2, 'Added item: <a href="item_details.php?id=15">PHP</a>', '05/18/2015 20:14', 0),
(26, 2, 'Added item: <a href="item_details.php?id=16"></a>', '05/20/2015 18:03', 0),
(27, 2, 'Added item: <a href="item_details.php?id=17">tyrtyrt</a>', '05/20/2015 18:18', 0),
(28, 2, 'Removed item: <a href="item_details.php?id=16"></a>', '05/20/2015 19:15', 0),
(29, 2, 'Added item: <a href="item_details.php?id=18">Piano Bench</a>', '05/21/2015 19:05', 0),
(30, 12, 'Added item: <a href="item_details.php?id=19">Diamond Necklace</a>', '05/22/2015 16:42', 0),
(31, 12, 'Added item: <a href="item_details.php?id=20">Samsung TV</a>', '05/22/2015 16:57', 0),
(32, 12, 'Removed item: <a href="item_details.php?id=19">Diamond Necklace</a>', '05/22/2015 16:57', 0),
(33, 12, 'Removed item: <a href="item_details.php?id=20">Samsung TV</a>', '05/22/2015 16:58', 0),
(34, 12, 'Restored item: <a href="item_details.php?id=19">Diamond Necklace</a>', '05/22/2015 16:58', 0),
(35, 2, 'Restored item: <a href="item_details.php?id=11">sfdsf</a>', '05/24/2015 15:46', 0),
(36, 2, 'Removed item: <a href="item_details.php?id=11">sfdsf</a>', '05/24/2015 15:46', 0),
(37, 2, 'Added item: <a href="item_details.php?id=21">Stereo system </a>', '05/24/2015 21:36', 0),
(38, 1, 'Updated <a href="claim_details.php?id=9">Claim #9</a>', '25/05/2015 21:48', 1),
(41, 1, 'Disabled <a href="profile.php?user=13">Guest  Employee</a>''s Account', '25/05/2015 22:13', 1),
(42, 1, 'Reactivated <a href="profile.php?user=13">Guest  Employee</a>''s Account', '25/05/2015 22:13', 1),
(43, 1, 'Reactivated <a href="profile.php?user=9">Claims Adjuster</a>''s Account', '25/05/2015 22:18', 1),
(44, 1, 'Changed <a href="profile.php?user=9">Claims Adjuster</a>''s Password', '25/05/2015 22:18', 1),
(45, 1, 'Disabled <a href="profile.php?user=9">Claims Adjuster</a>''s Account', '25/05/2015 22:22', 0),
(46, 1, 'Reactivated <a href="profile.php?user=9">Claims Adjuster</a>''s Account', '05/25/2015 22:27', 1),
(47, 12, 'Filed Claim: <a href="claim_details.php?id=12">yo man</a>', '26/05/2015 13:56', 0),
(48, 2, 'Edited item: <a href="item_details.php?id=2">Sampsung Television</a>', '05/27/2015 19:13', 0),
(49, 2, 'Filed Claim: <a href="claim_details.php?id=13">It broke</a>', '27/05/2015 19:40', 0),
(50, 1, 'Updated <a href="claim_details.php?id=13">Claim #13</a>', '05/27/2015 19:53', 1),
(51, 2, 'Removed item: <a href="item_details.php?id=17">tyrtyrt</a>', '05/27/2015 20:01', 0),
(52, 2, 'Removed item: <a href="item_details.php?id=21">Stereo system</a>', '05/27/2015 20:01', 0),
(53, 16, 'Added item: <a href="item_details.php?id=22">Antique Shower Curtain</a>', '05/28/2015 16:30', 0),
(54, 16, 'Filed Claim: <a href="claim_details.php?id=14">Antique Shower Curtain</a>', '28/05/2015 16:43', 0),
(55, 17, 'Added item: <a href="item_details.php?id=23">Antique Mideival Bedroom Wardrobe</a>', '05/28/2015 19:32', 0),
(56, 17, 'Removed item: <a href="item_details.php?id=23">Antique Mideival Bedroom Wardrobe</a>', '05/28/2015 19:34', 0),
(57, 17, 'Restored item: <a href="item_details.php?id=23">Antique Mideival Bedroom Wardrobe</a>', '05/28/2015 19:34', 0),
(58, 17, 'Filed Claim: <a href="claim_details.php?id=15">blah</a>', '28/05/2015 19:36', 0),
(59, 6, 'Updated <a href="claim_details.php?id=15">Claim #15</a>', '05/28/2015 19:40', 1),
(60, 2, 'Added item: <a href="item_details.php?id=24">Sam''s Club TV</a>', '05/29/2015 17:42', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `category`, `room_id`, `name`, `purchase_date`, `purchase_price`, `declared_value`, `notes`, `upload_date`, `updated`, `in_trash`) VALUES
(7, 2, 1, 5, 'Diamond Watch', '12/23/1989', '15,000', '16000', 'In the safe', '0', '', 0),
(2, 2, 2, 2, 'Sampsung Television', '12/23/1986', '2000.00', '1800', 'Family heirloom!', '0', '05/27/2015 19:13', 0),
(6, 2, 4, 1, 'Sheep Skin Banjo', '10/01/1929', '5.00', '21000', 'Appraised 10/07/1997', '18/03/2015 19:37', '18/05/2015 19:37', 0),
(8, 2, 1, 1, 'test', '12052015', '2000', '2100', 'tet', '12052015', '', 1),
(9, 2, 1, 1, 'Test again', '12052015', '2000', '2100', 'lorem', '12052015', '', 1),
(10, 2, 1, 1, 'testing history', '12052015', '2000', '2100', 'stuff', '12052015', '', 1),
(11, 2, 1, 1, 'sfdsf', '14/05/2015 17:41', '76', '6786', 'dfdasgfg', '14/05/2015 17:41', '14/05/2015 17:41', 1),
(12, 2, 1, 5, 'Romulan Necklacce', '14/05/2015 18:22', '50', '200', 'My prized posession', '14/05/2015 18:22', '14/05/2015 18:22', 0),
(13, 2, 7, 1, 'Vintage Monopoly Set', '16/05/2015 16:10', '15', '200', 'Keeping this safe', '16/05/2015 16:10', '16/05/2015 16:10', 0),
(14, 2, 10, 5, 'Old Book', '05/18/2015 20:12', '0.05', '950', 'Priceless antique', '05/18/2015 20:12', '05/18/2015 20:12', 0),
(15, 2, 5, 1, 'PHP', '05/18/2015 20:14', '5.00', '2100', 'Lorem', '05/18/2015 20:14', '05/18/2015 20:14', 0),
(17, 2, 3, 1, 'tyrtyrt', '05/20/2015 18:18', '', '', '', '05/20/2015 18:18', '05/20/2015 18:18', 1),
(21, 2, 2, 1, 'Stereo system ', '05/24/2015 21:36', '300', '300', 'Bose', '', '05/24/2015 21:36', 1),
(18, 2, 4, 5, 'Piano Bench', '05/21/2015 19:05', '2,000', '2000', '', '', '05/21/2015 19:05', 0),
(19, 12, 1, 6, 'Diamond Necklace', '05/22/2015 16:42', '950', '950', 'ghbtrb', '02/01/2000', '05/22/2015 16:42', 0),
(20, 12, 2, 6, 'Samsung TV', '05/22/2015 16:57', '1500', '1500', 'Stuff', '02/01/2000', '05/22/2015 16:57', 1),
(22, 16, 10, 8, 'Antique Shower Curtain', '05/28/2015 16:30', '10000', '12000', 'Antique Shower Curtain belonging to the Honorable Sir Peter Preston. It was made in 1846 and is white with interlacing gold trim and etchings.', '01/07/1988', '05/28/2015 16:30', 0),
(23, 17, 3, 9, 'Antique Mideival Bedroom Wardrobe', '05/28/2015 19:32', '100', '15000', 'See appraisal', '01/07/1988', '05/28/2015 19:32', 0),
(24, 2, 2, 2, 'Sam''s Club TV', '05/29/2015 17:42', '950', '1000', 'I like to poop and watch.', '12/23/2013', '05/29/2015 17:42', 0);

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
  `file_path` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_img` int(1) NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `thumb_path` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_img`
--

INSERT INTO `item_img` (`id`, `item_id`, `file_path`, `is_img`, `title`, `thumb_path`) VALUES
(9, 2, 'images/img_1432768827.jpg', 1, 'Jellies', 'thumbs/tn_img_1432768827.jpg'),
(3, 21, 'item_images/2/398e0314-2cd6-44de-bc98-7075e3ef6c7b.png', 1, 'Backwards man ', ''),
(4, 19, 'item_images/12/front_shoe.jpg', 1, 'Totes a Diamond Neck', ''),
(5, 2, 'item_images/2/keep-calm-and-please-hold-2.png', 1, 'Television', ''),
(8, 2, 'images/img_1432768176.jpg', 1, 'Screensaver', 'thumbs/tn_img_1432768176.jpg'),
(10, 2, 'images/img_1432768837.jpg', 1, 'Koala', 'thumbs/tn_img_1432768837.jpg'),
(11, 22, 'images/img_1432848746.jpg', 1, 'Antique Shower Curta', 'thumbs/tn_img_1432848746.jpg'),
(12, 23, 'images/img_1432859609.jpg', 1, 'hergkbjg', 'thumbs/tn_img_1432859609.jpg'),
(13, 23, 'images/img_1432859652.jpg', 1, 'blahe', 'thumbs/tn_img_1432859652.jpg');

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
(10, '17/05/2015 17:02', 3, 6, 7, 1, 'string''s test''s #9'),
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Super User'),
(2, 'Claims Adjuster'),
(3, 'Guest');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `notes`, `user_id`) VALUES
(1, 'Zora''s Bedroom', 'Upstairs in main house', 2),
(2, 'Upstairs Bathroom', 'Upstairs Bathroom', 2),
(5, 'Master Bedroom', '', 2),
(6, 'Bedroom', 'my bedroom', 12),
(7, 'Holodeck', 'The Holosuites and holodecks use two major subsystems: the holographic image and the conversion of matter. The holographic imaging system creates realistic environments and landscapes. The conversion system of matter creates physical objects from the central supply of raw materials from the ship. Under normal conditions, a participant in a holographic simulation should not be able to distinguish a real object from a simulated one.', 14),
(8, 'Bathroom', 'This is the Master Bathroom.', 16),
(9, 'B edroom', 'This is where we sleep at night and when we nap.', 17);

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
  `walkthrough_complete` int(1) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_employee`, `role`, `walkthrough_complete`, `email`, `password`, `first_name`, `last_name`, `address`, `city`, `state`, `zip`, `phone`, `theme`, `policy_number`, `profile_content`, `avatar`, `account_disabled`) VALUES
(1, 1, 1, 0, 'isolennox@gmail.com', '$2y$10$UbMiItxXdXK6HrgukgLUPe8R8g5L8IObAgYy2ESW6iEfnBksjoFXK', 'Isobel C', 'Lennox', '', '', 0, '', '', 0, '', 'Hi Kris!', 'profile_img/1/regina.gif', 0),
(2, 0, 0, 0, 'lennoxfiles@gmail.com', '$2y$10$m9raYcb0d8nZdvNL1dBs9.L3hKNlKqp2mSA0mUEzUPeyYRoYeIUpu', 'Izzy', 'Bee', '987 Mullberry Lane', 'Anchorage', 1, '96544', '6098404145', 1, '9898785-545-654001', 'kjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjgkjdsfhshgjwebhrgehriughkejrgkjenfkjgnkdfjg', 'profile_img/2/bruce.gif', 0),
(6, 1, 1, 0, 'larhea@gmail.com', '$2y$10$WCI96qcP1mfOI7hz0/Gq0eRh4dbSub0hE.svLWGChJFyXjVfKXmde', 'LaRhea', 'Phillips', '', '', 0, '', '', 0, '', '', '', 0),
(7, 1, 1, 0, 'matt@gmail.com', '$2y$10$XTxBelwLV6o9lIF9nOBSieAyP5KbQeAqNBpjnZ1dJGkwi87eU.PLG', 'Matt', 'Browne', '', '', 0, '', '', 1, '', '', '', 0),
(8, 0, 0, 0, 'g@me.com', '$2y$10$Ukl2SMPPgyj6MuBJE7YSt.8Ucmq.QvvMEq8eema309l9RG2C.0gue', 'Guest', 'guy', '', '', 0, '', '', 0, '', '', '', 0),
(9, 1, 2, 0, 'claims@gmail.com', '$2y$10$SX8Pc3tUGNFJWl8tqGU3qO9BXw3lIpX2cmw001jxBH0wU1SxhQbH6', 'Claims', 'Adjuster', '', '', 0, '', '', 0, '', '', '', 0),
(10, 1, 1, 0, 'kris@gmail.com', '$2y$10$PhcrvpzYeXWveR88g5XemuPamyvciUfym5ZSZo/w69kNNAWFlVuDS', 'Kris', 'Kuchinka', '', '', 0, '', '', 0, '', '', '', 0),
(13, 1, 3, 0, 'guest@gmail.com', '$2y$10$k43tptownD9QGxVEIBtHm.gBIc5zoH9jC0a/D5tfrDtkEnN4RSQgi', 'Guest ', 'Employee', '', '', 0, '', '', 1, '', '', '', 0),
(12, 0, 0, 0, 'l.phillips@students.clark.edu', '$2y$10$2XWe/Au65Dd0NOWQrYol/.MX3WQPqAcdaiJoHojvhHNjjXD6KWSli', 'LaRhea', 'Phillips', '', '', 0, '', '', 0, '', '', '', 0),
(14, 0, 0, 0, 'guest2@gmail.com', '$2y$10$JjZn.f9DfvwMbvCvstvfHu6btNNR0GpuEco4xLYIG.LuiYJTD5R96', 'Guest', 'Client', '', '', 0, '', '', 0, '', '', '', 0),
(17, 0, 0, 0, 'faker.person@gmail.com', '$2y$10$Wgyg.kvL68CKYjib8bUP7uwPOL/LHXR.SyYclBPr7vCo5DWvh80tm', 'Faker', 'Person', '', '', 0, '', '', 0, '', '', '', 0),
(15, 0, 0, 0, 'kriskuchinka@gmail.com', '$2y$10$hT2AGn1ff95jE0EGr3e5uuiCAUJx0Cl6DlZyVWjU397ABvbgP0YZC', 'Kris', 'Kuchinka', '', '', 0, '', '', 0, '', '', '', 0),
(16, 0, 0, 0, 'fake.person@gmail.com', '$2y$10$1NolbbP2JNy1pCbG4T/XCuWqv7KFjxPTseka2xGeNQ47sksHuDGVa', 'Fake', 'Person', '', '', 0, '', '', 0, '', '', '', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `claims_img`
--
ALTER TABLE `claims_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `claim_items`
--
ALTER TABLE `claim_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `item_img`
--
ALTER TABLE `item_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
