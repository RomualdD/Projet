<?php
        if(isset($_POST['ajaxready'])) {
            $error = 0;
            session_start();
            include_once '../configuration.php';
            include_once '../Model/dataBase.php';
            include_once '../Model/appointments.php'; 
            include_once '../Model/users.php';
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            switch ($lang) {
                case 'fr':
                case 'fr-fr':
                    include_once '../assets/lang/FR_FR.php';
                break;
                case 'en':
                case 'en-us':
                    include_once '../assets/lang/EN_EN.php';
                break;
                default:
                    include_once '../assets/lang/EN_EN.php';
                break;
            }
            $users = new users();
            $appointment = new appointments();
            $role = $_SESSION['role'];
            $pathology = $_SESSION['pathology'];    
            $users->username = $_SESSION['user'];
            $userId = $users->getUserId();
            $id = $userId->id;
            $appointment->userId=$id;
                // Ajax Modifier
            if(!empty($_POST['modifappointment'])) {
                if(!empty($_POST['dayappointmentmodif']) || (!empty($_POST['nameappointmentmodif'])) || (!empty($_POST['hourappointmentmodif'])) || (!empty($_POST['infosappointmentmodif'])) ) {  
                    // Récupération des informations du rendez-vous actuel
                    $appointment->nameappointment = strip_tags($_POST['name']);
                    $appointment->hourappointment = $_POST['hour'];
                    $appointment->infosappointment = strip_tags($_POST['infos']);
                    $appointment->id = $_POST['id'];
                    /* Recherche du champ à modifier
                     * Vérification des regex des champs à modifier
                     * Si le champ est vide, on récupère la valeur actuelle du rendez-vous
                     */
                    if(!empty($_POST['dayappointmentmodif']) && $_POST['dayappointmentmodif'] > date('Y-m-d H:i')) {
                        if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[13-9]{1}[-]{1}[1-2]{1}[0-9]{1}$#', $_POST['dayappointmentmodif'])|| (preg_match('#^[0-9]{4}[-]{1}[0]{1}[13-9]{1}[-]{1}[0]{1}[1-9]{1}$#', $_POST['dayappointmentmodif'])) || (preg_match('#^[0-9]{4}[-]{1}[0]{1}[2]{1}[-]{1}[0]{1}[1-9]{1}$#', $_POST['dayappointmentmodif'])) || (preg_match('#^[0-9]{4}[-]{1}[0]{1}[2]{1}[-]{1}[2]{1}[0-8]{1}$#', $_POST['dayappointmentmodif'])) || (preg_match('#^[0-9]{4}[-]{1}[0]{1}[2]{1}[-]{1}[1]{1}[0-9]{1}$#', $_POST['dayappointmentmodif'])) || (preg_match('#^[0-9]{4}[-]{1}[0]{1}[13-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointmentmodif']))|| (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointmentmodif'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointmentmodif']))){                     
                            $appointment->newdayappointment =  $_POST['dayappointmentmodif'];
                        }
                        else {
                            echo 'FailedDay';
                            $error++;
                        }
                    }
                    else {
                         $requestdate = $appointment->getDateAppointment();
                         $appointment->newdayappointment = $requestdate->date;
                    }
                    if(!empty($_POST['nameappointmentmodif'])) {
                         if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒéëêèàùüûœÙğ_\'!,;-]{2,}$#', $_POST['nameappointmentmodif'])) {
                            $appointment->newnameappointment = $_POST['nameappointmentmodif'];        
                         }
                         else {
                             echo 'FailedName';
                             $error++;
                         }
                    }
                    else {
                        $appointment->newnameappointment = $appointment->nameappointment;
                    }  
                    if(!empty($_POST['hourappointmentmodif'])) {
                        if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointmentmodif']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointmentmodif'])) {
                             $appointment->newhourappointment = $_POST['hourappointmentmodif'];
                        }
                        else {
                                echo 'FailedHour';
                                $error++;
                            }
                   }
                   else {
                       $appointment->newhourappointment = $appointment->hourappointment;
                   } 
                   if(!empty($_POST['infosappointmentmodif'])) {
                        if(preg_match('#^[a-zA-Z 0-9 ÂÊÎÔÛÄËÏÖÜÀÆêûôâèæÇÉÈéàŒœÙğéëêèàùüû_\'\"!,;-]{2,}#i', $_POST['infosappointmentmodif'])) {
                           $appointment->newinfoappointment = $_POST['infosappointmentmodif'];        
                        }
                        else {
                            echo 'FailedInfo';
                            $error++;
                        }
                   }
                   else {
                       $appointment->newinfoappointment = $appointment->infosappointment;
                   }
                   // Si pas d'erreur dans les regex
                    if($error == 0) {
                        // Modification des champs modifiés
                       $appointment->updateAppointment();
                       echo 'Success';        
                    } 
                }          
            }
        // -- //Ajax Notes à ajouter après rendez-vous
            elseif(isset($_POST['addremarque'])) {          
                if(!empty($_POST['remarque'])) {
                    $appointment->nameappointment = strip_tags($_POST['name']);
                    $appointment->hourappointment = $_POST['hour'];
                    $appointment->infosappointment = strip_tags($_POST['infos']);
                    $appointment->id = $_POST['id'];
                    // Récupération des champs du rendez-vous + Ajout de la note
                    if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğéëêèàùüû@&?._\'\"!,;-]{2,}$#', $_POST['remarque'])) { 
                        $appointment->remarqueappointment = strip_tags($_POST['remarque']); 
                        // On modifie la colonne note
                        $appointment->addRemarque();
                        echo 'Success';
                    }
                    else {
                        echo 'Failed';
                        $error++;
                    }
                }       
            }
        //--//Ajax Suppression    
            elseif(isset($_POST['suppr'])) {
                if(!empty($_POST['name']) && (!empty($_POST['hour'])) && (!empty($_POST['id']))) {
                    // Récupération des données du rendez-vous
                    $appointment->nameappointment = $_POST['name'];
                    $appointment->hourappointment = $_POST['hour'];
                    $appointment->infosappointment = $_POST['infos'];
                    $appointment->id = $_POST['id'];
                    // Requête pour supprimer le rendez-vous
                    if($appointment->deleteAppointment()) {
                        // Permet de dire à l'AJAX que l'opération est effectué
                        echo 'Success';                        
                    }
                }
                else {
                    echo 'Failed';
                }         
            }
        } else {
            if(isset($_SESSION['user'])) {
            include_once 'configuration.php';
            include_once 'Model/dataBase.php';
            include_once 'Model/appointments.php'; 
            include_once 'Model/users.php';
            $users = new users();
            $appointment = new appointments();
            $users->username = $_SESSION['user'];
            $userId = $users->getUserId();
            $appointment->userId = $id = $userId->id;
            $users->username = $_SESSION['user'];
    // -- // Ajout d'un rendez-vous
        $errorMessageDate='';
        $errorMessageInfos='';
        $errorMessageName='';
        $errorMessageHour='';
        $errorMessageAppointment = '';
        $successAppointment = '';
        if(isset($_POST['submit'])) {
            $error=0;
            if(!empty($_POST['nameappoitment']) && (!empty($_POST['dayappointment'])) && (!empty($_POST['hourappointment']))) {
                if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment']))) {
                    $appointment->hourappointment = $_POST['hourappointment'];
                }
                else {
                    $errorMessageHour= ERRORHOURINFORMATION;                            
                    $error++;
                }
                if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointment']) || preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointment']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointment'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointment']))) { 
                    if($_POST['dayappointment'] >= date('Y-m-d') ) {
                        $appointment->dayappointment = strip_tags($_POST['dayappointment']);                                   
                    }
                    else {
                        $errorMessageDate = ERRORPAST;                    
                    }
                }
                else {
                    $errorMessageDate = INVALIDDATE;
                    $error++;
                }
                if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒéàûœÙğéëêèàùüû@&?._\'-]{2,}$#i', $_POST['nameappoitment'])) {
                    $appointment->nameappointment = strip_tags($_POST['nameappoitment']);
                }
                else {
                    $errorMessageName = ERRORNAMEINFORMATION;
                    $error++;
                }
                if((!empty($_POST['informationappointment']))) {
                    if(preg_match('#^[a-zA-Z 0-9 ÂÊÎÔÛÄËÏÖÜÀÆêûôâèæÇÉÈéàŒœÙğéëêèàùüû@&?._\'\"!,;-]{2,}$#i', $_POST['informationappointment'])) {
                        $appointment->informationappointment = strip_tags($_POST['informationappointment']);                
                    }
                    else {
                        $errorMessageInfos = ERRORCOMPLEMENTARYINFORMATION;
                        $error++;
                    }   
                }
                else {
                    $appointment->informationappointment='';
                }
                if($error==0) {
                    $appointmentInTime = $appointment->getVerifInformation();
                    if($appointmentInTime == 0) {
                        if($appointment->addAppointment()) {
                            $_POST['hourappointment'] = '';
                            $_POST['dayappointment'] = '';
                            $_POST['nameappointment'] = '';
                            $_POST['informationappointment'] = '';
                            $successAppointment = INFORMATIONSUCCESS;   
                        }
                    }
                    else {
                        $errorMessageAppointment = ERRORDATEAPPOINTMENT;
                    }
                }
            }
            else {
                echo ERRORINPUT;
            }
        }
    // -- // Calendrier
        $yearDay = date('Y');
        // Récupération des mois avec leur numéro
        $months = array(1 => JANUARY, 2 => FEBRUAR, 3 => MARCH, 4 => APRIL, 5 => MAY, 6 => JUNE, 7 => JULY, 8 => AUGUST, 9 => SEPTEMBER, 10 => OCTOBER, 11 => NOVEMBER, 12 => DECEMBER);
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

    // -- // Récupération des rendez-vous
        //Création d'un tableau
        $timeappoitment = array();
        // Recherche dans la base de données
        $appointmentResultForId = $appointment->getAppointment();
        foreach($appointmentResultForId as $appointmentResult) {
            // Récupération des inforations
            $idappointment = $appointmentResult->id;
            $nameappointment = $appointmentResult->name;
            $hourappointment = $appointmentResult->hour;
            $informationappointment = $appointmentResult->additional_informations;
            $remarque = $appointmentResult->remarque;
            $dateappointment = $appointmentResult->date;
            // On sépare le jour le mois et l'année du rendez-vous
            $dayappointment= $appointmentResult->day;
            $monthappointment= $appointmentResult->month;
            $yearappointment= $appointmentResult->year;
            // On écrit tout dans un tableau
            $numbercle= array('id'=>$idappointment,'name'=>$nameappointment,'date' => $dateappointment,'day'=>$dayappointment,'month'=>$monthappointment,'year'=>$yearappointment,'hour'=>$hourappointment,'infos'=>$informationappointment,'remarque'=>$remarque);
            // On le push pour avoir tous les rendez-vous
            $result =  array_push($timeappoitment,$numbercle);
        }   
        $yearappointment = 0;
        // Vérification de l'année et du mois si rendez-vous
        foreach($timeappoitment as $appointment) {
            if($appointment['year'] == $year) {
                $yearappointment=$appointment['year'];
            }
            if($appointment['month']== $month) {
                $monthappointment=$appointment['month'];
            }
        } 
    }
}   
            

    