<?php

  // Gère les commentaires
  // Récupère   idTopic
  //

  $date = date("Y-m-d H:i:s");

  switch($_POST["submit"])
  {
    case "ajouter":

      $requete = $bdd->prepare("INSERT INTO commentaire (idCommentaire, contenuCommentaire, dateCommentaire) VALUES (:idCommentaire, :contenuCommentaire, :dateCommentaire)");
      $requete->bindParam(':idCommentaire', $_POST["idCommentaire"]);
      $requete->bindParam(':contenuCommentaire', $_POST["contenuCommentaire"]);
      $requete->bindParam(':dateCommentaire', $date);
      $requete->execute();

    break;

    case "modifier":

      $requete = $bdd->prepare("UPDATE commentaire SET contenuCommentaire = :contenuCommentaire, dateCommentaire = :dateCommentaire WHERE idCommentaire = :idCommentaire");
      $requete->bindParam(':contenuCommentaire', $_POST["contenuCommentaire"]);
      $requete->bindParam(':dateCommentaire', $date);
      $requete->execute();

    break;

    case "supprimer":

      $requete = $bdd->prepare("DELETE FROM commentaire WHERE idCommentaire = :idCommentaire");
      $requete->bindParam(':idCommentaire', $_SESSION["idCommentaire"]);
      $requete->execute();

    break;
  }

?>
