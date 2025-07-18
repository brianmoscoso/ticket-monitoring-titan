-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 04:32 PM
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
  `team_member` int(11) NOT NULL,
  `private` int(11) NOT NULL DEFAULT 0,
  `body` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `ticket`, `team_member`, `private`, `body`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 0, 'comment', '2019-05-31 13:54:56', '2019-05-31 13:54:56'),
(2, 2, 1, 0, 'comment on ticket', '2019-05-31 13:57:19', '2019-05-31 13:57:19'),
(3, 3, 4, 0, 'test comment', '2019-06-03 16:59:16', '2019-06-03 16:59:16'),
(4, 3, 4, 0, 'test ticket comment', '2019-06-03 16:59:43', '2019-06-03 16:59:43'),
(5, 10, 4, 0, 'ddmo', '2023-03-20 07:01:34', '2023-03-20 07:01:34'),
(6, 8, 4, 0, 'zxdczxc', '2025-02-04 13:27:26', '2025-02-04 13:27:26'),
(7, 14, 4, 0, 'zxczxc', '2025-02-04 14:21:33', '2025-02-04 14:21:33');

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

--
-- Dumping data for table `requester`
--

INSERT INTO `requester` (`id`, `name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(31, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:24:08', '2019-05-19 13:24:08'),
(32, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:45:22', '2019-05-19 13:45:22'),
(33, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:46:01', '2019-05-19 13:46:01'),
(34, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:46:27', '2019-05-19 13:46:27'),
(35, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:47:51', '2019-05-19 13:47:51'),
(36, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:48:31', '2019-05-19 13:48:31'),
(37, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:48:37', '2019-05-19 13:48:37'),
(38, 'mofiqul', 'example@email.com', '9876543210', '2019-05-19 13:51:05', '2019-05-19 13:51:05'),
(39, 'injamul ', 'injamul.haque6@gmail.com', '8822677188', '2019-05-23 17:18:25', '2019-05-23 17:18:25'),
(40, 'injamul ', 'injamul.haque6@gmail.com', '8822677188', '2019-05-30 13:55:17', '2019-05-30 13:55:17'),
(41, 'test', 'kangkan@email.com', '1234567898', '2019-06-07 02:07:43', '2019-06-07 02:07:43'),
(42, 'test ticket', 'johndoe@helpdesk.com', '1234567898', '2019-06-07 02:11:23', '2019-06-07 02:11:23'),
(43, 'test123', 'kangkan@email.com', '1234567898', '2019-06-07 06:51:33', '2019-06-07 06:51:33'),
(44, 'test ticket', 'johndoe@helpdesk.com', '1234567898', '2019-06-07 06:52:04', '2019-06-07 06:52:04'),
(45, 'demo ticket', 'demo@email.com', '1234567899', '2023-03-20 06:57:25', '2023-03-20 06:57:25'),
(46, 'demo', 'demo@email.com', '1234567899', '2023-03-20 11:11:23', '2023-03-20 11:11:23'),
(47, 'brian', 'johndoe@helpdesk.com', '9456190745', '2025-01-24 09:10:36', '2025-01-24 09:10:36'),
(48, 'John Doe', 'johndoe@helpdesk.com', '9456190745', '2025-01-24 09:12:45', '2025-01-24 09:12:45'),
(49, 'test ticket', 'johndoe@helpdesk.com', '9456190745', '2025-01-29 04:44:44', '2025-01-29 04:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `site_name` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `site_name`, `created_at`, `updated_at`) VALUES
(4, 'Banlic', '2025-02-13 09:09:01', '2025-02-13 09:09:01'),
(5, 'Mamatid', '2025-02-15 02:21:20', '2025-02-15 02:21:20'),
(6, 'San Isidro', '2025-02-15 02:21:35', '2025-02-15 02:21:35');

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
(2, 'Devops', '2019-05-19 09:49:15', '2019-05-19 09:49:15'),
(3, 'injamul ', '2019-05-23 19:16:36', '2019-05-23 19:16:36'),
(4, 'programmers', '2025-02-16 13:03:38', '2025-02-16 13:03:38');

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
(4, '', '4', '2025-02-16 14:39:06', '2025-02-16 14:39:06', 'Alex', 'programmers'),
(5, '', '2', '2025-02-16 15:02:55', '2025-02-16 15:02:55', 'brian', 'Devops');

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
  `work_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `title`, `body`, `requester`, `team`, `team_member`, `priority`, `rating`, `created_at`, `updated_at`, `deleted_at`, `site_name`, `cluster`, `state`, `project`, `vendor`, `remarks`, `team_assigned`, `schedule_date`, `status`, `work_type`) VALUES
