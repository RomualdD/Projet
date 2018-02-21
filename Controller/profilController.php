<?php
if(isset($_POST['deleteajax'])) {
    session_start();
    include_once '../Model/dataBase.php'; 
    include_once '../Model/verification.php';
    include_once '../Model/follow.php';
    include_once '../Model/users.php'; 
    $users = new users();
    $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $id = $userId['id'];
    $pathology = $_SESSION['pathology'];
}
    $verification = new verification();
    $follow = new follow();
    $user = new users();
    $user->username = $_SESSION['user'];
    $requestInfo = $user->getUserInfo();
// -- // Information des résultats
    $follow->id = $id;
    $verification->userId = $id;
    $user->id = $id;
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
                    $verification->oneclock = $info['onehour'];
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
                    $verification->twoclock = $info['twohour'];
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
                    $verification->threeclock = $info['threehour'];
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
                    $verification->fourclock = $info['fourhour'];
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
                            $verification->dateverification = $firstverif.' '.$hourverif.':00';
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
                                $errorAddTwoClock = 'Erreur Heure 2 ! Le format demandé est hh:mm !';
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
                               $errorAddThreeClock = 'Erreur Heure 3 ! Le format demandé est hh:mm ! ';
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
                               $errorAddFourClock = 'Erreur Heure 4 ! Le format demandé est hh:mm !'; 
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
                            $succesAddmsg= 'L\'ajout est bien prise en compte !';
                        }
                    }
                    else {
                        $error = 'Les champs ne sont pas tous remplis !';
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
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clock']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                            $verification->oneclock = $_POST['clock'];    
                        }
                        else {
                            $errorAddOneClock = 'Le format demandé est hh:mm';
                            $error++;
                        }
                        if(preg_match('#^[0-2]{1}[0-9]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']) || (preg_match('#^[0-2]{1}[0-9]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])) || (preg_match('#^[3]{1}[0-1]{1}[\/]{1}[0]{1}[1-9]{1}[\/]{1}[0-9]{4}[ ]{1}[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time']))){
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
                            $errorDateMsg = 'Le format demandé est jj/mm/YYYY hh:mm';
                            $error++;
                        }
                        if($error == 0) {
                            $verification->verification = 'Mois';
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
                       $verification->oneclock = $info['onehour']; 
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
    // -- // Modification du mot de passe
    if(isset($_POST['submitmodifpassword'])) {
        if(!empty($_POST['password']) && (!empty($_POST['newpassword'])) && (!empty($_POST['passwordverif']))) {
            $recuppassword = $user->getPassword();
            $password = $_POST['password'];
            if (password_verify($password,$recuppassword['password'])) {
                $newpassword = $_POST['newpassword'];
                $newpasswordverif = $_POST['passwordverif'];
                if ($newpassword == $newpasswordverif) {
                    $user->password = password_hash($newpassword,PASSWORD_DEFAULT);
                    $user->updatePassword();
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
            $errormessage= 'Les champs ne sont pas tous remplis !';
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
                $successModifMail = 'Le mail a bien était modifié !';
            }
            else {
                $errorMessageMail = 'Le mail n\'est pas valide !';
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
            $successModifPhone = 'Le numéro a bien était modifié !';
        }
        else {
            $errorMessagePhone = 'Le numéro de téléphone n\'est pas valide !';
        }   
    }
    // -- // Modification du second numéro de téléphone
    if(isset($_POST['addnum'])) {
        if(preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['newnum'])) {
            $user->phone2 = strip_tags($_POST['newnum']);  
            $user->updateSecondPhone();
            $successAddPhone = 'Le numéro a bien était ajouté !';
        }
        else {
            $errorMessagePhone2 = 'Le numéro de téléphone n\'est pas valide !';
        }   
    }
    if(isset($_POST['deletephone2'])) {
        $user->deleteSecondPhone();
        $successDeletePhone = 'Votre second numéro de téléphone n\'existe plus !';
    } 
    if(isset($_POST['deleteajax'])) {
        $follow->deleteFollowById();
        $user->deleteAccount();
        session_unset();
        session_destroy();
        echo 'Success';
    }
// -- // Recherche demande suivi    
$requestfollow = $follow->getFollowQuest();
foreach($requestfollow as $request) {
    $nbquest++;
}
