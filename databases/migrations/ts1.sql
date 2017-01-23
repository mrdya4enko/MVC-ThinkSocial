-- MySQL dump 10.13  Distrib 5.7.13, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: mydb
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE ts
    DEFAULT CHARACTER SET utf8;

USE ts;

--
-- Temporary view structure for view `admin_list`
--


DROP TABLE IF EXISTS `admin_list`;
/*!50001 DROP VIEW IF EXISTS `admin_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `admin_list` AS SELECT 
 1 AS `first_name`,
 1 AS `name`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
INSERT INTO `albums` (id, name) VALUES (1,'family'),(2,'I'),(3,'friends'),(4,'pets'),(5,'car');
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums_groups`
--

DROP TABLE IF EXISTS `albums_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums_groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `album_id` INT(11) NOT NULL,
  `groups_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_albums_users_albums1_idx` (`album_id`),
  KEY `fk_albums_groups_groups1_idx` (`groups_id`),
  CONSTRAINT `fk_albums_groups_groups1` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_albums_users_albums10` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums_groups`
--

LOCK TABLES `albums_groups` WRITE;
/*!40000 ALTER TABLE `albums_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `albums_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums_photos`
--

DROP TABLE IF EXISTS `albums_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums_photos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `album_id` INT(11) NOT NULL,
  `file_name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(100),
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`album_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_albums_photos_albums1_idx` (`album_id`),
  CONSTRAINT `fk_albums_photos_albums1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums_photos`
--

LOCK TABLES `albums_photos` WRITE;
/*!40000 ALTER TABLE `albums_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `albums_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums_photos_comments`
--

DROP TABLE IF EXISTS `albums_photos_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums_photos_comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `comment_id` INT(11) NOT NULL,
  `albums_photos_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_news_comments_comments1_idx` (`comment_id`),
  KEY `fk_albums_photos_comments_albums_photos1_idx` (`albums_photos_id`),
  CONSTRAINT `fk_albums_photos_comments_albums_photos1` FOREIGN KEY (`albums_photos_id`) REFERENCES `albums_photos` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_news_comments_comments10` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums_photos_comments`
--

LOCK TABLES `albums_photos_comments` WRITE;
/*!40000 ALTER TABLE `albums_photos_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `albums_photos_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums_users`
--

DROP TABLE IF EXISTS `albums_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `album_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_albums_users_users1_idx` (`user_id`),
  KEY `fk_albums_users_albums1_idx` (`album_id`),
  CONSTRAINT `fk_albums_users_albums1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_albums_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums_users`
--

LOCK TABLES `albums_users` WRITE;
/*!40000 ALTER TABLE `albums_users` DISABLE KEYS */;
INSERT INTO `albums_users` (id, user_id, album_id) VALUES (1,1,1),(2,1,3),(3,1,5),(4,2,2),(5,2,4);
/*!40000 ALTER TABLE `albums_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `country_id` INT(11) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_cities_countries1_idx` (`country_id`),
  CONSTRAINT `fk_cities_country_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (id, country_id, name) VALUES (1,1,'Киев'),(2,1,'Харьков'),(3,2,'Москва');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `text` text NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `published` timestamp NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaints` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `text` text NOT NULL,
  `status` enum('considered','unconsidered') NOT NULL DEFAULT 'unconsidered',
  `published` timestamp NULL DEFAULT NULL,
  `complaints_types_id` INT(11) NOT NULL,
  `object_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  KEY `fk_complaints_complaints_types1_idx` (`complaints_types_id`),
  CONSTRAINT `fk_comments_users10` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_complaints_complaints_types1` FOREIGN KEY (`complaints_types_id`) REFERENCES `complaints_types` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaints`
--

LOCK TABLES `complaints` WRITE;
/*!40000 ALTER TABLE `complaints` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaints_types`
--

DROP TABLE IF EXISTS `complaints_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaints_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `table_name` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name_UNIQUE` (`table_name`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaints_types`
--

LOCK TABLES `complaints_types` WRITE;
/*!40000 ALTER TABLE `complaints_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaints_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` (id, name) VALUES (2,'Россия'),(1,'Украина');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `user_sender` INT(11) NOT NULL,
  `user_receiver` INT(11) NOT NULL,
  `status` enum('applied','unapplied') NOT NULL DEFAULT 'unapplied',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY `fk_table1_users1_idx` (`user_sender`),
  KEY `fk_table1_users2_idx` (`user_receiver`),
  CONSTRAINT `fk_table1_users1` FOREIGN KEY (`user_sender`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_table1_users2` FOREIGN KEY (`user_receiver`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `description` tinytext NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idusers_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_avatars`
--

DROP TABLE IF EXISTS `groups_avatars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_avatars` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `file_name` VARCHAR(100) NOT NULL,
  `group_id` INT(11) NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_groups_avatars_groups1_idx` (`group_id`),
  CONSTRAINT `fk_groups_avatars_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_avatars`
--

LOCK TABLES `groups_avatars` WRITE;
/*!40000 ALTER TABLE `groups_avatars` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_avatars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_news`
--

DROP TABLE IF EXISTS `groups_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `news_id` INT(11) NOT NULL,
  `group_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_news_news1_idx` (`news_id`),
  KEY `fk_groups_news_groups1_idx` (`group_id`),
  CONSTRAINT `fk_groups_news_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_users_news_news10` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_news`
--

LOCK TABLES `groups_news` WRITE;
/*!40000 ALTER TABLE `groups_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender_id` INT(11) NOT NULL,
  `receiver_id` INT(11) NOT NULL,
  `text` text NOT NULL,
  `status` enum('read','unread','block','delete') NOT NULL DEFAULT 'unread',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`sender_id`),
  KEY `fk_messages_users1_idx` (`sender_id`),
  KEY `fk_messages_users2_idx` (`receiver_id`),
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_messages_users2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (id, sender_id, receiver_id, text, status) VALUES (1,1,2,'qwe','unread'),(2,1,3,'asd','unread'),(3,2,1,'zxc','unread'),(4,2,3,'dfg','unread'),(5,1,5,'jkl','unread'),(6,1,1,'iop','unread');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `text` text NOT NULL,
  `picture` VARCHAR(100) DEFAULT NULL,
  `status` enum('active','block','delete') NOT NULL DEFAULT 'active',
  `published` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (id, title, text, picture, status, published) VALUES (1,'qwe','qwe123','qwe','active','2016-12-16 16:05:50'),(2,'asd','asd123','asd','active','2016-12-16 16:05:59');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_comments`
--

DROP TABLE IF EXISTS `news_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `news_id` INT(11) NOT NULL,
  `comment_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_news_comments_news1_idx` (`news_id`),
  KEY `fk_news_comments_comments1_idx` (`comment_id`),
  CONSTRAINT `fk_news_comments_comments1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_news_comments_news1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_comments`
--

LOCK TABLES `news_comments` WRITE;
/*!40000 ALTER TABLE `news_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passwords`
--

DROP TABLE IF EXISTS `passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwords` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id_UNIQUE` (`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_passwords_users1_idx` (`user_id`),
  CONSTRAINT `fk_passwords_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passwords`
--

LOCK TABLES `passwords` WRITE;
/*!40000 ALTER TABLE `passwords` DISABLE KEYS */;
INSERT INTO `passwords` (id, user_id, password) VALUES (1,1,'qwerty'),(2,2,'q1w2e3'),(3,3,'qwerty123');
/*!40000 ALTER TABLE `passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `phone_UNIQUE` (`phone`),
  KEY `fk_phones_users1_idx` (`user_id`),
  CONSTRAINT `fk_phones_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones`
--

LOCK TABLES `phones` WRITE;
/*!40000 ALTER TABLE `phones` DISABLE KEYS */;
INSERT INTO `phones` (id, user_id, phone) VALUES (1,1,'0971231212'),(2,1,'0681231212'),(3,2,'0972341212');
/*!40000 ALTER TABLE `phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` enum('user','admin') NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (id, name) VALUES (1,'admin'),(2,'user');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(20) NOT NULL,
  `middle_name` VARCHAR(20) NOT NULL,
  `last_name` VARCHAR(20) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `birthday` date,
  `sex` enum('male','female') NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idusers_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `users_avatars`
--

DROP TABLE IF EXISTS `users_avatars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_avatars` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `file_name` VARCHAR(100) NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  KEY `fk_user_avatar_users1_idx` (`user_id`),
  CONSTRAINT `fk_user_avatar_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_avatars`
--

LOCK TABLES `users_avatars` WRITE;
/*!40000 ALTER TABLE `users_avatars` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_avatars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_avatars_comments`
--

DROP TABLE IF EXISTS `users_avatars_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_avatars_comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_avatar_id` INT(11) NOT NULL,
  `comment_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_avatars_comments_users_avatars1_idx` (`user_avatar_id`),
  KEY `fk_users_avatars_comments_comments1_idx` (`comment_id`),
  CONSTRAINT `fk_users_avatars_comments_comments1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_users_avatars_comments_users_avatars1` FOREIGN KEY (`user_avatar_id`) REFERENCES `users_avatars` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_avatars_comments`
--

LOCK TABLES `users_avatars_comments` WRITE;
/*!40000 ALTER TABLE `users_avatars_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_avatars_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_cities`
--

DROP TABLE IF EXISTS `users_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_cities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `city_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_cities_1_idx` (`user_id`),
  KEY `fk_users_cities_1_idx1` (`city_id`),
  CONSTRAINT `fk_users_cities_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_users_idq_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_cities`
--

LOCK TABLES `users_cities` WRITE;
/*!40000 ALTER TABLE `users_cities` DISABLE KEYS */;
INSERT INTO `users_cities` (id, user_id, city_id) VALUES (1,1,1),(2,2,1),(3,3,2);
/*!40000 ALTER TABLE `users_cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `group_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_groups_news_groups1_idx` (`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  CONSTRAINT `fk_groups_news_groups10` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_news`
--

DROP TABLE IF EXISTS `users_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_news` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `news_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_news_news1_idx` (`news_id`),
  KEY `fk_users_news_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_news_news1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_users_news_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_news`
--

LOCK TABLES `users_news` WRITE;
/*!40000 ALTER TABLE `users_news` DISABLE KEYS */;
INSERT INTO `users_news` (id, news_id, user_id) VALUES (1,1,1),(2,2,1);
/*!40000 ALTER TABLE `users_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `role_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_roles_users_idx` (`user_id`),
  KEY `fk_users_roles_roles1_idx` (`role_id`),
  CONSTRAINT `fk_users_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE RESTRICT,
  CONSTRAINT `fk_users_roles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE  RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `admin_list`
--

/*!50001 DROP VIEW IF EXISTS `admin_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `admin_list` AS select `u`.`first_name` AS `first_name`,`r`.`name` AS `name` from ((`users` `u` join `users_roles` `ur` on((`u`.`id` = `ur`.`user_id`))) join `roles` `r` on((`ur`.`role_id` = `r`.`id`))) where (`r`.`name` = 'admin') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-16 18:25:56

/*Альбом может принадлежать только одной группе или одному пользователю*/
ALTER TABLE albums_groups ADD UNIQUE KEY (album_id);
ALTER TABLE albums_users ADD UNIQUE KEY (album_id);

