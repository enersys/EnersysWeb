-- ------------------------------------------------------
-- ------------------------------------------------------
--
-- WPBackItUp Database Export 
--
-- Created: 2022/12/14 on 05:19
--
-- Database : wordpress_database
--
-- Backup   Table  : wp_termmeta
-- Snapshot Table  : 1670995005_termmeta
--
-- SQL    : SELECT * FROM wp_termmeta LIMIT 0,10000
-- Offset : 0
-- Rows   : 0
-- ------------------------------------------------------
-- ------------------------------------------------------
SET AUTOCOMMIT = 0 ;
SET FOREIGN_KEY_CHECKS=0 ;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET SESSION sql_mode = '' */;

--
-- Table structure for table `1670995005_termmeta`
--
DROP TABLE  IF EXISTS `1670995005_termmeta`;
CREATE TABLE `1670995005_termmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



--
-- Data for table `wp_termmeta`
-- Number of rows: 0
--
--
-- Data for table `wp_termmeta`
-- Number of rows: 0
--
SET FOREIGN_KEY_CHECKS = 1 ; 
COMMIT ; 
SET AUTOCOMMIT = 1 ; 
