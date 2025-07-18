-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 03:39 PM
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
-- Database: `helpdesk_core_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `team_member` varchar(11) NOT NULL,
  `team_member_name` varchar(255) NOT NULL,
  `private` int(11) NOT NULL DEFAULT 0,
  `body` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` varchar(255) NOT NULL,
  `screenshot_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `ticket`, `team_member`, `team_member_name`, `private`, `body`, `created_at`, `updated_at`, `author`, `screenshot_path`) VALUES
(115, 102, '1', 'John Doe', 0, 'test', '2025-06-27 03:09:24', '2025-06-27 03:09:24', '', ''),
(116, 112, '1', 'John Doe', 0, 'test', '2025-07-03 16:49:24', '2025-07-03 16:49:24', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `team_id`, `ticket_id`, `site_name`, `message`, `is_read`, `created_at`, `user_id`) VALUES
(27, 1, 99, NULL, 'New ticket created: Banlic', 1, '2025-03-21 09:24:12', NULL),
(28, 7, 100, NULL, 'New ticket created: sala', 0, '2025-06-24 05:26:51', NULL),
(29, 7, 101, NULL, 'New ticket created: sala', 0, '2025-06-24 05:27:22', NULL),
(30, 7, 102, NULL, 'New ticket created: Banlic', 0, '2025-06-24 13:51:02', NULL),
(31, 1, 103, NULL, 'New ticket created: Banlic', 1, '2025-06-24 13:51:48', NULL),
(32, 1, 104, NULL, 'New ticket created: sala', 1, '2025-06-24 13:53:23', NULL),
(33, 1, 105, NULL, 'New ticket created: Banlic', 1, '2025-06-24 13:55:01', NULL),
(34, 1, 106, NULL, 'New ticket created: Banlic', 1, '2025-06-24 13:55:28', NULL),
(35, 1, 107, NULL, 'New ticket created: sala', 1, '2025-06-24 13:56:46', NULL),
(36, 1, 108, NULL, 'New ticket created: Banlic', 1, '2025-06-24 14:10:03', NULL),
(37, 1, NULL, NULL, '📍 A new site has been created: pulo', 1, '2025-06-28 13:25:46', NULL),
(38, 7, NULL, NULL, '📍 A new site has been created: pulo', 0, '2025-06-28 13:25:46', NULL),
(39, 1, NULL, NULL, 'A new site <strong>San Cristobal</strong> has been created.', 1, '2025-06-28 13:31:44', NULL),
(40, 7, NULL, NULL, 'A new site <strong>San Cristobal</strong> has been created.', 0, '2025-06-28 13:31:44', NULL),
(41, 1, NULL, NULL, '📍 A new site has been created:niugan ', 1, '2025-06-28 13:35:30', NULL),
(42, 7, NULL, NULL, '📍 A new site has been created:niugan ', 0, '2025-06-28 13:35:30', NULL),
(43, 1, NULL, NULL, '📍 A new site has been created: zxc', 1, '2025-07-02 15:56:24', NULL),
(44, 7, NULL, NULL, '📍 A new site has been created: zxc', 0, '2025-07-02 15:56:24', NULL),
(45, 1, NULL, NULL, '📍 New Site Alert: zxc has just been added.', 1, '2025-07-02 15:56:24', NULL),
(46, 1, NULL, NULL, '📍 A new site has been created: cxzd', 1, '2025-07-02 16:01:00', NULL),
(47, 7, NULL, NULL, '📍 A new site has been created: cxzd', 0, '2025-07-02 16:01:00', NULL),
(50, NULL, NULL, NULL, '📍 A new site has been created: sss', 1, '2025-07-02 16:10:18', 1),
(51, NULL, NULL, NULL, '📍 A new site has been created: sss', 1, '2025-07-02 16:10:18', 47),
(52, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 48),
(53, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 49),
(54, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 50),
(55, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 51),
(56, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 52),
(57, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 53),
(58, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 54),
(59, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 55),
(60, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 56),
(61, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 57),
(62, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 58),
(63, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 59),
(64, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 60),
(65, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 61),
(66, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 62),
(67, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 63),
(68, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 64),
(69, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 65),
(70, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 66),
(71, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 67),
(72, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 68),
(73, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 69),
(74, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 70),
(75, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 71),
(76, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 72),
(77, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 73),
(78, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 74),
(79, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 75),
(80, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 76),
(81, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 77),
(82, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 78),
(83, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 79),
(84, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 80),
(85, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 81),
(86, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 82),
(87, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 83),
(88, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 84),
(89, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 85),
(90, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 86),
(91, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 87),
(92, NULL, NULL, NULL, '📍 A new site has been created: sss', 1, '2025-07-02 16:10:18', 88),
(93, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 89),
(94, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 90),
(95, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 91),
(96, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 92),
(97, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 93),
(98, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 94),
(99, NULL, NULL, NULL, '📍 A new site has been created: sss', 0, '2025-07-02 16:10:18', 95),
(100, 1, 109, NULL, 'New ticket created: banay banay', 1, '2025-07-02 16:16:09', NULL),
(101, NULL, NULL, NULL, '📍 A new site has been created: www', 1, '2025-07-02 17:13:59', 1),
(102, NULL, NULL, NULL, '📍 A new site has been created: www', 1, '2025-07-02 17:13:59', 47),
(103, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 48),
(104, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 49),
(105, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 50),
(106, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 51),
(107, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 52),
(108, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 53),
(109, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 54),
(110, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 55),
(111, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 56),
(112, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 57),
(113, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 58),
(114, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 59),
(115, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 60),
(116, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 61),
(117, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 62),
(118, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 63),
(119, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 64),
(120, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 65),
(121, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 66),
(122, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 67),
(123, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 68),
(124, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 69),
(125, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 70),
(126, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 71),
(127, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 72),
(128, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 73),
(129, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 74),
(130, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 75),
(131, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 76),
(132, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 77),
(133, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 78),
(134, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 79),
(135, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 80),
(136, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 81),
(137, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 82),
(138, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 83),
(139, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 84),
(140, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 85),
(141, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 86),
(142, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 87),
(143, NULL, NULL, NULL, '📍 A new site has been created: www', 1, '2025-07-02 17:13:59', 88),
(144, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 89),
(145, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 90),
(146, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 91),
(147, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 92),
(148, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 93),
(149, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 94),
(150, NULL, NULL, NULL, '📍 A new site has been created: www', 0, '2025-07-02 17:13:59', 95),
(151, NULL, NULL, NULL, '📍 A new site has been created: new', 1, '2025-07-03 09:32:44', 1),
(152, NULL, NULL, NULL, '📍 A new site has been created: new', 1, '2025-07-03 09:32:44', 47),
(153, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 48),
(154, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 49),
(155, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 50),
(156, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 51),
(157, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 52),
(158, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 53),
(159, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 54),
(160, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 55),
(161, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 56),
(162, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 57),
(163, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 58),
(164, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 59),
(165, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 60),
(166, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 61),
(167, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 62),
(168, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 63),
(169, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 64),
(170, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 65),
(171, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 66),
(172, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 67),
(173, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 68),
(174, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 69),
(175, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 70),
(176, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:44', 71),
(177, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 72),
(178, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 73),
(179, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 74),
(180, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 75),
(181, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 76),
(182, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 77),
(183, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 78),
(184, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 79),
(185, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 80),
(186, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 81),
(187, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 82),
(188, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 83),
(189, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 84),
(190, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 85),
(191, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 86),
(192, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 87),
(193, NULL, NULL, NULL, '📍 A new site has been created: new', 1, '2025-07-03 09:32:45', 88),
(194, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 89),
(195, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 90),
(196, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 91),
(197, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 92),
(198, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 93),
(199, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 94),
(200, NULL, NULL, NULL, '📍 A new site has been created: new', 0, '2025-07-03 09:32:45', 95),
(201, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 1, '2025-07-03 09:34:25', 1),
(202, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 1, '2025-07-03 09:34:25', 47),
(203, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 48),
(204, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 49),
(205, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 50),
(206, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 51),
(207, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 52),
(208, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 53),
(209, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 54),
(210, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 55),
(211, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 56),
(212, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 57),
(213, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 58),
(214, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 59),
(215, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 60),
(216, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 61),
(217, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 62),
(218, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 63),
(219, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 64),
(220, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 65),
(221, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 66),
(222, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 67),
(223, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 68),
(224, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 69),
(225, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 70),
(226, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 71),
(227, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 72),
(228, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 73),
(229, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 74),
(230, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 75),
(231, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 76),
(232, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 77),
(233, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 78),
(234, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 79),
(235, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 80),
(236, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 81),
(237, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 82),
(238, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 83),
(239, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 84),
(240, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 85),
(241, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 86),
(242, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 87),
(243, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 1, '2025-07-03 09:34:25', 88),
(244, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 89),
(245, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 90),
(246, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 91),
(247, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 92),
(248, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 93),
(249, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 94),
(250, NULL, NULL, NULL, '📍 A new site has been created: reqwqe', 0, '2025-07-03 09:34:25', 95),
(251, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 1, '2025-07-03 09:35:13', 1),
(252, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 1, '2025-07-03 09:35:13', 47),
(253, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 48),
(254, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 49),
(255, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 50),
(256, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 51),
(257, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 52),
(258, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 53),
(259, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 54),
(260, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 55),
(261, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 56),
(262, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 57),
(263, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 58),
(264, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 59),
(265, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 60),
(266, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 61),
(267, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 62),
(268, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 63),
(269, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 64),
(270, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 65),
(271, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 66),
(272, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 67),
(273, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 68),
(274, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 69),
(275, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 70),
(276, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 71),
(277, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 72),
(278, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 73),
(279, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 74),
(280, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 75),
(281, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 76),
(282, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 77),
(283, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 78),
(284, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 79),
(285, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 80),
(286, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 81),
(287, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 82),
(288, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 83),
(289, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 84),
(290, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 85),
(291, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 86),
(292, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 87),
(293, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 1, '2025-07-03 09:35:13', 88),
(294, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 89),
(295, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:13', 90),
(296, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:14', 91),
(297, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:14', 92),
(298, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:14', 93),
(299, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:14', 94),
(300, NULL, NULL, NULL, '📍 A new site has been created: mnbm', 0, '2025-07-03 09:35:14', 95),
(301, NULL, NULL, NULL, '📍 A new site has been created: test', 1, '2025-07-03 10:32:27', 1),
(302, NULL, NULL, NULL, '📍 A new site has been created: test', 1, '2025-07-03 10:32:27', 47),
(303, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 48),
(304, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 49),
(305, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 50),
(306, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 51),
(307, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 52),
(308, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 53),
(309, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 54),
(310, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 55),
(311, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 56),
(312, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 57),
(313, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 58),
(314, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 59),
(315, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 60),
(316, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 61),
(317, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 62),
(318, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 63),
(319, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 64),
(320, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 65),
(321, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 66),
(322, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 67),
(323, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 68),
(324, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 69),
(325, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 70),
(326, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 71),
(327, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 72),
(328, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 73),
(329, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 74),
(330, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 75),
(331, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 76),
(332, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 77),
(333, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 78),
(334, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 79),
(335, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 80),
(336, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 81),
(337, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 82),
(338, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 83),
(339, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 84),
(340, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 85),
(341, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 86),
(342, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 87),
(343, NULL, NULL, NULL, '📍 A new site has been created: test', 1, '2025-07-03 10:32:27', 88),
(344, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 89),
(345, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 90),
(346, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 91),
(347, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 92),
(348, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 93),
(349, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:27', 94),
(350, NULL, NULL, NULL, '📍 A new site has been created: test', 0, '2025-07-03 10:32:28', 95),
(351, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 1, '2025-07-03 10:39:08', 1),
(352, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 1, '2025-07-03 10:39:08', 47),
(353, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 48),
(354, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 49),
(355, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 50),
(356, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 51),
(357, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 52),
(358, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 53),
(359, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 54),
(360, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 55),
(361, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 56),
(362, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 57),
(363, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 58),
(364, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 59),
(365, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 60),
(366, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 61),
(367, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 62),
(368, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 63),
(369, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 64),
(370, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 65),
(371, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 66),
(372, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 67),
(373, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 68),
(374, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 69),
(375, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 70),
(376, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 71),
(377, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 72),
(378, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 73),
(379, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 74),
(380, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 75),
(381, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 76),
(382, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 77),
(383, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 78),
(384, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 79),
(385, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 80),
(386, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 81),
(387, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 82),
(388, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 83),
(389, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 84),
(390, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 85),
(391, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 86),
(392, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 87),
(393, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 1, '2025-07-03 10:39:08', 88),
(394, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 89),
(395, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 90),
(396, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 91),
(397, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 92),
(398, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 93),
(399, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 94),
(400, NULL, NULL, 'test2123', '📍 A new site has been created: test2123', 0, '2025-07-03 10:39:08', 95),
(401, 1, 110, NULL, 'New ticket created: banay banay', 1, '2025-07-03 10:45:53', NULL),
(402, 1, 111, NULL, 'New ticket created: calamba', 1, '2025-07-03 16:41:52', NULL),
(403, 1, 112, NULL, 'New ticket created: pulo', 1, '2025-07-03 16:48:57', NULL),
(404, 1, 113, NULL, 'New ticket created: Banlic', 1, '2025-07-03 17:21:30', NULL),
(405, 1, 114, NULL, 'New ticket created: Banlic', 1, '2025-07-03 17:22:28', NULL),
(406, 1, 115, NULL, 'New ticket created: pulo', 1, '2025-07-04 12:11:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requester`
--

