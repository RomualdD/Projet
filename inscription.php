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
        <div class="form-group">
          <label for="texte">Nom :</label>
          <input type="text" name="name" placeholder="Nom">
        </div>
        <div class="form-group">
          <label for="texte">Prénom :</label>
          <input type="text" name="surname" placeholder="Prénom">
        </div>
        <div class="form-group">
          <label for="texte">Date de naissance :</label>
          <input type="text" name="birthday" placeholder="Date de naissance">
          <div class="explication col-lg-offset-4"><p>Format: jj/mm/aaaa</p></div>
        </div>
        <div class="form-group">
          <label for="texte">Nom d'utilisateur :</label>
          <input type="text" name="user" placeholder="Nom d'utilisateur">
        </div>
        <div class="form-group">
          <label for="texte">Mot de passe :</label>
          <input type="password" name="password" placeholder="Mot de passe">
        </div>
        <div class="form-group">
          <label for="texte">Vérification mot de passe :</label>
          <input type="password" name="passwordcheck" placeholder="Même mot de passe">
        </div>
        <div class="form-group">
          <label for="texte">Adresse mail :</label>
          <input type="email" name="mail" placeholder="Adresse mail">
        </div>
        <div class="form-group">
          <label for="texte">Numéro de téléphone :</label>
          <input type="tel" name="phone" placeholder="N° téléphone">
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
