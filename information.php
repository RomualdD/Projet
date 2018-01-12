<?php
session_start();
if(!isset($_SESSION['user'])) {
    include 'header.php';
    echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
    include 'header1.php';
    $yearDay = date('Y');
    // Récupération des mois avec leur numéro
    $months = array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');
    // Vérification si on a choisi un mois et une année
    if(isset($_POST['months']) && isset($_POST['years'])) {
        $month = $_POST['months'];
        $year = $_POST['years'];
    }
    else {
        //Sinon attribution du mois et de l'année en cours
        $month = date('n');
        $year = date('Y');
    }
    // Nombre de nombres de jours dans un mois
    $numberDaysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
    // Premier jour de la semaine
    $firstWeekDayOfMonth = date('N', mktime(0, 0, 0, $month, 1, $year));
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4">
                <h2>Ajouter vos rendez-vous</h2>
            </div>
                <form action="information.php" method="POST">
                    <div class="col-lg-offset-4">
                        <div class="form-inline">
                            <label for="nameappointment">Nom du rendez-vous : </label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="nameappoitment" placeholder="Médecin">
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-offset-4">
                        <div class="form-inline">
                            <label for="dayappointment">Jour du rendez-vous : </label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="dayappointment" placeholder="01/01/2018">
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-offset-4">
                        <div class="form-inline">
                            <label for="hourappointment">Horaire consultation :</label>
                            <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                                <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="hourappointment" placeholder="00:00">
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-offset-4">
                        <div class="form-inline">
                            <div class="input-group subject">
                                <label for="informationappointment">Informations complémentaires du rendez-vous : </label>
                                <textarea class="form-control" rows="5" cols="10" placeholder="Informations supplémentaires" name="informationappointment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-offset-5 col-lg-2">
                        <div class="form-inline">
                          <input type="submit" value="Ajouter !" class="button btn btn-default col-lg-offset-4" name="submit">                        
                        </div>
                    </div>
                </form>
                <?php 
                if(isset($_POST['submit'])) {
                    $error=0;
                    if(!empty($_POST['nameappoitment']) && (!empty($_POST['dayappointment'])) && (!empty($_POST['informationappointment'])) && (!empty($_POST['hourappointment']))) {
                        $nameappointment = strip_tags($_POST['nameappoitment']);
                        $dayappointment = strip_tags($_POST['dayappointment']);
                        $informationappointment = strip_tags($_POST['informationappointment']);
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment'])) {
                            $hourappointment = $_POST['hourappointment'];
                        }
                        else {
                            echo 'L\'heure n\'est pas dans un format valide (ex:00:00)!';                            
                            $error++;
                        }
                        if(preg_match('#^[0-9]{2}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}$#', $dayappointment) && (preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $informationappointment)) && (preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'-]{2,}$#i', $nameappointment))) {
                            if($error==0) {
                            $requestappoitment = $bdd->prepare('INSERT INTO rendez_vous(id_utilisateur,nom_rendez_vous, date_rendez_vous, heure_rendez_vous, infos_complementaire) VALUES(:id,:name, :date, :hour, :information)');
                            $requestappoitment->execute(array(
                                'id' => $id,
                                'name' => $nameappointment,
                                'date' => $dayappointment,
                                'hour' => $hourappointment,
                                'information' => $informationappointment
                            ));                                
                            }
                        }
                        elseif(!preg_match('#^[0-9]{2}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}$#', $dayappointment)) {
                            echo 'La date n\'est pas dans un format valide !';
                        }
                        elseif(!preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $informationappointment)) {
                            echo 'Veuillez écrire vos informations complémentaires seulement avec des lettres !';
                        }
                        elseif(!preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'-]{2,}$#i', $nameappointment)) {
                            echo 'Veuillez écrire votre nom de rendez-vous seulement avec des lettres !';
                        }
                    }
                    else {
                        echo 'Les champs ne sont pas tous remplis !';
                    }
                } 
                ?>
        </div>
        <div class="row">
            <div class="col-lg-offset-4">
                <h2>Calendrier de vos rendez-vous</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-5 calendarchoice">
                <form action="information.php" method="POST">
                    <select name="months">
                        <?php
                        foreach ($months as $monthNumber => $monthName) {
                            ?>
                            <option value="<?= $monthNumber ?>" <?= $month == $monthNumber ? 'selected' : '' ?>><?= $monthName ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <select name="years">
                        <?php
                        for ($yearsList = $yearDay; $yearsList <= $yearDay + 100; $yearsList++) {
                            ?>
                            <option value="<?= $yearsList ?>" <?= $year == $yearsList ? 'selected' : '' ?>><?= $yearsList ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <input type="submit" name="send" value="Valider">      
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive-sm">
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
               <?php
               //Création d'un tableau
               $timeappoitment=array();
               // Recherche dans la base de données
                $researchappoitment = $bdd->query('SELECT nom_rendez_vous,date_rendez_vous,heure_rendez_vous,infos_complementaire FROM rendez_vous WHERE id_utilisateur='.$id);
                while($appointment = $researchappoitment->fetch()) {
                    // Récupération des inforations
                    $nameappointment = $appointment['nom_rendez_vous'];
                    $dayAppointment = $appointment['date_rendez_vous'];
                    $hourappointment = $appointment['heure_rendez_vous'];
                    $informationappointment = $appointment['infos_complementaire'];
                    // On sépare le jour le mois et l'année du rendez-vous
                    $dayappointment= substr($dayAppointment,0,2);
                    $monthappointment= substr($dayAppointment,3,2);
                    $yearappointment= substr($dayAppointment,6,6);
                    // On écrit tout dans un tableau
                    $numbercle= array('name'=>$nameappointment,'day'=>$dayappointment,'month'=>$monthappointment,'year'=>$yearappointment,'hour'=>$hourappointment,'infos'=>$informationappointment);
                   // On le push pour avoir tous les rendez-vous
                  $result =  array_push($timeappoitment,$numbercle);
                }
               ?>
              <tr>
                <?php
                // Vérification de l'année et du mois si rendez-vous
                foreach($timeappoitment as $appointment) {
                    if($appointment['year'] == $year) {
                        $yearappointment=$appointment['year'];
                    }
                    if($appointment['month']== $month) {
                        $monthappointment=$appointment['month'];
                    }
                }
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
                            // Vérification du jour du rendez-vous
                            foreach($timeappoitment as $appointment) {
                                // Si jour du rendez-vous est le jour d'aujourd'hui alors on récupère les informations
                                if($appointment['day'] == $currentDay) {
                                        $day=$appointment['day'];
                                        $hour=$appointment['hour'];
                                        $name=$appointment['name'];
                                        $infos=$appointment['infos'];
                                        // On écrit pour récupéré les informations qu'on veut
                                        $infocle=  array('day' => $day,'hour'=>$hour,'nameappointment'=>$name,'infoappointment'=>$infos);
                                        $informations = array_push($infoappointment, $infocle);
                                } 
                            }
                            if($day == $currentDay) {
                                ?><td class="tdcalendar"><?php
                                echo $currentDay;
                                // on cherche si y'a un rendez-vous ou plusieurs pour le jour
                                foreach($infoappointment as $informations) {
                                    if($informations['day'] == $currentDay) {
                                        $nbmodal++;
                                        ?><p><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?php echo $nbmodal;?>"><i class="fa fa-book" aria-hidden="true"></i></button></p>
                                    <?php
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
                                              <p><?php echo 'Nom du rendez-vous : '.$informations['nameappointment']; ?></p>
                                              <p><?php echo 'Heure du rendez-vous : '.$informations['hour']; ?></p>
                                              <p><?php echo 'Informations du rendez-vous : '.$informations['infoappointment']; ?></p>                                              
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                         <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fermer</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div><?php
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
