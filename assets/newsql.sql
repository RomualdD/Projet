
#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
CREATE DATABASE `diavk`;

USE `diavk`;

#------------------------------------------------------------
# Table: pbvhfjt_appointments
#------------------------------------------------------------

CREATE TABLE pbvhfjt_appointments(
        id                      int (11) Auto_increment  NOT NULL ,
        name                    Varchar (255) ,
        date                    Date ,
        hour                    Varchar (40) ,
        additional_informations Varchar (255) ,
        remarque                Varchar (255) ,
        id_pbvhfjt_users        Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pbvhfjt_follow
#------------------------------------------------------------

CREATE TABLE pbvhfjt_follow(
        id                 int (11) Auto_increment  NOT NULL ,
        confirm            Enum ("0","1") NOT NULL ,
        date               Date ,
        id_pbvhfjt_users   Int NOT NULL ,
        id_pbvhfjt_users_1 Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pbvhfjt_medical_followup
#------------------------------------------------------------

CREATE TABLE pbvhfjt_medical_followup(
        id               int (11) Auto_increment  NOT NULL ,
        today_date       Datetime ,
        result           Varchar (10) ,
        next_date_check  Datetime ,
        id_pbvhfjt_users Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pbvhfjt_users
#------------------------------------------------------------

CREATE TABLE pbvhfjt_users(
        id                   int (11) Auto_increment  NOT NULL ,
        lastname             Varchar (40) ,
        firstname            Varchar (60) ,
        username             Varchar (40) ,
        mail                 Varchar (80) ,
        password             Varchar (80) ,
        birthdate            Date ,
        phone                Varchar (12) ,
        phone2               Varchar (12) ,
        language             Char (5) ,
        keyverif             Varchar (32) ,
        active               Int ,
        qrcode               Varchar (60) ,
        id_pbvhfjt_role      Int NOT NULL ,
        id_pbvhfjt_pathology Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pbvhfjt_verification
#------------------------------------------------------------

CREATE TABLE pbvhfjt_verification(
        id                int (11) Auto_increment  NOT NULL ,
        verification      Varchar (12) ,
        one_hour          Varchar (40) ,
        two_hour          Varchar (40) ,
        three_hour        Varchar (40) ,
        four_hour         Varchar (40) ,
        notification      Int ,
        verification_date Varchar (40) ,
        id_pbvhfjt_users  Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pbvhfjt_pathology
#------------------------------------------------------------

CREATE TABLE pbvhfjt_pathology(
        id   int (11) Auto_increment  NOT NULL ,
        name Varchar (255) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: pbvhfjt_role
#------------------------------------------------------------

CREATE TABLE pbvhfjt_role(
        id   int (11) Auto_increment  NOT NULL ,
        name Varchar (255) ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;

ALTER TABLE pbvhfjt_appointments ADD CONSTRAINT FK_pbvhfjt_appointments_id_pbvhfjt_users FOREIGN KEY (id_pbvhfjt_users) REFERENCES pbvhfjt_users(id);
ALTER TABLE pbvhfjt_follow ADD CONSTRAINT FK_pbvhfjt_follow_id_pbvhfjt_users FOREIGN KEY (id_pbvhfjt_users) REFERENCES pbvhfjt_users(id);
ALTER TABLE pbvhfjt_follow ADD CONSTRAINT FK_pbvhfjt_follow_id_pbvhfjt_users_1 FOREIGN KEY (id_pbvhfjt_users_1) REFERENCES pbvhfjt_users(id);
ALTER TABLE pbvhfjt_medical_followup ADD CONSTRAINT FK_pbvhfjt_medical_followup_id_pbvhfjt_users FOREIGN KEY (id_pbvhfjt_users) REFERENCES pbvhfjt_users(id);
ALTER TABLE pbvhfjt_users ADD CONSTRAINT FK_pbvhfjt_users_id_pbvhfjt_role FOREIGN KEY (id_pbvhfjt_role) REFERENCES pbvhfjt_role(id);
ALTER TABLE pbvhfjt_users ADD CONSTRAINT FK_pbvhfjt_users_id_pbvhfjt_pathology FOREIGN KEY (id_pbvhfjt_pathology) REFERENCES pbvhfjt_pathology(id);
ALTER TABLE pbvhfjt_verification ADD CONSTRAINT FK_pbvhfjt_verification_id_pbvhfjt_users FOREIGN KEY (id_pbvhfjt_users) REFERENCES pbvhfjt_users(id);

