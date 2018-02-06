CREATE DATABASE `diavk`;

USE `diavk`;

CREATE TABLE `users` (
	`id` INT(11) AUTO_INCREMENT PRIMARY KEY,
	`lastname` VARCHAR(40),
	`firstname` VARCHAR(60),
	`username` VARCHAR(40),
	`mail` VARCHAR(80),
	`password` VARCHAR(80),
	`birthdate` DATE,
	`phone` VARCHAR(12),
	`phone2` VARCHAR(12),
	`role` INT(11),
	`pathology` INT(11),
	`keyverif` varchar(32),
	`active` INT(11),
	`qrcode` VARCHAR(60)	
);

CREATE TABLE `medical_followup` (
	`id` INT(11) PRIMARY KEY,
	`userId` INT(11),
	`today_date` DATETIME,
	`result` VARCHAR(10),
	`next_date_check` DATETIME
);

CREATE TABLE `follow` (
	`follow_from` INT(11),
	`follow_to` INT(11),
	`follow_confirm` enum('0','1') NOT NULL,
	`follow_date` DATE,
	CONSTRAINT PK_Follow PRIMARY KEY (`follow_from`, `follow_to`)
);

CREATE TABLE `verification` ( 
	`userId` INT(11) PRIMARY KEY,
	`verification` DATETIME,
	`onehour` VARCHAR(40),
	`twohour` VARCHAR(40),
	`threehour` VARCHAR(40),
	`fourhour` VARCHAR(40),
	`notification` INT(11),
	`verirication_date` VARCHAR(40)
);

CREATE TABLE `appointments` ( 
	`id` INT(11) PRIMARY KEY AUTO_INCREMENT,
	`userId` INT(12),
	`name_appointment` VARCHAR(255),
	`date_appointment` DATE,
	`hour_appointment` VARCHAR(40),
	`additional_informations` VARCHAR(255),
	`remarque` VARCHAR(255)
);
