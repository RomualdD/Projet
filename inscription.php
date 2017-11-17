<?php
  include "header.php";
?>
<!-- Page d'inscription -->
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Inscription</h2></div>
    </div>
    <div class="message col-lg-offset-2"><p>Bonjour, afin de continuer sur le site il est obligatoire d'être inscrit, veuillez remplir les informations ci-dessous.</p>
    <p>Si vous êtes déjà inscrit, veuillez-vous rendre sur la page <a href="connexion.php" class="link">connexion</a>.</p></div>
    <div class="row">
      <div class="inscription col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3>Informations à renseigner :</h3></div>
        </div>
        <div class="form-inline">
          <div class="input-group name col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="name" placeholder="Nom de Famille">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group surname col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="surname" placeholder="Prénom">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group birthday col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="birthday" placeholder="Date de naissance">
          </div>
          <p class="col-lg-offset-3">Format: jj/mm/aaaa</p>
        </div>
        <div class="form-inline">
          <div class="input-group username col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group password col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="password" placeholder="Mot de passe">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group password col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="passwordverif" placeholder="Vérification mot de passe">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group mail col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="mail" placeholder="Adresse mail">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group phone col-lg-offset-3">
              <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="phone" placeholder="Numéro de téléphone">
          </div>
        </div>
        <div class="form-group">
          <label for="texte" class="col-lg-2">Rôle :</label>
          <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role"> Médecin</div>
          <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role"> Patient</div>
        </div>
        <div class="form-group">
          <label for="texte">Informations de la pathologie :</label>
          <select>
            <option>Pathologie..</option>
            <option name="pathology">Diabète Type 1</option>
            <option name="pathology">Diabète Type 2</option>
            <option name="pathology">Anticoagulant (AVK)</option>
          </select>
        </div>
        <input type="submit" value="Envoyer !" class="button btn btn-default col-lg-offset-4">
      </div>
    </div>
  </div>

  <?php
    include "footer.php";
  ?>
