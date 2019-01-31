<?php

  /* ------------------------------------------------------ *\
   * Inscription
  \* ------------------------------------------------------ */
  //
  // idUser* mailUser* passwordUser*
  // nomUser* prenomUser*
  // naissanceUser
  //

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  if(isset($_POST["submit"]) && !empty($_POST["mailUser"]) && !empty($_POST["passwordUser"]) && !empty($_POST["idUser"]) && !empty($_POST["nomUser"]) && !empty($_POST["prenomUser"]))
  {
    $requete = $bdd->prepare("INSERT INTO utilisateur (idUser, nomUser, prenomUser, mailUser, passwordUser) VALUES (:id, :nom, :prenom, :mail, :mdp)");
    $requete->bindParam(':id', $_POST["idUser"]);
    $requete->bindParam(':nom', $_POST["nomUser"]);
    $requete->bindParam(':prenom', $_POST["prenomUser"]);
    $requete->bindParam(':mail', $_POST["mailUser"]);
    $requete->bindParam(':mdp', $_POST["passwordUser"]);
    $requete->execute();
  }

  

?>
