<?php
  /*
  * connexion.php
  * - récupère et compare les données fournies par l'utilisateur et la bdd
  * - retourne une erreur en fonction du cas de figure :
  *       - email éronné
  *       - mot de passe éronné
  * - crée une session en cas de réussite
  */

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  if(!empty($_POST["mailUser"]) && !empty($_POST["passwordUser"]))
  {
    $requete='SELECT idUser, mailUser, passwordUser FROM utilisateur';
    $resultats=$bdd->query($requete);
    $utilisateurs=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();

    $connexion = false;
    $i = 0;
    $erreur = "email";

    do
    {
      if($utilisateurs[$i]->mailUser == $_POST["mailUser"] || $utilisateurs[$i]->idUser == $_POST["mailUser"])
      {
        if($_POST["passwordUser"] == $utilisateurs[$i]->passwordUser)
        {
          session_start();
          $_SESSION["mailUser"] = $utilisateurs[$i]->mailUser;
          $_SESSION["idUser"] = $utilisateurs[$i]->idUser;
          $connexion = true;
        }
        else
        {
          $erreur = "mdp";
        }
      }
      $i++;
    }
    while(!$connexion && $i < count($utilisateurs));

    if($connexion)
    {
      header('Location: ../profil.php');
    }
    else
    {
      header('Location: ../index.php?erreur='.$erreur);
    }
  }
?>
