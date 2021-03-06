CREATE DATABASE `university`;

CREATE TABLE IF NOT EXISTS `university`.`student`
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age SMALLINT UNSIGNED NOT NULL,
    group_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (id)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `university`.`group`
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,

    PRIMARY KEY (id)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8;
