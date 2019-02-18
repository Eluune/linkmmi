<?php
  /*
  * modification.php
  * - Récupère les données saisies par l'utilisateur et update les données existantes dans la bdd
        mailUser CHAR(100),
        passwordUser CHAR(100),
        prenomUser CHAR(100),
        nomUser CHAR(100),
        descriptionUser TEXT,
        birthdayUser DATE,
        photoUser CHAR(100),
        banniereUser CHAR(100),
        portfolioUser CHAR(100),

        DROP TABLE IF EXISTS travail ;
        CREATE TABLE travail (idTravail BIGINT(8) AUTO_INCREMENT NOT NULL,
        villeTravail CHAR(100),
        nomTravail TEXT,
        intituleTravail TEXT,
        PRIMARY KEY (idTravail)) ENGINE=InnoDB;

        DROP TABLE IF EXISTS travaildans ;
        CREATE TABLE travaildans (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
        idTravail BIGINT(8) NOT NULL,
        debutTravail DATE,
        finTravail DATE,
        PRIMARY KEY (idUser,idTravail)) ENGINE=InnoDB;
  */

  $requete='SELECT * FROM utilisateur WHERE idUser='.$_POST["id"];
  $resultats=$bdd->query($requete);
  $user=$resultats->fetch(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $requete='SELECT travaildans.idTravail, travaildans.idUser, villeTravail, nomTravail, intituleTravail, debutTravail, finTravail FROM utilisateur, travail, travaildans WHERE utilisateur.idUser='.$_POST["id"].' AND travaildans.idUser='.$_POST["id"].' AND travaildans.idTravail = travail.idTravail';
  $resultats=$bdd->query($requete);
  $travail=$resultats->fetch(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  for($i = 0 ; $i < count($travail) ; $i++)
  {
    if(isset($_POST["idTravail"]))
    {
      // pas fini
    }
  }

  if($_POST["nom"] != $user->nomUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET nomUser = :nom WHERE idUser = :id");
    $requete->bindParam(':nom', $_POST["nom"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["nom"] != $user->nomUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET nomUser = :nom WHERE idUser = :id");
    $requete->bindParam(':nom', $_POST["nom"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["prenom"] != $user->prenomUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET prenomUser = :prenom WHERE idUser = :id");
    $requete->bindParam(':prenom', $_POST["prenom"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["mail"] != $user->mailUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET mailUser = :mail WHERE idUser = :id");
    $requete->bindParam(':mail', $_POST["mail"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["password"] != $user->passwordUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET passwordUser = :password WHERE idUser = :id");
    $requete->bindParam(':password', $_POST["password"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["description"] != $user->descriptionUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET descriptionUser = :description WHERE idUser = :id");
    $requete->bindParam(':description', $_POST["description"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["birthday"] != $user->birthdayUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET birthdayUser = :birthday WHERE idUser = :id");
    $requete->bindParam(':birthday', $_POST["birthday"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["photo"] != $user->photoUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET photoUser = :photo WHERE idUser = :id");
    $requete->bindParam(':photo', $_POST["photo"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["banniere"] != $user->banniereUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET banniereUser = :banniere WHERE idUser = :id");
    $requete->bindParam(':banniere', $_POST["banniere"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["portfolio"] != $user->portfolioUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET portfolioUser = :portfolio WHERE idUser = :id");
    $requete->bindParam(':portfolio', $_POST["portfolio"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }




?>
