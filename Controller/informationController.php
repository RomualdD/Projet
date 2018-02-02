<?php
    session_start();
    if(isset($_SESSION['user'])) {
        include '../Model/dataBase.php';
        include '../Model/appointments.php'; 
        include '../Model/users.php';
        $users = new users();
        $users->username = $_SESSION['user'];
        $userId = $users->getUserId();
        $id = $userId['id'];
        $appointment = new appointments();
        $users->username = $_SESSION['user'];
        $userId = $users->getUserId();
        $appointment->userId=$id;
    // -- // Ajout d'un rendez-vous
        $errorMessageDate='';
        $errorMessageInfos='';
        $errorMessageName='';
        $errorMessageHour='';
        $errorMessageAppointment = '';
        $successAppointment = '';
        if(isset($_POST['submit'])) {

            $error=0;
            if(!empty($_POST['nameappoitment']) && (!empty($_POST['dayappointment'])) && (!empty($_POST['informationappointment'])) && (!empty($_POST['hourappointment']))) {
                if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment']) || (preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment']))) {
                    $appointment->hourappointment = $_POST['hourappointment'];
                }
                else {
                    $errorMessageHour= 'L\'heure n\'est pas dans un format valide (ex:00:00)!';                            
                    $error++;
                }
                if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointment']) || preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointment']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointment'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointment']))) { 
                    $appointment->dayappointment = strip_tags($_POST['dayappointment']);               
                }
                else {
                    $errorMessageDate = 'La date n\'est pas dans un format valide !';
                    $error++;
                }
                if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒéàûœÙğ_\'-]{2,}$#i', $_POST['nameappoitment'])) {
                    $appointment->nameappointment = strip_tags($_POST['nameappoitment']);
                }
                else {
                    $errorMessageName = 'Veuillez écrire votre nom de rendez-vous seulement avec des lettres !';
                    $error++;
                }
                if(preg_match('#^[a-zA-Z 0-9 ÂÊÎÔÛÄËÏÖÜÀÆêûôâèæÇÉÈéàŒœÙğ_\'!,;-]{2,}$#i', $_POST['informationappointment'])) {
                    $appointment->informationappointment = strip_tags($_POST['informationappointment']);                
                }
                else {
                    $errorMessageInfos = 'Veuillez écrire vos informations complémentaires seulement avec des lettres !';
                    $error++;
                }
                if($error==0) {
                    $appointmentInTime = $appointment->getVerifInformation();
                    if($appointmentInTime == 0) {
                        $appointment->addAppointment();
                        $_POST['hourappointment'] = '';
                        $_POST['dayappointment'] = '';
                        $_POST['nameappointment'] = '';
                        $_POST['informationappointment'] = '';
                        $successAppointment = 'Enregistrement de votre rendez-vous effectué avec succès !';
                    }
                    else {
                        $errorMessageAppointment = 'Vous avez déjà un rendez-vous ce jour là à la même heure !';
                    }
                }
            }
            else {
                echo 'Les champs ne sont pas tous remplis !';
            }
        }
    // -- // Calendrier
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

    // -- // Récupération des rendez-vous
        //Création d'un tableau
        $timeappoitment = array();
        // Recherche dans la base de données
        $appointmentResultForId = $appointment->getAppointment();
        foreach($appointmentResultForId as $appointmentResult) {
            // Récupération des inforations
            $nameappointment = $appointmentResult['name_appointment'];
            $hourappointment = $appointmentResult['hour_appointment'];
            $informationappointment = $appointmentResult['additional_informations'];
            $remarque = $appointmentResult['remarque'];
            // On sépare le jour le mois et l'année du rendez-vous
            $dayappointment= $appointmentResult['day'];
            $monthappointment= $appointmentResult['month'];
            $yearappointment= $appointmentResult['year'];
            // On écrit tout dans un tableau
            $numbercle= array('name'=>$nameappointment,'day'=>$dayappointment,'month'=>$monthappointment,'year'=>$yearappointment,'hour'=>$hourappointment,'infos'=>$informationappointment,'remarque'=>$remarque);
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
        // Ajax Modifier
        if(!empty($_POST['modifappointment'])) {
            $appointment = new appointments();
            $appointment->userId=$id;
            if(!empty($_POST['dayappointmentmodif']) || (!empty($_POST['nameappointmentmodif'])) || (!empty($_POST['hourappointmentmodif'])) || (!empty($_POST['infosappointmentmodif'])) ) {  
                $appointment->userId = $id;
                // Récupération des informations du rendez-vous actuel
                $appointment->nameappointment = strip_tags($_POST['name']);
                $appointment->hourappointment = $_POST['hour'];
                $appointment->infosappointment = strip_tags($_POST['infos']);  
                /* Recherche du champ à modifier
                 * Vérification des regex des champs à modifier
                 * Si le champ est vide, on récupère la valeur actuelle du rendez-vous
                 */
                if(!empty($_POST['dayappointmentmodif'])) {
                    if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointmentmodif']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointmentmodif']))){                     
                        $appointment->newdayappointment =  $_POST['dayappointmentmodif'];
                    }
                    else {
                        echo 'FailedDay';
                        $error++;
                    }
                }
                else {
                     $requestdate = $appointment->getDateAppointment();
                     $appointment->newdayappointment = $requestdate['date_appointment'];
                }
                if(!empty($_POST['nameappointmentmodif'])) {
                     if(!preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['nameappointmentmodif'])) {
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
                    if(preg_match('#^[a-zA-Z 0-9 ÂÊÎÔÛÄËÏÖÜÀÆêûôâèæÇÉÈéàŒœÙğ_\'!,;-]{2,}#i', $_POST['infosappointmentmodif'])) {
                       $appointment->newinfoappointment = $_POST['infosappointmentmodif'];        
                    }
                    else {
                        echo 'FailedInfos';
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
            else {
                echo 'Failed';
            }          
        }
    // -- //Ajax Notes à ajouter après rendez-vous
        if(isset($_POST['addremarque'])) {
            $appointment = new appointments();
        $appointment->userId=$id;            
            if(!empty($_POST['remarque'])) {
                // Récupération des champs du rendez-vous + Ajout de la note
                $appointment->remarqueappointment = strip_tags($_POST['remarque']);
                $appointment->nameappointment = strip_tags($_POST['name']);
                $appointment->hourappointment = $_POST['hour'];
                $appointment->infosappointment = strip_tags($_POST['infos']); 
                // On modifie la colonne note
                $appointment->addRemarque();
                echo 'Success';
            }
            else {
                echo 'Failed';
            }        
        }
    //--//Ajax Suppression    
        if(isset($_POST['suppr'])) {
            $appointment = new appointments();
            $appointment->userId=$id;
            if(!empty($_POST['name']) && (!empty($_POST['hour'])) && (!empty($_POST['infos']))) {
                // Récupération des données du rendez-vous
                $appointment->nameappointment = $_POST['name'];
                $appointment->hourappointment = $_POST['hour'];
                $appointment->infosappointment = $_POST['infos'];
                // Requête pour supprimer le rendez-vous
                $appointment->deleteAppointment();
                // Permet de dire à l'AJAX que l'opération est effectué
                echo 'Success';
            }
            else {
                echo 'Failed';
            }         
        }
    }
            

    