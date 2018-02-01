<?php
  $users = new users();
  if(isset($_GET['log']) && (isset($_GET['cle']))) {     
    $users->username = $_GET['log'];
    $clebdd = $_GET['cle'];
    $recupcle = $users->getCleVerifActif();
    if($users->actif == 0) {
        if($users->cleverif == $clebdd) {
            $users->updateActif();
        }
    }
 }