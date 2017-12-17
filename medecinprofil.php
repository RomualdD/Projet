<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
  if($_SESSION['role']==1){
    echo "<script>document.location.replace('medecinprofil.php');</script>";
  }
?>
<!-- Page profil médecin -->
<div class="container">
  <div class="row">
    <div class="col-lg-offset-5"><h2>Profil</h2></div>
  </div>
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
  ?>
  <div class="row" ng-controller='inscriptioncontroller'>
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
    <form action="medecinprofil.php" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="subtitle col-lg-offset-1"><h3>Informations du compte à modifier :</h3></div>
        <div class="form-inline">
          <div class="input-group password col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="passwordchange" id="passwordchange" placeholder="Mot de passe actuel">
          </div>
         </div>
          <div class="form-inline">
            <div class="input-group newpassword col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Nouveau mot de passe">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group passwordverif col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="passwordverif" id="passwordverif" placeholder="Vérfication nouveau mot de passe">
            </div>
          </div>
        <label for="submit" class="col-lg-offset-3"><input type="submit" value="Valider !" name="submit" class="button btn btn-default col-lg-offset-5"/></label>
        </div>
        </form>
        <?php
          if(!empty($_POST['passwordchange']) && (!empty($_POST['newpassword'])) && (!empty($_POST['passwordverif']))) {
            $pass = $_POST['passwordchange'];
            $pass = md5($pass);
            $request = $bdd->query("SELECT mot_de_passe FROM utilisateurs WHERE nom_utilisateur = '".$user."'");
            $passwordchange = $request->fetch();
            if($passwordchange['mot_de_passe'] == $pass) {
              if($_POST['newpassword'] == $_POST['passwordverif']) {
                $newpass = $_POST['newpassword'];
                $newpass = md5($newpass);
                $changepass = $bdd->prepare("UPDATE utilisateurs SET mot_de_passe=".$newpass." WHERE nom_utilisateur like :user");
                $changepass->bindParam(':user', $user);
                $changepass->execute();
                echo "Changement réussi.";
              }
              else {
                echo "Les mots de passes ne sont pas identiques.";
              }
            }
            else {
              echo "Ce n'est pas votre mot de passe actuel.";
            }
          }
          else {
            echo "Les champs ne sont pas tous remplis !";
          }
         ?>
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
        <form action="medecinprofil.php" method="post">
        <div class="row">
          <div class="newnum col-lg-offset-3">
            <div class="form-inline">
              <div class="input-group mail">
                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="newnum" placeholder="Nouveau numéro de téléphone" ng-model='phone.text' ng-pattern='phone.regex' required>
              </div>
            </div>
            <input type="submit" value="Modifier !" name="addnum" class="button btn btn-default col-lg-offset-3">
          </div>
        </div>
        </form>
        <?php
          if(!empty($_POST['newnum'])) {
            $newnum=$_POST['newnum'];
            $request=$bdd->prepare("UPDATE utilisateurs SET phone2 =" .$newnum. " WHERE nom_utilisateur like :user");
            $request->bindParam(':user', $user);
            $request->execute();
          }
         ?>
      </div>
    </div>
    <div class="row">
      <div class="search col-lg-offset-3">
       <form action="medecinprofil.php" method="post" enctype="multipart/form-data">
        <div class="form-inline">
          <div class="input-group search">
            <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="searchpatient" placeholder="Rechercher son patient">
          </div>
          <input type="submit" value="Voir les demandes" name="answerpatient" class="button btn btn-default col-lg-offset-1" data-toggle="modal" data-target="#myModal" onclick="return false;" >
          <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Demande suivi du patient :</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="array">
                      <table class="patienttable" id="Patient">
                        <thead>
                          <tr>
                            <th>Nom : </th>
                            <th>Prénom : </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
        <input type="submit" value="Rechercher !" name="addpatient" class="button btn btn-default col-lg-offset-1" data-toggle="modal" data-target="#myModal" onclick="return false;" >
        <?php
          if(!empty($_POST['searchpatient'])) {
            $patient = $_POST['searchpatient'];
            $request = $bdd->query("SELECT nom,prenom FROM utilisateurs WHERE nom ='".$patient."' OR prenom = '".$patient."' OR nom_utilisateur = '".$patient."' AND role='1'" );
            $row = $request->fetch();
            $name = $row['nom'];
            $surname = $row['prenom'];
            echo "<script>$('.array').append('<tr><th>".$name."</th><th>".$surname."</th><th></th></tr>');</script>";
          }
         ?>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Recherche du patient :</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="array">
                    <table class="doctortable" id="doctorarray">
                      <thead>
                        <tr>
                          <th>Nom : </th>
                          <th>Prénom :</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
      </div>
     </form>
    </div>
  </div>
</div>
<?php
  }
  include 'footer.php';
?>
