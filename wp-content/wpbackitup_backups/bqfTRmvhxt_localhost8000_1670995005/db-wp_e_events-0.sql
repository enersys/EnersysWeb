-- ------------------------------------------------------
-- ------------------------------------------------------
--
-- WPBackItUp Database Export 
--
-- Created: 2022/12/14 on 05:18
--
-- Database : wordpress_database
--
-- Backup   Table  : wp_e_events
-- Snapshot Table  : 1670995005_e_events
--
-- SQL    : SELECT * FROM wp_e_events LIMIT 0,10000
-- Offset : 0
-- Rows   : 15
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
-- Table structure for table `1670995005_e_events`
--
DROP TABLE  IF EXISTS `1670995005_e_events`;
CREATE TABLE `1670995005_e_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_data` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



--
-- Data for table `wp_e_events`
-- Number of rows: 15
--
INSERT INTO `1670995005_e_events` VALUES 
(1,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"account\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:50:34.064-06:30\"}','2022-12-13 19:20:34'),
 (2,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"hello\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:51:09.178-06:30\"}','2022-12-13 19:21:09'),
 (3,'{\"event\":\"skip\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"account\\\"}\",\"ts\":\"2022-12-13T12:51:09.158-06:30\"}','2022-12-13 19:21:09'),
 (4,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"siteName\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:51:13.108-06:30\"}','2022-12-13 19:21:13'),
 (5,'{\"event\":\"skip\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"hello\\\"}\",\"ts\":\"2022-12-13T12:51:13.091-06:30\"}','2022-12-13 19:21:13'),
 (6,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"siteLogo\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:51:16.702-06:30\"}','2022-12-13 12:51:17'),
 (7,'{\"event\":\"skip\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"siteName\\\"}\",\"ts\":\"2022-12-13T12:51:16.685-06:30\"}','2022-12-13 12:51:17'),
 (8,'{\"event\":\"skip\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"siteLogo\\\"}\",\"ts\":\"2022-12-13T12:51:20.232-06:30\"}','2022-12-13 19:21:20'),
 (9,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"goodToGo\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:51:20.256-06:30\"}','2022-12-13 19:21:20'),
 (10,'{\"event\":\"skip\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"goodToGo\\\"}\",\"ts\":\"2022-12-13T12:51:22.179-06:30\"}','2022-12-13 19:21:22'),
 (11,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"goodToGo\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:53:36.772-06:30\"}','2022-12-13 12:53:37'),
 (12,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"siteLogo\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:53:38.439-06:30\"}','2022-12-13 19:23:38'),
 (13,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"siteName\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:53:39.096-06:30\"}','2022-12-13 19:23:39'),
 (14,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"hello\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:53:39.706-06:30\"}','2022-12-13 12:53:40'),
 (15,'{\"event\":\"modal load\",\"version\":\"\",\"details\":\"{\\\"placement\\\":\\\"Onboarding wizard\\\",\\\"step\\\":\\\"account\\\",\\\"user_state\\\":\\\"anon\\\"}\",\"ts\":\"2022-12-13T12:53:40.343-06:30\"}','2022-12-13 19:23:40');

SET FOREIGN_KEY_CHECKS = 1 ; 
COMMIT ; 
SET AUTOCOMMIT = 1 ; 
