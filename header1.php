<?php
  include 'bdd.php';

  $user=$_SESSION['user'];
  $role = $_SESSION['role'];
    $result = $bdd->query('SELECT `id` FROM `utilisateurs` WHERE `nom_utilisateur` ="'.$user.'"');
    $id = $result->fetch();
    $id= $id['id'];
 ?>

<!-- Header connecté -->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <script src="/assets/js/angular.min.js.map"></script>
    <script src="/assets/js/angular.min.js"></script>
    <script src="/assets/js/canvasjs.min.js"></script>
    <script src="assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <link rel="icon" href="logo.ico" />
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>di-A-vk: La santé avant tout</title>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="row">
          <div class="logo col-lg-1"><img src="assets/img/logo.png" alt="logosite" title="logosite" width="50px" height="50px"/></div>
          <div class="title col-lg-offset-4 col-lg-2"><h1>di-A-vk</h1></div>
          <div class="hello col-lg-offset-2 col-lg-3"><p>Bonjour <?php echo htmlspecialchars($user); ?></p></div>
        </div>
      </div>
      <div class="navbar navbar-default">
          <ul class="nav navbar-nav">
            <li><a href="http://diavk/" class="col-lg-offset-2">Accueil</a></li>
            <li><a href="profil.php" class="col-lg-offset-9">Profil</a></li>
            <li><a href="information.php" class="col-lg-offset-8">Information</a></li>
            <li><a href="suivi.php" class="col-lg-offset-9">Suivi</a></li>
            <li><a href="contact.php" class="col-lg-offset-9">Contact</a></li>
            <li><a href="deconnexion.php" class="col-lg-offset-7">Déconnexion</a></li>
          </ul>
      </div>
    </header>
