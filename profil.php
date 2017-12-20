<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
  if($_SESSION['role']==0){
    echo "<script>document.location.replace('medecinprofil.php');</script>";
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
            <input type="text" class="form-control" disabled="true"  name="pathology" value="<?php echo $pathology ?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="formular col-lg-offset-3 col-lg-5">
        <div class="subtitle col-lg-offset-1"><h3>Formulaire d'informations médicales :</h3></div>
        <div class="form-inline">
          <div class="input-group rate col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="name" placeholder="Taux de glycémie">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group date col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
              <select class="timeverif">
                <option>Vérification par :</option>
                <option name="date">Heure</option>
                <option name="date">Jours</option>
                <option name="date">Mois</option>
              </select>
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group clock col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="clock" placeholder="Heures de vérification">
              <input type="text" class="form-control" name="clock">
              <input type="text" class="form-control" name="clock">
              <input type="text" class="form-control" name="clock">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group time col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="time" placeholder="Première vérification">
          </div>
          <div class="info col-lg-offset-3">Format jj/mm/aaaa</div>
        </div>
        <div class="form-inline">
          <div class="input-group notif col-lg-offset-3">
              <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
              <select class="timeverif">
                <option>Notifications par :</option>
                <option name="notif">SMS</option>
                <option name="notif">Mail</option>
              </select>
          </div>
        </div>
        <input type="submit" value="Valider !" name="valid" class="button btn btn-default col-lg-offset-5">
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
              <div class="input-group mail">
                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="newnum" placeholder="Modifier numéro de téléphone">
              </div>
            </div>
            <input type="submit" value="Modifier !" name="addnum" class="button btn btn-default col-lg-offset-3">
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
      <div class="search col-lg-offset-3">
        <div class="form-inline">
          <div class="input-group search">
            <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="searchdoctor" placeholder="Rechercher son médecin">
          </div>
          <input type="submit" value="Voir les demandes" name="answerdoctor" class="button btn btn-default col-lg-offset-1" data-toggle="modal" data-target="#myModal">

        </div>
        <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
      </div>
    </div>
    <div>
     <form method="post" action="add_follow.php">
       <input type="text" name="name" class="col-lg-offset-3 col-lg-2"/>
       <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
     </form>
    </div>
    </div>
<?php
}
  include 'footer.php';
?>
