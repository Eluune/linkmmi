<?php
  include("bdd/config.php");
  include("bdd/bdd.php");

  $_SESSION['id'] = 1;

  // récupération des informations utilisateur
  $requete='SELECT * FROM utilisateur WHERE idUser='.$_SESSION["id"];
  $resultats=$bdd->query($requete);
  $user=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $atname = explode('#',$user[0]->atnameUser);

  // récupération des informations travail utilisateur
  $requete='SELECT travail.villeTravail AS "ville", travail.entrepriseTravail AS "entreprise", travaildans.fonctionTravail AS "fonction"
            FROM travaildans, travail
            WHERE travaildans.idUser='.$_SESSION["id"].' AND travaildans.idTravail = travail.idTravail
            ORDER BY travaildans.debutTravail DESC';
  $resultats=$bdd->query($requete);
  $travails=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  // récupération des informations relations utilisateur
  $requete='SELECT idUser_suivit FROM follow WHERE idUser_suit='.$_SESSION["id"].' AND acceptationSuivi = 1';
  $resultats=$bdd->query($requete);
  $userSuivi=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  // récupération des informations posts utilisateur
  $requete='SELECT topic.idTopic AS "id", topic.contenuTopic AS "contenu", topic.imgTopic AS "imgTopic", topic.dateTopic AS "date", utilisateur.prenomUser AS "prenom", utilisateur.nomUser AS "nom", utilisateur.atnameUser AS "atname", utilisateur.imgUser AS "imgUser"
            FROM topic, utilisateur
            WHERE topic.idUser='.$_SESSION["id"].' AND topic.idUser = utilisateur.idUser
            ORDER BY topic.dateTopic DESC';
  $resultats=$bdd->query($requete);
  $posts=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $user[0]->prenomUser.' '.$user[0]->nomUser; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/profil.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="icofont/icofont.min.css">
