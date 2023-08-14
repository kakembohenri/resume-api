-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2023 at 09:18 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resume`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Resume_Id` bigint(20) UNSIGNED NOT NULL,
  `Phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LinkedIn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED NOT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`Id`, `Resume_Id`, `Phone`, `Website`, `Twitter`, `Facebook`, `Instagram`, `LinkedIn`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(1, 15, '0712345689', NULL, NULL, NULL, NULL, NULL, '2023-08-13 03:03:59', 16, NULL, NULL, NULL, NULL),
(2, 16, '0783467821', NULL, NULL, NULL, NULL, NULL, '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(3, 17, '0783267821', NULL, NULL, NULL, NULL, NULL, '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `education_histories`
--

CREATE TABLE `education_histories` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Resume_Id` bigint(20) UNSIGNED NOT NULL,
  `Institution` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Achievements` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `StartDate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED NOT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education_histories`
--

INSERT INTO `education_histories` (`Id`, `Resume_Id`, `Institution`, `Location`, `Achievements`, `StartDate`, `EndDate`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(13, 15, 'muk', 'muk hill', 'bach in evry thing', '2023-08-02', '2023-09-02', '2023-08-13 03:03:59', 16, NULL, NULL, NULL, NULL),
(14, 16, 'muk', 'the mighty hill', 'sdasadasdas', '2023-09-03', NULL, '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(15, 16, 'kyambogo', 'kyambss', 'sdfs sdfdds fgsfds', '2023-09-02', '2023-09-02', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(16, 17, 'muk', 'the mighty hill', 'asdasdasda', '2023-09-02', NULL, '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL),
(17, 17, 'kyams', 'kysgdhd', 'sdcsdsd', '2023-09-01', '2023-09-02', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_verification_tokens`
--

CREATE TABLE `email_verification_tokens` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_verification_tokens`
--

INSERT INTO `email_verification_tokens` (`Id`, `Email`, `Token`, `created_at`, `updated_at`) VALUES
(1, 'mobd3ep@gmail.com', 'DGXvXdIdUo9QRGZZLGeutjMSn32r2eVuPCSeN1fdahKuv28wpJw9jn9aWADTqYek', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Resume_Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED NOT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`Id`, `Resume_Id`, `Name`, `Level`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(6, 15, 'french', 'native', '2023-08-13 03:03:59', 16, NULL, NULL, NULL, NULL),
(7, 16, 'french', 'fluent', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(8, 16, 'tennuis', 'intermediate', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(9, 17, 'abc', 'native', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL),
(10, 17, 'dada', 'beginner', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_08_12_152542_create_statuses_table', 1),
(2, '2023_08_12_152929_create_roles_table', 2),
(3, '2014_10_12_000000_create_users_table', 3),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(6, '2023_08_12_153640_create_resumes_table', 5),
(7, '2023_08_12_154237_create_education_histories_table', 6),
(8, '2023_08_12_154449_create_work_histories_table', 6),
(9, '2023_08_12_154548_create_skills_table', 6),
(10, '2023_08_12_154816_create_languages_table', 6),
(11, '2023_08_12_154904_create_contacts_table', 6),
(12, '2023_08_12_153442_create_email_verification_tokens_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `User_Id` bigint(20) UNSIGNED NOT NULL,
  `AvatarPath` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MiddleName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Headline` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateOfBirth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Bio` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `CountryOfResidence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `City` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostalCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RefererCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED NOT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`Id`, `User_Id`, `AvatarPath`, `FirstName`, `MiddleName`, `LastName`, `Headline`, `DateOfBirth`, `Nationality`, `Gender`, `Bio`, `CountryOfResidence`, `City`, `PostalCode`, `RefererCode`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(15, 16, 'KakemboHenry-13-Aug-2023.jpeg', 'Kakembo', NULL, 'Henry', 'top G', '2023-08-17', 'Anguilla', 'male', 'dasdasdasd', 'Uganda', 'kampala', NULL, 'e9pARd2421aCejsa0LT6UwoHZEfaZwE5dj8HAAzzgeaPsEfT2FEnWPumBd6Q49sR', '2023-08-13 03:03:59', 16, NULL, NULL, NULL, NULL),
