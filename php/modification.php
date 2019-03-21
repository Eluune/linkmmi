<?php
session_start();
  /*
  * modification.php
  * - Récupère les données saisies par l'utilisateur et update les données existantes dans la bdd
        mailUser CHAR(100),
        passwordUser CHAR(100),
        prenomUser CHAR(100),
        nomUser CHAR(100),
        descriptionUser TEXT,
        birthdayUser DATE,
        photoUser CHAR(100),
        banniereUser CHAR(100),
        portfolioUser CHAR(100),

        DROP TABLE IF EXISTS travail ;
        CREATE TABLE travail (idTravail BIGINT(8) AUTO_INCREMENT NOT NULL,
        villeTravail CHAR(100),
        nomTravail TEXT,
        intituleTravail TEXT,
        PRIMARY KEY (idTravail)) ENGINE=InnoDB;

        DROP TABLE IF EXISTS travaildans ;
        CREATE TABLE travaildans (idUser BIGINT(8) AUTO_INCREMENT NOT NULL,
        idTravail BIGINT(8) NOT NULL,
        debutTravail DATE,
        finTravail DATE,
        PRIMARY KEY (idUser,idTravail)) ENGINE=InnoDB;
  */
  include("../bdd/config.php");
  include("../bdd/bdd.php");

  $url_users = '../img/users/';
  $url_bannieres = '../img/bannieres/';

  if(!empty($_SESSION['id'] && $_SESSION['id']!=-1))
  {
    $requete='SELECT * FROM utilisateur WHERE idUser='.$_SESSION["id"];
    $resultats=$bdd->query($requete);
    $user=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();

    if(isset($_POST['infosClassiques']))
    {

      if($_POST["prenomUser"] != $user[0]->prenomUser)
      {
        $requete = $bdd->prepare("UPDATE utilisateur SET prenomUser = :prenom WHERE idUser = :id");
        $requete->bindParam(':prenom', $_POST["prenomUser"]);
        $requete->bindParam(':id', $_SESSION["id"]);
        $requete->execute();
      }

      if($_POST["nomUser"] != $user[0]->nomUser)
      {
        $requete = $bdd->prepare("UPDATE utilisateur SET nomUser = :nom WHERE idUser = :id");
        $requete->bindParam(':nom', $_POST["nomUser"]);
        $requete->bindParam(':id', $_SESSION["id"]);
        $requete->execute();
      }

      if($_POST["birthdayUser"] != $user[0]->birthdayUser)
      {
        $requete = $bdd->prepare("UPDATE utilisateur SET birthdayUser = :birthday WHERE idUser = :id");
        $requete->bindParam(':birthday', $_POST["birthdayUser"]);
        $requete->bindParam(':id', $_SESSION["id"]);
        $requete->execute();
      }

      if($_POST["portfolioUser"] != $user[0]->portfolioUser)
      {
        $requete = $bdd->prepare("UPDATE utilisateur SET portfolioUser = :portfolio WHERE idUser = :id");
        $requete->bindParam(':portfolio', $_POST["portfolioUser"]);
        $requete->bindParam(':id', $_SESSION["id"]);
        $requete->execute();
      }

      if($_POST["descriptionUser"] != $user[0]->descriptionUser)
      {
        $requete = $bdd->prepare("UPDATE utilisateur SET descriptionUser = :description WHERE idUser = :id");
        $requete->bindParam(':description', $_POST["descriptionUser"]);
        $requete->bindParam(':id', $_SESSION["id"]);
        $requete->execute();
      }

    }
    else if(isset($_POST['infosImages']))
    {

      $extensions_autorisees = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

      if(isset($_FILES['photoUser']) AND $_FILES['photoUser']['error'] == 0){
        if($_FILES['photoUser']['size'] <= 10000000){
          $infosfichier = pathinfo($_FILES['photoUser']['name']);
          $extension_upload = $infosfichier['extension'];

          if(in_array($extension_upload, $extensions_autorisees)){
            if(!empty($user[0]->photoUser)){
                unlink ($url_users.$user[0]->photoUser);
            }

            $url = time().''.$_FILES['photoUser']['name'];
            move_uploaded_file($_FILES['photoUser']['tmp_name'], $url_users . basename($url));

            $requete = $bdd->prepare("UPDATE utilisateur SET photoUser = :photo WHERE idUser = :id");
            $requete->bindParam(':photo', $url);
            $requete->bindParam(':id', $_SESSION["id"]);
            $requete->execute();
          }
        }
      }

      if(isset($_FILES['banniereUser']) AND $_FILES['banniereUser']['error'] == 0){
        if($_FILES['banniereUser']['size'] <= 10000000){
          $infosfichier = pathinfo($_FILES['banniereUser']['name']);
          $extension_upload = $infosfichier['extension'];

          if(in_array($extension_upload, $extensions_autorisees)){
            if(!empty($user[0]->banniereUser)){
                unlink ($url_bannieres.$user[0]->banniereUser);
            }

            $url = time().''.$_FILES['banniereUser']['name'];
            move_uploaded_file($_FILES['banniereUser']['tmp_name'], $url_bannieres . basename($url));

            $requete = $bdd->prepare("UPDATE utilisateur SET banniereUser = :photo WHERE idUser = :id");
            $requete->bindParam(':photo', $url);
            $requete->bindParam(':id', $_SESSION["id"]);
            $requete->execute();
          }
        }
      }
    }
    else if(isset($_POST['infosTravails']))
    {
      $increment = 0;
      for($i=0; $i<$_POST['nbOldTravails']; $i++)
      {
        $increment++;
        $find = false;

        do
        {
          if(!empty($_POST['id-'.$increment]))
          {
            $find = true;

            $requete='SELECT travaildans.idTravailDans AS "id", travaildans.debutTravail AS "debutTravail", travaildans.finTravail AS "finTravail", travail.villeTravail AS "villeTravail", travail.entrepriseTravail AS "entrepriseTravail", travaildans.fonctionTravail AS "fonctionTravail"
                      FROM travaildans, travail
                      WHERE travaildans.idTravail = '.$_POST["id-".$increment].'
                      ORDER BY travaildans.debutTravail DESC';
            $resultats=$bdd->query($requete);
            $travail=$resultats->fetchAll(PDO::FETCH_OBJ);
            $resultats->closeCursor();

            if($_POST['debutTravail-'.$increment] != $travail[0]->debutTravail)
            {
              $requete = $bdd->prepare("UPDATE travaildans SET debutTravail = :debutTravail WHERE idTravailDans = :id");
              $requete->bindParam(':debutTravail', $_POST['debutTravail-'.$increment]);
              $requete->bindParam(':id', $_POST["id-".$increment]);
              $requete->execute();
            }

            if($_POST['finTravail-'.$increment] != $travail[0]->debutTravail)
            {
              $requete = $bdd->prepare("UPDATE travaildans SET finTravail = :finTravail WHERE idTravailDans = :id");
              $requete->bindParam(':finTravail', $_POST['finTravail-'.$increment]);
              $requete->bindParam(':id', $_POST["id-".$increment]);
              $requete->execute();
            }

            if($_POST['fonctionTravail-'.$increment] != $travail[0]->fonctionTravail)
            {
              $requete = $bdd->prepare("UPDATE travaildans SET fonctionTravail = :fonctionTravail WHERE idTravailDans = :id");
              $requete->bindParam(':fonctionTravail', $_POST['fonctionTravail-'.$increment]);
              $requete->bindParam(':id', $_POST["id-".$increment]);
              $requete->execute();
            }

            if($_POST['entrepriseTravail-'.$increment] != $travail[0]->entrepriseTravail || $_POST['villeTravail-'.$increment] != $travail[0]->villeTravail)
            {
              $requete='SELECT idTravail
                        FROM travail
                        WHERE entrepriseTravail = "'.$travail[0]->entrepriseTravail.'" AND villeTravail = "'.$travail[0]->villeTravail.'"';
              $resultats=$bdd->query($requete);
              $entreprise=$resultats->fetchAll(PDO::FETCH_OBJ);
              $resultats->closeCursor();

              if(empty($entreprise))
              {
                $requete = $bdd->prepare("INSERT INTO travail (entrepriseTravail, villeTravail) VALUES (:entreprise, :ville)");
                $requete->bindParam(':entreprise', $_POST["entrepriseTravail-".$increment]);
                $requete->bindParam(':ville', $_POST["villeTravail-".$increment]);
                $requete->execute();

                $requete='SELECT idTravail
                          FROM travail
                          WHERE entrepriseTravail = "'.$travail[0]->entrepriseTravail.'" AND villeTravail = "'.$travail[0]->villeTravail.'"';
                $resultats=$bdd->query($requete);
                $entreprise=$resultats->fetchAll(PDO::FETCH_OBJ);
                $resultats->closeCursor();
              }

              $requete = $bdd->prepare("UPDATE travaildans SET idTravail = :idTravail WHERE idTravailDans = :id");
              $requete->bindParam(':idTravail', $entreprise[0]->idTravail);
              $requete->bindParam(':id', $_POST["id-".$increment]);
              $requete->execute();
            }
          }
          else
          {
            $increment++;
          }
        } while (!$find);
      }

    }
    else if(isset($_POST['removeTravail']))
    {
      $requete = $bdd->prepare("DELETE FROM travaildans WHERE idTravailDans = :idTravailDans");
      $requete->bindParam(':idTravailDans', $_POST["idTravailDans"]);
      $requete->execute();
    }
    else if(isset($_POST['infosPrivees']))
    {

      if($_POST["mailUser"] != $user[0]->mailUser)
      {
        $requete = $bdd->prepare("UPDATE utilisateur SET mailUser = :mail WHERE idUser = :id");
        $requete->bindParam(':mail', $_POST["mailUser"]);
        $requete->bindParam(':id', $_SESSION["id"]);
        $requete->execute();
      }

      if($_POST["passwordOld"] == $user[0]->passwordUser)
      {
        if(!empty($_POST['passwordNew']))
        {
          $requete = $bdd->prepare("UPDATE utilisateur SET passwordUser = :password WHERE idUser = :id");
          $requete->bindParam(':password', $_POST["passwordNew"]);
          $requete->bindParam(':id', $_SESSION["id"]);
          $requete->execute();
        }
      }

    }
  }

  header('location:../profil.php');
  exit;
?>
