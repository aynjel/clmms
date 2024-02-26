-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for eval
CREATE DATABASE IF NOT EXISTS `eval` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `eval`;

-- Dumping structure for table eval.academic_list
CREATE TABLE IF NOT EXISTS `academic_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` text COLLATE utf8mb4_general_ci NOT NULL,
  `semester` int NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Start,2=Closed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.class_list
CREATE TABLE IF NOT EXISTS `class_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `curriculum` text COLLATE utf8mb4_general_ci NOT NULL,
  `level` text COLLATE utf8mb4_general_ci NOT NULL,
  `section` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.criteria_list
CREATE TABLE IF NOT EXISTS `criteria_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `criteria` text COLLATE utf8mb4_general_ci NOT NULL,
  `order_by` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.equipment_list
CREATE TABLE IF NOT EXISTS `equipment_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `manufacturer` text COLLATE utf8mb4_general_ci NOT NULL,
  `serial_no` text COLLATE utf8mb4_general_ci NOT NULL,
  `condition` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_to_room` (`room_id`),
  CONSTRAINT `fk_to_room` FOREIGN KEY (`room_id`) REFERENCES `room_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.evaluation_answers
CREATE TABLE IF NOT EXISTS `evaluation_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `evaluation_id` int NOT NULL,
  `question_id` int NOT NULL,
  `rate` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.evaluation_list
CREATE TABLE IF NOT EXISTS `evaluation_list` (
  `evaluation_id` int NOT NULL AUTO_INCREMENT,
  `academic_id` int NOT NULL,
  `class_id` int NOT NULL,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `faculty_id` int NOT NULL,
  `restriction_id` int NOT NULL,
  `date_taken` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`evaluation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.faculty_list
CREATE TABLE IF NOT EXISTS `faculty_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_general_ci,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.faculty_room_list
CREATE TABLE IF NOT EXISTS `faculty_room_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faculty_id` int NOT NULL,
  `room_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_to_room1` (`room_id`),
  KEY `fk_to_faculty1` (`faculty_id`),
  CONSTRAINT `fk_to_faculty1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_to_room1` FOREIGN KEY (`room_id`) REFERENCES `room_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.maintenance_work_requests
CREATE TABLE IF NOT EXISTS `maintenance_work_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.question_list
CREATE TABLE IF NOT EXISTS `question_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `academic_id` int NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `order_by` int NOT NULL,
  `criteria_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.requests
CREATE TABLE IF NOT EXISTS `requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `section_id` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.restriction_list
CREATE TABLE IF NOT EXISTS `restriction_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `academic_id` int NOT NULL,
  `faculty_id` int NOT NULL,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.room_list
CREATE TABLE IF NOT EXISTS `room_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faculty_id` int DEFAULT NULL,
  `room` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `capacity` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_room_to_faculty` (`faculty_id`),
  CONSTRAINT `fk_room_to_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.sections
CREATE TABLE IF NOT EXISTS `sections` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.student_list
CREATE TABLE IF NOT EXISTS `student_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `class_id` int NOT NULL,
  `avatar` text COLLATE utf8mb4_general_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.subject_list
CREATE TABLE IF NOT EXISTS `subject_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.system_settings
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `cover_img` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.tbl_evaluation
CREATE TABLE IF NOT EXISTS `tbl_evaluation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `report_id` int NOT NULL,
  `faculty_id` int DEFAULT NULL,
  `service` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `response` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quality` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `communication` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `experience` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `troubleshooting` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `clean_orderly` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `overall` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `core_services` text COLLATE utf8mb4_general_ci,
  `improvement` text COLLATE utf8mb4_general_ci,
  `status` int NOT NULL DEFAULT '0',
  `f_status` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.tb_data
CREATE TABLE IF NOT EXISTS `tb_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `faculty_id` int DEFAULT NULL,
  `description` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `languages` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '0',
  `f_status` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table eval.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_general_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
