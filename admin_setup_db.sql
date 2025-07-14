-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 10, 2025 at 11:58 AM
-- Server version: 9.1.0
-- PHP Version: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_setup_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

DROP TABLE IF EXISTS `about_us`;
CREATE TABLE IF NOT EXISTS `about_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'NA',
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'NA',
  `content` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `image`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Test', '1698749469_1061676626_1377820497.jpg', '<p>Welcome to *The Unicorn Computech* - Your Ultimate Destination for Cutting-Edge Computer Parts!</p><p><br></p><p>At The Unicorn Computech, we are not just another eCommerce platform; we are the embodiment of your technology dreams. With a passion for all things tech, we have created a haven for enthusiasts, professionals, and everyday users alike.&nbsp;</p><p><br></p><p>*Our Story:*</p><p>Our journey began with a simple vision - to provide easy access to high-quality computer components and accessories to empower your digital endeavors. As avid gamers, programmers, and tech aficionados ourselves, we understand the importance of having the right tools and components to fuel your passions and pursuits.</p><p><br></p><p>*Our Commitment:*</p><p>- Quality Assurance: We handpick and rigorously test each product in our catalog to ensure it meets our high standards for performance and reliability.</p><p>- Diverse Selection: From graphic cards to processors, motherboards to peripherals, our catalog boasts an extensive range of products from renowned brands to cater to every need.</p><p>- Competitive Prices: We believe that premium technology shouldn\'t break the bank. Our competitive pricing ensures you get the best value for your money.</p><p><br></p><p>*Why Choose Us:*</p><p>- Expert Guidance: Our team of experts is always here to assist you in making informed decisions. Whether you\'re building a gaming rig or upgrading your workstation, we\'ve got you covered.</p><p>- Fast and Secure Shipping: We understand that time is of the essence when you\'re eager to complete your build or replace a malfunctioning component. We offer swift, reliable, and secure shipping options to get your order to you as quickly as possible.</p><p>- Customer Satisfaction: Your satisfaction is our top priority. We offer exceptional customer support to address your queries and concerns promptly.</p><p><br></p><p>Join us at The Unicorn Computech and embark on a journey through the world of technology. Explore our extensive collection of computer parts, accessories, and gadgets, and let us be your trusted partner in all your tech endeavors. Together, we\'ll make your computing dreams a reality. Welcome to the future of tech shopping. Welcome to The Unicorn Computech!</p>', '2023-09-01 03:42:27', '2023-10-31 10:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `dialCode` varchar(100) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL DEFAULT 'NA',
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pin` varchar(255) CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `mainRoleId` bigint DEFAULT NULL,
  `subRoleId` bigint DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `otp` bigint DEFAULT NULL,
  `otpVerifiedType` enum('PHONE','EMAIL','PASSWORD','PIN','NA') COLLATE utf16_unicode_ci NOT NULL DEFAULT 'NA',
  `otpVerifiedAt` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `uniqueId`, `name`, `email`, `dialCode`, `phone`, `image`, `password`, `pin`, `mainRoleId`, `subRoleId`, `remember_token`, `status`, `otp`, `otpVerifiedType`, `otpVerifiedAt`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AU-390101', 'Rahul Biswas', 'biswas.rahul31@gmail.com', '91', '8436191135', '1751430632_1751394600_696786597.png', '$2y$12$7LsVqQiWCwl/3dnf1J.tx.K8hrSW4mivQGW07vy6MSa5ypKNyD1/q', '$2y$12$W41uACHRmpt6ZFqbMTC5lO5lgI8Fl/vwgNu8trOGccuwOfsY9o1GW', 2, NULL, NULL, 'ACTIVE', 726532, 'EMAIL', NULL, '2020-04-01 23:44:52', '2025-07-04 12:40:02', NULL),
(2, 'AU-354298', 'Suman Nag', 'sumonnag@gmail.com', '91', '8436191136', '1748018359_1747958400_1635304235.jpg', '$2y$12$2MzLcSgCH8Iv/k3FpsYG5eDgtLloz6qyVR1kp9gquJubWt5LNdet2', '$2y$12$M3yXBCMdVc7I80YQW21akuJtcbxrQeukZfLFHyl5SKkWk/nMD51e2', 3, 2, NULL, 'ACTIVE', 409731, 'NA', NULL, '2020-04-01 23:44:52', '2025-06-17 22:35:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alert_for`
--

DROP TABLE IF EXISTS `alert_for`;
CREATE TABLE IF NOT EXISTS `alert_for` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alertTypeId` bigint DEFAULT NULL,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `alert_for`
--

INSERT INTO `alert_for` (`id`, `alertTypeId`, `uniqueId`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 2, 'ALFO-909372', 'Send OTP To Register User', 'ACTIVE', '2025-06-23 04:07:15', '2025-06-23 04:07:15', NULL),
(3, 2, 'ALFO-435919', 'Reset Password', 'ACTIVE', '2025-06-12 06:28:16', '2025-06-12 08:32:28', NULL),
(6, 3, 'ALFO-580923', 'Register Admin', 'ACTIVE', '2025-06-12 06:31:30', '2025-06-15 02:41:10', NULL),
(13, 3, 'ALFO-309899', 'Send OTP To Login User', 'ACTIVE', '2025-06-23 04:07:26', '2025-06-23 04:08:06', NULL),
(11, 3, 'ALFO-562883', 'Send OTP To Register User', 'ACTIVE', '2025-06-23 04:07:07', '2025-06-23 04:07:07', NULL),
(7, 3, 'ALFO-928865', 'Send OTP To Reset Admin Password', 'ACTIVE', '2025-06-18 11:51:31', '2025-06-18 11:51:31', NULL),
(8, 3, 'ALFO-799299', 'Send OTP To Reset Admin Pin', 'ACTIVE', '2025-06-18 11:51:42', '2025-06-18 11:51:42', NULL),
(9, 2, 'ALFO-237854', 'Chnage Auth Phone Number', 'ACTIVE', '2025-06-20 07:13:50', '2025-06-20 07:13:50', NULL),
(10, 3, 'ALFO-471078', 'Chnage Auth Email ID', 'ACTIVE', '2025-06-20 07:14:02', '2025-06-20 07:14:02', NULL),
(14, 2, 'ALFO-941855', 'Send OTP To Login User', 'ACTIVE', '2025-06-23 04:07:33', '2025-06-23 04:07:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alert_template`
--

DROP TABLE IF EXISTS `alert_template`;
CREATE TABLE IF NOT EXISTS `alert_template` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alertTypeId` bigint DEFAULT NULL,
  `alertForId` bigint DEFAULT NULL,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `heading` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `content` longtext COLLATE utf8mb3_unicode_ci,
  `variable` json DEFAULT NULL,
  `default` enum('YES','NO') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `alert_template`
--

INSERT INTO `alert_template` (`id`, `alertTypeId`, `alertForId`, `uniqueId`, `heading`, `content`, `variable`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16, 2, 14, 'ALTE-477084', 'OTP to verify before login user', '<h4 style=\"color: rgb(73, 80, 87);\"><font color=\"#003163\" style=\"background-color: rgb(181, 214, 165);\">&nbsp;SMS Login&nbsp;</font></h4><p><font color=\"#c67ba5\" style=\"background-color: rgb(255, 239, 198);\">An otp is sent to your registered phone to verify before login</font></p><p><b>The OTP is</b> [~otp~]</p><p>Do not share the <b>OTP</b> with others...</p>', '[\"[~otp~]\"]', 'YES', '2025-06-23 04:14:10', '2025-06-23 04:29:07', NULL),
(8, 3, 6, 'ALTE-102574', 'Registered for the admin access.', '<p style=\"text-align: justify;\">[~name~] Ipsum is simply <b>dummy text of the printing and typesetting industry. <span style=\"font-family: &quot;Times New Roman&quot;;\"><u>Lorem Ipsum has been the industry\'s</u></span> standard dummy text ever since the 1500s</b>,</p><p style=\"text-align: justify;\">When an unknown <span style=\"background-color: rgb(255, 231, 156);\"><font color=\"#085294\">printer took a galley of type and scrambled it to make</font></span> a type specimen book. It has survived <span style=\"background-color: rgb(49, 24, 115);\"><font color=\"#f7c6ce\">not only five centuries, but also the leap into</font></span> electronic typesetting, remaining essentially unchanged.</p><p style=\"text-align: justify;\"><span style=\"font-family: &quot;Comic Sans MS&quot;;\">It was </span><span style=\"margin: 0px; padding: 0px;\"><span style=\"font-family: &quot;Comic Sans MS&quot;\">[~password~] in the 1960s</span> with the<u>&nbsp;release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like</u>&nbsp;Aldus PageMaker, <span style=\"font-family: Impact;\">which included</span></span><span style=\"font-family: Impact;\">&nbsp;versions of [~phone~] Ipsum.</span></p>', '[\"[~name~]\", \"[~password~]\", \"[~phone~]\"]', 'YES', '2025-06-14 01:48:56', '2025-06-15 07:21:09', NULL),
(9, 2, 3, 'ALTE-980943', 'cxv', '<p>xcv</p>', '[]', 'YES', '2025-06-14 03:26:12', '2025-06-14 09:26:36', NULL),
(15, 3, 13, 'ALTE-856260', 'OTP to verify before login user', '<h4 style=\"color: rgb(73, 80, 87);\"><font color=\"#003163\" style=\"background-color: rgb(181, 214, 165);\">&nbsp;EMAIL Login&nbsp;</font></h4><p><font color=\"#c67ba5\" style=\"background-color: rgb(255, 239, 198);\">An otp is sent to your registered email to verify before login</font></p><p><b>The OTP is</b> [~otp~]</p><p>Do not share the <b>OTP</b> with others...</p>', '[\"[~otp~]\"]', 'YES', '2025-06-23 04:11:58', '2025-06-23 04:29:22', NULL),
(11, 3, 8, 'ALTE-121120', 'OTP to verify before reset pin', '<p>Reset Pin Name: [~name~], OTP: [~otp~]</p>', '[\"[~name~]\", \"[~otp~]\"]', 'YES', '2025-06-18 11:55:05', '2025-06-19 00:30:06', NULL),
(12, 3, 7, 'ALTE-832702', 'OTP to verify before reset password', '<p>Reset Password Name: [~name~], OTP: [~otp~]</p>', '[\"[~name~]\", \"[~otp~]\"]', 'YES', '2025-06-18 11:56:32', '2025-06-19 00:29:58', NULL),
(13, 2, 9, 'ALTE-284374', 'OTP to verify before chnage phone numbaer', '<p>Chnage phone number Name: [~name~], OTP: [~otp~]</p>', '[\"[~name~]\", \"[~otp~]\"]', 'YES', '2025-06-20 07:15:01', '2025-06-20 07:15:01', NULL),
(14, 3, 10, 'ALTE-430455', 'OTP to verify before chnage email id', '<p>Chnage email id Name: [~name~], OTP: [~otp~]</p>', '[\"[~name~]\", \"[~otp~]\"]', 'YES', '2025-06-20 07:15:28', '2025-06-20 07:15:28', NULL),
(17, 3, 11, 'ALTE-977168', 'OTP to verify before register user', '<h4 style=\"color: rgb(73, 80, 87);\"><font color=\"#003163\" style=\"background-color: rgb(181, 214, 165);\">&nbsp;EMAIL Registration&nbsp;</font></h4><p><font color=\"#c67ba5\" style=\"background-color: rgb(255, 239, 198);\">An otp is sent to the email that you want to register for verification before login</font></p><p><b>The OTP is</b> [~otp~]</p><p>Do not share the <b>OTP</b> with others...</p>', '[\"[~otp~]\"]', 'YES', '2025-06-23 04:15:45', '2025-06-23 04:28:52', NULL),
(18, 2, 12, 'ALTE-295314', 'OTP to verify before register user', '<h4><font style=\"background-color: rgb(181, 214, 165);\" color=\"#003163\">&nbsp;SMS Registration&nbsp;</font></h4><p><font color=\"#c67ba5\" style=\"background-color: rgb(255, 239, 198);\">An otp is sent to</font><span style=\"background-color: rgb(255, 239, 198); color: rgb(198, 123, 165);\">&nbsp;</span><span style=\"background-color: rgb(255, 239, 198); color: rgb(198, 123, 165);\">the phone that you want to register for verification before login</span></p><p><b>The OTP is</b> [~otp~]</p><p>Do not share the <b>OTP</b> with others...</p>', '[\"[~otp~]\"]', 'YES', '2025-06-23 04:17:49', '2025-06-23 04:28:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alert_type`
--

DROP TABLE IF EXISTS `alert_type`;
CREATE TABLE IF NOT EXISTS `alert_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `alert_type`
--

INSERT INTO `alert_type` (`id`, `uniqueId`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ALT-548429', 'Firebase Notification', 'ACTIVE', '2025-06-12 03:59:18', '2025-06-12 04:49:29', NULL),
(2, 'ALTY-756816', 'SMS', 'ACTIVE', '2025-06-12 04:00:48', '2025-06-12 04:49:11', NULL),
(3, 'ALTY-894165', 'Email', 'ACTIVE', '2025-06-12 04:45:10', '2025-06-12 04:49:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assign_broad`
--

DROP TABLE IF EXISTS `assign_broad`;
CREATE TABLE IF NOT EXISTS `assign_broad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `broadTypeId` bigint DEFAULT NULL,
  `propertyTypeId` bigint DEFAULT NULL,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `about` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `default` enum('YES','NO') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `assign_broad`
--

INSERT INTO `assign_broad` (`id`, `broadTypeId`, `propertyTypeId`, `uniqueId`, `about`, `status`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 2, 'PRAB-496704', NULL, 'ACTIVE', 'YES', '2025-06-02 07:28:55', '2025-06-14 00:30:35', NULL),
(4, 1, 2, 'PRAB-519476', NULL, 'ACTIVE', 'NO', '2025-06-02 07:57:41', '2025-06-02 08:48:10', NULL),
(5, 2, 1, 'PRAB-617599', NULL, 'ACTIVE', 'YES', '2025-06-02 07:57:50', '2025-06-14 00:30:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assign_category`
--

DROP TABLE IF EXISTS `assign_category`;
CREATE TABLE IF NOT EXISTS `assign_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `mainCategoryId` bigint DEFAULT NULL,
  `assignBroadId` bigint DEFAULT NULL,
  `broadTypeId` bigint DEFAULT NULL,
  `propertyTypeId` bigint DEFAULT NULL,
  `about` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `default` enum('YES','NO') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `assign_category`
--

INSERT INTO `assign_category` (`id`, `uniqueId`, `mainCategoryId`, `assignBroadId`, `broadTypeId`, `propertyTypeId`, `about`, `status`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PRAC-716149', 4, 4, 1, 2, NULL, 'ACTIVE', 'YES', '2025-06-03 05:49:54', '2025-06-14 00:30:44', NULL),
(2, 'PRAC-778736', 3, 4, 1, 2, NULL, 'ACTIVE', 'NO', '2025-06-03 05:50:54', '2025-06-03 06:38:24', NULL),
(3, 'PRAC-772551', 4, 1, 4, 2, 'Lorem Ipsum is simply dummy', 'ACTIVE', 'YES', '2025-06-03 05:51:13', '2025-06-03 06:50:44', NULL),
(4, 'PRAC-661340', 3, 5, 2, 1, NULL, 'ACTIVE', 'YES', '2025-06-03 05:51:27', '2025-06-05 00:28:28', NULL),
(5, 'PRAC-781591', 4, 5, 2, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries', 'ACTIVE', 'NO', '2025-06-03 05:51:34', '2025-06-03 06:50:36', NULL),
(6, 'PRAC-749029', 1, 1, 4, 2, NULL, 'INACTIVE', 'YES', '2025-06-03 05:51:43', '2025-06-14 00:30:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=Blocked, 1=Active',
  `for` enum('CONTACT','HOME','NA','CONTACT US','ABOUT US','PRIVACY POLICY','TERMS AND CONDITION','RETURN AND REFUND POLICY','PRODUCT','DASHBOARD','CHECKOUT') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`, `status`, `for`, `created_at`, `updated_at`) VALUES
