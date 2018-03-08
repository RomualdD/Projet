<?php
  $user = new users();
  $errorPassword = '';
  $successMsg = '';
  if(isset($_GET['username']) && (isset($_GET['cle']))) {     
    $user->username = $_GET['username'];
    $clebdd = $_GET['cle'];
    $recupcle = $user->getCleVerifActif();
        if($user->cleverif == $clebdd) {
            if(isset($_POST['submitmodifpassword'])) {
                if(!empty($_POST['newpassword']) && (!empty($_POST['passwordverif']))) {
                        $newpassword = $_POST['newpassword'];
                        $newpasswordverif = $_POST['passwordverif'];
                        if ($newpassword == $newpasswordverif) {
                            $user->password = password_hash($newpassword,PASSWORD_DEFAULT);
                            $successMsg = 'Le mot de passe a bien était modifié !';
                            $recupMail = $user->getMailByUsername();
                            $user->mail = $recupMail->mail; 
                            $user->updatePasswordFall();
                            $recupUsername = $user->getUsernameByMail();
                            $key = $recupUsername['keyverif'];
                            $recipient = $user->mail;
                            $subject = "[IMPORTANT] Rappel de vos identifiants";
                            $entete = "From: inscriptiondiavk@gmail.com";
                            $message = 'Vous avez bien changé de mot de passe '."\r\n"
                            .'Ne pas répondre à ce message.';
                            mail($recipient, $subject,$message,$entete);
                        }
                        else {
                            $errorPassword = 'Les mots de passes ne sont pas identiques !';
                        }
                    }
                    else {
                        $errorPasswordFalse = 'Ce n\'est pas votre mot de passe !';
                    }
                }
                else {
                    $errormessage= 'Les champs ne sont pas tous remplis !';
                }
            }
        }

