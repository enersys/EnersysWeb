-- ------------------------------------------------------
-- ------------------------------------------------------
--
-- WPBackItUp Database Export 
--
-- Created: 2022/12/14 on 05:18
--
-- Database : wordpress_database
--
-- Backup   Table  : wp_usermeta
-- Snapshot Table  : 1670995005_usermeta
--
-- SQL    : SELECT * FROM wp_usermeta LIMIT 0,10000
-- Offset : 0
-- Rows   : 22
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
-- Table structure for table `1670995005_usermeta`
--
DROP TABLE  IF EXISTS `1670995005_usermeta`;
CREATE TABLE `1670995005_usermeta` (
  `umeta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;



--
-- Data for table `wp_usermeta`
-- Number of rows: 22
--
INSERT INTO `1670995005_usermeta` VALUES 
(1,1,'nickname','admin'),
 (2,1,'first_name',''),
 (3,1,'last_name',''),
 (4,1,'description',''),
 (5,1,'rich_editing','true'),
 (6,1,'syntax_highlighting','true'),
 (7,1,'comment_shortcuts','false'),
 (8,1,'admin_color','fresh'),
 (9,1,'use_ssl','0'),
 (10,1,'show_admin_bar_front','true'),
 (11,1,'locale',''),
 (12,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),
 (13,1,'wp_user_level','10'),
 (14,1,'dismissed_wp_pointers',''),
 (15,1,'show_welcome_panel','0'),
 (16,1,'session_tokens','a:1:{s:64:\"9961d5c3cca59d11b7efaf78b17c71dff3fc461e44efbc91f47b83e21dfcab13\";a:4:{s:10:\"expiration\";i:1671071047;s:2:\"ip\";s:10:\"172.25.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36\";s:5:\"login\";i:1670898247;}}'),
 (17,1,'wp_user-settings','libraryContent=browse&editor=html'),
 (18,1,'wp_user-settings-time','1670919280'),
 (19,1,'wp_dashboard_quick_press_last_post_id','4'),
 (20,1,'community-events-location','a:1:{s:2:\"ip\";s:10:\"172.25.0.0\";}'),
 (21,1,'wp_persisted_preferences','a:3:{s:14:\"core/edit-site\";a:2:{s:12:\"welcomeGuide\";b:0;s:26:\"isComplementaryAreaVisible\";b:0;}s:9:\"_modified\";s:24:\"2022-12-14T05:14:18.951Z\";s:14:\"core/edit-post\";a:3:{s:26:\"isComplementaryAreaVisible\";b:0;s:12:\"welcomeGuide\";b:0;s:10:\"openPanels\";a:1:{i:0;s:11:\"post-status\";}}}'),
 (22,1,'elementor_introduction','a:1:{s:7:\"exit_to\";b:1;}');

SET FOREIGN_KEY_CHECKS = 1 ; 
COMMIT ; 
SET AUTOCOMMIT = 1 ; 
