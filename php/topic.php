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

  if(isset($_POST['create']))
  {
    // récupérer dans le formulaire :
      // contenuTopic
      // tagsTopic
      // eventuellement imgTopic

    $requete = $bdd->prepare("INSERT INTO topic (contenuTopic, dateTopic, idUser) VALUES (:contenuTopic, :dateTopic, :idUser)");
    $requete->bindParam(':contenuTopic', $_POST["contenuTopic"]);
    $requete->bindParam(':dateTopic', $date);
    $requete->bindParam(':idUser', $idUser);
    $requete->execute();

    $requete="SELECT idTopic FROM topic WHERE idUser = ".$idUser." AND dateTopic = '".$date."'";
    $resultats=$bdd->query($requete);
    $idTopic=$resultats->fetch();
    $resultats->closeCursor();

    // insérer les images
    $envoi = false;
    if(isset($_FILES['image']) AND $_FILES['image']['error'] == 0){
      if($_FILES['image']['size'] <= 100000){
        $infosfichier = pathinfo($_FILES['image']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

        if(in_array($extension_upload, $extensions_autorisees)){
          $url = time().''.$_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'], 'img/recettes/' . basename($url));

          $envoi = true;

          $requete = $bdd->prepare("INSERT INTO tag (photoUser) VALUES (:photoUSer)");
          $requete->bindParam(':photoUser', $url);
          $requete->execute();
        }
      }
    }

    // insérer les tags
    if(!empty($_POST['tags']))
    {
      $tagsInit = explode('',$_POST['tags']);
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

          $requete="SELECT idTag FROM tag WHERE nomTag = '".$newTag."'";
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
  }

  if(isset($_POST['update']))
  {

  }

  if(isset($_POST['delete']))
  {

  }

?>
