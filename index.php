<?php
  session_start();
  //session_destroy();

  //$_SESSION['id']=1;

  include("bdd/config.php");
  include("bdd/bdd.php");

  // tableau avec les mois de l'année
  $months = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
  // fuseau horraire pour les dates
  $tz = new DateTimeZone('Europe/Paris');

  if(isset($_SESSION["idUser"]))
  {
    // récupération des informations de l'utilisateur courant
    $requete='SELECT * FROM utilisateur WHERE idUser='.$_SESSION["idUser"];
    $resultats=$bdd->query($requete);
    $current_user=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();
  }
  else
  {
    $_SESSION["idUser"] = -1;
  }

  // récupération des informations posts utilisateur
  $requete='SELECT topic.idTopic AS "id", topic.contenuTopic AS "contenu", topic.imgTopic AS "imgTopic", topic.dateTopic AS "date", utilisateur.prenomUser AS "prenom", utilisateur.nomUser AS "nom", utilisateur.atnameUser AS "atname", utilisateur.photoUser AS "imgUser"
            FROM topic, utilisateur
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
  <link rel="stylesheet" type="text/css" media="screen" href="icofont/icofont.min.css">
</head>

<body>


  <!--- Menu -->
  <?php if($_SESSION["idUser"] != -1): ?>
      <nav>
          <div class="blcNav">
              <figure id="data-user" data-number="<?php echo $current_user[0]->idUser; ?>">
                <?php
                  if(!empty($current_user[0]->photoUser && $current_user[0]->photoUser != 'NULL')) { ?> <img src="<?php echo $current_user[0]->photoUser; ?>" alt="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                  else { ?> <img src="img-placeholder/bestLoutre.jpg" title="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                ?>
                <figcaption>
                  <a href="profil.php"></a>
                </figcaption>
              </figure>
              <form action="" method="post">
                  <input type="text" placeholder="Rechercher">
              </form>
          </div>
              <button class="btn-Icone active"><i class="icofont-link"></i></button>
          <div class="blcNav">
              <button class="btn-Icone active"><i class="icofont-home"></i></button>
              <button class="btn-Icone"><i class="icofont-wechat"></i></button>
              <button class="btn-Icone"><i class="icofont-heart-alt"></i></button>
          </div>
      </nav>
    <?php endif; ?>
    <!-- Fin menu -->

  <div class="section-connexion">

    <div class="section-left">
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
    </div> <!-- Fermeture .section-left -->

    <div class="section-center">
      <?php
        foreach ($posts as $post) {

          // récupération des informations likes post
          $requete='SELECT idUser FROM aime WHERE idTopic='.$post->id;
          $resultats=$bdd->query($requete);
          $likes=$resultats->fetchAll(PDO::FETCH_OBJ);
          $resultats->closeCursor();

          if($_SESSION["idUser"] != -1)
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
                    if(!empty($post->imgUser) && $post->imgUser != 'NULL') { ?> <img src="<?php echo $post->imgUser; ?>" class="authorPict" alt="Photo de profil de <?php echo $post->prenom.' '.$post->nom; ?>"> <?php }
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
                      <img src="img/<?php echo $post->imgTopic; ?>" alt="Image de publication">
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

              <div class="photo-utilisateur-comments">
                <?php
                  if(!empty($current_user[0]->photoUser) && $current_user[0]->photoUser != 'NULL') { ?> <img src="<?php echo $current_user[0]->photoUser; ?>" alt="Compte de <?php //echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                  else { ?> <img src="img-placeholder/bestLoutre.jpg" title="Compte de <?php //echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                ?>
              </div> <!-- Fermeture .photo-utilisateur-comments -->

              <input type="text" id="text-commentaire-<?php echo $post->id; ?>" name="" placeholder="Ajouter un commentaire...">
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
      <form action="">
        <label for="prenom"><i class="icofont-user-alt-3"></i>
          <input type="text" id="prenom" require placeholder="Prénom *">
        </label>
        <label for="nom"><i class="icofont-user-alt-3"></i>
          <input type="text" id="nom" require  placeholder="Nom *">
        </label>
        <label for="mail"><i class="icofont-email"></i>
          <input type="mail" id="mail" require placeholder="Mail *">
        </label>
        <label for="password"><i class="icofont-lock"></i>
          <input type="password" id="password" require placeholder="Mot de passe *">
        </label>
        </label>
        <label for="password2"><i class="icofont-lock"></i>
          <input type="password" id="password2" require placeholder="Valider mot de passe *">
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
          Erreur - l'adresse mail n'existe pas
        <?php endif; ?>
      </p>
    </div>
  <?php endif; ?>

  <script src="js/script.js" type="text/javascript"></script>
  <script src="js/section-connexion.js" type="text/javascript"></script>
  <script src="js/inscription.js" type="text/javascript"></script>

  </body>
</html>
