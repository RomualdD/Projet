<?php
  include "header.php";

  $user = $_GET['log'];
  $cle = $_GET['cle'];

  $recupcle = $bdd->prepare('SELECT cleverif, actif FROM utilisateurs WHERE nom_utilisateur like :user');
  if($recupcle->execute(array(':user' => $user)) && $row = $recupcle->fetch()) {
    $clebdd = $row['cleverif'];
    $actif = $row['actif'];
   }
  if($actif == 1) {
    echo 'Votre compte est déjà actif !';
  }
  else {
    if($cle == $clebdd) {
      echo "Votre compte a bien été activé.";
      $stmt = $bdd->prepare("UPDATE utilisateurs SET actif = 1 WHERE nom_utilisateur like :user ");
      $stmt->bindParam(':user', $user);
      $stmt->execute();
    }
    else {// Si les deux clés sont différentes on provoque une erreur...
     echo "Erreur ! Votre compte ne peut être activé...";
     }
  }
?>
