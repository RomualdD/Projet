CREATE DATABASE diavk;

CREATE TABLE utilisateurs (
	id INT(11) AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(40),
	prenom VARCHAR(60),
	nom_utilisateur VARCHAR(40),
	mail VARCHAR(80),
	mot_de_passe VARCHAR(80),
	date_anniversaire VARCHAR(40),
	phone VARCHAR(12),
	phone2 VARCHAR(12),
	role INT(11),
	pathologie INT(11),
	cleverif varchar(32),
	actif INT(11)	
)

CREATE TABLE suivis (
	id INT(11) PRIMARY KEY,
	id_utilisateur INT(11),
	date_du_jour VARCHAR(40),
	resultat VARCHAR(10),
	date_prochaine_verif VARCHAR(40)
)

CREATE TABLE follow (
	follow_from INT(11),
	follow_to INT(11),
	follow_confirm enum('0','1') NOT NULL,
	follow_date VARCHAR(40),
	CONSTRAINT PK_Follow PRIMARY KEY (follow_from, follow_to)
)

CREATE TABLE verification ( 
	id_utilisateur INT(11) PRIMARY KEY,
	verification VARCHAR(60),
	Heure1 VARCHAR(40),
	Heure2 VARCHAR(40),
	Heure3 VARCHAR(40),
	Heure4 VARCHAR(40),
	notification INT(11)
)

CREATE TABLE rendez_vous ( 
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
	id_utilisateur INT(12),
	nom_rendez_vous VARCHAR(255),
	date_rendez_vous VARCHAR(40),
	heure_rendez_vous VARCHAR(40),
	infos_complementaire VARCHAR(255)
)
