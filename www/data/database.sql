CREATE TABLE backups (
  id      INT(11)   NOT NULL AUTO_INCREMENT,
  sid     INT(11)   NOT NULL,
  bid     INT(11)   NOT NULL,
  item_id INT(11)   NOT NULL,
  date    TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;

CREATE TABLE block_ip (
  id   INT(11)   NOT NULL AUTO_INCREMENT,
  bid  INT(11)   NOT NULL,
  sid  INT(11)   NOT NULL,
  ip   TEXT      NOT NULL,
  date TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;

CREATE TABLE categories (
  id       INT(11)    NOT NULL AUTO_INCREMENT,
  cid      INT(11)    NOT NULL,
  sid      INT(11)    NOT NULL,
  category TEXT       NOT NULL,
  name     TEXT       NOT NULL,
  main     TINYINT(1) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;

CREATE TABLE codes (
  id       INT(11)      NOT NULL AUTO_INCREMENT,
  cid      INT(11)      NOT NULL,
  sid      INT(11)      NOT NULL,
  type     VARCHAR(255) NOT NULL DEFAULT 'single',
  code     TEXT         NOT NULL,
  count    INT(11)      NULL,
  item     TEXT         NOT NULL,
  discount FLOAT        NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;

CREATE TABLE gifts (
  id     INT(11) NOT NULL AUTO_INCREMENT,
  gid    INT(11) NOT NULL,
  sid    INT(11) NOT NULL,
  gift   TEXT    NOT NULL,
  winner TEXT    NOT NULL,
  users  TEXT    NOT NULL,
  image  TEXT    NOT NULL,
  `desc` TEXT    NOT NULL,
  vk     TEXT    NOT NULL,
  time   INT     NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;

CREATE TABLE items (
  id      INT(11)    NOT NULL AUTO_INCREMENT,
  sid     INT(11)    NOT NULL,
  cid     INT(11)    NOT NULL,
  item_id INT(11)    NOT NULL,
  item    TEXT       NOT NULL,
  image   TEXT       NOT NULL,
  price   TEXT       NOT NULL,
  count   INT(11)    NULL,
  body    TEXT       NOT NULL,
  main    INT(11)    NOT NULL,
  type    VARCHAR(4) NOT NULL DEFAULT 'text',
  min     INT(11)    NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;


CREATE TABLE logs (
  id     INT(11)    NOT NULL AUTO_INCREMENT,
  lid    INT(11)    NOT NULL,
  sid    INT(11)    NOT NULL,
  ip     TEXT       NOT NULL,
  login  TEXT       NOT NULL,
  status TINYINT(1) NOT NULL,
  date   TIMESTAMP  NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;


CREATE TABLE orders (
  id      INT(11)    NOT NULL AUTO_INCREMENT,
  oid     INT(11)    NOT NULL,
  sid     INT(11)    NOT NULL,
  item    TEXT       NOT NULL,
  item_id INT(11)    NOT NULL,
  email   TEXT       NOT NULL,
  wallet  TEXT       NOT NULL,
  bill    TEXT       NOT NULL,
  price   FLOAT      NOT NULL,
  count   INT(11)    NOT NULL,
  status  TINYINT(1) NOT NULL,
  time    TEXT       NOT NULL,
  ip      TEXT       NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;


CREATE TABLE pages (
  id    INT(11) NOT NULL AUTO_INCREMENT,
  pid   INT(11) NOT NULL,
  sid   INT(11) NOT NULL,
  title TEXT    NOT NULL,
  body  TEXT    NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;


CREATE TABLE users (
  id        INT(11) NOT NULL AUTO_INCREMENT,
  uid       INT(11) NOT NULL,
  sid       INT(11) NOT NULL,
  login     TEXT    NOT NULL,
  ulogin    TEXT    NULL,
  email     TEXT    NOT NULL,
  password  TEXT    NOT NULL,
  privilege TEXT    NULL,
  PRIMARY KEY (id)
)
  ENGINE innoDb
  CHARSET utf8;
