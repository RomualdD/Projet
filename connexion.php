<?php
    include_once 'Controller/connexionController.php';
    include_once 'View/header.php';
?>
<!-- Page de connexion -->
  <div class="container view">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Connexion</h2></div>
    </div>
    <div class="message col-lg-offset-2"><p>Veuillez entrer votre Nom d'utilisateur et votre de mot de passe afin de continuer sur le site.</p>
    <p>Si vous n'êtes pas inscrit, veuillez-vous rendre sur la page <a href="inscription.php" class="link">inscription</a>.</p></div>
    <div class="row">
      <div class="connexion col-lg-offset-3 col-lg-5">
        <form action="connexion.php" method="post">
          <div class="row">
            <div class="subtitle col-lg-offset-3"><h3>Informations de connexion :</h3></div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="username">Nom d'utilisateur :</label>
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
            </div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="password">Mot de passe :</label>  
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <p class="col-lg-offset-2 errormessage"><?php echo $errorMessageConnexionUser; ?></p>
          </div>
          <div class="form-group col-lg-offset-7">
            <input type="checkbox">Se rappeler de moi !
          </div>
          <input type="submit" value="Se connecter !" name="connexion" class="button btn btn-default col-lg-offset-4">
          <div class="explication col-lg-offset-5"><p>J'ai perdu mes identifiants,<a href="/userfall.php">cliquez ici</a></p></div>
        </form>
          <p class="col-lg-offset-3 errormessage"><?php echo $errorMessageConnexionActive; ?></p>
    </div>
  </div>
</div>

<?php
  include 'View/footer.php'
?>
