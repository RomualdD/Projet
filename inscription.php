<?php
  include "header.php";
?>
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Inscription</h2></div>
    </div>
    <p>Bonjour, afin de continuer sur le site il est obligatoire d'être inscrit, veuillez remplir les informations ci-dessous.</p>
    <p>Si vous êtes déjà inscrit, veuillez-vous rendre sur la page <a href="connexion.php" class="link">connexion</a>.</p>
    <div class="row">
      <div class="inscription col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3>Informations à renseigner :</h3></div>
        </div>
        <div class="form-group">
          <label for="texte">Nom :</label>
          <input type="text" placeholder="Nom">
        </div>
        <div class="form-group">
          <label for="texte">Prénom :</label>
          <input type="text" placeholder="Prénom">
        </div>
        <div class="form-group">
          <label for="texte">Date de naissance :</label>
          <input type="text" placeholder="Date de naissance">
          <div class="explication col-lg-offset-4"><p>Format: jj/mm/aaaa</p></div>
        </div>
        <div class="form-group">
          <label for="texte">Nom d'utilisateur :</label>
          <input type="text" placeholder="Nom d'utilisateur">
        </div>
        <div class="form-group">
          <label for="texte">Mot de passe :</label>
          <input type="password" placeholder="Mot de passe">
        </div>
        <div class="form-group">
          <label for="texte">Vérification mot de passe :</label>
          <input type="password" placeholder="Même mot de passe">
        </div>
        <div class="form-group">
          <label for="texte">Adresse mail :</label>
          <input type="email" placeholder="Adresse mail">
        </div>
        <div class="form-group">
          <label for="texte">Numéro de téléphone :</label>
          <input type="tel" placeholder="N° téléphone">
        </div>
        <div class="form-group">
          <label for="texte" class="col-lg-2">Rôle :</label>
          <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role"> Médecin</div>
          <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role"> Patient</div>
        </div>
        <div class="form-group">
          <label for="texte">Informations de la pathologie :</label>
          <select>
            <option>Diabète Type 1</option>
            <option>Diabète Type 2</option>
            <option>Anticoagulant (AVK)</option>
          </select>
        </div>
        <input type="button" value="Envoyer !" class="button col-lg-offset-4">
      </div>
    </div>
  </div>

  <?php
    include "footer.php";
  ?>
