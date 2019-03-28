<?php
session_start();

  include("bdd/config.php");
  include("bdd/bdd.php");

  // tableau avec les mois de l'année
  $months = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
  // fuseau horraire pour les dates
  $tz = new DateTimeZone('Europe/Paris');

  $url_posts = 'img/posts/';
  $url_users = 'img/users/';
  $url_bannieres = 'img/bannieres/';

  $connected = false;

  if(!empty($_SESSION['id']))
  {
    if($_SESSION['id'] != -1)
    {
      //récupération des informations de l'utilisateur courant
      $requete='SELECT * FROM utilisateur WHERE idUser='.$_SESSION["id"];
      $resultats=$bdd->query($requete);
      $current_user=$resultats->fetchAll(PDO::FETCH_OBJ);
      $resultats->closeCursor();

      if(!empty($current_user))
      {
        $connected = true;

        $atname = explode('#',$current_user[0]->atnameUser);

        // récupération des informations relations utilisateur
        $requete='SELECT idUser_suivit FROM follow WHERE idUser_suit='.$_SESSION['id'].' AND acceptationSuivi = 1';
        $resultats=$bdd->query($requete);
        $userTest=$resultats->fetchAll(PDO::FETCH_OBJ);
        $resultats->closeCursor();

        $userSuivi = 0;

        foreach($userTest as $test){
          $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit='.$test->idUser_suivit.' AND idUser_suivit='.$_SESSION['id'].' AND acceptationSuivi = 1';
          $resultats=$bdd->query($requete);
          $userTestApprobation=$resultats->fetch();
          $resultats->closeCursor();

          if(!empty($userTestApprobation)) { $userSuivi++; }
        }

        // récupération des informations posts utilisateur
        $requete='SELECT count(topic.idTopic) AS "nbPosts"
                  FROM topic, utilisateur
                  WHERE topic.idUser='.$_SESSION['id'].' AND topic.idUser = utilisateur.idUser';
        $resultats=$bdd->query($requete);
        $posts_users=$resultats->fetchAll(PDO::FETCH_OBJ);
        $resultats->closeCursor();
      }
    }
  }

  // récupération des informations posts utilisateur
  $requete='SELECT topic.idTopic AS "id", topic.contenuTopic AS "contenu", topic.imgTopic AS "imgTopic", topic.dateTopic AS "date", utilisateur.prenomUser AS "prenom", utilisateur.nomUser AS "nom", utilisateur.atnameUser AS "atname", utilisateur.photoUser AS "imgUser"
            FROM topic, utilisateur
            WHERE topic.idUser = utilisateur.idUser
            GROUP BY topic.idTopic
            ORDER BY topic.dateTopic DESC';
  $resultats=$bdd->query($requete);
  $posts=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- Bibliothèques -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- Meta tag -->
  <meta charset="UTF-8">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Linkmmi - Le réseau social des MMI</title>

  <!-- Links -->
  <link rel="stylesheet" href="css/style.min.css">
  <?php if($connected){ ?> <link rel="stylesheet" href="css/style-nav&post.min.css"> <?php } ?>
  <link rel="stylesheet" type="text/css" media="screen" href="icofont/icofont.min.css">
</head>

