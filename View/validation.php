<?php
  include '../Model/dataBase.php';
  include '../Model/users.php';
  include '../Controller/validationController.php';
  include 'header.php';
  if(isset($_GET['log']) && (isset($_GET['cle']))) {     
    if($users->actif == 1) {
        ?><p class="errormessage col-lg-12">Votre compte est déjà actif !</p><?php
    }
  else {
        if($users->cleverif == $clebdd) {
            ?><p class="col-lg-12">Votre compte a bien été activé.</p><?php
        }
        else {
            ?><p class="errormessage">Erreur ! Votre compte ne peut être activé...</p><?php
        }
    }
  } 
  include 'footer.php';
?>
