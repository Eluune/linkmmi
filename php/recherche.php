<?php

  $requete='SELECT nomTag FROM tag WHERE nomTag LIKE '.$_POST["recherche"];
  $resultats=$bdd->query($requete);
  $tags=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $requete='SELECT idUser FROM utilisateur WHERE idUser LIKE '.$_POST["recherche"];
  $resultats=$bdd->query($requete);
  $users=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  if(isset($_POST["recherche"]))
  {
    if(!empty($_POST["recherche"]))
    {

      if(stristr($_POST["recherche"], "@"))
      {
        for($i = 0 ; $i < count($tags) ; $i++)
        {
          if(stristr($tags[$i], $_POST["recherche"])) { echo($tags[$i]." "); }
        }
      }
      else if(stristr($_POST["recherche"], "#"))
      {
        for($i = 0 ; $i < count($users) ; $i++)
        {
          if(stristr($users[$i], $_POST["recherche"])) { echo($users[$i]." "); }
        }
      }
      else
      {
        for($i = 0 ; $i < count($tags) ; $i++)
        {
          if(stristr($tags[$i], $_POST["recherche"])) { echo($tags[$i]." "); }
        }
        for($i = 0 ; $i < count($users) ; $i++)
        {
          if(stristr($users[$i], $_POST["recherche"])) { echo($users[$i]." "); }
        }
      }
    }
    else
    {
      echo("");
    }
  }
  else
  {
    echo("");
  }

?>
