<?php
  include("../bdd/config.php");
  include("../bdd/bdd.php");

  if(isset($_POST["submit"]) && !empty($_POST["mailUser"]) && !empty($_POST["passwordUser"]))
  {
    $requete='SELECT * FROM utilisateur';
    $resultats=$bdd->query($requete);
    $utilisateurs=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();

    $connexion = false;
    $finish = 0;
    $erreur = "Email éronné";

    do
    {
      if($utilisateurs[$i]->mailUser == $_POST["mailUser"] || $utilisateurs[$i]->idUser == $_POST["mailUser"])
      {
        if(password_verify($_POST["passwordUser"], $utilisateurs[$i]->passwordUser))
        {
          session_start();
          $_SESSION["mailUser"] = $utilisateurs[$i]->mailUser;
          $_SESSION["idUser"] = $utilisateurs[$i]->idUser;
          $connexion = true;
        }
        else
        {
          $erreur = "Mot de passe éronné";
        }
      }
      $finish++;
    }
    while(!$connexion || $finish < count($utilisateurs));

    if($connexion) { echo("connecté"); }
    else { echo($erreur); }
  }

?>
