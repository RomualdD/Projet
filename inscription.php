<?php
  include "header.php";
?>
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Inscription</h2></div>
    </div>
    <div class="row">
      <div class="inscription col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3>Informations à renseigner</h3></div>
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
          <input type="password">
        </div>
        <div class="form-group">
          <label for="texte">Vérification mot de passe :</label>
          <input type="password">
        </div>
        <div class="form-group">
          <label for="texte">Adresse mail :</label>
          <input type="email" placeholder="Adresse mail">
        </div>
        <div class="form-group">
          <label for="texte">Numéro de téléphone :</label>
          <input type="tel">
        </div>
        <div class="form-group">
          <label for="texte">Rôle :</label>
          <input type="radio" name="role"> Médecin
          <input type="radio" name="role"> Patient
        </div>
        <div class="form-group">
          <label for="texte">Informations de la pathologie</label>
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
