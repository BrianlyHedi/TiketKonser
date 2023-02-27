/*
 Navicat Premium Data Transfer

 Source Server         : SQL Local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : ticket

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 27/02/2023 15:42:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, 'Tiket Konser', 'tiket-konser', '2023-02-26 21:39:02', '2023-02-26 21:39:02');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2020_11_16_131654_create_category_table', 1);
INSERT INTO `migrations` VALUES (3, '2020_11_17_004604_create_transportasi_table', 1);
INSERT INTO `migrations` VALUES (4, '2020_11_18_081507_create_rute_table', 1);
INSERT INTO `migrations` VALUES (5, '2020_11_20_095338_create_pemesanan_table', 1);

-- ----------------------------
-- Table structure for pemesanan
-- ----------------------------
DROP TABLE IF EXISTS `pemesanan`;
CREATE TABLE `pemesanan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kursi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total` int NOT NULL,
  `status` enum('Belum Terverifikasi','Sudah Terverifikasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Terverifikasi',
  `tempat_id` bigint UNSIGNED NOT NULL,
  `pemesan_id` bigint UNSIGNED NOT NULL,
  `petugas_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `waktu` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pemesanan_rute_id_foreign`(`tempat_id` ASC) USING BTREE,
  INDEX `pemesanan_penumpang_id_foreign`(`pemesan_id` ASC) USING BTREE,
  INDEX `pemesanan_petugas_id_foreign`(`petugas_id` ASC) USING BTREE,
  CONSTRAINT `pemesanan_penumpang_id_foreign` FOREIGN KEY (`pemesan_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pemesanan_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pemesanan_rute_id_foreign` FOREIGN KEY (`tempat_id`) REFERENCES `tempat` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pemesanan
-- ----------------------------
INSERT INTO `pemesanan` VALUES (13, '4GRBVZC', 'K2', 100000, 'Sudah Terverifikasi', 1, 8, 1, '2023-02-27 01:15:16', '2023-02-27 01:19:30', '2023-02-08 11:41:00');
INSERT INTO `pemesanan` VALUES (14, '2ELQAF5', 'K17', 100000, 'Sudah Terverifikasi', 1, 8, 1, '2023-02-27 01:18:20', '2023-02-27 01:19:21', '2023-02-10 11:41:00');

-- ----------------------------
-- Table structure for tempat
-- ----------------------------
DROP TABLE IF EXISTS `tempat`;
CREATE TABLE `tempat`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `jam` time NOT NULL,
  `tiket_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rute_transportasi_id_foreign`(`tiket_id` ASC) USING BTREE,
  CONSTRAINT `rute_transportasi_id_foreign` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tempat
-- ----------------------------
INSERT INTO `tempat` VALUES (1, 'Bandung', 100000, '11:41:00', 1, '2023-02-26 21:39:34', '2023-02-26 21:39:34');
INSERT INTO `tempat` VALUES (4, 'Cimahi', 100000, '16:46:00', 4, '2023-02-27 00:46:39', '2023-02-27 00:46:39');
INSERT INTO `tempat` VALUES (5, 'Bandung', 100000, '15:01:00', 4, '2023-02-27 01:01:36', '2023-02-27 01:01:36');

-- ----------------------------
-- Table structure for tiket
-- ----------------------------
DROP TABLE IF EXISTS `tiket`;
CREATE TABLE `tiket`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transportasi_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `transportasi_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tiket
-- ----------------------------
INSERT INTO `tiket` VALUES (1, 'Lagu Lagu Fest', '123', 1000, 1, '2023-02-26 21:39:15', '2023-02-27 00:15:24');
INSERT INTO `tiket` VALUES (4, 'Halo Halo Fest', '888', 100, 1, '2023-02-27 00:45:41', '2023-02-27 00:45:41');
INSERT INTO `tiket` VALUES (5, 'HAlo', '2312', 1, 1, '2023-02-27 01:00:12', '2023-02-27 01:00:12');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('Admin','Petugas','Penumpang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'admin', '$2y$10$sueSYBQbAI0Lyn6Kw0x4/uZcll44hS9T1CX7lvE98mGZFxHpeljH6', 'Admin', '2021-01-11 20:49:02', '2023-02-27 00:08:50');
INSERT INTO `users` VALUES (6, 'Brianly', 'hai', '$2y$10$8g0dv5AhejhaZt5mPE1BkedCHLwy0cJqmXYVZnSpMIa9LrNF6kCA2', 'Penumpang', '2023-02-26 21:10:01', '2023-02-27 00:16:37');
INSERT INTO `users` VALUES (7, 'Brianly', 'brianly', '$2y$10$hryjbIDa9ThM46KFswkJj.N1spDkZsMWkjqdxcNDK77Vc8jh.C.sa', 'Penumpang', '2023-02-27 00:18:16', '2023-02-27 00:18:16');
INSERT INTO `users` VALUES (8, 'Deden', 'deden', '$2y$10$godsVUodCo2GP3FcVhd97eXOt7fWFRSOkawZFUkCllUcRV5IML0ZS', 'Penumpang', '2023-02-27 00:55:12', '2023-02-27 00:55:12');
INSERT INTO `users` VALUES (9, 'Petugas', 'Petugas', '$2y$10$kZ8CD6k5kx0RVSc56AAd/uXb9R8t.oqk4X92keYwgAGtLeCGCI9Aa', 'Petugas', '2023-02-27 01:19:57', '2023-02-27 01:19:57');

SET FOREIGN_KEY_CHECKS = 1;
