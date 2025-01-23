-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2025 at 07:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crms`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_periods`
--

CREATE TABLE `academic_periods` (
  `id` bigint UNSIGNED NOT NULL,
  `academic_year` varchar(9) DEFAULT NULL,
  `semester` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_periods`
--

INSERT INTO `academic_periods` (`id`, `academic_year`, `semester`, `start_date`, `end_date`, `created_at`, `updated_at`, `status`) VALUES
(1, '2024/2025', 1, '2025-01-01', '2025-06-01', '2025-01-07 19:48:23', '2025-01-07 19:48:23', 'active'),
(2, '2025/2026', 1, '2025-01-01', '2025-06-11', '2025-01-17 08:37:23', '2025-01-17 08:37:23', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('major','minor') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'major',
  `course_code` text COLLATE utf8mb4_general_ci,
  `credit_hours` int DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `faculty_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `type`, `course_code`, `credit_hours`, `capacity`, `faculty_id`, `created_at`, `updated_at`) VALUES
(1, 'Digital Media Ethics', 'major', 'CS101', 3, 15, 1, '2024-12-30 16:28:21', '2024-12-30 16:28:21'),
(2, 'Artificial Intelligence In Communication', 'minor', 'FT3320', 3, 60, 1, '2024-12-30 16:29:15', '2024-12-30 16:29:15'),
(3, 'Database Application', 'minor', 'FT3408', 3, 15, 1, '2025-01-05 05:08:44', '2025-01-05 05:08:44'),
(4, 'Internet And Ethics', 'minor', 'FT3408', 3, 30, 1, '2025-01-05 05:09:21', '2025-01-05 05:09:21'),
(5, 'Introduction To Professional Communication', 'major', 'FT3399', 3, 45, 1, '2025-01-08 06:45:37', '2025-01-08 06:45:37'),
(6, 'Media Editing And Production', 'major', 'FT3310', 3, NULL, 1, '2025-01-12 16:15:35', '2025-01-12 16:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `course_lecturer`
--

CREATE TABLE `course_lecturer` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_lecturer`
--

INSERT INTO `course_lecturer` (`id`, `course_id`, `lecturer_id`, `created_at`, `updated_at`) VALUES
(1, 2, 2, NULL, NULL),
(2, 1, 3, NULL, NULL),
(3, 4, 3, NULL, NULL),
(4, 5, 3, NULL, NULL),
(5, 3, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 3, 4, NULL, NULL),
(8, 5, 4, NULL, NULL),
(9, 6, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_offerings`
--

CREATE TABLE `course_offerings` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `academic_period_id` bigint UNSIGNED DEFAULT NULL,
  `max_students` int DEFAULT NULL,
  `current_enrolled` int DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_prerequisite`
--

CREATE TABLE `course_prerequisite` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `prerequisite_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_registrations`
--

CREATE TABLE `course_registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci NOT NULL,
  `fee_receipt` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_requests`
--

CREATE TABLE `course_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `student_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `matric_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `request_type` enum('major','minor') COLLATE utf8mb4_general_ci NOT NULL,
  `student_status` enum('scholarship','non-scholarship') COLLATE utf8mb4_general_ci NOT NULL,
  `fee_receipt` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci NOT NULL,
  `submission_date` timestamp NULL DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `registration_period_id` bigint UNSIGNED DEFAULT NULL,
  `group_id` bigint UNSIGNED DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_requests`
--

INSERT INTO `course_requests` (`id`, `student_id`, `student_name`, `course_id`, `course_code`, `program`, `matric_number`, `request_type`, `student_status`, `fee_receipt`, `status`, `submission_date`, `remarks`, `created_at`, `updated_at`, `approved_at`, `rejected_at`, `registration_period_id`, `group_id`, `group_name`, `day_of_week`, `time`, `place`) VALUES
(2, 9, 'Ezra', 1, 'CS101', ' Bachelor of Halal Technology and Compliance', 'M22616', 'major', 'non-scholarship', 'fee_receipts/2MrXbygkEuqB4TuMhy4reepD3GWQCEaZiPDPWGI4.jpg', 'approved', '2025-01-05 06:58:29', NULL, '2025-01-05 06:58:29', '2025-01-08 06:43:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 9, 'Ezra', 5, 'FT3399', ' Bachelor of Halal Technology and Compliance', 'M22616', 'major', 'non-scholarship', 'fee_receipts/tKqiYFYtETIidPbmZfnUQqgGYlIUMUYNUOtuiAPT.jpg', 'approved', '2025-01-08 06:46:54', NULL, '2025-01-08 06:46:54', '2025-01-12 11:59:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 'Quincy Schultz', 5, 'FT3399', 'Bachelor of Islamic Cybersecurity ', 'M22614', 'major', 'non-scholarship', NULL, 'rejected', '2025-01-12 11:31:18', 'where is your fee receipt', '2025-01-12 11:31:18', '2025-01-12 11:58:58', NULL, NULL, 5, 2, NULL, NULL, NULL, NULL),
(5, 2, 'Quincy Schultz', 5, 'FT3399', 'Bachelor of Islamic Cybersecurity ', 'M22614', 'major', 'non-scholarship', 'fee_receipts/TqvXjiup8HOiBRIZbHbPuOnRkcb6m3W78TKaG8sw.jpg', 'rejected', '2025-01-12 11:59:55', 'receipt not clear', '2025-01-12 11:59:55', '2025-01-12 12:01:15', NULL, NULL, 5, 2, NULL, NULL, NULL, NULL),
(7, 2, 'Quincy Schultz', 5, 'FT3399', 'Bachelor of Islamic Cybersecurity ', 'M22614', 'major', 'non-scholarship', 'fee_receipts/4AwmP4zya6Dgw11RDvXqDIHRPAKQW890OuMKW3TD.jpg', 'approved', '2025-01-12 12:19:10', NULL, '2025-01-12 12:19:10', '2025-01-12 12:19:42', NULL, NULL, 5, 2, NULL, NULL, NULL, NULL),
(8, 2, 'Quincy Schultz', 6, 'FT3310', 'Bachelor of Islamic Cybersecurity ', 'M22614', 'major', 'non-scholarship', 'fee_receipts/1Xb08L7tZfA5fVZvfiqK5GpWo0T7HRyYF7LeZATm.jpg', 'approved', '2025-01-12 16:24:53', NULL, '2025-01-12 16:24:53', '2025-01-12 16:25:52', NULL, NULL, 5, 4, 'A', 'Thursday', '11:00:00', 'TBA'),
(9, 9, 'Ezra', 6, 'FT3310', ' Bachelor of Halal Technology and Compliance', 'M22616', 'major', 'non-scholarship', 'fee_receipts/x6BVsA0TLoychwYiB0Bp4Fb2EE8gcFctw0C0VhDV.jpg', 'approved', '2025-01-13 01:15:29', NULL, '2025-01-13 01:15:29', '2025-01-13 01:16:07', NULL, NULL, 5, 4, 'A', 'Thursday', '11:00:00', 'Computer Lab Sinaut'),
(10, 8, 'Kitsune Akari', 1, 'CS101', 'Bachelor of Fine Arts in Digital and Traditional Media', 'M22615', 'major', 'non-scholarship', 'fee_receipts/HH6oc3kzhivCEeffBf2x3CQadCuTDTUc2lpBkZD5.jpg', 'approved', '2025-01-15 18:28:22', NULL, '2025-01-15 18:28:22', '2025-01-15 18:29:07', NULL, NULL, 5, 1, 'A', 'Monday', '08:00:00', 'TBA'),
(11, 8, 'Kitsune Akari', 5, 'FT3399', 'Bachelor of Fine Arts in Digital and Traditional Media', 'M22615', 'major', 'scholarship', NULL, 'pending', '2025-01-18 01:12:41', NULL, '2025-01-18 01:12:41', '2025-01-18 01:12:41', NULL, NULL, 5, 2, 'A', 'Tuesday', '08:00:00', 'TBA');

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'enrolled',
  `semester` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `academic_year` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `group_id`, `course_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'active', '2025-01-13 01:11:00', '2025-01-13 01:11:00'),