(35, '1695463108_2043220729_1658730163.jfif', '0', 'HOME', '2023-02-25 21:39:26', '2023-11-12 07:44:52'),
(37, '1695463092_1541367142_1970531866.jpg', '0', 'HOME', '2023-09-16 06:52:01', '2023-11-12 07:44:50'),
(38, '1695463077_572258514_1612905629.jpg', '0', 'HOME', '2023-09-16 06:52:07', '2023-11-12 07:44:24'),
(39, '1695462746_982507413_769036380.jfif', '0', 'HOME', '2023-09-16 06:52:14', '2023-11-12 07:44:27'),
(41, '1695477542_1325089053_725530501.jpg', '1', 'ABOUT US', '2023-09-23 09:44:26', '2023-09-23 13:59:02'),
(42, '1695477547_727363441_964057250.jpg', '1', 'PRIVACY POLICY', '2023-09-23 09:44:33', '2023-09-23 13:59:07'),
(43, '1695477531_1919191035_595312217.jpg', '1', 'TERMS AND CONDITION', '2023-09-23 09:44:38', '2023-09-23 13:58:51'),
(44, '1695477526_1730433772_263657228.jpg', '1', 'RETURN AND REFUND POLICY', '2023-09-23 09:46:41', '2023-09-23 13:58:46'),
(48, '1696699846_46386730_1274054550.png', '1', 'PRODUCT', '2023-10-07 17:30:46', '2023-10-07 17:30:46'),
(49, '1696735071_1651208883_930696922.png', '1', 'DASHBOARD', '2023-10-08 03:17:51', '2023-10-08 03:17:51'),
(50, '1697886705_971376575_1048657313.jpg', '1', 'CHECKOUT', '2023-10-21 11:11:45', '2023-10-21 11:11:45'),
(51, '1699774924_235952466_88227185.JPG', '1', 'HOME', '2023-11-12 07:42:04', '2023-11-12 07:42:04'),
(52, '1702184083_581206708_679068616.jpg', '1', 'CONTACT US', '2023-12-10 04:54:43', '2023-12-10 04:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `broad_type`
--

DROP TABLE IF EXISTS `broad_type`;
CREATE TABLE IF NOT EXISTS `broad_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `about` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `broad_type`
--

INSERT INTO `broad_type` (`id`, `uniqueId`, `name`, `about`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PRBT-874234', 'Buy', NULL, 'ACTIVE', '2025-06-02 06:37:46', '2025-06-02 06:37:46', NULL),
(2, 'PRBT-683445', 'Sell', NULL, 'ACTIVE', '2025-06-02 06:38:04', '2025-06-02 06:38:04', NULL),
(3, 'PRBT-384428', 'Rent', NULL, 'ACTIVE', '2025-06-02 06:38:09', '2025-06-02 06:38:09', NULL),
(4, 'PRBT-485124', 'PG', NULL, 'ACTIVE', '2025-06-02 06:38:14', '2025-06-21 14:02:18', NULL),
(5, 'PRBT-365529', 'Rahul Biswas', 'asd', 'INACTIVE', '2025-06-21 14:01:17', '2025-06-21 14:01:31', '2025-06-21 14:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `button`
--

DROP TABLE IF EXISTS `button`;
CREATE TABLE IF NOT EXISTS `button` (
  `id` int NOT NULL AUTO_INCREMENT,
  `btnIcon` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `backColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `textColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `backHoverColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `textHoverColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `btnFor` enum('Add Button','Update Button','Close Button','Save Button','Search Button','Reload Button','NA','Back Button','Print Button','Download Button','Detail Button') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `status` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `button`
--

INSERT INTO `button` (`id`, `btnIcon`, `backColor`, `textColor`, `backHoverColor`, `textHoverColor`, `btnFor`, `status`, `created_at`, `updated_at`) VALUES
(2, 'ion-plus-circled', '81.91520320434088,226.71929371204092,255,1', '29.432784383413512,42.25443558340089,177.47547422136577,1', '38.29472508981187,156.62301935334227,207.98438889639718,1', '206.84599603925435,206.84599603925435,206.84599603925435,1', 'Add Button', '1', '2020-10-25 09:36:48', '2020-11-28 23:38:24'),
(3, 'ti-save', '77.29690279279437,77.29690279279437,77.29690279279437,1', '143.67107832553867,236.67190279279438,1.545276121888795,1', '116.9129603249686,116.9129603249686,116.9129603249686,1', '255,121.54089551620221,121.54089551620221,1', 'Update Button', '1', '2020-10-25 09:36:52', '2020-11-28 23:05:10'),
(4, 'ti-close', '186.58261707850866,13.644193955403054,13.644193955403054,1', '255,255,255,1', '219.36831746782573,61.87523457031282,61.87523457031282,1', '255,255,255,1', 'Close Button', '1', '2020-10-25 09:36:55', '2020-10-30 06:31:51'),
(5, 'ti-save', '75.46572445949113,193.41297422136577,0,1', '0,0,0,1', '69.56269253663102,228.4754603249686,0,1', '255,255,255,1', 'Save Button', '1', '2020-10-25 09:37:07', '2020-10-30 07:56:04'),
(17, 'ti-search', '68.83262901869105,134.50808836619393,184.30583136422294,1', '255,255,255,1', '66.81990820596474,117.2851711356964,131.71206746782576,1', '255,255,255,1', 'Search Button', '1', '2020-10-25 22:52:10', '2020-10-27 11:22:20'),
(18, 'ti-reload', '102.13420025307266,68.83262901869105,184.30583136422294,1', '255,255,255,1', '85.88195877108421,66.81990820596474,131.71206746782576,1', '255,255,255,1', 'Reload Button', '1', '2020-10-25 22:52:14', '2020-10-30 02:48:18'),
(45, 'ti-arrow-left', '60.12887598202242,106.89511707850863,41.6669255434913,1', '52.27922434769856,255,125.22237087515114,1', '84.62142072405135,66,90,1', '148.84596325098255,157.6921329800673,255,1', 'Back Button', '1', '2020-10-30 06:46:36', '2021-05-02 07:40:05'),
(46, 'md md-local-print-shop', '60.12887598202242,106.89511707850863,41.6669255434913,1', '52.27922434769856,255,125.22237087515114,1', '84.62142072405135,66,90,1', '148.84596325098255,157.6921329800673,255,1', 'Print Button', '1', '2020-10-30 06:46:36', '2021-05-02 07:40:05'),
(47, 'md md-file-download', '60.12887598202242,106.89511707850863,41.6669255434913,1', '52.27922434769856,255,125.22237087515114,1', '84.62142072405135,66,90,1', '148.84596325098255,157.6921329800673,255,1', 'Download Button', '1', '2020-10-30 06:46:36', '2021-05-02 07:40:05'),
(48, 'md md-visibility', '60.12887598202242,106.89511707850863,41.6669255434913,1', '52.27922434769856,255,125.22237087515114,1', '84.62142072405135,66,90,1', '148.84596325098255,157.6921329800673,255,1', 'Detail Button', '1', '2020-10-30 06:46:36', '2021-05-02 07:40:05');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `googleMap` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `address`, `email`, `phone`, `googleMap`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Andul Mouri, Andul, Howrah, West Bengal 711302', 'info@unicorngroups.co.in', '7003619844', '<iframe class=\"w-100\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d805184.6320105711!2d144.49269039866502!3d-37.971237001538135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad646b5d2ba4df7%3A0x4045675218ccd90!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sin!4v1654250375825!5m2!1sen!2sin\" height=\"450\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'NA', NULL, '2023-09-26 09:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `contact_enquiry`
--

DROP TABLE IF EXISTS `contact_enquiry`;
CREATE TABLE IF NOT EXISTS `contact_enquiry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `phone` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `contact_enquiry`
--

INSERT INTO `contact_enquiry` (`id`, `name`, `email`, `phone`, `content`, `created_at`, `updated_at`) VALUES
(5, 'asdsad', 'asd@asd.asd', '1231231231', 'asd', '2023-02-12 11:21:16', '2023-02-12 11:21:16'),
(6, 'Nishant Sharma', 'nishant.developer22@gmail.com', '1201201200', 'Hi kisalayakgschool.com,\r\n\r\nI am Nishant,  Do you want to build your online business and need a great website?\r\n\r\nWe offer comprehensive solutions at a reasonable price.\r\n\r\nWeb design and development (E-Commerce Website, Magneto, Word Press, CI, Laravel, Core PHP) etc.\r\n\r\nIf interested. May I send you a package/proposal?\r\n\r\nThanks & Regards,\r\nNishant', '2023-02-28 00:49:09', '2023-02-28 00:49:09'),
(7, 'aa', 'asd@gmail.com', '1231232131', 'asd', '2023-09-23 12:27:52', '2023-09-23 12:27:52'),
(8, 'Nishant Sharma', 'nishant.developer22@gmail.com', '1234567890', 'Hi team unicorncomputech.com\r\n\r\nI was just browsing your website and I came up with a great plan to re-develop your website using the latest technology.\r\n\r\nI\'m an excellent web developer capable of almost anything you can come up with, and my costs are affordable for nearly everyone.\r\n\r\nLet me know your WhatsApp/Call, contact number for further conversation.\r\n\r\nThanks in advance,\r\nNishant (Website Optimization Expert)', '2023-10-11 22:21:25', '2023-10-11 22:21:25'),
(9, 'Harvey Miller', 'harvey.web4@gmail.com', '8456404550', 'Hello,\n\nYour website is facing critical SEO (Search Engine Optimization) issues, causing it to be invisible on major search engines like Google, Bing, Safari etc. As it\'s simple fix, we can resolve it for you. If this business is a priority for you, please share your \"phone number\" and a suitable time for a call, so that we can discuss more about the same in depth and get it fixed on a high priority basis.\n\nBest regards,\nHarvey Miller', '2023-11-10 22:45:16', '2023-11-10 22:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loader`
--

DROP TABLE IF EXISTS `loader`;
CREATE TABLE IF NOT EXISTS `loader` (
  `id` int NOT NULL AUTO_INCREMENT,
  `raw` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `loaderType` enum('NA','Html, Css, Js Combine Loader','Image Type Loader','Video Type Loader') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `pageLoader` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `internalLoader` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `loader`
--

INSERT INTO `loader` (`id`, `raw`, `image`, `loaderType`, `pageLoader`, `internalLoader`, `created_at`, `updated_at`) VALUES
(29, '{\"html\":\"<div class=\\\"loading\\\">\\r\\n        <ul>\\r\\n            <li><\\/li>\\r\\n            <li><\\/li>\\r\\n            <li><\\/li>\\r\\n            <li><\\/li>\\r\\n            <li><\\/li>\\r\\n            <li><\\/li>\\r\\n            <li><\\/li>\\r\\n        <\\/ul>\\r\\n    <\\/div>\",\"css\":\"#pageLoader {\\r\\n            margin: 0;\\r\\n            padding: 0;\\r\\n            background: #f3f3f3;\\r\\n            position: fixed;\\r\\n            left: 0;\\r\\n            top: 0;\\r\\n            width: 100%;\\r\\n            height: 100vh;\\r\\n        }\\r\\n\\r\\n        #pageLoader .loading {\\r\\n            position: absolute;\\r\\n            top: 40%;\\r\\n            left: 50%;\\r\\n            transform: translate(-50%, -50%);\\r\\n        }\\r\\n\\r\\n        #pageLoader ul {\\r\\n            margin: 0;\\r\\n            padding: 0;\\r\\n            position: relative;\\r\\n            width: 400px;\\r\\n            height: 240px;\\r\\n            overflow: hidden;\\r\\n            border-bottom: 1px solid rgba(0, 0, 0, .2);\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li {\\r\\n            list-style: none;\\r\\n            border-radius: 50%;\\r\\n            border: 15px solid #000;\\r\\n            position: absolute;\\r\\n            top: 100%;\\r\\n            left: 50%;\\r\\n            border-bottom-color: transparent !important;\\r\\n            border-left-color: transparent !important;\\r\\n            box-shadow: 0 0 10px rgba(0, 0, 0, .5);\\r\\n            animation: pageLoaderAnimate 5s infinite alternate;\\r\\n            transform: translate(-50%, -50%);\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(1) {\\r\\n            width: 60px;\\r\\n            height: 60px;\\r\\n            border-color: #FF0000;\\r\\n            animation-delay: .2s;\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(2) {\\r\\n            width: 90px;\\r\\n            height: 90px;\\r\\n            border-color: #FF7F00;\\r\\n            animation-delay: .4s;\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(3) {\\r\\n            width: 120px;\\r\\n            height: 120px;\\r\\n            border-color: #FFFF00;\\r\\n            animation-delay: .6s;\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(4) {\\r\\n            width: 150px;\\r\\n            height: 150px;\\r\\n            border-color: #00FF00;\\r\\n            animation-delay: .8s;\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(5) {\\r\\n            width: 180px;\\r\\n            height: 180px;\\r\\n            border-color: #0000FF;\\r\\n            animation-delay: 1s;\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(6) {\\r\\n            width: 210px;\\r\\n            height: 210px;\\r\\n            border-color: #4B0082;\\r\\n            animation-delay: 1.2s;\\r\\n        }\\r\\n\\r\\n        #pageLoader ul li:nth-child(7) {\\r\\n            width: 240px;\\r\\n            height: 240px;\\r\\n            border-color: #9400D3;\\r\\n            animation-delay: 1.4s;\\r\\n        }\\r\\n\\r\\n        @keyframes pageLoaderAnimate {\\r\\n            0% {\\r\\n                transform: translate(-50%, -50%) rotate(-45deg);\\r\\n            }\\r\\n\\r\\n            100% {\\r\\n                transform: translate(-50%, -50%) rotate(315deg);\\r\\n            }\\r\\n        }\",\"js\":null}', 'NA', 'Html, Css, Js Combine Loader', '1', '0', '2020-12-14 23:35:58', '2021-08-02 23:58:10'),
(41, '{\"html\":\"<div class=\\\"loading\\\">\\r\\n        <span><\\/span>\\r\\n        <span><\\/span>\\r\\n        <span><\\/span>\\r\\n    <\\/div>\",\"css\":\"#internalLoader {\\r\\n            margin: 0;\\r\\n        padding: 0;\\r\\n        background: #f3f3f3;\\r\\n        position: fixed;\\r\\n        left: 0;\\r\\n        z-index: 99999;\\r\\n        top: 0;\\r\\n        width: 100%;\\r\\n        height: 100vh;\\r\\n        }\\r\\n\\r\\n        #internalLoader .loading {\\r\\n            position: absolute;\\r\\n            top: 50%;\\r\\n            transform: translateY(-50%);\\r\\n            width: 100%;\\r\\n            height: 10px;\\r\\n            text-align: center;\\r\\n        }\\r\\n\\r\\n        #internalLoader .loading span {\\r\\n            width: 10px;\\r\\n            height: 10px;\\r\\n            background: #fff;\\r\\n            display: inline-block;\\r\\n            border-radius: 50%;\\r\\n            animation: internalLoaderAnimate 2s linear infinite;\\r\\n            opacity: 0;\\r\\n        }\\r\\n\\r\\n        #internalLoader .loading span:nth-child(1) {\\r\\n            animation-delay: 0.8s;\\r\\n            background: #00c2ff;\\r\\n        }\\r\\n\\r\\n        #internalLoader .loading span:nth-child(2) {\\r\\n            animation-delay: 0.4s;\\r\\n            background: #ffe837;\\r\\n        }\\r\\n\\r\\n        #internalLoader .loading span:nth-child(3) {\\r\\n            animation-delay: 0s;\\r\\n            background: #ff1b78;\\r\\n        }\\r\\n\\r\\n        @keyframes internalLoaderAnimate {\\r\\n            0% {\\r\\n                transform: translateX(-100px);\\r\\n                opacity: 0;\\r\\n            }\\r\\n\\r\\n            10% {\\r\\n                transform: translateX(-100px);\\r\\n                opacity: 0;\\r\\n            }\\r\\n\\r\\n            25% {\\r\\n                transform: translateX(0px);\\r\\n                opacity: 1;\\r\\n            }\\r\\n\\r\\n            50% {\\r\\n                transform: translateX(0px);\\r\\n                opacity: 1;\\r\\n            }\\r\\n\\r\\n            75% {\\r\\n                transform: translateX(0px);\\r\\n                opacity: 1;\\r\\n            }\\r\\n\\r\\n            100% {\\r\\n                transform: translateX(100px);\\r\\n                opacity: 0;\\r\\n            }\\r\\n\\r\\n            90% {\\r\\n                transform: translateX(100px);\\r\\n                opacity: 0;\\r\\n            }\\r\\n        }\",\"js\":null}', 'NA', 'Html, Css, Js Combine Loader', '0', '1', '2020-12-19 05:21:28', '2021-08-03 00:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

DROP TABLE IF EXISTS `logo`;
CREATE TABLE IF NOT EXISTS `logo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) COLLATE utf16_unicode_ci NOT NULL DEFAULT 'NA',
  `bigLogo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `smallLogo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `favicon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `default` enum('YES','NO','NA') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id`, `uniqueId`, `bigLogo`, `smallLogo`, `favicon`, `default`, `created_at`, `updated_at`) VALUES
(36, 'LOGO-437391', '1749620750_1749600000_943230790.jpeg', '1749620750_1749600000_1587168353.PNG', '1749620750_1749600000_1205998357.PNG', 'YES', '2025-06-11 00:15:50', '2025-06-14 00:27:46'),
(33, 'LOGO-558335', '1748526838_1748476800_2038979315.jpg', '1748525949_1748476800_778908277.jpg', '1748509152_1748476800_940530459.jpg', 'NO', '2025-05-29 03:29:12', '2025-06-14 00:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `log_site_visit`
--

DROP TABLE IF EXISTS `log_site_visit`;
CREATE TABLE IF NOT EXISTS `log_site_visit` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `country` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `ip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `url` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `platform` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `visitTo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `browserName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `browserVersion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `browserInfo` json DEFAULT NULL,
  `locationInfo` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `log_site_visit`
--

INSERT INTO `log_site_visit` (`id`, `country`, `state`, `city`, `ip`, `url`, `platform`, `visitTo`, `browserName`, `browserVersion`, `browserInfo`, `locationInfo`, `created_at`, `updated_at`) VALUES
(1, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 13:36:49', '2025-07-09 13:36:49'),
(2, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 13:37:38', '2025-07-09 13:37:38'),
(3, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 13:37:57', '2025-07-09 13:37:57'),
(4, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 13:45:02', '2025-07-09 13:45:02'),
(5, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 13:45:27', '2025-07-09 13:45:27'),
(6, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 13:45:50', '2025-07-09 13:45:50'),
(7, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 15:36:11', '2025-07-09 15:36:11'),
(8, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 15:39:58', '2025-07-09 15:39:58'),
(9, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 15:45:16', '2025-07-09 15:45:16'),
(10, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 15:48:39', '2025-07-09 15:48:39'),
(11, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 15:51:02', '2025-07-09 15:51:02'),
(12, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin/dashboard-related/dashboard/quick-overview', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:13:33', '2025-07-09 16:13:33'),
(13, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:13:33', '2025-07-09 16:13:33'),
(14, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin/check-login', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:13:45', '2025-07-09 16:13:45'),
(15, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:13:48', '2025-07-09 16:13:48'),
(16, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin/dashboard-related/dashboard/quick-overview', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:13:49', '2025-07-09 16:13:49'),
(17, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:17:36', '2025-07-09 16:17:36'),
(18, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:21:50', '2025-07-09 16:21:50'),
(19, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:24:41', '2025-07-09 16:24:41'),
(20, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:25:52', '2025-07-09 16:25:52'),
(21, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:48:14', '2025-07-09 16:48:14'),
(22, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:49:46', '2025-07-09 16:49:46'),
(23, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:53:58', '2025-07-09 16:53:58'),
(24, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:54:40', '2025-07-09 16:54:40'),
(25, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:55:42', '2025-07-09 16:55:42'),
(26, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:56:18', '2025-07-09 16:56:18'),
(27, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:56:46', '2025-07-09 16:56:46'),
(28, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 16:57:57', '2025-07-09 16:57:57'),
(29, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:00:30', '2025-07-09 17:00:30'),
(30, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:00:50', '2025-07-09 17:00:50'),
(31, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"2ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:01:45', '2025-07-09 17:01:45'),
(32, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:03:19', '2025-07-09 17:03:19'),
(33, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:03:40', '2025-07-09 17:03:40'),
(34, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:03:59', '2025-07-09 17:03:59'),
(35, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:05:48', '2025-07-09 17:05:48'),
(36, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:06:10', '2025-07-09 17:06:10'),
(37, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:07:24', '2025-07-09 17:07:24'),
(38, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:19:07', '2025-07-09 17:19:07'),
(39, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:19:31', '2025-07-09 17:19:31'),
(40, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:27:19', '2025-07-09 17:27:19'),
(41, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:28:58', '2025-07-09 17:28:58');
INSERT INTO `log_site_visit` (`id`, `country`, `state`, `city`, `ip`, `url`, `platform`, `visitTo`, `browserName`, `browserVersion`, `browserInfo`, `locationInfo`, `created_at`, `updated_at`) VALUES
(42, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:29:49', '2025-07-09 17:29:49'),
(43, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:30:12', '2025-07-09 17:30:12'),
(44, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:30:43', '2025-07-09 17:30:43'),
(45, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-09 17:47:16', '2025-07-09 17:47:16'),
(46, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 04:48:09', '2025-07-10 04:48:09'),
(47, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 04:48:27', '2025-07-10 04:48:27'),
(48, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 04:51:20', '2025-07-10 04:51:20'),
(49, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 04:51:28', '2025-07-10 04:51:28'),
(50, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:01:03', '2025-07-10 05:01:03'),
(51, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:01:31', '2025-07-10 05:01:31'),
(52, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin/dashboard-related/dashboard/quick-overview', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:06:40', '2025-07-10 05:06:40'),
(53, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:06:41', '2025-07-10 05:06:41'),
(54, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:07:20', '2025-07-10 05:07:20'),
(55, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin/auth-profile/edit', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:07:31', '2025-07-10 05:07:31'),
(56, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/admin', 'windows', 'admin', 'Google Chrome', '138.0.0.0', '{\"name\": \"Google Chrome\", \"pattern\": \"#(?<browser>Version|Chrome|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"138.0.0.0\", \"platform\": \"windows\", \"userAgent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:07:31', '2025-07-10 05:07:31'),
(57, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 05:32:52', '2025-07-10 05:32:52'),
(58, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 09:09:34', '2025-07-10 09:09:34'),
(59, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"0ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 09:10:05', '2025-07-10 09:10:05'),
(60, 'India', 'West Bengal', 'Siliguri', '49.47.153.94', 'http://localhost/LARAVEL/AdminSetup/api/test-case/upload-file', 'postman', 'api', 'Postman Runtime', '?', '{\"name\": \"Postman Runtime\", \"pattern\": \"#(?<browser>Version|Postman|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#\", \"version\": \"?\", \"platform\": \"postman\", \"userAgent\": \"PostmanRuntime/7.44.1\"}', '{\"city\": \"Siliguri\", \"inEU\": \"0\", \"delay\": \"1ms\", \"credit\": \"Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href=\'https://www.maxmind.com\'>https://www.maxmind.com</a>.\", \"region\": \"West Bengal\", \"status\": \"200\", \"dmaCode\": [], \"request\": \"49.47.153.94\", \"areaCode\": [], \"latitude\": \"26.7084\", \"timezone\": \"Asia/Kolkata\", \"euVATrate\": [], \"longitude\": \"88.4318\", \"regionCode\": \"WB\", \"regionName\": \"West Bengal\", \"countryCode\": \"IN\", \"countryName\": \"India\", \"currencyCode\": \"INR\", \"continentCode\": \"AS\", \"continentName\": \"Asia\", \"currencySymbol\": [], \"currencyConverter\": \"86.4987\", \"currencySymbol_UTF8\": [], \"locationAccuracyRadius\": \"500\"}', '2025-07-10 09:48:58', '2025-07-10 09:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `main_nav`
--

DROP TABLE IF EXISTS `main_nav`;
CREATE TABLE IF NOT EXISTS `main_nav` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `navTypeId` bigint DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `lastSegment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `access` json DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_nav`
--

INSERT INTO `main_nav` (`id`, `uniqueId`, `navTypeId`, `name`, `icon`, `route`, `lastSegment`, `description`, `access`, `status`, `position`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'NM-124127', 1, 'Dashboard', 'ri-dashboard-2-line', 'dashboard-related/dashboard', 'dashboard', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', NULL, 'ACTIVE', 1, '2024-08-07 04:50:28', '2025-06-11 08:50:44', NULL),
(29, 'NM-271623', 36, 'Property Related', 'mdi mdi-crane', 'category-attributes-type/property-related', 'property-related', 'NA', NULL, 'ACTIVE', 5, '2025-05-29 23:40:37', '2025-06-11 08:35:40', NULL),
(30, 'NM-334896', 2, 'Role & Permission', 'ri-apps-2-line', 'admin-related/role-permission', 'role-permission', 'NA', NULL, 'ACTIVE', 3, '2025-06-09 22:05:13', '2025-06-11 08:35:38', NULL),
(25, 'NM-332277', 35, 'Manage Users', 'bx bxs-user-account', 'users-related/manage-users', 'manage-users', 'NA', NULL, 'ACTIVE', 2, '2025-05-19 21:10:37', '2025-06-11 08:35:42', NULL),
(32, 'NM-810930', 2, 'Quick Setting', 'ri-apps-2-line', 'admin-related/quick-setting', 'quick-setting', 'NA', NULL, 'ACTIVE', 6, '2025-06-10 23:59:06', '2025-06-11 08:35:27', NULL),
(31, 'NM-515634', 2, 'Navigation & Access', 'las la-user-tie', 'admin-related/navigation-access', 'navigation-access', 'NA', NULL, 'ACTIVE', 4, '2025-06-09 22:06:04', '2025-06-11 08:35:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_role`
--

DROP TABLE IF EXISTS `main_role`;
CREATE TABLE IF NOT EXISTS `main_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_role`
--

INSERT INTO `main_role` (`id`, `uniqueId`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'RM-500077', 'Super Admin', 'This is super admin which access only have to dveloper', 'ACTIVE', '2025-04-10 03:01:35', '2025-04-10 07:32:11', NULL),
(3, 'RM-417362', 'Admin', 'NA', 'ACTIVE', '2025-04-10 03:01:50', '2025-05-23 23:40:56', NULL),
(4, 'RM-842521', 'Sub Admin', 'lol', 'ACTIVE', '2025-04-10 05:15:49', '2025-06-08 22:08:03', NULL),
(10, 'RM-836120', 'a', 's', 'ACTIVE', '2025-06-21 14:24:21', '2025-06-21 14:25:53', '2025-06-21 14:25:53'),
(9, 'RM-694329', 'a', 'd', 'ACTIVE', '2025-06-21 14:20:46', '2025-06-21 14:20:53', '2025-06-21 14:20:53'),
(11, 'RM-354241', 'da', 'das', 'ACTIVE', '2025-06-21 14:25:27', '2025-06-21 14:25:50', '2025-06-21 14:25:50'),
(12, 'RM-646856', 'd', 'd', 'ACTIVE', '2025-06-21 14:36:10', '2025-06-21 14:36:14', '2025-06-21 14:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `manage_category`
--

DROP TABLE IF EXISTS `manage_category`;
CREATE TABLE IF NOT EXISTS `manage_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mainCategoryId` bigint DEFAULT NULL,
  `subCategoryId` bigint DEFAULT NULL,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `about` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `type` enum('MAIN','SUB','NESTED','NA') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `manage_category`
--

INSERT INTO `manage_category` (`id`, `mainCategoryId`, `subCategoryId`, `uniqueId`, `name`, `about`, `status`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'PRMC-234328', 'Category One', NULL, 'ACTIVE', 'MAIN', '2025-06-03 03:48:01', '2025-06-03 03:48:01', NULL),
(2, NULL, NULL, 'PRMC-161056', 'Category Two', NULL, 'ACTIVE', 'MAIN', '2025-06-03 03:48:13', '2025-06-04 21:00:05', NULL),
(3, NULL, NULL, 'PRMC-351010', 'Category Three', 'Lorem Ipsum is simply dummy', 'ACTIVE', 'MAIN', '2025-06-03 03:48:19', '2025-06-03 03:53:01', NULL),
(4, NULL, NULL, 'PRMC-948449', 'Category Four', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries', 'ACTIVE', 'MAIN', '2025-06-03 03:48:34', '2025-06-05 00:18:28', NULL),
(26, 20, 21, 'PRMC-727785', 'Nox Four', 'asa', 'ACTIVE', 'NESTED', '2025-06-04 21:39:15', '2025-06-05 00:20:28', NULL),
(25, 20, 21, 'PRMC-138590', 'Nox Three', NULL, 'ACTIVE', 'NESTED', '2025-06-04 21:38:59', '2025-06-04 21:38:59', NULL),
(24, 20, 22, 'PRMC-387875', 'Nox Two', NULL, 'ACTIVE', 'NESTED', '2025-06-04 21:38:49', '2025-06-05 00:15:38', NULL),
(23, 20, 22, 'PRMC-939650', 'Nox One', NULL, 'ACTIVE', 'NESTED', '2025-06-04 21:38:40', '2025-06-05 00:15:38', NULL),
(22, 20, NULL, 'PRMC-581383', 'Light Two', 'dfds', 'ACTIVE', 'SUB', '2025-06-04 21:38:26', '2025-06-05 00:15:38', NULL),
(21, 20, NULL, 'PRMC-409785', 'Light One', NULL, 'ACTIVE', 'SUB', '2025-06-04 21:38:17', '2025-06-04 23:32:24', NULL),
(20, NULL, NULL, 'PRMC-486497', 'Test One', 'asd', 'ACTIVE', 'MAIN', '2025-06-04 21:37:57', '2025-06-21 15:31:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_28_081518_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nav_type`
--

DROP TABLE IF EXISTS `nav_type`;
CREATE TABLE IF NOT EXISTS `nav_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `lastSegment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nav_type`
--

INSERT INTO `nav_type` (`id`, `uniqueId`, `name`, `route`, `lastSegment`, `icon`, `description`, `status`, `position`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'NT-841206', 'Dashboard Related', 'dashboard-related', 'dashboard-related', 'ri-dashboard-2-line', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing ublishing software', 'ACTIVE', 1, '2024-08-07 04:21:05', '2025-06-11 08:50:25', NULL),
(2, 'NT-549934', 'Admin Related', 'admin-related', 'admin-related', 'las la-hat-cowboy-side', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently', 'ACTIVE', 3, '2024-08-07 04:21:10', '2025-06-15 03:23:05', NULL),
(35, 'NT-162469', 'Users Related', 'users-related', 'users-related', 'las la-user-tie', 'NA', 'ACTIVE', 2, '2025-05-09 08:24:38', '2025-06-15 03:23:18', NULL),
(36, 'NT-533251', 'Category & Attributes & type', 'category-attributes-type', 'category-attributes-type', 'NA', 'NA', 'ACTIVE', 4, '2025-05-29 22:58:41', '2025-06-11 08:30:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nested_nav`
--

DROP TABLE IF EXISTS `nested_nav`;
CREATE TABLE IF NOT EXISTS `nested_nav` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `navTypeId` bigint DEFAULT NULL,
  `mainNavId` bigint DEFAULT NULL,
  `subNavId` bigint DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `access` json DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `lastSegment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nested_nav`
--

INSERT INTO `nested_nav` (`id`, `uniqueId`, `navTypeId`, `mainNavId`, `subNavId`, `name`, `icon`, `description`, `access`, `route`, `lastSegment`, `status`, `position`, `created_at`, `updated_at`, `deleted_at`) VALUES
(47, 'NN-280341', 2, 32, 38, 'Alert For', 'aa', 'NA', NULL, 'admin-related/quick-setting/customized-alert/alert-for', 'alert-for', 'ACTIVE', 13, '2025-06-12 03:01:00', '2025-06-12 03:01:00', NULL),
(48, 'NN-735510', 2, 32, 38, 'Alert Template', 'aa', 'NA', NULL, 'admin-related/quick-setting/customized-alert/alert-template', 'alert-template', 'ACTIVE', 14, '2025-06-12 03:03:01', '2025-06-12 03:03:01', NULL),
(46, 'NN-758726', 2, 32, 38, 'Alert Type', 'na', 'NA', NULL, 'admin-related/quick-setting/customized-alert/alert-type', 'alert-type', 'ACTIVE', 12, '2025-06-12 03:00:43', '2025-06-12 03:00:43', NULL),
(34, 'NN-337728', 36, 29, 32, 'Broad Type', 'NA', 'NA', '{\"add\": true, \"set\": false, \"back\": false, \"edit\": false, \"info\": false, \"save\": false, \"close\": false, \"other\": false, \"reset\": false, \"access\": false, \"delete\": false, \"detail\": false, \"filter\": false, \"reload\": false, \"search\": false, \"status\": false, \"update\": false, \"default\": false, \"permission\": false}', 'category-attributes-type/property-related/manage-broad/broad-type', 'broad-type', 'ACTIVE', 7, '2025-06-02 03:04:59', '2025-06-11 08:47:31', NULL),
(35, 'NN-977889', 36, 29, 32, 'Assign Broad', 'NA', 'NA', NULL, 'category-attributes-type/property-related/manage-broad/assign-broad', 'assign-broad', 'ACTIVE', 8, '2025-06-02 05:30:28', '2025-06-11 08:47:25', NULL),
(36, 'NN-856688', 36, 29, 30, 'Manage Category', 'NA', 'NA', NULL, 'category-attributes-type/property-related/property-category/manage-category', 'manage-category', 'ACTIVE', 9, '2025-06-02 22:59:01', '2025-06-11 08:47:21', NULL),
(38, 'NN-880792', 36, 29, 30, 'Assign Category', 'NA', 'NA', '{\"add\": true, \"set\": false, \"back\": false, \"edit\": true, \"info\": true, \"save\": false, \"close\": false, \"other\": false, \"reset\": false, \"access\": false, \"delete\": true, \"detail\": false, \"filter\": false, \"reload\": false, \"search\": false, \"status\": true, \"update\": false, \"default\": false, \"permission\": false}', 'category-attributes-type/property-related/property-category/assign-category', 'assign-category', 'ACTIVE', 10, '2025-06-03 00:06:12', '2025-06-11 08:47:16', NULL),
(39, 'NN-465544', 2, 30, 33, 'Main Role', 'NA', 'NA', NULL, 'admin-related/role-permission/manage-role/main-role', 'main-role', 'ACTIVE', 1, '2025-06-09 22:08:40', '2025-06-11 08:47:12', NULL),
(40, 'NN-620521', 2, 30, 33, 'Sub Role', 'NA', 'NA', NULL, 'admin-related/role-permission/manage-role/sub-role', 'sub-role', 'ACTIVE', 2, '2025-06-09 22:09:00', '2025-06-11 08:47:07', NULL),
(41, 'NN-860240', 2, 31, 35, 'Nav Type', 'NA', 'NA', NULL, 'admin-related/navigation-access/manage-side-nav/nav-type', 'nav-type', 'ACTIVE', 3, '2025-06-10 04:39:56', '2025-06-11 08:47:04', NULL),
(42, 'NN-332143', 2, 31, 35, 'Main Nav', 'NA', 'NA', NULL, 'admin-related/navigation-access/manage-side-nav/main-nav', 'main-nav', 'ACTIVE', 4, '2025-06-10 04:40:17', '2025-06-11 08:46:59', NULL),
(43, 'NN-391247', 2, 31, 35, 'Sub Nav', 'NA', 'NA', NULL, 'admin-related/navigation-access/manage-side-nav/sub-nav', 'sub-nav', 'ACTIVE', 5, '2025-06-10 04:40:45', '2025-06-11 08:46:55', NULL),
(44, 'NN-444821', 2, 31, 35, 'Nested Nav', 'NA', 'NA', NULL, 'admin-related/navigation-access/manage-side-nav/nested-nav', 'nested-nav', 'ACTIVE', 6, '2025-06-10 04:41:01', '2025-06-11 06:53:37', NULL),
(45, 'NN-648526', 2, 32, 37, 'Logo', 'na', 'NA', NULL, 'admin-related/quick-setting/site-setting/logo', 'logo', 'ACTIVE', 11, '2025-06-11 00:09:45', '2025-06-11 08:46:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('797e9cd4-d833-433a-97e8-31a911c31c90', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"Rahul Biswas has scheduled a session with you\",\"userId\":180,\"userIdBy\":180,\"date\":\"02-12-2023 03:04 PM\",\"deviceToken\":null,\"deviceType\":\"NA\",\"type\":\"CreateBooking\"}', NULL, '2023-12-02 09:34:54', '2023-12-07 10:50:29'),
('406fc1cf-6f89-46eb-b4cb-ee538821ab13', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"Aamit has scheduled a session with you\",\"userId\":1,\"userIdBy\":1,\"date\":\"02-12-2023 03:06 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"CreateBooking\"}', '2023-12-07 10:50:29', '2023-12-02 09:36:06', '2023-12-07 10:50:29'),
('fedd16f2-46a1-43b9-a6e5-2ad15007af5d', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"02-12-2023 03:08 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-02 10:23:30', '2023-12-02 09:38:39', '2023-12-02 10:23:30'),
('86270f09-a1dc-4fd0-84eb-49faf4a8f296', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"02-12-2023 03:13 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', NULL, '2023-12-02 09:43:06', '2023-12-07 10:31:59'),
('3881c693-9a18-43c5-8090-2126e1c6c859', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"02-12-2023 03:13 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', NULL, '2023-12-02 09:43:20', '2023-12-02 10:14:27'),
('bf83a9b5-33e9-4338-a98b-bb8f98f404b5', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"02-12-2023 03:17 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-02 10:23:30', '2023-12-02 09:47:29', '2023-12-02 10:23:30'),
('05b7bb1b-bb7d-4baf-96d6-fb79d377ce1c', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"02-12-2023 03:19 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-02 10:23:45', '2023-12-02 09:49:12', '2023-12-02 10:23:45'),
('4ec2d0c3-7bfb-48c6-b76e-fa4083194286', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"02-12-2023 03:19 PM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', NULL, '2023-12-02 09:49:46', '2023-12-07 10:31:59'),
('38e0f135-616b-47f8-bc72-a7683c4fa273', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"03-12-2023 09:33 AM\",\"deviceToken\":\"adhasdhas\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-07 06:29:45', '2023-12-03 04:03:45', '2023-12-07 06:29:45'),
('687b4a67-372b-47ad-82a7-756131c306d8', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"03-12-2023 09:36 AM\",\"deviceToken\":\"dKfbgx1pTMGDtj1sneScKx:APA91bG4Ec_vauSbdn4M4qCdVMlJGMxO3DsNLdmFyGRbKLcASnBkvmZKto6FisjHWTg_ld23rPpuxe4ujo7g7aJosbdYbck5-Yw7EUbpk98drawMvVSHxVXZyxXCqQTunsGRYDr8zPbL\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-07 10:31:59', '2023-12-03 04:06:16', '2023-12-07 10:31:59'),
('b6e1ef86-0f2c-4321-9c19-86f7f6f55f4e', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"03-12-2023 09:43 AM\",\"deviceToken\":\"dKfbgx1pTMGDtj1sneScKx:APA91bG4Ec_vauSbdn4M4qCdVMlJGMxO3DsNLdmFyGRbKLcASnBkvmZKto6FisjHWTg_ld23rPpuxe4ujo7g7aJosbdYbck5-Yw7EUbpk98drawMvVSHxVXZyxXCqQTunsGRYDr8zPbL\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-07 06:29:45', '2023-12-03 04:13:12', '2023-12-07 06:29:45'),
('879d147e-3f65-4323-be70-769255320984', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"03-12-2023 09:44 AM\",\"deviceToken\":\"dKfbgx1pTMGDtj1sneScKx:APA91bG4Ec_vauSbdn4M4qCdVMlJGMxO3DsNLdmFyGRbKLcASnBkvmZKto6FisjHWTg_ld23rPpuxe4ujo7g7aJosbdYbck5-Yw7EUbpk98drawMvVSHxVXZyxXCqQTunsGRYDr8zPbL\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', NULL, '2023-12-03 04:14:15', '2023-12-07 10:31:59'),
('b868060c-76a8-4b4b-a485-b99813613e1a', 'App\\Notifications\\NotifyUser', 'App\\Models\\User', 1, '{\"title\":\"New Booking\",\"msg\":\"A new order has created by Rahul Biswas\",\"userId\":1,\"date\":\"03-12-2023 09:45 AM\",\"deviceToken\":\"dKfbgx1pTMGDtj1sneScKx:APA91bG4Ec_vauSbdn4M4qCdVMlJGMxO3DsNLdmFyGRbKLcASnBkvmZKto6FisjHWTg_ld23rPpuxe4ujo7g7aJosbdYbck5-Yw7EUbpk98drawMvVSHxVXZyxXCqQTunsGRYDr8zPbL\",\"deviceType\":\"Android\",\"type\":\"create_order\"}', '2023-12-07 06:29:45', '2023-12-03 04:15:57', '2023-12-07 06:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) COLLATE utf16_unicode_ci NOT NULL DEFAULT 'NA',
  `mainRoleId` int DEFAULT NULL,
  `subRoleId` int DEFAULT NULL,
  `navTypeId` int DEFAULT NULL,
  `mainNavId` int DEFAULT NULL,
  `subNavId` int DEFAULT NULL,
  `nestedNavId` int DEFAULT NULL,
  `privilege` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `uniqueId`, `mainRoleId`, `subRoleId`, `navTypeId`, `mainNavId`, `subNavId`, `nestedNavId`, `privilege`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PER-115876', 4, NULL, 1, 1, 2, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": true}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": true, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": true, \"permission\": false}, \"filter\": {\"allowed\": true, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(2, 'PER-158598', 4, NULL, 1, 1, 1, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": true, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": true, \"permission\": false}, \"filter\": {\"allowed\": true, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(3, 'PER-518775', 4, NULL, 35, 25, 20, NULL, '{\"add\": {\"allowed\": true, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": true, \"permission\": false}, \"edit\": {\"allowed\": true, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": false}, \"save\": {\"allowed\": true, \"permission\": false}, \"close\": {\"allowed\": true, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": true, \"permission\": false}, \"detail\": {\"allowed\": true, \"permission\": false}, \"filter\": {\"allowed\": true, \"permission\": false}, \"reload\": {\"allowed\": true, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": true, \"permission\": false}, \"update\": {\"allowed\": true, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(4, 'PER-820444', 4, NULL, 2, 30, 33, 39, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(5, 'PER-582992', 4, NULL, 2, 30, 33, 40, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(6, 'PER-448583', 4, NULL, 2, 30, 34, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(7, 'PER-518323', 4, NULL, 2, 31, 35, 41, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(8, 'PER-791264', 4, NULL, 2, 31, 35, 42, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(9, 'PER-635174', 4, NULL, 2, 31, 35, 43, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(10, 'PER-548100', 4, NULL, 2, 31, 35, 44, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(11, 'PER-301251', 4, NULL, 2, 31, 36, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(12, 'PER-405559', 4, NULL, 2, 32, 37, 45, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(13, 'PER-615148', 4, NULL, 2, 32, 38, 46, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(14, 'PER-105755', 4, NULL, 2, 32, 38, 47, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(15, 'PER-312555', 4, NULL, 2, 32, 38, 48, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(16, 'PER-309200', 4, NULL, 36, 29, 29, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(17, 'PER-743250', 4, NULL, 36, 29, 32, 34, '{\"add\": {\"allowed\": true, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(18, 'PER-732535', 4, NULL, 36, 29, 32, 35, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(19, 'PER-905409', 4, NULL, 36, 29, 30, 36, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(20, 'PER-212796', 4, NULL, 36, 29, 30, 38, '{\"add\": {\"allowed\": true, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": true, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": true, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": true, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(21, 'PER-878024', 4, NULL, 36, 29, 31, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-12 04:29:43', '2025-06-12 04:29:51', NULL),
(22, 'PER-464470', 3, 2, 1, 1, 2, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": true, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": true, \"permission\": false}, \"filter\": {\"allowed\": true, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(23, 'PER-906407', 3, 2, 1, 1, 1, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": true, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": true, \"permission\": false}, \"filter\": {\"allowed\": true, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(24, 'PER-277297', 3, 2, 35, 25, 20, NULL, '{\"add\": {\"allowed\": true, \"permission\": true}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": true, \"permission\": true}, \"edit\": {\"allowed\": true, \"permission\": true}, \"info\": {\"allowed\": true, \"permission\": true}, \"save\": {\"allowed\": true, \"permission\": true}, \"close\": {\"allowed\": true, \"permission\": true}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": true, \"permission\": true}, \"detail\": {\"allowed\": true, \"permission\": true}, \"filter\": {\"allowed\": true, \"permission\": true}, \"reload\": {\"allowed\": true, \"permission\": true}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": true, \"permission\": true}, \"update\": {\"allowed\": true, \"permission\": true}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:53', NULL),
(25, 'PER-794611', 3, 2, 2, 30, 33, 39, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(26, 'PER-461790', 3, 2, 2, 30, 33, 40, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(27, 'PER-154375', 3, 2, 2, 30, 34, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(28, 'PER-189928', 3, 2, 2, 31, 35, 41, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(29, 'PER-592077', 3, 2, 2, 31, 35, 42, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(30, 'PER-380166', 3, 2, 2, 31, 35, 43, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(31, 'PER-618409', 3, 2, 2, 31, 35, 44, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(32, 'PER-797645', 3, 2, 2, 31, 36, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(33, 'PER-593506', 3, 2, 2, 32, 37, 45, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(34, 'PER-463656', 3, 2, 2, 32, 38, 46, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(35, 'PER-349004', 3, 2, 2, 32, 38, 47, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(36, 'PER-139106', 3, 2, 2, 32, 38, 48, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(37, 'PER-578302', 3, 2, 36, 29, 29, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(38, 'PER-688584', 3, 2, 36, 29, 32, 34, '{\"add\": {\"allowed\": true, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(39, 'PER-208643', 3, 2, 36, 29, 32, 35, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(40, 'PER-100005', 3, 2, 36, 29, 30, 36, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(41, 'PER-853079', 3, 2, 36, 29, 30, 38, '{\"add\": {\"allowed\": true, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": true, \"permission\": false}, \"info\": {\"allowed\": true, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": true, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": true, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL),
(42, 'PER-437707', 3, 2, 36, 29, 31, NULL, '{\"add\": {\"allowed\": false, \"permission\": false}, \"set\": {\"allowed\": false, \"permission\": false}, \"back\": {\"allowed\": false, \"permission\": false}, \"edit\": {\"allowed\": false, \"permission\": false}, \"info\": {\"allowed\": false, \"permission\": false}, \"save\": {\"allowed\": false, \"permission\": false}, \"close\": {\"allowed\": false, \"permission\": false}, \"other\": {\"allowed\": false, \"permission\": false}, \"reset\": {\"allowed\": false, \"permission\": false}, \"access\": {\"allowed\": false, \"permission\": false}, \"delete\": {\"allowed\": false, \"permission\": false}, \"detail\": {\"allowed\": false, \"permission\": false}, \"filter\": {\"allowed\": false, \"permission\": false}, \"reload\": {\"allowed\": false, \"permission\": false}, \"search\": {\"allowed\": false, \"permission\": false}, \"status\": {\"allowed\": false, \"permission\": false}, \"update\": {\"allowed\": false, \"permission\": false}, \"default\": {\"allowed\": false, \"permission\": false}, \"permission\": {\"allowed\": false, \"permission\": false}}', '2025-06-17 22:19:12', '2025-06-17 22:19:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'USER1', '03d63a5b3853e7ac595ea6e0abf9126e7659af8479242969bd5c660fe4cf933d', '[\"*\"]', '2025-07-02 06:59:31', NULL, '2025-07-01 04:50:51', '2025-07-02 06:59:31'),
(2, 'App\\Models\\User', 3, 'USER3', 'b7c3ed9bc46a41b818331df8cb5c1997082c8f9529ef0b43e27b2d47f3b670a9', '[\"*\"]', NULL, NULL, '2025-07-04 05:24:07', '2025-07-04 05:24:07'),
(3, 'App\\Models\\User', 4, 'AGENT4', '3df88ac98cc2fac4aa818a77841080e0c684f04dc2668c0adfd217bbf9b0b2c1', '[\"*\"]', NULL, NULL, '2025-07-04 05:49:10', '2025-07-04 05:49:10'),
(4, 'App\\Models\\User', 1, 'USER1', '224bc2d37888527074aba0cb82ad64cd20bff99a3bdce1916820261fb373fbb1', '[\"*\"]', NULL, NULL, '2025-07-04 06:01:41', '2025-07-04 06:01:41'),
(5, 'App\\Models\\User', 1, 'USER1', 'd764b1c27bd0bbf4e1b08697719cef712a40553b9dcf76a3c8079f4d9c1dc7cf', '[\"*\"]', NULL, NULL, '2025-07-04 06:03:58', '2025-07-04 06:03:58'),
(6, 'App\\Models\\User', 1, 'USER1', '3b1c8caaeeaf06168c152a45528ca53c31bdef38e01d387959d8cbdf39fcfcf7', '[\"*\"]', '2025-07-04 06:13:10', NULL, '2025-07-04 06:12:52', '2025-07-04 06:13:10'),
(7, 'App\\Models\\User', 1, 'USER1', '50a4d8cb61a775ad9870d801ce60797661dd61104ff27fa9251c42022eef43ce', '[\"*\"]', '2025-07-05 17:43:21', NULL, '2025-07-05 17:16:44', '2025-07-05 17:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy`
--

DROP TABLE IF EXISTS `privacy_policy`;
CREATE TABLE IF NOT EXISTS `privacy_policy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `privacyPolicy` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `privacy_policy`
--

INSERT INTO `privacy_policy` (`id`, `privacyPolicy`, `created_at`, `updated_at`) VALUES
(1, '<span style=\"box-sizing: inherit; font-weight: 700; color: rgb(54, 54, 54); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Privacy Policy</span><span style=\"color: rgb(74, 74, 74); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\"></span><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; color: rgb(74, 74, 74); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">The Unicorn Computech built the website \"www.unicorncomputech.com\" as a Commercial e-commerce website. This SERVICE is provided by The Unicorn Computech and is intended for use as is.</p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; color: rgb(74, 74, 74); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">This page is used to inform visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service.</p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; color: rgb(74, 74, 74); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">If you choose to use our Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that we collect is used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>1. Information We Collect</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We collect personal information such as your name, contact details, and payment information.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We also collect non-personal information related to your interactions with our platform.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>2. Use of Information</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We use your personal information for order processing, customer support, and marketing purposes.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We do not sell or share your personal information with third parties, except as required for order fulfillment.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>3. Cookies</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We use cookies to improve your browsing experience and collect non-personal information.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>4. Security</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We employ security measures to protect your personal information.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>5. Third-Party Links</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - Our platform may contain links to third-party websites. We are not responsible for their privacy practices.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>6. Changes to Privacy Policy</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - We reserve the right to update our privacy policy. Any changes will be posted on our website.</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>7. Contact Us</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>&nbsp; &nbsp; - If you have questions or concerns about our privacy policy, please contact us at [Your Contact Information].</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b><br></b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#363636\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>Please note that these are sample documents, and it\'s important to tailor them to your specific needs and comply with the legal requirements in your jurisdiction. Additionally, it\'s advisable to have legal professionals review and assist in drafting these documents.</b></span></font></p>', NULL, '2023-10-31 11:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `property_attribute`
--

DROP TABLE IF EXISTS `property_attribute`;
CREATE TABLE IF NOT EXISTS `property_attribute` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `about` text COLLATE utf8mb3_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `default` enum('YES','NO') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NO',
  `type` enum('amenities','propertyFeatures','societyFeatures','typeOfFloorings','parkingTypes','locatedNear','locationAdvantages','NA','measurementsUnits','propertyFacing','uploadedPhotoType','typesOfUsers','ownership','measurementsUnits','qualityRating','otherRooms','availabilityStatus','furnishing','propertyProvided','yourApartment','additionalFeature','suitableType','washroomDetails','facilityAvailable','ageOfProperty','waterSource','overlooking','otherFeature','powerBackup','constructionDone','propertyApproved','locationInside','zoneType','constructionStatus','fireSafety','previouslyUsed','approvedType','buildingFeature') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `property_attribute`
--

INSERT INTO `property_attribute` (`id`, `uniqueId`, `name`, `about`, `status`, `default`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PRPA-937733', 'NEW', 'LOL', 'ACTIVE', 'NO', 'typeOfFloorings', '2025-05-30 04:42:41', '2025-06-14 00:30:08', NULL),
(2, 'PRPA-477373', 'NEW', 'dfg', 'ACTIVE', 'YES', 'propertyFeatures', '2025-05-30 05:03:21', '2025-06-14 00:30:05', NULL),
(3, 'PRPA-448593', 'NEW', NULL, 'ACTIVE', 'YES', 'parkingTypes', '2025-05-30 06:15:43', '2025-06-14 00:30:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

DROP TABLE IF EXISTS `property_type`;
CREATE TABLE IF NOT EXISTS `property_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `about` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `default` enum('YES','NO') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `uniqueId`, `name`, `about`, `status`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PRPT-212157', 'Commercial', NULL, 'ACTIVE', 'NO', '2025-06-02 06:36:25', '2025-06-15 03:06:51', NULL),
(2, 'PRPT-275109', 'Residential', NULL, 'ACTIVE', 'YES', '2025-06-02 06:36:35', '2025-06-21 13:56:46', NULL),
(3, 'PRPT-622842', 'asa', NULL, 'ACTIVE', 'NO', '2025-06-21 14:17:01', '2025-06-21 14:17:14', '2025-06-21 14:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cvupHKHM8ZjpNyIJh0qilAQ8VX2oJ07BhD1PhrKs', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamVKaHB2QmlFY3h3SDBjWmdIanpJU3VvS2Z5NnhaQVRlSUJKM2t5SyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3QvTEFSQVZFTC9BZG1pblNldHVwL2hvbWUiO319', 1752147301);

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
CREATE TABLE IF NOT EXISTS `social_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `link` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `icon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `status` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `title`, `link`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'https://fontawesome.com/icons/facebook?s=&f=brands', 'fa-brands fa-facebook-f', '1', '2022-12-31 09:57:31', '2023-09-23 10:17:07'),
(2, 'Twitter', 'https://fontawesome.com/icons/facebook?s=&f=brands', 'fab fa-twitter', '1', '2022-12-31 09:59:29', '2023-02-11 17:45:02'),
(4, 'Instagram', 'https://fontawesome.com/icons/facebook?s=&f=brands', 'fab fa-instagram', '1', '2022-12-31 10:06:00', '2023-09-23 10:11:24'),
(5, 'Linkedin', 'http://localhost/LARAVEL/Kisalaya/admin/setting/social-links', 'fa-brands fa-linkedin-in', '1', '2023-09-23 10:19:31', '2023-09-23 10:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `sub_nav`
--

DROP TABLE IF EXISTS `sub_nav`;
CREATE TABLE IF NOT EXISTS `sub_nav` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `navTypeId` bigint DEFAULT NULL,
  `mainNavId` bigint DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `access` json DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `lastSegment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_nav`
--

INSERT INTO `sub_nav` (`id`, `uniqueId`, `navTypeId`, `mainNavId`, `name`, `icon`, `description`, `access`, `route`, `lastSegment`, `status`, `position`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'NS-772799', 1, 1, 'Charts View', 'ri-apps-2-line', 'NA', '{\"add\": false, \"back\": false, \"edit\": false, \"info\": true, \"save\": false, \"close\": false, \"other\": true, \"reset\": false, \"access\": false, \"delete\": false, \"detail\": true, \"filter\": true, \"reload\": false, \"search\": false, \"status\": false, \"update\": false, \"permission\": false}', 'dashboard-related/dashboard/charts-view', 'charts-view', 'ACTIVE', 2, '2024-08-07 04:52:31', '2025-06-11 08:50:59', NULL),
(2, 'NS-261429', 1, 1, 'Quick Overview', 'ri-apps-2-line', 'NA', '{\"add\": false, \"back\": false, \"edit\": false, \"info\": true, \"save\": false, \"close\": false, \"other\": true, \"reset\": false, \"access\": false, \"delete\": false, \"detail\": true, \"filter\": true, \"reload\": false, \"search\": false, \"status\": false, \"update\": false, \"permission\": false}', 'dashboard-related/dashboard/quick-overview', 'quick-overview', 'ACTIVE', 1, '2024-08-07 04:52:31', '2025-06-11 08:50:56', NULL),
(20, 'NS-229603', 35, 25, 'Admin Users', 'las la-user-tie', 'NA', '{\"add\": true, \"set\": false, \"back\": true, \"edit\": true, \"info\": true, \"save\": true, \"close\": true, \"other\": false, \"reset\": false, \"access\": false, \"delete\": true, \"detail\": true, \"filter\": true, \"reload\": true, \"search\": false, \"status\": true, \"update\": true, \"permission\": false}', 'users-related/manage-users/admin-users', 'admin-users', 'ACTIVE', 3, '2025-05-19 23:32:47', '2025-06-11 08:39:38', NULL),
(38, 'NS-293578', 2, 32, 'Customized Alert', 'ri-apps-2-line', 'NA', NULL, 'admin-related/quick-setting/customized-alert', 'customized-alert', 'ACTIVE', 13, '2025-06-12 00:53:53', '2025-06-12 03:00:10', NULL),
(30, 'NS-184980', 36, 29, 'Property Category', 'NA', 'Property types can be broadly categorized into real, personal, private, public, and intellectual property. Real property includes land and anything permanently attached to it, like buildings. Personal property refers to movable items, such as vehicles and furniture. Private property is owned by individuals or corporations, while public property is owned by the government. Intellectual property encompasses creations of the mind, such as patents and copyrights.', NULL, 'category-attributes-type/property-related/property-category', 'property-category', 'ACTIVE', 10, '2025-05-29 23:42:39', '2025-06-11 08:39:32', NULL),
(29, 'NS-722249', 36, 29, 'Property Type', 'NA', 'Property types in real estate can be broadly classified into five main categories: residential, commercial, raw land, industrial, and special purpose. Within each category, there are further sub-types.', NULL, 'category-attributes-type/property-related/property-type', 'property-type', 'ACTIVE', 8, '2025-05-29 23:42:01', '2025-06-11 08:39:35', NULL),
(31, 'NS-489685', 36, 29, 'Property Attribute', 'NA', 'Property attributes, in various contexts, are characteristics or features that describe or define a property, such as a house, a piece of land, or an object in programming. These attributes can include details like address, size, location, and more. In programming, they define how a property can be accessed and modified', NULL, 'category-attributes-type/property-related/property-attribute', 'property-attribute', 'ACTIVE', 11, '2025-05-29 23:43:33', '2025-06-11 08:39:29', NULL),
(32, 'NS-734166', 36, 29, 'Manage Broad', 'NA', 'NA', NULL, 'category-attributes-type/property-related/manage-broad', 'manage-broad', 'ACTIVE', 9, '2025-06-02 01:25:39', '2025-06-11 08:39:23', NULL),
(33, 'NS-752378', 2, 30, 'Manage Role', 'NA', 'NA', NULL, 'admin-related/role-permission/manage-role', 'manage-role', 'ACTIVE', 4, '2025-06-09 22:07:45', '2025-06-11 08:39:19', NULL),
(34, 'NS-592149', 2, 30, 'Manage Permission', 'NA', 'NA', NULL, 'admin-related/role-permission/manage-permission', 'manage-permission', 'ACTIVE', 5, '2025-06-09 22:08:13', '2025-06-11 08:39:16', NULL),
(35, 'NS-902337', 2, 31, 'Manage Side Nav', 'NA', 'NA', NULL, 'admin-related/navigation-access/manage-side-nav', 'manage-side-nav', 'ACTIVE', 6, '2025-06-10 04:37:45', '2025-06-11 08:39:12', NULL),
(36, 'NS-466374', 2, 31, 'Arrange Side Nav', 'NA', 'NA', NULL, 'admin-related/navigation-access/arrange-side-nav', 'arrange-side-nav', 'ACTIVE', 7, '2025-06-10 04:38:10', '2025-06-11 08:39:08', NULL),
(37, 'NS-680452', 2, 32, 'Site Setting', 'na', 'NA', NULL, 'admin-related/quick-setting/site-setting', 'site-setting', 'ACTIVE', 12, '2025-06-11 00:00:22', '2025-06-11 08:38:55', NULL),
(39, 'NS-919984', 35, 25, 'App Users', 'na', 'NA', NULL, 'users-related/manage-users/app-users', 'app-users', 'ACTIVE', 14, '2025-07-04 02:50:22', '2025-07-04 02:50:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_role`
--

DROP TABLE IF EXISTS `sub_role`;
CREATE TABLE IF NOT EXISTS `sub_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mainRoleId` int DEFAULT NULL,
  `uniqueId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_role`
--

INSERT INTO `sub_role` (`id`, `mainRoleId`, `uniqueId`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 3, 'RS-345889', 'bbb', 'bbbb', 'ACTIVE', '2025-04-10 21:16:51', '2025-05-23 23:40:56', NULL),
(3, 3, 'RS-326003', 'ccc', 'cccc', 'ACTIVE', '2025-04-10 21:18:45', '2025-06-21 14:36:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

DROP TABLE IF EXISTS `table`;
CREATE TABLE IF NOT EXISTS `table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bodyBackColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bodyTextColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bodyHoverBackColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bodyHoverTextColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `headBackColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `headTextColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `headHoverBackColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `headHoverTextColor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `bodyTableStyle` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `headTableStyle` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`id`, `bodyBackColor`, `bodyTextColor`, `bodyHoverBackColor`, `bodyHoverTextColor`, `headBackColor`, `headTextColor`, `headHoverBackColor`, `headHoverTextColor`, `bodyTableStyle`, `headTableStyle`, `status`, `created_at`, `updated_at`) VALUES
(6, '66,68,90,0', '0,0,0,1', '66,68,90,0', '0,0,0,1', '40.99999999999999,107,155,1', '255,255,255,1', '40.99999999999999,107,155,1', '255,255,255,1', '{\"fontType\":\"Comic Sans MS\",\"fontStyle\":\"italic\",\"fontWeight\":\"bold\",\"fontSize\":\"12\",\"decorationType\":\"overline\",\"decorationStyle\":\"dashed\",\"decorationColor\":\"255,0,32.78563090733107,1\",\"decorationSize\":\"1\"}', '{\"fontType\":\"Algerian\",\"fontStyle\":\"italic\",\"fontWeight\":\"normal\",\"fontSize\":\"18\",\"decorationType\":\"underline\",\"decorationStyle\":\"dotted\",\"decorationColor\":\"255,244.5267023359026,0,1\",\"decorationSize\":\"2\"}', '1', '2020-10-30 10:46:21', '2021-07-31 10:04:35'),
(11, '40,70,155,1', '255,255,255,1', '40,70,155,1', '255,255,255,1', '184.41964285714286,180.19163604905063,66.03545223055984,1', '255,255,255,1', '40,70,155,1', '255,255,255,1', '{\"fontType\":\"\\\"Roboto\\\", sans-serif\",\"fontStyle\":\"normal\",\"fontWeight\":\"normal\",\"fontSize\":\"14\",\"decorationType\":\"underline\",\"decorationStyle\":\"dashed\",\"decorationColor\":\"0, 0, 0, 0\",\"decorationSize\":\"1\"}', '{\"fontType\":\"\\\"Roboto\\\", sans-serif\",\"fontStyle\":\"normal\",\"fontWeight\":\"normal\",\"fontSize\":\"14\",\"decorationType\":\"line-through\",\"decorationStyle\":\"dotted\",\"decorationColor\":\"48.20544146063241,62.70617963980323,222.2142996106829,1\",\"decorationSize\":\"1\"}', '0', '2020-11-01 11:34:48', '2021-03-21 00:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `terms_condition`
--

DROP TABLE IF EXISTS `terms_condition`;
CREATE TABLE IF NOT EXISTS `terms_condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `termsCondition` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `terms_condition`
--

INSERT INTO `terms_condition` (`id`, `termsCondition`, `created_at`, `updated_at`) VALUES
(1, '<div><br></div><div><span style=\"box-sizing: inherit; font-weight: 700; color: rgb(54, 54, 54); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Terms &amp; Conditions</span><span style=\"color: rgb(74, 74, 74); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\"></span><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><br></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>1. Introduction</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; Welcome to The Unicorn Computech. These terms and conditions govern your use of our website and the purchase of products from our platform. By using our website and making purchases, you agree to abide by these terms and conditions. If you do not agree, please refrain from using our platform.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>2. Ordering and Payment</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - You must be of legal age to make purchases on our platform.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - Prices are displayed in your preferred currency and are subject to change without notice.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - Payment must be made in full before the order is processed.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - We accept various payment methods, which are listed on our website.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>3. Shipping and Delivery</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - We aim to ship orders promptly, but delivery times may vary.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - You are responsible for providing accurate shipping information.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - Shipping fees are calculated at checkout.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>4. Returns and Refunds</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - Please review our return policy for detailed information on returns and refunds.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - Products must be in their original condition for returns.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>5. Intellectual Property</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - All content and materials on our website are protected by copyright and other intellectual property laws.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - You may not use, reproduce, or distribute our content without permission.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>6. Privacy</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - Your use of our platform is governed by our privacy policy, which is outlined separately.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>7. Limitation of Liability</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - We are not liable for any direct or indirect damages arising from the use of our platform or products.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><br></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\"><b>8. Governing Law</b></span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; background-color: rgb(255, 255, 255);\"><font color=\"#4a4a4a\" face=\"BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Helvetica, Arial, sans-serif\"><span style=\"font-size: 16px;\">&nbsp; &nbsp; - These terms and conditions are governed by the laws of Howrah Jurisdiction.</span></font></p><p style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; color: rgb(74, 74, 74); font-family: BlinkMacSystemFont, -apple-system, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\"><br></p><div class=\"styles__StepsFlex-a5s7uc-12 jxcCkk\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 15px; line-height: 24px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><div type=\"contents\" class=\"styles__Content-a5s7uc-13 eJeCen\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 10px;\"><h4 class=\"styles__H4-a90kxg-4 styles__H4TextWrapper-a5s7uc-31 iJCgIp\" style=\"box-sizing: inherit; padding: 0px; margin-bottom: 0px; font-weight: 600; line-height: 24px; color: inherit; font-size: 16px;\">Shipping Fee (Weight and Location)</h4><p class=\"styles__ParaTextWrapper-a5s7uc-33 jerNyk\" style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 8px; margin-left: 0px; width: 604.5px; color: rgb(53, 53, 53);\">The shipping fee is calculated based on the actual weight of the product or the volumetric weight, whichever is higher. Volumetric weight accounts for items that are lightweight but occupy a significant amount of shipping space. This approach ensures fair and accurate shipping charges are applied, taking into consideration the actual or volumetric weight of the products being shipped.</p></div></div><div class=\"styles__StepsFlex-a5s7uc-12 jxcCkk\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 15px; line-height: 24px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><div type=\"contents\" class=\"styles__Content-a5s7uc-13 eJeCen\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 10px;\"><p class=\"styles__ParaTextWrapper-a5s7uc-33 jerNyk\" style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 8px; margin-left: 0px; width: 604.5px; color: rgb(53, 53, 53);\">The shipping fee is calculated based on the actual weight of the product or the volumetric weight, whichever is higher. Volumetric weight accounts for items that are lightweight but occupy a significant amount of shipping space. This approach ensures fair and accurate shipping charges are applied, taking into consideration the actual or volumetric weight of the products being shipped.</p><div class=\"styles__BarContent-a5s7uc-24 lajsSP\" style=\"box-sizing: inherit; display: flex; height: 60px; background: rgb(226, 244, 255); border-radius: 8px; flex-flow: column; -webkit-box-pack: center; justify-content: center; padding: 20px; margin-bottom: 15px; font-size: 16px;\"><span style=\"box-sizing: inherit;\">Volumetric Weight (kg) = Length (cm) X Breadth (cm) X Height (cm)/5000</span></div></div></div><div class=\"styles__StepsFlex-a5s7uc-12 jxcCkk\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 15px; line-height: 24px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><table class=\"styles__TableContainer-sc-1d66s2n-0 dtWRkx\" style=\"box-sizing: inherit; border-spacing: 0px; background-color: transparent; width: 806px; margin: 0px auto;\"><thead style=\"box-sizing: inherit;\"><tr class=\"styles__TableHeaderRow-sc-1d66s2n-1 kyoswe\" style=\"box-sizing: inherit; background: rgba(110, 177, 227, 0.12); font-size: 16px; font-weight: bold; display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><th class=\"styles__TableHeaderCell-sc-1d66s2n-2 eXXJdh\" style=\"box-sizing: inherit; padding: 8px; text-align: left; display: flex; -webkit-box-align: center; align-items: center; width: 196.5px; -webkit-box-pack: justify; justify-content: space-between; gap: 10px;\">Weight Bucket (Kgs)</th><th class=\"styles__TableHeaderCell-sc-1d66s2n-2 eXXJdh\" style=\"box-sizing: inherit; padding: 8px; text-align: left; display: flex; -webkit-box-align: center; align-items: center; width: 196.5px; -webkit-box-pack: justify; justify-content: space-between; gap: 10px;\">Local (Intracity)</th><th class=\"styles__TableHeaderCell-sc-1d66s2n-2 eXXJdh\" style=\"box-sizing: inherit; padding: 8px; text-align: left; display: flex; -webkit-box-align: center; align-items: center; width: 196.5px; -webkit-box-pack: justify; justify-content: space-between; gap: 10px;\">Zonal (Intrazone)</th><th class=\"styles__TableHeaderCell-sc-1d66s2n-2 eXXJdh\" style=\"box-sizing: inherit; padding: 8px; text-align: left; display: flex; -webkit-box-align: center; align-items: center; width: 196.5px; -webkit-box-pack: justify; justify-content: space-between; gap: 10px;\">National (Interzone)</th></tr></thead><tbody class=\"styles__TableBody-sc-1d66s2n-3 TfNjx\" style=\"box-sizing: inherit;\"><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">0.5</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">47</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">54</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">68</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">0.5-1 (for every 0.5kgs)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">4</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">19</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">26</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">1-1.5 (for every 0.5kgs)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">13</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">17</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">28</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">1.5-2 (for every 0.5kgs)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">10</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">18</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">22</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">2-2.5 (for every 0.5kgs)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">8</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">11</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">17</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">2.5-3 (for every 0.5kgs)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">8</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">11</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">17</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">3-4 (for every 1kg)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">7</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">10</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">16</td></tr><tr class=\"styles__TableDataRow-sc-1d66s2n-4 gRXpaM\" style=\"box-sizing: inherit; border-bottom: 1px solid rgb(235, 235, 236); display: flex; flex-flow: row; -webkit-box-pack: justify; justify-content: space-between; min-height: 50px; padding: 10px;\"><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">4-5 (for every 1kg)</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">7</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">10</td><td class=\"styles__TableDataCell-sc-1d66s2n-5 coqPbe\" style=\"box-sizing: inherit; padding: 8px; width: 196.5px;\">16</td></tr></tbody></table></div><div class=\"styles__StepsFlex-a5s7uc-12 jxcCkk\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 15px; line-height: 24px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><div class=\"styles__BreakContent-a5s7uc-1 jMrvgN\" style=\"box-sizing: inherit; margin-top: 8px; margin-bottom: 8px;\"></div></div><div class=\"styles__StepsFlex-a5s7uc-12 jxcCkk\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 15px; line-height: 24px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><div type=\"contents\" class=\"styles__Content-a5s7uc-13 eJeCen\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 10px;\"><p class=\"styles__ParaTextWrapper-a5s7uc-33 dQffCP\" style=\"box-sizing: inherit; margin-right: 0px; margin-bottom: 8px; margin-left: 0px; width: 806px; color: rgb(113, 113, 113);\">Please note that the information provided above is based on the standard rate card and is subject to change. To obtain the accurate and up-to-date shipping fee applicable to your sales, we recommend logging into your Flipkart seller account. By accessing your account, you can stay informed about the specific shipping fees that apply to your transactions.</p></div></div><div class=\"styles__StepsFlex-a5s7uc-12 jxcCkk\" style=\"box-sizing: inherit; display: flex; flex-flow: column; gap: 15px; line-height: 24px; color: rgb(51, 51, 51); font-family: Inter, sans-serif;\"><div class=\"styles__Container-a5s7uc-5 bOSNXD\" style=\"box-sizing: inherit; display: flex; flex-flow: column; line-height: 26px;\"><div type=\"tick-mark\" class=\"styles__ContentStepsContainer-a5s7uc-23 kYNqyY\" style=\"box-sizing: inherit; display: flex; gap: 40px; flex-flow: column;\"><div type=\"tick-mark\" class=\"styles__ContentStepsContainer-a5s7uc-23 kYNqyY\" style=\"box-sizing: inherit; display: flex; gap: 40px; flex-flow: column;\"><ul style=\"box-sizing: inherit; padding: 0px; margin: 2px 0px 0px; list-style-image: url(&quot;https://static-assets-web.flixcart.com/fk-sp-static/images/tick-mark-revamp.svg&quot;);\"><div class=\"styles__DivWrapper-a5s7uc-39 bVOUKv\" style=\"box-sizing: inherit; margin: 5px 0px 8px;\"><li style=\"box-sizing: inherit; list-style-position: inside; list-style-type: none; margin-bottom: 12px;\"><span class=\"styles__SpanTextWrapper-a5s7uc-34 capNWR\" style=\"box-sizing: inherit; margin-top: 6px; margin-left: 12px;\">Local (Intracity): Item shipped within a city</span></li></div><div class=\"styles__DivWrapper-a5s7uc-39 bVOUKv\" style=\"box-sizing: inherit; margin: 5px 0px 8px;\"><li style=\"box-sizing: inherit; list-style-position: inside; list-style-type: none; margin-bottom: 12px;\"><span class=\"styles__SpanTextWrapper-a5s7uc-34 capNWR\" style=\"box-sizing: inherit; margin-top: 6px; margin-left: 12px;\">Zonal (Intrazone): Item shipped within the borders of a zone (North, South, East, West)</span></li></div><div class=\"styles__DivWrapper-a5s7uc-39 bVOUKv\" style=\"box-sizing: inherit; margin: 5px 0px 8px;\"><li style=\"box-sizing: inherit; list-style-position: inside; list-style-type: none; margin-bottom: 12px;\"><span class=\"styles__SpanTextWrapper-a5s7uc-34 capNWR\" style=\"box-sizing: inherit; margin-top: 6px; margin-left: 12px;\">National (Interzone): Item shipped across zones</span></li></div></ul></div></div></div></div></div>', '2019-09-13 06:39:03', '2023-10-31 11:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniqueId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `dialCode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `phone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','NA','INCOMPLETE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `userType` enum('USER','AGENT','NA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `otp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otpFor` enum('LOGIN','REGISTER','NA','RESET PASSWORD','CHANGE EMAIL','CHANGE PHONE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `otpExpiredAt` timestamp NULL DEFAULT NULL,
  `deviceToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deviceType` enum('ANDROID','IOS','WEB','NA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uniqueId`, `name`, `dialCode`, `phone`, `email`, `image`, `password`, `status`, `userType`, `otp`, `otpFor`, `otpExpiredAt`, `deviceToken`, `deviceType`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'APU-123456', 'Rahul Biswas', '91', '8436191135', 'biswas.rahul31@gmail.com', '1751439571_1751394600_576722065.jpg', '$2y$12$Gb1bTZ25hVHzmxKR9frKPOqu90e6AAeNN/aWvWXqoXs6ec78IbV2K', 'ACTIVE', 'USER', NULL, 'NA', NULL, 'RAHULBISWAS', 'ANDROID', NULL, NULL, '2025-07-01 04:39:03', '2025-07-05 17:43:21', NULL),
(4, 'APU-797662', 'Somenath Day', '91', '8436191136', 'biswas.rahul32@gmail.com', 'NA', '$2y$12$gkCd37oVNJJmWdVB2hk85OWuycuXSQVbJ9tH7NlRYVP19zOBEjQ0G', 'ACTIVE', 'AGENT', NULL, 'NA', NULL, NULL, 'NA', NULL, NULL, '2025-07-04 05:47:55', '2025-07-04 06:01:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

DROP TABLE IF EXISTS `users_info`;
CREATE TABLE IF NOT EXISTS `users_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` bigint DEFAULT NULL,
  `pinCode` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `state` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `country` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `address` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `about` text COLLATE utf8mb3_unicode_ci,
  `userType` enum('ADMIN','NA','USER','AGENT') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`id`, `userId`, `pinCode`, `state`, `country`, `address`, `about`, `userType`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '741126', 'West Bengal', 'India', 'College para, Birpur road, Bathuadahari, Nadia', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from popular belief, Lorem Ipsum is not simply random text. It has roots in a piece.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>', 'ADMIN', '2025-05-02 06:05:09', '2025-06-18 01:14:50', NULL),
(2, 2, '123456', 'NA', 'NA', 'NA', 'NA', 'ADMIN', '2025-05-01 06:05:06', '2025-05-23 11:09:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `version_control`
--

DROP TABLE IF EXISTS `version_control`;
CREATE TABLE IF NOT EXISTS `version_control` (
  `id` int NOT NULL AUTO_INCREMENT,
  `appVersion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'NA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `version_control`
--

INSERT INTO `version_control` (`id`, `appVersion`, `created_at`, `updated_at`) VALUES
(1, '0.0.0', NULL, '2022-01-14 10:55:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
