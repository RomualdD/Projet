<?php
    include_once 'View/header.php';
    include_once 'Controller/informationController.php';
    if(!isset($_SESSION['user'])) {
        ?><p><?php echo NOTCONNECT; ?></p><?php
    }
    else {
?>
    <div class="container view">
        <div class="row">
            <div class="col-lg-offset-4" id="addappointment">
                <h2><?php echo ADDAPPOINTMENT; ?></h2>
            </div>
            <a href="#calendar" id="viewcalendar">
                <div class="btn btn-primary col-lg-offset-5 col-xs-offset-3"><i class="fas fa-arrow-alt-circle-down"></i> <?php echo SHOWCALENDAR; ?></div>
            </a>
            <div class="col-lg-offset-3">
                <form action="rendez-vous" method="POST">
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <label for="nameappointment"><?php echo NAMEAPPOINTMENT ?> </label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="nameappoitment" placeholder="<?php echo NAMEAPPOINTMENTPLACEHOLDER; ?>" value="<?php echo isset($_POST['nameappoitment']) ? strip_tags($_POST['nameappoitment']) : ''; ?>">
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageName;?></p>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <label for="dayappointment"><?php echo DAYAPPOINTMENT; ?> </label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control" name="dayappointment" value="<?php echo isset($_POST['dayappointment']) ? strip_tags($_POST['dayappointment']) : ''; ?>">
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageDate;?></p>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <label for="hourappointment"><?php echo HOURAPPOINTMENT; ?></label>
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
                                <label for="informationappointment"><?php echo INFORMATIONAPPOINTMENT; ?> </label>
                                <textarea class="form-control" rows="5" cols="10" placeholder="<?php echo INFORMATIONAPPOINTMENTPLACEHOLDER; ?>" name="informationappointment"><?php echo isset($_POST['informationappointment']) ? strip_tags($_POST['informationappointment']) : ''; ?></textarea>
                            </div>
                            <p class="errormessage col-lg-offset-3 col-lg-9"><?php echo $errorMessageInfos;?></p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-inline">
                          <input type="submit" value="<?php echo ADDBUTTON; ?>" class="button btn btn-default col-lg-offset-4 col-xs-offset-4" name="submit">                        
                        </div>
                    </div>
                </form>
                <p class="successmessage col-lg-7"><?php echo $successAppointment; ?></p>
                <p class="errormessage col-lg-7"><?php echo $errorMessageAppointment; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-4 col-lg-8" id="calendar">
                <h2><?php echo CALENDARAPPOINTMENT; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-3 calendarchoice">
                <form action="rendez-vous" method="POST">
                    <div class="col-lg-3">
                        <select class="form-control" name="months">
                            <?php
                            foreach ($months as $monthNumber => $monthName) {
                                ?>
                                <option value="<?= $monthNumber ?>" <?= $month == $monthNumber ? 'selected' : '' ?>><?= $monthName ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" name="years">
                            <?php
                            for ($yearsList = $yearDay-1; $yearsList <= $yearDay + 100; $yearsList++) {
                                ?>
                                <option value="<?= $yearsList ?>" <?= $year == $yearsList ? 'selected' : '' ?>><?= $yearsList ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                     <input type="submit" class="button btn btn-default form-control" name="send" value="<?php echo VALID; ?>">  
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-offset-3 col-lg-8"><p><span class="col-lg-1" id="graycolor"><i class="fa fa-check-square-o" aria-hidden="true"></i></span> <?php echo PASTAPPOINTMENT; ?></p></div>
        <div class="col-lg-offset-3 col-lg-8"><p><span class="col-lg-1" id="greencolor"><i class="fa fa-book" aria-hidden="true"></i></span> <?php echo FUTUREAPPOINTMENT; ?></p></div>    
        <div class="row" id="btnaddappointment">
            <a href="#addappointment" >
                <div class="btn btn-primary col-lg-offset-5 col-xs-offset-3"><i class="fas fa-arrow-alt-circle-up"></i> <?php echo ADDAPPOINTMENT; ?></div>
            </a>
        </div>    
    </div>
    <div id="tablecalendar" class="table-responsive-sm">
        <table class="calendar table table-bordered">
            <thead>
                <tr>
                    <th class="thcalendar col-lg-12"><?php echo MONDAY;?></th>
                    <th class="thcalendar col-lg-12"><?php echo TUESDAY; ?></th>
                    <th class="thcalendar col-lg-12"><?php echo WEDNESDAY; ?></th>
                    <th class="thcalendar col-lg-12"><?php echo THURSDAY; ?></th>
                    <th class="thcalendar col-lg-12"><?php echo FRIDAY; ?></th>
                    <th class="thcalendar col-lg-12"><?php echo SATURDAY; ?></th>
                    <th class="thcalendar col-lg-12"><?php echo SUNDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALEMONDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALETUESDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALEWEDNESDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALETHURSDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALEFRIDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALESATURDAY; ?></th>
                    <th class="thcalendar col-xs-12"><?php echo INITIALESUNDAY; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php // si rendez-vous dans le mois
                if($yearappointment == $year && $monthappointment == $month) {
                    // jour en cours
                    $currentDay = 1;
                    $day='';
                    $infoappointment = array();
                    // bon nombre de cases dans le mois
                    for($daysCases = 1; $daysCases <= $numberDaysInMonth + $firstWeekDayOfMonth - 1; $daysCases++) {
                        // cherche le premier jour du mois
                        if($firstWeekDayOfMonth <= $daysCases) {
                            include 'Controller/calendarday.php';
                            if($day == $currentDay) {
                                ?><td class="tdcalendar"><?php
                                echo $currentDay;
                                // on cherche si y'a un rendez-vous ou plusieurs pour le jour
                                foreach($infoappointment as $informations) {
                                    if($informations['day'] == $currentDay && $informations['month']== $month && $informations['year']== $yearDay) {
                                        $dateNow=date('Y-m-d H:i');
                                        $verifEventDay = $informations['year'].'-'.$informations['month'].'-'.$informations['day'].' '.$hour;
                                        if($dateNow >= $verifEventDay) {  ?> 
                                            <p class="appointmentup" data-toggle="modal" data-idappointment="<?php echo $informations['id']; ?>" data-infoappointment="<?php echo $informations['infoappointment'];?>" data-hourappointment="<?php echo $informations['hour']; ?>" data-nameappointment="<?php echo $informations['nameappointment']; ?>" data-remarque="<?php echo $informations['remarque']; ?>" data-target="#modalAppointmentUp"><i class="fa fa-check-square-o" aria-hidden="true"></i></p>        
                                        <?php  }
                                        else { ?>
                                        <p class="appointment" data-toggle="modal" data-idappointment="<?php echo $informations['id']; ?>" data-infoappointment="<?php echo $informations['infoappointment'];?>" data-hourappointment="<?php echo $informations['hour']; ?>" data-nameappointment="<?php echo $informations['nameappointment']; ?>" data-target="#modalAppointment"><i class="fa fa-book" aria-hidden="true"></i></p>
                                    <?php }
                                    } 
                                } ?></td><?php
                            }
                            else { ?>
                                <td class="tdcalendar"><?php echo $currentDay; ?></td><?php
                            }
                            $currentDay++;
                        }
                        else { ?>
                            <td class="tdcalendar"></td>
                        <?php }
                        // si c'est un multiple de 7 alors changement de semaines
                        if($daysCases % 7 == 0) { ?>
                            </tr><tr>
                        <?php }
                    }
                }
                else {
                    // -- // Si calendrier n'a pas de rendez-vous
                    $currentDay = 1;
                    for($daysCases = 1; $daysCases <= $numberDaysInMonth + $firstWeekDayOfMonth - 1; $daysCases++) {
                        // cherche le premier jour du mois
                        if($firstWeekDayOfMonth <= $daysCases) { ?>
                            <td class="tdcalendar"><?php echo $currentDay; ?></td>
                            <?php 
                            $currentDay++;
                        }
                        else { ?>
                            <td class="tdcalendar"></td>
                        <?php }
                        // si c'est un multiple de 7 alors changement de semaines
                        if($daysCases % 7 == 0) { ?>
                            </tr><tr>
                        <?php }
                    }
                }  ?>
               </tr>
           </tbody>
        </table>
    </div>
    <?php include 'View/modalinformation.php';  ?>
    <script src="assets/js/modalopen.js"></script>
<?php }
include 'View/footer.php';
?>
