<?php
  include "header.php";
  if(isset($_POST['submit'])){
     // Vérification si les champs sont bien remplis
     if(!empty($_POST['name']) && (!empty($_POST['firstname'])) && (!empty($_POST['password'])) && (!empty($_POST['passwordverif'])) && (!empty($_POST['mail'])) && (!empty($_POST['birthday'])) && (!empty($_POST['phone'])) && (!empty($_POST['role'])))  {
       //enregistrement des données des champs
       $name = $_POST['name'];
       $firstname = $_POST['firstname'];
       $username = $_POST['username'];
       $mail = $_POST['mail'];
       $password = $_POST['password'];
       $passwordverif = $_POST['passwordverif'];
       $password = md5($password); //cryptage de données mdp
       $passwordverif = md5($passwordverif);
       $birthday = $_POST['birthday'];
       $phone = $_POST['phone'];
       $role = $_POST['role'];
       $pathology = $_POST['pathology'];
       $phone2 = "Pas indiqué";
       if($role == 0){
         $pathology = 0;
       }
       // On vérifie que les mots de passes sont identiques
       if($password == $passwordverif) {
         $result = $bdd->query('SELECT nom_utilisateur FROM utilisateurs WHERE nom_utilisateur ="'.$username.'"');
         $nameverif = $result->fetch();
         if($username == $nameverif['nom_utilisateur']) {
           echo "Nom d'utilisateur déjà utilisé!";
         }
         else {
           // Clé généré aléatoirement
           $cle = md5(microtime(TRUE)*100000);
           // Indique qu'il faut le vérifier
           $actif = 0;

           // inclusion dans la bdd
           $req = $bdd->prepare('INSERT INTO utilisateurs(nom, prenom, nom_utilisateur, mail, mot_de_passe,date_anniversaire, phone,phone2, role, pathologie,cleverif,actif) VALUES(:name, :firstname, :username, :mail, :password,:birthday,:phone,:phone2,:role,:pathology,:cleverif,:actif)');
           $req->execute(array(
             'name' => $name,
             'firstname' => $firstname,
             'username' => $username,
             'mail' => $mail,
             'password' => $password,
             'birthday' => $birthday,
             'phone' => $phone,
             ':phone2' => $phone2,
             'role' => $role,
             'pathology' => $pathology,
             'cleverif' => $cle,
             'actif' => $actif
           ));
           //Envoie du mail d'activation
           $recipient = $mail;
           $subject = "[IMPORTANT] Activation de votre compte di-A-vk";
           $entete = "From: inscriptiondiavk@gmail.com";
           $message = "Bienvenue sur di-A-vk,
           Afin de continuer sur le site veuillez activez votre compte en cliquant sur ce lien:

           http://diavk/validation.php?log=".urlencode($username)."&cle=".urlencode($cle)."

           Ne pas répondre à ce message.";
           mail($recipient, $subject,$message,$entete);
           //Informer l'utilisateur que l'inscription est bien prise en compte
           echo "<script>alert('L\'inscription est réussi. Un mail a était envoyé!');</script>";
           //Redirection vers la page de connexion
           header('Location:http://diavk/connexion.php');
           exit();
          // echo "<script>document.location.replace('connexion.php');</script>";
          }
         }
       else {
         echo 'Mot de passe différent';
       }
     }
   else {
    echo  'Les champs ne sont pas remplis.';
    }
  }
?>
<!-- Page d'inscription -->
  <div class="container" ng-app="Inscription">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Inscription</h2></div>
    </div>
    <div class="message col-lg-offset-2"><p>Bonjour, afin de continuer sur le site il est obligatoire d'être inscrit, veuillez remplir les informations ci-dessous.</p>
    <p>Si vous êtes déjà inscrit, veuillez-vous rendre sur la page <a href="connexion.php" class="link">connexion</a>.</p></div>
    <div class="row">
      <div class="inscription col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3>Informations à renseigner :</h3></div>
        </div>
        <form method="post" action="inscription.php" ng-controller='inscriptioncontroller' name='inscription' enctype="multipart/form-data">
          <div class="form-inline">
            <div class="input-group name col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" placeholder="Nom de Famille" ng-model='name.text' ng-pattern='name.regex' required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group surname col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']; ?>" placeholder="Prénom" ng-model='firstname.text' ng-pattern='firstname.regex' required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group birthday col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="birthday" name="birthday" value="<?php if(isset($_POST['birthday'])) echo $_POST['birthday']; ?>" placeholder="Date de naissance" ng-model='birthday.text' ng-pattern='birthday.regex' required>
            </div>
            <p class="col-lg-offset-3">Format: jj/mm/aaaa</p>
          </div>
          <div class="form-inline">
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" id="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" placeholder="Nom d'utilisateur" required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="passwordverif" id="passwordverif" placeholder="Vérification mot de passe" required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group mail col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="mail" class="form-control" name="mail" id="mail" placeholder="Adresse mail" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>" ng-model='mail.text' ng-pattern='mail.regex' required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group phone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="phone" class="form-control" name="phone" id="phone" placeholder="Numéro de téléphone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" ng-model='phone.text' ng-pattern='phone.regex' required>
            </div>
          </div>
          <div class="form-group">
            <label for="texte" class="col-lg-2">Rôle :</label>
            <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role" value="0" checked="<?php if(isset($_POST['role'])){if(($_POST['role'])==0) echo "checked"; } ?>"/> Médecin</div>
            <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role" value="1" checked="<?php if(isset($_POST['role'])){if(($_POST['role'])==1) echo "checked"; } ?>"/> Patient</div>
          </div>
          <div class="form-group">
            <label for="texte">Informations de la pathologie :</label>
            <select name="pathology">
              <option value="0" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==0) echo "selected"; } ?>>Pathologie..</option>
              <option value="1" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==1) echo "selected"; } ?>>Diabète Type 1</option>
              <option value="2" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==2) echo "selected"; } ?>>Diabète Type 2</option>
              <option value="3" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==3) echo "selected"; } ?>>Anticoagulant (AVK)</option>
            </select>
          </div>
          <div>
            <label for="submit" class="col-lg-offset-3"><input type="submit" name="submit" value="S'inscrire !" class="button btn btn-default col-lg-offset-4"  ng-click="buttonClick()"></label>
            <p><span class="error" ng-show="inscription.mail.$error.pattern || inscription.mail.$error.required">Le mail n'est pas valide !</span></p>
            <p><span class="error" ng-show="inscription.name.$error.pattern || inscription.name.$error.required">Nom invalide !</span></p>
            <p><span class="error" ng-show="inscription.firstname.$error.pattern || inscription.firstname.$error.required">Prénom invalide !</span></p>
            <p><span class="error" ng-show="inscription.phone.$error.pattern || inscription.phone.$error.required">Numéro de téléphone invalide !</span></p>
            <p><span class="error" ng-show="inscription.birthday.$error.pattern || inscription.birthday.$error.required">Date de naissance incorrecte !</span></p>
          </div>
        </form>

      </div>
    </div>
  </div>
<?php
    include "footer.php";
?>
