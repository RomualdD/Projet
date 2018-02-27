<?php
    $errorMessageName = '';
    $errorMessageFirstname = '';
    $errorMessageMail = '';
    $errorMessageBirthday = '';
    $errorMessagePhone = '';
    $errorMessageUser = '';
    $errorMessagePassword = '';
    $errorMessagePathology = '';
if(isset($_POST['inscriptionusername'])) {
  include_once '../Model/dataBase.php';
  include_once '../Model/users.php';
    $user = new users();
    $user->username = $_POST['inscriptionusername'];
    $verifusername = $user->getUsername();    
    if($user->username == $verifusername['username']) {
      echo 'Failed';
    } else {
        echo 'Success';
    }
}
    $user = new users();

if(isset($_POST['submit'])) {
     // Vérification si les champs sont bien remplis
     if(!empty($_POST['name']) && (!empty($_POST['firstname'])) && (!empty($_POST['password'])) && (!empty($_POST['passwordverif'])) && (!empty($_POST['mail'])) && (!empty($_POST['birthday'])) && (!empty($_POST['phone'])))  {
        $error = 0;
        /* Enregistrement des données des champs
         * Vérifications des regex
         * On évite les éléments comme balise html/php
         */
        if(preg_match('#^[a-zA-ZéçèàûüÛÜÉÀÇÈ\- ]{1,30}$#', $_POST['name'])) {
            // Mise en majuscule du nom
            $user->name = strtoupper(strip_tags($_POST['name']));
        }
        else {
            $errorMessageName = 'Le nom n\'est pas valide';
            $error++;
        }
        if(preg_match('#^[a-zA-ZéçèàûüÛÜÉÀÇÈ\- ]{1,30}$#', $_POST['firstname'])) {
          $user->firstname = strip_tags($_POST['firstname']);     
        }
        else {
            $errorMessageFirstname = 'Le prénom n\'est pas valide';
            $error++;
        }
        if(preg_match('#^[a-zA-ZéçèàûüÛÜÉÀÇÈ\- ]{1,30}$#', $_POST['username'])) {
            $user->username = strip_tags($_POST['username']); 
        }
        if(preg_match('#^[\w\-\.]+[a-z0-9]@[\w\-\.]+[a-z0-9]\.[a-z]{2,}$#',$_POST['mail'])) {
            $user->mail = strip_tags($_POST['mail']);   
        }
        else {
            $errorMessageMail = 'Le mail n\'est pas valide !';
            $error++;
        }
        $user->password = $_POST['password'];
        $passwordverif = $_POST['passwordverif'];
        if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['birthday']) || preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['birthday']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['birthday'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['birthday']))) {
           $user->birthday = strip_tags($_POST['birthday']);   
        }
        else {
            $errorMessageBirthday = 'La date n\'est pas valide';
            $error++;
        }
        if(preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['phone'])) {
            $user->phone = strip_tags($_POST['phone']);      
        }
        else {
            $errorMessagePhone = 'Le numéro de téléphone n\'est pas valide !';
            $error++;
        }
       $user->role = $_POST['role'];
       $user->pathology = $_POST['pathology'];
       $user->phone2 = 'Pas indiqué';
       $user->qrcodeParam = md5(microtime(TRUE)*100000);
       if($user->role == 0) {
         $user->pathology = 0;
       }
        if($error == 0) {
            if(($user->role == 1 && $user->pathology != 0) || ($user->role == 0 && $user->pathology == 0)) {
             // On vérifie que les mots de passes sont identiques
                if($user->password == $passwordverif) {
                // Cryptage de données mdp
                  $user->password = password_hash($user->password,PASSWORD_DEFAULT);  
                    // Vérification qu'un utilisateur n'a pas le même nom
                  $verifusername = $user->getUsername();             
                  if($user->username == $verifusername['username']) {
                    $errorMessageUser = 'Nom d\'utilisateur déjà utilisé!';
                  }
                  else {
                    // Clé généré aléatoirement
                    $user->cleverif = md5(microtime(TRUE)*100000);
                    // Indique qu'il faut le vérifier
                    $user->actif = 0;
                    // Inclusion dans la bdd
                    $user->addUser();
                    //Envoie du mail d'activation
                    $recipient = $user->mail;
                    $subject = '[IMPORTANT] Activation de votre compte di-A-vk';
                    $entete = 'From: inscriptiondiavk@gmail.com';
                    $message = 'Bienvenue sur di-A-vk,'. "\r\n"
                    .'Afin de continuer sur le site veuillez activer votre compte en cliquant sur ce lien:'."\r\n"
                    .'https://diavk/validation.php?log='.urlencode($user->username).'&cle='.urlencode($user->cleverif)."\r\n"
                    .'Ne pas répondre à ce message.';
                    mail($recipient, $subject,$message,$entete);
                    //Informer l'utilisateur que l'inscription est bien prise en compte
                    //Redirection vers la page de connexion
                    header('Location: connexion.php');
                    exit();
                   }
                }
                else {
                  $errorMessagePassword = 'Mot de passe différent';
                }
            }
            else {
             $errorMessagePathology = 'Veuillez choisir votre pathologie !';
            }
        }
     }
    else {
        echo  'Les champs ne sont pas remplis.';
    }
  }