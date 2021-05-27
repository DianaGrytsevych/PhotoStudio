/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100313
 Source Host           : localhost:3306
 Source Schema         : photo

 Target Server Type    : MySQL
 Target Server Version : 100313
 File Encoding         : 65001

 Date: 26/05/2021 15:36:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for books
-- ----------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `service_id` int(11) NOT NULL,
  `photographer_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of books
-- ----------------------------
INSERT INTO `books` VALUES (15, 'Cus', 'Customer', '056565656565', 'Test 1', 1, 9);
INSERT INTO `books` VALUES (16, 'Cus', 'Customer', '056565656565', 'Test 2', 2, NULL);
INSERT INTO `books` VALUES (17, 'Cus', 'Customer', '056565656565', 'Test 3', 3, 10);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (3, 'service-list', 3);
INSERT INTO `permissions` VALUES (4, 'service-edit', 3);
INSERT INTO `permissions` VALUES (5, 'order-list', 2);
INSERT INTO `permissions` VALUES (6, 'order-list', 3);
INSERT INTO `permissions` VALUES (7, 'order-edit', 3);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Користувач');
INSERT INTO `roles` VALUES (2, 'Фотограф');
INSERT INTO `roles` VALUES (3, 'Адміністратор');

-- ----------------------------
-- Table structure for services
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services
-- ----------------------------
INSERT INTO `services` VALUES (1, 'Винайняти фотографа', 1000.00, 'Винайняти фотографа дял роботи на студії');
INSERT INTO `services` VALUES (2, 'Оренда студії', 2000.00, 'Студія зі всім необхідним обладнанням для фотозйомки');
INSERT INTO `services` VALUES (3, 'Студія + фотограф', 2500.00, 'Винайняти студію і фотографа на час бронювання студії');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT current_timestamp(),
  `role_id` int(11) NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone_number` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '$2y$10$MC6dP90y6J6dKD/dUz6rnewmPIfs7E24r.Jmu3mKfjT1XN/KN.OYK', '2021-05-26 01:30:33', 3, 'admin', 'admin', '0');
INSERT INTO `users` VALUES (9, 'photo@gmail.com', '$2y$10$34l6KMwPHaQHTTUyWv9dbuv2Uu1.jCswr8iLw.R1D6bTGWBdHRz/2', '2021-05-26 10:55:41', 2, 'Peter', 'Parker', 'asdasdas123123123123');
INSERT INTO `users` VALUES (10, 'ph2@gmail.com', '$2y$10$Zaipov.FPl8Rfb9xAX/1xeEsErJS42tu.tVSxwMXsLKfB24B4ZWt6', '2021-05-26 14:25:35', 2, 'Peter2', 'Parker2', '0677781899899');
INSERT INTO `users` VALUES (11, 'customer@gmail.com', '$2y$10$BOVqoG2uM1t2AdOCt40G3e4VPUtI5LPnnweNNrPw1T8T5V9O8nFLy', '2021-05-26 15:28:44', 1, 'Customer', 'Cus', '056565656565');

SET FOREIGN_KEY_CHECKS = 1;
