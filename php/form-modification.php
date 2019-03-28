<!-- Formulaires d'édition de profil -->
<div class="edit">
  <div class="popup-edit">
    <button class="close"><i class="icofont-ui-close"></i></button>
    <h2>Editer le profil</h2>

    <div class="categorie">
      <div class="popup-titres">
        <div class="popup-titre-single active" id="popup-infosClassiques">
          <span>Informations publiques</span>
        </div>
        <div class="popup-titre-single" id="popup-infosImages">
          <span>Images</span>
        </div>
        <div class="popup-titre-single" id="popup-infosTravails">
          <span>Détails</span>
        </div>
        <div class="popup-titre-single" id="popup-infosPrivees">
          <span>Informations privées</span>
        </div>
      </div>

      <div class="popup-contents active" id="content-popup-infosClassiques">
        <form method="post" action="php/modification.php">
          <div class="ligne ligne-4">
            <label for="popup-prenomUser">Prénom
              <input type="text" name="prenomUser" id="popup-prenomUser" value="<?php echo $current_user[0]->prenomUser; ?>" />
            </label>
            <label for="popup-nomUser">Nom
              <input type="text" name="nomUser" id="popup-nomUser" value="<?php echo $current_user[0]->nomUser; ?>" />
            </label>
            <label for="popup-birthdayUser">Anniversaire
              <input type="date" name="birthdayUser" id="popup-birthdayUser" value="<?php echo $current_user[0]->birthdayUser; ?>" />
            </label>
            <label for="popup-portfolioUser">Portfolio
              <input type="text" name="portfolioUser" id="popup-portfolioUser" value="<?php echo $current_user[0]->portfolioUser; ?>" />
            </label>
          </div>
          <div class="ligne ligne-1">
            <label for="popup-descriptionUser">Description
              <input type="text" name="descriptionUser" id="popup-descriptionUser" value="<?php echo $current_user[0]->descriptionUser ?>" />
            </label>
          </div>
          <button type="submit" name="infosClassiques" id="btn-popup-infosClassiques"><span>Mettre à jour</span></button>
        </form>
      </div>

      <div class="popup-contents" id="content-popup-infosImages">
        <form method="post" action="php/modification.php" enctype="multipart/form-data">
          <div class="ligne ligne-2">
            <label for="popup-photoUser">Image de profil
              <input type="file" name="photoUser" id="popup-photoUser" />
            </label>
            <label for="popup-banniereUser">Image de bannière
              <input type="file" name="banniereUser" id="popup-banniereUser" />
            </label>
          </div>
          <button type="submit" name="infosImages" id="btn-popup-infosImages"><span>Mettre à jour</span></button>
        </form>
      </div>

      <div class="popup-contents" id="content-popup-infosTravails">
        <form method="post" action="php/modification.php">
          <div class="container">
            <?php
              if(!empty($travails))
              {
                $i = 0;
                foreach ($travails as $travail)
                {
                  $i++;
                  ?>
                  <div class="ligne ligne-6 in-database">
                    <label for="popup-debutTravail">Date de début
                      <input type="date" name="debutTravail-<?php echo $i; ?>" id="popup-debutTravail-<?php echo $i; ?>" value="<?php echo $travail->debut; ?>" />
                    </label>
                    <label for="popup-finTravail">Date de fin
                      <input type="date" name="finTravail-<?php echo $i; ?>" id="popup-finTravail-<?php echo $i; ?>" value="<?php echo $travail->fin; ?>" />
                    </label>
                    <label for="popup-fonctionTravail">Poste
                      <input type="text" name="fonctionTravail-<?php echo $i; ?>" id="popup-fonctionTravail-<?php echo $i; ?>" value="<?php echo $travail->fonction; ?>" />
                    </label>
                    <label for="popup-entrepriseTravail">Entreprise
                      <input type="text" name="entrepriseTravail-<?php echo $i; ?>" id="popup-entrepriseTravail-<?php echo $i; ?>" value="<?php echo $travail->entreprise; ?>" />
                    </label>
                    <label for="popup-villeTravail">Ville
                      <input type="text" name="villeTravail-<?php echo $i; ?>" id="popup-villeTravail-<?php echo $i; ?>" value="<?php echo $travail->ville; ?>" />
                    </label>
                    <input type="hidden" name="idTravail-<?php echo $i; ?>" value="<?php echo $travail->idTravail; ?>" />
                    <input type="hidden" name="id-<?php echo $i; ?>" value="<?php echo $travail->id; ?>" />
                    <button class="supprimer" type="button" data-number="<?php echo $travail->id; ?>"><span>Supprimer</span></button>
                  </div>
                  <?php
                }
              }
            ?>
            <input type="hidden" name="nbOldTravails" id="nbOldTravails" value="<?php echo count($travails); ?>" />
            <div id="nouveauxChamps"></div>
            <div class="ligne ligne-6">
              <button class="newField" type="button" data-number="0"><span>Ajouter</span></button>
            </div>
          </div>
          <input type="hidden" name="nbNewTravails" id="nbNewTravails" value="0" />
          <button type="submit" name="infosTravails" id="btn-popup-infosTravails"><span>Mettre à jour</span></button>
        </form>
      </div>

      <div class="popup-contents" id="content-popup-infosPrivees">
        <form method="post" action="php/modification.php">
          <div class="ligne ligne-3">
            <label for="popup-mailUser">Mail
              <input type="mail" name="mailUser" id="popup-mailUser" value="<?php echo $current_user[0]->mailUser; ?>" />
            </label>
            <label for="popup-passwordUser1">Ancien mot de passe
              <input type="password" name="passwordOld" id="popup-passwordUserOld" />
            </label>
            <label for="popup-passwordUser2">Nouveau mot de passe
              <input type="password" name="passwordNew" id="popup-passwordUserNew" />
            </label>
          </div>
          <button type="submit" name="infosPrivees" id="btn-popup-infosPrivees"><span>Mettre à jour</span></button>
        </form>
      </div>

    </div>
  </div>
</div>
