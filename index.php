<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <!-- Bibliothèques -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
            <input type="submit" value="Se connexion">
          </form>

        </div> <!-- Fermeture .information -->
      </div> <!-- Fermeture .connexion -->
    </div> <!-- Fermeture .section-left -->

    <div class="section-center">
      <?php
        for($i = 0; $i < 4; $i++) {
       ?>
      <div class="actualitées">

        <div class="utilisateur">

          <div class="photo-utilisateur">
            <img src="img/photo-utilisateur.jpg" alt="Photo de profile de l'utilisateur">
          </div> <!-- Fermeture .photo-utilisateur -->

          <div class="info-utilisateur">
            <h2>Marie Durant</h2>
            <a href="#">@Marie_Drnt</a>
          </div> <!-- Fermeture .info-utilisateur -->

        </div> <!-- Fermeture .utilisateur -->

        <p class="content-actualité">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        <div class="image-content">
          <img src="img/photo-content.jpg" alt="Image de publication">
        </div> <!-- Fermeture .image-content -->

        <p class="date-publication">Publié à <span> 12h00 le 21 janvier 2018</span> </p>

        <i class="icofont-ui-love like"></i>
        <p class="nb-like">300</p>

        <i class="icofont-speech-comments comments" data-number="<?php echo $i; ?>"></i> <!-- Remplaccer le $i par id-->
        <p class="nb-comments">200</p>
      </div> <!-- Fermeture .actualitées -->

      <div class="section-comments" id="comments-<?php echo $i; ?>"> <!-- Remplaccer le $i par id-->

        <div class="commentaire-users">
          <a href="#"> @Sarah_Crch </a>
          <p>Voici mon commentaire</p>
        </div>

        <div class="photo-utilisateur-comments">
          <img src="img/photo-utilisateur.jpg" alt="Photo de profile de l'utilisateur">
        </div> <!-- Fermeture .photo-utilisateur-comments -->

        <input type="text" name="" placeholder="Ajouter un commentaire...">
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
        <button type="submit">S'inscrire</button>
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

  <script src="js/script.js" type="text/javascript"></script>
  <script src="js/section-connexion.js" type="text/javascript"></script>

</body>
</html>
