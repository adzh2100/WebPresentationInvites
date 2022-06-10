DROP DATABASE if EXISTS webInvites;

CREATE DATABASE webInvites;

USE webInvites;

CREATE TABLE users (
  id                INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username          VARCHAR(30) NOT NULL UNIQUE,
  email             VARCHAR(30) NOT NULL UNIQUE,
  password          VARCHAR(255) NOT NULL,
  first_name        VARCHAR(20) NOT NULL,
  last_name         VARCHAR(20) NOT NULL,
  faculty_number    INT(10) NOT NULL UNIQUE,
  role              ENUM('teacher', 'student') NOT NULL,
  created_at        DATETIME DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- CREATE TABLE invitations (
--   id                    INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'primary key',
--   user_id               INT NOT NULL REFERENCES users(id),
--   presentation_theme    VARCHAR(255) NOT NULL,
--   datetime              DATETIME NOT NULL,
--   description           VARCHAR(255) NOT NULL
-- ) default charset utf8 comment '';