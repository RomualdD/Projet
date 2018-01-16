<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
  if($_SESSION['role']==0){
        header('Location:http://diavk/medecinprofil.php');
        exit();
    }
?>
<!-- Page profil type -->
    <div class="container">
      <div class="row">
        <div class="col-lg-offset-5"><h2>Profil</h2></div>
      </div>
      <div class="row">
        <?php
              $user = $_SESSION['user'];
              $request = $bdd->query('SELECT `nom`, `prenom`, `date_anniversaire`, `mail`, `phone`, `phone2`, `pathologie` FROM `utilisateurs` WHERE `nom_utilisateur` ="'.$user.'"');
              $request = $request->fetch();
              $name = $request['nom'];
              $surname = $request['prenom'];
              $birthday = $request['date_anniversaire'];
              $mail = $request['mail'];
              $phone = $request['phone'];
              $otherphone = $request['phone2'];
              $pathology = $request['pathologie'];
              if($pathology == 1) {
                  $pathologyname = 'Diabète Type 1';
              }
              elseif ($pathology == 2) {
                  $pathologyname = 'Diabète Type 2';
              }
              else {
                  $pathologyname = 'Anticoagulant (AVK)';
              }
        ?>
        <div class="profil col-lg-offset-3 col-lg-5">
          <div class="subtitle col-lg-offset-3"><h3>Informations du patient :</h3></div>
          <div class="form-inline">
            <div class="input-group name col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group surname col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="surname" value="<?php echo htmlspecialchars($surname); ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group birthday col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="birthday" value="<?php echo htmlspecialchars($birthday); ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="username" value="<?php echo htmlspecialchars($user); ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group mail col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="mail" value="<?php echo htmlspecialchars($mail) ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group phone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="phone" value="<?php echo $phone ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group otherphone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="otherphone" value="<?php echo $otherphone ?>">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group pathology col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                <input type="text" class="form-control" disabled="true"  name="pathology" value="<?php echo $pathologyname ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="formular col-lg-offset-3 col-lg-5">
            <div class="subtitle col-lg-offset-1"><h3>Formulaire d'informations médicales :</h3></div>
            <?php 
                if($pathology == 1 || $pathology == 2) {
                    $searchinfo = $bdd->prepare("SELECT `verification` FROM `verification` WHERE `id_utilisateur` = :id");
                    $searchinfo->bindValue('id',$id,PDO::PARAM_INT);
                    $searchinfo->execute();
                    if($searchinfo->rowCount() == 1) {
            ?>
            <form name="modifverif" method="POST" action="profil.php">
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
                      <input type="text" class="form-control" name="clockone" placeholder="Heures de vérification">
                      <input type="text" class="form-control" name="clocktwo" placeholder="<?php echo date('H:i'); ?>">
                      <input type="text" class="form-control" name="clockthree">
                      <input type="text" class="form-control" name="clockfour">
                  </div>
                    <div class="info col-lg-offset-3">Format HH:mm</div>
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
                <input type="submit" value="Modifier !" name="modif" class="button btn btn-default col-lg-offset-5">            
            </form>
                   <?php
                        if(isset($_POST['modif'])) {
                            $error=0;
                            if(!empty($_POST['timeverif'])) {
                                $verif = $_POST['timeverif'];
                                if($verif != 'Heure') {
                                    if(!empty($_POST['clockone'])) {
                                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                                            $oneclock = $_POST['clockone'];                        
                                        }
                                        else {
                                            ?><p><?php
                                            echo 'Le format demandé est : hh:mm';
                                            ?></p><?php
                                            $error++;
                                        }
                                    }
                                    else {
                                        $oneclock = $searchinfo['Heure1'];
                                    }
                                    if($error == 0) { 
                                        $modifverification = $bdd->prepare('UPDATE `verification` SET `verification` = :verif, `Heure1` = :oneclock WHERE `id_utilisateur` = :id');
                                        $modifverification->bindValue('verif',$verif,PDO::PARAM_STR);
                                        $modifverification->bindValue('oneclock',$oneclock,PDO::PARAM_STR);
                                        $modifverification->bindValue('id',$id,PDO::PARAM_INT);
                                        $modifverification->execute(); 
                                        ?><p><?php
                                        echo 'Les modifications sont bien prises en compte !';
                                        ?></p><?php
                                    }    
                                }
                                else {
                                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                                        $oneclock = $_POST['clockone'];    
                                    }
                                    else {
                                        ?><p><?php
                                        echo 'Le format demandé est hh:mm';
                                        ?></p><?php
                                        $error++;
                                    }                                    
                                    if(!empty($_POST['clocktwo'])) {
                                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo'])) {                                
                                            $twoclock = $_POST['clocktwo']; 
                                        }
                                        else {
                                            ?><p><?php
                                            echo 'Le format demandé est hh:mm';
                                            ?></p><?php
                                            $error++;
                                        }
                                    }
                                    else {
                                        $twoclock = '';
                                    }
                                    if(!empty($_POST['clockthree'])) {
                                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree'])) {                                
                                            $threeclock = $_POST['clockthree'];
                                        }
                                        else {
                                           ?><p><?php
                                           echo 'Le format demandé est hh:mm';
                                           ?></p><?php
                                           $error++;
                                        }
                                    }
                                    else {
                                        $threeclock = '';
                                    }
                                    if(!empty($_POST['clockfour'])) {
                                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour'])) {                                                                        
                                            $fourclock = $_POST['clockfour'];
                                            $error++;
                                        }
                                        else {
                                           ?><p><?php
                                           echo 'Le format demandé est hh:mm'; 
                                           ?></p><?php
                                        }                                        
                                    }
                                    else {
                                        $fourclock = '';
                                    }
                                    if($error == 0) { 
                                        $modifverification = $bdd->prepare('UPDATE `verification` SET `verification` = :verif, `Heure1` = oneclock WHERE `id` = :id');
                                        $modifverification->bindValue('verif',$verif,PDO::PARAM_STR);
                                        $modifverification->bindValue('oneclock',$oneclock,PDO::PARAM_STR);
                                        $modifverification->bindValue('id',$id,PDO::PARAM_INT);
                                        $modifverification->execute();
                                        ?><p><?php
                                        echo 'Les modifications sont bien prises en compte !';
                                        ?></p><?php
                                    }
                                }
                            }
                            elseif (!empty($_POST['notification'])) {
                                $modifverification = $bdd->prepare('UPDATE `verification` SET `notification` = :notif WHERE `id` = :id');
                                $modifverification->bindValue('notification',$verif,PDO::PARAM_STR);
                                $modifverification->bindValue('id',$id,PDO::PARAM_INT);
                                $modifverification->execute(); 
                            }
                            elseif (!empty($_POST['clockone'])) {
                                if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                                    $oneclock = $_POST['clockone'];    
                                }
                                else {
                                    ?><p><?php
                                    echo 'Le format demandé est hh:mm';
                                    ?></p><?php
                                    $error++;
                                }
                                if(!empty($_POST['clocktwo'])) {
                                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo'])) {                                
                                        $twoclock = $_POST['clocktwo']; 
                                    }
                                    else {
                                        ?><p><?php
                                        echo 'Le format demandé est hh:mm';
                                        ?></p><?php
                                        $error++;
                                    }
                                }
                                else {
                                    $twoclock = '';
                                }
                                if(!empty($_POST['clockthree'])) {
                                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree'])) {                                
                                        $threeclock = $_POST['clockthree'];
                                    }
                                    else {
                                       ?><p><?php
                                       echo 'Le format demandé est hh:mm'; 
                                       ?></p><?php
                                       $error++;
                                    }
                                }
                                else {
                                    $threeclock = '';
                                }
                                if(!empty($_POST['clockfour'])) {
                                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour'])) {                                                                        
                                        $fourclock = $_POST['clockfour'];  
                                    }
                                    else {
                                        ?><p><?php
                                        echo 'Le format demandé est hh:mm';
                                        ?></p><?php
                                        $error++;
                                    }   
                                }
                                else {
                                    $fourclock = '';
                                }
                                if($error == 0) { 
                                    $modifverification = $bdd->prepare('UPDATE `verification` SET `Heure1` = :oneclock, `Heure2` = :twoclock, `Heure3` = :threeclock, `Heure4` = :fourclock WHERE `id` = :id');
                                    $modifverification->bindValue('oneclock',$oneclock,PDO::PARAM_STR);
                                    $modifverification->bindValue('twoclock',$twoclock,PDO::PARAM_STR);
                                    $modifverification->bindValue('threeclock',$threeclock,PDO::PARAM_STR);
                                    $modifverification->bindValue('fourclock',$fourclock,PDO::PARAM_STR);
                                    $modifverification->bindValue('id',$id,PDO::PARAM_INT);
                                    $modifverification->execute(); 
                                    ?><p><?php
                                    echo 'Les modifications sont bien prises en compte !';
                                    ?></p><?php
                                }
                            }
                        }   
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
                      <input type="text" class="form-control" name="clockone" placeholder="Heures de vérification">
                      <input type="text" class="form-control" name="clocktwo">
                      <input type="text" class="form-control" name="clockthree">
                      <input type="text" class="form-control" name="clockfour">
                  </div>
                    <div class="info col-lg-offset-3">Format HH:mm</div>
                </div>
                <div class="form-inline">
                  <div class="input-group time col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="time" placeholder="Première vérification">
                  </div>
                  <div class="info col-lg-offset-3">Format jj/mm/aaaa h:min (première vérification sur le site !)</div>
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
            <?php }
                if(isset($_POST['valid'])) {
                    if(!empty($_POST['timeverif']) && (!empty($_POST['time'])) && (!empty($_POST['notification'])) && (!empty($_POST['clockone']))) {
                        $timeverif = $_POST['timeverif'];
                        $time = $_POST['time'];
                        if($_POST['notification'] == 'SMS') {
                            $notification = 0;
                        }
                        else {
                            $notification = 1;
                        }
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                            $oneclock = $_POST['clockone'];    
                        }
                        else {
                            ?><p><?php
                            echo 'Le format demandé est hh:mm';
                            ?></p><?php
                            $error++;
                        }
                        if(!empty($_POST['clocktwo'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo'])) {                                
                                $twoclock = $_POST['clocktwo']; 
                        }
                            else {
                                ?><p><?php
                                echo 'Le format demandé est hh:mm';
                                ?></p><?php
                                $error++;
                            }
                        }
                        else {
                            $twoclock = '';
                        }
                        if(!empty($_POST['clockthree'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree'])) {                                
                                $threeclock = $_POST['clockthree'];
                            }
                            else {
                                ?><p><?php
                               echo 'Le format demandé est hh:mm';
                               ?></p><?php
                               $error++;
                            }
                        }
                        else {
                            $threeclock = '';
                        }
                        if(!empty($_POST['clockfour'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour'])) {                                                                        
                                $fourclock = $_POST['clockfour'];  
                            }
                            else {
                                ?><p><?php
                               echo 'Le format demandé est hh:mm'; 
                               ?></p><?php
                               $error++;
                            }
                        }
                        else {
                            $fourclock = '';
                        }     
                        if($error == 0) {
                            $requestverif = $bdd->prepare('INSERT INTO `verification`(`id_utilisateur`, `verification`, `Heure1`, `Heure2`, `Heure3`, `Heure4`, `notification`, `date_verification`) VALUES (:id, :verification, :hour1, :hour2, :hour3, :hour4, :notification, :dateverification)');
                            $requestverif->execute(array(
                                'id' => $id,
                                'verification' => $timeverif,
                                'hour1' => $oneclock,
                                'hour2' => $twoclock,
                                'hour3' => $threeclock,
                                'hour4' => $fourclock,
                                'notification' => $notification,
                                'dateverification' => $time
                            ));
                            ?><p><?php
                            echo 'Les modifications sont prises en compte !';
                            ?></p><?php
                        }
                    }
                    else {
                        ?><p><?php
                        echo 'Les champs ne sont pas tous remplis !';
                        ?></p><?php
                    }
                }
            }
            elseif($pathology == 3) {
                ?>
            <form  name="addverif" method="POST" action="profil.php">
                <div class="form-inline">
                  <div class="input-group clock col-lg-offset-3 col-lg-6">
                      <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="clock" placeholder="Heure de vérification">
                  </div>
                 <div class="info col-lg-offset-3">Format HH:mm</div>
                </div>
                <div class="form-inline">
                  <div class="input-group time col-lg-offset-3">
                      <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="time" placeholder="Première vérification">
                  </div>
                  <div class="info col-lg-offset-3">Format jj/mm/aaaa h:min (première vérification sur le site !)</div>
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
            <?php
                if(isset($_POST['valid'])) {
                    if(isset($_POST['time']) && (isset($_POST['notification'])) && (isset($_POST['clock']))) {
                        if($_POST['notification'] == 'SMS') {
                            $notification = 0;
                        }
                        else {
                            $notification = 1;
                        }
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                            $oneclock = $_POST['clockone'];    
                        }
                        else {
                            ?><p><?php
                            echo 'Le format demandé est hh:mm';
                            ?></p><?php
                            $error++;
                        }
                        if(preg_match('#^[0-9]{2}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])){
                            $time = $_POST['time'];
                        }
                        else {
                            ?><p><?php
                            echo 'Le format demandé est jj/mm/YYYY hh:mm';
                            ?></p><?php
                            $error++;
                        }
                        if($error == 0) {
                            $requestverif = $bdd->prepare('INSERT INTO `verification`(`id_utilisateur`, `Heure1`, `notification`, `date_verification`) VALUES (:id, :hour1, :notification, :dateverification)');
                            $requestverif->execute(array(
                                'id' => $id,
                                'hour1' => $oneclock,
                                'notification' => $notification,
                                'dateverification' => $time
                            ));
                            ?><p><?php
                            echo 'Les modifications sont prises en compte !';
                            ?></p><?php
                        }
                    }
                    else {
                        ?><p><?php
                        echo 'Les champs ne sont pas tous remplis !';
                        ?></p><?php
                    }
                }
            }
            ?>
          </div>
        </div>
        <div class="modificate col-lg-offset-3 col-lg-5">
          <div class="row">
            <div class="subtitle col-lg-offset-1"><h3>Informations du compte à modifier :</h3></div>
            <div class="form-inline">
              <div class="input-group password col-lg-offset-3">
                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                  <input type="password" class="form-control" name="password" placeholder="Mot de passe actuel">
              </div>
             </div>
              <div class="form-inline">
                <div class="input-group newpassword col-lg-offset-3">
                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                  <input type="password" class="form-control" name="newpassword" placeholder="Nouveau mot de passe">
                </div>
              </div>
              <div class="form-inline">
                <div class="input-group passwordverif col-lg-offset-3">
                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                  <input type="password" class="form-control" name="passwordverif" placeholder="Vérfication nouveau mot de passe">
                </div>
              </div>
            <input type="submit" value="Valider !" name="valid" class="button btn btn-default col-lg-offset-5">
            </div>
            <div class="row">
              <div class="modificatemail col-lg-offset-3">
                <div class="form-inline">
                  <div class="input-group mail">
                    <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="newmail" placeholder="Nouvelle adresse mail">
                  </div>
                </div>
                <input type="submit" value="Modifier !" name="modificatemail" class="button btn btn-default col-lg-offset-3">
              </div>
            </div>
            <div class="row">
              <div class="modificatenum col-lg-offset-3">
                <div class="form-inline">
                  <div class="input-group phone">
                    <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="newnum" placeholder="Modifier numéro de téléphone">
                  </div>
                </div>
                <input type="submit" value="Modifier !" name="modificatenum" class="button btn btn-default col-lg-offset-3">
              </div>
            </div>
            <div class="row">
              <div class="newnum col-lg-offset-3">
                <div class="form-inline">
                  <div class="input-group phone">
                    <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="newnum" placeholder="Nouveau numéro de téléphone">
                  </div>
                </div>
                <input type="submit" value="Modifier !" name="addnum" class="button btn btn-default col-lg-offset-3">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="search col-lg-offset-4">
              <p><?php
            $requestfollow = $bdd->prepare('SELECT `follow_from`, `follow_date`,`nom`,`prenom`,`nom_utilisateur` FROM `follow` LEFT JOIN `utilisateurs` ON `id`=`follow_from` WHERE `follow_to` = :id AND `follow_confirm` = :confirm');
            $requestfollow->bindValue(':id',$id, PDO::PARAM_INT);
            $requestfollow->bindValue(':confirm','0', PDO::PARAM_STR);
            $requestfollow->execute();

            if($requestfollow->rowCount() == 0){
                echo 'Vous n\'avez aucune demande !';
            }
            else {
                while($request = $requestfollow->fetch()) {
                    $nbquest++;
                }
                if($nbquest > 1) {
                    echo 'Vous avez '.$nbquest.' demandes.'; 
                }
                else {
                    echo 'Vous avez '.$nbquest.' demande.';
                }
        ?>
                <div class="form-inline">
                  <form method="post" action="demande.php">
                    <input type="submit" value="Voir les demandes" name="answerdoctor" class="button btn btn-default col-lg-offset-1">
                  </form>
                </div>
        <?php
            }
        ?></p>
          </div>
        </div>
        <div>
         <form method="post" action="ajout.php">
            <div class="form-inline">
                <div class="input-group search col-lg-offset-4">
                    <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="name" placeholder="Chercher votre médecin">
                </div>
            </div>
            <div class="form-inline col-lg-offset-4">
                <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
            </div>
         </form>
        </div>
    </div>
<?php
}
  include 'footer.php';
?>
