DROP TABLE IF EXISTS `basic_table`;

CREATE TABLE `should_return_int` (
  `increment_field` INTEGER PRIMARY KEY AUTOINCREMENT,
  `smallint_field` SMALLINT(5) NOT NULL,
  `mediumint_field` MEDIUMINT(7) NOT NULL,
  `int_field` INT(11) NOT NULL,
  `bigint_field` BIGINT(20) NOT NULL
  `decimal_field` DECIMAL(5,2) NOT NULL,
  `float_field` FLOAT(5,2) NOT NULL,
  `real_field` REAL(5,2) NOT NULL,
  `double_field` DOUBLE PRECISION(5,2) NOT NULL
  `char_field` CHAR(255) NOT NULL,
  `varchar_field` VARCHAR(255) NOT NULL,
  `tinytext_field` TINYTEXT NOT NULL,
  `text_field` TEXT NOT NULL,
  `mediumtext_field` MEDIUMTEXT NOT NULL,
  `longtext_field` LONGTEXT NOT NULL
);
