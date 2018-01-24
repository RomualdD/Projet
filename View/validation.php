<?php
  include 'header.php';
  if(isset($_GET['log']) && (isset($_GET['cle']))) {
      
    $user = $_GET['log'];
    $cle = $_GET['cle'];

    $recupcle = $bdd->prepare('SELECT `cleverif`, `actif` FROM `utilisateurs` WHERE `nom_utilisateur` like :user');
    if($recupcle->execute(array(':user' => $user)) && $row = $recupcle->fetch()) {
        $clebdd = $row['cleverif'];
        $actif = $row['actif'];
    }
    if($actif == 1) {
        ?><p class="errormessage col-lg-12">Votre compte est déjà actif !</p><?php
    }
  else {
        if($cle == $clebdd) {
            ?><p class="col-lg-12">Votre compte a bien été activé.</p><?php
            $stmt = $bdd->prepare('UPDATE `utilisateurs` SET `actif` = 1 WHERE `nom_utilisateur` like :user ');
            $stmt->bindParam(':user', $user);
            $stmt->execute();
        }
        else {
            ?><p class="errormessage">Erreur ! Votre compte ne peut être activé...</p><?php
        }
    }
  } 
  include 'footer.php';
?>
