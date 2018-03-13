<?php
    include_once 'configuration.php';
  include_once 'Model/dataBase.php';
  include_once 'Model/users.php';
  include_once 'Controller/validationController.php';
  include_once 'View/header.php';
  if(!empty($_GET['log']) && (!empty($_GET['cle']))) {     
    if($users->actif == 1) {
        ?><p class="errormessage col-lg-12">Votre compte est déjà actif !</p><?php
    }
  else {
        if($users->cleverif == $clebdd) {
            ?><p class="col-lg-12">Votre compte a bien été activé.</p><?php
        }
        elseif($users->cleverif != $clebdd) {
           ?><p class="errormessage col-lg-12">Clé non correspondante.</p><?php 
        }
        else {
            ?><p class="errormessage">Erreur ! Votre compte ne peut être activé...</p><?php
        }
    }
  }
  else {
      ?><p class="errormessage">Erreur ! Il n'y a pas de paramètre.</p><?php
  }
  include 'View/footer.php';
?>
