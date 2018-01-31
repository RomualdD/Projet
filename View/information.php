<?php
    include '../Model/verificationconnexion.php';
    if(isset($_SESSION['user'])) {
        include '../Model/appointments.php';
        include '../Controller/informationController.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4">
                <h2>Ajouter vos rendez-vous</h2>
            </div>
            <div class="col-lg-offset-3">
                <form action="information.php" method="POST">
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <label for="nameappointment">Nom du rendez-vous : </label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="nameappoitment" placeholder="Médecin" value="<?php echo isset($_POST['nameappoitment']) ? strip_tags($_POST['nameappoitment']) : ''; ?>">
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageName;?></p>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <label for="dayappointment">Jour du rendez-vous : </label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                <input type="date" class="form-control" name="dayappointment" value="<?php echo isset($_POST['dayappointment']) ? strip_tags($_POST['dayappointment']) : ''; ?>">
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageDate;?></p>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <label for="hourappointment">Horaire consultation :</label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                <input type="time" class="form-control" name="hourappointment" placeholder="<?php echo date('H:i'); ?>" value="<?php echo isset($_POST['hourappointment']) ? strip_tags($_POST['hourappointment']) : ''; ?>">
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageHour;?></p>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <div class="input-group subject">
                                <label for="informationappointment">Informations complémentaires du rendez-vous : </label>
                                <textarea class="form-control" rows="5" cols="10" placeholder="Informations supplémentaires" name="informationappointment"><?php echo isset($_POST['informationappointment']) ? strip_tags($_POST['informationappointment']) : ''; ?></textarea>
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageInfos;?></p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-inline">
                          <input type="submit" value="Ajouter !" class="button btn btn-default col-lg-offset-4" name="submit">                        
                        </div>
                    </div>
                </form>
                <p class="successmessage col-lg-7"><?php echo $successAppointment; ?></p>
                <p class="errormessage col-lg-7"><?php echo $errorMessageAppointment; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-4 col-lg-8">
                <h2>Calendrier de vos rendez-vous</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-3 calendarchoice">
                <form action="information.php" method="POST">
                    <div class="col-lg-3">
                        <select class="form-control" name="months">
                            <?php
                            foreach ($months as $monthNumber => $monthName) {
                                ?>
                                <option value="<?= $monthNumber ?>" <?= $month == $monthNumber ? 'selected' : '' ?>><?= $monthName ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" name="years">
                            <?php
                            for ($yearsList = $yearDay-1; $yearsList <= $yearDay + 100; $yearsList++) {
                                ?>
                                <option value="<?= $yearsList ?>" <?= $year == $yearsList ? 'selected' : '' ?>><?= $yearsList ?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                     <input type="submit" class="button btn btn-default form-control" name="send" value="Valider !">  
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-offset-3 col-lg-8"><p><span class="col-lg-1" id="graycolor"><i class="fa fa-check-square-o" aria-hidden="true"></i></span> Rendez-vous passé (cliquez pour ajouter une note)</p></div>
        <div class="col-lg-offset-3 col-lg-8"><p><span class="col-lg-1" id="greencolor"><i class="fa fa-book" aria-hidden="true"></i></span> Rendez-vous à venir (cliquer pour modifier ou supprimer le rendez-vous)</p></div>
    </div>
    <div id="tablecalendar" class="table-responsive-sm">
        <table class="calendar table table-bordered">
          <thead>
            <tr>
              <th class="thcalendar col-lg-12">Lundi</th>
              <th class="thcalendar col-lg-12">Mardi</th>
              <th class="thcalendar col-lg-12">Mercredi</th>
              <th class="thcalendar col-lg-12">Jeudi</th>
              <th class="thcalendar col-lg-12">Vendredi</th>
              <th class="thcalendar col-lg-12">Samedi</th>
              <th class="thcalendar col-lg-12">Dimanche</th>
              <th class="thcalendar col-xs-12">L</th>
              <th class="thcalendar col-xs-12">M</th>
              <th class="thcalendar col-xs-12">M</th>
              <th class="thcalendar col-xs-12">J</th>
              <th class="thcalendar col-xs-12">V</th>
              <th class="thcalendar col-xs-12">S</th>
              <th class="thcalendar col-xs-12">D</th>
            </tr>
           </thead>
           <tbody>
              <tr>
                <?php
                // si rendez-vous dans le mois
                if($yearappointment == $year && $monthappointment == $month) {
                    // jour en cours
                    $currentDay = 1;
                    $day='';
                    $nbmodal=0;
                    $infoappointment = array();
                    // bon nombre de cases dans le mois
                    for($daysCases = 1; $daysCases <= $numberDaysInMonth + $firstWeekDayOfMonth - 1; $daysCases++) {
                        // cherche le premier jour du mois
                        if($firstWeekDayOfMonth <= $daysCases) {
                            include '../Model/calendarday.php';
                            if($day == $currentDay) {
                                ?><td class="tdcalendar"><?php
                                echo $currentDay;
                                // on cherche si y'a un rendez-vous ou plusieurs pour le jour
                                foreach($infoappointment as $informations) {
                                    if($informations['day'] == $currentDay && $informations['month']== $month && $informations['year']== $yearDay) {
                                        $nbmodal++;
                                        $dateNow=date('Y-m-d H:i');
                                        $verifEventDay=$informations['year'].'-'.$informations['month'].'-'.$informations['day'].' '.$hour;
                                        if($dateNow>$verifEventDay) {
                                        ?> 
                                            <p class="appointmentup" data-toggle="modal" data-target="#myModal<?php echo $nbmodal;?>"><i class="fa fa-check-square-o" aria-hidden="true"></i></p>        
                                        <?php
                                        }
                                        else {
                                        ?>
                                    <p class="appointment" data-toggle="modal" data-target="#myModal<?php echo $nbmodal;?>"><i class="fa fa-book" aria-hidden="true"></i></p>
                                    <?php
                                        }
                                    } // Affichage fenêtre modal
                                    ?>
                                    <div class="modal fade" id="myModal<?php echo $nbmodal;?>" role="dialog">
                                      <div class="modal-dialog">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h3 class="modal-title"><i class="fa fa-info" aria-hidden="true"></i> Informations de ce rendez-vous :</h3>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row">
                                              <div class="col-lg-offset-1 col-lg-11">
                                                <p><?php echo 'Nom du rendez-vous : ';?><input class="col-lg-offset-1 nameappointment" type="text" name="nameappointmentforModif" id="nameappointment<?php echo $nbmodal;?>" value="<?php echo $informations['nameappointment'];?>" disabled></p>
                                                <p><?php echo 'Heure du rendez-vous : ';?><input type="text" class="col-lg-offset-1 hourappointment" name="hourappointmentforModif" id="hourappointment<?php echo $nbmodal;?>" value="<?php echo $informations['hour'];?>" disabled></p>
                                                <p><?php echo 'Informations consultation : '; ?></p><textarea class="form-control" rows="5" cols="10" type="text" name="infoappointmentforModif" id="infoappointment<?php echo $nbmodal;?>" disabled><?php echo $informations['infoappointment'];?></textarea> 
                                              </div>
                                          </div>
                                            <?php
                                                if($dateNow < $verifEventDay) {
                                            ?>
                                          <hr>
                                          <div class="row">
                                              <div class="col-lg-11">
                                                 <h3 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifier ce rendez-vous :</h3>
                                              </div>
                                          </div>
                                            <div class="row">
                                                <div class="col-lg-offset-1">
                                                    <form action="information.php" method="POST">
                                                        <div class="col-lg-12">
                                                            <div class="form-inline">
                                                                <label for="nameappointment">Nom du rendez-vous : </label>
                                                                <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                                                    <span class="input-group-addon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                                                                    <input type="text" class="form-control" id="name<?php echo $nbmodal;?>" name="nameappoitmentmodif" placeholder="Médecin">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-inline">
                                                                <label for="dayappointment">Jour du rendez-vous : </label>
                                                                <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                                    <input type="date" class="form-control" id="day<?php echo $nbmodal;?>" name="dayappointmentmodif">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-inline">
                                                                <label for="hourappointment">Horaire consultation :</label>
                                                                <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                                                    <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                                                    <input type="time" class="form-control" id="hour<?php echo $nbmodal;?>" name="hourappointmentmodif" placeholder="<?php echo date('H:i'); ?>">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-inline">
                                                                <div class="input-group subject">
                                                                    <label for="informationappointment">Informations complémentaires du rendez-vous : </label>
                                                                    <textarea class="form-control" id="info<?php echo $nbmodal;?>" rows="5" cols="10" placeholder="Informations supplémentaires" name="infosappointmentmodif"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-offset-3 col-lg-2">
                                                            <div class="form-inline">
                                                              <input id="submitmodif<?php echo $nbmodal;?>" type="submit" value="Modifier !" class="button btn btn-default col-lg-offset-4" name="submitmodif">                        
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php 
                                                   include '../Model/ajaxmodifappointment.php';
                                                ?>  
                                                </div>
                                            </div>
                                          <hr>
                                          <div class="row">
                                              <div class="col-lg-11">
                                                 <h3 class="modal-title"><i class="fa fa-times" aria-hidden="true"></i> Supprimer ce rendez-vous :</h3>
                                              </div>
                                              <div class="row">
                                                <div class="col-lg-offset-1 col-lg-11">
                                                    <form method="POST" action="information.php">
                                                      <div class="col-lg-offset-3 col-lg-2">
                                                          <div class="form-inline">
                                                              <input id="submitdelete<?php echo $nbmodal;?>" type="submit" value="Supprimer !" class="button btn btn-default col-lg-offset-4" name="submitdelete">                        
                                                          </div>
                                                      </div>
                                                    </form>
                                                    <?php include '../Model/ajaxsupprapointment.php';?> 
                                                </div>
                                              </div>
                                          </div>
                                          <?php
                                                }
                                                else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-11">
                                                            <h3 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ajouter une note à ce rendez-vous :</h3>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-offset-1 col-lg-11">
                                                                <form method="POST" action="information.php">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-inline">
                                                                            <div class="input-group subject">
                                                                                <label for="remarqueappointment">Note complémentaire du rendez-vous : </label>
                                                                                <textarea class="form-control" id="remarqueappointment<?php echo $nbmodal;?>" rows="5" cols="10" placeholder="Notes complémentaire" name="remarqueappointment"><?php echo $informations['remarque']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-offset-3 col-lg-2">
                                                                        <div class="form-inline">
                                                                          <input id="submitremarqueadd<?php echo $nbmodal;?>" type="submit" value="Ajouter !" class="button btn btn-default col-lg-offset-4" name="submitremarqueadd">                        
                                                                        </div>
                                                                    </div>                                                                    
                                                                </form>
                                                                <?php  include '../Model/ajaxaddremarque.php';?> 
                                                            </div>
                                                        </div>    
                                                    </div><?php
                                                } 
                                            ?>                                          
                                        </div>
                                        <div class="modal-footer">
                                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fermer</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php
                                   }   
                                ?></td><?php
                            }
                            else { ?>
                                <td class="tdcalendar"><?= $currentDay ?></td><?php
                            }
                            $currentDay++;
                        }
                        else {
                        ?>
                            <td class="tdcalendar"></td>
                        <?php
                        }
                        // si c'est un multiple de 7 alors changement de semaines
                        if($daysCases % 7 == 0) {
                        ?>
                            </tr><tr>
                        <?php    
                        }
                    }
                }
                else {
                    // -- // Si calendrier n'a pas de rendez-vous
                    // jour en cours
                    $currentDay = 1;
                    // bon nombre de cases dans le mois
                    for($daysCases = 1; $daysCases <= $numberDaysInMonth + $firstWeekDayOfMonth - 1; $daysCases++) {
                        // cherche le premier jour du mois
                        if($firstWeekDayOfMonth <= $daysCases) {
                        ?>
                            <td class="tdcalendar"><?= $currentDay ?></td>
                            <?php 
                            $currentDay++;
                        }
                        else {
                        ?>
                            <td class="tdcalendar"></td>
                        <?php
                        }
                        // si c'est un multiple de 7 alors changement de semaines
                        if($daysCases % 7 == 0) {
                        ?>
                            </tr><tr>
                        <?php    
                        }
                    }
                }
                ?>
               </tr>
           </tbody>
        </table>
    </div>
<?php
}
include 'footer.php';
?>
