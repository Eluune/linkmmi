<?php
session_start();

  $url_posts = 'img/posts/';
  $url_users = 'img/users/';
  $url_bannieres = 'img/bannieres/';

if(empty($_SESSION['id']) || $_SESSION['id']==-1)
{
  header('location:index.php');
  exit;
}
else
{
  include("bdd/config.php");
  include("bdd/bdd.php");

  // tableau avec les mois de l'année
  $months = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
  // fuseau horraire pour les dates
  $tz = new DateTimeZone('Europe/Paris');

  // récupération des informations de l'utilisateur courant
  $requete='SELECT * FROM utilisateur WHERE idUser='.$_SESSION["id"];
  $resultats=$bdd->query($requete);
  $current_user=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $afficherUser = false;
  $wait = false;
  $friends = false;
  $accept = false;

  if(isset($_GET['user']))
  {
    if(!empty($_GET['user']))
    {
      $requete='SELECT * FROM utilisateur WHERE idUser='.$_GET["user"];
      $resultats=$bdd->query($requete);
      $user=$resultats->fetchAll(PDO::FETCH_OBJ);
      $resultats->closeCursor();

      if(!empty($user))
      {
        $afficherUser = true;
        $idUser = $user[0]->idUser;
      }
    }
  }
  if(!$afficherUser)
  {
    $idUser = $_SESSION['id'];

    $requete='SELECT * FROM utilisateur WHERE idUser='.$idUser;
    $resultats=$bdd->query($requete);
    $user=$resultats->fetchAll(PDO::FETCH_OBJ);
    $resultats->closeCursor();
  }

  // récupération des informations utilisateur
  $requete='SELECT * FROM utilisateur WHERE idUser='.$idUser;
  $resultats=$bdd->query($requete);
  $user=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $atname = explode('#',$user[0]->atnameUser);

  // récupération des informations travail utilisateur
  $requete='SELECT travaildans.idTravailDans AS "id", travaildans.debutTravail AS "debut", travaildans.finTravail AS "fin", travail.villeTravail AS "ville", travail.entrepriseTravail AS "entreprise", travaildans.fonctionTravail AS "fonction", travaildans.idTravail AS "idTravail"
            FROM travaildans, travail
            WHERE travaildans.idUser='.$idUser.' AND travaildans.idTravail = travail.idTravail
            ORDER BY travaildans.debutTravail DESC';
  $resultats=$bdd->query($requete);
  $travails=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  // récupération des informations relations utilisateur
  $requete='SELECT idUser_suivit FROM follow WHERE idUser_suit='.$idUser.' AND acceptationSuivi = 1';
  $resultats=$bdd->query($requete);
  $userTest=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $userSuivi = 0;

  foreach($userTest as $test){
    $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit='.$test->idUser_suivit.' AND idUser_suivit='.$idUser.' AND acceptationSuivi = 1';
    $resultats=$bdd->query($requete);
    $userTestApprobation=$resultats->fetch();
    $resultats->closeCursor();

    if(!empty($userTestApprobation)) { $userSuivi++; }
  }

  // récupération des informations posts utilisateur
  $requete='SELECT topic.idTopic AS "id", topic.contenuTopic AS "contenu", topic.imgTopic AS "imgTopic", topic.dateTopic AS "date", utilisateur.prenomUser AS "prenom", utilisateur.nomUser AS "nom", utilisateur.atnameUser AS "atname", utilisateur.photoUser AS "imgUser"
            FROM topic, utilisateur
            WHERE topic.idUser='.$idUser.' AND topic.idUser = utilisateur.idUser
            ORDER BY topic.dateTopic DESC';
  $resultats=$bdd->query($requete);
  $posts=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  if($_SESSION['id'] != $idUser)
  {
    // on regarde si l'utilisateur courrant suit l'utilisateur sélectionné
    $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit='.$_SESSION['id'].' AND idUser_suivit='.$idUser;
    $resultats=$bdd->query($requete);
    $acceptationSuiviCurrent=$resultats->fetch();
    $resultats->closeCursor();
    // on regarde si l'utilisateur sélectionné suit l'utilisateur currant
    $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit='.$idUser.' AND idUser_suivit='.$_SESSION['id'];
    $resultats=$bdd->query($requete);
    $acceptationSuiviSelected=$resultats->fetch();
    $resultats->closeCursor();

    // si le champ n'existe pas, il est considéré égal à 0
    if(empty($acceptationSuiviCurrent)) { $acceptationSuiviCurrent[0] = 0; }
    if(empty($acceptationSuiviSelected)) { $acceptationSuiviSelected[0] = 0; }

    if($acceptationSuiviCurrent[0]==1 && $acceptationSuiviSelected[0]==1) { $friends = true; }
    if($acceptationSuiviCurrent[0]==1 && $acceptationSuiviSelected[0]==0) { $wait = true; }
    if($acceptationSuiviCurrent[0]==0 && $acceptationSuiviSelected[0]==1) { $accept = true; }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <!-- Bibliothèques -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $user[0]->prenomUser.' '.$user[0]->nomUser; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="css/style-nav&post.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="css/profil.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="icofont/icofont.min.css">
</head>
<body>
  <?php include('php/nav.php'); ?>

  <div class="content">
    <?php
      if(!empty($user[0]->banniereUser) && $user[0]->banniereUser != 'NULL') { ?> <img src="<?php echo $url_bannieres.$user[0]->banniereUser; ?>" class="banniere"> <?php }
      else { ?> <img src="img-placeholder/bestLoutre.jpg" alt="" class="banniere"> <?php }
    ?>

    <!-- contenu des informations du profil -->
    <div class="profil">
      <div class="profilPictContainer">
        <?php
          if(!empty($user[0]->photoUser) && $user[0]->photoUser != 'NULL') { ?> <img src="<?php echo $url_users.$user[0]->photoUser; ?>" class="profilPict"> <?php }
          else { ?> <img src="img-placeholder/bestLoutre.jpg" class="profilPict"> <?php }
        ?>
        <?php
          if($_SESSION['id'] != $idUser)
          {
            ?>
              <button id="friend" data-number="<?php echo $idUser; ?>" class="<?php
                if(!$wait)
                {
                  if($friends){ echo "friends"; }
                  else{ echo "unfriends"; if($accept){ echo " accept"; } }
                } ?>">
              </button>
            <?php
          }
        ?>
      </div>
      <div class="contentProfil">
        <div class="descProfil">
          <h3><?php echo $user[0]->prenomUser.' '.$user[0]->nomUser; ?><br><em class="highLight">@<?php echo $atname[0]; ?></em></h3>
          <?php
            if(!empty($user[0]->birthdayUser))
            {
              $birthday = new DateTime($user[0]->birthdayUser);
              echo '<p>Né(e) le '.intval($birthday->format('d')).' '.$months[intval($birthday->format('m'))-1].'</p>';
            }
            if(!empty($user[0]->descriptionUser))
            {
              echo '<p>'.$user[0]->descriptionUser.'</p>';
            }
            if(!empty($user[0]->portfolioUser))
            {
              echo '<a href="http://'.$user[0]->portfolioUser.'" class="portfolio" target="_blank">Voir le portfolio <i class="icofont-external-link"></i></a>';
            }
            if(!empty($travails))
            {
              foreach ($travails as $travail)
              {
                echo '<p class="travail-'.$travail->id.'">'.$travail->fonction.' à <a href="recherche.php?entreprise='.$travail->id.'" class="highLight">'.$travail->entreprise.' de '.$travail->ville.'</a></p>';
              }
            }
          ?>
          <div class="containerProfilNul">
            <div class="profilNum">
              <span class="textFolower">Relation<?php if($userSuivi>1){ ?>s<?php } ?></span>
              <br>
              <em id="nbFollower" class="highLight"><?php echo $userSuivi; ?></em>
            </div>
            <div class="profilNum">
              <span>Publication<?php if(count($posts)>1){ ?>s<?php } ?></span>
              <br>
              <em class="highLight"><?php echo count($posts); ?></em>
            </div>
          </div>
        </div>
        <?php if($_SESSION['id'] == $idUser){ ?> <div id="edit" class="subBtn">Éditer le profil</div> <?php } ?>
      </div>
    </div>
    <!-- fin informations du profil -->

    <!-- contenu messages de l'utilisateur -->
    <div class="section-center">
      <?php include('php/post.php'); ?>
      <?php
        foreach ($posts as $post) {

          // récupération des informations likes post
          $requete='SELECT idUser FROM aime WHERE idTopic='.$post->id;
          $resultats=$bdd->query($requete);
          $likes=$resultats->fetchAll(PDO::FETCH_OBJ);
          $resultats->closeCursor();

          // récupération information : user a liké le post
          $requete='SELECT idUser FROM aime WHERE idUser='.$current_user[0]->idUser.' AND idTopic='.$post->id;
          $resultats=$bdd->query($requete);
          $likeExiste=$resultats->fetch();
          $resultats->closeCursor();

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

              <div class="photo-utilisateur-comments">
                <?php
                  if(!empty($current_user[0]->photoUser) && $current_user[0]->photoUser != 'NULL') { ?> <img src="<?php echo $url_users.$current_user[0]->photoUser; ?>" alt="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                  else { ?> <img src="img-placeholder/bestLoutre.jpg" title="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
                ?>
              </div> <!-- Fermeture .photo-utilisateur-comments -->

              <input type="text" id="text-commentaire-<?php echo $post->id; ?>" name="" placeholder="Ajouter un commentaire...">
            </div> <!-- Fermeture .section-comments -->
          <?php
        }
      ?>
    </div> <!-- Fermeture .section-center -->


    <div class="other">
      <div class="suggest">
        <h3>Suggestion</h3>
        <div class="blcPpl">
          <img src="img-placeholder/bestLoutre.jpg" alt="" class="blcPplPict">
          <p>Sarah Croche <em class="highLight">@Sarah_croche</em></p>
          <button class="btn-suivre">Suivre</button>
        </div>
        <div class="blcPpl">
          <img src="img-placeholder/bestLoutre.jpg" alt="" class="blcPplPict">
          <p>Pat Icier <em class="highLight">@Pat_ic</em></p>
          <button class="btn-suivre">Suivre</button>
        </div>
        <div class="subBtn">Voir plus</div>
      </div>
      <div class="message">
        <h3>Message</h3>
        <div class="blcMess">
          <img src="img-placeholder/bestLoutre.jpg" alt="" class="blcMessPict">
          <p>Sarah Croche <em class="highLight">Mar</em></p>
          <p class="extraitMess">ibzfibsciub</p>
        </div>
        <div class="blcMess">
          <img src="img-placeholder/bestLoutre.jpg" alt="" class="blcMessPict">
          <p>Pat Icier <em class="highLight">Mar</em></p>
          <p class="extraitMess">ibzfibsciub</p>
        </div>
        <form action="" method="post">
          <input type="text" placeholder="Rechercher">
          <button type="submit">?</button>
        </form>
        <div class="subBtn">Voir plus</div>
      </div>

      <em class="highLight">LinkMMI © 2019</em>
    </div>
  </div>

  <?php if($_SESSION['id'] == $idUser){ include('php/form-modification.php'); } ?>

  <script src="js/script-profil.js" type="text/javascript"></script>
  <script src="js/script-topic.js" type="text/javascript"></script>
  <script src="js/script.js" type="text/javascript"></script>
</body>
</html>
<?php } ?>
