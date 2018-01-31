<?php
    $user = new users();
    // Variable d'erreur
      $errorMessageUser = '';
      $errorMessageActive = '';
    if(isset($_POST['connexion'])) {
      // Si les champs sont remplis
      if(!empty($_POST['username']) && (!empty($_POST['password']))) {
           $user->username = $_POST['username'];
           // Cryptage du mot de passe entré
           $user->password = sha1(md5($_POST['password']));
           // Cherche le nom d'utilisateur et le mot de passe entré
           $requestUser =  $user->getUser();
           $verifUser = $requestUser['nom_utilisateur'];
           $verifPassword = $requestUser['mot_de_passe'];
          // Si les champs correspondent dans la base de données
          if($verifUser == $user->username && $user->password == $verifPassword) {
              // Vérification si le compte est bien actif
              $verifactif = $user->getVerif();
              $actif = $verifactif['actif'];
             if($actif == '1') {
               // Démarrage d'une session
               session_start();
               $infosUser = $user->getInfoConnexion();
               //Enregistement dans la session:
               $_SESSION['user'] = $_POST['username'];
               $_SESSION['password'] = $_POST['password'];
               $_SESSION['role'] = $infosUser['role'];
               $_SESSION['pathology']= $infosUser['pathologie'];
               header('Location: profil.php');
             }
             else {
               $errorMessageActive = 'Veuillez activez votre compte !';
             }
           }
         else
          {
             $errorMessageUser = 'Utilisateur ou mot de passe incorrect !';
          }
       }
       else {
          echo 'Tous les champs n\'ont pas était remplis !';
        }
    }