CREATE DATABASE examples DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

USE `examples`;

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR (255) NOT NULL COMMENT 'Display name',
  email VARCHAR(255) NOT NULL COMMENT 'Email and login identity',
  password VARCHAR(255) NOT NULL COMMENT 'SHA256 digest',
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User registration table';
