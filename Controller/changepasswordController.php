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
                            $successMsg = PASSWORDMODIFICATESUCCESS;
                            $recupMail = $user->getMailByUsername();
                            $user->mail = $recupMail->mail; 
                            $user->updatePasswordFall();
                            $recupUsername = $user->getUsernameByMail();
                            $key = $recupUsername->keyverif;
                            $recipient = $user->mail;
                            $subject = PASSWORDMODIFSUBJECTMAIL;
                            $entete = PASSWORDMODIFHEADING;
                            $message = PASSWORDMODIFMESSAGE ."\r\n"
                            .NOTREPLYMESSAGE;
                            mail($recipient, $subject,$message,$entete);
                        }
                        else {
                            $errorPassword = PASSWORDIDENTICERROR;
                        }
                    }
                    else {
                        $errorPasswordFalse = PASSWORDNOTGOOD;
                    }
                }
                else {
                    $errormessage= ERRORINPUT;
                }
            }
        }

