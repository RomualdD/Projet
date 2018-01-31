<?php
  include '../Model/bdd.php';
?>

<!-- Header non connecté -->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
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
          <div class="hello col-lg-offset-4 col-lg-1"><p>Bonjour</p></div>
        </div>
      </div>
      <div class="navbar navbar-default">
          <ul class="nav navbar-nav">
            <li><a href="http://diavk/View/" class=" col-lg-offset-8">Accueil</a></li>
            <li><a href="inscription.php" class="col-lg-offset-9">Inscription</a></li>
            <li><a href="connexion.php" class="col-lg-offset-8">Connexion</a></li>
            <li><a href="contact.php" class="col-lg-offset-9">Contact</a></li>
          </ul>
      </div>
    </header>