-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 31 jan. 2019 à 09:02
-- Version du serveur :  10.1.30-MariaDB
-- Version de PHP :  7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `linkmmi`
--

-- --------------------------------------------------------

--
-- Structure de la table `aime`
--

CREATE TABLE `aime` (
  `idTopic` bigint(8) NOT NULL,
  `idUser` bigint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `idArticle` bigint(8) NOT NULL,
  `contenuArticle` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bloque`
--

CREATE TABLE `bloque` (
  `idUser_bloquant` bigint(8) NOT NULL,
  `idUser_bloque` bigint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `idConversation` bigint(8) NOT NULL,
  `nomConversation` char(120) DEFAULT NULL,
  `idMessage` bigint(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `envoie`
--

CREATE TABLE `envoie` (
  `idUser` bigint(8) NOT NULL,
  `idMessage` bigint(8) NOT NULL,
  `dateMessage` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

CREATE TABLE `follow` (
  `idUser_suit` bigint(8) NOT NULL,
  `idUser_suivi` bigint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idMessage` bigint(8) NOT NULL,
  `contenuMessage` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `publie`
--

CREATE TABLE `publie` (
  `idArticle` bigint(8) NOT NULL,
  `idUser` bigint(8) NOT NULL,
  `dateArticle` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reference`
--

CREATE TABLE `reference` (
  `idTag` bigint(8) NOT NULL,
  `idTopic` bigint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rejoint`
--

CREATE TABLE `rejoint` (
  `idUser` bigint(8) NOT NULL,
  `idConversation` bigint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `idTag` bigint(8) NOT NULL,
  `nomTag` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE `topic` (
  `idTopic` bigint(8) NOT NULL,
  `nomTopic` char(120) DEFAULT NULL,
  `idArticle` bigint(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `travail`
--

CREATE TABLE `travail` (
  `idTravail` bigint(8) NOT NULL,
  `villeTravail` char(100) DEFAULT NULL,
  `nomTravail` text,
  `intituleTravail` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `travaildans`
--

CREATE TABLE `travaildans` (
  `idUser` bigint(8) NOT NULL,
  `idTravail` bigint(8) NOT NULL,
  `debutTravail` date DEFAULT NULL,
  `finTravail` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUser` bigint(8) NOT NULL,
  `mailUser` char(100) DEFAULT NULL,
  `passwordUser` char(100) DEFAULT NULL,
  `prenomUser` char(100) DEFAULT NULL,
  `nomUser` char(100) DEFAULT NULL,
  `birthdayUser` date DEFAULT NULL,
  `photoUser` char(100) DEFAULT NULL,
  `portfolioUser` char(100) DEFAULT NULL,
  `idTopic` bigint(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aime`
--
ALTER TABLE `aime`
  ADD PRIMARY KEY (`idTopic`,`idUser`),
  ADD KEY `FK_aime_idUser` (`idUser`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`idArticle`);

--
-- Index pour la table `bloque`
--
ALTER TABLE `bloque`
  ADD PRIMARY KEY (`idUser_bloque`,`idUser_bloquant`),
  ADD KEY `suit_Composé` (`idUser_bloquant`);

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`idConversation`),
  ADD KEY `FK_conversation_idMessage` (`idMessage`);

--
-- Index pour la table `envoie`
--
ALTER TABLE `envoie`
  ADD PRIMARY KEY (`idUser`,`idMessage`),
  ADD KEY `FK_envoie_idMessage` (`idMessage`);

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`idUser_suit`,`idUser_suivi`),
  ADD KEY `suit_Composé` (`idUser_suivi`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idMessage`);

--
-- Index pour la table `publie`
--
ALTER TABLE `publie`
  ADD PRIMARY KEY (`idArticle`,`idUser`),
  ADD KEY `FK_publie_idUser` (`idUser`);

--
-- Index pour la table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`idTag`,`idTopic`),
  ADD KEY `FK_reference_idTopic` (`idTopic`);

--
-- Index pour la table `rejoint`
--
ALTER TABLE `rejoint`
  ADD PRIMARY KEY (`idUser`,`idConversation`),
  ADD KEY `FK_rejoint_idConversation` (`idConversation`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`idTag`);

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`idTopic`),
  ADD KEY `FK_topic_idArticle` (`idArticle`);

--
-- Index pour la table `travail`
--
ALTER TABLE `travail`
  ADD PRIMARY KEY (`idTravail`);

--
-- Index pour la table `travaildans`
--
ALTER TABLE `travaildans`
  ADD PRIMARY KEY (`idUser`,`idTravail`),
  ADD KEY `FK_travaildans_idTravail` (`idTravail`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `FK_utilisateur_idTopic` (`idTopic`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aime`
--
ALTER TABLE `aime`
  MODIFY `idTopic` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `idArticle` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `idConversation` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `envoie`
--
ALTER TABLE `envoie`
  MODIFY `idUser` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idMessage` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `publie`
--
ALTER TABLE `publie`
  MODIFY `idArticle` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reference`
--
ALTER TABLE `reference`
  MODIFY `idTag` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rejoint`
--
ALTER TABLE `rejoint`
  MODIFY `idUser` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `idTag` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `topic`
--
ALTER TABLE `topic`
  MODIFY `idTopic` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `travail`
--
ALTER TABLE `travail`
  MODIFY `idTravail` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `travaildans`
--
ALTER TABLE `travaildans`
  MODIFY `idUser` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUser` bigint(8) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `aime`
--
ALTER TABLE `aime`
  ADD CONSTRAINT `FK_aime_idTopic` FOREIGN KEY (`idTopic`) REFERENCES `topic` (`idTopic`),
  ADD CONSTRAINT `FK_aime_idUser` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);

--
-- Contraintes pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `FK_conversation_idMessage` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`);

--
-- Contraintes pour la table `envoie`
--
ALTER TABLE `envoie`
  ADD CONSTRAINT `FK_envoie_idMessage` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`),
  ADD CONSTRAINT `FK_envoie_idUser` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);

--
-- Contraintes pour la table `publie`
--
ALTER TABLE `publie`
  ADD CONSTRAINT `FK_publie_idArticle` FOREIGN KEY (`idArticle`) REFERENCES `article` (`idArticle`),
  ADD CONSTRAINT `FK_publie_idUser` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);

--
-- Contraintes pour la table `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `FK_reference_idTag` FOREIGN KEY (`idTag`) REFERENCES `tag` (`idTag`),
  ADD CONSTRAINT `FK_reference_idTopic` FOREIGN KEY (`idTopic`) REFERENCES `topic` (`idTopic`);

--
-- Contraintes pour la table `rejoint`
--
ALTER TABLE `rejoint`
  ADD CONSTRAINT `FK_rejoint_idConversation` FOREIGN KEY (`idConversation`) REFERENCES `conversation` (`idConversation`),
  ADD CONSTRAINT `FK_rejoint_idUser` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_topic_idArticle` FOREIGN KEY (`idArticle`) REFERENCES `article` (`idArticle`);

--
-- Contraintes pour la table `travaildans`
--
ALTER TABLE `travaildans`
  ADD CONSTRAINT `FK_travaildans_idTravail` FOREIGN KEY (`idTravail`) REFERENCES `travail` (`idTravail`),
  ADD CONSTRAINT `FK_travaildans_idUser` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_utilisateur_idTopic` FOREIGN KEY (`idTopic`) REFERENCES `topic` (`idTopic`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