(16, 19, 'mobdeep-13-Aug-2023.png', 'mob', NULL, 'deep', 'deeep mobster', '2023-09-02', 'Norway', 'male', 'dej ssj ssk sjd doa siajs sosdsd', 'Uganda', 'kampala', NULL, 'LQJDGr3rTHKydGTKDNUZqIvpPZWSqQWFom1Bi6cVbh7HGKSnr8C2SIZ3ZjgYfxor', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(17, 20, 'testtester-14-Aug-2023.png', 'test', NULL, 'tester', 'tester', '2023-08-26', 'Argentina', 'male', 'testing tester', 'argentina', 'buenos aires', NULL, 'LF2T6I8yBYFicrdshim13k67Ia8D7KaKzebTGpd0AbgmpsevqV6BNNlua7tlYljN', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Id`, `Name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Resume_Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED NOT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`Id`, `Resume_Id`, `Name`, `Description`, `Level`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(13, 15, 'java', 'butto', 'beginner', '2023-08-13 03:03:59', 16, NULL, NULL, NULL, NULL),
(14, 16, 'java', 'script', 'expert', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(15, 16, 'james', 'Restful (API) for blood bank', 'intermediate', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(16, 17, 'skill', 'fineses', 'expert', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL),
(17, 17, 'java', 'Blood bank front end', 'beginner', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`Id`, `Name`) VALUES
(1, 'Verified'),
(2, 'UnVerified');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status_Id` bigint(20) UNSIGNED NOT NULL,
  `Role_Id` bigint(20) UNSIGNED NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED DEFAULT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Email`, `Password`, `Status_Id`, `Role_Id`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(16, 'kakembohenry5@gmail.com', '$2y$10$bnGj5Ymgjjvne1RO0ZlkmuoOAsktiuDZAmx.MMsEUMZ9XMj6kvGHm', 1, 2, '2023-08-12 19:15:59', NULL, '2023-08-12 16:15:59', NULL, NULL, NULL),
(19, 'mobd3ep@gmail.com', '$2y$10$qKpxnV0cfl8pyBMrBQT5gewLxJp4Z/UPdi.xSENjtwRD/GC81r13e', 1, 2, '2023-08-13 16:06:01', NULL, '2023-08-13 13:06:01', NULL, NULL, NULL),
(20, 'test@mail.com', '$2y$10$cpTTTSj5QbOSI7AUw/qkOuWl.rMYheYyE6W3dYrm2QvK9GT2mDQN6', 1, 2, '2023-08-14 06:44:46', NULL, '2023-08-14 03:44:46', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_histories`
--

CREATE TABLE `work_histories` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Resume_Id` bigint(20) UNSIGNED NOT NULL,
  `Company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Role` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `StartDate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` bigint(20) UNSIGNED NOT NULL,
  `ModifiedAt` timestamp NULL DEFAULT NULL,
  `Modified_By` bigint(20) UNSIGNED DEFAULT NULL,
  `Deleted_By` bigint(20) UNSIGNED DEFAULT NULL,
  `DeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_histories`
--

INSERT INTO `work_histories` (`Id`, `Resume_Id`, `Company`, `Position`, `Role`, `StartDate`, `EndDate`, `CreatedAt`, `Created_By`, `ModifiedAt`, `Modified_By`, `Deleted_By`, `DeletedAt`) VALUES
(13, 15, 'bidco', 'manager', 'managing stuff', '2023-08-03', '2023-08-11', '2023-08-13 03:03:59', 16, NULL, NULL, NULL, NULL),
(14, 16, 'adsada', 'asdasda', 'adasdas', '2023-09-10', NULL, '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(15, 16, 'hrye', 'nsapsuw', 'player', '2023-08-08', '2023-09-03', '2023-08-13 14:41:25', 19, NULL, NULL, NULL, NULL),
(16, 17, 'bidco', 'asdasda', 'asdads', '2023-09-07', '2023-09-03', '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL),
(17, 17, 'police', 'capi', 'killings', '2023-08-04', NULL, '2023-08-14 03:51:36', 20, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `contacts_resume_id_foreign` (`Resume_Id`),
  ADD KEY `contacts_created_by_foreign` (`Created_By`),
  ADD KEY `contacts_modified_by_foreign` (`Modified_By`),
  ADD KEY `contacts_deleted_by_foreign` (`Deleted_By`);

--
-- Indexes for table `education_histories`
--
ALTER TABLE `education_histories`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `education_histories_resume_id_foreign` (`Resume_Id`),
  ADD KEY `education_histories_created_by_foreign` (`Created_By`),
  ADD KEY `education_histories_modified_by_foreign` (`Modified_By`),
  ADD KEY `education_histories_deleted_by_foreign` (`Deleted_By`);

--
-- Indexes for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `languages_resume_id_foreign` (`Resume_Id`),
  ADD KEY `languages_created_by_foreign` (`Created_By`),
  ADD KEY `languages_modified_by_foreign` (`Modified_By`),
  ADD KEY `languages_deleted_by_foreign` (`Deleted_By`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `resumes_referercode_unique` (`RefererCode`),
  ADD KEY `resumes_user_id_foreign` (`User_Id`),
  ADD KEY `resumes_created_by_foreign` (`Created_By`),
  ADD KEY `resumes_modified_by_foreign` (`Modified_By`),
  ADD KEY `resumes_deleted_by_foreign` (`Deleted_By`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `skills_resume_id_foreign` (`Resume_Id`),
  ADD KEY `skills_created_by_foreign` (`Created_By`),
  ADD KEY `skills_modified_by_foreign` (`Modified_By`),
  ADD KEY `skills_deleted_by_foreign` (`Deleted_By`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `users_email_unique` (`Email`),
  ADD KEY `users_status_id_foreign` (`Status_Id`),
  ADD KEY `users_role_id_foreign` (`Role_Id`),
  ADD KEY `users_created_by_foreign` (`Created_By`),
  ADD KEY `users_modified_by_foreign` (`Modified_By`),
  ADD KEY `users_deleted_by_foreign` (`Deleted_By`);

--
-- Indexes for table `work_histories`
--
ALTER TABLE `work_histories`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `work_histories_resume_id_foreign` (`Resume_Id`),
  ADD KEY `work_histories_created_by_foreign` (`Created_By`),
  ADD KEY `work_histories_modified_by_foreign` (`Modified_By`),
  ADD KEY `work_histories_deleted_by_foreign` (`Deleted_By`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `education_histories`
--
ALTER TABLE `education_histories`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `work_histories`
--
ALTER TABLE `work_histories`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `contacts_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `contacts_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `contacts_resume_id_foreign` FOREIGN KEY (`Resume_Id`) REFERENCES `resumes` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `education_histories`
--
ALTER TABLE `education_histories`
  ADD CONSTRAINT `education_histories_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `education_histories_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `education_histories_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `education_histories_resume_id_foreign` FOREIGN KEY (`Resume_Id`) REFERENCES `resumes` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `languages_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `languages_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `languages_resume_id_foreign` FOREIGN KEY (`Resume_Id`) REFERENCES `resumes` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `resumes`
--
ALTER TABLE `resumes`
  ADD CONSTRAINT `resumes_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `resumes_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `resumes_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `resumes_user_id_foreign` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `skills_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `skills_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `skills_resume_id_foreign` FOREIGN KEY (`Resume_Id`) REFERENCES `resumes` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `users_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `users_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`Role_Id`) REFERENCES `roles` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_status_id_foreign` FOREIGN KEY (`Status_Id`) REFERENCES `statuses` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `work_histories`
--
ALTER TABLE `work_histories`
  ADD CONSTRAINT `work_histories_created_by_foreign` FOREIGN KEY (`Created_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `work_histories_deleted_by_foreign` FOREIGN KEY (`Deleted_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `work_histories_modified_by_foreign` FOREIGN KEY (`Modified_By`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `work_histories_resume_id_foreign` FOREIGN KEY (`Resume_Id`) REFERENCES `resumes` (`Id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
