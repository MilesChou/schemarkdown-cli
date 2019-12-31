DROP TABLE IF EXISTS should_return_int;

CREATE TABLE should_return_int (
  increment_field INTEGER PRIMARY KEY,
  smallint_field SMALLINT NOT NULL,
  int_field INT NOT NULL,
  bigint_field BIGINT NOT NULL
);

DROP TABLE IF EXISTS should_return_float;

CREATE TABLE should_return_float (
  decimal_field DECIMAL(5,2) NOT NULL,
  float_field FLOAT NOT NULL,
  real_field REAL NOT NULL,
  double_field DOUBLE PRECISION NOT NULL
);

DROP TABLE IF EXISTS should_return_string;

CREATE TABLE should_return_string (
  char_field CHAR(255) NOT NULL,
  varchar_field VARCHAR(255) NOT NULL,
  text_field TEXT NOT NULL
);
