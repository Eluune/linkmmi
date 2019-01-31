<?php

  /* ------------------------------------------------------ *\
   * Créer un topic - Edit un topic - Supprimer un topic
  \* ------------------------------------------------------ */
  //
  //
  //

  $date = date("Y-m-d H:i:s");

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $requete='SELECT idTag, nomTag FROM tag';
  $resultats=$bdd->query($requete);
  $tags=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  switch ($_POST['submit'])
  {
    case 'create':
        // récupérer dans le formulaire :
          // contenuTopic
          // tagsTopic
          // eventuellement imgTopic

        // fonction pour récupérer l'image et réduire l'image

        $requete = $bdd->prepare("INSERT INTO topic (contenuTopic, dateCommentaire) VALUES (:contenuCommentaire, :dateCommentaire)");
        $requete->bindParam(':contenuCommentaire', $_POST["contenuTopic"]);
        $requete->bindParam(':dateCommentaire', $date);
        $requete->execute();

        $requete = $bdd->prepare("SELECT idTopic WHERE contenuTopic = :contenuCommentaire AND dateCommentaire = :dateCommentaire");
        $requete->bindParam(':contenuCommentaire', $_POST["contenuTopic"]);
        $requete->bindParam(':dateCommentaire', $date);
        $resultats=$bdd->query($requete);
        $idTopic=$resultats->fetch();
        $resultats->closeCursor();

        if(!empty($_POST['tags']))
        {
          $tagsInit = explod('',$_POST['tags']);
          $tagsEntres = array_unique($tagsInit);

          foreach($tagsEntres as $newTag)
          {
            $existant = false;
            $increment = 0;
            do
            {
              if($tagsEntres == tags[$increment]->nomTag)
              {
                $existant = true;
                $idTag = tags[$increment]->idTag;
              }
              $increment++;
            }
            while (!$existant || $increment < count($tags));
            
            if(!$existant)
            {
              $requete = $bdd->prepare("INSERT INTO tag (nomTag) VALUES (:nomTag)");
              $requete->bindParam(':nomTag', $newTag);
              $requete->execute();

              $requete='SELECT idTag FROM tag WHERE nomTag = "$newTag"';
              $resultats=$bdd->query($requete);
              $valIdTag=$resultats->fetch();
              $resultats->closeCursor();

              $idTag = $valIdTag[0];
            }

            $requete = $bdd->prepare("INSERT INTO reference (idTag, idTopic) VALUES (:idTag, :idTopic)");
            $requete->bindParam(':idTag', $idTag);
            $requete->bindParam(':idTopic', $idTopic[0]);
            $requete->execute();
          }
        }

      break;

    case 'edit':

      break;

    case 'delete':

      break;
  }

?>
