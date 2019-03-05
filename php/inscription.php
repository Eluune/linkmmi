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

  if(isset($_POST["mailUser"]) && !empty($_POST["mailUser"]) && !empty($_POST["passwordUser"]) && !empty($_POST["nomUser"]) && !empty($_POST["prenomUser"]))
  {
    $requete = $bdd->prepare("INSERT INTO utilisateur (nomUser, prenomUser, mailUser, passwordUser) VALUES (:nom, :prenom, :mail, :mdp)");
    $requete->bindParam(':nom', $_POST["nomUser"]);
    $requete->bindParam(':prenom', $_POST["prenomUser"]);
    $requete->bindParam(':mail', $_POST["mailUser"]);
    $requete->bindParam(':mdp', $_POST["passwordUser"]);
    $requete->execute();

    $requete='SELECT idUser FROM utilisateur WHERE mailUser = "'.$_POST['mailUser'].'"';
    $resultats=$bdd->query($requete);
    $user=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();

    $id = $user[0]->idUser;
    $atname = $_POST["prenomUser"].".".$_POST["nomUser"]."#".$id;

    $requete1 = $bdd->prepare("UPDATE utilisateur SET atnameUser = :atname WHERE idUser = :id");
    $requete1->bindParam(':atname', $atname);
    $requete1->bindParam(':id', $id);
    $requete1->execute();

    echo("inscrit");
  }
  else
  {
    echo("probleme");
  }
?>
