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
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" type="text/css" media="screen" href="icofont/icofont.min.css">
</head>

<body>

  <div class="section-connexion">

    <div class="section-left">
      <div class="connexion">
        <div class="information">

          <h1>Connexion</h1>
          <a href="#" id="inscript" class="animUnderline">Inscription</a>

          <form class="" action="index.html" method="post">
            <input type="text" name="login" placeholder="Login">
            <br>
            <input type="password" name="password" placeholder="Mot de passe">
            <br>
            <input type="submit" value="Se connexion">
          </form>

        </div> <!-- Fermeture .information -->
      </div> <!-- Fermeture .connexion -->
    </div> <!-- Fermeture .section-left -->

    <div class="section-center">
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

      </div> <!-- Fermeture .actualitées -->
    </div> <!-- Fermeture .section-center -->

    <div class="section-right">
    </div> <!-- Fermeture .section-right -->

  </div>

  <div class="popupInscript">
    <div class="contentPopup">
      <h2>LinkMMI</h2>
      <form action="">
        <label for="prenom"><i class="icofont-user-alt-3"></i>
          <input type="text" id="prenom" placeholder="Prénom">
        </label>
        <label for="nom"><i class="icofont-user-alt-3"></i>
          <input type="text" id="nom" placeholder="Nom">
        </label>
        <label for="mail"><i class="icofont-email"></i>
          <input type="mail" id="mail" placeholder="Mail">
        </label>
        <label for="password"><i class="icofont-lock"></i>
          <input type="password" id="password" placeholder="Mot de passe">
        </label>
        <label for="portfolio"><i class="icofont-link-alt"></i>
          <input type="url" id="portfolio" placeholder="portfolio">
        </label>
        <label for="dateNaissance"><i class="icofont-calendar"></i>
          <input type="date" id="dateNaissance">
        </label>
        <button type="submit">S'inscrire</button>
      </form>
      <button class="closeInscript"><i class="icofont-close"></i></button>
    </div>
  </div>

  <script src="js/script.js" type="text/javascript"></script>
  <script src="js/event.js" type="text/javascript"></script>
</body>
</html>
