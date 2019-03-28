<!--- Menu -->
<nav>
  <div class="blcNav">
    <figure id="data-user" data-number="<?php echo $current_user[0]->idUser; ?>">
      <?php
        if(!empty($current_user[0]->photoUser && $current_user[0]->photoUser != 'NULL')) { ?> <img src="<?php echo $url_users.$current_user[0]->photoUser; ?>" alt="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
        else { ?> <img src="img-placeholder/bestLoutre.jpg" title="Compte de <?php echo $current_user[0]->prenomUser.' '.$current_user[0]->nomUser; ?>"> <?php }
      ?>
      <figcaption>
        <a href="profil.php"></a>
      </figcaption>
    </figure>
    <form action="" method="post">
      <input type="text" name="recherche" placeholder="Rechercher" />
    </form>
  </div>

  <figure id="linkmmi">
    <img src="img/linkmmi/logo.jpg" alt="Logo de LinkMMI" />
    <figcaption>
      <a href="./"></a>
    </figcaption>
  </figure>

  <div class="blcNav">
    <button class="btn-Icone active"><i class="icofont-home"></i></button>
    <button class="btn-Icone"><i class="icofont-wechat"></i></button>
    <button class="btn-Icone"><a href="php/disconnect.php"></a><i class="icofont-exit"></i></button>
  </div>
</nav>
<!-- Fin menu -->
