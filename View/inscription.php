<?php
  include 'header.php';
  include '../Model/userInsert.php';
?>
<!-- Page d'inscription -->
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Inscription</h2></div>
    </div>
    <div class="message col-lg-offset-2 col-lg-10"><p>Bonjour, afin de continuer sur le site il est obligatoire d'être inscrit, veuillez remplir les informations ci-dessous.</p>
    <p>Si vous êtes déjà inscrit, veuillez-vous rendre sur la page <a href="connexion.php" class="link">connexion</a>.</p></div>
    <div class="row">
      <div class="inscription col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3>Informations à renseigner :</h3></div>
        </div>
        <form method="POST" action="inscription.php" ng-controller='inscriptioncontroller' name='inscription'>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="name">Nom de famille :</label>
            <div class="input-group name col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($_POST['name']) ? strip_tags($_POST['name']) : ''; ?>" placeholder="Nom de Famille" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageName; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="firstname">Prénom :</label>  
            <div class="input-group surname col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo isset($_POST['firstname']) ? strip_tags($_POST['firstname']) : ''; ?>" placeholder="Prénom" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageFirstname; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="birthday">Date de naissance :</label>  
            <div class="input-group birthday col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo isset($_POST['birthday']) ? strip_tags($_POST['birthday']) : ''; ?>" placeholder="<?php echo date('d/m/Y'); ?>" required>
            </div>
            <p class="col-lg-offset-3">Format: jj/mm/aaaa</p>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageBirthday; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="username">Nom d'utilisateur :</label>
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo isset($_POST['username']) ? strip_tags($_POST['username']) : ''; ?>" placeholder="Nom d'utilisateur" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageUser;?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="password">Mot de passe :</label>  
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
            </div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="passwordverif">Vérification mot de passe :</label>  
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="passwordverif" id="passwordverif" placeholder="Vérification mot de passe" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePassword; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="mail">Adresse mail :</label>  
            <div class="input-group mail col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="mail" class="form-control" name="mail" id="mail" placeholder="Adresse mail" value="<?php echo isset($_POST['mail']) ?  strip_tags($_POST['mail']) : ''; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageMail; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="phone">Numéro de téléphone :</label>  
            <div class="input-group phone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="phone" class="form-control" name="phone" id="phone" placeholder="Numéro de téléphone" value="<?php echo isset($_POST['phone']) ? strip_tags($_POST['phone']) : ''; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePhone; ?></p>
          </div>
          <div class="form-group">
            <label for="role" class="col-lg-2">Rôle :</label>
            <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role" value="0" <?php if(isset($_POST['role'])){if(($_POST['role'])==0) echo 'checked'; } ?>/> Médecin</div>
            <div class="role col-lg-offset-1 col-lg-3"><input type="radio" name="role" value="1" <?php if(isset($_POST['role'])){if(($_POST['role'])==1) echo 'checked'; } ?>/> Patient</div>
          </div>
          <div class="form-group">
            <label for="texte">Informations de la pathologie :</label>
            <select name="pathology">
              <option value="0" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==0) echo 'selected'; } ?>>Pathologie..</option>
              <option value="1" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==1) echo 'selected'; } ?>>Diabète Type 1</option>
              <option value="2" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==2) echo 'selected'; } ?>>Diabète Type 2</option>
              <option value="3" <?php if(isset($_POST['pathology'])){if(($_POST['pathology'])==3) echo 'selected'; } ?>>Anticoagulant (AVK)</option>
            </select>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePathology;?></p>
          </div>
          <div>
            <label for="submit" class="col-lg-offset-3"><input type="submit" name="submit" value="S'inscrire !" class="button btn btn-default col-lg-offset-4"></label>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
    include 'footer.php';
?>
