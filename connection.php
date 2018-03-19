<?php
include_once 'assets/lang/'.(isset($_GET['lang'])? $_GET['lang']: 'FR_FR').'.php';
    include_once 'Controller/connectionController.php';
    include_once 'View/header.php';
?>
<!-- Page de connexion -->
  <div class="container view">
    <div class="row">
      <div class="col-lg-offset-5"><h2><?php echo CONNECTION; ?></h2></div>
    </div>
    <div class="message col-lg-offset-2"><p><?php echo CONNEXIONMESSAGE; ?></p>
    <p><?php echo CONNEXIONMESSAGETWO; ?> <a href="inscription" class="link"><?php echo REGISTER; ?></a>.</p></div>
    <div class="row">
      <div class="connexion col-lg-offset-3 col-lg-5">
        <form action="connection.php" method="post">
          <div class="row">
            <div class="subtitle col-lg-offset-3"><h3><?php echo INFORMATIONCONNEXION; ?></h3></div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="username"><?php echo USERNAME; ?></label>
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" placeholder="<?php echo USERNAMEPLACEHOLDER; ?>" required>
            </div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="password"><?php echo PASSWORDCONNECT; ?></label>  
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" placeholder="<?php echo PASSWORDPLACEHOLDER; ?>" required>
            </div>
            <p class="col-lg-offset-2 errormessage"><?php echo $errorMessageConnexionUser; ?></p>
          </div>
          <div class="form-group col-lg-offset-7">
            <input type="checkbox" name="cookie"><?php echo RECALL; ?>
          </div>
          <input type="submit" value="<?php echo CONNECTBUTTON; ?>" name="connexion" class="button btn btn-default col-lg-offset-4">
          <div class="explication col-lg-offset-5"><p><?php echo LOOSELOGIN; ?> <a href="mot-de-passe-oublier"><?php echo CLICK; ?></a></p></div>
        </form>
          <p class="col-lg-offset-3 errormessage"><?php echo $errorMessageConnexionActive; ?></p>
    </div>
  </div>
</div>

<?php
  include 'View/footer.php'
?>
