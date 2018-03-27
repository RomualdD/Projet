<?php
    session_start();
    include_once 'configuration.php';
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/follow.php';
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
    $follow = new follow();  
    $users = new users();
    // Récupération du paramètre
    $users->qrcodeParam = $idFollow = $_GET['idFollow'];
    // Si on est pas directement connecté
    if(isset($_POST['connexion'])) {
        if(!empty($_POST['username']) && (!empty($_POST['password']))) {
               $users->username = $_POST['username'];
               // Cryptage du mot de passe entré
               $users->password = $_POST['password'];
               // Cherche le nom d'utilisateur et le mot de passe entré
               $requestUser =  $users->getUser();
               $verifUser = $requestUser->username;
               $verifPassword = $requestUser->password;
              // Si les champs correspondent dans la base de données
              if($verifUser == $users->username && password_verify($users->password, $verifPassword)) {
                  // Vérification si le compte est bien actif
                  $verifactif = $users->getVerif();
                  $actif = $verifactif->active;
                 if($actif == '1') {
                    session_start();
                   // Démarrage d'une session
                   $infosUser = $users->getInfoConnexion();
                    //Enregistement dans la session:
                    if(isset($_POST['cookie'])) {                     
                        setcookie('user',$user->username,time()+ 365*24*3600,'/',null,0,1);
                        setcookie('firstname',$infosUser->firstname,time()+365*24*3600,'/',null,0,1);
                        setcookie('name',$infosUser->lastname,time()+365*24*3600,'/',null,0,1);
                        setcookie('role',$infosUser->role,time()+ 365*24*3600,'/',null,0,1);
                        setcookie('pathology',$infosUser->pathology,time()+ 365*24*3600,'/',null,0,1);
                    }
                   //Enregistement dans la session:
                   $_SESSION['user'] = $_POST['username'];
                   $_SESSION['password'] = $_POST['password'];
                   $_SESSION['role'] = $infosUser->role;
                   $_SESSION['pathology']= $infosUser->pathology;
                   $_SESSION['firstname'] = $infosUser->firstname;
                   $_SESSION['name'] = $infosUser->lastname; 
                 }
               }
             else {
                 echo 'Failed';
              }
           }
        else {
           echo ERRORINPUT;
        }
    } 
    // Si on est connecté
    if(isset($_SESSION['user'])) {
        $role = $_SESSION['role'];
        $user = $_SESSION['user'];
        $users->username = $_SESSION['user'];
        $userId = $users->getUserId();
        $follow->from = $id = $userId->id;
        // On recherche si y'a un utilisateur qui correspond au qrcode
        $researchidParam = $users->getIdByQrCode();
        // Si oui, on vérifie le suivi entre les deux personnes
        if($researchidParam != FALSE) {
            $roleUser = $researchidParam->role;
            $follow->to = $researchidParam->id;   
            $verif = $follow->getFollowAlready();
            // Si il n'y a pas de suivi alors on l'ajoute
            if($verif == '' && $follow->to != $follow->from && $roleUser != $role) {
                $follow->confirm = '1';
                $follow->addFollow();
            }
            // Si il y'a une demande alors on fait une modification
            elseif($verif == 0 && ($follow->to != $follow->from && $roleUser != $role)) {
              $follow->updateAddFollow(); 
            }        
        } 
    } 