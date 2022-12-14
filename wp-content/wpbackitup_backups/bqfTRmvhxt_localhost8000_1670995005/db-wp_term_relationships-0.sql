-- ------------------------------------------------------
-- ------------------------------------------------------
--
-- WPBackItUp Database Export 
--
-- Created: 2022/12/14 on 05:18
--
-- Database : wordpress_database
--
-- Backup   Table  : wp_term_relationships
-- Snapshot Table  : 1670995005_term_relationships
--
-- SQL    : SELECT * FROM wp_term_relationships LIMIT 0,10000
-- Offset : 0
-- Rows   : 18
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
-- Table structure for table `1670995005_term_relationships`
--
DROP TABLE  IF EXISTS `1670995005_term_relationships`;
CREATE TABLE `1670995005_term_relationships` (
  `object_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



--
-- Data for table `wp_term_relationships`
-- Number of rows: 18
--
INSERT INTO `1670995005_term_relationships` VALUES 
(1,1,0),
 (5,2,0),
 (7,2,0),
 (8,2,0),
 (8,3,0),
 (32,1,0),
 (34,1,0),
 (35,1,0),
 (42,1,0),
 (55,1,0),
 (65,2,0),
 (65,4,0),
 (66,2,0),
 (66,4,0),
 (67,2,0),
 (67,4,0),
 (71,2,0),
 (71,5,0);

SET FOREIGN_KEY_CHECKS = 1 ; 
COMMIT ; 
SET AUTOCOMMIT = 1 ; 
