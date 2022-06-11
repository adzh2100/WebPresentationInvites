DROP DATABASE if EXISTS webInvites;

CREATE DATABASE webInvites;

USE webInvites;

CREATE TABLE users (
  id                INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username          VARCHAR(30) NOT NULL UNIQUE,
  email             VARCHAR(70) NOT NULL UNIQUE,
  password          VARCHAR(255) NOT NULL,
  first_name        VARCHAR(20) NOT NULL,
  last_name         VARCHAR(20) NOT NULL,
  faculty_number    INT(10) NOT NULL UNIQUE,
  specification     VARCHAR(50) NOT NULL,
  year              INT(2) NOT NULL,
  created_at        DATETIME DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE invitations (
  id                    INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_id               INT NOT NULL REFERENCES users(id),
  presentation_theme    VARCHAR(255) NOT NULL,
  date                  DATE NOT NULL,
  time                  VARCHAR(10) NOT NULL,
  description           VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;