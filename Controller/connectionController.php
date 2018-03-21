<?php
$infoAjax = false;
if (isset($_POST['testconnexionajax'])) {
    include_once '../configuration.php';
    include_once '../Model/dataBase.php';
    include_once '../Model/users.php';
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    switch ($lang) {
        case 'fr':
        case 'fr-fr':
            include_once '../assets/lang/FR_FR.php';
        break;
        case 'en':
            include_once '../assets/lang/EN_EN.php';
        break;
        default:
            include_once 'assets/lang/EN_EN.php';
        break;
    }
    $infoAjax = true;
}
else {
    include_once 'configuration.php';
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
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
}
$user = new users();
// Variable d'erreur
$error = 0;
$errorMessageConnexionUser = '';
$errorMessageConnexionActive = '';
if (isset($_POST['connexion'])) {
    // Si les champs sont remplis
    if (!empty($_POST['username']) && (!empty($_POST['password']))) {
        $user->username = strip_tags($_POST['username']);
        $user->password = $_POST['password'];
        // Cherche le nom d'utilisateur et le mot de passe entré
        $requestUser = $user->getUser();
        if($requestUser != NULL) {
            // Si les champs correspondent dans la base de données
            if ($requestUser->username == $user->username && password_verify($user->password, $requestUser->password)) {
                // Vérification si le compte est bien actif
                $verifactif = $user->getVerif();
                $actif = $verifactif->active;
                if ($actif == '1') {
                    session_start();
                    $infosUser = $user->getInfoConnexion();
                    //Enregistement dans la session:
                    if(isset($_POST['cookie'])) {                     
                        setcookie('user',$user->username,time()+ 365*24*3600,'/',null,0,1);
                        setcookie('firstname',$infosUser->firstname,time()+365*24*3600,'/',null,0,1);
                        setcookie('name',$infosUser->lastname,time()+365*24*3600,'/',null,0,1);
                        setcookie('role',$infosUser->role,time()+ 365*24*3600,'/',null,0,1);
                        setcookie('pathology',$infosUser->pathology,time()+ 365*24*3600,'/',null,0,1);
                    }
                    $_SESSION['user'] = $user->username;
                    $_SESSION['firstname'] = $infosUser->firstname;
                    $_SESSION['name'] = $infosUser->lastname;
                    $_SESSION['role'] = $infosUser->role;
                    $_SESSION['pathology'] = $infosUser->pathology;
                    if($infoAjax == false) {
                        if($_SESSION['role'] != 1) {
                            header('Location: votre-profil');   
                        }
                        else {
                            header('Location: /');
                        }
                        exit();
                    }
                    else {
                        echo 'Success';
                    }
                }
                else {
                    $errorMessageConnexionActive = ACCOUNTNOTACTIVATE;
                    $error++;
                }
            }
            else {
                $errorMessageConnexionUser = INCORRECTLOGIN;
                $error++;
            }   
        }
        else {
            $errorMessageConnexionUser = INCORRECTLOGIN;
        }
    }
    else {
        echo ERRORINPUT;
        $error++;
    }
    if ($error > 0 && $infoAjax == true) {
        echo 'Failed';
    }
}