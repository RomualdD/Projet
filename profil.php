<?php
    include 'View/header.php';
    if(isset($_SESSION['user'])) { 
       include_once 'Model/follow.php';
       include_once 'Model/verification.php';
       include_once 'Controller/profilController.php';
?>
<!-- Page profil type -->
    <div class="container view">
        <div class="row">
          <div class="col-lg-offset-5 col-sm-offset-5 col-xs-offset-4"><h2><?php echo PROFILTITLE; ?></h2></div>
        </div>
        <div class="col-lg-4">
            <a href="#" class="nav-tabs-dropdown btn btn-block btn-primary" disabled><?php echo PROFILMENU; ?></a>
            <ul id="nav-tabs-wrapper" class="nav nav-tabs nav-pills nav-stacked well">
              <li class="active"><a href="#displayInformations" data-toggle="tab"><?php echo PROFILINFORMATION; ?></a></li>
              <?php if($role != 2) { ?>
              <li><a href="#medicalInformations" data-toggle="tab"><?php echo PROFILMEDICALINFORMATION; ?></a></li>                
              <?php } ?>
              <li><a href="#modificateInformations" data-toggle="tab"><?php echo PROFILINFORMATIONMODIFICATE; ?></a></li>
              <li><a href="#displayFollow" data-toggle="tab"><?php echo VIEWADDFOLLOW; ?> <span id="infoFollow"><?php echo $nbquest;?></span></a></li>
              <li><a href="#DeleteAccount" data-toggle="tab"><?php echo UNSUSCRIBE; ?></a></li>            
            </ul>
        </div>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="displayInformations">
            <div class="row">
                <div class="profil col-lg-offset-2 col-lg-5 col-sm-offset-4">
                        <div class="subtitle col-lg-offset-3 col-sm-offset-1 col-xs-offset-2"><h3><?php echo PROFILINFORMATION; ?></h3></div>
                        <div class="form-inline">
                          <div class="input-group name col-lg-offset-3">
                              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="name" value="<?php echo $user->name; ?>">
                          </div>
                        </div>
                        <div class="form-inline">
                          <div class="input-group surname col-lg-offset-3">
                              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="surname" value="<?php echo $user->firstname; ?>">
                          </div>
                        </div>
                        <div class="form-inline">
                          <div class="input-group birthday col-lg-offset-3">
                              <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="birthday" value="<?php echo $user->birthday; ?>">
                          </div>
                        </div>
                        <div class="form-inline">
                          <div class="input-group username col-lg-offset-3">
                              <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="username" value="<?php echo $user->username; ?>">
                          </div>
                        </div>
                        <div class="form-inline">
                          <div class="input-group mail col-lg-offset-3">
                              <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="mail" value="<?php echo $user->mail; ?>">
                          </div>
                        </div>
                        <div class="form-inline">
                          <div class="input-group phone col-lg-offset-3">
                              <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="phone" value="<?php echo $user->phone; ?>">
                          </div>
                        </div>
                        <div class="form-inline">
                          <div class="input-group otherphone col-lg-offset-3">
                              <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="otherphone" value="<?php echo $user->phone2; ?>">
                          </div>
                        </div>
                        <?php if($_SESSION['role'] == 3) { ?>
                        <div class="form-inline">
                          <div class="input-group pathology col-lg-offset-3">
                              <span class="input-group-addon"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" disabled name="pathology" value="<?php echo $user->pathology; ?>">
                          </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
          </div>
            <?php if($_SESSION['role'] != 2) { ?>
            <div role="tabpanel" class="tab-pane fade" id="medicalInformations">  
                <div class="formular col-lg-offset-3 col-lg-5 col-sm-offset-4">            
                    <div class="subtitle col-lg-offset-1"><h3><?php echo FORMULARINFORMATION; ?></h3></div>
                    <?php 
                        if($pathology == 1) {
                            if($info != NULL) {
                    ?>
                        <form name="modifverif" method="POST" action="profil.php">
                            <div class="form-inline">
                              <div class="input-group date col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                                  <select name="timeverif">
                                      <option value=""><?php echo VERIFICATIONSELECT; ?></option>
                                    <option value="Heure"><?php echo HOURVERIFICATION; ?></option>
                                    <option value="Jours"><?php echo DAYVERIFICATION; ?></option>
                                    <option value="Mois"><?php echo MONTHVERIFICATION; ?></option>
                                  </select>
                              </div>
                            </div>
                            <div class="form-inline">
                              <div class="input-group clock col-lg-offset-3 col-lg-6">
                                  <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                  <input type="time" class="form-control" name="clockone" placeholder="<?php echo HOURVERIFICATIONPLACEHOLDER; ?>">
                                  <input type="time" class="form-control" name="clocktwo" placeholder="<?php echo date('H:i'); ?>">
                                  <input type="time" class="form-control" name="clockthree">
                                  <input type="time" class="form-control" name="clockfour">
                              </div>
                                <div class="info col-lg-offset-3"><p><?php echo VERIFICATIONFORMAT; ?></p></div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorModifOneClock.' '.$errorModifTwoClock.' '.$errorModifThreeClock.' '.$errorModifFourClock; ?></p>
                            </div>
                           <div class="form-inline">
                              <div class="input-group notif col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                                  <select name="notification">
                                    <option value=""><?php echo NOTIFICATION; ?></option>
                                    <option value="SMS"><?php echo SMS; ?></option>
                                    <option value="Mail"><?php echo MAILNOTIFICATION; ?></option>
                                  </select>
                              </div>
                            </div>
                            <input type="submit" value="<?php echo EDIT; ?>" name="modif" class="button btn btn-default col-lg-offset-5 col-sm-offset-2">            
                        </form>
                        <p class="successmessage"><?php echo $successModifMsg ?></p>
                               <?php
                                }
                                else {  
                        ?>
                        <form  name="addverif" method="POST" action="profil.php">
                            <div class="form-inline">
                              <div class="input-group date col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                                  <select name="timeverif">
                                    <option><?php echo VERIFICATIONSELECT ?></option>
                                    <option value="Heure"><?php echo HOURVERIFICATION; ?></option>
                                    <option value="Jours"><?php echo DAYVERIFICATION; ?></option>
                                    <option value="Mois"><?php echo MONTHVERIFICATION; ?></option>
                                  </select>
                              </div>
                            </div>
                            <div class="form-inline">
                              <div class="input-group clock col-lg-offset-3 col-lg-6">
                                  <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                  <input type="time" class="form-control" name="clockone" placeholder="<?php echo HOURVERIFICATIONPLACEHOLDER; ?>">
                                  <input type="time" class="form-control" name="clocktwo">
                                  <input type="time" class="form-control" name="clockthree">
                                  <input type="time" class="form-control" name="clockfour">
                              </div>
                                <div class="info col-lg-offset-3"><?php echo VERIFICATIONFORMAT; ?></div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorAddOneClock.' '.$errorAddTwoClock.' '.$errorAddThreeClock.' '.$errorAddFourClock; ?></p>
                            </div>
                            <div class="form-inline">
                              <div class="input-group time col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                                  <input type="text" class="form-control" name="time" placeholder="<?php echo FIRSTVERIFICATION; ?>" required>
                              </div>
                              <div class="info col-lg-offset-3"><?php echo FIRSTVERIFICATIONFORMAT; ?></div>
                              <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorDateMsg; ?></p>
                            </div>
                            <div class="form-inline">
                              <div class="input-group notif col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                                  <select name="notification">
                                    <option><?php echo NOTIFICATION; ?></option>
                                    <option value="SMS"><?php echo SMS; ?></option>
                                    <option value="Mail"><?php echo MAIL; ?></option>
                                  </select>
                              </div>
                            </div>
                            <input type="submit" value="<?php echo VALID; ?>" name="valid" class="button btn btn-default col-lg-offset-5 col-sm-offset-2">
                        </form>
                        <p class="successmessage"><?php echo $succesAddmsg; ?></p>
                        <?php 
                            }
                        }
                        elseif($pathology == 2 || $pathology == 3) {
                                if($info == NULL) {
                            ?>
                        <form name="addverif" method="POST" action="profil.php">
                            <div class="form-inline">
                              <div class="input-group clock col-lg-offset-3 col-lg-6">
                                  <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                  <input type="time" class="form-control" name="clock" placeholder="<?php echo HOURVERIFICATIONPLACEHOLDER; ?>" required>
                              </div>
                             <div class="info col-lg-offset-3"><?php echo VERIFICATIONFORMAT; ?></div>
                             <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorAddOneClock; ?></p>
                            </div>
                            <div class="form-inline">
                              <div class="input-group time col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                                  <input type="text" class="form-control" name="time" placeholder="<?php echo FIRSTVERIFICATION ?>" required>
                              </div>
                              <div class="info col-lg-offset-3"><?php echo FIRSTVERIFICATIONFORMAT; ?></div>
                              <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorDateMsg; ?></p>
                            </div>
                            <div class="form-inline">
                              <div class="input-group notif col-lg-offset-3">
                                  <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                                  <select name="notification">
                                    <option><?php echo NOTIFICATION; ?></option>
                                    <option value="SMS"><?php echo SMS; ?></option>
                                    <option value="Mail"><?php echo MAIL; ?></option>
                                  </select>
                              </div>
                            </div>
                            <input type="submit" value="<?php echo VALID; ?>" name="valid" class="button btn btn-default col-lg-offset-5 col-sm-offset-2">
                        </form>
                        <p class="successmessage"><?php echo $succesAddmsg; ?></p>
                        <?php 
                            }
                            else { ?> 
                            <form name="modifverif" method="POST" action="profil.php">
                                <div class="form-inline">
                                  <div class="input-group clock col-lg-offset-3 col-lg-6">
                                      <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                      <input type="time" class="form-control" name="clock" placeholder="<?php echo HOURVERIFICATIONPLACEHOLDER; ?>">
                                  </div>
                                 <div class="info col-lg-offset-3"><?php echo VERIFICATIONFORMAT; ?></div>
                                 <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorAddOneClock; ?></p>
                                </div>
                                <div class="form-inline">
                                  <div class="input-group notif col-lg-offset-3">
                                      <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
                                      <select name="notification">
                                        <option><?php echo NOTIFICATION; ?></option>
                                        <option value="SMS"><?php echo SMS; ?></option>
                                        <option value="Mail"><?php echo MAIL; ?></option>
                                      </select>
                                  </div>
                                </div>
                                <input type="submit" value="<?php echo EDIT; ?>" name="modifverif" class="button btn btn-default col-lg-offset-5 col-sm-offset-2">
                            </form>
                        <?php }
                        }
                        ?>
                </div>
            </div>
        <?php } ?>
            <div role="tabpanel" class="tab-pane fade" id="modificateInformations"> 
                <div class="modificate col-lg-offset-3 col-lg-5 col-sm-offset-2">                       
                    <div class="row">
                        <div class="subtitle col-lg-offset-1"><h3><?php echo PROFILINFORMATIONMODIFICATE; ?></h3></div>
                        <form name="modifpassword" method="POST" action="profil.php">
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 col-sm-offset-3 col-sm-9 modificateform" for="password"><?php echo CURRENTPASSWORD; ?></label>
                                <div class="input-group password col-lg-offset-3 col-sm-offset-3">
                                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                  <input type="password" class="form-control" name="password" placeholder="<?php echo CURRENTPASSWORD; ?>">
                                </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorPasswordFalse; ?></p>
                            </div>
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform col-sm-offset-3 col-sm-9 " for="newpassword"><?php echo NEWPASSWORD; ?></label>
                                <div class="input-group newpassword col-lg-offset-3 col-sm-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="newpassword" placeholder="<?php echo NEWPASSWORD; ?>">
                                </div>
                            </div>
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform col-sm-offset-3 col-sm-9 " for="passwordverif"><?php echo VERIFICATIONPASSWORD; ?></label>
                                <div class="input-group passwordverif col-lg-offset-3 col-sm-offset-3">
                                  <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                  <input type="password" class="form-control" name="passwordverif" placeholder="<?php echo VERIFICATIONPASSWORD; ?>">
                                </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorPassword; ?></p>
                            </div>
                            <input type="submit" value="<?php echo VALID; ?>" name="submitmodifpassword" class="button btn btn-default col-lg-offset-5 col-xs-offset-4">
                        </form>
                        <p class="successmessage col-lg-offset-3 col-lg-9"><?php echo $successMsg; ?></p>
                    </div>
                    <div class="row">
                        <form name="modifmail" method="POST" action="profil.php">
                            <div class="form-inline">
                            <label class="col-lg-offset-3 col-lg-9 modificateform col-sm-offset-3 col-sm-9 " for="newmail"><?php echo NEWMAIL; ?></label>                    
                              <div class="input-group mail col-lg-offset-3 col-sm-offset-3">
                                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="newmail" placeholder="<?php echo NEWMAIL; ?>">
                              </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageMail; ?></p>                   
                            </div>
                            <input type="submit" value="<?php echo EDIT; ?>" name="modificatemail" class="button btn btn-default col-lg-offset-5 col-xs-offset-4">
                        </form>
                        <p class="successmessage col-lg-offset-3 col-lg-9"><?php echo $successModifMail; ?></p>                
                    </div>
                    <div class="row">
                        <form name="modifnum" method="POST" action="profil.php">
                            <div class="form-inline">
                            <label class="col-lg-offset-3 col-lg-9 modificateform col-sm-offset-3 col-sm-9 " for="modificatenum"><?php echo EDITPHONE; ?></label>                                        
                              <div class="input-group phone col-lg-offset-3 col-sm-offset-3">
                                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="modificatenum" placeholder="<?php echo EDITPHONE; ?>">
                              </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePhone; ?></p>                
                            </div>
                            <input type="submit" value="<?php echo EDIT; ?>" name="submitmodificatenum" class="button btn btn-default col-lg-offset-5 col-xs-offset-4">
                        </form>
                        <p class="successmessage col-lg-offset-3 col-lg-9"><?php echo $successModifPhone; ?></p>                
                    </div>
                    <div class="row">
                        <form name="addnum" method="POST" action="profil.php">
                            <div class="form-inline">
                            <label class="col-lg-offset-3 col-lg-9 modificateform col-sm-offset-3 col-sm-9 " for="newnum"><?php echo ADDPHONE; ?></label>                                                            
                              <div class="input-group phone col-lg-offset-3 col-sm-offset-3">
                                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="newnum" placeholder="<?php echo NEWPHONE; ?>">
                              </div>
                                <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessagePhone2; ?></p>                
                            </div>
                            <input type="submit" value="<?php echo ADDBUTTON; ?>" name="addnum" class="button btn btn-default col-lg-offset-5 col-xs-offset-4">
                        </form>
                        <p class="successmessage col-lg-offset-3 col-lg-9"><?php echo $successAddPhone; ?></p>
                        <form method="POST" action="profil.php">
                            <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 modificateform col-sm-offset-3 col-sm-9" for="newnum"><?php echo DELETEPHONE; ?></label> 
                              <input type="submit" value="<?php echo DELETEBUTTON; ?>" name="deletephone2" class="button btn btn-default col-lg-offset-5 col-xs-offset-4">
                            </div>
                        </form>
                        <p class="successmessage col-lg-offset-3 col-lg-9"><?php echo $successDeletePhone; ?></p>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="displayFollow">
                <div class="demande col-lg-offset-3 col-lg-5 col-sm-offset-4">
                    <div class="row">
                        <div class="subtitle col-lg-offset-1 col-sm-12"><h3><?php echo ADDFOLLOWED; ?></h3></div>
                        <div class="search col-lg-offset-2">
                            <p class=" col-sm-offset-1"><?php
                            if($nbquest == 0) {  
                                echo NOQUEST;
                            }
                            else {
                              if($nbquest > 1) {
                                  echo QUESTHAVE.$nbquest.ASKS; 
                              }
                              else {
                                  echo QUESTHAVE.$nbquest.ASK;
                              } ?>
                            <div class="form-inline">
                                <form method="post" action="demande">
                                    <input type="submit" value="<?php echo VIEWADDBUTTON; ?>" name="answerdoctor" class="button btn btn-default col-lg-offset-1 col-xs-offset-4">
                                </form>
                            </div>
                        <?php } ?></p>
                    </div>
                    <?php if($_SESSION['role'] != 2) {  ?>
                        <form method="post" action="ajout">
                            <div class="form-inline">
                                <label class="col-lg-offset-2 col-lg-8 modificateform" for="namedoctor"><?php echo SEARCHDOCTOR; ?></label>                                                        
                                <div class="input-group search col-lg-offset-2">
                                    <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="name" placeholder="<?php echo SEARCHDOCTORPLACEHOLDER; ?>">
                                </div>
                            </div>
                            <div class="form-inline col-lg-offset-2">
                                <input type="submit" value="<?php echo SEARCHBUTTON; ?>" name="adddoctor" class="button btn btn-default col-lg-offset-1 col-sm-offset-2 col-xs-offset-4">
                            </div>
                        </form>
                <?php  }
                    else { ?>
                        <form method="post" action="ajout">
                            <div class="form-inline">
                                <label class="col-lg-offset-4 col-lg-8 modificateform" for="namedoctor"><?php echo SEARCHPATIENT; ?></label>                                                        
                                <div class="input-group search col-lg-offset-4">
                                    <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="name" placeholder="<?php echo SEARCHPATIENTPLACEHOLDER; ?>">
                                </div>
                            </div>
                            <div class="form-inline col-lg-offset-4">
                                    <input type="submit" value="<?php echo SEARCHBUTTON; ?>" name="addpatient" class="button btn btn-default col-lg-offset-1 col-xs-offset-4">
                            </div>
                        </form>
                        <?php  } ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="DeleteAccount">
                <div class="delete col-lg-offset-3 col-lg-5 col-sm-offset-3">
                    <div class="row">
                        <div class="subtitle col-lg-offset-1 col-xs-offset-2"><h3><?php echo UNSUSCRIBE; ?></h3></div>
                        <div class="delete col-lg-offset-1 col-sm-offset-1 col-xs-offset-3">
                            <div class="form-inline">
                                <div value="<?php echo DELETEACCOUNT; ?>" data-toggle="modal" data-target="#DeleteModal" class="button btn btn-default col-sm-offset-2"><?php echo DELETE; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="qrcode col-lg-offset-3 col-lg-9 col-sm-offset-1">
                    <?php if($_SESSION['role'] != 2) {  ?>
                        <h4><?php echo QRCODEMESSAGEPATIENT; ?></h4>
                        <?php }
                        else { ?>
                        <h4><?php echo QRCODEMESSAGEDOCTOR; ?></h4>
                        <?php } ?>
                    <img src="Controller/qrcode.php" class="col-lg-offset-2 col-sm-offset-4 col-xs-offset-4">
                </div>
            </div>
    </div>
    <div class="modal fade" id="DeleteModal" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="modal-title"> <?php echo DELETEMESSAGEACCOUNT; ?></h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" disabled id="username" name="username" value="<?php echo $user->username; ?>">
                    <input type="submit" value="<?php echo DELETEBUTTON; ?>" id="delete" name="delete" class="button btn btn-default col-lg-offset-4">
                </div>
                <div class="modal-footer">
                 <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo CLOSE; ?></button>
                </div>                        
            </div>
        </div>            
    </div>
<script src="assets/js/script.js"></script>
<?php
    } else {
        ?><p><?php echo $errorConnexion; ?></p><?php
    }
  include 'View/footer.php';
?>
