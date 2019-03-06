<?php

  // Gère les commentaires
  // Récupère   idTopic
  //

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $date = date("Y-m-d H:i:s");

  if($_POST['ajouter'])
  {
    $requete = $bdd->prepare("INSERT INTO commentaire (contenuCommentaire, dateCommentaire, idTopic, idUser) VALUES (:contenuCommentaire, :dateCommentaire, :idTopic, :idUser)");
    $requete->bindParam(':contenuCommentaire', $_POST["contenuCommentaire"]);
    $requete->bindParam(':dateCommentaire', $date);
    $requete->bindParam(':idTopic', $_POST["idTopic"]);
    $requete->bindParam(':idUser', $_POST["idUser"]);
    $requete->execute();

    $requete='SELECT atnameUser FROM utilisateur WHERE idUser='.$_POST["idUser"];
    $resultats=$bdd->query($requete);
    $atname=$resultats->fetch();
    $resultats->closeCursor();

    echo $atname[0];
  }
  else if($_POST['modifier'])
  {
    $requete = $bdd->prepare("UPDATE commentaire SET contenuCommentaire = :contenuCommentaire, dateCommentaire = :dateCommentaire WHERE idCommentaire = :idCommentaire");
    $requete->bindParam(':contenuCommentaire', $_POST["contenuCommentaire"]);
    $requete->bindParam(':dateCommentaire', $date);
    $requete->execute();
  }
  else if($_POST['supprimer'])
  {
    $requete = $bdd->prepare("DELETE FROM commentaire WHERE idCommentaire = :idCommentaire");
    $requete->bindParam(':idCommentaire', $_SESSION["idCommentaire"]);
    $requete->execute();
  }

?>
