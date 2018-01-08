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
        $request = $bdd->query("SELECT nom, prenom, mail,utilisateur, phone, phone2, date_anniversaire FROM utilisateurs WHERE nom_utilisateur ='".$user."'");
        $request = $request->fetch();
        $name = $request['nom'];
        $surname = $request['prenom'];
        $user = $request['utilisateur'];
        $birthday = $request['date_anniversaire'];
        $mail = $request['mail'];
        $phone = $request['phone'];
        $otherphone = $request['phone2'];
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
    <form action="medecinprofil.php" method="POST" enctype="multipart/form-data">
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
        if(isset($_POST['submit'])) {
          if(!empty($_POST['passwordchange']) && (!empty($_POST['newpassword'])) && (!empty($_POST['passwordverif']))) {
            $pass = $_POST['passwordchange'];
            $pass = md5($pass);
            $request = $bdd->query("SELECT mot_de_passe FROM utilisateurs WHERE nom_utilisateur = '".$user."'");
            $passwordchange = $request->fetch();
            if($passwordchange['mot_de_passe'] == $pass) {
              if($_POST['newpassword'] == $_POST['passwordverif']) {
                $newpass = $_POST['newpassword'];
                $newpass = md5($newpass);
                $changepass = $bdd->prepare("UPDATE utilisateurs SET mot_de_passe=".$newpass." WHERE nom_utilisateur = :user");
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
      </div>
    </div>
    <div class="row">
      <div class="search col-lg-offset-4">
          <p><?php
          // Initialisation du nombre de requete faite
          $nbquest = 0;
          // Recherche si il y'a des demandes de suivis
        $requestfollow = $bdd->prepare('SELECT follow_from, follow_date,nom,prenom,nom_utilisateur FROM follow LEFT JOIN utilisateurs ON id=follow_from WHERE follow_to = :id AND follow_confirm = :confirm');
    $requestfollow->bindValue(':id',$id, PDO::PARAM_INT);
    $requestfollow->bindValue(':confirm','0', PDO::PARAM_STR);
    $requestfollow->execute();  
    // Affichage du nombre de demande
    if($requestfollow->rowCount()==0){
        ?><?php echo 'Vous n\'avez aucune demande !';
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
          <form method="POST" action="demande.php">
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
       <input type="text" name="name" class="col-lg-offset-3 col-lg-2"/>
       <input type="submit" value="Rechercher !" name="adddoctor" class="button btn btn-default col-lg-offset-1">
     </form>
    </div>
    </div>
<?php
  }
  include 'footer.php';
?>
