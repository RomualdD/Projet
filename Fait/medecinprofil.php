<?php
    include '../Model/verificationconnexion.php';
    if(isset($_SESSION['user'])) {  
        if($_SESSION['role'] == 1) {
            header('Location: profil.php');
        }
        include '../Model/modificationprofilmedecin.php';
        include '../Model/modifprofil.php';
    ?>
    <!-- Page profil médecin -->
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-5"><h2>Profil</h2></div>
        </div>
        <div class="row">
            <div class="profil col-lg-offset-3 col-lg-5">
                <div class="subtitle col-lg-offset-3"><h3>Informations du médecin :</h3></div>
                <div class="form-inline">
                    <div class="input-group name col-lg-offset-3">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="name" value="<?php echo $name ?>"/>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group surname col-lg-offset-3">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="firstname" value="<?php echo $surname ?>"/>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group birthday col-lg-offset-3">
                        <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="birthday" value="<?php echo $birthday ?>">
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group username col-lg-offset-3">
                        <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="username" value="<?php echo $user ?>">
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group mail col-lg-offset-3">
                        <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="mail" value="<?php echo $mail ?>">
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group phone col-lg-offset-3">
                        <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="phone" value="<?php echo $phone ?>">
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group otherphone col-lg-offset-3">
                        <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" disabled="true" name="otherphone" value="<?php echo $otherphone ?>">
                    </div>
                </div>
            </div>
            <div class="modificate col-lg-offset-3 col-lg-5">
                <div class="row">
                    <div class="subtitle col-lg-offset-1"><h3>Informations du compte à modifier :</h3></div>
                    <form name="modifpassword" method="POST" action="medecinprofil.php">
                        <div class="form-inline">
                            <label class="col-lg-offset-3 col-lg-9 modificateform" for="password">Mot de passe actuel :</label>
                            <div class="input-group password col-lg-offset-3">
                                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Mot de passe actuel">
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorPasswordFalse; ?></p>
                        </div>
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
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorPassword ?></p>
                        </div>
                        <input type="submit" value="Valider !" name="submitmodifpassword" class="button btn btn-default col-lg-offset-5">
                    </form>
                    <p class="successmessage"><?php echo $successMsg; ?></p>
                </div>
                <div class="row">
                    <div class="modificatemail col-lg-offset-3">
                        <div class="form-inline">
                            <div class="input-group mail">
                                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="newmail" placeholder="Nouvelle adresse mail" ng-model='mail.text' ng-pattern='mail.regex' required>
                            </div>
                        </div>
                        <input type="submit" value="Modifier !" name="modificatemail" class="button btn btn-default col-lg-offset-3">
                    </div>
                </div>
                <div class="row">
                    <div class="modificatenum col-lg-offset-3">
                        <div class="form-inline">
                            <div class="input-group mail">
                                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="modifnum" placeholder="Modifier numéro de téléphone">
                            </div>
                        </div>
                        <input type="submit" value="Modifier !" name="addnum" class="button btn btn-default col-lg-offset-3">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="search col-lg-offset-4">
                <?php
                // Affichage du nombre de demande
                if ($requestfollow->rowCount() == 0) {
                    ?><p><?php
                    echo 'Vous n\'avez aucune demande !';?></p><?php
                }
                else {
                    while ($request = $requestfollow->fetch()) {
                        $nbquest++;
                    }
                    if ($nbquest > 1) {
                        $infoQuest = 'Vous avez ' . $nbquest . ' demandes.';
                    }
                    else {
                        $infoQuest = 'Vous avez ' . $nbquest . ' demande.';
                    }
                    ?>
                <p><?php echo $infoQuest ;?></p>
                <div class="form-inline">
                    <form method="POST" action="demande.php">
                        <input type="submit" value="Voir les demandes" name="answerdoctor" class="button btn btn-default col-lg-offset-1">
                    </form>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div>
            <form method="POST" action="ajout.php">
                <input type="text" name="name" class="col-lg-offset-3 col-lg-2"/>
                <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
            </form>
        </div>
        <div class="col-lg-offset-3">
            <h4>Votre QRCode pour permettre à votre patient de vous suivre instantané</h4>
            <img src="../Model/qrcode.php" class="col-lg-offset-3">
        </div>
    </div>
    <?php
    }
include 'footer.php';
?>
