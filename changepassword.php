<?php
  include 'Model/dataBase.php';
  include 'Model/users.php';
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
 include 'View/header.php'; ?>
                    <div class="view">
                        <form method="post" action="changepassword.php?username=<?php echo $_GET['username'] ?>&cle=<?php echo $_GET['cle'] ?>">
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform" for="newpassword">Nouveau mot de passe :</label>
                                <div class="input-group newpassword col-lg-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="newpassword" placeholder="Nouveau mot de passe">
                                </div>
                            </div>
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform" for="passwordverif">Vérification nouveau mot de passe :</label>
                                <div class="input-group passwordverif col-lg-offset-3">
                                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                  <input type="password" class="form-control" name="passwordverif" placeholder="Vérification nouveau mot de passe">
                                </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorPassword; ?></p>
                            </div>
                            <input type="submit" value="Valider !" name="submitmodifpassword" class="button btn btn-default col-lg-offset-5">
                            <p class="successmessage"><?php echo $successMsg; ?></p>
                        </form>
                        <p>Retourner à la page <a href="/connexion.php">connexion</a></p>
                    </div>
<?php include 'View/footer.php'; ?>
