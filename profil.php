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
          $request = $bdd->query("SELECT nom FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $name = $request->fetch();
          $name = $name['nom'];
          $request = $bdd->query("SELECT prenom FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $surname = $request->fetch();
          $surname = $surname['prenom'];
          $request = $bdd->query("SELECT date_anniversaire FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $birthday = $request->fetch();
          $birthday = $birthday['date_anniversaire'];
          $request = $bdd->query("SELECT mail FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $mail = $request->fetch();
          $mail = $mail['mail'];
          $request = $bdd->query("SELECT phone FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $phone = $request->fetch();
          $phone = $phone['phone'];
          $request = $bdd->query("SELECT phone2 FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $otherphone = $request->fetch();
          $otherphone = $otherphone['phone2'];
          $request = $bdd->query("SELECT pathologie FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
          $pathology = $request->fetch();
          $pathology = $pathology['pathologie'];
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
          <div class="input-group clock col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="clockone" placeholder="Heures de vérification">
              <input type="text" class="form-control" name="clocktwo">
              <input type="text" class="form-control" name="clockthree">
              <input type="text" class="form-control" name="clockfour">
          </div>
            <div class="info col-lg-offset-3">Format h:min</div>
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
                if(isset($_POST['timeverif']) && (isset($_POST['time'])) && (isset($_POST['notification']))) {
                    $timeverif = $_POST['timeverif'];
                    $time = $_POST['time'];
                    if($_POST['notification'] == 'SMS') {
                        $notification = 0;
                    }
                    else {
                        $notification = 1;
                    }
                    $oneclock = $_POST['clockone'];
                    if(isset($_POST['clocktwo'])) {
                        $twoclock = $_POST['clocktwo'];                        
                    }
                    else {
                        $twoclock = '';
                    }
                    if(isset($_POST['clockthree'])) {
                        $threeclock = $_POST['clockthree'];
                    }
                    else {
                        $threeclock = '';
                    }
                    if(isset($_POST['clockfour'])) {
                        $fourclock = $_POST['clockfour'];                        
                    }
                    else {
                        $fourclock = '';
                    }                    
                    $requestverif = $bdd->prepare('INSERT INTO verification(id_utilisateur, verification, Heure1, Heure2, Heure3, Heure4, notification, date_verification) VALUES (:id, :verification, :hour1, :hour2, :hour3, :hour4, :notification, :dateverification)');
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
                    echo 'Les modifications sont prises en compte !';
                }
                else {
                    echo 'Les champs ne sont pas tous remplis !';
                }
            }
        }
        elseif($pathology == 3) {
            ?>
        <form  name="addverif" method="POST" action="suivimedecin.php">
        <div class="form-inline">
          <div class="input-group clock col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="clock" placeholder="Heures de vérification">
          </div>
                      <div class="info col-lg-offset-3">Format h:min</div>
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
              <select class="notification">
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
                if(isset($_POST['time']) && (isset($_POST['notification']))) {
                    $time = $_POST['time'];
                    if($_POST['notification'] == 'SMS') {
                        $notification = 0;
                    }
                    else {
                        $notification = 1;
                    }
                    $oneclock = $_POST['clock'];
                    $requestverif = $bdd->prepare('INSERT INTO verification(id_utilisateur, verification, Heure1, notification, date_verification) VALUES (:id, :verification, :hour1, :notification, :dateverification)');
                    $requestverif->execute(array(
                        'id' => $id,
                        'verification' => $timeverif,
                        'hour1' => $clock,
                        'notification' => $notification,
                        'dateverification' => $time
                    ));
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
                <input type="text" class="form-control" name="newmail" value="Nouvelle adresse mail">
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
                <input type="text" class="form-control" name="newnum" placeholder="Modifier numéro de téléphone">
              </div>
            </div>
            <input type="submit" value="Modifier !" name="modificatenum" class="button btn btn-default col-lg-offset-3">
          </div>
        </div>
        <div class="row">
          <div class="newnum col-lg-offset-3">
            <div class="form-inline">
              <div class="input-group mail">
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
        $requestfollow = $bdd->prepare('SELECT follow_from, follow_date,nom,prenom,nom_utilisateur FROM follow LEFT JOIN utilisateurs ON id=follow_from WHERE follow_to = :id AND follow_confirm = :confirm');
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
       <input type="text" name="name" placeholder="Nom du médecin" class="col-lg-offset-3 col-lg-2"/>
       <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
     </form>
    </div>
    </div>
<?php
}
  include 'footer.php';
?>
