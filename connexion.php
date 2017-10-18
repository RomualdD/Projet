<?php
  include 'header.php'
?>

  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Connexion</h2></div>
    </div>
    <p>Bonjour, veuillez entrer votre Nom d'utilisateur et votre de mot de passe afin de continuer sur le site.</p>
    <p>Si vous n'êtes pas inscrit, veuillez-vous rendre sur la page <a href="inscription.php" class="link">inscription</a>.</p>
    <div class="row">
      <div class="connexion col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3>Informations de connexion :</h3></div>
        </div>
        <div class="form-group">
          <label for="texte">Nom d'utilisateur :</label>
          <input type="text" placeholder="Nom d'utilisateur" class="col-lg-offset-1">
        </div>
        <div class="form-group">
          <label for="texte">Mot de passe :</label>
          <input type="password" placeholder="Mot de Passe" class="col-lg-offset-1">
        </div>
        <input type="button" value="Se connecter !" class="button col-lg-offset-4">
        <div class="explication col-lg-offset-5"><p>J'ai perdu mes identifiants,<a href="">cliquez ici</a></p></div>
    </div>
  </div>
</div>

<?php
  include 'footer.php'
?>