/*Каждая фотография имеет уникальное имя файла*/
ALTER TABLE albums_photos ADD UNIQUE KEY (file_name);

/*Каждый комментарий может относиться только к одному объекту (фото, аватар, новость)*/
ALTER TABLE albums_photos_comments ADD UNIQUE KEY (comment_id);
ALTER TABLE users_avatars_comments ADD UNIQUE KEY (comment_id);
ALTER TABLE news_comments ADD UNIQUE KEY (comment_id);


/*В стране не должно быть городов с повторяющимися названиями*/
ALTER TABLE cities ADD UNIQUE KEY country_id_name (country_id, name);

/*Нельзя дважды предложить дружбу от одного человека к другому (обратная ситуация проверяется триггером)*/
ALTER TABLE friends ADD UNIQUE KEY sender_receiver (user_sender, user_receiver);

/*Группа может иметь только один аватар*/
ALTER TABLE groups_avatars ADD UNIQUE KEY (group_id);

/*Новость может принадлежать только одному пользователю или группе*/
ALTER TABLE groups_news ADD UNIQUE KEY (news_id);
ALTER TABLE users_news ADD UNIQUE KEY (news_id);

/*Названия ролей повторяться не могут*/
ALTER TABLE roles ADD UNIQUE KEY (name);

/*Нельзя дважды прописать одинаковую роль для одного юзера*/
ALTER TABLE users_roles ADD UNIQUE KEY user_id_role_id (user_id, role_id);

