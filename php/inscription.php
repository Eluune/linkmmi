<?php
session_start();
  /*
  * inscription.php
  * - Récupère les données saisies par l'utilisateur et les stocks dans la bdd
  *   - nom
  *   - prenom
  *   - password
  *   - email
  *   - id
  */

  include("../bdd/config.php");
  include("../bdd/bdd.php");

  // Fonction pour convertir les strings en chaines sans caractères spéciaux ni accents
  function enleverCaracteresSpeciaux($text)
  {
    $utf8 = array(
      '/[áàâãªä]/u' => 'a',
      '/[ÁÀÂÃÄ]/u' => 'A',
      '/[ÍÌÎÏ]/u' => 'I',
      '/[íìîï]/u' => 'i',
      '/[éèêë]/u' => 'e',
      '/[ÉÈÊË]/u' => 'E',
      '/[óòôõºö]/u' => 'o',
      '/[ÓÒÔÕÖ]/u' => 'O',
      '/[úùûü]/u' => 'u',
      '/[ÚÙÛÜ]/u' => 'U',
      '/ç/' => 'c',
      '/Ç/' => 'C',
      '/ñ/' => 'n',
      '/Ñ/' => 'N',
      '/-/' => '', // conversion d'un tiret UTF-8 en un tiret simple
      '/ /' => '', // espace insécable (équiv. à 0x160)
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
  }

  function convertString($text)
  {
    $newtext = enleverCaracteresSpeciaux($text);
    $newtext = strtolower($newtext);
    $newtext = str_replace(" ","",$newtext);

    return $newtext;
  }

  if(isset($_POST["mailUser"]) && isset($_POST["passwordUser"]) && isset($_POST["passwordUser2"]) && isset($_POST["nomUser"]) && isset($_POST["prenomUser"]))
  {
    if($_POST["passwordUser"] == $_POST["passwordUser2"])
    {
      $requete='SELECT mailUser FROM utilisateur WHERE mailUser = "'.$_POST['mailUser'].'"';
      $resultats=$bdd->query($requete);
      $mail=$resultats->fetchAll(PDO::FETCH_OBJ);
      $resultats->closeCursor();

      if(empty($mail))
      {
        $requete = $bdd->prepare("INSERT INTO utilisateur (nomUser, prenomUser, mailUser, passwordUser) VALUES (:nom, :prenom, :mail, :mdp)");
        $requete->bindParam(':nom', trim($_POST["nomUser"]));
        $requete->bindParam(':prenom', trim($_POST["prenomUser"]));
        $requete->bindParam(':mail', trim($_POST["mailUser"]));
        $requete->bindParam(':mdp', $_POST["passwordUser"]);
        $requete->execute();

        $requete='SELECT idUser FROM utilisateur WHERE mailUser = "'.$_POST['mailUser'].'"';
        $resultats=$bdd->query($requete);
        $user=$resultats->fetchAll(PDO::FETCH_OBJ);
        $resultats->closeCursor();

        $id = $user[0]->idUser;
        $atname = convertString($_POST["prenomUser"]).".".convertString($_POST["nomUser"])."#".$id;

        $requete1 = $bdd->prepare("UPDATE utilisateur SET atnameUser = :atname WHERE idUser = :id");
        $requete1->bindParam(':atname', $atname);
        $requete1->bindParam(':id', $id);
        $requete1->execute();

        $_SESSION['id'] = $id;

        header('location:../profil.php');
        exit;
      }
    }
  }

  header('location:../');
  exit;

?>
