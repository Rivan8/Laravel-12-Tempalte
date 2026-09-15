/*
 Navicat Premium Data Transfer

 Source Server         : elshaddai
 Source Server Type    : MySQL
 Source Server Version : 80200 (8.2.0)
 Source Host           : localhost:3306
 Source Schema         : equipClass

 Target Server Type    : MySQL
 Target Server Version : 80200 (8.2.0)
 File Encoding         : 65001

 Date: 11/09/2026 10:13:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for batches
-- ----------------------------
DROP TABLE IF EXISTS `batches`;
CREATE TABLE `batches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int NOT NULL,
  `nama_batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `batches_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `batches_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of batches
-- ----------------------------
BEGIN;
INSERT INTO `batches` (`id`, `kelas_id`, `nama_batch`, `start_date`, `is_active`, `created_at`, `updated_at`) VALUES (1, 2, 'Batch Default', '2026-04-22', 1, '2026-04-22 08:34:55', '2026-04-22 08:34:55');
INSERT INTO `batches` (`id`, `kelas_id`, `nama_batch`, `start_date`, `is_active`, `created_at`, `updated_at`) VALUES (2, 3, 'Batch Default', '2026-04-22', 1, '2026-04-22 08:34:55', '2026-04-22 08:34:55');
INSERT INTO `batches` (`id`, `kelas_id`, `nama_batch`, `start_date`, `is_active`, `created_at`, `updated_at`) VALUES (3, 4, 'Batch Default', '2026-04-22', 1, '2026-04-22 08:34:55', '2026-04-22 08:34:55');
INSERT INTO `batches` (`id`, `kelas_id`, `nama_batch`, `start_date`, `is_active`, `created_at`, `updated_at`) VALUES (4, 5, 'Batch Default', '2026-04-22', 1, '2026-04-22 08:34:55', '2026-04-22 08:34:55');
COMMIT;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------
BEGIN;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('esc-equip-discipleship-cache-rivan.tampi77@gmail.com|127.0.0.1', 'i:1;', 1776130835);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('esc-equip-discipleship-cache-rivan.tampi77@gmail.com|127.0.0.1:timer', 'i:1776130835;', 1776130835);
COMMIT;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` text NOT NULL,
  `exception` text NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` text NOT NULL,
  `options` text,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` text NOT NULL,
  `attempts` int NOT NULL,
  `reserved_at` int DEFAULT NULL,
  `available_at` int NOT NULL,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `deskripsi` text,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `prasyarat_kelas_id` int DEFAULT NULL,
  `link_quiz` varchar(255) DEFAULT NULL,
  `handbook` varchar(255) DEFAULT NULL,
  `handbook_name` varchar(255) DEFAULT NULL,
  `tools` varchar(255) DEFAULT NULL,
  `tools_name` varchar(255) DEFAULT NULL,
  `slide` varchar(255) DEFAULT NULL,
  `slide_name` varchar(255) DEFAULT NULL,
  `file_4` varchar(255) DEFAULT NULL,
  `file_4_name` varchar(255) DEFAULT NULL,
  `file_5` varchar(255) DEFAULT NULL,
  `file_5_name` varchar(255) DEFAULT NULL,
  `file_6` varchar(255) DEFAULT NULL,
  `file_6_name` varchar(255) DEFAULT NULL,
  `file_7` varchar(255) DEFAULT NULL,
  `file_7_name` varchar(255) DEFAULT NULL,
  `file_8` varchar(255) DEFAULT NULL,
  `file_8_name` varchar(255) DEFAULT NULL,
  `file_9` varchar(255) DEFAULT NULL,
  `file_9_name` varchar(255) DEFAULT NULL,
  `file_10` varchar(255) DEFAULT NULL,
  `file_10_name` varchar(255) DEFAULT NULL,
  `file_11` varchar(255) DEFAULT NULL,
  `file_11_name` varchar(255) DEFAULT NULL,
  `file_12` varchar(255) DEFAULT NULL,
  `file_12_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prasyarat_kelas_id` (`prasyarat_kelas_id`),
  CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`prasyarat_kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of kelas
-- ----------------------------
BEGIN;
INSERT INTO `kelas` (`id`, `nama_kelas`, `kategori`, `deskripsi`, `gambar`, `created_at`, `updated_at`, `prasyarat_kelas_id`, `link_quiz`, `handbook`, `handbook_name`, `tools`, `tools_name`, `slide`, `slide_name`, `file_4`, `file_4_name`, `file_5`, `file_5_name`, `file_6`, `file_6_name`, `file_7`, `file_7_name`, `file_8`, `file_8_name`, `file_9`, `file_9_name`, `file_10`, `file_10_name`, `file_11`, `file_11_name`, `file_12`, `file_12_name`) VALUES (2, 'CORE TEAM TRAINNING (CTT)', 'Disciples Community', 'Kelas Pelatihan untuk core team', 'img/curved-images/curved1.jpg', '2026-03-25 12:23:42', '2026-04-24 04:11:49', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdLGqp4aLH2U7Ep8q6EyWC4CgSIeyVY6T49DFJ-i8BqcyNmeg/viewform?usp=header', 'storage/materi_pendukung/wEVZMiEYdhBleRju9QszFAHlgGiZHpsDbQZVS0F5.pdf', NULL, NULL, NULL, NULL, NULL, 'storage/materi_pendukung/V4cz1dkjHxcD9Pf7bDYHaFeSMGuJ6ln1WkgwH3O8.pdf', NULL, 'storage/materi_pendukung/T370a9smr8ZB25i0uAkFBR9uKvVgMStUsiHylgcV.pdf', 'file tambahan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `kelas` (`id`, `nama_kelas`, `kategori`, `deskripsi`, `gambar`, `created_at`, `updated_at`, `prasyarat_kelas_id`, `link_quiz`, `handbook`, `handbook_name`, `tools`, `tools_name`, `slide`, `slide_name`, `file_4`, `file_4_name`, `file_5`, `file_5_name`, `file_6`, `file_6_name`, `file_7`, `file_7_name`, `file_8`, `file_8_name`, `file_9`, `file_9_name`, `file_10`, `file_10_name`, `file_11`, `file_11_name`, `file_12`, `file_12_name`) VALUES (3, 'Disciple Maker Trainning (DMT', 'Disciples Community', 'Dmt', 'img/curved-images/curved1.jpg', '2026-03-25 12:24:33', '2026-03-25 12:24:33', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `kelas` (`id`, `nama_kelas`, `kategori`, `deskripsi`, `gambar`, `created_at`, `updated_at`, `prasyarat_kelas_id`, `link_quiz`, `handbook`, `handbook_name`, `tools`, `tools_name`, `slide`, `slide_name`, `file_4`, `file_4_name`, `file_5`, `file_5_name`, `file_6`, `file_6_name`, `file_7`, `file_7_name`, `file_8`, `file_8_name`, `file_9`, `file_9_name`, `file_10`, `file_10_name`, `file_11`, `file_11_name`, `file_12`, `file_12_name`) VALUES (4, 'Foundation Class 1 - SALVATION & BAPTISM', 'Equip - New', 'Kelas Pengajaran tentang keselamatan dan baptisan', 'img/curved-images/curved1.jpg', '2026-03-25 13:00:34', '2026-04-07 08:21:49', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdLGqp4aLH2U7Ep8q6EyWC4CgSIeyVY6T49DFJ-i8BqcyNmeg/viewform?usp=header', 'storage/materi_pendukung/9BJFmKDqepsmFlG32AOdsTsCQn32pEZVRwYWJZOB.pdf', NULL, 'storage/materi_pendukung/Zhlfdzgr522akv8pcc2kU3Vrixa532PSOL4IS0lZ.docx', NULL, 'storage/materi_pendukung/IYITu05qZjZJmB4gAyESGAJRVLLjaFxEvQ7B3R7Q.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `kelas` (`id`, `nama_kelas`, `kategori`, `deskripsi`, `gambar`, `created_at`, `updated_at`, `prasyarat_kelas_id`, `link_quiz`, `handbook`, `handbook_name`, `tools`, `tools_name`, `slide`, `slide_name`, `file_4`, `file_4_name`, `file_5`, `file_5_name`, `file_6`, `file_6_name`, `file_7`, `file_7_name`, `file_8`, `file_8_name`, `file_9`, `file_9_name`, `file_10`, `file_10_name`, `file_11`, `file_11_name`, `file_12`, `file_12_name`) VALUES (5, 'Membership Class', 'Equip - New', 'kelas Untuk mengenal tentang profil El shaddai church', 'img/curved-images/curved1.jpg', '2026-03-25 13:01:43', '2026-03-25 13:01:43', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for kelas_users
-- ----------------------------
DROP TABLE IF EXISTS `kelas_users`;
CREATE TABLE `kelas_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `status` enum('requested','in_progress','completed','rejected') DEFAULT 'requested',
  `rejection_reason` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `batch_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `kelas_users_batch_id_foreign` (`batch_id`),
  CONSTRAINT `kelas_users_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kelas_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kelas_users_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of kelas_users
-- ----------------------------
BEGIN;
INSERT INTO `kelas_users` (`id`, `user_id`, `kelas_id`, `status`, `rejection_reason`, `created_at`, `updated_at`, `batch_id`) VALUES (1, 1, 2, 'completed', NULL, '2026-03-25 12:26:37', '2026-03-25 12:58:01', 1);
INSERT INTO `kelas_users` (`id`, `user_id`, `kelas_id`, `status`, `rejection_reason`, `created_at`, `updated_at`, `batch_id`) VALUES (2, 1, 3, 'in_progress', NULL, '2026-03-25 12:58:52', '2026-03-27 02:50:17', 2);
INSERT INTO `kelas_users` (`id`, `user_id`, `kelas_id`, `status`, `rejection_reason`, `created_at`, `updated_at`, `batch_id`) VALUES (3, 1, 4, 'completed', NULL, '2026-03-25 13:03:06', '2026-03-25 13:04:28', 3);
INSERT INTO `kelas_users` (`id`, `user_id`, `kelas_id`, `status`, `rejection_reason`, `created_at`, `updated_at`, `batch_id`) VALUES (4, 1, 5, 'in_progress', NULL, '2026-03-25 13:04:48', '2026-04-01 00:43:17', 4);
INSERT INTO `kelas_users` (`id`, `user_id`, `kelas_id`, `status`, `rejection_reason`, `created_at`, `updated_at`, `batch_id`) VALUES (6, 67, 4, 'rejected', 'Anda diharuskan untuk mengikuti kelas CTT', '2026-04-22 08:50:37', '2026-04-22 08:59:57', 3);
COMMIT;

-- ----------------------------
-- Table structure for materi_users
-- ----------------------------
DROP TABLE IF EXISTS `materi_users`;
CREATE TABLE `materi_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `materi_id` int NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materi_users_user_id_materi_id_unique` (`user_id`,`materi_id`),
  KEY `materi_id` (`materi_id`),
  CONSTRAINT `materi_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materi_users_ibfk_2` FOREIGN KEY (`materi_id`) REFERENCES `materis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of materi_users
-- ----------------------------
BEGIN;
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (6, 1, 7, 1, '2026-03-27 01:56:07', '2026-03-27 01:56:07');
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (7, 1, 8, 1, '2026-03-27 01:56:17', '2026-03-27 01:56:17');
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (8, 1, 2, 1, '2026-03-31 08:57:56', '2026-03-31 08:57:56');
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (9, 1, 3, 1, '2026-03-31 08:58:06', '2026-03-31 08:58:06');
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (10, 1, 17, 1, '2026-03-31 09:01:21', '2026-03-31 09:01:21');
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (11, 1, 9, 1, '2026-04-02 02:21:47', '2026-04-02 02:21:47');
INSERT INTO `materi_users` (`id`, `user_id`, `materi_id`, `is_completed`, `created_at`, `updated_at`) VALUES (12, 1, 10, 1, '2026-04-02 02:23:01', '2026-04-02 02:23:01');
COMMIT;

-- ----------------------------
-- Table structure for materis
-- ----------------------------
DROP TABLE IF EXISTS `materis`;
CREATE TABLE `materis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kelas_id` int NOT NULL,
  `sesi_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `video_url` varchar(255) NOT NULL,
  `pembicara` varchar(255) DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `materis_sesi_id_foreign` (`sesi_id`),
  CONSTRAINT `materis_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materis_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of materis
-- ----------------------------
BEGIN;
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (2, 2, 1, 'Introduction - Church Vision', NULL, 'https://youtu.be/_DmYy0SkNXM', NULL, 1, '2026-03-25 12:25:12', '2026-03-27 02:50:52');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (3, 2, 1, 'The Why - Mengapa Memuridkan?', 'fff', 'https://youtu.be/mwLmEWaYtH8', NULL, 2, '2026-03-25 12:25:48', '2026-03-27 02:53:22');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (7, 4, 2, 'Keselamatan-Pertanyaan Besar: Mengapa Tuhan yang Baik mengijinkan Kejahatan?', 'Penjelasan ringkas: Pertanyaan Besar : Mengapa Tuhan yang Baik mengijinkan Kejahatan?', 'https://www.youtube.com/embed/fEaEW90Fgik', 'Ps.Yehezkiel Wilan', 1, '2026-03-27 01:47:09', '2026-04-14 08:36:30');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (8, 4, 2, 'Ps.Yehezkiel Wilan - Apa itu dosa?', 'Penjelasan ringkas: Apa itu Dosa?', 'https://www.youtube.com/embed/Y2jQIfbk7is', NULL, 2, '2026-03-27 01:49:19', '2026-03-27 01:49:19');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (9, 4, 2, 'Ps.Yehezkiel Wilan - Bagaimana Caranya supaya saya diselamatkan?', 'Penjelasan ringkas: Bagaimana caranya manusia diselamatkan?', 'https://youtu.be/uRNlMbXq0nA', NULL, 3, '2026-03-27 01:55:56', '2026-03-27 01:55:56');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (10, 4, 2, 'Ps.Yehezkiel Wilan - Jaminan Keselamatan', 'Penjelasan ringkas: Jaminan Keselamatan', 'https://youtu.be/fEaEW90Fgik', NULL, 4, '2026-03-27 01:57:50', '2026-03-27 01:57:50');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (11, 4, 3, 'Ps.Rivan Stevanus Tampi - Mengapa Baptisan Penting?', 'Penjelasan ringkas: Mengapa Baptisan Penting?', 'https://youtu.be/33eFB70wtbk', NULL, 5, '2026-03-27 01:59:52', '2026-03-27 01:59:52');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (12, 4, 3, 'Ps.Rivan Stevanus Tampi - Apa itu Baptisan?', 'Apa itu Baptisan?', 'https://youtu.be/7DI1zo8ioiI', NULL, 6, '2026-03-27 02:16:47', '2026-03-27 02:16:47');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (13, 4, 3, 'Ps.Rivan Stevanus Tampi - Dasar Alkitabiah Baptisan', 'Dasar Alkitabiah Baptisan', 'https://youtu.be/bM3fXwLPLDg', NULL, 7, '2026-03-27 02:17:51', '2026-03-27 02:17:51');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (14, 4, 3, 'Ps.Rivan Stevanus Tampi - Makna Rohani Baptisan', 'Makna Rohani Baptisan', 'https://youtu.be/DQiIs3LfsHA', NULL, 8, '2026-03-27 02:18:57', '2026-03-27 02:18:57');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (15, 4, 3, 'Ps.Rivan Stevanus Tampi - Siapa yang perlu dibaptis?', 'Siapa yang perlu dibaptis?', 'https://youtu.be/dw1OmO_4gQ8', NULL, 9, '2026-03-27 02:19:47', '2026-03-27 02:19:47');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (16, 4, 3, 'Ps.Rivan Stevanus Tampi - Baptisan & kehidupan setelahnya Undangan untuk Meresponi', 'Baptisan & kehidupan setelahnya Undangan untuk Meresponi', 'https://youtu.be/jp0-olFaQJQ', NULL, 10, '2026-03-27 02:20:24', '2026-03-27 02:20:24');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (17, 2, 1, 'The What - Disciples Community', NULL, 'https://youtu.be/dVbIbNe6K3A', NULL, 3, '2026-03-27 02:59:32', '2026-03-27 02:59:32');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (18, 2, 1, 'The How - Dasar Pemuridan', NULL, 'https://youtu.be/lWI_SFe_r6s', NULL, 4, '2026-03-27 03:04:01', '2026-03-27 03:04:01');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (19, 2, 1, 'Membangun Hubungan dalam Komunitas', NULL, 'https://youtu.be/x4Yr31kzFXU', NULL, 5, '2026-03-27 03:12:36', '2026-03-27 03:12:36');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (20, 2, 1, 'Menyimak Secara Aktif dan Empati', NULL, 'https://youtu.be/BfG22W5u93s', NULL, 6, '2026-03-27 03:14:06', '2026-03-27 03:14:06');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (21, 2, 1, 'Bertanya dengan Baik dan terarah', NULL, 'https://youtu.be/ZcW4a3xZ2TQ', NULL, 7, '2026-03-27 03:15:05', '2026-03-27 03:15:05');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (22, 2, 1, 'DM -Gembala dan Kepemimpinan', NULL, 'https://youtu.be/RvSzscclbiU', NULL, 8, '2026-03-27 03:16:14', '2026-03-27 03:16:14');
INSERT INTO `materis` (`id`, `kelas_id`, `sesi_id`, `judul`, `deskripsi`, `video_url`, `pembicara`, `urutan`, `created_at`, `updated_at`) VALUES (23, 2, 1, 'Greetings - Penutup', NULL, 'https://youtu.be/QeD5Ko6tYYo', NULL, 9, '2026-03-27 03:17:09', '2026-03-27 03:17:09');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2026_03_25_003126_create_kelas_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2026_03_25_003203_create_kelas_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2026_03_25_024616_create_materis_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2026_03_25_045613_create_materi_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2026_03_25_100000_alter_kelas_table_add_prasyarat', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2026_03_27_022823_add_link_quiz_to_kelas_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2026_04_02_005711_create_personal_access_tokens_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2026_04_07_070321_add_download_files_to_kelas_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13, '2026_04_14_014834_add_pembicara_to_materis_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14, '2026_04_18_040641_create_batches_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15, '2026_04_18_040642_add_batch_id_to_kelas_users_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16, '2026_04_22_071031_add_rejection_reason_to_kelas_users_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17, '2026_04_22_071556_add_rejection_reason_to_kelas_users_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18, '2026_04_22_084624_add_rejection_reason_column_to_kelas_users', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19, '2026_04_22_085530_update_status_enum_in_kelas_users_table', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20, '2026_04_24_040715_add_extra_files_to_kelas_table', 9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21, '2026_09_11_000000_add_sesi_id_to_materis_table', 10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22, '2026_09_11_000001_create_sesis_table', 11);
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
BEGIN;
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES ('rivan.tampi7@gmail.com', '$2y$12$q4OCfb.Np46umbBhiedccuEInGCwhYGoxlutIJRRM5xGerVdgg0Cy', '2026-03-31 09:03:42');
COMMIT;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sesis
-- ----------------------------
DROP TABLE IF EXISTS `sesis`;
CREATE TABLE `sesis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `link_quiz` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sesis_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `sesis_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sesis
-- ----------------------------
BEGIN;
INSERT INTO `sesis` (`id`, `kelas_id`, `judul`, `deskripsi`, `link_quiz`, `urutan`, `created_at`, `updated_at`) VALUES (1, 2, 'Sesi 1', NULL, NULL, 1, '2026-09-11 02:49:45', '2026-09-11 02:49:45');
INSERT INTO `sesis` (`id`, `kelas_id`, `judul`, `deskripsi`, `link_quiz`, `urutan`, `created_at`, `updated_at`) VALUES (2, 4, 'KESELAMATAN', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdLGqp4aLH2U7Ep8q6EyWC4CgSIeyVY6T49DFJ-i8BqcyNmeg/viewform?usp=header', 1, '2026-09-11 02:49:45', '2026-09-11 03:09:42');
INSERT INTO `sesis` (`id`, `kelas_id`, `judul`, `deskripsi`, `link_quiz`, `urutan`, `created_at`, `updated_at`) VALUES (3, 4, 'BAPTISAN', NULL, 'https://docs.google.com/forms/d/e/1FAIpQLSdLGqp4aLH2U7Ep8q6EyWC4CgSIeyVY6T49DFJ-i8BqcyNmeg/viewform?usp=header', 2, '2026-09-11 02:56:36', '2026-09-11 03:09:48');
INSERT INTO `sesis` (`id`, `kelas_id`, `judul`, `deskripsi`, `link_quiz`, `urutan`, `created_at`, `updated_at`) VALUES (4, 4, 'DOA', NULL, NULL, 3, '2026-09-11 02:56:56', '2026-09-11 02:56:56');
INSERT INTO `sesis` (`id`, `kelas_id`, `judul`, `deskripsi`, `link_quiz`, `urutan`, `created_at`, `updated_at`) VALUES (5, 4, 'KOMUNITAS', NULL, NULL, 4, '2026-09-11 02:57:07', '2026-09-11 02:57:07');
COMMIT;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_last_activity_index` (`last_activity`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
BEGIN;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('nw96l9LoewY42PLqMWNIU4odK7mAqzBfjjkaJdSZ', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDFXMVZ6cHQ0WkRtb0xIeFlzMXU2YkZ6cnRwR1FMRlZ0enZDZlpvNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1789096285);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki laki','Perempuan') NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `role` enum('Admin','Fasilitator','Member') NOT NULL DEFAULT 'Member',
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Rivan Stevanus', 'Laki laki', 'rivan.tampi7@gmail.com', '085234786655', 'Admin', NULL, '$2y$12$/i.SJq6cCCbsqrlALe4C3eEOoFabJsIUSMUtW2vNgyp99LFBVm8Ry', NULL, '2026-03-25 11:25:53', '2026-03-25 11:25:53');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (2, 'Rivan Tampi', 'Laki laki', 'rivan.tampi@gmail.com', '345252352352', 'Member', NULL, '$2y$12$pgnrFfQlBli7YHF0/zTh0.f/Wtgpt2kMWdXBXrJT9SbXyYTBoV0Kq', NULL, '2026-03-25 11:25:53', '2026-03-25 11:25:53');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (3, 'Makayla Shekinah Tampi', 'Laki laki', 'Makayla77@gmail.com', '085234786655', 'Member', NULL, '$2y$12$XitRVjCGVpzOAwSIGUm8j.OnxWmHH1b4FJlug..42QfU9RoSqr.06', NULL, '2026-03-25 11:25:53', '2026-03-25 11:25:53');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (4, 'Rivan Stevanus', 'Laki laki', 'rivan.tampi77@gmail.com', '085234786655', 'Fasilitator', NULL, '$2y$12$LQkpGAeAfhTP8Fxbt77EgOSMYFI9gBDF2rFMz1mnG8oV8x/dKqFPq', NULL, '2026-03-25 11:25:53', '2026-03-27 08:57:36');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (5, 'Shane Darren Ghevariel Tampi', 'Laki laki', 'rivan.tampi777@gmail.com', '085234786655', 'Member', NULL, '$2y$12$FfbWolCv550835jRmKw4Q.ZSDnTIBZnlsCrtBbM67ofKFANDJkaHm', NULL, '2026-03-25 11:25:53', '2026-03-25 11:25:53');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (6, 'Agam Suteja', 'Laki laki', 'agam7@gmail.com', '098739850994', 'Member', NULL, '$2y$12$tRE7NXheHdHMpNxFw28a7eDM3SjaNMuoN6j7HTk/OueWGbaXO4F8C', NULL, '2025-09-04 13:32:00', '2025-09-04 13:32:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (7, 'Lampos Rajagukguk', 'Laki laki', 'workoflamposaritonang@gmail.com', '089648565494', 'Member', NULL, '$2y$12$I3HU3PUw0rckbm4njbtIzOXojLRvWpxwyrqIQ3pelK7e7UPjMzaUm', NULL, '2025-10-10 16:21:00', '2025-10-10 16:21:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (8, 'Alfiano Armando Tagor', 'Laki laki', 'alfiano.armando46@gmail.com', '081251125443', 'Member', NULL, '$2y$12$LQOwE0ELdRSZvOsBrYGcaOpU2/iODrpOv6YyfW5gIqDyKu4ku7iKa', NULL, '2025-09-02 19:57:00', '2025-09-02 19:57:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (9, 'Rina Vidiawati', 'Laki laki', 'rinavidiawati@gmail.com', '0812000111222', 'Member', NULL, '$2y$12$1LExHaZSEz7bBBnXdgW/h.aLzBOxjleN0DJCJPvFLgH/Bn//DbAcW', NULL, '2025-09-15 19:17:00', '2025-09-15 19:17:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (10, 'Romida Elpina Lubis', 'Laki laki', 'romida.elpina@gmail.com', '081274506852', 'Member', NULL, '$2y$12$AaweWd.vhErNmNFUW9u6h.CvNuzlEK0YFtUUiJ7tTH.lqna4/SzFy', NULL, '2025-09-26 10:09:00', '2025-09-26 10:09:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (11, 'Sumiati', 'Laki laki', 'elvi8nadapdap8@gmail.com', '0895374165511', 'Member', NULL, '$2y$12$6Gaw/QPq5BImiK8KQApE5evXNe7zV2NVMOhL3ztejI5ktoO./yiJK', NULL, '2025-09-09 16:49:00', '2025-09-09 16:49:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (12, 'Natan Chandra Lisandi', 'Laki laki', 'natanchandra67@gmail.com', '085822642708', 'Member', NULL, '$2y$12$0O4tZfQNbWEDaOrHYPAGkOHqNikDMm3X6J1ihA4UPrk0OEvw4QSym', NULL, '2025-10-15 11:10:00', '2025-10-15 11:10:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (13, 'Rachel Miriam Aprilia Ginting', 'Laki laki', 'rachelapriliagins@gmail.com', '082154894378', 'Member', NULL, '$2y$12$vrRHqkWQLOkGvy9HDYbX8.H8cV9IdCl2oCSvH1WS5F1TGsCbqstN.', NULL, '2025-10-15 17:22:00', '2025-10-15 17:22:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (14, 'Yemima Ceria', 'Laki laki', 'yemimaceria@gmail.com', '089619130126', 'Member', NULL, '$2y$12$JCqH.vPhGQBnV/lfdPw.Z.zNQleS2YkRHxPtpD59gpxIy/zaPFA9m', NULL, '2025-10-08 18:52:00', '2025-10-08 18:52:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (15, 'Alex Renaldy Lumban Gaol', 'Laki laki', 'marbun1412@gmail.com', '085787217404', 'Member', NULL, '$2y$12$WjFiD.H84jByX1DdPAftHuUcPD1R4Tj2lJThCRL.Y7F/HujMo7FDG', NULL, '2025-10-18 20:57:00', '2025-10-18 20:57:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (16, 'Mardoyo', 'Laki laki', 'mardoyo17@gmail.com', '082255338103', 'Member', NULL, '$2y$12$JGCKysBPCW5KQrBBWSXjXunafyDtptCziWgzQeJUnSN7GfGnYKoxC', NULL, '2025-10-02 11:52:00', '2025-10-02 11:52:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (17, 'Florentina Eka Aresya', 'Laki laki', 'florentina.eka687@gmail.com', '081283352608', 'Member', NULL, '$2y$12$WG0t2AFaDe.YO0r.sfd3Cu1Wvks2AmCDecLpS7Pnwbq4IlQeZXmOy', NULL, '2025-09-13 16:42:00', '2025-09-13 16:42:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (18, 'Sepni Epiensus Kalnus', 'Laki laki', 'jager.power@gmail.com', '081283352608', 'Member', NULL, '$2y$12$JuU/YJPioHOIOS/vcaKrVOTqdE.Ra4a89Dj9pVDizEbtK1Ch1/fj2', NULL, '2025-09-17 10:53:00', '2025-09-17 10:53:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (19, 'Ferry Oktavinlii', 'Laki laki', 'ferrygt75@gmail.com', '085754220374', 'Member', NULL, '$2y$12$Xbvi0fQLKN.0UKmEO0Ttvult69oCfVVVZKygu2RJv.AIKxicjqmJ2', NULL, '2025-09-20 16:31:00', '2025-09-20 16:31:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (20, 'Yesi Aprilia', 'Laki laki', 'yesiaprilia2304@gmail.com', '08990686857', 'Member', NULL, '$2y$12$ur9KTZ316rPP42.niWhqZuIgLopjSZqw4rky6CSZze27zvE1cCI.S', NULL, '2025-10-20 17:32:00', '2025-10-20 17:32:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (21, 'Figar Prafky Lumberji', 'Laki laki', 'figarpraf@gmail.com', '081248220105', 'Member', NULL, '$2y$12$elccBZHELiE7KrXjoC64NupT9mMhwlR3fYvM/WGQ7I1RqU8nCMeBG', NULL, '2025-10-15 13:34:00', '2025-10-15 13:34:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (22, 'Vella Noviant Goliked', 'Laki laki', 'vellaokke@gmail.com', '08152052183', 'Member', NULL, '$2y$12$0MjfvxL1GgOJbsCVurh5k.9pssUj6gtL.J6RkXkZltfenScWV/v1O', NULL, '2025-10-01 14:52:00', '2025-10-01 14:52:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (23, 'ESC DC', 'Perempuan', 'elshaddaichurchdc@gmail.com', '085245767038', 'Member', NULL, '$2y$12$3eHmcfkE8vNafJPOwYHpO.CKcyJ5iV1G8X5uLXSkZDEPeciyjaboC', NULL, '2025-10-24 16:42:00', '2025-10-24 16:42:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (24, 'Luciana Epridaiani Napitupulu', 'Laki laki', 'lucianaefridaiani@gmail.com', '0895603037674', 'Member', NULL, '$2y$12$jColKSYpaqt9PYv0WCqZn.Lm1/hCpeAhIedEW70k0C3LLlgFiaOjK', NULL, '2025-09-27 20:20:00', '2025-09-27 20:20:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (25, 'Susiana', 'Laki laki', 'susi.bilha77@gmail.com', '082157985933', 'Member', NULL, '$2y$12$ScjoHDlrznTgYl5easmuxe2QUx.e1qUVP606g3ux9MI4t5bkPJoIi', NULL, '2025-09-22 11:35:00', '2025-09-22 11:35:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (26, 'Velyn Claristhya', 'Laki laki', 'vclaristhya1@gmail.com', '089657904296', 'Member', NULL, '$2y$12$K41HT/qI7z5zBW4hOS1ehumEuKXuiFVr7OGBunRNLT2qZneneCJ6u', NULL, '2025-09-25 18:31:00', '2025-09-25 18:31:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (27, 'Devi Ayu Ellya Rizky', 'Laki laki', 'ellyarizky@gmail.com', '089509623747', 'Member', NULL, '$2y$12$L8slYYIwe8agk4P0Gy5NIuW2.vnRWSbUqkCCcZxOJ/rbzusetYO5a', NULL, '2025-09-10 20:12:00', '2025-09-10 20:12:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (28, 'Nourdin Jaya', 'Laki laki', 'Adien.jaya@yahoo.com', '082157440508', 'Member', NULL, '$2y$12$IG5ECEEGdGZeBJf3OBtMb.rBrpek7fNWyIstSorNf2Gpi8eWLLwB6', NULL, '2025-09-01 09:40:00', '2025-09-01 09:40:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (29, 'Evy Rosdiana Pangaribuan', 'Laki laki', 'rosdianaevy13@gmail.com', '082159477755', 'Member', NULL, '$2y$12$jsXTOsI4lMRom/p3/68bJ.En6w7ikXeEK.D3y5AV9DJkaVLqLhW.a', NULL, '2025-09-18 16:41:00', '2025-09-18 16:41:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (30, 'Andri Himawan', 'Laki laki', 'pangaribuanevy@gmail.com', '081352966255', 'Member', NULL, '$2y$12$B34XwUZFemV/JWum8kj5huwcko9FlNbybGoYbDXtrSsTOVkxXAF1O', NULL, '2025-10-16 19:59:00', '2025-10-16 19:59:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (31, 'Siauw Betty', 'Laki laki', 'sb3ty86@gmail.com', '081352068489', 'Member', NULL, '$2y$12$Rp9RlZwl0b1tTmrcYJ6gZOhLmZmP8wAClQs24l4G2GXJgZpTp8kVe', NULL, '2025-09-24 17:23:00', '2025-09-24 17:23:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (32, 'Chelsea Ruth Stevani', 'Laki laki', 'chelsearth8@gmail.com', '085943411028', 'Member', NULL, '$2y$12$/rcnxqejaJpC838DgwJneebtyeb495fgQ81RpubmWcjxA6v1i8MX6', NULL, '2025-09-16 10:43:00', '2025-09-16 10:43:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (33, 'Fina Thalia Rerung', 'Laki laki', 'tharei257@gmail.com', '082250563984', 'Member', NULL, '$2y$12$FjHlFwUbBxv4R0AeIHKYqOxu0CccK3vwdm2WZKC1SEL9VY1eXyHq6', NULL, '2025-09-10 08:06:00', '2025-09-10 08:06:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (34, 'Yosef Andrian Handita', 'Laki laki', 'Yosepandrian300@gmail.com', '085750331867', 'Member', NULL, '$2y$12$qySs7KFNwXstOPbaMdrdFuTMcizJQ1RhxvDVb/lLYc9w5yovYi6pi', NULL, '2025-10-04 12:10:00', '2025-10-04 12:10:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (35, 'Ezra Amarya Aipassa', 'Laki laki', 'ezramrya@gmail.com', '082153149738', 'Member', NULL, '$2y$12$yPRE8nd861k/OWRNod84TOIuU7asth/bnOdb8pxyaFrV9650Pf.JC', NULL, '2025-10-14 15:05:00', '2025-10-14 15:05:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (36, 'Agam Suteja', 'Laki laki', 'agamsuteja98@gmail.com', '08992885301', 'Member', NULL, '$2y$12$NoGMEBU5jSdEIquITvr3meVAVlPmEKLbudVY0SN9SSZlXCLvctzee', NULL, '2025-10-03 14:53:00', '2025-10-03 14:53:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (37, 'Anthony', 'Laki laki', 'kuro60954@gmail.com', '085135728772', 'Member', NULL, '$2y$12$5vR.Lqwm.yJgo7vEqIDFA.rb8hfLKjCuR/6dHKY7nYL8qGbNhf.ki', NULL, '2025-10-19 09:00:00', '2025-10-19 09:00:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (38, 'Tegar Kristian Ompu Sunggu Aritonang', 'Laki laki', 'tegarompusunggu@gmail.com', '085371881264', 'Member', NULL, '$2y$12$GONXA5OczT96SVKo7AJp8.RF6jflegkUIP6Y5Rko9mPlSTunY6Mpq', NULL, '2025-10-23 11:12:00', '2025-10-23 11:12:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (39, 'Ellen Karolina Sirait', 'Laki laki', 'sinagareynaldo74@gmail.com', '085652164061', 'Member', NULL, '$2y$12$BVt8UjgPw1/di2FP1.SKmeNkfKd0cJSrz7n.BqbOOl7K7tZGFxcO2', NULL, '2025-09-15 18:39:00', '2025-09-15 18:39:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (40, 'Aida', 'Laki laki', 'aidaling6548@gmail.com', '089654395771', 'Member', NULL, '$2y$12$82Ag99ovnBiR9Bk.9tAs7uCnj.SNfNMvxQVpLZnaPk//C8l9oOh/u', NULL, '2025-09-20 15:35:00', '2025-09-20 15:35:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (41, 'Juliana Panjaitan', 'Laki laki', 'julianapanjaitanvivo@gmail.com', '08973925219', 'Member', NULL, '$2y$12$A371IQR0f33nj//4jXqZq.oJQSuaqAAnAEybluEcSebXze4Sz9D.6', NULL, '2025-09-20 18:41:00', '2025-09-20 18:41:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (42, 'Gyanriza Satya Pradhika', 'Laki laki', 'gyanriza.satya@gmail.com', '082251067729', 'Member', NULL, '$2y$12$WTFdrffBR9A2Mc6YDjCY4e/0Yb36VWGravjFBbn10mL0znxdash5S', NULL, '2025-10-17 19:12:00', '2025-10-17 19:12:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (43, 'Libel Ovie Octovinie', 'Laki laki', 'Luphzvie@gmail.com', '082277123789', 'Member', NULL, '$2y$12$jN8eFgsF1rfpGrTlfh66v.YQXrpc9wO2eR4xd9UhfHAciRqTd8Ff.', NULL, '2025-10-25 17:40:00', '2025-10-25 17:40:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (44, 'Febryanto', 'Laki laki', 'Megajayamotor168@gmail.com', '085247832777', 'Member', NULL, '$2y$12$X/UbLXbykd8jKaIsWWCBVOFywBvcfQiret1QjntFdsMTSD4uhjV3u', NULL, '2025-10-21 10:55:00', '2025-10-21 10:55:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (45, 'Beti Wisma Mulia', 'Laki laki', 'muliawisma7@gmail.com', '082372164450', 'Member', NULL, '$2y$12$9rqP3AHzKZeNgN1B4JAfguBQ9dbbRI0u0bMAikaalU3Gs6Z6e7fhC', NULL, '2025-10-01 11:25:00', '2025-10-01 11:25:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (46, 'Martin Mikael Evan Tampubolon', 'Laki laki', 'martintampubolon19@gmail.com', '085752728334', 'Member', NULL, '$2y$12$v.T96mR5CN7wBA5hdJ7B1en1hDdf8DIBmRprxeUji9hnOPmg1AC6e', NULL, '2025-09-20 09:59:00', '2025-09-20 09:59:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (47, 'Renta Raya Sitinjak', 'Laki laki', 'rentarsitinjak25@gmail.com', '081260795154', 'Member', NULL, '$2y$12$jPLqL/cW58mvwZR2h/2P9u27vX6w.3KCnSBrqn/opA4s/XFvmAKYS', NULL, '2025-10-23 19:57:00', '2025-10-23 19:57:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (48, 'Diminda Ela Sri Ertina Br Ginting', 'Laki laki', 'dimindaginting@gmail.com', '081269136891', 'Member', NULL, '$2y$12$3GZX2tTyEY/ZTZ7m5tWhCuADZNcinsfl9s3U/w0M6KfNNcAbpp0eu', NULL, '2025-10-02 20:53:00', '2025-10-02 20:53:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (49, 'TIURMA SINAGA', 'Laki laki', 'tiurdelinasinaga@gmail.com', '082149000188', 'Member', NULL, '$2y$12$24YL85XuYRkM3EkAZ5oTueanFDRzTx7Ymshvp/PITbCoJVHRiSFd.', NULL, '2025-10-18 11:59:00', '2025-10-18 11:59:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (50, 'MH. Simbolon', 'Laki laki', 'simbolonvilla@gmail.com', '08125784520', 'Member', NULL, '$2y$12$orz7kq5fBNLn0OOvPCUfoe3AiqJrdTfpDcSaI4TLGLvynx4v67VJK', NULL, '2025-09-25 16:25:00', '2025-09-25 16:25:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (51, 'Sepni Epiensus Kalnus', 'Laki laki', 'adarupa308@gmail.com', '085845166117', 'Member', NULL, '$2y$12$HQIasFmEVwbDCniseiGCAeXTcH3J39qDpaJHxQnckBULJYW4eP2D2', NULL, '2025-10-04 20:28:00', '2025-10-04 20:28:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (52, 'Devi Ayu Ellya Rizky', 'Laki laki', 'devirizky96@guru.sd.belajar.id', '089509623747', 'Member', NULL, '$2y$12$HobYmlUl4Yi1ClF0yfYyc.keJFcuFmcJMRbN9H/pZm6xrBl6i7qXu', NULL, '2025-10-01 20:31:00', '2025-10-01 20:31:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (53, 'Hendrawati Elokvitry', 'Laki laki', 'elokvitry34@gmail.com', '08152052360', 'Member', NULL, '$2y$12$R9qb9W3fDiTnN8rTkl/qdeY4JPj2M2YiFKTzTtLAGs2KDT8.n5QHW', NULL, '2025-09-18 19:26:00', '2025-09-18 19:26:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (54, 'Febriani Sisilia Indri', 'Laki laki', 'febrianisisiliaa28@gmail.com', '082358960102', 'Member', NULL, '$2y$12$0YAvMYixsJbAIE676GtBiOoWSlFHjkCKOdLliETWhvf8tgkYyoXum', NULL, '2025-09-27 10:42:00', '2025-09-27 10:42:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (55, 'Hotlia Hutabarat', 'Laki laki', 'liahurabarat13@gmail.com', '082253870818', 'Member', NULL, '$2y$12$rZy7wFg6nohw9TfBmal.POUvrhY51a/c3F53NDnMPtZktKNmWL1OG', NULL, '2025-09-01 18:41:00', '2025-09-01 18:41:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (56, 'Hotlia Hutabarat', 'Laki laki', 'hotliahutabarat@gmail.com', '082253870818', 'Member', NULL, '$2y$12$6/dZVHShJCgfxeCls9p0z.bW8RAIqk8LY8kVklQVTt15XPDCyiegi', NULL, '2025-10-04 11:31:00', '2025-10-04 11:31:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (57, 'Rita Megawati Panjaitan', 'Laki laki', 'gritapanjaitan@gmail.com', '085753633797', 'Member', NULL, '$2y$12$FXHkoyrHzd2aYqOnvUlagOPMfwwuGWggezKHhUzZNyWWzb9FZEhGG', NULL, '2025-09-04 17:17:00', '2025-09-04 17:17:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (58, 'Sumiati Manik', 'Laki laki', 'sumiatimanik79@gmail.com', '087755047337', 'Member', NULL, '$2y$12$ZD.Fr4j0cfcetfaBw6zLF.iobE.Zzvqng3Waiz.IwSKcHn65Hf122', NULL, '2025-09-18 10:33:00', '2025-09-18 10:33:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (59, 'Sri Widayati', 'Laki laki', 'sriwidayati501@gmail.com', '08994316825', 'Member', NULL, '$2y$12$M4QAjxTpGIhjiJ/h1QaFIOjntN.5oi4tkbenFYWrdxEc9dx2X07Fm', NULL, '2025-10-26 16:19:00', '2025-10-26 16:19:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (60, 'Yuda Jerry Rajagukguk', 'Laki laki', 'aritonang92rg@gmail.com', '082350688464', 'Member', NULL, '$2y$12$hYAbtuF3noehVHHMIdec4.Y7UWRrZrA5qNYklgRrOxOwOhpb7pViO', NULL, '2025-10-16 19:57:00', '2025-10-16 19:57:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (61, 'MH Simbolon', 'Laki laki', 'simbolonvillla@gmail.com', '08215784520', 'Member', NULL, '$2y$12$UaNhVsvWzPiYqwzuF/Ezjey6pXaF2l1RfPu.ziyxM.BoQhb5baNBS', NULL, '2025-09-21 16:05:00', '2025-09-21 16:05:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (62, 'Ruben Natanael', 'Laki laki', 'rubenzon8@gmail.com', '082352634520', 'Member', NULL, '$2y$12$2HweYXnZAh/jwCE7ubgZRe5QNZYSW..1L3TKmS0X2CgCZ.SSRmmem', NULL, '2025-09-06 12:26:00', '2025-09-06 12:26:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (63, 'April Silla', 'Laki laki', 'aprilaprili0712@gmail.com', '085705562885', 'Member', NULL, '$2y$12$4iLihtu/btSX75A8rCqHOewqWPCfmXw3dxlAvP.zs/v4Jd.ZmY9y6', NULL, '2025-09-22 14:55:00', '2025-09-22 14:55:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (64, 'Agung bachtiar', 'Laki laki', 'agungbachtiar.jpn@gmail.com', '086787266122', 'Member', NULL, '$2y$12$CGZlGECe61dfhyo1jsuTZOtOkckOCInj6vFrtyn2mgKHGe1DfwmA6', NULL, '2025-10-08 17:27:00', '2025-10-08 17:27:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (65, 'Laura Yuni Kartika', 'Laki laki', 'yunilaura25@gmail.com', '085751728662', 'Member', NULL, '$2y$12$mdm09K8RCg2HIjmjZHS/7eTzLty9.XCGG7BFvWIRpCriIkU/BMv1G', NULL, '2025-09-04 15:58:00', '2025-09-04 15:58:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (66, 'zukri', 'Laki laki', 'zukrizack008@gmail.com', '081298853639', 'Member', NULL, '$2y$12$BwJLuSEE1UqKLOaB6K7vnOxsvHLs01AHZKPmnEP19Izr11dWpOffG', NULL, '2025-09-09 11:36:00', '2025-09-09 11:36:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (67, 'Shane Darren Gevariel Tampi', 'Laki laki', 'shanedarren77@gmail.com', '0812000111222', 'Member', NULL, '$2y$12$ah0I2kfHyjYiualzqkjEZenuOQwA66wmLH2r7/pfruQ1kJDLTW/S.', NULL, '2025-10-11 11:45:00', '2025-10-11 11:45:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (68, 'nextstep', 'Laki laki', 'cp.escnextstep@gmail.com', '081298853639', 'Member', NULL, '$2y$12$xTg8st2IjEzLBgL2PRSnSep2PEqYleRtgK0XyZSRguhh/RBuRmj/a', NULL, '2025-09-28 13:46:00', '2025-09-28 13:46:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (69, 'Jeremiah Pujianto', 'Laki laki', 'jeremiahpuji@gmail.com', '081345018272', 'Member', NULL, '$2y$12$LwvGqYDkXWq.N9ZfF.A7quhME4FUxFC4huJmkrf8zQGa2tEK0McKa', NULL, '2025-09-07 14:16:00', '2025-09-07 14:16:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (70, 'escequip', 'Laki laki', 'escequip@gmail.com', '081298853639', 'Member', NULL, '$2y$12$s2vy88Ud9DRrNrhbz9sfhe2Fn49ehhwsjLWxeETmFdCebHcDmpWSK', NULL, '2025-10-28 16:16:00', '2025-10-28 16:16:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (71, 'Imelda Blegur', 'Perempuan', 'imeldablegs@gmail.com', '085245767038', 'Member', NULL, '$2y$12$41trsusqRShCc7SSPH5LUOoNgSQzxudq4UJ1IV5vVwJS6G61szUTu', NULL, '2025-09-05 13:16:00', '2025-09-05 13:16:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (72, 'TJE SONG KIANG', 'Laki laki', 'freddysonk78@gmail.com', '085849109541', 'Member', NULL, '$2y$12$maZWzNmfqjT7gugdZpeA9u3e2/EVLDEeLKd.yS6S5j22my.nRShaK', NULL, '2025-10-03 20:56:00', '2025-10-03 20:56:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (73, 'Purnama Sianturi', 'Laki laki', 'purnamasianturi@gmail.com', '081256385135', 'Member', NULL, '$2y$12$UxGKDsp8JHWKipM6JNnExOYkmzI66PFpBgf.Ntxt88JIrW8i9fmaC', NULL, '2025-10-12 19:47:00', '2025-10-12 19:47:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (74, 'Vellen', 'Laki laki', 'vellenvel812@gmail.com', '087755746808', 'Member', NULL, '$2y$12$RQLHzRSH2zVudsoACKYUm.G4uCs4SqVGVjJWBOmfUCCWc8knzBK/2', NULL, '2025-09-16 18:23:00', '2025-09-16 18:23:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (75, 'masnah', 'Laki laki', 'masnaheesscc80@gmail.com', '082213319410', 'Member', NULL, '$2y$12$9JcR4wAq/WVTwNjQTy/pQuR/2h81/AoWPUI4nM1hLoVLvj2SM.35i', NULL, '2025-09-16 18:28:00', '2025-09-16 18:28:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (76, 'masnah hayati', 'Laki laki', 'masnahhayati@gmail.com', '082213319410', 'Member', NULL, '$2y$12$ITBdIPBr1sHdiXAwmtyseuZz3pDuxeNIZJ3bAuxGfxAjWTMdJQplK', NULL, '2025-09-14 09:47:00', '2025-09-14 09:47:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (77, 'Mardoyo', 'Laki laki', 'mardoyo@gmail.com', '082255338103', 'Member', NULL, '$2y$12$iXY8uoPjXHkrxtMsbHaayOsvCbRUEM389JUxyBxDS/QZDBhCb9m9y', NULL, '2025-10-21 14:39:00', '2025-10-21 14:39:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (78, 'Makayla Shekinah Tampi', 'Laki laki', 'makayla.tampi77@gmail.com', '085234786656', 'Member', NULL, '$2y$12$Gcv5uQrXPw7qlMBReprdde3dGuUoqA88lXFEc1T/onO7Q8F4U/3sy', NULL, '2025-10-15 19:11:00', '2025-10-15 19:11:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (79, 'Regina Anastasia Kacaribu', 'Laki laki', 'regina.anastasia19@gmail.com', '082351999403', 'Member', NULL, '$2y$12$/JjDKaDoF5Xiu7DDH7CnSOBKn060DQJC2A4duuuhJ0zCFLvggkOv.', NULL, '2025-10-15 08:05:00', '2025-10-15 08:05:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (80, 'VERGIONO', 'Laki laki', 'vergionovergy@gmail.com', '083822589786', 'Member', NULL, '$2y$12$v.J3tn9W6PprtWI8/yz6P.TkpupvvQ5UfA0t.B0dz45ji1JGtul1y', NULL, '2025-10-25 08:28:00', '2025-10-25 08:28:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (81, 'Ellyatun Tarigan', 'Perempuan', 'ellytarigan22@gmail.com', '081345177226', 'Member', NULL, '$2y$12$I.GgmI33H/ifxtTjh/.uROXrRgeaQ0N81ycBk0tWuwN5EtUZ0W5y2', NULL, '2025-09-10 09:28:00', '2025-09-10 09:28:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (82, 'Ruth Widya Sarah Silaban', 'Laki laki', 'ruthptk99@gmail.com', '089502463511', 'Member', NULL, '$2y$12$Y.FTb1DklHk3OrgAU4rEqOYt.F5Vng2Emfc6jNoaxTmvq9wgcCrJW', NULL, '2025-10-23 09:18:00', '2025-10-23 09:18:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (83, 'rachel', 'Laki laki', 'rachel@gmail.com', '085183023883', 'Member', NULL, '$2y$12$KVrk3cNDs4ojhHm0wgISauNL0QydWqnvF2gxAy53gelRTpIs7cy4.', NULL, '2025-09-16 19:53:00', '2025-09-16 19:53:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (84, 'max tuhumury', 'Laki laki', 'maxtuhumury79@gmail.com', '085248054400', 'Member', NULL, '$2y$12$bKKItP8z85m1t53wjZTKUe.EDTvUty7tSYn31hSGz5PPNcskKflKW', NULL, '2025-09-06 20:36:00', '2025-09-06 20:36:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (85, 'Hendry', 'Laki laki', 'smartbrain1996@gmail.com', '089517300753', 'Member', NULL, '$2y$12$cfsiwwFGafZl5F0Qx8DoUOTsHSrmVt0WW0N3y1ezc82PUmE6baRfm', NULL, '2025-10-24 13:09:00', '2025-10-24 13:09:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (86, 'Rizki wulandari', 'Laki laki', 'rzkywdr@gmail.com', '082351573688', 'Member', NULL, '$2y$12$SzEnqhzDdaz.quU65ogBke2B5Jv8EToDmYeWTXziuHvr16JeHFQmO', NULL, '2025-10-28 09:38:00', '2025-10-28 09:38:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (87, 'Kent Setiawan Jonathan', 'Laki laki', 'kentjonathan28@gmail.com', '087829607099', 'Member', NULL, '$2y$12$W7QSLqV/8rOkac3kxX9kcubvNiLuqYxyKkk6PsxgxRSQ1VpAFxI/.', NULL, '2025-09-07 18:30:00', '2025-09-07 18:30:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (88, 'yopi', 'Laki laki', 'yopi@gmail.com', '081234567890', 'Member', NULL, '$2y$12$CBpXrNJF./0MM9a8.fpBQO8XP3NhVYPHXyyrU7Z.KtC6qnT8mD6Ry', NULL, '2025-09-11 19:20:00', '2025-09-11 19:20:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (89, 'ellyatun', 'Laki laki', 'ellyatun@gmail.com', '081234567890', 'Member', NULL, '$2y$12$O0/jUc.kfd1QG/2xb5VSTOjL1NslAtQO/fl7p3mSi0Y6MzvuecYG2', NULL, '2025-10-09 18:01:00', '2025-10-09 18:01:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (90, 'Jeniffer', 'Laki laki', 'jeniffer.gracellia@gmail.com', '089513035385', 'Member', NULL, '$2y$12$lGQEqL1uzminGr.OFrxfx.87CRkOPDQ2Jyx.cvQsGK2wSx6oLRCam', NULL, '2025-10-25 13:35:00', '2025-10-25 13:35:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (91, 'Vivi Susanti', 'Laki laki', 'viviester875@gmail.com', '081253580116', 'Member', NULL, '$2y$12$mQNgqgsnreuGhwlWtJog9.dCzCmDkpgAQIsTalm1r7yZLXIJ3ZC9q', NULL, '2025-10-08 14:08:00', '2025-10-08 14:08:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (92, 'Trisye Icha', 'Laki laki', 'ica22ptk@gmail.com', '081350079351', 'Member', NULL, '$2y$12$KriATroIfBhk9eVKFkIbgeaPd4IIQ7/ryPEswaG2a8QBtC5XerOuu', NULL, '2025-09-17 15:52:00', '2025-09-17 15:52:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (93, 'Ariel Wandi', 'Laki laki', 'wandiaril911@gmail.com', '085251424923', 'Member', NULL, '$2y$12$jC/XorhKFIfJZaqSi.oq1.W4VqxCP5oNHNgRCLJf20kUn0aktIrfC', NULL, '2025-10-16 16:14:00', '2025-10-16 16:14:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (94, 'wendi', 'Laki laki', 'Wendi090807@gmail.com', '085794397036', 'Member', NULL, '$2y$12$ZqS.NS8snGCSGAt1yMm0Aubo8YK51HL2fikCIkFQYc7NCCzt8CyaS', NULL, '2025-10-04 15:37:00', '2025-10-04 15:37:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (95, 'Natalia Rosi Heavenlim', 'Laki laki', 'nataliarosi62@gmail.com', '085825228929', 'Member', NULL, '$2y$12$Y9qmpana3Cd5Ot4Rik41FOoJp7iVSPcJzW4PIbBrDzxWbRP5zGk/y', NULL, '2025-09-19 17:44:00', '2025-09-19 17:44:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (96, 'Miki', 'Laki laki', 'mikiabin92@gmail.com', '085828516671', 'Member', NULL, '$2y$12$SohK.vkQ3aswfdYzWk33rORSyTtX4JgGKrH.r.xwMNINt3lsE3LSi', NULL, '2025-10-26 11:09:00', '2025-10-26 11:09:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (97, 'Tabhita', 'Laki laki', 'tabhitaesc@gmail.com', '082155491569', 'Member', NULL, '$2y$12$Tgp0XJMv.jW/8YgggyRRc.DbXszA6rl93ZRUxu6tZBiQM.fzLvTv6', NULL, '2025-10-17 17:02:00', '2025-10-17 17:02:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (98, 'Vita', 'Laki laki', 'otsuka7yu@gmail.com', '081256191979', 'Member', NULL, '$2y$12$zbTmE2ZkdWfMkRRrR5BQf.yLJ3KfN3MULFVe0P.ZjgwhgK6lBKP2e', NULL, '2025-10-08 12:41:00', '2025-10-08 12:41:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (99, 'Rafael Nathanael Kacaribu', 'Laki laki', 'rafaelkacaribu73@gmail.com', '081345291733', 'Member', NULL, '$2y$12$.x/sqXlVBxJl0j5nZWadO.fOfHD2isJ8YMiAVxIsMGJWEorFAN6/S', NULL, '2025-09-18 15:47:00', '2025-09-18 15:47:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (100, 'Nindya Zalukhu', 'Laki laki', 'nindyzal3@gmail.com', '085346507371', 'Member', NULL, '$2y$12$1cApHHRRTpFWwHdVHOvF8.xBrJzozyzoJVPnwuC1pOGZTGngD3ms.', NULL, '2025-10-23 12:39:00', '2025-10-23 12:39:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (101, 'Imelda Blegur', 'Perempuan', 'imeldablegur5@gmail.com', '085245767038', 'Member', NULL, '$2y$12$F8.cY1nCJGfvMZZ3eZ.lL.IaKR5HlgrHfc1peI07nMTW7WWH1m1Gq', NULL, '2025-09-14 16:16:00', '2025-09-14 16:16:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (102, 'Stevanus Tampi', 'Laki laki', 'stevanustampi7@gmail.com', '085234786655', 'Member', NULL, '$2y$12$g30wUE46TqeI3JIq1L1ZC.FmAbkbPHv1byOwWqhMp7ryTqIf3UrcC', NULL, '2025-09-06 18:07:00', '2025-09-06 18:07:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (103, 'Junifer lavigni', 'Laki laki', 'jlavingni@gmail.com', '089506034091', 'Member', NULL, '$2y$12$JT1N0cx7WKYQ/DHxGIK8I.kUKNwlDW5aYEATtXIYaG8SLlb3iRXZ2', NULL, '2025-09-19 11:42:00', '2025-09-19 11:42:00');
INSERT INTO `users` (`id`, `nama_lengkap`, `jenis_kelamin`, `email`, `no_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (104, 'Riris marinduk br hutabarat', 'Laki laki', 'ririsptk2024@gmail.com', '082154612607', 'Member', NULL, '$2y$12$KR8t4oCMDVkpYAUpzHHx4.I.rWM1E0VeQ9oHT4ebqamF31fcMIvfe', NULL, '2025-10-11 15:46:00', '2025-10-11 15:46:00');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
