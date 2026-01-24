-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 10:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `adcomment`
--

CREATE TABLE `adcomment` (
  `pid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `cid` int(11) NOT NULL,
  `Adid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `adcomment`
--

INSERT INTO `adcomment` (`pid`, `comment`, `cid`, `Adid`) VALUES
(1, 'comment of 10', 2, 10),
(13, 'new for 10 again', 3, 10),
(13, 'from me to me', 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `adlike`
--

CREATE TABLE `adlike` (
  `pid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `Adid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `adlike`
--

INSERT INTO `adlike` (`pid`, `lid`, `Adid`) VALUES
(13, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `ccid` int(11) NOT NULL,
  `Adid` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `no_like` int(11) NOT NULL DEFAULT 0,
  `no_comment` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`ccid`, `Adid`, `content`, `image`, `date`, `no_like`, `no_comment`) VALUES
(13, 6, 'asda', '', '2024-05-03 12:58:31', 0, 0),
(13, 7, 'sdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '', '2024-05-03 13:02:02', 0, 0),
(13, 8, 'new one ', '', '2024-05-03 13:07:46', 0, 0),
(13, 10, 'asd', '', '2024-05-03 13:08:04', 0, 0),
(15, 11, 'new one from emam', '', '2024-05-04 14:26:24', 0, 0),
(15, 12, '', '25183842_1222546.jpg', '2024-05-04 14:35:43', 0, 0),
(13, 13, 'new ad', '74966381_617724.jpg', '2024-05-04 14:58:01', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `blockuser`
--

CREATE TABLE `blockuser` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `blockuser`
--

INSERT INTO `blockuser` (`pid`, `uid`) VALUES
(16, 15);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`pid`, `cid`, `comment`, `postid`) VALUES
(1, 1, 'easy content', 11),
(1, 2, 'new comment for 26 ', 27),
(1, 3, 'for 25 i think', 26),
(1, 6, 'new comment for comment comment', 10),
(1, 7, 'easy', 10),
(1, 8, 'sa', 10),
(1, 9, 'comment for one of ali but from here', 24),
(13, 10, 'one from me to mo', 33),
(1, 11, 'can it go or not 29\r\n', 29),
(16, 14, 'from ehab', 28);

-- --------------------------------------------------------

--
-- Table structure for table `followuser`
--

CREATE TABLE `followuser` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `followuser`
--

INSERT INTO `followuser` (`pid`, `uid`) VALUES
(12, 1),
(1, 12),
(16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE `hashtag` (
  `pid` int(11) NOT NULL,
  `hid` int(11) NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `no_uses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`pid`, `hid`, `content`, `no_uses`) VALUES
(1, 1, 'jj', 0),
(1, 2, 'jj', 0),
(1, 3, 'll', 4),
(5, 6, 'new one babe', 2),
(1, 7, 'new hashtag for private', 2),
(16, 8, 'solo leveling', 1);

-- --------------------------------------------------------

--
-- Table structure for table `muteuser`
--

CREATE TABLE `muteuser` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `muteuser`
--

INSERT INTO `muteuser` (`pid`, `uid`) VALUES
(13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `aid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `noteid` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `role` int(3) NOT NULL DEFAULT 3,
  `FPQ` varchar(255) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `pimage` varchar(255) DEFAULT NULL,
  `cimage` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `banned` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `uname`, `email`, `pass`, `Fname`, `Lname`, `role`, `FPQ`, `phone`, `pimage`, `cimage`, `date`, `banned`) VALUES
(1, 'body', 'easy@gmail.g', '12345', 'Abdelrahman', 'Ahmed', 1, '', '', 'abstract-user-flat-4.webp', 'pexels-felixmittermeier-1146134.jpg', '2024-04-21 14:49:34', 0),
(5, 'Ali012', 'easy@gmail.c', '12', 'Ali33', 'Mohamed', 3, '', '', 'abstract-user-flat-4.webp', 'pexels-felixmittermeier-1146134.jpg', '2024-04-21 14:49:34', 0),
(12, 'Mohamed11', 'ali@f.c', '123', 'Mo', 'Mohamed', 3, '', '', '43587584_bloodshot-x-fast-and-furious-9-movie-4k-2020-2k-1366x768.jpg', '62258363_1366_768_20130423123330502621.jpg', '2024-05-02 15:09:13', 0),
(13, 'ahmed01', 'ali@f.c', '12', 'Ali', 'Mohamed', 2, '', '', 'abstract-user-flat-4.webp', 'pexels-felixmittermeier-1146134.jpg', '2024-05-03 11:58:21', 0),
(15, 'emam', 'ali@f.c', '12', 'aa', 'aaa', 2, '', '', 'abstract-user-flat-4.webp', 'pexels-felixmittermeier-1146134.jpg', '2024-05-04 14:26:04', 0),
(16, 'Devil', 'ali@f.c', '123', 'Mo', 'Ehab', 3, '', '', '11168744_Solo_Leveling.jpeg', '82661163_ACE.jpg', '2024-05-04 21:40:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `pid` int(11) NOT NULL,
  `interid` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `no_like` int(11) NOT NULL DEFAULT 0,
  `no_comment` int(11) NOT NULL DEFAULT 0,
  `hid` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `visibility` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`pid`, `interid`, `content`, `image`, `no_like`, `no_comment`, `hid`, `date`, `visibility`) VALUES
(1, 10, '', '87675512_1232265.jpg', 0, 0, NULL, '2024-04-22 21:12:04', 1),
(1, 11, '', '35961150_1222546.jpg', 0, 0, NULL, '2024-04-22 21:13:58', 0),
(1, 13, '', '66662802_1232264.jpg', 0, 0, 2, '2024-04-24 11:39:09', 0),
(5, 15, 'user', '', 0, 0, 1, '2024-04-24 11:54:56', 0),
(5, 16, 'easy', '', 0, 0, NULL, '2024-04-24 12:17:43', 0),
(5, 17, 'fdf', '', 0, 0, 1, '2024-04-24 12:24:09', 0),
(5, 20, 'dddd', '', 0, 0, 3, '2024-04-24 12:25:07', 0),
(5, 21, 'eeeeeeeeeeeeeeee', '', 0, 0, NULL, '2024-04-24 12:29:32', 0),
(5, 22, 'eeeeeeeeeeeeeeeeeeeeef', '', 0, 0, 2, '2024-04-24 12:30:09', 0),
(5, 23, 'fffffffffffffffffffffffffffffffff', '', 0, 0, 6, '2024-04-24 12:30:28', 0),
(5, 24, 'vvvvvvvvvvvvvvvvvvvvvvv', '', 0, 0, NULL, '2024-04-24 12:31:06', 0),
(1, 25, 'profile', '', 0, 0, NULL, '2024-04-24 12:34:41', 1),
(1, 26, 'fdvf  ', '', 0, 0, 3, '2024-04-24 14:53:38', 0),
(1, 27, 'new post from body to know if the hashtag increase or not', '', 0, 0, 6, '2024-04-25 05:33:44', 0),
(1, 28, 'new post with visibility private', '', 0, 0, 7, '2024-04-25 18:01:43', 0),
(1, 29, 'private', '', 0, 0, 3, '2024-04-25 18:02:12', 1),
(12, 33, 'no thing i only make sure that photo', '', 0, 0, NULL, '2024-05-02 17:22:10', 0),
(13, 35, 'gggfgfb ', '', 0, 0, NULL, '2024-05-03 23:39:46', 0),
(15, 38, '', '38485897_1222546.jpg', 0, 0, NULL, '2024-05-04 14:31:45', 0),
(16, 39, 'solo leveling is the best ', '62818533_AnimeWallpapers1.jpg', 0, 0, 8, '2024-05-04 21:42:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `pid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`pid`, `lid`, `postid`) VALUES
(1, 6, 13),
(1, 7, 29),
(16, 10, 24),
(16, 12, 35);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`pid`, `uid`, `rid`, `content`, `date`) VALUES
(1, 5, 2, 'report', '2024-04-30 13:33:37'),
(1, 5, 4, 'from there ', '2024-05-02 14:54:16'),
(13, 13, 5, 'from me', '2024-05-03 17:06:17'),
(1, 1, 6, 'report my self ??', '2024-05-04 10:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `retweetcomment`
--

CREATE TABLE `retweetcomment` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `retweetcomment`
--

INSERT INTO `retweetcomment` (`pid`, `cid`, `shareid`, `content`) VALUES
(1, 3, 12, 'comment of 12'),
(12, 5, 14, 'new reply from me'),
(12, 6, 14, 'is this g for retweet'),
(16, 7, 14, 'it ;ckv'),
(16, 8, 14, 'oofod');

-- --------------------------------------------------------

--
-- Table structure for table `retweetlike`
--

CREATE TABLE `retweetlike` (
  `retweetid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `lid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `retweetlike`
--

INSERT INTO `retweetlike` (`retweetid`, `pid`, `lid`) VALUES
(13, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `savedpost`
--

CREATE TABLE `savedpost` (
  `savepid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `saveId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `savedpost`
--

INSERT INTO `savedpost` (`savepid`, `postid`, `groupid`, `saveId`) VALUES
(13, 38, 12, 18);

-- --------------------------------------------------------

--
-- Table structure for table `savedretweet`
--

CREATE TABLE `savedretweet` (
  `savepid` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `saveid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `savedretweet`
--

INSERT INTO `savedretweet` (`savepid`, `shareid`, `saveid`, `groupid`) VALUES
(1, 14, 21, 7);

-- --------------------------------------------------------

--
-- Table structure for table `savegroups`
--

CREATE TABLE `savegroups` (
  `groupid` int(11) NOT NULL,
  `groupName` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `savegroups`
--

INSERT INTO `savegroups` (`groupid`, `groupName`, `pid`) VALUES
(7, 'CS', 1),
(8, 'IT', 1),
(12, 'IT', 13),
(13, 'gg', 16);

-- --------------------------------------------------------

--
-- Table structure for table `sharedpost`
--

CREATE TABLE `sharedpost` (
  `retweetpid` int(11) NOT NULL,
  `oldid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `newContent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `shareid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sharedpost`
--

INSERT INTO `sharedpost` (`retweetpid`, `oldid`, `postid`, `newContent`, `date`, `shareid`) VALUES
(1, 5, 24, '', '2024-04-28 15:42:12', 2),
(1, 5, 24, 'again', '2024-04-28 16:00:20', 4),
(1, 1, 13, '', '2024-04-28 17:42:49', 6),
(1, 1, 13, 'new content for image', '2024-04-30 05:57:28', 9),
(1, 5, 24, 'again of vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', '2024-05-01 19:57:41', 12),
(1, 1, 13, 'no one', '2024-05-01 20:00:58', 13),
(1, 5, 24, 'again vvvvvvvvvv', '2024-05-01 20:01:11', 14),
(12, 5, 24, 'vvx', '2024-05-02 17:28:15', 20),
(16, 5, 24, 'from ehab again', '2024-05-04 21:46:42', 23),
(16, 5, 24, 'retweet from ehab again ', '2024-05-04 21:49:56', 24),
(16, 5, 24, 'can tfsdvmm', '2024-05-04 21:52:23', 25),
(16, 1, 28, 'bbv', '2024-05-04 22:13:57', 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adcomment`
--
ALTER TABLE `adcomment`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `Adid` (`Adid`);

--
-- Indexes for table `adlike`
--
ALTER TABLE `adlike`
  ADD PRIMARY KEY (`lid`),
  ADD KEY `Adid` (`Adid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`Adid`),
  ADD KEY `ccid` (`ccid`);

--
-- Indexes for table `blockuser`
--
ALTER TABLE `blockuser`
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `followuser`
--
ALTER TABLE `followuser`
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`hid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `muteuser`
--
ALTER TABLE `muteuser`
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`noteid`),
  ADD KEY `aid` (`aid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`interid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `hid` (`hid`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`lid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `retweetcomment`
--
ALTER TABLE `retweetcomment`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `shareid` (`shareid`);

--
-- Indexes for table `retweetlike`
--
ALTER TABLE `retweetlike`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `savedpost`
--
ALTER TABLE `savedpost`
  ADD PRIMARY KEY (`saveId`),
  ADD KEY `pid` (`savepid`),
  ADD KEY `postid` (`postid`),
  ADD KEY `groupSave` (`groupid`);

--
-- Indexes for table `savedretweet`
--
ALTER TABLE `savedretweet`
  ADD PRIMARY KEY (`saveid`),
  ADD KEY `groupid` (`groupid`),
  ADD KEY `shareid` (`shareid`),
  ADD KEY `savepid` (`savepid`);

--
-- Indexes for table `savegroups`
--
ALTER TABLE `savegroups`
  ADD PRIMARY KEY (`groupid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `sharedpost`
--
ALTER TABLE `sharedpost`
  ADD PRIMARY KEY (`shareid`),
  ADD KEY `oldid` (`oldid`),
  ADD KEY `pid` (`retweetpid`),
  ADD KEY `postid` (`postid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adcomment`
--
ALTER TABLE `adcomment`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `adlike`
--
ALTER TABLE `adlike`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `Adid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hashtag`
--
ALTER TABLE `hashtag`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `noteid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `interid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `retweetcomment`
--
ALTER TABLE `retweetcomment`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `retweetlike`
--
ALTER TABLE `retweetlike`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `savedpost`
--
ALTER TABLE `savedpost`
  MODIFY `saveId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `savedretweet`
--
ALTER TABLE `savedretweet`
  MODIFY `saveid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `savegroups`
--
ALTER TABLE `savegroups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sharedpost`
--
ALTER TABLE `sharedpost`
  MODIFY `shareid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adcomment`
--
ALTER TABLE `adcomment`
  ADD CONSTRAINT `adcomment_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adcomment_ibfk_2` FOREIGN KEY (`Adid`) REFERENCES `advertisement` (`Adid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `adlike`
--
ALTER TABLE `adlike`
  ADD CONSTRAINT `adlike_ibfk_1` FOREIGN KEY (`Adid`) REFERENCES `advertisement` (`Adid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adlike_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD CONSTRAINT `advertisement_ibfk_1` FOREIGN KEY (`ccid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blockuser`
--
ALTER TABLE `blockuser`
  ADD CONSTRAINT `blockuser_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blockuser_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `post` (`interid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `followuser`
--
ALTER TABLE `followuser`
  ADD CONSTRAINT `followuser_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followuser_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD CONSTRAINT `hashtag_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `muteuser`
--
ALTER TABLE `muteuser`
  ADD CONSTRAINT `muteuser_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `muteuser_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`hid`) REFERENCES `hashtag` (`hid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `post` (`interid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `retweetcomment`
--
ALTER TABLE `retweetcomment`
  ADD CONSTRAINT `retweetcomment_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `retweetcomment_ibfk_2` FOREIGN KEY (`shareid`) REFERENCES `sharedpost` (`shareid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `savedpost`
--
ALTER TABLE `savedpost`
  ADD CONSTRAINT `savedpost_ibfk_1` FOREIGN KEY (`savepid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `savedpost_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `post` (`interid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `savedpost_ibfk_3` FOREIGN KEY (`groupid`) REFERENCES `savegroups` (`groupid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `savedretweet`
--
ALTER TABLE `savedretweet`
  ADD CONSTRAINT `savedretweet_ibfk_2` FOREIGN KEY (`groupid`) REFERENCES `savegroups` (`groupid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `savedretweet_ibfk_3` FOREIGN KEY (`shareid`) REFERENCES `sharedpost` (`shareid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `savedretweet_ibfk_4` FOREIGN KEY (`savepid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `savegroups`
--
ALTER TABLE `savegroups`
  ADD CONSTRAINT `savegroups_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sharedpost`
--
ALTER TABLE `sharedpost`
  ADD CONSTRAINT `sharedpost_ibfk_1` FOREIGN KEY (`oldid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sharedpost_ibfk_2` FOREIGN KEY (`retweetpid`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sharedpost_ibfk_3` FOREIGN KEY (`postid`) REFERENCES `post` (`interid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