/*Нельзя дважды добавить пользователя в одну и ту же группу*/
ALTER TABLE users_groups ADD UNIQUE KEY group_id_user_id (group_id, user_id);


DELIMITER //
CREATE TRIGGER friends_insert
	BEFORE INSERT
    ON friends FOR EACH ROW
BEGIN
	DECLARE row_num INT;
	SELECT COUNT(*) FROM friends
		WHERE user_receiver=NEW.user_sender
			AND user_sender=NEW.user_receiver
		INTO row_num;
	IF row_num>0 THEN
		SIGNAL SQLSTATE '02000' SET message_text="Такая дружба уже существует";
	END IF;
	IF NEW.user_receiver=NEW.user_sender THEN
		SIGNAL SQLSTATE '02000' SET message_text="Дружба с собой невозможна";
	END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER complaints_insert
	AFTER INSERT
    ON complaints FOR EACH ROW
BEGIN
	DECLARE comp_num INT;
	DECLARE table_name varchar(45);
    	SELECT COUNT(*) FROM complaints
		WHERE complaints_types_id=NEW.complaints_types_id
			AND object_id=NEW.object_id
		INTO comp_num;
	IF comp_num>=2	THEN
		SELECT ct.table_name FROM complaints_types ct
			WHERE ct.id=NEW.complaints_types_id
	            INTO table_name;
		CASE table_name
			WHEN 'albums_photos' THEN
			        UPDATE albums_photos SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'comments' THEN
			        UPDATE comments SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'groups_avatars' THEN
			        UPDATE groups_avatars SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'messages' THEN
			        UPDATE messages SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'news' THEN
			        UPDATE news SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'users_avatars' THEN
			        UPDATE users_avatars SET status='block'
					WHERE id=NEW.object_id;
		END CASE;
	END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER user_insert
	AFTER INSERT
    ON users FOR EACH ROW
BEGIN
	DECLARE role_id INT;
      SELECT id FROM roles
		WHERE name='user'
		INTO role_id;
	INSERT INTO users_roles (user_id, role_id)
		VALUES (NEW.id, role_id);
END //
DELIMITER ;


CREATE USER 'dev'@'localhost' IDENTIFIED BY 'qqq';
GRANT ALL ON ts.* TO 'dev'@'localhost';

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (id, first_name, middle_name, last_name, email, birthday, sex, status) VALUES (1,'Вадим','Александрович','Малец','abc@bb.bb','1996-04-27','male','active'),(2,'Илья','Юрьевич','Морква','test@bb.eu','1996-04-28','female','active'),(3,'Петя','Петрович','Пупкин','petya@bb.ua','1996-01-12','male','block'),(4,'Вася','Васильевич','Васькин','vasya@bb.ru','1997-01-01','male','active'),(5,'Ирина','Александровна','Иркина','ira@bb.ru','1981-01-14','female','active'),(6,'Даша','Фёдоровна','Дашевна','dasha@bb.ru','1989-09-09','female','active');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` (user_sender, user_receiver, status) VALUES (1,2,'applied'),(1,3,'unapplied'),(1,4,'applied'),(5,1,'applied'),(2,3,'applied');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;


