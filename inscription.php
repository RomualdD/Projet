<?php
  include "header.php";
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
        <form method="post" action="inscription.php" ng-controller='inscriptioncontroller' name='inscription'>
          <div class="form-inline">
            <div class="input-group name col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nom de Famille" ng-model='name.text' ng-pattern='name.regex' required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group surname col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" ng-model='firstname.text' ng-pattern='firstname.regex' required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group birthday col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="birthday" name="birthday" placeholder="Date de naissance" ng-model='birthday.text' ng-pattern='birthday.regex' required>
            </div>
            <p class="col-lg-offset-3">Format: jj/mm/aaaa</p>
          </div>
          <div class="form-inline">
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" id="username" placeholder="Nom d'utilisateur" required>
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
                <input type="mail" class="form-control" name="mail" id="mail" placeholder="Adresse mail" ng-model='mail.text' ng-pattern='mail.regex' required>
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group phone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="phone" class="form-control" name="phone" id="phone" placeholder="Numéro de téléphone" ng-model='phone.text' ng-pattern='phone.regex' required>
            </div>
          </div>
          <div class="form-group">
            <label for="texte" class="col-lg-2">Rôle :</label>
            <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role"> Médecin</div>
            <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role"> Patient</div>
          </div>
          <div class="form-group">
            <label for="texte">Informations de la pathologie :</label>
            <select>
              <option>Pathologie..</option>
              <option name="pathology">Diabète Type 1</option>
              <option name="pathology">Diabète Type 2</option>
              <option name="pathology">Anticoagulant (AVK)</option>
            </select>
          </div>
          <div>
            <input type="submit" name="submit" value="S'inscrire !" class="button btn btn-default col-lg-offset-4"  ng-click="buttonClick()">
            <p><span class="error" ng-show="inscription.mail.$error.pattern || inscription.mail.$error.required">Le mail n'est pas valide !<br/></span>
            <span class="error" ng-show="inscription.name.$error.pattern || inscription.name.$error.required">Nom invalide !<br/></span>
            <span class="error" ng-show="inscription.firstname.$error.pattern || inscription.firstname.$error.required">Prénom invalide !<br/></span>
            <span class="error" ng-show="inscription.phone.$error.pattern || inscription.phone.$error.required">Numéro de téléphone invalide !<br/></span>
            <span class="error" ng-show="inscription.birthday.$error.pattern || inscription.birthday.$error.required">Date de naissance incorrecte !<br/></span>
            </p>
          </div>
        </form>
        <?php
        if(isset($_POST['submit']))
        {
          if(!empty($_POST['name']) && (!empty($_POST['surname'])) && (!empty($_POST['password'])) && (!empty($_POST['passwordverif'])) && (!empty($_POST['mail'])) && (!empty($_POST['phone'])))
          {
            if($_POST['password'] == $_POST['passwordverif'])
            {
              echo 'inscription validé';
            }
            else {
              echo 'Mot de passe différent';
            }
          }
          else
          {
           echo  'Les champs ne sont pas remplis.';
          }
        }
        ?>
      </div>
    </div>
  </div>
<?php
    include "footer.php";
?>
