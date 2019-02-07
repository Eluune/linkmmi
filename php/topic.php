<?php

  /* ------------------------------------------------------ *\
   * Créer un topic - Edit un topic - Supprimer un topic
  \* ------------------------------------------------------ */

  $date = date("Y-m-d H:i:s");
  $idUser = $_SESSION['id'];

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $requete='SELECT idTag, nomTag FROM tag';
  $resultats=$bdd->query($requete);
  $tags=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  if(isset($_POST['create'])) // /!\ Penser à mettre ça dans le formulaire : enctype="multipart/form-data"
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
    if($_FILES['imgTopic']['error'] == 0)
    {
      if($_FILES['imgTopic']['size'] > 2000000)
      {
          // réduire l'image
      }
      $infosfichier = pathinfo($_FILES['imgTopic']['name']);
      $extension_upload = $infosfichier['extension'];
      $extensions_autorisees = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

      if(in_array($extension_upload, $extensions_autorisees))
      {
        $url = time().''.$_FILES['imgTopic']['name'];
        move_uploaded_file($_FILES['imgTopic']['tmp_name'], 'img/'.basename($url));

        $envoi = true;

        $requete = $bdd->prepare("UPDATE topic SET imgTopic = :imgTopic WHERE idTopic = :idTopic");
        $requete->bindParam(':imgTopic', $url);
        $requete->bindParam(':idTopic', $idTopic[0]);
        $requete->execute();
      }
    }

    // insertion des tags entrés : création des nouveaux tags et référencement du topic
    if(!empty($_POST['tagsTopic']))
    {
      $tagsInit = explode('',$_POST['tagsTopic']);
      $tagsEntres = array_unique($tagsInit);

      foreach($tagsEntres as $newTag)
      {
        $existant = false;
        $increment = 0;
        do
        {
          if($newTag == tags[$increment]->nomTag)
          {
            $existant = true;
            $idTag = tags[$increment]->idTag;
          }
          $increment++;
        }
        while (!$existant && $increment < count($tags));

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

    header('location: /');
    exit;
  }
  else if(isset($_POST['update']))
  {
    // si le contenu est modifié

    // si l'image est modifiée ou ajoutée
  }
  else if(isset($_POST['delete']))
  {
     // on récupère l'idUser du topic à supprimer
    $requete="SELECT idUser FROM topic WHERE idTopic = ".$_GET['idTopic'];
    $resultats=$bdd->query($requete);
    $idAuteur=$resultats->fetch();
    $resultats->closeCursor();
     // on vérifie que l'idUser récupèrée et celle de l'user courant
    if($idAuteur[0] == $idUser)
    {
      $requete = $bdd->prepare("DELETE FROM commentaire WHERE idTopic = :idTopic");
      $requete->bindParam(':idTopic', $_GET['idTopic']);
      $requete->execute();

      $requete = $bdd->prepare("DELETE FROM reference WHERE idTopic = :idTopic");
      $requete->bindParam(':idTopic', $_GET['idTopic']);
      $requete->execute();

      $requete = $bdd->prepare("DELETE FROM topic WHERE idTopic = :idTopic");
      $requete->bindParam(':idTopic', $_GET['idTopic']);
      $requete->execute();
    }
    else
    {
      // on ne peut pas supprimer
    }

    header('location: /');
    exit;
  }
  else
  {
    // si on ne provient d'aucun formulaire
  }

?>
