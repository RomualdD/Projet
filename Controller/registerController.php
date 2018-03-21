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
  include_once '../configuration.php';
  include_once '../Model/dataBase.php';
  include_once '../Model/users.php';
    $user = new users();
    $user->username = strip_tags($_POST['inscriptionusername']);
    $verifusername = $user->getUsername();    
    if($user->username == $verifusername->username) {
      echo 'Failed';
    } else {
        echo 'Success';
    }
}
    $pathology = new pathology();
    $role = new role();
    $pathologyinfos = $pathology->getPathology();
    $roleinfos = $role->getRole();
    $user = new users();
if(isset($_POST['submit'])) {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        switch ($lang) {
            case 'fr':
                include_once 'assets/lang/FR_FR.php';
            break;
            case 'en':
                include_once 'assets/lang/EN_EN.php';
            break;
            default:
                include_once 'assets/lang/EN_EN.php';
            break;
        }  
     // Vérification si les champs sont bien remplis
     if(!empty($_POST['name']) && (!empty($_POST['firstname'])) && (!empty($_POST['password'])) && (!empty($_POST['passwordverif'])) && (!empty($_POST['mail'])) && (!empty($_POST['birthday'])) && (!empty($_POST['phone'])))  {
        $error = 0;
        /* Enregistrement des données des champs
         * Vérifications des regex
         * On évite les éléments comme balise html/php
         */
        if(preg_match('#^[a-zA-ZéçèàûüÛÜÉÀÇÈ\- ]{2,30}$#', $_POST['name'])) {
            // Mise en majuscule du nom
            $user->name = strtoupper(strip_tags($_POST['name']));
        }
        else {
            $errorMessageName = ERRORNAME;
            $error++;
        }
        if(preg_match('#^[a-zA-ZéçèàûüÛÜÉÀÇÈ\- ]{2,30}$#', $_POST['firstname'])) {
          $user->firstname = strip_tags($_POST['firstname']);     
        }
        else {
            $errorMessageFirstname = ERRORFIRSTNAME;
            $error++;
        }
        if(preg_match('#^[a-zA-ZéçèàûüÛÜÉÀÇÈ0-9@$!.\- ]{2,30}$#', $_POST['username'])) {
            $user->username = strip_tags($_POST['username']); 
        }
        else  {
            $errorMessageUser = ERRORUSERNAME;
        }
        if(filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $user->mail = strip_tags($_POST['mail']);   
        }
        else {
            $errorMessageMail = ERRORMAIL;
            $error++;
        }
        $user->password = $_POST['password'];
        $passwordverif = $_POST['passwordverif'];
        if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['birthday']) || preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['birthday']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['birthday'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['birthday']))) {
           $user->birthday = strip_tags($_POST['birthday']);   
        }
        else {
            $errorMessageBirthday = ERRORDATE;
            $error++;
        }
        if(preg_match("#^0[1-678]([-. ]?[0-9]{2}){4}$#", $_POST['phone'])) {
            $user->phone = strip_tags($_POST['phone']);      
        }
        else {
            $errorMessagePhone = ERRORPHONE;
            $error++;
        }
       $user->role = $_POST['role'];
       $user->pathology = $_POST['pathology'];
       $user->phone2 = 'Pas indiqué';
       $user->qrcodeParam = md5(microtime(TRUE)*100000);
       if($user->role == 3) {
         $user->pathology = 1;
       }
        if($error == 0) {
            if(($user->role == 2 && $user->pathology != 1) || ($user->role == 3 && $user->pathology == 1)) {
             // On vérifie que les mots de passes sont identiques
                if($user->password == $passwordverif) {
                // Cryptage de données mdp
                  $user->password = password_hash($user->password,PASSWORD_DEFAULT);  
                    // Vérification qu'un utilisateur n'a pas le même nom
                  $verifusername = $user->getUsername();
                  if($verifusername != FALSE) {
                    if($user->username == $verifusername->username) {
                        $errorMessageUser = ERRORUSERNAMEALREADY;
                    }
                  }
                  else {
                    $user->language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);;  
                    // Clé généré aléatoirement
                    $user->cleverif = md5(microtime(TRUE)*100000);
                    // Indique qu'il faut le vérifier
                    $user->actif = 0;
                    // Inclusion dans la bdd
                    if($user->addUser()) {
                        //Envoie du mail d'activation
                        $recipient = $user->mail;
                        $subject = REGISTERSUBJECTMAIL;
                        $entete = REGISTERHEADINGMAIL;
                        $message = REGISTERFIRSTMESSAGEMAIL."\r\n"
                        .REGISTERSECONDMESSAGEMAIL."\r\n"
                        .'https://diavk/compte-validation?log='.urlencode($user->username).'&cle='.urlencode($user->cleverif)."\r\n"
                        .NOTREPLYMESSAGE;
                        mail($recipient, $subject,$message,$entete);
                        //Informer l'utilisateur que l'inscription est bien prise en compte
                        //Redirection vers la page de connexion
                        header('Location: connexion');
                        exit();   
                    }
                   }
                }
                else {
                  $errorMessagePassword = PASSWORDIDENTICERROR;
                }
            }
            else {
             $errorMessagePathology = ERRORPATHOLOGY;
            }
        }
     }
    else {
        echo ERRORINPUT;
    }
  }