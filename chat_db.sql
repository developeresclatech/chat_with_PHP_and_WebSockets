-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 02:44 PM
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
-- Database: `chat_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `created_at`, `updated_at`) VALUES
(27, '2024-10-13 22:45:06', '2024-10-13 13:45:06'),
(28, '2024-10-13 23:53:02', '2024-10-13 14:53:02'),
(29, '2024-10-13 23:53:34', '2024-10-13 14:53:34'),
(30, '2024-10-14 05:37:15', '2024-10-13 20:37:15'),
(31, '2024-10-14 05:38:58', '2024-10-13 20:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `conversation_participants`
--

CREATE TABLE `conversation_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation_participants`
--

INSERT INTO `conversation_participants` (`id`, `conversation_id`, `user_id`, `joined_at`) VALUES
(31, 27, 39, '2024-10-13 13:49:43'),
(32, 27, 39, '2024-10-13 14:31:09'),
(33, 27, 39, '2024-10-13 14:31:11'),
(34, 27, 39, '2024-10-13 14:31:11'),
(35, 27, 39, '2024-10-13 14:31:12'),
(36, 27, 39, '2024-10-13 14:31:12'),
(37, 27, 39, '2024-10-13 14:31:12'),
(38, 27, 39, '2024-10-13 14:31:12'),
(39, 27, 39, '2024-10-13 14:31:13'),
(40, 27, 39, '2024-10-13 14:31:13'),
(41, 27, 39, '2024-10-13 14:31:13'),
(42, 27, 39, '2024-10-13 14:31:15'),
(43, 27, 39, '2024-10-13 14:32:39'),
(44, 27, 39, '2024-10-13 14:35:11'),
(45, 27, 39, '2024-10-13 14:42:33'),
(46, 27, 39, '2024-10-13 14:43:06'),
(47, 27, 39, '2024-10-13 14:52:14'),
(48, 27, 39, '2024-10-13 14:52:22'),
(49, 27, 40, '2024-10-13 14:54:43'),
(50, 27, 39, '2024-10-13 14:54:51'),
(51, 27, 39, '2024-10-13 14:59:13'),
(52, 27, 39, '2024-10-13 16:42:31'),
(53, 27, 40, '2024-10-13 16:43:54'),
(54, 27, 40, '2024-10-13 16:44:50'),
(55, 27, 40, '2024-10-13 16:47:41'),
(56, 27, 40, '2024-10-13 17:29:04'),
(57, 27, 40, '2024-10-13 17:30:00'),
(58, 27, 40, '2024-10-13 17:31:04'),
(59, 27, 40, '2024-10-13 17:31:07'),
(60, 27, 40, '2024-10-13 17:31:07'),
(61, 27, 40, '2024-10-13 17:31:08'),
(62, 27, 40, '2024-10-13 17:31:08'),
(63, 27, 40, '2024-10-13 17:31:27'),
(64, 27, 39, '2024-10-13 17:31:43'),
(65, 27, 39, '2024-10-13 17:32:05'),
(66, 27, 40, '2024-10-13 17:35:26'),
(67, 27, 40, '2024-10-13 17:35:28'),
(68, 27, 40, '2024-10-13 17:35:28'),
(69, 27, 40, '2024-10-13 17:35:29'),
(70, 27, 40, '2024-10-13 17:35:29'),
(71, 27, 40, '2024-10-13 17:35:29'),
(72, 27, 40, '2024-10-13 17:36:20'),
(73, 27, 40, '2024-10-13 17:44:37'),
(74, 27, 39, '2024-10-13 17:45:49'),
(75, 27, 40, '2024-10-13 17:47:52'),
(76, 27, 39, '2024-10-13 17:49:18'),
(77, 27, 39, '2024-10-13 17:50:35'),
(78, 27, 39, '2024-10-13 17:51:39'),
(79, 27, 39, '2024-10-13 17:54:50'),
(80, 27, 39, '2024-10-13 17:58:08'),
(81, 27, 40, '2024-10-13 18:02:24'),
(82, 27, 39, '2024-10-13 19:38:53'),
(83, 27, 39, '2024-10-13 19:42:45'),
(84, 27, 39, '2024-10-13 19:48:44'),
(85, 27, 39, '2024-10-15 10:53:07'),
(86, 27, 40, '2024-10-15 10:53:35'),
(87, 27, 40, '2024-10-15 10:53:40'),
(88, 27, 40, '2024-10-15 10:53:44'),
(89, 27, 39, '2024-10-15 10:54:10'),
(90, 27, 39, '2024-10-15 10:54:13'),
(91, 27, 40, '2024-10-15 10:54:16'),
(92, 27, 40, '2024-10-15 10:54:19'),
(93, 27, 39, '2024-10-15 10:54:25'),
(94, 27, 40, '2024-10-15 10:54:59'),
(95, 27, 40, '2024-10-15 10:55:03'),
(96, 27, 40, '2024-10-15 10:55:05'),
(97, 27, 40, '2024-10-15 10:55:07'),
(98, 27, 40, '2024-10-15 10:55:08'),
(99, 27, 40, '2024-10-15 10:55:08'),
(100, 27, 40, '2024-10-15 10:55:54'),
(101, 27, 40, '2024-10-15 10:56:41'),
(102, 27, 40, '2024-10-15 10:56:45'),
(103, 27, 39, '2024-10-15 10:57:31'),
(104, 27, 39, '2024-10-15 10:57:35'),
(105, 27, 40, '2024-10-15 10:57:45'),
(106, 27, 39, '2024-10-15 10:58:32'),
(107, 27, 39, '2024-10-15 10:58:35'),
(108, 27, 40, '2024-10-15 10:58:54'),
(109, 27, 39, '2024-10-15 10:59:59'),
(110, 27, 39, '2024-10-15 11:00:03'),
(111, 27, 40, '2024-10-15 11:00:36'),
(112, 27, 40, '2024-10-15 11:00:43'),
(113, 27, 40, '2024-10-15 11:01:44'),
(114, 27, 40, '2024-10-15 11:02:00'),
(115, 27, 39, '2024-10-15 11:02:17'),
(116, 27, 40, '2024-10-15 11:02:24'),
(117, 27, 39, '2024-10-15 11:02:41'),
(118, 27, 40, '2024-10-15 11:02:47'),
(119, 27, 39, '2024-10-15 11:18:20'),
(120, 27, 39, '2024-10-15 11:18:25'),
(121, 27, 39, '2024-10-15 11:18:33'),
(122, 27, 39, '2024-10-15 11:18:35'),
(123, 27, 39, '2024-10-15 11:19:47'),
(124, 27, 39, '2024-10-15 11:20:03'),
(125, 27, 39, '2024-10-15 11:22:44'),
(126, 27, 39, '2024-10-15 11:23:05'),
(127, 27, 39, '2024-10-15 11:23:15'),
(128, 27, 39, '2024-10-15 11:23:21'),
(129, 27, 39, '2024-10-15 11:23:54'),
(130, 27, 39, '2024-10-15 11:24:45'),
(131, 27, 39, '2024-10-15 11:36:16'),
(132, 27, 39, '2024-10-15 11:36:19'),
(133, 27, 39, '2024-10-15 11:36:22'),
(134, 27, 39, '2024-10-15 11:36:43'),
(135, 27, 39, '2024-10-15 11:41:46'),
(136, 27, 39, '2024-10-15 11:42:25'),
(137, 27, 39, '2024-10-15 11:45:53'),
(138, 27, 39, '2024-10-15 11:46:43'),
(139, 27, 39, '2024-10-15 11:47:07'),
(140, 27, 39, '2024-10-15 11:47:10'),
(141, 27, 39, '2024-10-15 11:49:26'),
(142, 27, 39, '2024-10-15 11:49:30'),
(143, 27, 39, '2024-10-15 11:54:41'),
(144, 27, 39, '2024-10-15 11:54:53'),
(145, 27, 39, '2024-10-15 11:57:15'),
(146, 27, 39, '2024-10-15 11:57:24'),
(147, 27, 39, '2024-10-15 11:57:26'),
(148, 27, 39, '2024-10-15 11:58:32'),
(149, 27, 39, '2024-10-15 11:58:46'),
(150, 27, 39, '2024-10-15 12:04:08'),
(151, 27, 39, '2024-10-15 12:07:39'),
(152, 27, 39, '2024-10-15 12:07:42'),
(153, 27, 39, '2024-10-15 12:08:04'),
(154, 27, 39, '2024-10-15 12:08:09'),
(155, 27, 39, '2024-10-15 12:08:48'),
(156, 27, 39, '2024-10-15 12:10:14'),
(157, 27, 39, '2024-10-15 12:21:56'),
(158, 27, 39, '2024-10-15 12:21:58'),
(159, 27, 39, '2024-10-15 12:22:00'),
(160, 27, 39, '2024-10-15 12:22:00'),
(161, 27, 39, '2024-10-15 12:22:04'),
(162, 27, 39, '2024-10-15 12:22:05'),
(163, 27, 39, '2024-10-15 12:22:06'),
(164, 27, 39, '2024-10-15 12:22:06'),
(165, 27, 39, '2024-10-15 12:22:06'),
(166, 27, 39, '2024-10-15 12:22:06'),
(167, 27, 39, '2024-10-15 12:22:06'),
(168, 27, 39, '2024-10-15 12:22:06'),
(169, 27, 39, '2024-10-15 12:22:07'),
(170, 27, 39, '2024-10-15 12:22:07'),
(171, 27, 39, '2024-10-15 12:22:07'),
(172, 27, 39, '2024-10-15 12:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `message`, `created_at`) VALUES
(142, 27, 40, 'sa', '2024-10-15 10:53:44'),
(146, 27, 40, 'ee', '2024-10-15 10:54:19'),
(149, 27, 40, 'gi ', '2024-10-15 10:55:03'),
(154, 27, 40, 'f', '2024-10-15 10:55:54'),
(155, 27, 40, 'jk', '2024-10-15 10:56:40'),
(156, 27, 40, 'yu', '2024-10-15 10:56:45'),
(157, 27, 39, 'asdasd', '2024-10-15 10:57:31'),
(158, 27, 39, 'as', '2024-10-15 10:57:35'),
(159, 27, 40, 'f', '2024-10-15 10:57:45'),
(160, 27, 39, 's', '2024-10-15 10:58:32'),
(161, 27, 39, 'dd', '2024-10-15 10:58:35'),
(162, 27, 40, 'g', '2024-10-15 10:58:54'),
(163, 27, 39, 'rr', '2024-10-15 10:59:59'),
(164, 27, 39, 'o', '2024-10-15 11:00:03'),
(165, 27, 40, 'zxcvzx', '2024-10-15 11:00:36'),
(166, 27, 40, 'ty', '2024-10-15 11:00:43'),
(167, 27, 40, 'oo', '2024-10-15 11:01:44'),
(168, 27, 40, 'ggg', '2024-10-15 11:02:00'),
(169, 27, 39, 'tt', '2024-10-15 11:02:17'),
(170, 27, 40, 'we', '2024-10-15 11:02:24'),
(171, 27, 39, 't', '2024-10-15 11:02:41'),
(172, 27, 40, 't', '2024-10-15 11:02:47'),
(173, 27, 39, 'sfsfsdf', '2024-10-15 11:18:20'),
(174, 27, 39, 'test', '2024-10-15 11:18:25'),
(175, 27, 39, 'test', '2024-10-15 11:18:33'),
(176, 27, 39, 'fsdfsdf', '2024-10-15 11:18:35'),
(177, 27, 39, 'abc', '2024-10-15 11:19:47'),
(178, 27, 39, 'dfsdfsd', '2024-10-15 11:20:03'),
(179, 27, 39, 'abcc', '2024-10-15 11:22:44'),
(180, 27, 39, 'sdfsdf', '2024-10-15 11:23:05'),
(181, 27, 39, 'fsdfsdfsd', '2024-10-15 11:23:15'),
(182, 27, 39, 'a', '2024-10-15 11:23:21'),
(183, 27, 39, 'adff', '2024-10-15 11:23:54'),
(184, 27, 39, 'DDDDD', '2024-10-15 11:24:45'),
(185, 27, 39, 'sfsdf', '2024-10-15 11:36:16'),
(186, 27, 39, 'sfsdfdfd', '2024-10-15 11:36:19'),
(187, 27, 39, 'sfsdfdfddfsd', '2024-10-15 11:36:22'),
(188, 27, 39, 'fsdfsd', '2024-10-15 11:36:43'),
(189, 27, 39, 'sdfsdf', '2024-10-15 11:41:46'),
(190, 27, 39, 'hbm', '2024-10-15 11:42:25'),
(191, 27, 39, 'sdfdsf', '2024-10-15 11:45:53'),
(192, 27, 39, 'dfd', '2024-10-15 11:46:43'),
(193, 27, 39, 'sfsdf', '2024-10-15 11:47:07'),
(194, 27, 39, 'sadas', '2024-10-15 11:47:10'),
(195, 27, 39, 'sfsdf', '2024-10-15 11:49:26'),
(196, 27, 39, 'st', '2024-10-15 11:49:30'),
(197, 27, 39, 'sfsfsd', '2024-10-15 11:54:41'),
(198, 27, 39, 'fsdfsdf', '2024-10-15 11:54:53'),
(199, 27, 39, 'sdfd', '2024-10-15 11:57:15'),
(200, 27, 39, 'fsdf', '2024-10-15 11:57:24'),
(201, 27, 39, 'sdfsd', '2024-10-15 11:57:26'),
(202, 27, 39, 'sfsdfsdf', '2024-10-15 11:58:31'),
(203, 27, 39, 'ABC 123', '2024-10-15 11:58:45'),
(204, 27, 39, 'dfsdfds', '2024-10-15 12:04:08'),
(205, 27, 39, 'sdcsd', '2024-10-15 12:07:39'),
(206, 27, 39, 'sdfsd', '2024-10-15 12:07:42'),
(207, 27, 39, 'fvfcv', '2024-10-15 12:08:04'),
(208, 27, 39, 'gg', '2024-10-15 12:08:09'),
(209, 27, 39, 'rr', '2024-10-15 12:08:48'),
(210, 27, 39, 'f', '2024-10-15 12:10:13'),
(211, 27, 39, 'asdas', '2024-10-15 12:21:55'),
(212, 27, 39, 'asdassa', '2024-10-15 12:21:58'),
(213, 27, 39, 'asdassa', '2024-10-15 12:22:00'),
(214, 27, 39, 'asdassa', '2024-10-15 12:22:00'),
(215, 27, 39, 'asdassa', '2024-10-15 12:22:04'),
(216, 27, 39, 'asdassa', '2024-10-15 12:22:05'),
(217, 27, 39, 'asdassa', '2024-10-15 12:22:06'),
(218, 27, 39, 'asdassa', '2024-10-15 12:22:06'),
(219, 27, 39, 'asdassa', '2024-10-15 12:22:06'),
(220, 27, 39, 'asdassa', '2024-10-15 12:22:06'),
(221, 27, 39, 'asdassa', '2024-10-15 12:22:06'),
(222, 27, 39, 'asdassa', '2024-10-15 12:22:06'),
(223, 27, 39, 'asdassa', '2024-10-15 12:22:07'),
(224, 27, 39, 'asdassa', '2024-10-15 12:22:07'),
(225, 27, 39, 'asdassa', '2024-10-15 12:22:07'),
(226, 27, 39, 'asdassa', '2024-10-15 12:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`, `role_id`) VALUES
(39, 'amanullah', 'aman@gmail.com', NULL, '2024-10-13 13:45:06', '2024-10-13 20:36:18', 2),
(40, 'Ali', 'ali@gmail.com', NULL, '2024-10-13 14:53:02', '2024-10-13 14:53:16', 1),
(41, 'amanullah', 'aman@gamil.com', NULL, '2024-10-13 20:37:15', '2024-10-13 20:37:15', 2),
(42, 'hafeez', 'hafeez@gmail.com', NULL, '2024-10-13 20:38:58', '2024-10-13 20:38:58', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD CONSTRAINT `conversation_participants_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
