<?php
$infoAjax = false;
if (isset($_POST['testconnexionajax']))
{
    include_once '/Model/dataBase.php';
    include_once '/Model/users.php';
    $infoAjax = true;
}
else
{
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
}
$user = new users();
// Variable d'erreur
$error = 0;
$errorMessageConnexionUser = '';
$errorMessageConnexionActive = '';
if (isset($_POST['connexion']))
{
    // Si les champs sont remplis
    if (!empty($_POST['username']) && (!empty($_POST['password']))) {
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        // Cherche le nom d'utilisateur et le mot de passe entré
        $requestUser = $user->getUser();
        $verifUser = $requestUser['username'];
        $verifPassword = $requestUser['password'];
        // Si les champs correspondent dans la base de données
        if ($verifUser == $user->username && password_verify($user->password, $verifPassword)) {
            // Vérification si le compte est bien actif
            $verifactif = $user->getVerif();
            $actif = $verifactif['active'];
            if ($actif == '1') {
                session_start();
                $infosUser = $user->getInfoConnexion();
                //Enregistement dans la session:
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['role'] = $infosUser['role'];
                $_SESSION['pathology'] = $infosUser['pathology'];
                if($infoAjax == false)
                {
                    header('Location: profil.php');
                    exit();
                }
                else
                {
                    echo 'Success';
                }
            }
            else {
                $errorMessageConnexionActive = 'Veuillez activez votre compte !';
                $error++;
            }
        }
        else {
            $errorMessageConnexionUser = 'Utilisateur ou mot de passe incorrect !';
            $error++;
        }
    }
    else {
        echo 'Tous les champs n\'ont pas était remplis !';
        $error++;
    }
    if ($error > 0 && $infoAjax == true) {
        echo 'Failed';
    }
}