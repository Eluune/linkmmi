<?php
  /*
  * inscription.php
  * - Récupère les données saisies par l'utilisateur et les stocks dans la bdd
  *   - nom
  *   - prenom
  *   - password
  *   - email
  *   - id
  */

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  if(isset($_POST["submit"]) && !empty($_POST["mailUser"]) && !empty($_POST["passwordUser"]) && !empty($_POST["idUser"]) && !empty($_POST["nomUser"]) && !empty($_POST["prenomUser"]))
  {
    $requete = $bdd->prepare("INSERT INTO utilisateur (idUser, nomUser, prenomUser, mailUser, passwordUser, atnameUser) VALUES (:id, :nom, :prenom, :mail, :mdp, :atname)");
    $requete->bindParam(':id', $_POST["idUser"]);
    $requete->bindParam(':nom', $_POST["nomUser"]);
    $requete->bindParam(':prenom', $_POST["prenomUser"]);
    $requete->bindParam(':mail', $_POST["mailUser"]);
    $requete->bindParam(':mdp', $_POST["passwordUser"]);
    $requete->bindParam(':atname', $_POST["prenomUser"].".".$_POST["nomUser"]."#".$_POST["idUSer"]);
    $requete->execute();
  }

?>
