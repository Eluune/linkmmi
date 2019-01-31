<?php

  if(!isset($_POST["recherche"]))
  {
    if(strpos($_POST["@"]))
    {
      $requete='SELECT idUser FROM utilisateur';
      $resultats=$bdd->query($requete);
      $utilisateurs=$resultats->fetchAll(PDO::FETCH_OBJ);
      $resultats->closeCursor();

      $i = 0;
      $continue = true;
      $autocomplete = array();

      do
      {
        if(stristr($_POST["recherche"], $utilisateurs[$i]->idUser))
        {
          array_push($utilisateurs[$i]->idUser);
        }

        $i++;
      } while($continue || $index < count($utilisateurs));
    }
    else if(strpos($_POST["#"]))
    {

    }
    else
    {

    }
  }

?>