CREATE TABLE `requester` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `site_name` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `site_name`, `created_at`, `updated_at`, `color`) VALUES
(4, 'Banlic', '2025-02-13 09:09:01', '2025-02-13 09:09:01', ''),
(12, 'sala', '2025-06-24 05:25:47', '2025-06-24 05:25:47', '#792ABC'),
(13, 'calamba', '2025-06-28 13:22:54', '2025-06-28 13:22:54', '#910B78'),
(14, 'calamba', '2025-06-28 13:24:19', '2025-06-28 13:24:19', '#2735DF'),
(15, 'banay banay', '2025-06-28 13:24:40', '2025-06-28 13:24:40', '#D05AB8'),
(16, 'pulo', '2025-06-28 13:25:46', '2025-06-28 13:25:46', '#FB1E20'),
(17, 'sta rosa', '2025-06-28 13:31:20', '2025-06-28 13:31:20', '#F37B41'),
(18, 'San Cristobal', '2025-06-28 13:31:44', '2025-06-28 13:31:44', '#7E0685'),
(19, 'niugan', '2025-06-28 13:35:30', '2025-06-28 13:35:30', '#72ABE0'),
(20, 'zxc', '2025-07-02 15:56:24', '2025-07-02 15:56:24', '#C0B632'),
(21, 'cxzd', '2025-07-02 16:01:00', '2025-07-02 16:01:00', '#1E8709'),
(22, 'qwe', '2025-07-02 16:08:51', '2025-07-02 16:08:51', '#BD1942'),
(23, 'sss', '2025-07-02 16:10:18', '2025-07-02 16:10:18', '#3D24C1'),
(24, 'www', '2025-07-02 17:13:59', '2025-07-02 17:13:59', '#B6E84A'),
(25, 'new', '2025-07-03 09:32:44', '2025-07-03 09:32:44', '#73DC1E'),
(26, 'reqwqe', '2025-07-03 09:34:25', '2025-07-03 09:34:25', '#3A8704'),
(27, 'mnbm', '2025-07-03 09:35:13', '2025-07-03 09:35:13', '#E7C9F8'),
(28, 'test', '2025-07-03 10:32:27', '2025-07-03 10:32:27', '#50921C'),
(29, 'test2123', '2025-07-03 10:39:08', '2025-07-03 10:39:08', '#7A58C2');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Server', '2019-05-19 09:49:15', '2019-05-19 09:49:15'),
(7, 'Team NSW', '2025-04-03 03:50:14', '2025-04-03 03:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

CREATE TABLE `team_member` (
  `id` int(11) NOT NULL,
  `user` varchar(11) NOT NULL,
  `team` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  `team_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `team_member`
--

INSERT INTO `team_member` (`id`, `user`, `team`, `created_at`, `updated_at`, `name`, `team_name`) VALUES
(1, '', '1', '2025-02-16 14:54:46', '2025-02-16 14:54:46', 'John Doe', 'Server'),
(92, '', '7', '2025-07-15 04:21:28', '2025-07-15 04:21:28', 'Mervilyn Derilo', 'Team NSW');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `requester` int(11) DEFAULT NULL,
  `team` int(11) DEFAULT NULL,
  `team_member` varchar(11) DEFAULT NULL,
  `priority` varchar(20) NOT NULL DEFAULT 'low',
  `rating` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` varchar(50) DEFAULT NULL,
  `deleted_at` varchar(50) DEFAULT NULL,
  `site_name` varchar(255) NOT NULL,
  `cluster` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `project` varchar(255) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `team_assigned` varchar(11) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `status` enum('New','On-going','On Hold','Completed') DEFAULT NULL,
  `work_type` text NOT NULL,
  `date_modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_user_modified` varchar(255) DEFAULT NULL,
  `schedule_date_from` date DEFAULT NULL,
  `schedule_date_to` date DEFAULT NULL,
  `site_color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `title`, `body`, `requester`, `team`, `team_member`, `priority`, `rating`, `created_at`, `updated_at`, `deleted_at`, `site_name`, `cluster`, `state`, `project`, `vendor`, `remarks`, `team_assigned`, `schedule_date`, `status`, `work_type`, `date_modified`, `last_user_modified`, `schedule_date_from`, `schedule_date_to`, `site_color`) VALUES
(99, 'Banlic', NULL, NULL, 1, NULL, 'Low', 0, '2025-03-21 09:24:12', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', 'Server', '2025-04-02', 'New', 'Link Upgrade', '2025-04-01 04:02:52', 'Harold Moscoso', '2025-04-02', '2025-04-05', ''),
(100, 'sala', NULL, NULL, 7, NULL, 'low', 0, '2025-06-24 05:26:51', NULL, NULL, 'sala', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-24', 'New', 'site survey', '2025-06-24 13:26:51', NULL, '2025-06-24', '2025-06-25', '#792ABC'),
(101, 'sala', NULL, NULL, 7, NULL, 'low', 0, '2025-06-24 05:27:22', NULL, NULL, 'sala', 'Cabuyao', 'Laguna', 'TELSTRA', 'Downer', 'Ticket initially created.', NULL, '2025-06-26', 'New', 'scope checking', '2025-06-24 13:27:22', NULL, '2025-06-26', '2025-06-28', '#792ABC'),
(102, 'Banlic', NULL, NULL, 7, NULL, 'low', 0, '2025-06-24 13:51:02', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-25', 'New', 'scope checking', '2025-06-24 21:51:02', NULL, '2025-06-25', '2025-06-26', ''),
(103, 'Banlic', NULL, NULL, 1, NULL, 'high', 0, '2025-06-24 13:51:48', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'EJV', 'Downer', 'Ticket initially created.', NULL, '2025-06-28', 'New', 'plant hire', '2025-06-24 21:51:48', NULL, '2025-06-28', '2025-06-29', ''),
(104, 'sala', NULL, NULL, 1, NULL, 'medium', 0, '2025-06-24 13:53:23', NULL, NULL, 'sala', 'Cabuyao', 'LAGUNA', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-24', 'New', 'team submission', '2025-06-24 21:53:23', NULL, '2025-06-24', '2025-06-25', '#792ABC'),
(105, 'Banlic', NULL, NULL, 1, NULL, 'low', 0, '2025-06-24 13:55:01', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-23', 'New', 'material checking', '2025-06-24 21:55:01', NULL, '2025-06-23', '2025-06-24', ''),
(106, 'Banlic', NULL, NULL, 1, NULL, 'medium', 0, '2025-06-24 13:55:28', NULL, NULL, 'Banlic', 'CABUYAO', 'LAGUNA', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-30', 'New', 'RF prep works', '2025-06-24 21:55:28', NULL, '2025-06-30', '2025-07-01', ''),
(107, 'sala', NULL, NULL, 1, NULL, 'medium', 0, '2025-06-24 13:56:46', NULL, NULL, 'sala', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-24', 'New', 'TX prep works', '2025-06-24 21:56:46', NULL, '2025-06-24', '2025-06-25', '#792ABC'),
(108, 'Banlic', NULL, NULL, 1, NULL, 'high', 0, '2025-06-24 14:10:03', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-06-24', 'New', 'team submission', '2025-06-24 22:10:03', NULL, '2025-06-24', '2025-06-25', ''),
(109, 'banay banay', NULL, NULL, 1, NULL, 'Low', 0, '2025-07-02 16:16:09', NULL, NULL, 'banay banay', 'Cabuyao', 'Laguna', 'NBN', 'Downer', NULL, 'Team NSW', '2025-07-03', 'New', 'AC upgrade', '2025-07-04 00:41:20', 'John Doe', '2025-07-03', '2025-07-04', '#D05AB8'),
(110, 'banay banay', NULL, NULL, 1, NULL, 'Low', 0, '2025-07-03 10:45:53', NULL, NULL, 'banay banay', 'Cabuyao', 'Laguna', 'NBN', 'Downer', NULL, 'Team NSW', '2025-07-03', 'New', 'HOPS', '2025-07-04 00:40:30', 'John Doe', '2025-07-03', '2025-07-04', '#D05AB8'),
(111, 'calamba', NULL, NULL, 1, NULL, 'Low', 0, '2025-07-03 16:41:52', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', 'Team NSW', '2025-07-04', 'New', 'HOPS', '2025-07-04 01:11:25', 'John Doe', '2025-07-04', '2025-07-05', '#910B78'),
(112, 'pulo', NULL, NULL, 1, NULL, 'Low', 0, '2025-07-03 16:48:57', NULL, NULL, 'San Cristobal', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', 'Server', '2025-07-04', 'New', 'scope checking,plant hire,Call Testing', '2025-07-04 20:11:31', 'John Doe', '2025-07-04', '2025-07-05', '#FB1E20'),
(113, 'Banlic', NULL, NULL, 1, NULL, 'high', 0, '2025-07-03 17:21:30', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'Starlink', 'Downer', 'Ticket initially created.', NULL, '2025-06-20', 'New', 'site survey', '2025-07-04 01:21:30', NULL, '2025-06-20', '2025-06-23', ''),
(114, 'Banlic', NULL, NULL, 1, NULL, 'high', 0, '2025-07-03 17:22:28', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'Starlink', 'Downer', 'Ticket initially created.', NULL, '2025-06-20', 'New', 'RF Build', '2025-07-04 01:22:28', NULL, '2025-06-20', '2025-06-26', ''),
(115, 'pulo', NULL, NULL, 1, NULL, 'high', 0, '2025-07-04 12:11:55', NULL, NULL, 'pulo', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'Ticket initially created.', NULL, '2025-07-04', 'New', 'Call Testing', '2025-07-04 20:11:55', NULL, '2025-07-04', '2025-07-05', '#FB1E20');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_event`
--

CREATE TABLE `ticket_event` (
  `id` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `body` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'member',
  `avatar` varchar(150) DEFAULT NULL,
  `last_password` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `team_name` varchar(255) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `avatar`, `last_password`, `created_at`, `updated_at`, `team_name`, `team_id`) VALUES
(1, 'John Doe', 'johndoe@helpdesk.com', '8888888888', '$2y$10$PHXjdcPjksokkGryfqK.WePBgiQB30Gw.ytYBHdmGtqtoGtVHtAm.', 'admin', NULL, '$2y$10$PHXjdcPjksokkGryfqK.WePBgiQB30Gw.ytYBHdmGtqtoGtVHtAm.', '2025-03-26 06:12:12', '2019-05-19 09:01:34', 'Server', 1),
(47, 'Amador Comighod', 'amador@titan4.au', '0493902296', '$2y$10$mtjecUxSpoyjoKDC8yySLel72/Mz9RgLwAqtEt76YrR5kyYiO0fiy', 'member', NULL, '$2y$10$mtjecUxSpoyjoKDC8yySLel72/Mz9RgLwAqtEt76YrR5kyYiO0fiy', '2025-07-05 19:55:55', '2025-07-05 19:55:55', NULL, NULL),
(48, 'Daryl Leo Dela Cruz', 'darylleo@titan4.au', '0406766758', '$2y$10$d3pR0w0brGLszvFhc/a9..jrIOgG/zTcoQZEYNhfpvd9C7Qxz/zEu', 'member', NULL, '$2y$10$d3pR0w0brGLszvFhc/a9..jrIOgG/zTcoQZEYNhfpvd9C7Qxz/zEu', '2025-03-26 06:33:27', '2025-03-26 06:33:27', NULL, NULL),
(49, 'Descartes Misola', 'descartes@titan4.au', '0405976425', '$2y$10$NTSmkrCSHLIrdl6WrVoVa.S1OzTgjAKZxMnuoTdMlMTSOCBpRcwdW', 'member', NULL, '$2y$10$NTSmkrCSHLIrdl6WrVoVa.S1OzTgjAKZxMnuoTdMlMTSOCBpRcwdW', '2025-03-26 06:33:48', '2025-03-26 06:33:48', NULL, NULL),
(50, 'Dexter Gasco', 'dexter@titan4.au', '0412392973', '$2y$10$xoRKYBDshSvvwaAMQTQ4CeH/BrGxtNVqAyB2EC80MHJBOrQKDXyhu', 'member', NULL, '$2y$10$xoRKYBDshSvvwaAMQTQ4CeH/BrGxtNVqAyB2EC80MHJBOrQKDXyhu', '2025-03-26 06:34:15', '2025-03-26 06:34:15', NULL, NULL),
(51, 'Ed Rodulph Flores', 'ed@titan4.au', '0405990127', '$2y$10$3i85ZHUaFTUUHCFOBxwI1OG.TO8D81p6a3x9I/NwYVSKx.pHgTWcu', 'member', NULL, '$2y$10$3i85ZHUaFTUUHCFOBxwI1OG.TO8D81p6a3x9I/NwYVSKx.pHgTWcu', '2025-03-26 06:34:30', '2025-03-26 06:34:30', NULL, NULL),
(52, 'Emeterio Urbano', 'emeterio@titan4.au', '0476988703', '$2y$10$1tap8QKn4VFwEjqytHmzqOvlwYQVtai3/lhxRJK2PxnF6rRj6Q91u', 'member', NULL, '$2y$10$1tap8QKn4VFwEjqytHmzqOvlwYQVtai3/lhxRJK2PxnF6rRj6Q91u', '2025-03-26 06:34:50', '2025-03-26 06:34:50', NULL, NULL),
(53, 'Gilbert Aguilar', 'gilbert@titan4.au', '0475779807', '$2y$10$nl6U4VUYIaaqgMZp4/XtmegNBxRwKMxyl0DkRizz6CoIJcOcADDju', 'member', NULL, '$2y$10$nl6U4VUYIaaqgMZp4/XtmegNBxRwKMxyl0DkRizz6CoIJcOcADDju', '2025-03-26 06:35:06', '2025-03-26 06:35:06', NULL, NULL),
(54, 'Joeme Bazar', 'joeme@titan4.au', '0431074288', '$2y$10$/n7XpLkyXrXGCAin2eBQjOZ7a5jeGHxRVadJtxEKoypx1vQVXQpni', 'member', NULL, '$2y$10$/n7XpLkyXrXGCAin2eBQjOZ7a5jeGHxRVadJtxEKoypx1vQVXQpni', '2025-03-26 06:35:21', '2025-03-26 06:35:21', NULL, NULL),
(55, 'John Anthony Dela Cruz', 'john@titan4.au', '0426609134', '$2y$10$wgZ6SDdiovsjMM3Tp7OEI.piEDwh35KqN2qdLEabqTC.RF26rEqVa', 'member', NULL, '$2y$10$wgZ6SDdiovsjMM3Tp7OEI.piEDwh35KqN2qdLEabqTC.RF26rEqVa', '2025-03-26 06:35:38', '2025-03-26 06:35:38', NULL, NULL),
(56, 'John Paulo Ocasion', 'john.ocasion@titan4communications.com.au', '0413168398', '$2y$10$W0UeP2lfRVD3UGnvt0nAxu.5NV5oldKNt2an9Q3g/NKeHeD5/fBpW', 'member', NULL, '$2y$10$W0UeP2lfRVD3UGnvt0nAxu.5NV5oldKNt2an9Q3g/NKeHeD5/fBpW', '2025-03-26 06:35:55', '2025-03-26 06:35:55', NULL, NULL),
(57, 'John Stephen Cudal', 'stephen@titan4.au', '0413745761', '$2y$10$MlKxOgDqe9IuDKBlVMVNduxZKs4DCqgKU7hNm0obJ3atlr4Qd.HHq', 'member', NULL, '$2y$10$MlKxOgDqe9IuDKBlVMVNduxZKs4DCqgKU7hNm0obJ3atlr4Qd.HHq', '2025-03-26 06:36:31', '2025-03-26 06:36:31', NULL, NULL),
(58, 'Johnson Ritualo', 'johnson@titan4.au', '0421848055', '$2y$10$U2NIgcBDpypr0Mt0eoAXHuVFn4eHA12jKG3tpQ/F3uQImjQZWU8Me', 'member', NULL, '$2y$10$U2NIgcBDpypr0Mt0eoAXHuVFn4eHA12jKG3tpQ/F3uQImjQZWU8Me', '2025-03-26 06:36:44', '2025-03-26 06:36:44', NULL, NULL),
(59, 'Mandy Paladan', 'mandy@titan4.au', '0493902460', '$2y$10$4YP/jI0Mot0xX.gKc5kg6uAnk0LrtO/irepSGfVpafXL32ngED3jm', 'member', NULL, '$2y$10$4YP/jI0Mot0xX.gKc5kg6uAnk0LrtO/irepSGfVpafXL32ngED3jm', '2025-03-26 06:36:59', '2025-03-26 06:36:59', NULL, NULL),
(60, 'Marc Dominic Camba', 'marcdominic@titan4.au', '0426792824', '$2y$10$63CXHbbrsX.7giiZY7Rmc.lyvDcI9rOm8kWmQ1ZIlRizrdGRJ5W5e', 'member', NULL, '$2y$10$63CXHbbrsX.7giiZY7Rmc.lyvDcI9rOm8kWmQ1ZIlRizrdGRJ5W5e', '2025-03-26 06:37:23', '2025-03-26 06:37:23', NULL, NULL),
(61, 'Mark Arjay Marto', 'mark@titan4.au', '0416161739', '$2y$10$ieaEjhLNNFvecT/MXjSHoubfaDwBKNDjrwfPoj4DZGD/YvaUQonM2', 'member', NULL, '$2y$10$ieaEjhLNNFvecT/MXjSHoubfaDwBKNDjrwfPoj4DZGD/YvaUQonM2', '2025-03-26 06:37:34', '2025-03-26 06:37:34', NULL, NULL),
(62, 'Patrick Martinez', 'patrick@titan4communications.com.au', '0403349928', '$2y$10$A/jyLByiDMlFsJAksifDOubyKUfBRLr9gmzdWcVgn2pl7fJlLwJn2', 'member', NULL, '$2y$10$A/jyLByiDMlFsJAksifDOubyKUfBRLr9gmzdWcVgn2pl7fJlLwJn2', '2025-03-26 06:37:48', '2025-03-26 06:37:48', NULL, NULL),
(63, 'Rhunder Ryan Vale', 'rhunder@titan4communications.com.au', '0413108401', '$2y$10$2qh856CrRyl68qT37qWibOKirPbDYcxMKkOauzV0UkGD7yzOLinPC', 'member', NULL, '$2y$10$2qh856CrRyl68qT37qWibOKirPbDYcxMKkOauzV0UkGD7yzOLinPC', '2025-03-26 06:38:01', '2025-03-26 06:38:01', NULL, NULL),
(64, 'Roland Rapanot', 'roland@titan4.au', '0422627722', '$2y$10$vhaKtVWoG/GRyIGNTUXLX.4sJhilmOya3zGr/QWwtSMtm5bvaS4Jq', 'member', NULL, '$2y$10$vhaKtVWoG/GRyIGNTUXLX.4sJhilmOya3zGr/QWwtSMtm5bvaS4Jq', '2025-03-26 06:38:14', '2025-03-26 06:38:14', NULL, NULL),
(65, 'Wynedol Corpuz', 'wynedol@titan4.au', '0410637189', '$2y$10$yi9nPUBhD61tEeB3RYDOKuJwxCsWdPljRK1MpZ4s/UbF4XoLVv55G', 'member', NULL, '$2y$10$yi9nPUBhD61tEeB3RYDOKuJwxCsWdPljRK1MpZ4s/UbF4XoLVv55G', '2025-03-26 06:38:28', '2025-03-26 06:38:28', NULL, NULL),
(66, 'Elijah Cruz', 'elijah@titan4.au', '0491070458', '$2y$10$zoisYH7Lk6RVHq4tCR6j0.6A/bh6qgFdKhGfn91XIz.3KhnmLtS4y', 'member', NULL, '$2y$10$zoisYH7Lk6RVHq4tCR6j0.6A/bh6qgFdKhGfn91XIz.3KhnmLtS4y', '2025-03-26 06:38:40', '2025-03-26 06:38:40', NULL, NULL),
(67, 'Christian Quilapio', 'christian@titan4.au', '0455442847', '$2y$10$7jJJN4oGuaw2Q1WUX4ELGOG/5qKTVrvd5O7gWTURL9Qh34wQJiYuy', 'member', NULL, '$2y$10$7jJJN4oGuaw2Q1WUX4ELGOG/5qKTVrvd5O7gWTURL9Qh34wQJiYuy', '2025-03-26 06:38:52', '2025-03-26 06:38:52', NULL, NULL),
(68, 'Ariel Jr. Gernale', 'ariel@titan4.au', '0499645363', '$2y$10$8h47jlZcR2kO1c5HawhAV.Ox8dLAx1eZ.lVjK2p/8KL678Fq.xBIG', 'member', NULL, '$2y$10$8h47jlZcR2kO1c5HawhAV.Ox8dLAx1eZ.lVjK2p/8KL678Fq.xBIG', '2025-03-26 06:39:05', '2025-03-26 06:39:05', NULL, NULL),
(69, 'Carl Vincent Marquez', 'carl.vincent@titan4.au', '0450430266', '$2y$10$THQb7b4YO7mBZCZEoVDcUuS1JRAxKqLfW68WpqYfFhkdBSDjpWC5y', 'member', NULL, '$2y$10$THQb7b4YO7mBZCZEoVDcUuS1JRAxKqLfW68WpqYfFhkdBSDjpWC5y', '2025-03-26 06:40:02', '2025-03-26 06:40:02', NULL, NULL),
(70, 'Emerzon Pangan', 'emerzon@titan4.au', '0493902459', '$2y$10$lvXQ0Zrqp2gYeDPMga6RW.CD2T8tI6ceKMTGuhKiUWpAPlRi4vwLa', 'member', NULL, '$2y$10$lvXQ0Zrqp2gYeDPMga6RW.CD2T8tI6ceKMTGuhKiUWpAPlRi4vwLa', '2025-03-26 06:40:20', '2025-03-26 06:40:20', NULL, NULL),
(71, 'Federick Fernandez', 'federick@titan4.au', '0412284724', '$2y$10$qvTSMGUrbtF6bDFjuJN7XOhDNDsnVHfLUPE7veI4UV0drR/g6FkpS', 'member', NULL, '$2y$10$qvTSMGUrbtF6bDFjuJN7XOhDNDsnVHfLUPE7veI4UV0drR/g6FkpS', '2025-03-26 06:40:35', '2025-03-26 06:40:35', NULL, NULL),
(72, 'Ian Patrick Arenas', 'ian@titan4.au', '0452275652', '$2y$10$fbXdBD80ZjAqfOXx8yYW7.X5Fie.R/V2tyfuZNKrsY4gnCdbZQi/S', 'member', NULL, '$2y$10$fbXdBD80ZjAqfOXx8yYW7.X5Fie.R/V2tyfuZNKrsY4gnCdbZQi/S', '2025-03-26 06:40:51', '2025-03-26 06:40:51', NULL, NULL),
(73, 'Jads Limuel Dana', 'jads@titan4.au', '0466432577', '$2y$10$AQeQDf3Rf7dTkTyFOTqT2OCdJyXnWXBHuOFr27wIf.gubrx2s9lkS', 'member', NULL, '$2y$10$AQeQDf3Rf7dTkTyFOTqT2OCdJyXnWXBHuOFr27wIf.gubrx2s9lkS', '2025-03-26 06:41:09', '2025-03-26 06:41:09', NULL, NULL),
(74, 'Julius Datiles', 'julius@titan4.au', '0450222030', '$2y$10$K2Rq/YjDPlSGtKjay3zKt.mT33ISCajRA4COkBjWEP0OHRlYvebFe', 'member', NULL, '$2y$10$K2Rq/YjDPlSGtKjay3zKt.mT33ISCajRA4COkBjWEP0OHRlYvebFe', '2025-03-26 06:41:28', '2025-03-26 06:41:28', NULL, NULL),
(75, 'Kurt Benedict Martinez', 'kurtmartinez@titan4.au', '0426727087', '$2y$10$gHhMk4L0w4pW/JkGDhWzgOW8sL53kPZVXb6Nsmk6Bl.mHiUgkyQJK', 'member', NULL, '$2y$10$gHhMk4L0w4pW/JkGDhWzgOW8sL53kPZVXb6Nsmk6Bl.mHiUgkyQJK', '2025-03-26 06:41:41', '2025-03-26 06:41:41', NULL, NULL),
(76, 'Lorenzo Pasamonte', 'lorenzo@titan4.au', '0493320376', '$2y$10$rjosrWX/FlvS7xeQ39oThO.aCAunRRS.pTsVht.iiU8MJ8Y7puaVq', 'member', NULL, '$2y$10$rjosrWX/FlvS7xeQ39oThO.aCAunRRS.pTsVht.iiU8MJ8Y7puaVq', '2025-03-26 06:41:53', '2025-03-26 06:41:53', NULL, NULL),
(77, 'Marc Irvin Camba', 'marcirvin@titan4.au', '0459895821', '$2y$10$wO74yu/pCWnQGIFWRdC4eewnuVo6OrNEyOic1A2MYhdg5QGazdpn2', 'member', NULL, '$2y$10$wO74yu/pCWnQGIFWRdC4eewnuVo6OrNEyOic1A2MYhdg5QGazdpn2', '2025-03-26 06:42:06', '2025-03-26 06:42:06', NULL, NULL),
(78, 'Marueen Meredor', 'marueen@titan4communications.com.au', '0411820449', '$2y$10$f9pxHjMDE3cCq7.3t6g9rukqnjgMELWStOk.DF9vdLgHttRpzyHZe', 'member', NULL, '$2y$10$f9pxHjMDE3cCq7.3t6g9rukqnjgMELWStOk.DF9vdLgHttRpzyHZe', '2025-03-26 06:42:19', '2025-03-26 06:42:19', NULL, NULL),
(79, 'Michael Montevirgen', 'michael@titan4.au', '0493691695', '$2y$10$E2CELYD00KD8fl5fwVklWudt3z3NxTQyOchZtbFaCZpgHmKM1qIMK', 'member', NULL, '$2y$10$E2CELYD00KD8fl5fwVklWudt3z3NxTQyOchZtbFaCZpgHmKM1qIMK', '2025-03-26 06:42:33', '2025-03-26 06:42:33', NULL, NULL),
(80, 'Ramzel Klarke Bismonte', 'klarke@titan4.au', '0492894488', '$2y$10$F.s0R1uzuVPUJ8XXm7IuP.yEAhlBjv44/ixCvY1JcjT7YzKsA0O5m', 'member', NULL, '$2y$10$F.s0R1uzuVPUJ8XXm7IuP.yEAhlBjv44/ixCvY1JcjT7YzKsA0O5m', '2025-03-26 06:42:47', '2025-03-26 06:42:47', NULL, NULL),
(81, 'Ronee Lee Celestial', 'ronee@titan4.au', '0421720903', '$2y$10$h9bFdMmGOx9VLnKWum3Beu9LDpNxwhGktTJkK/VOWuvON8yIOJjmG', 'member', NULL, '$2y$10$h9bFdMmGOx9VLnKWum3Beu9LDpNxwhGktTJkK/VOWuvON8yIOJjmG', '2025-03-26 06:43:00', '2025-03-26 06:43:00', NULL, NULL),
(82, 'Willymer Ricohermoso', 'willymer.ricohermoso@titan4.au', '0423643302', '$2y$10$IqwZu.LpacUFHBieC0q3q.R0p6Slm7kq0o2HEJxSoNVGEipEx04oi', 'member', NULL, '$2y$10$IqwZu.LpacUFHBieC0q3q.R0p6Slm7kq0o2HEJxSoNVGEipEx04oi', '2025-03-26 06:43:14', '2025-03-26 06:43:14', NULL, NULL),
(83, 'Gerald Van Elipasqua', 'van@titan4.au', '0450638239', '$2y$10$sYz22agWyJJoKcsHJr8ddux0Rb151/LDxe1WUhG/8xJoDQvY83nsi', 'member', NULL, '$2y$10$sYz22agWyJJoKcsHJr8ddux0Rb151/LDxe1WUhG/8xJoDQvY83nsi', '2025-03-26 06:43:27', '2025-03-26 06:43:27', NULL, NULL),
(84, 'Daniel Angelo Fernandez', 'daniel@titan4.au', '0414141946', '$2y$10$kfnElByxkIJRquIcr94sIu914I66cMNbnVXt8457LgWFLBF2yGuc6', 'member', NULL, '$2y$10$kfnElByxkIJRquIcr94sIu914I66cMNbnVXt8457LgWFLBF2yGuc6', '2025-03-26 06:43:41', '2025-03-26 06:43:41', NULL, NULL),
(85, 'Elmer Dela Cruz', 'elmer@titan4communications.com.au', '0499401007', '$2y$10$QEtppvywRxYI2rdma6fZEuuqYAs4z.IKfGxt7xKP.XmF0W8Q19tf6', 'admin', NULL, '$2y$10$QEtppvywRxYI2rdma6fZEuuqYAs4z.IKfGxt7xKP.XmF0W8Q19tf6', '2025-03-26 06:48:10', '2025-03-26 06:45:32', NULL, NULL),
(86, 'Enrydave Vale', 'enrydave@titan4communications.com.au', '0493902296', '$2y$10$s07BNdmdGyDELQBBscCz5ebfX3oBZFxbHFqgQXUrxC7KZaRE5zy.a', 'admin', NULL, '$2y$10$s07BNdmdGyDELQBBscCz5ebfX3oBZFxbHFqgQXUrxC7KZaRE5zy.a', '2025-03-26 06:48:16', '2025-03-26 06:45:57', NULL, NULL),
(87, 'Florence Marte', 'florence@titan4communications.com.au', '0493902296', '$2y$10$TB/pbyf1Yhn/frpBHeGHiuY5WYZ8r6oT.x2XtKwvt.5oej.1Vkc5i', 'admin', NULL, '$2y$10$TB/pbyf1Yhn/frpBHeGHiuY5WYZ8r6oT.x2XtKwvt.5oej.1Vkc5i', '2025-03-26 06:48:17', '2025-03-26 06:46:10', NULL, NULL),
(88, 'Harold Moscoso', 'harold@titan4.au', '0493902296', '$2y$10$Xh6nOyOJMa.u7rNIHMnY9uKac80dM9MPCyHkKGJ6u88pkJTtCowsK', 'admin', NULL, '$2y$10$Xh6nOyOJMa.u7rNIHMnY9uKac80dM9MPCyHkKGJ6u88pkJTtCowsK', '2025-03-26 06:48:18', '2025-03-26 06:46:25', NULL, NULL),
(89, 'Mark John Paul Sonio', 'mjpaul@titan4.au', '0493902296', '$2y$10$a3qKBICNVrIl51KhJZvL5u99dJjnzRB7QYz1Jyh5pNa6BcUWBPl9m', 'admin', NULL, '$2y$10$a3qKBICNVrIl51KhJZvL5u99dJjnzRB7QYz1Jyh5pNa6BcUWBPl9m', '2025-03-26 06:48:19', '2025-03-26 06:46:39', NULL, NULL),
(90, 'Jads Limuel Dana ', 'jads@titan4.au', '0466432577', '$2y$10$5NKOr7TNE2nF4ucRWwIWoeO4m.kT3jsRVCfty3pltWiZ5Ide3qXPK', 'admin', NULL, '$2y$10$5NKOr7TNE2nF4ucRWwIWoeO4m.kT3jsRVCfty3pltWiZ5Ide3qXPK', '2025-03-26 06:48:20', '2025-03-26 06:46:54', NULL, NULL),
(91, 'Margret Lim', 'margret@titan4.au', '0402504029', '$2y$10$CJaNnWon2ei4j7EcxaWEseO1lWApwxMzG6B55WVCmTDpTXZFt/CRy', 'admin', NULL, '$2y$10$CJaNnWon2ei4j7EcxaWEseO1lWApwxMzG6B55WVCmTDpTXZFt/CRy', '2025-03-26 06:48:22', '2025-03-26 06:47:07', NULL, NULL),
(92, 'Mervilyn Derilo', 'hopsadmin@titan4.au', '0434702549', '$2y$10$BO//v/bc4MzKpyIxKnCh2uK1QCkXuztM6kUTJGFdojxA6kW1YwlCm', 'admin', NULL, '$2y$10$BO//v/bc4MzKpyIxKnCh2uK1QCkXuztM6kUTJGFdojxA6kW1YwlCm', '2025-07-15 04:21:28', '2025-03-26 06:47:20', 'Team NSW', 7),
(93, 'Alma Sadama', 'alma@titan4.au', '0433447952', '$2y$10$kD/1kzYSjdAyMxYK4WCmnuU8Zlpz/qCvuBeO6TWxLo8yIbbGlL4.G', 'admin', NULL, '$2y$10$kD/1kzYSjdAyMxYK4WCmnuU8Zlpz/qCvuBeO6TWxLo8yIbbGlL4.G', '2025-07-05 18:47:08', '2025-07-05 18:47:08', NULL, NULL),
(94, 'Rizza Vale', 'admin@titan4communications.com.au', '0466440128', '$2y$10$zHPbtc0zCrr/vJObuWsgD.o9B7sclUAHba1vMENpUxGvgA9M2veDe', 'admin', NULL, '$2y$10$zHPbtc0zCrr/vJObuWsgD.o9B7sclUAHba1vMENpUxGvgA9M2veDe', '2025-03-26 06:48:27', '2025-03-26 06:47:45', NULL, NULL),
(95, 'Zenda Dela Cruz', 'zenda@titan4communications.com.au', '0435722264', '$2y$10$IGBiJlJzvvV6XnSX/gQB/.Z9PgiWSEdNCoW7ogpwpF3Cn0.bVlpvS', 'admin', NULL, '$2y$10$IGBiJlJzvvV6XnSX/gQB/.Z9PgiWSEdNCoW7ogpwpF3Cn0.bVlpvS', '2025-03-26 06:48:28', '2025-03-26 06:47:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_notes`
--

CREATE TABLE `work_notes` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `requester`
--
ALTER TABLE `requester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_event`
--
ALTER TABLE `ticket_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_notes`
--
ALTER TABLE `work_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=407;

--
-- AUTO_INCREMENT for table `requester`
--
ALTER TABLE `requester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `ticket_event`
--
ALTER TABLE `ticket_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `work_notes`
--
ALTER TABLE `work_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_notes`
--
ALTER TABLE `work_notes`
  ADD CONSTRAINT `work_notes_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