(2, 2, 2, 5, 'active', '2025-01-13 01:11:00', '2025-01-13 01:11:00'),
(3, 8, 2, 5, 'active', '2025-01-13 01:11:00', '2025-01-13 01:11:00'),
(4, 9, 4, 6, 'active', '2025-01-13 01:11:00', '2025-01-13 01:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `semester_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `semester_name`, `event_type`, `event_title`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Semester 1 2025/2026 (AT24)', 'URGENT', 'Major Registration Open', '2025-01-02', '2025-01-29', '2024-12-30 20:12:19', '2025-01-16 03:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` bigint UNSIGNED NOT NULL,
  `faculty_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `faculty_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `faculty_name`, `faculty_code`, `created_at`, `updated_at`) VALUES
(1, 'Faculty of Islamic Technology', 'FIT', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(2, 'Faculty of Arts', 'FA', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(3, 'Faculty of Engineering', 'FE', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(4, 'Faculty of Business', 'FB', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(5, 'Faculty of Medicine', 'FM', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(6, 'Faculty of Islamic Technology', 'FIT', '2025-01-04 18:19:37', '2025-01-04 18:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `max_students` int NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Saturday') COLLATE utf8mb4_general_ci NOT NULL,
  `time` time NOT NULL,
  `place` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `course_id`, `name`, `max_students`, `day_of_week`, `time`, `place`, `created_at`, `updated_at`) VALUES
(1, 1, 'A', 50, 'Monday', '08:00:00', NULL, '2025-01-12 10:15:48', '2025-01-12 10:15:48'),
(2, 5, 'A', 30, 'Tuesday', '08:00:00', NULL, '2025-01-12 10:27:58', '2025-01-12 10:27:58'),
(4, 6, 'A', 5, 'Thursday', '11:00:00', NULL, '2025-01-12 16:20:08', '2025-01-12 16:20:08'),
(5, 1, 'B', 4, 'Saturday', '09:00:00', NULL, '2025-01-12 16:22:43', '2025-01-12 16:22:43'),
(6, 3, 'A', 30, 'Saturday', '14:00:00', NULL, '2025-01-13 06:24:14', '2025-01-13 06:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_general_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED NOT NULL,
  `expertise` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `faculty_id` bigint UNSIGNED DEFAULT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `name`, `photo`, `user_id`, `lecturer_id`, `expertise`, `email`, `faculty_id`, `course_id`, `phone`, `created_at`, `updated_at`) VALUES
(2, 'Koizora', NULL, 21, 2, NULL, 'shinichixye@gmail.com', 1, NULL, '0239710127', '2024-12-30 20:11:29', '2025-01-15 01:53:57'),
(3, 'Karina', 'lecturer_photos/DDJ5jWYw8bEZUf2RH1zq0fnPxqQ2pRnzM8BoSMsQ.jpg', 22, 102, NULL, 'karina@unissa.bn.edu', 1, NULL, '01897102451', '2024-12-30 20:14:09', '2025-01-17 07:49:21'),
(4, 'Hikaru Yoshi', 'lecturer_photos/MJwg1Zb50mTKZ8p0aNUTGDEFViMBN5SUuLTL7Qm4.jpg', 25, 2025001, NULL, 'hikaru@gmail.com', 1, NULL, '0189710129', '2025-01-16 06:13:59', '2025-01-16 06:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2024_12_11_091036_create_students_table', 2),
(11, '2024_12_12_131932_add_photo_to_students_table', 3),
(21, '2024_12_22_214234_add_course_code_to_course_requests_table', 13),
(24, '2024_12_26_032740_add_approval_dates_to_course_requests_table', 16),
(25, '2024_12_27_090709_add_current_semester_to_students_table', 17),
(26, '2024_12_27_120648_add_recommendation_fields_to_minor_registrations_table', 18),
(27, '2024_12_28_081547_add_type_to_timetables_table', 19),
(30, '2024_12_30_165543_add_is_scholarship_to_students_table', 22),
(31, '2024_12_30_172915_add_email_to_students_table', 23),
(33, '2024_12_11_110928_create_events_table', 24),
(34, '2024_12_12_021047_add_user_id_and_is_scholarship_to_students_table', 24),
(35, '2024_12_13_101542_create_faculties_table', 24),
(36, '2024_12_13_194504_create_groups_table', 24),
(37, '2024_12_14_103300_create_course_prerequisite_table', 24),
(38, '2024_12_16_000003_create_course_registrations_table', 25),
(39, '2024_12_18_074129_create_enrollments_table', 25),
(40, '2024_12_22_180527_create_timetables_table', 25),
(41, '2024_12_24_035857_create_lecturers_table', 25),
(42, '2024_12_24_072900_create_places_table', 25),
(43, '2024_12_28_085104_update_type_in_timetables_table', 25),
(44, '2024_12_29_124038_create_news_table', 25),
(45, '2024_12_29_141725_fix_news_image_paths', 25),
(46, '2024_12_30_010657_create_program_structures_table', 25),
(47, '2024_12_30_180649_add_email_to_students_table', 26),
(48, '2024_12_30_181440_modify_students_table_add_email', 27),
(49, '2024_12_30_181901_create_students_table', 28),
(50, '2024_12_30_182154_create_students_table', 29),
(51, '2024_12_30_183654_add_program_id_to_students_table', 30),
(52, '2024_12_30_184812_add_program_id_to_program_structures_table', 31),
(53, '2024_12_30_212002_add_type_to_courses_table', 32),
(54, '2024_12_31_040650_create_course_lecturer_table', 33),
(55, '2024_12_31_045313_add_missing_columns_to_timetables_table', 34),
(56, '2024_12_31_045436_add_missing_columns_to_timetables_table', 35),
(57, '2024_12_31_055627_add_student_details_to_minor_registrations_table', 36),
(58, '2024_12_31_060532_rename_programme_column_in_minor_registrations_table', 37),
(59, '2025_01_01_214646_remove_batch_and_intake_from_students_table', 38),
(60, '2025_01_01_215108_add_faculty_id_to_students_table', 39),
(61, '2025_01_01_220025_remove_program_columns_from_students_table', 40),
(62, '2025_01_05_014339_create_roles_table', 41),
(63, '2025_01_05_020145_add_faculty_id_to_users_table', 42),
(64, '2025_01_05_142028_update_minor_registrations_status_column', 43),
(65, '2025_01_08_083232_add_registration_period_to_minor_registrations', 44),
(66, '2025_01_08_111825_add_type_to_registration_periods', 45),
(67, '2025_01_08_112949_add_registration_period_to_course_requests', 46),
(68, '2025_01_12_072449_create_groups_table', 47),
(69, '2025_01_12_072947_create_enrollments_table', 48),
(70, '2025_01_12_085941_add_columns_to_groups_table', 49),
(71, '2025_01_12_090546_create_enrollments_table', 50),
(72, '2025_01_12_183946_update_group_id_in_course_requests_table', 51),
(73, '2025_01_12_185549_create_enrollments_table', 52),
(74, '2025_01_12_210245_add_group_details_to_course_requests_table', 53),
(76, '2025_01_13_010316_add_place_to_groups_table', 54),
(77, '2025_01_15_095142_update_users_role_enum', 55),
(78, '2025_01_15_095322_update_lecturers_with_user_accounts', 56),
(79, '2025_01_15_112653_update_lecturer_password', 57),
(81, '2025_01_15_112927_update_lecturer_password', 58),
(82, '2025_01_16_142638_add_photo_to_lecturers_table', 59),
(83, '2025_01_17_155953_add_document_columns_to_minor_registrations_table', 60);

-- --------------------------------------------------------

--
-- Table structure for table `minor_registrations`
--

CREATE TABLE `minor_registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `matric_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `current_semester` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `program_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `semester1_gpa` decimal(3,2) DEFAULT NULL,
  `semester2_gpa` decimal(3,2) DEFAULT NULL,
  `semester3_gpa` decimal(3,2) DEFAULT NULL,
  `semester4_gpa` decimal(3,2) DEFAULT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `proposed_semester` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `signed_form_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `transcript_path` varchar(191) COLLATE utf8mb4_general_ci NOT NULL,
  `additional_docs_path` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `remarks` text COLLATE utf8mb4_general_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recommendation_status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dean_comments` text COLLATE utf8mb4_general_ci,
  `dean_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dean_signature` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recommendation_date` timestamp NULL DEFAULT NULL,
  `registration_period_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `minor_registrations`
--

INSERT INTO `minor_registrations` (`id`, `student_id`, `name`, `matric_number`, `current_semester`, `program_name`, `phone`, `email`, `semester1_gpa`, `semester2_gpa`, `semester3_gpa`, `semester4_gpa`, `cgpa`, `course_id`, `course_code`, `course_name`, `faculty`, `proposed_semester`, `signed_form_path`, `transcript_path`, `additional_docs_path`, `status`, `remarks`, `approved_at`, `approved_by`, `created_at`, `updated_at`, `recommendation_status`, `dean_comments`, `dean_name`, `dean_signature`, `recommendation_date`, `registration_period_id`) VALUES
(6, 8, 'Kitsune Akari', 'M22615', '2', 'Bachelor of Performing Arts in Traditional and Modern Theater', '0189710127', 'foxy@gmail.com', '2.00', '2.00', NULL, NULL, '3.00', 2, 'FT3320', 'Artificial Intelligence In Communication', '1', '3', 'minor-registrations/pRtDc5ON8WCGBGQ0w8M33ohUtxnDjCXrRagmpEef.pdf', '', NULL, 'approved', NULL, NULL, NULL, '2025-01-05 04:22:04', '2025-01-05 04:26:00', NULL, NULL, 'DR DAYANG', NULL, '2025-01-05 04:26:00', NULL),
(8, 9, 'Ezra', 'M22616', '1', ' Bachelor of Halal Technology and Compliance', '0145256709', 'ezra@gmail.com', '2.00', NULL, NULL, NULL, '3.00', 4, 'FT3408', 'Internet And Ethics', '1', '3', 'minor-registrations/deJMoz48CW3CzharXRAuk1mnyzUMZfVoLQsXvHlr.pdf', '', NULL, 'cancelled', 'Cancelled by student', NULL, NULL, '2025-01-06 18:41:55', '2025-01-08 04:21:05', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, 'Ezra', 'M22616', '1', ' Bachelor of Halal Technology and Compliance', '0145256709', 'ezra@gmail.com', '1.00', NULL, NULL, NULL, '3.20', 3, 'FT3408', 'Database Application', '1', '5', 'minor-registrations/SaE1vjUInEjpFcwPu93LffT28vAduG7jYiUmD9Wy.pdf', '', NULL, 'rejected', NULL, NULL, NULL, '2025-01-08 05:13:57', '2025-01-08 07:01:12', NULL, 'please enter valid form', 'Dr Dayang', NULL, '2025-01-08 07:01:12', NULL),
(10, 9, 'Ezra', 'M22616', '1', ' Bachelor of Halal Technology and Compliance', '0145256709', 'ezra@gmail.com', '1.00', NULL, NULL, NULL, '2.00', 2, 'FT3320', 'Artificial Intelligence In Communication', '1', '3', 'minor-registrations/GZqIzhntWD4DK8R5bNBRznmQWZjr1zRZvin1rp2k.pdf', '', NULL, 'cancelled', 'Cancelled by student', NULL, NULL, '2025-01-08 07:01:59', '2025-01-08 07:48:21', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2, 'Quincy Schultz', 'M22614', '4', 'Bachelor of Islamic Cybersecurity ', '01111121217', 'quincy@gmail.com', '1.00', '1.00', '1.00', '1.00', '3.00', 4, 'FT3408', 'Internet And Ethics', '1', '5', 'minor-registrations/signed-forms/UUgaRTvbyXZnbIS9y9cqsNsM6F0oyCjnuw0XTO3o.pdf', 'minor-registrations/transcripts/p1TpmbTGegIebqfTB18v8tHLqyDzUzKgN9SaQAhw.pdf', 'minor-registrations/additional-docs/mpb77yG2WclXoy1horkoZLj0f3m4lCi0Ga6EdUvg.pdf', 'rejected', NULL, NULL, NULL, '2025-01-17 08:15:42', '2025-01-17 22:02:39', NULL, 'submit proper doc', 'Dr Dayang', NULL, '2025-01-17 22:02:39', NULL),
(16, 2, 'Quincy Schultz', 'M22614', '4', 'Bachelor of Islamic Cybersecurity ', '01111121217', 'quincy@gmail.com', '1.00', '1.00', '1.00', '1.00', '1.98', 3, 'FT3408', 'Database Application', '1', '5', 'minor-registrations/signed-forms/NbQaw11O7cSlHWzhz7LlUO4e1OMTEKGXjo7fZBtt.pdf', 'minor-registrations/transcripts/zEQcnHdxf0n0JJG6uT7oYAhIR7cEFVtWajMW8BsV.pdf', 'minor-registrations/additional-docs/1V5s9RG1WNv94CrAlpOE7AZnA6eL8AgSUvguRmnj.pdf', 'cancelled', 'Cancelled by student', NULL, NULL, '2025-01-17 22:38:44', '2025-01-17 22:40:11', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Chainsaw Man: Chaos Unleashed in Devil-Infested City', '<p><br></p><p><em style=\"color: rgb(107, 36, 178);\"><span class=\"ql-cursor\">﻿</span>Even surrounded, I feel alone.</em></p>', 'news/1735593371.jpeg', 1, '2024-12-30 13:16:11', '2025-01-17 21:41:33'),
(2, 'PENANDATANGANAN MOU ANTARA UNISSA DAN MITSUBISHI CORPORATION', '<p><strong>Universiti Islam Sultan Sharif Ali (UNISSA) menandatangani Memorandum Persefahaman (MoU) bersama Mitsubishi Corporation pada hari Rabu, 2 Jamadilakhir 1446H bersamaan 4 Disember 2024M.</strong></p><p><strong><span class=\"ql-cursor\">﻿</span></strong>\r\n\r\n<em>Majlis penandatangan MoU berkenaan berlangsung di Kampus Gadong, UNISSA dimana menandatangani bagi pihak UNISSA ialah Dato Seri Setia Dr Haji Norarfan bin Haji Zainal, Rektor UNISSA dan bagi pihak Mitsubishi Corporation ialah Tadashi Hara, wakil Negara Mitsubishi Corporation (Pejabat Perwakilan Brunei).</em></p>', 'news/1736130982.jpg', 1, '2025-01-05 18:36:22', '2025-01-17 21:21:00'),
(3, 'Semester Course Availability: Check Now and Plan Your Schedule!', '<p>We are pleased to inform you that the list of available courses for the current semester has been published. You can now review the courses offered by your respective faculties and plan your academic schedule accordingly.</p><p>\r\n\r\n<strong>How to Access:</strong>\r\n\r\nClick this link : <a href=\"https://drive.google.com/drive/folders/1tlFilKq1hNnpFLh2IcRKBrrVf2N9FuxU?usp=drive_link \" target=\"_blank\">https://drive.google.com/drive/folders/1tlFilKq1hNnpFLh2IcRKBrrVf2N9FuxU?usp=drive_link </a></p><p>\r\n\r\n<strong>Important Notes:\r\n</strong>\r\nEnsure you meet the prerequisites for your chosen courses.\r\n\r\nThe deadline for course registration is 29 Jan 2025. Late submissions will not be accepted.</p><p>\r\n\r\nFor any inquiries or assistance, please contact <strong><em>dhzrna.exe@gmail.com</em></strong></p><p><strong><em><span class=\"ql-cursor\">﻿</span></em></strong>\r\n\r\nWe wish you a productive and successful semester ahead!\r\n</p>', 'news/lw4OymqfkHkhquZyiOEWPaRddIfMlDSfnTPBGfrY.jpg', 1, '2025-01-16 03:31:31', '2025-01-17 21:41:06'),
(4, 'ATTENDANCE', '<p><em>Attending class is like watering a plant. Miss too many, and you\'ll still grow—just wildly in the wrong direction.</em></p>\r\n\r\n<p><br></p>\r\n\r\n<p><a href=\"https://drive.google.com/drive/folders/1tlFilKq1hNnpFLh2IcRKBrrVf2N9FuxU?usp=drive_link\">https://drive.google.com/drive/folders/1tlFilKq1hNnpFLh2IcRKBrrVf2N9FuxU?usp=drive_link </a></p>', NULL, 1, '2025-01-16 04:01:00', '2025-01-16 04:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Jubli Hall (400)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(2, 'Computer Lab 1 (30)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(3, 'Computer Lab 2 (30)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(4, 'Computer Lab Sinaut', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(5, 'M 1.4 (36)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(6, 'M 1.5 (72)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(7, 'M 1.6 (22)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(8, 'M 1.14 (36)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(9, 'N 1.1 (132)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(10, 'N 1.2 (24)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(11, 'N 1.3 (24)', '2024-12-30 10:31:33', '2024-12-30 10:31:33'),
(12, 'N 1.5 (48)', '2024-12-30 10:31:33', '2024-12-30 10:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `faculty_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `code`, `faculty_id`, `description`, `created_at`, `updated_at`) VALUES
(1, ' Bachelor of Halal Technology and Compliance', 'BHTC', 1, NULL, '2024-12-30 10:35:38', '2024-12-30 10:35:38'),
(2, 'Bachelor of Islamic Cybersecurity ', 'BIC', 1, 'The Bachelor of Islamic Cybersecurity program is designed to equip students with the necessary skills to protect and secure Islamic digital assets. It covers topics such as Islamic cyber ethics, cyber law, and cybersecurity strategies. Graduates will be able to contribute to the development of a secure and compliant digital environment for Islamic institutions.', '2024-12-30 10:35:38', '2024-12-30 10:35:38'),
(3, 'Bachelor of Fine Arts in Digital and Traditional Media', 'BFA-DTM', 2, 'The Bachelor of Fine Arts in Digital and Traditional Media program prepares students for careers in the creative industries, focusing on both digital and traditional media. It combines art theory with practical skills in digital and traditional media production. Graduates will be able to create innovative and culturally relevant media content for a global audience.', '2024-12-30 10:35:38', '2024-12-30 10:35:38'),
(4, 'Bachelor of Performing Arts in Traditional and Modern Theater', 'BPA-TMT', 2, 'The Bachelor of Performing Arts in Traditional and Modern Theater program prepares students for careers in the performing arts, focusing on both traditional and modern theater. It combines theater theory with practical skills in theater production. Graduates will be able to create innovative and culturally relevant theater content for a global audience.', '2024-12-30 10:35:38', '2024-12-30 10:35:38'),
(5, 'Bachelor of Arts in Creative Writing and Storytelling ', 'BACWS', 2, 'The Bachelor of Arts in Creative Writing and Storytelling program prepares students for careers in the creative industries, focusing on both creative writing and storytelling. It combines writing theory with practical skills in creative writing and storytelling. Graduates will be able to create innovative and culturally relevant writing and storytelling content for a global audience.', '2024-12-30 10:35:38', '2024-12-30 10:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `program_structures`
--

CREATE TABLE `program_structures` (
  `id` bigint UNSIGNED NOT NULL,
  `program_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `faculty_id` bigint UNSIGNED NOT NULL,
  `pdf_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_structures`
--

INSERT INTO `program_structures` (`id`, `program_name`, `faculty_id`, `pdf_path`, `academic_year`, `version`, `is_active`, `created_at`, `updated_at`, `program_id`) VALUES
(3, 'Bachelor of Islamic Cybersecurity ', 1, 'program-structures/6GUXUyS9J3mRFyrhzIQUsZrugkpirSCzof8djCZp.pdf', '2023/2024', '1.0', 1, '2025-01-01 10:53:00', '2025-01-01 10:53:00', 2),
(4, ' Bachelor of Halal Technology and Compliance', 1, 'program-structures/7oGFzG0adaUWIE2TxP0fJezyMDaykgorLA5fKvaR.pdf', '2023/2024', '1.0', 1, '2025-01-01 11:06:32', '2025-01-01 11:06:32', 1),
(5, 'Bachelor of Fine Arts in Digital and Traditional Media', 2, 'program-structures/LtFv0kU685eoDIDtd2fCgKbvVm6DVBm6LAef7shL.pdf', '2023/2024', '1.0', 1, '2025-01-01 18:37:24', '2025-01-01 18:37:24', 3),
(6, 'Bachelor of Performing Arts in Traditional and Modern Theater', 2, 'program-structures/tQmrJE2hlkwd8ysimC5SjobkZhKcEyA3MNguADQp.pdf', '2023/2024', '1.0', 1, '2025-01-01 18:40:32', '2025-01-01 18:40:32', 4),
(7, 'Bachelor of Arts in Creative Writing and Storytelling ', 2, 'program-structures/ZXfAK3bekmS33wrzN8TSyVayQVFQUXIUMOFrlvTj.pdf', '2023/2024', '1.0', 1, '2025-01-01 18:43:32', '2025-01-01 18:43:32', 5);

-- --------------------------------------------------------

--
-- Table structure for table `registration_periods`
--

CREATE TABLE `registration_periods` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('major','minor') NOT NULL DEFAULT 'major',
  `academic_period_id` bigint UNSIGNED DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` enum('upcoming','active','closed') DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_periods`
--

INSERT INTO `registration_periods` (`id`, `type`, `academic_period_id`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 'minor', 1, '2025-01-01 20:55:00', '2025-01-20 20:56:00', 'upcoming', '2025-01-08 04:56:08', '2025-01-21 07:08:40'),
(5, 'major', 1, '2025-01-11 11:18:00', '2025-01-21 11:18:00', 'upcoming', '2025-01-08 19:18:13', '2025-01-15 18:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-01-04 17:48:43', '2025-01-04 17:48:43'),
(2, 'student', '2025-01-04 17:48:43', '2025-01-04 17:48:43'),
(3, 'lecturer', '2025-01-04 17:48:43', '2025-01-04 17:48:43'),
(4, 'dean', '2025-01-04 17:48:43', '2025-01-04 17:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RwIJyDIJ5Cs11ufYU4oASOJEDaiBwUG9qXXZr9tm', 25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo0OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xlY3R1cmVyL2NvdXJzZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoieTNQeFNqMUZocmtNbnpGazhnVHBKcjZzajZSZnp6WG5uanZEb1daTyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjU7fQ==', 1737444762);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `matric_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ic_number` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `current_semester` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `scholarship_status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `program_id` bigint UNSIGNED DEFAULT NULL,
  `faculty_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `name`, `email`, `matric_number`, `ic_number`, `current_semester`, `phone`, `academic_year`, `address`, `scholarship_status`, `photo`, `created_at`, `updated_at`, `program_id`, `faculty_id`) VALUES
(2, 5, 'Quincy Schultz', 'quincy@gmail.com', 'M22614', '37917353571', '4', '01111121217', '2024/2025', '5851 Waelchi Circle Apt. 742\r\nKhalilville, NV 76603-3299', 'Non-Scholarship', 'profile_photos/LcTh36BCfTMfjlrBvxc6DWRnwCzAiYFdvFWOHFnP.jpg', '2024-12-30 10:23:21', '2025-01-01 07:53:12', 2, 1),
(8, 18, 'Kitsune Akari', 'foxy@gmail.com', 'M22615', '030111-12-5644', '2', '0189710127', '2024/2025', '2-21-1 Dogenzaka,\r\nShibuya City,\r\nTokyo 150-0043,\r\nJapan', 'Scholarship', 'profile_photos/Vus9oce9JeZ6vu60zXNQIwdmHO4Zdz3OKV2zyaKE.jpg', '2025-01-01 15:32:30', '2025-01-05 18:52:18', 3, 1),
(9, 20, 'Ezra', 'ezra@gmail.com', 'M22616', '000101-12-5642', '1', '0145256709', '2024/2025', '1-2-3 Ginza\r\nChuo City, Tokyo, Japan', 'Non-Scholarship', 'profile_photos/DjczwrbDCOSXL7FutCdP5bWJPbAWjLaHVZIIUnW4.jpg', '2025-01-05 05:51:09', '2025-01-05 05:53:39', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `course_id`, `lecturer_id`, `course_code`, `course_name`, `student_id`, `day_of_week`, `start_time`, `end_time`, `place`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'CS101', 'Digital Media Ethics', 2, 'Monday', '08:00:00', '10:00:00', 'N 1.3 (24)', 'major', '2024-12-30 21:37:41', '2024-12-30 21:37:41'),
(3, 2, 2, 'FT3320', 'Artificial Intelligence In Communication', 2, 'Monday', '08:00:00', '11:00:00', 'N 1.1 (132)', 'minor', '2024-12-30 21:49:47', '2024-12-30 21:49:47'),
(4, 4, 3, 'FT3408', 'Internet And Ethics', NULL, 'Wednesday', '12:00:00', '14:00:00', 'N 1.3 (24)', 'minor', '2025-01-08 17:56:54', '2025-01-08 17:56:54'),
(5, 5, 3, 'FT3399', 'Introduction To Professional Communication', NULL, 'Tuesday', '08:00:00', '10:00:00', 'Jubli Hall (400)', 'major', '2025-01-08 18:53:47', '2025-01-08 18:53:47'),
(6, 3, 2, 'FT3408', 'Database Application', NULL, 'Saturday', '14:00:00', '16:00:00', 'N 1.5 (48)', 'minor', '2025-01-08 18:57:27', '2025-01-08 18:57:27'),
(7, 6, 2, 'FT3310', 'Media Editing And Production', NULL, 'Thursday', '11:00:00', '14:00:00', 'Computer Lab Sinaut', 'major', '2025-01-12 16:18:40', '2025-01-12 16:18:40'),
(8, 1, 3, 'CS101', 'Digital Media Ethics', NULL, 'Saturday', '09:00:00', '11:00:00', 'M 1.14 (36)', 'major', '2025-01-12 16:19:16', '2025-01-12 16:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `faculty_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Admin','Student','program_head','faculty_dean','offering_faculty','lecturer') COLLATE utf8mb4_general_ci DEFAULT 'Student',
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `faculty_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Ren Nanase', 'renNanase@gmail.com', '2024-12-30 08:46:11', '$2y$12$ywUxwobh0rWrg.FeNvnp8.1uMhwhs6/pCjAHxgzPUvf7W4N3cUQDa', 'Admin', 'l3jcowWu2CUfkd1SZDvEdXbxsjMBmQEWkzmj8VWuDcOWUSiDo6qNW7rdKrmO', '2024-12-30 08:46:11', '2024-12-30 08:46:11'),
(5, 2, 1, 'Quincy', 'quincy@gmail.com', '2024-12-30 18:23:45', '$2y$12$bhg8biXRh4n6SR7oO6GgZ.fc7HRB0qUZ5lQhqB.1d/ll4kM/ubpcu', 'Student', NULL, '2024-12-30 10:23:21', '2024-12-30 10:23:21'),
(18, 2, 2, 'Kitsune Akari', 'foxy@gmail.com', '2025-01-05 01:58:16', '$2y$12$sWp1bza5UtAfybzeaMEbtezmjhKtZAdJmEVGEJ2CwLPk943P2o.Ym', 'Student', NULL, '2025-01-01 15:32:30', '2025-01-01 15:32:30'),
(19, 4, 6, 'Dr Dayang', 'drdayang@unissa.edu.bn', '2025-01-05 02:20:39', '$2y$12$8XXdAbG.9YMkv0qbHQ2TTOKA7JTn8rjIVoIA4OX.yyY/gYsVE8OM2', 'faculty_dean', NULL, '2025-01-04 18:19:38', '2025-01-04 18:19:38'),
(20, 2, 1, 'Ezra', 'ezra@gmail.com', '2025-01-05 13:52:01', '$2y$12$YZ44JvfKTVPd5xmAUNDvt.Mnm.3QKffsk.DhhJ0Gj8XVRHqKABRKm', 'Student', NULL, '2025-01-05 05:51:09', '2025-01-05 05:51:09'),
(21, 3, 1, 'Koizora', 'shinichixye@gmail.com', '2025-01-15 01:58:11', '$2y$12$n31id8Bt3NixOFxXKm7fOeZZORD4YinsJxCWuWnOKdDIW1XcemD3m', 'lecturer', NULL, '2025-01-15 01:53:57', '2025-01-15 01:53:57'),
(22, 3, 1, 'Karina', 'karina@unissa.bn.edu', '2025-01-15 01:58:12', '$2y$12$mmQLWiem/eICnEI1yZQ.MeFKoVULBZ4Ik4Ps6opRgZD97ZoF57GR2', 'lecturer', NULL, '2025-01-15 01:53:57', '2025-01-15 01:53:57'),
(25, 3, NULL, 'Hikaru Yoshi', 'hikaru@gmail.com', NULL, '$2y$12$XOIN7Rg5w95i29yYuyGp6uuWqHOLIbxvNsmeUGZUjGfz913HGirdS', 'lecturer', NULL, '2025-01-16 06:13:59', '2025-01-16 06:13:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_periods`
--
ALTER TABLE `academic_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `course_lecturer`
--
ALTER TABLE `course_lecturer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_lecturer_course_id_lecturer_id_unique` (`course_id`,`lecturer_id`),
  ADD KEY `course_lecturer_lecturer_id_foreign` (`lecturer_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_offerings`
--
ALTER TABLE `course_offerings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `academic_period_id` (`academic_period_id`);

--
-- Indexes for table `course_prerequisite`
--
ALTER TABLE `course_prerequisite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_prerequisite_course_id_foreign` (`course_id`),
  ADD KEY `course_prerequisite_prerequisite_id_foreign` (`prerequisite_id`);

--
-- Indexes for table `course_registrations`
--
ALTER TABLE `course_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_registrations_student_id_foreign` (`student_id`),
  ADD KEY `course_registrations_course_id_foreign` (`course_id`),
  ADD KEY `course_registrations_group_id_foreign` (`group_id`);

--
-- Indexes for table `course_requests`
--
ALTER TABLE `course_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_requests_student_id_foreign` (`student_id`),
  ADD KEY `course_requests_course_id_foreign` (`course_id`),
  ADD KEY `course_requests_registration_period_id_foreign` (`registration_period_id`),
  ADD KEY `course_requests_group_id_foreign` (`group_id`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_student_course_id_foreign` (`course_id`),
  ADD KEY `course_student_student_id_foreign` (`student_id`),
  ADD KEY `course_student_group_id_foreign` (`group_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_student_id_group_id_course_id_unique` (`student_id`,`group_id`,`course_id`),
  ADD KEY `enrollments_group_id_foreign` (`group_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_course_id_foreign` (`course_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lecturers_email_unique` (`email`),
  ADD KEY `lecturers_faculty_id_foreign` (`faculty_id`),
  ADD KEY `lecturers_course_id_foreign` (`course_id`),
  ADD KEY `lecturers_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minor_registrations`
--
ALTER TABLE `minor_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `minor_registrations_course_id_foreign` (`course_id`,`student_id`) USING BTREE,
  ADD KEY `student_id` (`student_id`),
  ADD KEY `minor_registrations_registration_period_id_foreign` (`registration_period_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `places_name_unique` (`name`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `program_structures`
--
ALTER TABLE `program_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_structures_faculty_id_foreign` (`faculty_id`),
  ADD KEY `program_structures_program_name_is_active_index` (`program_name`,`is_active`),
  ADD KEY `program_structures_program_id_foreign` (`program_id`);

--
-- Indexes for table `registration_periods`
--
ALTER TABLE `registration_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_period_id` (`academic_period_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_program_id_foreign` (`program_id`),
  ADD KEY `students_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetables_course_id_foreign` (`course_id`),
  ADD KEY `timetables_student_id_foreign` (`student_id`),
  ADD KEY `timetables_lecturer_id_foreign` (`lecturer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `users_faculty_id_foreign` (`faculty_id`,`role_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_periods`
--
ALTER TABLE `academic_periods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_lecturer`
--
ALTER TABLE `course_lecturer`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course_offerings`
--
ALTER TABLE `course_offerings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_prerequisite`
--
ALTER TABLE `course_prerequisite`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_registrations`
--
ALTER TABLE `course_registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_requests`
--
ALTER TABLE `course_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `minor_registrations`
--
ALTER TABLE `minor_registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `program_structures`
--
ALTER TABLE `program_structures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `registration_periods`
--
ALTER TABLE `registration_periods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_lecturer`
--
ALTER TABLE `course_lecturer`
  ADD CONSTRAINT `course_lecturer_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_lecturer_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_offerings`
--
ALTER TABLE `course_offerings`
  ADD CONSTRAINT `course_offerings_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `course_offerings_ibfk_2` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`);

--
-- Constraints for table `course_prerequisite`
--
ALTER TABLE `course_prerequisite`
  ADD CONSTRAINT `course_prerequisite_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_prerequisite_prerequisite_id_foreign` FOREIGN KEY (`prerequisite_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_registrations`
--
ALTER TABLE `course_registrations`
  ADD CONSTRAINT `course_registrations_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_registrations_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_registrations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_requests`
--
ALTER TABLE `course_requests`
  ADD CONSTRAINT `course_requests_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_requests_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `course_requests_registration_period_id_foreign` FOREIGN KEY (`registration_period_id`) REFERENCES `registration_periods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `course_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `course_student_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_student_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturers_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lecturers_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lecturers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `minor_registrations`
--
ALTER TABLE `minor_registrations`
  ADD CONSTRAINT `minor_registrations_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `minor_registrations_registration_period_id_foreign` FOREIGN KEY (`registration_period_id`) REFERENCES `registration_periods` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_structures`
--
ALTER TABLE `program_structures`
  ADD CONSTRAINT `program_structures_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_structures_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`);

--
-- Constraints for table `registration_periods`
--
ALTER TABLE `registration_periods`
  ADD CONSTRAINT `registration_periods_ibfk_1` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`),
  ADD CONSTRAINT `timetables_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
