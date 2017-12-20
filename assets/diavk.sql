CREATE TABLE 'utilisateurs' (
	'id' int(11) AUTO_INCREMENT,
	'nom' VARCHAR(40),
	'prenom' VARCHAR(60),
	'nom_utilisateur' VARCAR(40),
	'mail' VARCHAR(80),
	'mot_de_passe' VARCHAR(80),
	'date_anniversaire' VARCHAR(40),
	'phone' VARCHAR(12),
	'phone2' VARCHAR(12),
	'role' INT(11),
	'pathologie' int(11),
	'cleverif' varchar(32),
	'actif' int(11),
	PRIMARY KEY('id')
	)

CREATE TABLE 'suivis' (
	'id' int(11),
	'id_utilisateur' int(11),
	'date_du_jour' VARCHAR(40),
	'resultat' VARCHAR(10),
	'date_prochaine_verif' VARCHAR(40),
	PRIMARY KEY('id')
	)

CREATE TABLE 'follow' (
	'follow_from' int(11),
	'follow_to' int(11),
	'follow_confirm' enum('0','1') NOT NULL,
	'follow_date' VARCHAR(40),
	PRIMARY KEY ('follow_from', 'follow_to')
	)
