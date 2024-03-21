CREATE DATABASE IF NOT EXISTS `innovation_group`;
CREATE DATABASE IF NOT EXISTS `innovation_group_test`;
USE `innovation_group`;

DROP TABLE IF EXISTS `bonus`;
CREATE TABLE `bonus` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                         `type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                         `date_create` datetime NOT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
LOCK TABLES `bonus` WRITE;
UNLOCK TABLES;
DROP TABLE IF EXISTS innovation_group_test.bonus;
CREATE TABLE innovation_group_test.bonus
AS
SELECT * FROM innovation_group.bonus;


DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                          `birthday` date NOT NULL,
                          `is_email_verified` tinyint(1) NOT NULL,
                          `date_create` datetime NOT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
LOCK TABLES `client` WRITE;
UNLOCK TABLES;
DROP TABLE IF EXISTS innovation_group_test.client;
CREATE TABLE innovation_group_test.client
AS
SELECT * FROM innovation_group.client;

DROP TABLE IF EXISTS `client_bonus`;
CREATE TABLE `client_bonus` (
                                `id` int NOT NULL AUTO_INCREMENT,
                                `client_id` int NOT NULL,
                                `bonus_id` int NOT NULL,
                                `date_create` datetime NOT NULL,
                                PRIMARY KEY (`id`),
                                KEY `IDX_3CF5E3CD19EB6921` (`client_id`),
                                KEY `IDX_3CF5E3CD69545666` (`bonus_id`),
                                CONSTRAINT `FK_3CF5E3CD19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE,
                                CONSTRAINT `FK_3CF5E3CD69545666` FOREIGN KEY (`bonus_id`) REFERENCES `bonus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
LOCK TABLES `client_bonus` WRITE;
UNLOCK TABLES;
DROP TABLE IF EXISTS innovation_group_test.client_bonus;
CREATE TABLE innovation_group_test.client_bonus
AS
SELECT * FROM innovation_group.client_bonus;

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
                                               `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
                                               `executed_at` datetime DEFAULT NULL,
                                               `execution_time` int DEFAULT NULL,
                                               PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
LOCK TABLES `doctrine_migration_versions` WRITE;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240314163930','2024-03-14 16:39:52',3529),('DoctrineMigrations\\Version20240315074057','2024-03-15 07:42:41',7384),('DoctrineMigrations\\Version20240315095411','2024-03-15 09:54:42',17547);
UNLOCK TABLES;
DROP TABLE IF EXISTS innovation_group_test.doctrine_migration_versions;
CREATE TABLE innovation_group_test.doctrine_migration_versions
AS
SELECT * FROM innovation_group.doctrine_migration_versions;
