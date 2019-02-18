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
  */
  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $requete='SELECT * FROM utilisateur WHERE idUser='.$_POST["id"];
  $resultats=$bdd->query($requete);
  $user=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  if($_POST["nom"] != $user[0]->nomUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET nomUser = :nom WHERE idUser = :id");
    $requete->bindParam(':nom', $_POST["nom"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["prenom"] != $user[0]->prenomUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET prenomUser = :prenom WHERE idUser = :id");
    $requete->bindParam(':prenom', $_POST["prenom"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["mail"] != $user[0]->mailUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET mailUser = :mail WHERE idUser = :id");
    $requete->bindParam(':mail', $_POST["mail"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["password"] != $user[0]->passwordUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET passwordUser = :password WHERE idUser = :id");
    $requete->bindParam(':password', $_POST["password"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["description"] != $user[0]->descriptionUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET descriptionUser = :description WHERE idUser = :id");
    $requete->bindParam(':description', $_POST["description"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["birthday"] != $user[0]->birthdayUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET birthdayUser = :birthday WHERE idUser = :id");
    $requete->bindParam(':birthday', $_POST["birthday"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["photo"] != $user[0]->photoUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET photoUser = :photo WHERE idUser = :id");
    $requete->bindParam(':photo', $_POST["photo"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["banniere"] != $user[0]->banniereUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET banniereUser = :banniere WHERE idUser = :id");
    $requete->bindParam(':banniere', $_POST["banniere"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  if($_POST["portfolio"] != $user[0]->portfolioUser)
  {
    $requete = $bdd->prepare("UPDATE utilisateur SET portfolioUser = :portfolio WHERE idUser = :id");
    $requete->bindParam(':portfolio', $_POST["portfolio"]);
    $requete->bindParam(':id', $_POST["id"]);
    $requete->execute();
  }

  $requete='SELECT * FROM utilisateur WHERE idUser='.$_POST["id"];
  $resultats=$bdd->query($requete);
  $userUpdate=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  echo json_encode($userUpdate);
?>
