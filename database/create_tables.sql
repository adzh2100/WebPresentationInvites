DROP DATABASE if EXISTS webInvites;

CREATE DATABASE webInvites;


CREATE TABLE users (
  id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  username        VARCHAR(20) NOT NULL UNIQUE,
  password        VARCHAR(255) NOT NULL,
  first_name       VARCHAR(20), NOT NULL,
  last_name        VARCHAR(20), NOT NULL,
  email           VARCHAR(30) NOT NULL UNIQUE,
  role            ENUM('teacher', 'student') NOT NULL
  faculty_number   VARCHAR(20) UNIQUE NOT NULL,
) default charset utf8 comment '';

CREATE TABLE invitations (
  id                    INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
  user_id               INT NOT NULL REFERENCES users(id),
  presentation_theme    VARCHAR(255) NOT NULL,
  datetime              DATETIME NOT NULL,
  description           VARCHAR(255) NOT NULL
) default charset utf8 comment '';