<?php
  /* page pour gérer l'ajout ou la suppression de like */
  /* data à entrer :
      $_POST['idUser']
      $_POST['idPost']
  */

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $requete='SELECT idUser FROM aime WHERE idUser='.$_POST["idUser"].' AND idTopic='.$_POST['idPost'];
  $resultats=$bdd->query($requete);
  $like=$resultats->fetch();
  $resultats->closeCursor();

  if(empty($like))
  {
    $requete = $bdd->prepare("INSERT INTO aime (idUser, idTopic) VALUES (:idUser, :idTopic)");
    $requete->bindParam(':idUser', $_POST["idUser"]);
    $requete->bindParam(':idTopic', $_POST["idPost"]);
    $requete->execute();
  }
  else
  {
    $requete = $bdd->prepare("DELETE FROM aime WHERE (idUser = :idUser AND idTopic = :idTopic)");
    $requete->bindParam(':idUser', $_POST["idUser"]);
    $requete->bindParam(':idTopic', $_POST["idPost"]);
    $requete->execute();
  }

  $requete='SELECT COUNT(idUser) FROM aime WHERE idTopic='.$_POST['idPost'];
  $resultats=$bdd->query($requete);
  $nblike=$resultats->fetch();
  $resultats->closeCursor();

  echo $nblike[0];
?>
