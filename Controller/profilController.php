<?php
if(isset($_POST['deleteajax'])) {
    session_start();
    include_once '../configuration.php';
    include_once '../Model/dataBase.php'; 
    include_once '../Model/verification.php';
    include_once '../Model/follow.php';
    include_once '../Model/users.php'; 
    include_once '../Model/appointments.php';
    include_once '../Model/suivis.php';
    $users = new users();
    $followup = new suivis();
    $appointment = new appointments();
    $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $followup->id = $appointment->id = $id = $userId->id;
    $pathology = $_SESSION['pathology'];
}
    $verification = new verification();
    $follow = new follow();
    $user = new users();
    $user->username = $_SESSION['user'];
    $requestInfo = $user->getUserInfo();
// -- // Information des résultats
    $user->id = $verification->userId = $follow->id = $id;
    $info = $verification->getVerification();
// -- // Modification vérification
    if($pathology == 2) {
        $successModifMsg='';
        $errorModifOneClock='';
        $errorModifTwoClock='';
        $errorModifThreeClock='';
        $errorModifFourClock='';
         if(isset($_POST['modif'])) {
            $error=0;
            if(!empty($_POST['timeverif']) ||(!empty($_POST['notification']))||(!empty($_POST['clockone']))||(!empty($_POST['clocktwo']))||(!empty($_POST['clockthree']))||(!empty($_POST['clockfour']))) {
                if(!empty($_POST['notification'])) {
                    $verification->notification = $_POST['notification'];
                }
                else {
                    $verification->notification = $info->notification;
                }
                if(!empty($_POST['timeverif'])) {
                    $verification->verification = $_POST['timeverif'];  
                }
                else {
                    $verification->verification = $info->verification;
                }
                if(!empty($_POST['clockone'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                        $verification->oneclock = $_POST['clockone']; 
                        $clockfirst=explode(':', $verification->oneclock);
                        $firstHour = $clockfirst['0'];
                        $firstMin = $clockfirst['1'];                                        
                    }
                    else {
                        $errorModifOneClock= HOURONE;
                        $error++;
                    }
                }    
                else {
                    $verification->oneclock = $info->one_hour;
                    $clockfirst=explode(':', $verification->oneclock);
                    $firstHour = $clockfirst['0'];
                    $firstMin = $clockfirst['1'];                                           
                }                                    
                if(!empty($_POST['clocktwo'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo'])) {                                
                        $verification->twoclock = $_POST['clocktwo'];
                        $clocksecond=explode(':', $verification->twoclock);
                        $secondHour = $clocksecond['0'];
                        $secondMin = $clocksecond['1'];                                        
                    }
                    else {
                        $errorModifTwoClock= HOURTWO;
                        $error++;
                    }
                }
                else {
                    $verification->twoclock = $info->two_hour;
                    if($verification->twoclock != '') {
                       $clocksecond=explode(':', $verification->twoclock);
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
                        $verification->threeclock = $_POST['clockthree'];
                        $clockthree=explode(':', $verification->threeclock);
                        $threeHour = $clockthree['0'];
                        $threeMin = $clockthree['1'];                                        
                    }
                    else {
                       $errorModifThreeClock= HOURTHREE;
                       $error++;
                    }
                }
                else {
                    $verification->threeclock = $info->three_hour;
                    if($verification->threeclock != '' ) {
                       $clockthree=explode(':', $verification->threeclock);
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
                        $verification->fourclock = $_POST['clockfour'];
                        $clockfour=explode(':', $verification->fourclock);
                        $fourHour = $clockfour['0'];
                        $fourMin = $clockfour['1'];                                          
                    }
                    else {
                       $errorModifFourClock= HOURFOUR; 
                        $error++;
                    }                                        
                }
                else {
                    $verification->fourclock = $info->four_hour;
                    if($verification->fourclock != '') {
                        $clockfour=explode(':', $verification->fourclock);
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
                            $clocktemp = $verification->twoclock;
                            $verification->twoclock = $verification->oneclock;
                            $verification->oneclock = $clocktemp;
                            $hourtemp = $secondHour;
                            $secondHour = $firstHour;
                            $firstHour = $hourtemp;
                            $mintemp = $secondMin;
                            $secondMin = $firstMin;
                            $firstMin = $mintemp;
                        }
                    }
                    if($firstHour > $secondHour) {
                        $clocktemp = $verification->twoclock;
                        $verification->twoclock = $verification->oneclock;
                        $verification->oneclock = $clocktemp;
                        $hourtemp = $secondHour;
                        $secondHour = $firstHour;
                        $firstHour = $hourtemp;
                        $mintemp = $secondMin;
                        $secondMin = $firstMin;
                        $firstMin = $mintemp;                                        
                    }
                    if($secondHour == $threeHour) {
                        if($secondMin > $threeMin) {
                            $clocktemp = $verification->threeclock;
                            $verification->threeclock = $verification->twoclock;
                            $verification->twoclock = $clocktemp;
                            $hourtemp = $threeHour;
                            $threeHour = $secondHour;
                            $secondHour = $hourtemp; 
                            $mintemp = $threeMin;
                            $threeMin = $secondMin;
                            $secondMin = $mintemp;                                            
                        }
                    }
                    if($secondHour > $threeHour) {
                        $clocktemp = $verification->threeclock;
                        $verification->threeclock = $verification->twoclock;
                        $verification->twoclock = $clocktemp;
                        $hourtemp = $threeHour;
                        $threeHour = $secondHour;
                        $secondHour = $hourtemp; 
                        $mintemp = $threeMin;
                        $threeMin = $secondMin;
                        $secondMin = $mintemp;                                         
                    }
                    if($threeHour == $fourHour) {
                        if($threeMin > $fourMin) {
                            $clocktemp = $verification->fourclock;
                            $verification->fourclock = $verification->threeclock;
                            $verification->threeclock = $clocktemp;
                            $hourtemp = $fourHour;
                            $fourHour = $threeHour;
                            $threeHour = $hourtemp;
                            $mintemp = $fourMin;
                            $fourMin = $threeMin;
                            $threeMin = $mintemp;                                             
                        }
                    }
                    if($threeHour > $fourHour) {
                        $clocktemp = $verification->fourclock;
                        $verification->fourclock = $verification->threeclock;
                        $verification->threeclock = $clocktemp;
                        $hourtemp = $fourHour;
                        $fourHour = $threeHour;
                        $threeHour = $hourtemp;  
                        $mintemp = $fourMin;
                        $fourMin = $threeMin;
                        $threeMin = $mintemp;                                           
                    }
                }                                
                if($error == 0) { 
                    $verification->updateVerification();
                    $successModifMsg = MODIFICATEHOUR;
                }
            }
        }
        $succesAddmsg='';
        $errorDateMsg='';
        $errorAddOneClock='';
        $errorAddTwoClock='';
        $errorAddThreeClock='';
        $errorAddFourClock='';
// -- // Ajout des heures
         if(isset($_POST['valid'])) {
                    $error = 0;
                    if(!empty($_POST['timeverif']) && (!empty($_POST['time'])) && (!empty($_POST['notification'])) && (!empty($_POST['clockone']))) {
                        $verification->verification = $_POST['timeverif'];
                        if(preg_match('#^[0-2]{1}[1-9]{1}[\/]{1}[0]{1}[13-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[0-2]{1}[0-9]{1}[\/]{1}[0]{1}[13-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[13-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[2]{1}[0-8]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))  || (preg_match('#^[2]{1}[0-8]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[0-1]{1}[0-9]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))|| (preg_match('#^[0-1]{1}[0-9]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])))) {
                            $time = $_POST['time'];
                            //On récupère la date
                            $verif = explode(' ', $time);
                            $firstverif = $verif['0'];
                            $hourverif = $verif['1'];
                            // On met dans le format date SQ
                            $dt = DateTime::createFromFormat('d/m/Y', $firstverif);
                            $firstverif =  $dt->format('Y-m-d');
                            $verification->dateverification = $firstverif.' '.$hourverif.':00';
                        }
                        else {
                            $errorDateMsg= FORMATHOUR;
                            $error++;
                        }
                        if($_POST['notification'] == 'SMS') {
                            $verification->notification = 0;
                        }
                        else {
                            $verification->notification = 1;
                        }
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']))) {
                            $verification->oneclock = $_POST['clockone']; 
                            $clockfirst=explode(':', $verification->oneclock);
                            $firstHour = $clockfirst['0'];
                            $firstMin = $clockfirst['1'];     
                        }
                        else {
                            $errorAddOneClock = HOURONE;
                            $error++;
                            $firstHour = 23;
                            $firstMin = 59;                             
                        }
                        if(!empty($_POST['clocktwo'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clocktwo']))) {                                
                                $verification->twoclock = $_POST['clocktwo'];
                                $clocksecond=explode(':', $verification->twoclock);
                                $secondHour = $clocksecond['0'];
                                $secondMin = $clocksecond['1'];  
                        }
                            else {
                                $errorAddTwoClock = HOURTWO;
                                $error++;
                            }
                        }
                        else {
                            $verification->twoclock = '';
                            $secondHour = 23;
                            $secondMin = 59;
                        }
                        if(!empty($_POST['clockthree'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockthree']))) {                                
                                $verification->threeclock = $_POST['clockthree'];
                                $clockthree=explode(':', $verification->threeclock);
                                $threeHour = $clockthree['0'];
                                $threeMin = $clockthree['1']; 
                            }
                            else {
                               $errorAddThreeClock = HOURTHREE;
                               $error++;
                            }
                        }
                        else {
                            $verification->threeclock = '';
                            $threeHour = 23;
                            $threeMin = 59; 
                        }
                        if(!empty($_POST['clockfour'])) {
                            if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockfour']))) {                                                                        
                                $verification->fourclock = $_POST['clockfour']; 
                                $clockfour=explode(':', $verification->fourclock);
                                $fourHour = $clockfour['0'];
                                $fourMin = $clockfour['1'];     
                            }
                            else {
                               $errorAddFourClock = HOURFOUR; 
                               $error++;
                            }
                        }
                        else {
                            $verification->fourclock = '';
                            $fourHour = 23;
                            $fourMin = 59; 
                        }                            
                        if($verification->oneclock > $verification->twoclock && $verification->twoclock != '') {
                            $clocktemp = $verification->twoclock;
                            $verification->twoclock = $verification->oneclock;
                            $verification->oneclock = $clocktemp;
                            $hourtemp = $secondHour;
                            $secondHour = $firstHour;
                            $firstHour = $hourtemp;
                            $mintemp = $secondMin;
                            $secondMin = $firstMin;
                            $firstMin = $mintemp;
                        }
                        elseif($verification->twoclock > $verification->threeclock && $verification->threeclock != '') {
                            $clocktemp = $verification->threeclock;
                            $verification->threeclock = $verification->twoclock;
                            $verification->twoclock = $clocktemp;  
                            $hourtemp = $threeHour;
                            $threeHour = $secondHour;
                            $secondHour = $hourtemp; 
                            $mintemp = $threeMin;
                            $threeMin = $secondMin;
                            $secondMin = $mintemp;                              
                        }
                        elseif($verification->threeclock > $verification->fourclock && $verification->fourclock != '') {
                            $clocktemp = $verification->fourclock;
                            $verification->fourclock = $verification->threeclock;
                            $verification->threeclock = $clocktemp;
                            $hourtemp = $fourHour;
                            $fourHour = $threeHour;
                            $threeHour = $hourtemp;
                            $mintemp = $fourMin;
                            $fourMin = $threeMin;
                            $threeMin = $mintemp;                            
                        }
                        for($testverification=0 ; $testverification <= 5 ; $testverification++) {            
                            if($firstHour == $secondHour) {
                                if($firstMin > $secondMin) {
                                    $clocktemp = $verification->twoclock;
                                    $verification->twoclock = $verification->oneclock;
                                    $verification->oneclock = clocktemp;
                                    $hourtemp = $secondHour;
                                    $secondHour = $firstHour;
                                    $firstHour = $hourtemp;
                                    $mintemp = $secondMin;
                                    $secondMin = $firstMin;
                                    $firstMin = $mintemp;
                                }
                            }
                            if($firstHour > $secondHour) {
                                $clocktemp = $verification->twoclock;
                                $verification->twoclock = $verification->oneclock;
                                $verification->oneclock = $clocktemp;
                                $hourtemp = $secondHour;
                                $secondHour = $firstHour;
                                $firstHour = $hourtemp;
                                $mintemp = $secondMin;
                                $secondMin = $firstMin;
                                $firstMin = $mintemp;                                        
                            }
                            if($secondHour == $threeHour) {
                                if($secondMin > $threeMin) {
                                    $clocktemp = $verification->threeclock;
                                    $verification->threeclock = $verification->twoclock;
                                    $verification->twoclock = $clocktemp;
                                    $hourtemp = $threeHour;
                                    $threeHour = $secondHour;
                                    $secondHour = $hourtemp; 
                                    $mintemp = $threeMin;
                                    $threeMin = $secondMin;
                                    $secondMin = $mintemp;                                            
                                }
                            }
                            if($secondHour > $threeHour) {
                                $clocktemp = $verification->threeclock;
                                $verification->threeclock = $verification->twoclock;
                                $verification->twoclock = $clocktemp;
                                $hourtemp = $threeHour;
                                $threeHour = $secondHour;
                                $secondHour = $hourtemp; 
                                $mintemp = $threeMin;
                                $threeMin = $secondMin;
                                $secondMin = $mintemp;                                         
                            }
                            if($threeHour == $fourHour) {
                                if($threeMin > $fourMin) {
                                    $clocktemp = $verification->fourclock;
                                    $verification->fourclock = $verification->threeclock;
                                    $verification->threeclock = $clocktemp;
                                    $hourtemp = $fourHour;
                                    $fourHour = $threeHour;
                                    $threeHour = $hourtemp;
                                    $mintemp = $fourMin;
                                    $fourMin = $threeMin;
                                    $threeMin = $mintemp;                                             
                                }
                            }
                            if($threeHour > $fourHour) {
                                $clocktemp = $verification->fourclock;
                               $verification->fourclock = $verification->threeclock;
                               $verification->threeclock = $clocktemp;
                               $hourtemp = $fourHour;
                               $fourHour = $threeHour;
                               $threeHour = $hourtemp;  
                               $mintemp = $fourMin;
                               $fourMin = $threeMin;
                               $threeMin = $mintemp;                                           
                            }
                        }                             
                        if($error == 0) {
                            $verification->addVerificationDiabete();
                            $succesAddmsg= SUCCESSADDHOUR;
                        }
                    }
                    else {
                        $error = ERRORINPUT;
                    }
                }
        }
        // -- // Profil Avk
        elseif($pathology == 3 || $pathology == 4) {
            $error = 0;
            $succesAddmsg='';
            $errorDateMsg='';
            $errorAddOneClock='';
            if(isset($_POST['valid'])) {
                if(isset($_POST['time']) && (isset($_POST['notification'])) && (isset($_POST['clock']))) {
                        if($_POST['notification'] == 'SMS') {
                            $verification->notification = 0;
                        }
                        else {
                            $verification->notification = 1;
                        }
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clock']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                            $verification->oneclock = $_POST['clock'];    
                        }
                        else {
                            $errorAddOneClock = FORMATTIME;
                            $error++;
                        }
                        if(preg_match('#^[0-2]{1}[1-9]{1}[\/]{1}[0]{1}[13-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[0-2]{1}[0-9]{1}[\/]{1}[0]{1}[13-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[13-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[2]{1}[0-8]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))  || (preg_match('#^[2]{1}[0-8]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[0-1]{1}[0-9]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))|| (preg_match('#^[0-1]{1}[0-9]{1}[\/]{1}[0]{1}[2]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])))) {
                            $time = $_POST['time'];
                            //On récupère la date
                            $verif = explode(' ', $time);
                            $firstverif = $verif['0'];
                            $hourverif = $verif['1'];
                            // On met dans le format date SQ
                            $dt = DateTime::createFromFormat('d/m/Y', $firstverif);
                            $firstverif =  $dt->format('Y-m-d');
                            $verification->dateverification = $firstverif.' '.$hourverif.':00';
                        }
                        else {
                            $errorDateMsg = FORMATHOUR;
                            $error++;
                        }
                        if($error == 0) {
                            if($pathology == 4) {
                                $verification->verification = 'Mois';
                            }
                            else {
                                $verification->verification = '3 Mois';
                            }    
                            $verification->addVerificationAvk();
                            $succesAddmsg = MODIFICATEHOUR;
                        }
                }
                else {
                    echo ERRORINPUT;
                }
            }
            if(isset($_POST['modifverif'])) {
                if(isset($_POST['notification']) || (isset($_POST['clock']))) {
                    if($_POST['notification'] == 'SMS') {
                        $verification->notification = 0;
                    }
                    elseif($_POST['notification'] == 'Mail') {
                        $verification->notification = 1;
                    }
                    else {
                        $verification->notification = $info->notification;
                    }
                    if(!empty($_POST['clock'])) {
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clock']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clock']))) {
                            $verification->oneclock = $_POST['clock'];    
                        }
                        else {
                            $errorAddOneClock = FORMATTIME;
                            $error++;
                        }  
                    }
                    else {
                       $verification->oneclock = $info->onehour; 
                    }
                    if($error == 0) {
                        $verification->updateVerificationAvk();
                        $succesAddmsg = MODIFICATEHOUR;
                    }
                }
            }
        }
