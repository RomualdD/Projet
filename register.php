<?php
    include_once 'configuration.php';
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/pathology.php';
    include_once 'Model/role.php';
    include_once 'Controller/registerController.php';
    include_once 'View/header.php';
?>
<!-- Page d'inscription -->
  <div class="container view">
    <div class="row">
      <div class="col-lg-offset-5 col-xs-offset-4"><h2><?php echo REGISTER; ?></h2></div>
    </div>
    <div class="message col-lg-offset-2 col-lg-10"><p><?php echo REGISTERMESSAGE; ?></p>
    <p><?php echo REGISTERMESSAGETWO; ?> <a href="connexion" class="link"><?php echo CONNECTION; ?></a>.</p></div>
    <div class="row">
      <div class="inscription col-lg-offset-3 col-lg-5">
        <div class="row">
          <div class="subtitle col-lg-offset-3"><h3><?php echo REGISTERINFORMATION; ?></h3></div>
        </div>
        <form method="POST" action="register.php" name="inscription">
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="name"><?php echo LASTNAME; ?></label>
            <div class="input-group name col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($_POST['name']) ? strip_tags($_POST['name']) : ''; ?>" placeholder="<?php echo LASTNAMEPLACEHOLDER; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageName; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="firstname"><?php echo FIRSTNAME; ?></label>  
            <div class="input-group surname col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo isset($_POST['firstname']) ? strip_tags($_POST['firstname']) : ''; ?>" placeholder="<?php echo FIRSTNAMEPLACEHOLDER; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageFirstname; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="birthday"><?php echo BIRTHDATE; ?></label>  
            <div class="input-group birthday col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                <input type="date" class="form-control" max="<?php echo date('Y-m-d', strtotime('- 1 YEAR')); ?>" id="birthday" name="birthday" value="<?php echo isset($_POST['birthday']) ? strip_tags($_POST['birthday']) : ''; ?>" placeholder="<?php echo date('d/m/Y'); ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageBirthday; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="username"><?php echo USERNAME; ?></label>
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" id="inscriptionUsername" value="<?php echo isset($_POST['username']) ? strip_tags($_POST['username']) : ''; ?>" placeholder="<?php echo USERNAMEPLACEHOLDER; ?>" required>
            </div>
            <p id="usernameerror" class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageUser;?></p>
            <p id="allreadyusernameerror" class="errormessage col-lg-offset-3 col-lg-9 errormessagemodal"><?php echo ERRORUSERNAMEALREADY; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="password"><?php echo PASSWORDCONNECT; ?></label>  
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" id="passwordregister" placeholder="<?php echo PASSWORDPLACEHOLDER; ?>" required>
            </div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="passwordverif"><?php echo PASSSWORDVERIFICATION; ?></label>  
            <div class="input-group password col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="passwordverif" id="passwordverif" placeholder="<?php echo PASSWORDVERIFPLACEHOLDER; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9" id="errorPassword"><?php echo $errorMessagePassword; ?></p>
            <p id="errorPasswordIdentic" class="errormessagemodal errormessage col-lg-offset-3 col-lg-9"><?php echo PASSWORDIDENTICERROR; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="mail"><?php echo MAIL; ?></label>  
            <div class="input-group mail col-lg-offset-3">
                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="mail" class="form-control" name="mail" id="mail" placeholder="<?php echo MAILPLACEHOLDER; ?>" value="<?php echo isset($_POST['mail']) ?  strip_tags($_POST['mail']) : ''; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageMail; ?></p>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="phone"><?php echo PHONE; ?></label>  
            <div class="input-group phone col-lg-offset-3">
                <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="phone" class="form-control" name="phone" id="phone" placeholder="<?php echo PHONEPLACEHOLDER; ?>" value="<?php echo isset($_POST['phone']) ? strip_tags($_POST['phone']) : ''; ?>" required>
            </div>
            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePhone; ?></p>
          </div>
          <div class="form-group col-lg-offset-3">
            <label for="texte"><?php echo ROLE; ?></label>
            <select name="role">
                <?php foreach($roleinfos as $role) { ?>
                <option value="<?php echo $role->id; ?>" <?php echo ((isset($_POST['role'])) && (($_POST['role'])==0)) ? 'selected' : '';  ?>><?php echo $role->name; ?></option>
                <?php } ?>
            </select>
            </div>
            <div class="form-group">
                <label for="texte"><?php echo PATHOLOGY; ?></label>
                <select name="pathology">
                    <option value="0" <?php echo ((isset($_POST['pathology'])) && (($_POST['pathology'])==0)) ? 'selected' : '';  ?>><?php echo PATHOLOGYSELECT; ?></option>
                    <?php foreach($pathologyinfos as $pathology) { ?>
                    <option value="<?php echo $pathology->id; ?>" <?php echo ((isset($_POST['pathology'])) && (($_POST['pathology'])==0)) ? 'selected' : '';  ?>><?php echo $pathology->name; ?></option>
                    <?php } ?>
                </select>
                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePathology;?></p>
            </div>
          <div>
            <label for="submit" class="col-lg-offset-3 col-xs-offset-4"><input type="submit" name="submit" value="<?php echo REGISTERBUTTON; ?>" class="button btn btn-default col-lg-offset-4"></label>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
    include 'View/footer.php';
?>
