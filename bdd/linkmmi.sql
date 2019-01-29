DROP TABLE IF EXISTS section ;
CREATE TABLE section (idSection BIGINT(8) AUTO_INCREMENT NOT NULL,
nomSection CHAR(120),
idTopic BIGINT(8),
PRIMARY KEY (idSection)) ENGINE=InnoDB;

DROP TABLE IF EXISTS tag ;
CREATE TABLE tag (idTag BIGINT(8) AUTO_INCREMENT NOT NULL,
nomTag CHAR(100),
PRIMARY KEY (idTag)) ENGINE=InnoDB;

DROP TABLE IF EXISTS travail ;
CREATE TABLE travail (idTravail BIGINT(8) AUTO_INCREMENT NOT NULL,
villeTravail CHAR(100),
nomTravail TEXT,
intituleTravail TEXT,
PRIMARY KEY (idTravail)) ENGINE=InnoDB;

DROP TABLE IF EXISTS conversation ;
CREATE TABLE conversation (idConversation BIGINT(8) AUTO_INCREMENT NOT NULL,
nomConversation CHAR(120),
idMessage BIGINT(8),
PRIMARY KEY (idConversation)) ENGINE=InnoDB;

DROP TABLE IF EXISTS message ;
CREATE TABLE message (idMessage BIGINT(8) AUTO_INCREMENT NOT NULL,
contenuMessage TEXT,
PRIMARY KEY (idMessage)) ENGINE=InnoDB;

DROP TABLE IF EXISTS utilisateur ;
CREATE TABLE utilisateur (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
mailUser CHAR(100),
passwordUser CHAR(100),
prenomUser CHAR(100),
nomUser CHAR(100),
birthdayUser DATE,
photoUser CHAR(100),
portfolioUser CHAR(100),
idTopic BIGINT(8),
PRIMARY KEY (idUser)) ENGINE=InnoDB;

DROP TABLE IF EXISTS article ;
CREATE TABLE article (idArticle BIGINT(8) AUTO_INCREMENT NOT NULL,
contenuArticle TEXT,
PRIMARY KEY (idArticle)) ENGINE=InnoDB;

DROP TABLE IF EXISTS topic ;
CREATE TABLE topic (idTopic BIGINT(8) AUTO_INCREMENT NOT NULL,
nomTopic CHAR(120),
idArticle BIGINT(8),
PRIMARY KEY (idTopic)) ENGINE=InnoDB;

DROP TABLE IF EXISTS reference_par ;
CREATE TABLE reference_par (idArticle BIGINT(8) AUTO_INCREMENT NOT NULL,
idTag BIGINT(8) NOT NULL,
PRIMARY KEY (idArticle,
 idTag)) ENGINE=InnoDB;

DROP TABLE IF EXISTS aime ;
CREATE TABLE aime (idArticle BIGINT(8) AUTO_INCREMENT NOT NULL,
idUser BIGINT(8) NOT NULL,
PRIMARY KEY (idArticle,
 idUser)) ENGINE=InnoDB;

DROP TABLE IF EXISTS publie ;
CREATE TABLE publie (idArticle BIGINT(8) AUTO_INCREMENT NOT NULL,
idUser BIGINT(8) NOT NULL,
dateArticle DATETIME,
PRIMARY KEY (idArticle,
 idUser)) ENGINE=InnoDB;

DROP TABLE IF EXISTS rejoint ;
CREATE TABLE rejoint (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
idConversation BIGINT(8) NOT NULL,
PRIMARY KEY (idUser,
 idConversation)) ENGINE=InnoDB;

DROP TABLE IF EXISTS envoie ;
CREATE TABLE envoie (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
idMessage BIGINT(8) NOT NULL,
dateMessage DATETIME,
PRIMARY KEY (idUser,
 idMessage)) ENGINE=InnoDB;

DROP TABLE IF EXISTS travaildans ;
CREATE TABLE travaildans (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
idTravail BIGINT(8) NOT NULL,
debutTravail DATE,
finTravail DATE,
PRIMARY KEY (idUser,
 idTravail)) ENGINE=InnoDB;

ALTER TABLE section ADD CONSTRAINT FK_section_idTopic FOREIGN KEY (idTopic) REFERENCES topic (idTopic);

ALTER TABLE conversation ADD CONSTRAINT FK_conversation_idMessage FOREIGN KEY (idMessage) REFERENCES message (idMessage);
ALTER TABLE utilisateur ADD CONSTRAINT FK_utilisateur_idTopic FOREIGN KEY (idTopic) REFERENCES topic (idTopic);
ALTER TABLE topic ADD CONSTRAINT FK_topic_idArticle FOREIGN KEY (idArticle) REFERENCES article (idArticle);
ALTER TABLE reference_par ADD CONSTRAINT FK_reference_par_idArticle FOREIGN KEY (idArticle) REFERENCES article (idArticle);
ALTER TABLE reference_par ADD CONSTRAINT FK_reference_par_idTag FOREIGN KEY (idTag) REFERENCES tag (idTag);
ALTER TABLE aime ADD CONSTRAINT FK_aime_idArticle FOREIGN KEY (idArticle) REFERENCES article (idArticle);
ALTER TABLE aime ADD CONSTRAINT FK_aime_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE publie ADD CONSTRAINT FK_publie_idArticle FOREIGN KEY (idArticle) REFERENCES article (idArticle);
ALTER TABLE publie ADD CONSTRAINT FK_publie_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE rejoint ADD CONSTRAINT FK_rejoint_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE rejoint ADD CONSTRAINT FK_rejoint_idConversation FOREIGN KEY (idConversation) REFERENCES conversation (idConversation);
ALTER TABLE envoie ADD CONSTRAINT FK_envoie_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE envoie ADD CONSTRAINT FK_envoie_idMessage FOREIGN KEY (idMessage) REFERENCES message (idMessage);
ALTER TABLE travaildans ADD CONSTRAINT FK_travaildans_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE travaildans ADD CONSTRAINT FK_travaildans_idTravail FOREIGN KEY (idTravail) REFERENCES travail (idTravail);
