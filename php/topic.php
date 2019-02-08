<?php

  /* ------------------------------------------------------ *\
   * Créer un topic - Edit un topic - Supprimer un topic
  \* ------------------------------------------------------ */

  /* DONNÉES À RÉCUPÉRER */
  /* CREATE  /!\ Penser à mettre ça dans le formulaire : enctype="multipart/form-data"
        Depuis formulaire methode = POST
            contenuTopic
            tagsTopic
            imgTopic */
  /* UPDATE  /!\ Penser à mettre ça dans le formulaire : enctype="multipart/form-data"
        Depuis formulaire methode = POST
            idTopic
            contenuTopic
            imgTopic /*
  /* DELETE
      Depuis l'url (Get)
            idTopic */

  $date = date("Y-m-d H:i:s");
  $idUser = $_SESSION['id']; // id utilisateur
  $folder = './img/'; // lien du fichier qui reçoit l'image
  $homePage = '../index.php'; //  lien de la page d'accueil

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $requete='SELECT idTag, nomTag FROM tag';
  $resultats=$bdd->query($requete);
  $tags=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  if(isset($_POST['create']))
  {
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
      if($_FILES['imgTopic']['size'] < 1000000)
      {
        $infosfichier = pathinfo($_FILES['imgTopic']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

        if(in_array($extension_upload, $extensions_autorisees))
        {
          $url = time().''.$_FILES['imgTopic']['name'];
          move_uploaded_file($_FILES['imgTopic']['tmp_name'], $folder.basename($url));

          $requete = $bdd->prepare("UPDATE topic SET imgTopic = :imgTopic WHERE idTopic = :idTopic");
          $requete->bindParam(':imgTopic', $url);
          $requete->bindParam(':idTopic', $idTopic[0]);
          $requete->execute();
        }
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

    header('location: '.$homePage);
    exit;
  }
  else if(isset($_POST['update']))
  {
    $requete="SELECT contenuTopic, imgTopic FROM topic WHERE idTopic = ".$_GET['idTopic'];
    $resultats=$bdd->query($requete);
    $topicInit=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();
    // si le contenu est modifié
    if($topicInit[0]->contenuTopic != $_POST['contenuTopic'] &&)
    {
      $requete = $bdd->prepare("UPDATE topic SET contenuTopic = :contenuTopic, editTopic = :editTopic WHERE idTopic = :idTopic");
      $requete->bindParam(':contenuTopic', $_POST['contenuTopic']);
      $requete->bindParam(':editTopic', $date);
      $requete->bindParam(':idTopic', $_POST['idTopic']);
      $requete->execute();
    }

    // supprime l'image qui existait déjà puis ajoute la nouvelle image
    if($topicInit[0]->imgTopic != 'NULL'){
      unlink($folder.$topicInit[0]->imgTopic);
    }
    if($_FILES['imgTopic']['error'] == 0)
    {
      if($_FILES['imgTopic']['size'] < 1000000)
      {
        $infosfichier = pathinfo($_FILES['imgTopic']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

        if(in_array($extension_upload, $extensions_autorisees))
        {
          $url = time().''.$_FILES['imgTopic']['name'];
          move_uploaded_file($_FILES['imgTopic']['tmp_name'], $folder.basename($url));

          $requete = $bdd->prepare("UPDATE topic SET imgTopic = :imgTopic WHERE idTopic = :idTopic");
          $requete->bindParam(':imgTopic', $url);
          $requete->bindParam(':idTopic', $idTopic[0]);
          $requete->execute();
        }
      }
    }

    header('location: '.$homePage);
    exit;
  }
  else if(isset($_POST['delete']))
  {
    // on récupère l'idUser du topic à supprimer
    $requete="SELECT idUser, imgTopic FROM topic WHERE idTopic = ".$_GET['idTopic'];
    $resultats=$bdd->query($requete);
    $infosTopic=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();
    // on vérifie que l'idUser récupèrée et celle de l'user courant
    if($infosTopic[0]->idUser == $idUser)
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

      if($infosTopic[0]->imgTopic != 'NULL'){
        unlink($folder.$infosTopic[0]->imgTopic);
      }
    }
    else
    {
      // retourne erreur : vous ne pouvez pas supprimer ce topic
      header('location: '.$homePage?'?erreur=user');
      exit;
    }
    header('location: '.$homePage.'?delete=ok'); // le topic a bien été supprimé
    exit;
  }

?>
