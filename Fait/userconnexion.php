<?php
// -- // Connexion au site
    // Variable d'erreur
      $errorMessageUser = '';
      $errorMessageActive = '';

    if(isset($_POST['connexion'])) {
      // Si les champs sont remplis
      if(!empty($_POST['username']) && (!empty($_POST['password']))) {
           $user = $_POST['username'];
           $pass = $_POST['password'];
           // Cryptage du mot de passe entré
           $pass = sha1(md5($pass));
           // Cherche le nom d'utilisateur et le mot de passe entré
           $request = $db->query('SELECT `nom_utilisateur`,`mot_de_passe` FROM `utilisateurs` WHERE `mot_de_passe` = "'.$pass.'" AND `nom_utilisateur` = "'.$user.'"');
           $requestUser = $request->fetch(PDO::FETCH_ASSOC);
           $verifUser = $requestUser['nom_utilisateur'];
           $verifPassword = $requestUser['mot_de_passe'];
          // Si les champs correspondent dans la base de données
          if($verifUser == $user && $pass == $verifPassword) {
              // Vérification si le compte est bien actif
             $search = $db->prepare('SELECT `actif` FROM `utilisateurs` WHERE `nom_utilisateur` = :user');
             if($search->execute(array(':user' => $user)) && $row = $search->fetch()){
               $actif = $row['actif'];
             }
             if($actif == '1') {
               // Démarrage d'une session
               session_start();
               $requestInfo = $db->query('SELECT `role`,`pathologie` FROM `utilisateurs` WHERE `nom_utilisateur` = "'.$user.'"');
               $infosUser = $requestInfo->fetch(PDO::FETCH_ASSOC);
               $db = NULL;
               //Enregistement dans la session:
               $_SESSION['user'] = $_POST['username'];
               $_SESSION['password'] = $_POST['password'];
               $_SESSION['role'] = $infosUser['role'];
               $_SESSION['pathology']= $infosUser['pathologie'];
               if($_SESSION['role'] == 1) {
                    header('Location: profil.php');
               }
               else {
                 header('Location: medecinprofil.php');
               }
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