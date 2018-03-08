<?php
  $users = new users();
  if(!empty($_GET['log']) && (!empty($_GET['cle']))) {     
    $users->username = $_GET['log'];
    $clebdd = $_GET['cle'];
    $recupcle = $users->getCleVerifActif();
    if($recupcle != FALSE) {
        if($users->actif == 0) {
            if($users->cleverif == $clebdd) {
                $users->updateActif();
            }
        }   
    }
 }