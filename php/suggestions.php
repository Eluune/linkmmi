<?php
  // rechercher des profils qui ne sont pas amis
  $requete='SELECT idUser, prenomUser, nomUser, photoUser FROM utilisateur WHERE idUser <> '.$_SESSION['id'].' LIMIT 5';
  $resultats=$bdd->query($requete);
  $listeUsers=$resultats->fetchAll(PDO::FETCH_OBJ);
  $resultats->closeCursor();

  $suggestions = [];

  foreach($listeUsers as $sug){
    $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suit = '.$_SESSION['id'].' AND idUser_suivit = '.$sug->idUser;
    $resultats=$bdd->query($requete);
    $acceptationSuivi=$resultats->fetch();
    $resultats->closeCursor();

    $i=0;

    if(empty($acceptationSuivi) || $acceptationSuivi[0] == 0)
    {
      $suggestions[$i] = $sug;
      $i++;
    }
  }
?>
<div class="suggest">
  <h3>Suggestion</h3>
  <?php
    if(empty($suggestions))
    {
      ?>
        <br>
        <p>Désolé :(</p>
        <br>
        <p>Nous n'avons trouvé aucun profil à vous suggérer</p>
      <?php
    }
    else
    {
      foreach($suggestions as $profil)
      {
        $requete='SELECT acceptationSuivi FROM follow WHERE idUser_suivit = '.$_SESSION['id'].' AND idUser_suit = '.$profil->idUser;
        $resultats=$bdd->query($requete);
        $acceptationSuiviCourant=$resultats->fetch();
        $resultats->closeCursor();

        $wait = false;

        if($acceptationSuiviCourant[0]==1) { $wait = true; }

        ?>
          <div class="blcPpl">
            <?php
              if(empty($profil->img)) { ?><img src="img-placeholder/bestLoutre.jpg" alt="Photo de <?php echo $profil->prenomUser.' '.$profil->nomUser; ?>" class="blcPplPict"><?php }
              else { ?><img src="<?php echo $url_users.$profil->photoUser; ?>" alt="Photo de <?php echo $profil->prenomUser.' '.$profil->nomUser; ?>" class="blcPplPict"><?php }
            ?>

            <p><a href="profil.php?user=<?php echo $profil->idUser; ?>"><?php echo $profil->prenomUser.' '.$profil->nomUser; ?></a></p>
            <button data-number="<?php echo $profil->idUser; ?>" class="btn-friend unfriends<?php
              if($wait)
              {
                echo " accept";
              } ?>">
            </button>
          </div>
        <?php
      }
    }
  ?>
</div>

<!-- bloc utilisable lors de l'ajout de la messageries
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
-->

<em class="highLight">LinkMMI © 2019</em>
