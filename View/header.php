<?php 
    if(!isset($_SESSION['user'])) {
        include_once 'Model/dataBase.php';
        include_once 'Model/users.php';
?>
<!-- Header non connecté -->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="../logo.ico" />
    <script src="../assets/js/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="../assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>di-A-vk: La santé avant tout</title>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="row">
          <div class="logo col-lg-1"><img src="../assets/img/logo.png" alt="logosite" title="logosite" width="50px" height="50px"/></div>
          <div class="title col-lg-offset-4 col-lg-2"><h1>di-A-vk</h1></div>
          <div class="hello col-lg-offset-2 col-lg-3"><a href="inscription.php"><p>S'inscrire</p></a><div data-toggle="modal" data-target="#myModalConnexion"><p class="connexionheader">Se connecter</p></div></div>          
          <div class="modal fade" id="myModalConnexion" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h3 class="modal-title"> Connexion :</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                              <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9" for="username">Nom d'utilisateur :</label>
                                <div class="input-group username col-lg-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" id="username" class="form-control" name="username" placeholder="Nom d'utilisateur ou mail" required>
                                </div>
                              </div>
                              <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9" for="password">Mot de passe :</label>  
                                <div class="input-group password col-lg-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe" required>
                                </div>
                              </div>  
                              <input type="submit" value="Se connecter !" id="connexion" name="connexion" class="button btn btn-default col-lg-offset-4">
                            </div>
                        </div>
                        <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fermer</button>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="navbar navbar-default">
          <ul class="nav navbar-nav">
            <li><a href="http://diavk/" class=" col-lg-offset-8">Accueil</a></li>
            <li><a href="inscription.php" class="col-lg-offset-9">Inscription</a></li>
            <li><a href="connexion.php" class="col-lg-offset-8">Connexion</a></li>
            <li><a href="contact.php" class="col-lg-offset-9">Contact</a></li>
          </ul>
      </div>
    </header>
      <script src="assets/js/script.js"></script>
  <?php  }
  else { ?>
      <!-- Header connecté -->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <script src="../assets/js/canvasjs.min.js"></script>
    <script src="../assets/js/jquery-3.2.1.slim.min.js"></script>
    <link rel="icon" href="../logo.ico" />
    <link rel="stylesheet" href="../assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>di-A-vk: La santé avant tout</title>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="row">
          <div class="logo col-lg-1"><img src="../assets/img/logo.png" alt="logosite" title="logosite" width="50px" height="50px"/></div>
          <div class="title col-lg-offset-4 col-lg-2"><h1>di-A-vk</h1></div>
          <div class="hello col-lg-offset-2 col-lg-3"><p>Bonjour <?php echo isset($_SESSION['user']) ? strip_tags($_SESSION['user']) : ''; ?></p></div>
        </div>
      </div>
      <div class="navbar navbar-default">
          <ul class="nav navbar-nav">
            <li><a href="http://diavk/" class="col-lg-offset-2">Accueil</a></li>
            <li><a href="http://diavk/profil.php" class="col-lg-offset-9">Profil</a></li>
            <li><a href="http://diavk/information.php" class="col-lg-offset-8">Information</a></li>
            <li><a href="http://diavk/suivi.php" class="col-lg-offset-9">Suivi</a></li>
            <li><a href="http://diavk/contact.php" class="col-lg-offset-9">Contact</a></li>
            <li><a href="http://diavk/Controller/deconnexion.php" class="col-lg-offset-7">Déconnexion</a></li>
          </ul>
      </div>
    </header>
  <?php }
  ?>