</head>
<body>
    <nav>
        <div class="blcNav">
            <img src="img-placeholder/bestLoutre.jpg" alt="" class="navProfil">
            <button class="btn-Y-R">Poster</button>
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
    <div class="content">
        <img src="img-placeholder/bestLoutre.jpg" alt="" class="banniere">
        <div class="profil">
            <div class="profilPictContainer">
                <img src="img-placeholder/bestLoutre.jpg" class="profilPict">
            </div>
            <div class="contentProfil">
                <div class="descProfil">
                    <h3><?php echo $user[0]->prenomUser.' '.$user[0]->nomUser; ?><br><em class="highLight">@<?php echo $atname[0]; ?></em></h3>
                    <?php
                      if(!empty($travails))
                      {
                        foreach ($travails as $travail)
                        {
                          echo $travail->fonction.' à <em class="highLight">'.$travail->entreprise.' de '.$travail->ville.'</em><br>';
                        }
                      }
                      else
                      {
                        echo 'Vide';
                      }
                    ?>
                    <div class="profilNum">Relation<?php if(count($userSuivi)>1){ ?>s<?php } ?><br><em class="highLight"><?php echo count($userSuivi); ?></em></div>
                    <div class="profilNum">Publication<?php if(count($posts)>1){ ?>s<?php } ?><br><em class="highLight"><?php echo count($posts); ?></em></div>
                </div>
                <div class="subBtn">Éditer le profil</div>
            </div>
        </div>
        <div class="flux">
          <?php
            foreach ($posts as $post) {

              // récupération des informations likes post
              $requete='SELECT idUser FROM aime WHERE idTopic='.$post->id;
              $resultats=$bdd->query($requete);
              $likes=$resultats->fetchAll(PDO::FETCH_OBJ);
              $resultats->closeCursor();

              // récupération des informations commentaires post
              $requete='SELECT commentaire.contenuCommentaire AS "contenu", utilisateur.prenomUser AS "prenom", utilisateur.nomUser AS "nom", utilisateur.atnameUser AS "atname", utilisateur.imgUser AS "imgUser"
                        FROM commentaire, utilisateur
                        WHERE commentaire.idTopic='.$post->id.' AND commentaire.idUser = utilisateur.idUser';
              $resultats=$bdd->query($requete);
              $commentaires=$resultats->fetchAll(PDO::FETCH_OBJ);
              $resultats->closeCursor();

              ?>
                <div class="article">
                  <div class="author">
                    <img src="img-placeholder/bestLoutre.jpg" alt="" class="authorPict">
                    <h3><?php echo $post->prenom.' '.$post->nom; ?><br>
                      <em class="highLight">
                        <a class="highLight" href="profil.php?user=<?php echo explode('#',$post->atname)[1]; ?>">@<?php echo explode('#',$post->atname)[0]; ?></a>
                      </em>
                    </h3>
                  </div>
                  <div class="contentTxt">
                    <?php echo $post->contenu; ?>
                  </div>
                  <?php
                    if(!empty($post->imgTopic))
                    {
                      ?>
                        <div class="contentPict">
                          <img src="<?php echo $post->imgTopic; ?>" alt="">
                        </div>
                      <?php
                    }
                  ?>
                  <div class="contentDetails">
                    Publié le <em class="highLight"><?php echo $post->date; //12h00 le 21 janvier 2019 ?></em>
                    <div class="subBtn">
                      <span> <i class="icofont-heart-alt c-yellow"></i><?php echo count($likes); ?></span>
                      <span> <i class="icofont-google-talk c-grey"></i><?php echo count($commentaires); ?></span>
                    </div>
                  </div>
                  <?php
                    if(!empty($commentaires))
                    {
                      ?>
                        <div class="contentcomm">
                          <ul>
                            <li><b>@Sarah_croche</b> Wouah ! Cette photo est magnifique.</li>
                            <li><b>@Lara_clette</b> <em class="tagPpl">@Vincent_tim</em> C'est cool</li>
                          </ul>
                          <div class="subBtn">
                            Voir plus
                          </div>
                        </div>
                      <?php
                    }
                  ?>
                </div>
              <?php
            }
          ?>

            <div class="article">
                <div class="author">
                    <img src="img-placeholder/bestLoutre.jpg" alt="" class="authorPict">
                    <h3>Marie Durant<br><em class="highLight">@Marie_Drt</em></h3>
                </div>
                <div class="contentTxt">
                    Cum saepe multa, tum memini domi in hemicyclio sedentem, ut solebat, cum et ego essem una et pauci admodum familiares, in eum sermonem illum incidere qui tum forte multis erat in ore. Meministi enim profecto, Attice, et eo magis, quod P. Sulpicio utebare multum, cum is tribunus plebis capitali odio a Q. Pompeio, qui tum erat consul, dissideret, quocum coniunctissime et amantissime vixerat, quanta esset hominum vel admiratio vel querella.
                </div>
                <div class="contentPict">
                    <img src="img-placeholder/bestLoutre.jpg" alt="">
                </div>
                <div class="contentDetails">
                    Publié le<em class="highLight"> 12h00 le 21 janvier 2019</em>
                    <div class="subBtn">
                        <span><i class="icofont-heart-alt c-yellow"></i>300</span>
                        <span> <i class="icofont-google-talk c-grey"></i> 25</span>
                    </div>
                </div>
                <div class="contentcomm">
                    <ul>
                        <li><b>@Sarah_croche</b> Wouah ! Cette photo est magnifique.</li>
                        <li><b>@Lara_clette</b> <em class="tagPpl">@Vincent_tim</em> C'est cool</li>
                    </ul>
                    <div class="subBtn">
                        Voir plus
                    </div>
                </div>
            </div>
            <div class="article">
                <div class="author">
                    <img src="img-placeholder/bestLoutre.jpg" alt="" class="authorPict">
                    <h3>Marie Durant<br><em class="highLight">@Marie_Drt</em></h3>
                </div>
                <div class="contentTxt">
                    Cum saepe multa, tum memini domi in hemicyclio sedentem, ut solebat, cum et ego essem una et pauci admodum familiares, in eum sermonem illum incidere qui tum forte multis erat in ore. Meministi enim profecto, Attice, et eo magis, quod P. Sulpicio utebare multum, cum is tribunus plebis capitali odio a Q. Pompeio, qui tum erat consul, dissideret, quocum coniunctissime et amantissime vixerat, quanta esset hominum vel admiratio vel querella.
                </div>
                <div class="contentDetails">
                    Publié le<em class="highLight"> 12h00 le 21 janvier 2019</em>
                    <div class="subBtn">
                        <span><i class="icofont-heart-alt c-yellow"></i>300</span>
                        <span> <i class="icofont-google-talk c-grey"></i> 25</span>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="subBtn">
                        Voir plus
                </div>
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
                <div class="subBtn">
                        Voir plus
                </div>
            </div>

            <em class="highLight">LinkMMI © 2019</em>
        </div>
    </div>
</body>
</html>
