<?php
  include '../Controller/verificationconnexion.php';
   if(isset($_SESSION['user'])) { 
       include '../Model/follow.php';
       include '../Model/verification.php';
       include '../Controller/profilController.php';
?>
<!-- Page profil type -->
    <div class="container">
      <div class="row">
        <div class="col-lg-offset-5"><h2>Votre profil</h2></div>
      </div>
      <div class="row">
        <div class="profil col-lg-offset-3 col-lg-5">
          <div class="subtitle col-lg-offset-3"><h3>Vos informations :</h3></div>
          <div class="form-inline">
            <div class="input-group name col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="name" value="<?php echo $user->name; ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group surname col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="surname" value="<?php echo $user->firstname; ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group birthday col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="birthday" value="<?php echo $user->birthday; ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="username" value="<?php echo $user->username; ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group mail col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="mail" value="<?php echo $user->mail; ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group phone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="phone" value="<?php echo $user->phone; ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group otherphone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="otherphone" value="<?php echo $user->phone2; ?>">
            </div>
          </div>
          <?php if($_SESSION['role']!=0) { ?>
          <div class="form-inline">
            <div class="input-group pathology col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled name="pathology" value="<?php echo $user->pathology; ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="formular col-lg-offset-3 col-lg-5">
            <div class="subtitle col-lg-offset-1"><h3>Formulaire d'informations médicales :</h3></div>
            <?php 
                if($pathology == 1 || $pathology == 2) {
                    if($info != 0) {
            ?>
            <form name="modifverif" method="POST" action="profil.php">
                <div class="form-inline">
                  <div class="input-group date col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                      <select name="timeverif">
                          <option value="">Vérification par :</option>
                        <option value="Heure">Heure</option>
                        <option value="Jours">Jours</option>
                        <option value="Mois">Mois</option>
                      </select>
                  </div>
                </div>
                <div class="form-inline">
                  <div class="input-group clock col-lg-offset-3 col-lg-6">
                      <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                      <input type="time" class="form-control" name="clockone" placeholder="Heures de vérification">
                      <input type="time" class="form-control" name="clocktwo" placeholder="<?php echo date('H:i'); ?>">
                      <input type="time" class="form-control" name="clockthree">
                      <input type="time" class="form-control" name="clockfour">
                  </div>
                    <div class="info col-lg-offset-3"><p>Format HH:mm</p></div>
                    <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorModifOneClock.' '.$errorModifTwoClock.' '.$errorModifThreeClock.' '.$errorModifFourClock; ?></p>
                </div>
               <div class="form-inline">
                  <div class="input-group notif col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                      <select name="notification">
                        <option value="">Notifications par :</option>
                        <option value="SMS">SMS</option>
                        <option value="Mail">Mail</option>
                      </select>
                  </div>
                </div>
                <input type="submit" value="Modifier !" name="modif" class="button btn btn-default col-lg-offset-5">            
            </form>
            <p class="successmessage"><?php echo $successModifMsg ?></p>
                   <?php
                    }
                    else {  
            ?>
            <form  name="addverif" method="POST" action="profil.php">
                <div class="form-inline">
                  <div class="input-group date col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                      <select name="timeverif">
                        <option>Vérification par :</option>
                        <option value="Heure">Heure</option>
                        <option value="Jours">Jours</option>
                        <option value="Mois">Mois</option>
                      </select>
                  </div>
                </div>
                <div class="form-inline">
                  <div class="input-group clock col-lg-offset-3 col-lg-6">
                      <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                      <input type="time" class="form-control" name="clockone" placeholder="Heures de vérification">
                      <input type="time" class="form-control" name="clocktwo">
                      <input type="time" class="form-control" name="clockthree">
                      <input type="time" class="form-control" name="clockfour">
                  </div>
                    <div class="info col-lg-offset-3">Format HH:mm</div>
                    <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorAddOneClock.' '.$errorAddTwoClock.' '.$errorAddThreeClock.' '.$errorAddFourClock; ?></p>
                </div>
                <div class="form-inline">
                  <div class="input-group time col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="time" placeholder="Première vérification" required>
                  </div>
                  <div class="info col-lg-offset-3">Format jj/mm/aaaa hh:mm (première vérification sur le site !)</div>
                  <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorDateMsg; ?></p>
                </div>
                <div class="form-inline">
                  <div class="input-group notif col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                      <select name="notification">
                        <option>Notifications par :</option>
                        <option value="SMS">SMS</option>
                        <option value="Mail">Mail</option>
                      </select>
                  </div>
                </div>
                <input type="submit" value="Valider !" name="valid" class="button btn btn-default col-lg-offset-5">
            </form>
            <p class="successmessage"><?php echo $succesAddmsg; ?></p>
            <?php 
                }
            }
            elseif($pathology == 3) {
                    if($info == 0) {
                ?>
            <form name="addverif" method="POST" action="profil.php">
                <div class="form-inline">
                  <div class="input-group clock col-lg-offset-3 col-lg-6">
                      <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                      <input type="time" class="form-control" name="clock" placeholder="Heure de vérification" required>
                  </div>
                 <div class="info col-lg-offset-3">Format HH:mm</div>
                 <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorAddOneClock; ?></p>
                </div>
                <div class="form-inline">
                  <div class="input-group time col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="time" placeholder="Première vérification" required>
                  </div>
                  <div class="info col-lg-offset-3">Format jj/mm/aaaa h:min (première vérification sur le site !)</div>
                  <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorDateMsg; ?></p>
                </div>
                <div class="form-inline">
                  <div class="input-group notif col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                      <select name="notification">
                        <option>Notifications par :</option>
                        <option value="SMS">SMS</option>
                        <option value="Mail">Mail</option>
                      </select>
                  </div>
                </div>
                <input type="submit" value="Valider !" name="valid" class="button btn btn-default col-lg-offset-5">
            </form>
            <p class="successmessage"><?php echo $succesAddmsg; ?></p>
            <?php 
                }
                else { ?> 
                <form name="modifverif" method="POST" action="profil.php">
                    <div class="form-inline">
                      <div class="input-group clock col-lg-offset-3 col-lg-6">
                          <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                          <input type="time" class="form-control" name="clock" placeholder="Heure de vérification">
                      </div>
                     <div class="info col-lg-offset-3">Format HH:mm</div>
                     <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorAddOneClock; ?></p>
                    </div>
                    <div class="form-inline">
                      <div class="input-group notif col-lg-offset-3">
                          <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                          <select name="notification">
                            <option>Notifications par :</option>
                            <option value="SMS">SMS</option>
                            <option value="Mail">Mail</option>
                          </select>
                      </div>
                    </div>
                    <input type="submit" value="Valider !" name="modifverif" class="button btn btn-default col-lg-offset-5">
                </form>
            <?php }
            }
            ?>
          </div>   
        <?php } ?>
        </div>
        <div class="modificate col-lg-offset-3 col-lg-5">
          <div class="row">
            <div class="subtitle col-lg-offset-1"><h3>Informations du compte à modifier :</h3></div>
            <form name="modifpassword" method="POST" action="profil.php">
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
              <form name="modifmail" method="POST" action="profil.php">
                <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9 modificateform" for="newmail">Nouvelle adresse mail :</label>                    
                  <div class="input-group mail col-lg-offset-3">
                    <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="newmail" placeholder="Nouvelle adresse mail">
                  </div>
                </div>
                <input type="submit" value="Modifier !" name="modificatemail" class="button btn btn-default col-lg-offset-5">
              </form>
            </div>
            <div class="row">
                <form name="modifnum" method="POST" action="profil.php">
                <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9 modificateform" for="modificatenum">Modifier numéro de téléphone :</label>                                        
                  <div class="input-group phone col-lg-offset-3">
                    <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="modificatenum" placeholder="Modifier numéro de téléphone">
                  </div>
                </div>
                <input type="submit" value="Modifier !" name="submitmodificatenum" class="button btn btn-default col-lg-offset-5">
              </form>
            </div>
            <div class="row">
                <form name="addnum" method="POST" action="profil.php">
                <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9 modificateform" for="newnum">Ajouter numéro de téléphone :</label>                                                            
                  <div class="input-group phone col-lg-offset-3">
                    <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="newnum" placeholder="Nouveau numéro de téléphone">
                  </div>
                </div>
                <input type="submit" value="Ajouter !" name="addnum" class="button btn btn-default col-lg-offset-5">
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="search col-lg-offset-4">
              <p><?php
              if($requestfollow == NULL) {  
                  echo 'Vous n\'avez aucune demande !';
              }
              else {
                foreach($requestfollow as $request) {
                    $nbquest++;
                }
                if($nbquest > 1) {
                    echo 'Vous avez '.$nbquest.' demandes.'; 
                }
                else {
                    echo 'Vous avez '.$nbquest.' demande.';
                } ?>
                <div class="form-inline">
                  <form method="post" action="demande.php">
                    <input type="submit" value="Voir les demandes" name="answerdoctor" class="button btn btn-default col-lg-offset-1">
                  </form>
                </div>
                <?php } ?></p>
          </div>
        </div>
        <div>
            <?php if($_SESSION['role']!=0) {  ?>
         <form method="post" action="ajout.php">
            <div class="form-inline">
                <label class="col-lg-offset-4 col-lg-8 modificateform" for="namedoctor">Chercher votre médecin :</label>                                                        
                <div class="input-group search col-lg-offset-4">
                    <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="name" placeholder="Chercher votre médecin">
                </div>
            </div>
            <div class="form-inline col-lg-offset-4">
                <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
            </div>
         </form>
         <?php  }
         else { ?>
            <form method="post" action="ajout.php">
                <div class="form-inline">
                    <label class="col-lg-offset-4 col-lg-8 modificateform" for="namedoctor">Chercher votre patient :</label>                                                        
                    <div class="input-group search col-lg-offset-4">
                        <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="name" placeholder="Chercher votre médecin">
                    </div>
                </div>
                <div class="form-inline col-lg-offset-4">
                    <input type="submit" value="Rechercher !" name="addpatient" class="button btn btn-default col-lg-offset-1">
                </div>
            </form>
            <?php  } ?>
        </div>
        <div class="col-lg-offset-3">
    <?php if($_SESSION['role']!=0) {  ?>
            <h4>Votre QRCode pour permettre à votre médecin de vous suivre instantané : </h4>
            <?php }
            else { ?>
            <h4>Votre QRCode pour permettre à votre patient de le suivre : </h4>
            <?php } ?>
            <img src="../Controller/qrcode.php" class="col-lg-offset-2">
        </div>
    </div>
<?php
    }
  include 'footer.php';
?>