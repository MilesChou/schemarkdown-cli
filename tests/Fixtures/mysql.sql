CREATE DATABASE test_mysql DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

USE `test_mysql`;

DROP TABLE IF EXISTS `test_basic`;

CREATE TABLE `test_basic` (
  `comment_field` VARCHAR(255) NOT NULL COMMENT 'some_comment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `should_return_int`;

CREATE TABLE `should_return_int` (
  `increment_field` INT(11) NOT NULL AUTO_INCREMENT,
  `smallint_field` SMALLINT(5) NOT NULL,
  `mediumint_field` MEDIUMINT(7) NOT NULL,
  `int_field` INT(11) NOT NULL,
  `bigint_field` BIGINT(20) NOT NULL,
  PRIMARY KEY (`increment_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `should_return_float`;

CREATE TABLE `should_return_float` (
  `decimal_field` DECIMAL(5,2) NOT NULL,
  `float_field` FLOAT(5,2) NOT NULL,
  `real_field` REAL(5,2) NOT NULL,
  `double_field` DOUBLE PRECISION(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `should_return_string`;

CREATE TABLE `should_return_string` (
  `char_field` CHAR(255) NOT NULL,
  `varchar_field` VARCHAR(255) NOT NULL,
  `tinytext_field` TINYTEXT NOT NULL,
  `text_field` TEXT NOT NULL,
  `mediumtext_field` MEDIUMTEXT NOT NULL,
  `longtext_field` LONGTEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `test_for_pk`;

CREATE TABLE `test_for_pk` (
  `varchar_field` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`varchar_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `test_for_comment`;

CREATE TABLE `test_for_comment` (
  `some_char1` char(64) COLLATE utf8_bin DEFAULT NULL,
  `some_char2` char(64) COLLATE utf8_bin NOT NULL COMMENT 'some_char2 comment ',
  `some_varchar` varchar(4000) COLLATE utf8_bin DEFAULT NULL COMMENT 'some_varchar comment ',
  KEY `test_for_comment_idx_01` (`some_char2`),
  KEY `test_for_comment_idx_02` (`some_char2`,`some_char1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='table_comment ';
