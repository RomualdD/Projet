<?php
     // -- // Modification vérification
    if($pathology == 1 || $pathology == 2) {
        $searchinfo = $bdd->prepare('SELECT `verification`,`Heure1`,`Heure2`,`Heure3`,`Heure4`,`notification` FROM `verification` WHERE `id_utilisateur` = :id');
        $searchinfo->bindValue('id',$id,PDO::PARAM_INT);
        $searchinfo->execute();
        if($searchinfo->rowCount() == 1) {
            $info=$searchinfo->fetch();
        }
        $successModifMsg='';
        $errorModifOneClock='';
        $errorModifTwoClock='';
        $errorModifThreeClock='';
        $errorModifFourClock='';
         if(isset($_POST['modif'])) {
            $error=0;
            if(!empty($_POST['timeverif']) ||(!empty($_POST['notification']))||(!empty($_POST['clockone']))||(!empty($_POST['clocktwo']))||(!empty($_POST['clockthree']))||(!empty($_POST['clockfour']))) {
                if(!empty($_POST['notification'])) {
                    $notif=$_POST['notification'];
                }
                else {
                    $notif = $info['notification'];
                }
                if(!empty($_POST['timeverif'])) {
                    $verif = $_POST['timeverif'];  
                }
                else {
                    $verif = $info['verification'];
                }
                if(!empty($_POST['clockone'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                        $oneclock = $_POST['clockone']; 
                        $clockfirst=explode(':', $oneclock);
                        $firstHour = $clockfirst['0'];
                        $firstMin = $clockfirst['1'];                                        
                    }
                    else {
                        $errorModifOneClock= 'Erreur Heure 1 ! Le format demandé est hh:mm !';
                        $error++;
                    }
                }    
                else {
                    $oneclock = $info['Heure1'];
                    $clockfirst=explode(':', $oneclock);
                    $firstHour = $clockfirst['0'];
                    $firstMin = $clockfirst['1'];                                           
                }                                    
                if(!empty($_POST['clocktwo'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo'])) {                                
                        $twoclock = $_POST['clocktwo'];
                        $clocksecond=explode(':', $twoclock);
                        $secondHour = $clocksecond['0'];
                        $secondMin = $clocksecond['1'];                                        
                    }
                    else {
                        $errorModifTwoClock= 'Erreur Heure 2 ! Le format demandé est hh:mm !';
                        $error++;
                    }
                }
                else {
                    $twoclock = $info['Heure2'];
                    if($twoclock != '') {
                       $clocksecond=explode(':', $twoclock);
                       $secondHour = $clocksecond['0'];
                       $secondMin = $clocksecond['1'];                                        
                    }
                    else {
                        $secondHour = 24;
                        $secondMin = 59;
                    }
                }
                if(!empty($_POST['clockthree'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree'])) {                                
                        $threeclock = $_POST['clockthree'];
                        $clockthree=explode(':', $threeclock);
                        $threeHour = $clockthree['0'];
                        $threeMin = $clockthree['1'];                                        
                    }
                    else {
                       $errorModifThreeClock= 'Erreur Heure 3 ! Le format demandé est hh:mm !';
                       $error++;
                    }
                }
                else {
                    $threeclock = $info['Heure3'];
                    if($threeclock != '' ) {
                       $clockthree=explode(':', $threeclock);
                       $threeHour = $clockthree['0'];
                       $threeMin = $clockthree['1'];                                       
                    }
                    else {
                        $threeHour = 24;
                        $threeMin = 59;
                    }      
                }
                if(!empty($_POST['clockfour'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour'])) {                                                                        
                        $fourclock = $_POST['clockfour'];
                        $clockfour=explode(':', $fourclock);
                        $fourHour = $clockfour['0'];
                        $fourMin = $clockfour['1'];                                          
                    }
                    else {
                       $errorModifFourClock= 'Erreur Heure 4 ! Le format demandé est hh:mm !'; 
                        $error++;
                    }                                        
                }
                else {
                    $fourclock = $info['Heure4'];
                    if($fourclock != '') {
                        $clockfour=explode(':', $fourclock);
                        $fourHour = $clockfour['0'];
                        $fourMin = $clockfour['1'];                                          
                    }
                    else {
                        $fourHour = 24;
                        $fourMin = 59;
                    }
                }
                // Vérification des heures si dans l'ordre
                for($testverification=0 ; $testverification <= 4 ; $testverification++) {            
                    if($firstHour == $secondHour) {
                        if($firstMin > $secondMin) {
                            $clocktemp = $twoclock;
                            $twoclock = $oneclock;
                            $oneclock = $clocktemp;
                            $hourtemp = $secondHour;
                            $secondHour = $firstHour;
                            $firstHour = $hourtemp;
                            $mintemp = $secondMin;
                            $secondMin = $firstMin;
                            $firstMin = $mintemp;
                        }
                    }
                    if($firstHour > $secondHour) {
                        $clocktemp = $twoclock;
                        $twoclock = $oneclock;
                        $oneclock = $clocktemp;
                        $hourtemp = $secondHour;
                        $secondHour = $firstHour;
                        $firstHour = $hourtemp;
                        $mintemp = $secondMin;
                        $secondMin = $firstMin;
                        $firstMin = $mintemp;                                        
                    }
                    if($secondHour == $threeHour) {
                        if($secondMin > $threeMin) {
                            $clocktemp = $threeclock;
                            $threeclock = $twoclock;
                            $twoclock = $clocktemp;
                            $hourtemp = $threeHour;
                            $threeHour = $secondHour;
                            $secondHour = $hourtemp; 
                            $mintemp = $threeMin;
                            $threeMin = $secondMin;
                            $secondMin = $mintemp;                                            
                        }
                    }
                    if($secondHour > $threeHour) {
                        $clocktemp = $threeclock;
                        $threeclock = $twoclock;
                        $twoclock = $clocktemp;
                        $hourtemp = $threeHour;
                        $threeHour = $secondHour;
                        $secondHour = $hourtemp; 
                        $mintemp = $threeMin;
                        $threeMin = $secondMin;
                        $secondMin = $mintemp;                                         
                    }
                    if($threeHour == $fourHour) {
                        if($threeMin > $fourMin) {
                            $clocktemp = $fourclock;
                            $fourclock = $threeclock;
                            $threeclock = $clocktemp;
                            $hourtemp = $fourHour;
                            $fourHour = $threeHour;
                            $threeHour = $hourtemp;
                            $mintemp = $fourMin;
                            $fourMin = $threeMin;
                            $threeMin = $mintemp;                                             
                        }
                    }
                    if($threeHour > $fourHour) {
                        $clocktemp = $fourclock;
                        $fourclock = $threeclock;
                        $threeclock = $clocktemp;
                        $hourtemp = $fourHour;
                        $fourHour = $threeHour;
                        $threeHour = $hourtemp;  
                        $mintemp = $fourMin;
                        $fourMin = $threeMin;
                        $threeMin = $mintemp;                                           
                    }
                }                                
                if($error == 0) { 
                    $modifverification = $bdd->prepare('UPDATE `verification` SET `verification` = :verif,`notification` = :notif, `Heure1` = :oneclock, `Heure2` = :twoclock, `Heure3` = :threeclock, `Heure4` = :fourclock WHERE `id_utilisateur` = :id');
                    $modifverification->bindValue('verif',$verif,PDO::PARAM_STR);
                    $modifverification->bindValue('notif',$notif,PDO::PARAM_INT);
                    $modifverification->bindValue('oneclock',$oneclock,PDO::PARAM_STR);
                    $modifverification->bindValue('twoclock',$twoclock,PDO::PARAM_STR);
                    $modifverification->bindValue('threeclock',$threeclock,PDO::PARAM_STR);
                    $modifverification->bindValue('fourclock',$fourclock,PDO::PARAM_STR);
                    $modifverification->bindValue('id',$id,PDO::PARAM_INT);
                    $modifverification->execute();
                    $successModifMsg = 'Les modifications sont bien prises en compte !';
                }
            }
        }
        $succesAddmsg='';
        $errorDateMsg='';
        $errorAddOneClock='';
        $errorAddTwoClock='';
        $errorAddThreeClock='';
        $errorAddFourClock='';
         if(isset($_POST['valid'])) {
                    $error = 0;
                    if(!empty($_POST['timeverif']) && (!empty($_POST['time'])) && (!empty($_POST['notification'])) && (!empty($_POST['clockone']))) {
                        $timeverif = $_POST['timeverif'];
                        if(preg_match('#^[0-2]{1}[0-9]{1}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}[ ]{1}[1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[3]{1}[0-1]{1}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))){
                            $time = $_POST['time'];
                            //On récupère la date
                            $verif = explode(' ', $time);
                            $firstverif = $verif['0'];
                            $hourverif = $verif['1'];
                            // On met dans le format date SQ
                            $dt = DateTime::createFromFormat('d/m/Y', $firstverif);
                            $firstverif =  $dt->format('Y-m-d');
                            $time = $firstverif.' '.$hourverif;
                        }
                        else {
                            $errorDateMsg= 'Le format demandé est jj/mm/YYYY hh:mm';
                            $error++;
                        }
                        if($_POST['notification'] == 'SMS') {
                            $notification = 0;
                        }
                        else {
                            $notification = 1;
                        }
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']))) {
                            $oneclock = $_POST['clockone']; 
                            $clockfirst=explode(':', $oneclock);
                            $firstHour = $clockfirst['0'];
                            $firstMin = $clockfirst['1'];     
                        }
                        else {
                            $errorAddOneClock = 'Erreur Heure 1 ! Le format demandé est hh:mm !';
                            $error++;
                            $firstHour = 24;
                            $firstMin = 59;                             
                        }
                        if(!empty($_POST['clocktwo'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']))) {                                
                                $twoclock = $_POST['clocktwo'];
                                $clocksecond=explode(':', $twoclock);
                                $secondHour = $clocksecond['0'];
                                $secondMin = $clocksecond['1'];  
                        }
                            else {
                                $errorAddTwoClock = 'Erreur Heure 2 ! Le format demandé est hh:mm !';
                                $error++;
                            }
                        }
                        else {
                            $twoclock = '';
                            $secondHour = 24;
                            $secondMin = 59;
                        }
                        if(!empty($_POST['clockthree'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']))) {                                
                                $threeclock = $_POST['clockthree'];
                                $clockthree=explode(':', $threeclock);
                                $threeHour = $clockthree['0'];
                                $threeMin = $clockthree['1']; 
                            }
                            else {
                               $errorAddThreeClock = 'Erreur Heure 3 ! Le format demandé est hh:mm ! ';
                               $error++;
                            }
                        }
                        else {
                            $threeclock = '';
                            $threeHour = 24;
                            $threeMin = 59; 
                        }
                        if(!empty($_POST['clockfour'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']))) {                                                                        
                                $fourclock = $_POST['clockfour']; 
                                $clockfour=explode(':', $fourclock);
                                $fourHour = $clockfour['0'];
                                $fourMin = $clockfour['1'];     
                            }
                            else {
                               $errorAddFourClock = 'Erreur Heure 4 ! Le format demandé est hh:mm !'; 
                               $error++;
                            }
                        }
                        else {
                            $fourclock = '';
                            $fourHour = 0;
                            $fourMin = 0; 
                        }                            
                        if($oneclock > $twoclock && $twoclock != '') {
                            $clocktemp = $twoclock;
                            $twoclock = $oneclock;
                            $oneclock = $clocktemp;
                        }
                        elseif($twoclock > $threeclock && $threeclock != '') {
                            $clocktemp = $threeclock;
                            $threeclock = $twoclock;
                            $twoclock = $clocktemp;                            
                        }
                        elseif($threeclock > $fourclock && $fourclock != '') {
                            $clocktemp = $fourclock;
                            $fourclock = $threeclock;
                            $threeclock = $clocktemp;                            
                        }
                        for($testverification=0 ; $testverification <= 4 ; $testverification++) {            
                            if($firstHour == $secondHour) {
                                if($firstMin > $secondMin) {
                                    $clocktemp = $twoclock;
                                    $twoclock = $oneclock;
                                    $oneclock = $clocktemp;
                                    $hourtemp = $secondHour;
                                    $secondHour = $firstHour;
                                    $firstHour = $hourtemp;
                                    $mintemp = $secondMin;
                                    $secondMin = $firstMin;
                                    $firstMin = $mintemp;
                                }
                            }
                            if($firstHour > $secondHour) {
                                $clocktemp = $twoclock;
                                $twoclock = $oneclock;
                                $oneclock = $clocktemp;
                                $hourtemp = $secondHour;
                                $secondHour = $firstHour;
                                $firstHour = $hourtemp;
                                $mintemp = $secondMin;
                                $secondMin = $firstMin;
                                $firstMin = $mintemp;                                        
                            }
                            if($secondHour == $threeHour) {
                                if($secondMin > $threeMin) {
                                    $clocktemp = $threeclock;
                                    $threeclock = $twoclock;
                                    $twoclock = $clocktemp;
                                    $hourtemp = $threeHour;
                                    $threeHour = $secondHour;
                                    $secondHour = $hourtemp; 
                                    $mintemp = $threeMin;
                                    $threeMin = $secondMin;
                                    $secondMin = $mintemp;                                            
                                }
                            }
                            if($secondHour > $threeHour) {
                                $clocktemp = $threeclock;
                                $threeclock = $twoclock;
                                $twoclock = $clocktemp;
                                $hourtemp = $threeHour;
                                $threeHour = $secondHour;
                                $secondHour = $hourtemp; 
                                $mintemp = $threeMin;
                                $threeMin = $secondMin;
                                $secondMin = $mintemp;                                         
                            }
                            if($threeHour == $fourHour) {
                                if($threeMin > $fourMin) {
                                    $clocktemp = $fourclock;
                                    $fourclock = $threeclock;
                                    $threeclock = $clocktemp;
                                    $hourtemp = $fourHour;
                                    $fourHour = $threeHour;
                                    $threeHour = $hourtemp;
                                    $mintemp = $fourMin;
                                    $fourMin = $threeMin;
                                    $threeMin = $mintemp;                                             
                                }
                            }
                            if($threeHour > $fourHour) {
                                $clocktemp = $fourclock;
                                $fourclock = $threeclock;
                                $threeclock = $clocktemp;
                                $hourtemp = $fourHour;
                                $fourHour = $threeHour;
                                $threeHour = $hourtemp;  
                                $mintemp = $fourMin;
                                $fourMin = $threeMin;
                                $threeMin = $mintemp;                                           
                            }
                        }                             
                        if($error == 0) {
                            $requestverif = $bdd->prepare('INSERT INTO `verification`(`id_utilisateur`, `verification`, `Heure1`, `Heure2`, `Heure3`, `Heure4`, `notification`, `date_verification`) VALUES (:id, :verification, :hour1, :hour2, :hour3, :hour4, :notification, :dateverification)');
                            $requestverif->execute(array(
                                'id' => $id,
                                'verification' => $timeverif,
                                'hour1' => $oneclock,
                                'hour2' => $twoclock,
                                'hour3' => $threeclock,
                                'hour4' => $fourclock,
                                'notification' => $notification,
                                'dateverification' => $time
                            ));
                            $succesAddmsg= 'L\'ajout sont prises en compte !';
                        }
                    }
                    else {
                        ?><p><?php
                        echo 'Les champs ne sont pas tous remplis !';
                        ?></p><?php
                    }
                }
        }    
?>
