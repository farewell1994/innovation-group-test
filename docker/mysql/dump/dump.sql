
CREATE DATABASE IF NOT EXISTS innovation_group;

DROP TABLE IF EXISTS innovation_group.bonus;
CREATE TABLE innovation_group.bonus
(
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    date_create DATETIME NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

DROP TABLE IF EXISTS innovation_group.client;
CREATE TABLE IF NOT EXISTS innovation_group.client
(
    id INT AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    is_email_verified TINYINT(0) NOT NULL,
    date_create DATETIME NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

DROP TABLE IF EXISTS innovation_group.client_bonus;
CREATE TABLE innovation_group.client_bonus
(
    id INT AUTO_INCREMENT NOT NULL,
    client_id INT NOT NULL,
    bonus_id INT NOT NULL,
    date_create DATETIME NOT NULL,
    INDEX IDX_3CF5E3CD19EB6921 (client_id),
    INDEX IDX_3CF5E3CD69545666 (bonus_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

ALTER TABLE innovation_group.client_bonus
    ADD CONSTRAINT FK_3CF5E3CD19EB6921
        FOREIGN KEY (client_id)
            REFERENCES innovation_group.client (id)
            ON DELETE CASCADE;
ALTER TABLE innovation_group.client_bonus
    ADD CONSTRAINT FK_3CF5E3CD69545666
        FOREIGN KEY (bonus_id)
            REFERENCES innovation_group.bonus (id)
            ON DELETE CASCADE;

DROP TABLE IF EXISTS innovation_group.doctrine_migration_versions;
CREATE TABLE doctrine_migration_versions
(
    version varchar(191) COLLATE utf8_unicode_ci NOT NULL,
    executed_at datetime DEFAULT NULL,
    execution_time int DEFAULT NULL,
    PRIMARY KEY (version)
) ENGINE InnoDB DEFAULT CHARSET utf8 COLLATE utf8_unicode_ci;

INSERT INTO innovation_group.doctrine_migration_versions
VALUES
    (`DoctrineMigrations\\Version20240314163930`,`2024-03-14 16:39:52`,3529),
    (`DoctrineMigrations\\Version20240315074057`,`2024-03-15 07:42:41`,7384),
    (`DoctrineMigrations\\Version20240315095411`,`2024-03-15 09:54:42`,17547);


CREATE DATABASE IF NOT EXISTS innovation_group_test;

DROP TABLE IF EXISTS innovation_group_test.bonus;
CREATE TABLE innovation_group_test.bonus LIKE innovation_group.bonus;

DROP TABLE IF EXISTS innovation_group_test.client;
CREATE TABLE innovation_group_test.client LIKE innovation_group.client;

DROP TABLE IF EXISTS innovation_group_test.client_bonus;
CREATE TABLE innovation_group_test.client_bonus LIKE innovation_group.client_bonus;

DROP TABLE IF EXISTS innovation_group_test.doctrine_migration_versions;
CREATE TABLE innovation_group_test.doctrine_migration_versions LIKE innovation_group.doctrine_migration_versions;
INSERT innovation_group_test.doctrine_migration_versions SELECT * FROM innovation_group.doctrine_migration_versions;
