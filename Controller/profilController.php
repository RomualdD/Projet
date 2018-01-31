<?php
    $verification = new verification();
    $follow = new follow();
    $user = new users();
    $user->username = $_SESSION['user'];
    $requestInfo = $user->getUserInfo();
// -- // Information des résultats
    $follow->id = $id;
    $verification->userId = $id;
    $info = $verification->getVerification();
// -- // Modification vérification
    if($pathology == 1 || $pathology == 2) {
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
                    $verification->notification = $info['notification'];
                }
                if(!empty($_POST['timeverif'])) {
                    $verification->verification = $_POST['timeverif'];  
                }
                else {
                    $verification->verification = $info['verification'];
                }
                if(!empty($_POST['clockone'])) {
                    if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                        $verification->oneclock = $_POST['clockone']; 
                        $clockfirst=explode(':', $verification->oneclock);
                        $firstHour = $clockfirst['0'];
                        $firstMin = $clockfirst['1'];                                        
                    }
                    else {
                        $errorModifOneClock= 'Erreur Heure 1 ! Le format demandé est hh:mm !';
                        $error++;
                    }
                }    
                else {
                    $verification->oneclock = $info['Heure1'];
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
                        $errorModifTwoClock= 'Erreur Heure 2 ! Le format demandé est hh:mm !';
                        $error++;
                    }
                }
                else {
                    $verification->twoclock = $info['Heure2'];
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
                       $errorModifThreeClock= 'Erreur Heure 3 ! Le format demandé est hh:mm !';
                       $error++;
                    }
                }
                else {
                    $verification->threeclock = $info['Heure3'];
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
                       $errorModifFourClock= 'Erreur Heure 4 ! Le format demandé est hh:mm !'; 
                        $error++;
                    }                                        
                }
                else {
                    $verification->fourclock = $info['Heure4'];
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
// -- // Ajout des heures
         if(isset($_POST['valid'])) {
                    $error = 0;
                    if(!empty($_POST['timeverif']) && (!empty($_POST['time'])) && (!empty($_POST['notification'])) && (!empty($_POST['clockone']))) {
                        $verification->verification = $_POST['timeverif'];
                        if(preg_match('#^[0-2]{1}[0-9]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[0-2]{1}[0-9]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))){
                            $time = $_POST['time'];
                            //On récupère la date
                            $verif = explode(' ', $time);
                            $firstverif = $verif['0'];
                            $hourverif = $verif['1'];
                            // On met dans le format date SQ
                            $dt = DateTime::createFromFormat('d/m/Y', $firstverif);
                            $firstverif =  $dt->format('Y-m-d');
                            $verification->dateverification = $firstverif.' '.$hourverif;
                        }
                        else {
                            $errorDateMsg= 'Le format demandé est jj/mm/YYYY hh:mm';
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
                            $errorAddOneClock = 'Erreur Heure 1 ! Le format demandé est hh:mm !';
                            $error++;
                            $firstHour = 24;
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
                                $errorAddTwoClock = 'Erreur Heure 2 ! Le format demandé est hh:mm !';
                                $error++;
                            }
                        }
                        else {
                            $verification->twoclock = '';
                            $secondHour = 24;
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
                               $errorAddThreeClock = 'Erreur Heure 3 ! Le format demandé est hh:mm ! ';
                               $error++;
                            }
                        }
                        else {
                            $verification->threeclock = '';
                            $threeHour = 24;
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
                               $errorAddFourClock = 'Erreur Heure 4 ! Le format demandé est hh:mm !'; 
                               $error++;
                            }
                        }
                        else {
                            $verification->fourclock = '';
                            $fourHour = 0;
                            $fourMin = 0; 
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
        // -- // Profil Avk
        elseif($pathology == 3) {
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
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                            $verification->oneclock = $_POST['clockone'];    
                        }
                        else {
                            $errorAddOneClock = 'Le format demandé est hh:mm';
                            $error++;
                        }
                        if(preg_match('#^[0-9]{2}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])){
                            $time = $_POST['time'];
                            //On récupère la date
                            $verif = explode(' ', $time);
                            $firstverif = $verif['0'];
                            $hourverif = $verif['1'];
                            // On met dans le format date SQ
                            $dt = DateTime::createFromFormat('d/m/Y', $firstverif);
                            $firstverif =  $dt->format('Y-m-d');
                            $verification->dateverification = $firstverif.' '.$hourverif;
                        }
                        else {
                            $errorDateMsg = 'Le format demandé est jj/mm/YYYY hh:mm';
                            $error++;
                        }
                        if($error == 0) {
                            $verification->addVerificationAvk();
                            $succesAddmsg = 'Les modifications sont prises en compte !';
                        }
                }
                else {
                    echo 'Les champs ne sont pas tous remplis !';
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
                        $verification->notification = $info['notification'];
                    }
                    if(!empty($_POST['clock'])) {
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clock']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clock']))) {
                            $verification->oneclock = $_POST['clock'];    
                        }
                        else {
                            $errorAddOneClock = 'Le format demandé est hh:mm';
                            $error++;
                        }  
                    }
                    else {
                       $verification->oneclock = $info['Heure1']; 
                    }
                    if($error == 0) {
                        $verification->updateVerificationAvk();
                        $succesAddmsg = 'Les modifications sont prises en compte !';
                    }
                }
            }
        }
// -- // Modification du profil
    $successMsg = '';
    $errorPassword = '';
    $errorPasswordFalse = '';
    $nbquest = 0;
    if(isset($_POST['submitmodifpassword'])) {
        if(!empty($_POST['password']) && (!empty($_POST['newpassword'])) && (!empty($_POST['passwordverif']))) {
            $recuppassword = $user->getPassword();
            $password = sha1(md5($_POST['password']));
            if ($password == $recuppassword['mot_de_passe']) {
                $newpassword = sha1(md5($_POST['newpassword']));
                $newpasswordverif = sha1(md5($_POST['passwordverif']));
                if ($newpassword == $newpasswordverif) {
                    $user->modifPassword();
                    $successMsg = 'Le mot de passe a bien était modifié !';
                }
                else {
                    $errorPassword = 'Les mots de passes ne sont pas identiques !';
                }
            }
            else {
                $errorPasswordFalse = 'Ce n\'est pas votre mot de passe !';
            }
        }
        else {
            echo 'Les champs ne sont pas tous remplis !';
        }
    }
// -- // Recherche demande suivi    
$requestfollow = $follow->getFollowQuest();

