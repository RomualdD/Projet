<?php
include_once 'View/header.php';
include_once 'Model/dataBase.php';
include_once 'Model/users.php';
include_once 'Model/follow.php';
include_once 'Controller/qrcodeController.php';
if(!isset($_SESSION['user'])) {
    ?>
    <div class="container">
        <div class="row view">
            <h2 class="col-lg-offset-5"><?php echo SUBTITLEQRCODE; ?></h2>
            <form action="addUser.php?idFollow=<?php echo $idFollow; ?>" method="POST">
              <div class="row">
                <div class="subtitle col-lg-offset-3"><h3><?php echo INFORMATIONCONNEXION; ?></h3></div>
              </div>
              <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9" for="username"><?php echo USERNAME; ?></label>
                <div class="input-group username col-lg-offset-3">
                    <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="<?php echo USERNAMEPLACEHOLDER; ?>" required>
                </div>
              </div>
              <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9" for="password"><?php echo PASSWORDCONNECT; ?></label>  
                <div class="input-group password col-lg-offset-3">
                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="<?php echo PASSWORDPLACEHOLDER; ?>" required>
                </div>
              </div>
              <div class="form-group col-lg-offset-7">
              <input type="checkbox"><?php echo RECALL; ?>
              </div>
              <input type="submit" value="<?php echo CONNECTBUTTON; ?>" name="connexion" class="button btn btn-default col-lg-offset-4">
              <div class="explication col-lg-offset-5"><p><?php echo LOOSELOGIN; ?><a href=""><?php echo CLICK; ?></a></p></div>
            </form>
        </div>
    </div>
    <?php
}
else { 
    ?><div class="view"><?php
    if($researchidParam != FALSE) {
        if($verif == '' && $follow->follow_to != $follow->follow_from && $roleUser != $role) {  
            ?><p><?php echo SUCCESSQRCODE; ?></p><?php
        }
        elseif($verif == 0 && $follow->follow_to != $follow->follow_from && $roleUser != $role) {
            ?><p><?php echo MODIFICATESUCCESSQRCODE; ?></p><?php
        }
        elseif($roleUser == $role) {
            ?><p><?php echo NOTPOSSIBLEQRCODE; ?></p><?php  
        }
        elseif($follow->follow_to == $follow->follow_from) {
            ?><p><?php echo IDENTICNAME; ?></p><?php  
        }
        else {
            ?><p><?php echo ALREADYQRCODE; ?></p><?php
        }   
    }
    else {
        ?><p><?php echo PARAMETERERROR; ?></p><?php
    }?></div><?php
}
include 'View/footer.php';
?>