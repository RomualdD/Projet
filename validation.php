<?php 
    include_once 'configuration.php';
    include_once 'View/header.php';
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Controller/validationController.php';
  if(!empty($_GET['log']) && (!empty($_GET['cle']))) {     
    if($users->actif == 1) {
        ?><p class="errormessage col-lg-12"><?php echo ALREADYACTIVATEDACCOUNT; ?></p><?php
    }
  else {
        if($users->cleverif == $clebdd) {
            ?><p class="col-lg-12"><?php echo ACTIVATEDACCOUNT; ?></p><?php
        }
        elseif($users->cleverif != $clebdd) {
           ?><p class="errormessage col-lg-12"><?php echo ERRORKEY; ?></p><?php 
        }
        else {
            ?><p class="errormessage"><?php echo NOTPOSSIBLEACTIVATE; ?></p><?php
        }
    }
  }
  else {
      ?><p class="errormessage"><?php echo MISSPARAMETER; ?></p><?php
  }
  include 'View/footer.php';
?>
