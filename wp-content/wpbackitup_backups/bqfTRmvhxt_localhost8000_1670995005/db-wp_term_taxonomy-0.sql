-- ------------------------------------------------------
-- ------------------------------------------------------
--
-- WPBackItUp Database Export 
--
-- Created: 2022/12/14 on 05:18
--
-- Database : wordpress_database
--
-- Backup   Table  : wp_term_taxonomy
-- Snapshot Table  : 1670995005_term_taxonomy
--
-- SQL    : SELECT * FROM wp_term_taxonomy LIMIT 0,10000
-- Offset : 0
-- Rows   : 5
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
-- Table structure for table `1670995005_term_taxonomy`
--
DROP TABLE  IF EXISTS `1670995005_term_taxonomy`;
CREATE TABLE `1670995005_term_taxonomy` (
  `term_taxonomy_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint unsigned NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



--
-- Data for table `wp_term_taxonomy`
-- Number of rows: 5
--
INSERT INTO `1670995005_term_taxonomy` VALUES 
(1,1,'category','',0,3),
 (2,2,'wp_theme','',0,7),
 (3,3,'wp_template_part_area','',0,1),
 (4,4,'wp_template_part_area','',0,3),
 (5,5,'wp_template_part_area','',0,1);

SET FOREIGN_KEY_CHECKS = 1 ; 
COMMIT ; 
SET AUTOCOMMIT = 1 ; 
