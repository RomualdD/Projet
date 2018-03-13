<?php
include_once 'configuration.php';
include_once 'Model/dataBase.php';
include_once 'Model/users.php';
$user = new users();
$errorMessageConnexionUser = '';

if(isset($_POST['fallSubmit'])) {
    if(!empty($_POST['mail'])) {
        $user->mail = $_POST['mail'];
        $password = md5(microtime(TRUE));
        $user->password = password_hash($password,PASSWORD_DEFAULT);
        $user->updatePasswordFall();
        $recupUsername = $user->getUsernameByMail();
        $username = $recupUsername->username;
        $key = $recupUsername->keyverif;
        $recipient = $user->mail;
        $subject = "[IMPORTANT] Rappel de vos identifiants";
        $entete = "From: inscriptiondiavk@gmail.com";
        $message = 'Votre nom d\'utilisateur est '.$username."\r\n"
                .'https://diavk/changer-mot-de-passe?username='.urlencode($username).'&cle='.urlencode($key)."\r\n"
        .'Ne pas répondre à ce message.';
        mail($recipient, $subject,$message,$entete);
    }
}

