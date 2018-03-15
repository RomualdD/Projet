<?php
    include 'Model/dataBase.php';
    include 'Model/users.php';
    include 'View/header.php';
    include 'Controller/changepasswordController.php' ;
        if(isset($_GET['username']) && (isset($_GET['cle']))) { 
            if($user->cleverif == $clebdd) {?>
                    <div class="view">
                        <form method="post" action="changer-mot-de-passe?username=<?php echo $_GET['username'] ?>&cle=<?php echo $_GET['cle'] ?>">
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform" for="newpassword"><?php echo NEWPASSWORD; ?></label>
                                <div class="input-group newpassword col-lg-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="newpassword" placeholder="<?php echo NEWPASSWORDPLACEHOLDER; ?>">
                                </div>
                            </div>
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform" for="passwordverif"><?php echo VERIFICATIONPASSWORD; ?></label>
                                <div class="input-group passwordverif col-lg-offset-3">
                                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                  <input type="password" class="form-control" name="passwordverif" placeholder="<?php echo VERIFICATIONPASSWORDPLACEHOLDER; ?>">
                                </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorPassword; ?></p>
                            </div>
                            <input type="submit" value="<?php echo VALID; ?>" name="submitmodifpassword" class="button btn btn-default col-lg-offset-5">
                            <p class="successmessage"><?php echo $successMsg; ?></p>
                        </form>
                        <p><?php echo MESSAGERETURNPAGE; ?> <a href="/connexion"><?php echo CONNECTION; ?></a></p>
                    </div>
            <?php }
                else { ?>
            <div class="view">
                <p class="errormessage"><?php echo PARAMETERSERROR; ?></p>
            </div> 
              <?php }
            }
        else { ?>
            <div class="view">
                <p class="errormessage"><?php echo MISSPARAMETER; ?></p>
            </div>
        <?php } 
include 'View/footer.php'; ?>
