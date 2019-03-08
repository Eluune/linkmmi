<?php
  /* page pour gérer le follow entre utilisateur */
  /* data à entrer :
      $_POST['idUser_suit']
      $_POST['idUser_suivit']
  */

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $unfollow = false;
  $follow = false;
  $return = '';

  // on regarde si l'utilisateur courrant suit l'utilisateur sélectionné
  $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit='.$_POST['idUser_suit'].' AND idUser_suivit='.$_POST['idUser_suivit'];
  $resultats=$bdd->query($requete);
  $acceptationSuiviCurrent=$resultats->fetch();
  $resultats->closeCursor();
  // on regarde si l'utilisateur sélectionné suit l'utilisateur currant
  $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit='.$_POST['idUser_suivit'].' AND idUser_suivit='.$_POST['idUser_suit'];
  $resultats=$bdd->query($requete);
  $acceptationSuiviSelected=$resultats->fetch();
  $resultats->closeCursor();

  // si le champ n'existe pas, il est considéré égal à 0
  if(empty($acceptationSuiviCurrent)) { $acceptationSuiviCurrent[0] = 0; }
  if(empty($acceptationSuiviSelected)) { $acceptationSuiviSelected[0] = 0; }

  if($acceptationSuiviCurrent[0]==1 && $acceptationSuiviSelected[0]==1) { $unfollow = true; $return = 'suppression'; }
  if($acceptationSuiviCurrent[0]==0 && ($acceptationSuiviSelected[0]==0 || $acceptationSuiviSelected[0]==1)) { $follow = true; }
  if($acceptationSuiviCurrent[0]==0 && $acceptationSuiviSelected[0]==1) { $return = 'ajout'; }

  if($unfollow)
  {
    $requete = $bdd->prepare("DELETE FROM follow WHERE (idUser_suit = :idUser_suit AND idUser_suivit = :idUser_suivit) || (idUser_suit = :idUser_suivit AND idUser_suivit = :idUser_suit)");
    $requete->bindParam(':idUser_suit', $_POST["idUser_suit"]);
    $requete->bindParam(':idUser_suivit', $_POST["idUser_suivit"]);
    $requete->execute();
  }
  else if($follow)
  {
    if(!empty($acceptationSuiviCurrent))
    {
      $requete = $bdd->prepare("INSERT INTO follow VALUES (:idUser_suit, :idUser_suivit, 1)");
      $requete->bindParam(':idUser_suit', $_POST["idUser_suit"]);
      $requete->bindParam(':idUser_suivit', $_POST["idUser_suivit"]);
      $requete->execute();
    }
    else {
      $requete = $bdd->prepare("UPDATE follow SET acceptationSuivi = 1 WHERE idUser_suit = :idUser_suit AND idUser_suivit = :idUser_suivit");
      $requete->bindParam(':idUser_suit', $_POST["idUser_suit"]);
      $requete->bindParam(':idUser_suivit', $_POST["idUser_suivit"]);
      $requete->execute();
    }
  }

  echo $return;

?>