(48, 'Banlic', NULL, NULL, 0, NULL, 'medium', 0, '2025-02-15 18:36:46', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'CRQQQ', 'Devops', '2025-02-16', 'On-going', 'Comm CL'),
(49, 'Banlic', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 13:39:43', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'TELSTRA', 'Downer', 'CRQW', 'programmers', '2025-02-16', 'New', 'HOPS,Link Upgrade'),
(50, 'Mamatid', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 13:47:13', NULL, NULL, 'Mamatid', 'Cabuyao', 'Laguna', 'EJV', 'Downer', '', 'programmers', '2025-02-17', 'On-going', 'Link Upgrade'),
(51, 'Mamatid', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 14:48:05', NULL, NULL, 'Mamatid', 'Cabuyao', 'Laguna', 'EJV', 'Downer', 'CRQQ', 'Devops', '2025-02-20', 'On Hold', 'Link Upgrade,Link Rectification,Comm CL'),
(52, 'San Isidro', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 14:49:30', NULL, NULL, 'San Isidro', 'Cabuyao', 'Laguna', 'TELSTRA', 'Downer', 'CRQ', 'Devops', '2025-02-19', 'On-going', 'HOPS,Link Upgrade'),
(53, 'Banlic', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 14:55:28', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'wqeq', 'Server', '2025-02-16', 'On-going', 'HOPS,Link Upgrade'),
(54, 'Banlic', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 15:01:03', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'CRQRQRQ', 'Server', '2025-02-16', 'On Hold', 'HOPS,Link Upgrade,Link Rectification'),
(55, 'Banlic', NULL, NULL, 0, NULL, 'high', 0, '2025-02-16 15:03:20', NULL, NULL, 'Banlic', 'Cabuyao', 'Laguna', 'NBN', 'Downer', 'CRQQ', 'Devops', '2025-02-22', 'New', 'HOPS,Link Upgrade,Link Rectification,Comm CL,SWR installation');

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

--
-- Dumping data for table `ticket_event`
--

INSERT INTO `ticket_event` (`id`, `ticket`, `user`, `body`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'Ticket created', '2019-05-23 17:18:25', '2019-05-23 17:18:25'),
(2, 5, 1, 'Ticket created', '2019-05-30 13:55:17', '2019-05-30 13:55:17'),
(3, 6, 1, 'Ticket created', '2019-06-07 02:07:43', '2019-06-07 02:07:43'),
(4, 7, 1, 'Ticket created', '2019-06-07 02:11:23', '2019-06-07 02:11:23'),
(5, 8, 4, 'Ticket created', '2019-06-07 06:51:33', '2019-06-07 06:51:33'),
(6, 9, 4, 'Ticket created', '2019-06-07 06:52:04', '2019-06-07 06:52:04'),
(7, 10, 1, 'Ticket created', '2023-03-20 06:57:25', '2023-03-20 06:57:25'),
(8, 11, 1, 'Ticket created', '2023-03-20 11:11:23', '2023-03-20 11:11:23'),
(9, 12, 1, 'Ticket created', '2025-01-24 09:10:36', '2025-01-24 09:10:36'),
(10, 13, 1, 'Ticket created', '2025-01-24 09:12:45', '2025-01-24 09:12:45'),
(11, 14, 1, 'Ticket created', '2025-01-29 04:44:44', '2025-01-29 04:44:44');

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
  `team_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `avatar`, `last_password`, `created_at`, `updated_at`, `team_name`) VALUES
(1, 'John Doe', 'johndoe@helpdesk.com', '8888888888', '$2y$10$PHXjdcPjksokkGryfqK.WePBgiQB30Gw.ytYBHdmGtqtoGtVHtAm.', 'admin', NULL, '$2y$10$PHXjdcPjksokkGryfqK.WePBgiQB30Gw.ytYBHdmGtqtoGtVHtAm.', '2025-02-16 14:54:46', '2019-05-19 09:01:34', 'Server'),
(3, 'injamul ', 'johndoe@helpdesk.com', '1234567899', '$2y$10$6N4gbdypYQvRkU2ke9Q1f.Gm4fcGY/PEpv2rSB77wiSLZaOy8kq5i', 'member', NULL, '$2y$10$6N4gbdypYQvRkU2ke9Q1f.Gm4fcGY/PEpv2rSB77wiSLZaOy8kq5i', '2023-03-20 07:16:07', '2019-05-24 07:58:53', NULL),
(4, 'Alex', 'kangkan@email.com', '9999999999', '$2y$10$Q0rxoFO4fSrcdp58CO0RNOSDP7znVc9eGY6Z4xjQ8MTLHYhx0TF.6', 'member', NULL, '$2y$10$Q0rxoFO4fSrcdp58CO0RNOSDP7znVc9eGY6Z4xjQ8MTLHYhx0TF.6', '2025-02-16 14:39:06', '2019-05-30 08:49:22', 'programmers'),
(5, 'brian', 'brian@gmail.com', '9456190745', '$2y$10$TWZ8VL/qUHODPlGFoZl0DuEfvh/mqV6yX82iTB15hknEJezdy.UJe', 'member', NULL, '$2y$10$TWZ8VL/qUHODPlGFoZl0DuEfvh/mqV6yX82iTB15hknEJezdy.UJe', '2025-02-16 15:02:55', '2025-02-16 15:02:47', 'Devops');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `requester`
--
ALTER TABLE `requester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `ticket_event`
--
ALTER TABLE `ticket_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
