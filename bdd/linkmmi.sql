DROP TABLE IF EXISTS travail ;
CREATE TABLE travail (idTravail BIGINT(8) AUTO_INCREMENT NOT NULL,
villeTravail CHAR(100),
nomTravail TEXT,
intituleTravail TEXT,
PRIMARY KEY (idTravail)) ENGINE=InnoDB;

DROP TABLE IF EXISTS conversation ;
CREATE TABLE conversation (idConversation BIGINT(8) AUTO_INCREMENT NOT NULL,
nomConversation CHAR(120),
PRIMARY KEY (idConversation)) ENGINE=InnoDB;

DROP TABLE IF EXISTS message ;
CREATE TABLE message (idMessage BIGINT(8) AUTO_INCREMENT NOT NULL,
contenuMessage TEXT,
dateMessage DATETIME,
idUser BIGINT(8),
idConversation BIGINT(8),
PRIMARY KEY (idMessage)) ENGINE=InnoDB;

DROP TABLE IF EXISTS utilisateur ;
CREATE TABLE utilisateur (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
mailUser CHAR(100),
passwordUser CHAR(100),
prenomUser CHAR(100),
nomUser CHAR(100),
descriptionUser TEXT,
birthdayUser DATE,
photoUser CHAR(100),
banniereUser CHAR(100),
portfolioUser CHAR(100),
PRIMARY KEY (idUser)) ENGINE=InnoDB;

DROP TABLE IF EXISTS commentaire ;
CREATE TABLE commentaire (idCommentaire BIGINT(8) AUTO_INCREMENT NOT NULL,
contenuCommentaire TEXT,
dateCommentaire DATETIME,
idTopic BIGINT(8),
idUser BIGINT(8),
PRIMARY KEY (idCommentaire)) ENGINE=InnoDB;

DROP TABLE IF EXISTS topic ;
CREATE TABLE topic (idTopic BIGINT(8) AUTO_INCREMENT NOT NULL,
imgTopic CHAR(100),
contenuTopic TEXT,
dateTopic DATETIME,
idUser BIGINT(8),
PRIMARY KEY (idTopic)) ENGINE=InnoDB;

DROP TABLE IF EXISTS tag ;
CREATE TABLE tag (idTag BIGINT(8) AUTO_INCREMENT NOT NULL,
nomTag CHAR(100),
PRIMARY KEY (idTag)) ENGINE=InnoDB;

INSERT INTO tag VALUES (1, 'mmi');

DROP TABLE IF EXISTS rejoint ;
CREATE TABLE rejoint (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
idConversation BIGINT(8) NOT NULL,
PRIMARY KEY (idUser,
 idConversation)) ENGINE=InnoDB;

DROP TABLE IF EXISTS travaildans ;
CREATE TABLE travaildans (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
idTravail BIGINT(8) NOT NULL,
debutTravail DATE,
finTravail DATE,
PRIMARY KEY (idUser,
 idTravail)) ENGINE=InnoDB;

DROP TABLE IF EXISTS aime ;
CREATE TABLE aime (idTopic BIGINT(8) AUTO_INCREMENT NOT NULL,
idUser BIGINT(8) NOT NULL,
PRIMARY KEY (idTopic,
 idUser)) ENGINE=InnoDB;

DROP TABLE IF EXISTS reference ;
CREATE TABLE reference (idTag BIGINT(8) AUTO_INCREMENT NOT NULL,
idTopic BIGINT(8) NOT NULL,
PRIMARY KEY (idTag,
 idTopic)) ENGINE=InnoDB;

DROP TABLE IF EXISTS follow ;
CREATE TABLE follow (
idUser_suit BIGINT(8),
idUser_suivit BIGINT(8)) ENGINE=InnoDB;

DROP TABLE IF EXISTS bloque ;
CREATE TABLE bloque (
idUser_bloque BIGINT(8),
idUser_bloquant BIGINT(8)) ENGINE=InnoDB;

ALTER TABLE message ADD CONSTRAINT FK_message_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);

ALTER TABLE message ADD CONSTRAINT FK_message_idConversation FOREIGN KEY (idConversation) REFERENCES conversation (idConversation);
ALTER TABLE commentaire ADD CONSTRAINT FK_commentaire_idTopic FOREIGN KEY (idTopic) REFERENCES topic (idTopic);
ALTER TABLE commentaire ADD CONSTRAINT FK_commentaire_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE topic ADD CONSTRAINT FK_topic_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE rejoint ADD CONSTRAINT FK_rejoint_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE rejoint ADD CONSTRAINT FK_rejoint_idConversation FOREIGN KEY (idConversation) REFERENCES conversation (idConversation);
ALTER TABLE travaildans ADD CONSTRAINT FK_travaildans_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE travaildans ADD CONSTRAINT FK_travaildans_idTravail FOREIGN KEY (idTravail) REFERENCES travail (idTravail);
ALTER TABLE aime ADD CONSTRAINT FK_aime_idTopic FOREIGN KEY (idTopic) REFERENCES topic (idTopic);
ALTER TABLE aime ADD CONSTRAINT FK_aime_idUser FOREIGN KEY (idUser) REFERENCES utilisateur (idUser);
ALTER TABLE reference ADD CONSTRAINT FK_reference_idTag FOREIGN KEY (idTag) REFERENCES tag (idTag);
ALTER TABLE reference ADD CONSTRAINT FK_reference_idTopic FOREIGN KEY (idTopic) REFERENCES topic (idTopic);
ALTER TABLE follow ADD PRIMARY KEY (idUser_suit, idUser_suivit), ADD KEY follow_Composé (idUser_suivit);
ALTER TABLE bloque ADD PRIMARY KEY (idUser_bloque, idUser_bloquant), ADD KEY bloque_Composé (idUser_bloquant);