// -- // Modification du profil
    $successMsg = '';
    $errorPassword = '';
    $errorPasswordFalse = '';
    $nbquest = 0;
    // -- // Modification du mot de passe
    if(isset($_POST['submitmodifpassword'])) {
        if(!empty($_POST['password']) && (!empty($_POST['newpassword'])) && (!empty($_POST['passwordverif']))) {
            $recuppassword = $user->getPassword();
            $password = $_POST['password'];
            if (password_verify($password,$recuppassword->password)) {
                $newpassword = $_POST['newpassword'];
                $newpasswordverif = $_POST['passwordverif'];
                if ($newpassword == $newpasswordverif) {
                    $user->password = password_hash($newpassword,PASSWORD_DEFAULT);
                    $user->updatePassword();
                    $successMsg = PASSWORDMODIFICATESUCCESS;
                }
                else {
                    $errorPassword = PASSWORDIDENTICERROR;
                }
            }
            else {
                $errorPasswordFalse = PASSWORDNOTGOOD;
            }
        }
        else {
            $errormessage= ERRORINPUT;
        }
    }
    $successModifMail='';
    $errorMessageMail='';
    // -- // Modification du mail
    if(isset($_POST['modificatemail'])) {
        if(!empty($_POST['newmail'])) {
            if(preg_match('#^[\w\-\.]+[a-z0-9]@[\w\-\.]+[a-z0-9]\.[a-z]{2,}$#',$_POST['newmail'])) {
                $user->mail = strip_tags($_POST['newmail']);   
                $user->updateMail();
                $successModifMail = SUCCESSMODIFICATEMAIL;
            }
            else {
                $errorMessageMail = ERRORMAIL;
            }
        }
    }
    $successAddPhone='';
    $successModifPhone='';
    $errorMessagePhone2='';
    $errorMessagePhone='';
    $successDeletePhone = '';
    // -- // Modification du premier numéro de téléphone
    if(isset($_POST['submitmodificatenum'])) {
        if(preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['modificatenum'])) {
            $user->phone = strip_tags($_POST['modificatenum']); 
            $user->updatePhone();
            $successModifPhone = SUCCESSMODIFICATEPHONE;
        }
        else {
            $errorMessagePhone = ERRORPHONE;
        }   
    }
    // -- // Modification du second numéro de téléphone
    if(isset($_POST['addnum'])) {
        if(preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['newnum'])) {
            $user->phone2 = strip_tags($_POST['newnum']);  
            $user->updateSecondPhone();
            $successAddPhone = ADDPHONEMESSAGE;
        }
        else {
            $errorMessagePhone2 = ERRORPHONE;
        }   
    }
    if(isset($_POST['deletephone2'])) {
        $user->deleteSecondPhone();
        $successDeletePhone = DELETEPHONE;
    } 
    if(isset($_POST['deleteajax'])) {
        $appointment->deleteAppointment();
        $followup->deleteRate();
        $verification->deleteVerification();
        $follow->deleteFollowById();
        $user->deleteAccount();
        session_unset();
        session_destroy();
        setcookie('user','',time() - 3600,'/','diavk',0,1);
        setcookie('firstname','',time() - 3600,'/','diavk',0,1);
        setcookie('name','',time() - 3600,'/','diavk',0,1);
        setcookie('role','',time() - 3600,'/','diavk',0,1);
        setcookie('pathology','',time() - 3600,'/','diavk',0,1);
        echo 'Success';
    }
// -- // Recherche demande suivi    
$requestfollow = $follow->getnbFollowQuest();
$nbquest = $requestfollow->nbFollow;