<body>
  <?php if($connected) { include('php/nav.php'); echo '<div style="height: 60px;"></div>';  } ?>

  <div class="section-connexion">

    <div class="section-left">
      <?php
        if(!$connected)
        {
          ?>
          <div class="connexion">
            <div class="information">
              <h1>Connexion</h1>
              <a href="#" id="inscript" class="animUnderline">Inscription</a>

              <form action="php/connexion.php" method="post">
                <input type="text" name="mailUser" placeholder="Login">
                <br>
                <input type="password" name="passwordUser" placeholder="Mot de passe">
                <br>
                <input type="submit" value="Connexion">
              </form>
            </div> <!-- Fermeture .information -->
          </div> <!-- Fermeture .connexion -->
          <?php
        }
        else
        {
          ?>
            <!-- contenu des informations du profil -->
            <div class="profil">
              <div class="profilPictContainer">
                <?php
                  if(!empty($current_user[0]->photoUser) && $current_user[0]->photoUser != 'NULL') { ?> <img src="<?php echo $url_users.$current_user[0]->photoUser; ?>" class="profilPict"> <?php }
                  else { ?> <img src="img-placeholder/bestLoutre.jpg" class="profilPict"> <?php }
                ?>
              </div>
              <div class="contentProfil">
                <div class="descProfil">
                  <h3><?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?><br><em class="highLight">@<?php echo $atname[0]; ?></em></h3>

                  <div class="containerProfilNul">
                    <div class="profilNum">
                      <span class="textFolower">Relation<?php if($userSuivi>1){ ?>s<?php } ?></span>
                      <br>
                      <em id="nbFollower" class="highLight"><?php echo $userSuivi; ?></em>
                    </div>
                    <div class="profilNum">
                      <span>Publication<?php if($posts_users[0]->nbPosts>1){ ?>s<?php } ?></span>
                      <br>
                      <em class="highLight"><?php echo $posts_users[0]->nbPosts; ?></em>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- fin informations du profil -->
          <?php
        }
      ?>
    </div> <!-- Fermeture .section-left -->

    <div class="section-center">
      <?php if($connected){ include('php/post.php'); } ?>
      <?php
        foreach ($posts as $post) {

          // récupération des informations likes post
          $requete='SELECT idUser FROM aime WHERE idTopic='.$post->id;
          $resultats=$bdd->query($requete);
          $likes=$resultats->fetchAll(PDO::FETCH_OBJ);
          $resultats->closeCursor();

          if($connected)
          {
            // récupération information : user a liké le post
            $requete='SELECT idUser FROM aime WHERE idUser='.$current_user[0]->idUser.' AND idTopic='.$post->id;
            $resultats=$bdd->query($requete);
            $likeExiste=$resultats->fetch();
            $resultats->closeCursor();
          }

          // récupération des informations commentaires post
          $requete='SELECT commentaire.contenuCommentaire AS "contenu", utilisateur.prenomUser AS "prenom", utilisateur.nomUser AS "nom", utilisateur.atnameUser AS "atname", utilisateur.photoUser AS "imgUser"
                    FROM commentaire, utilisateur
                    WHERE commentaire.idTopic='.$post->id.' AND commentaire.idUser = utilisateur.idUser
                    ORDER BY commentaire.dateCommentaire ASC';
          $resultats=$bdd->query($requete);
          $commentaires=$resultats->fetchAll(PDO::FETCH_OBJ);
          $resultats->closeCursor();

          // récupération des informations références post
          $requete='SELECT tag.idTag AS "id", tag.nomTag AS "tag"
                    FROM tag, reference
                    WHERE reference.idTopic='.$post->id.' AND reference.idTag = tag.idTag';
          $resultats=$bdd->query($requete);
          $references=$resultats->fetchAll(PDO::FETCH_OBJ);
          $resultats->closeCursor();

          $dateTopic = new DateTime($post->date, $tz);
          $date = $dateTopic->format('H\hi').' le '.intval($dateTopic->format('d')).' '.$months[intval($dateTopic->format('m'))-1].' '.$dateTopic->format('Y');

          ?>
            <div class="actualitées" data-number="<?php echo $post->id; ?>">
              <div class="utilisateur">

                <figure class="photo-utilisateur">
                  <?php
                    if(!empty($post->imgUser) && $post->imgUser != 'NULL') { ?> <img src="<?php echo $url_users.$post->imgUser; ?>" class="authorPict" alt="Photo de profil de <?php echo $post->prenom.' '.$post->nom; ?>"> <?php }
                    else { ?> <img src="img-placeholder/bestLoutre.jpg" class="authorPict" alt="Photo de profil de <?php echo $post->prenom.' '.$post->nom; ?>"> <?php }
                  ?>
                  <figcaption>
                    <a href="profil.php?user=<?php echo explode('#',$post->atname)[1]; ?>"></a>
                  </figcaption>
                </figure> <!-- Fermeture .photo-utilisateur -->

                <div class="info-utilisateur">
                  <h2><?php echo $post->prenom.' '.$post->nom; ?></h2>
                  <a href="profil.php?user=<?php echo explode('#',$post->atname)[1]; ?>">@<?php echo explode('#',$post->atname)[0]; ?></a>
                </div> <!-- Fermeture .info-utilisateur -->

              </div> <!-- Fermeture .utilisateur -->

              <p class="content-actualité">
                <?php
                  echo $post->contenu.'<br>';
                  foreach ($references as $ref) {
                    ?>
                      <a href="recherche.php?tag=<?php echo $ref->id; ?>">#<?php echo $ref->tag; ?></a>
                    <?php
                  }
                ?>
              </p>

              <?php
                if(!empty($post->imgTopic))
                {
                  ?>
                    <div class="image-content">
                      <img src="<?php echo $url_posts.$post->imgTopic; ?>" alt="Image de publication">
                    </div>
                  <?php
                }
              ?>

              <p class="date-publication">Publié à <span> <?php echo $date ?></span> </p>

              <i class="icofont-ui-love like <?php if(!empty($likeExiste)){ echo 'like-active'; } ?>"></i>
              <p class="nb-like nb-like-<?php echo $post->id; ?>"><?php echo count($likes); ?></p>

              <i class="icofont-speech-comments comments" data-number="<?php echo $post->id; ?>"></i> <!-- Remplaccer le $i par id-->
              <p class="nb-comments nb-comments-<?php echo $post->id; ?>"><?php echo count($commentaires); ?></p>
            </div> <!-- Fermeture .actualitées -->

            <div class="section-comments" id="comments-<?php echo $post->id; ?>" data-number="<?php echo $post->id; ?>"> <!-- Remplaccer le $i par id-->
              <div class="commentaire-users">
                <?php
                  if(!empty($commentaires))
                  {
                    foreach ($commentaires as $commentaire) {
                      ?>
                        <a href="profil.php?user=<?php echo explode('#',$commentaire->atname)[1]; ?>">@<?php echo explode('#',$commentaire->atname)[0]; ?></a>
                        <p><?php echo $commentaire->contenu; ?></p>
                      <?php
                    }
                  }
                ?>
              </div>

              <?php
                if($connected)
                {
                  ?>
                  <div class="photo-utilisateur-comments">
                    <?php
                      if(!empty($current_user[0]->photoUser) && $current_user[0]->photoUser != 'NULL') { ?> <img src="<?php echo $url_users.$current_user[0]->photoUser; ?>" alt="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                      else { ?> <img src="img-placeholder/bestLoutre.jpg" title="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                    ?>
                  </div> <!-- Fermeture .photo-utilisateur-comments -->
                  <input type="text" id="text-commentaire-<?php echo $post->id; ?>" name="" placeholder="Ajouter un commentaire...">
                  <?php
                }
                else
                {
                  echo '<br>';
                }
              ?>
            </div> <!-- Fermeture .section-comments -->
          <?php
        }
      ?>
    </div> <!-- Fermeture .section-center -->

    <div class="section-right">
      <div class="message-accueil">
        <h2>Bienvenue</h2>
        <div class="content-message">
          <p>Bienvenue sur notre réseau social LinkMMI. Le but est de partager les créations réaliser par des étudiants de formation MMI ou bien même de connaître le parcours d’ancien de vos camarades. </p>
          <br>
          <p>L’équipes LinkMMI vous souhaites une bonne visite sur notre site. </p>
        </div>
      </div> <!-- Fermeture .message-accueil -->
    </div> <!-- Fermeture .section-right -->

  </div>

  <div class="popupInscript">
    <div class="contentPopup">
      <h2>LinkMMI</h2>
      <form action="php/inscription.php" method="post">
        <label for="prenom"><i class="icofont-user-alt-3"></i>
          <input type="text" name="prenomUser" id="prenom" require placeholder="Prénom *">
        </label>
        <label for="nom"><i class="icofont-user-alt-3"></i>
          <input type="text" name="nomUser" id="nom" require  placeholder="Nom *">
        </label>
        <label for="mail"><i class="icofont-email"></i>
          <input type="mail" name="mailUser" id="mail" require placeholder="Mail *">
        </label>
        <label for="password"><i class="icofont-lock"></i>
          <input type="password" name="passwordUser" id="password" require placeholder="Mot de passe *">
        </label>
        </label>
        <label for="password2"><i class="icofont-lock"></i>
          <input type="password" name="passwordUser2" id="password2" require placeholder="Valider mot de passe *">
        </label>
        <button id="btn-inscription">S'inscrire</button>
      </form>
      <button class="closeInscript"><i class="icofont-close"></i></button>
    </div>
  </div>
  <div class="popupImg-container">
    <div class="imgPopup">
      <button class="closeImg"><i class="icofont-close"></i></button>
      <img src="" alt="">
    </div>
  </div>

  <?php if(isset($_GET["erreur"])): ?>
    <div class="popupErreur">
      <p>
        <?php if($_GET["erreur"] == "mdp"): ?>
          Erreur - Mot de passe incorrect
        <?php else: ?>
          Erreur - L'adresse mail n'existe pas
        <?php endif; ?>
      </p>
    </div>
  <?php endif; ?>

  <script src="js/script.js" type="text/javascript"></script>
  <script src="js/section-connexion.js" type="text/javascript"></script>
  <script src="js/inscription.js" type="text/javascript"></script>
  <script src="js/profil.js" type="text/javascript"></script>
  <?php if($connected){ ?> <script src="js/script-topic.js" type="text/javascript"></script> <?php } ?>

</body>
</html>
