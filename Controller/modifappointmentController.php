<?php
    session_start();
    include '../Model/dataBase.php';
    include '../Model/appointments.php'; 
    include '../Model/users.php';
    $users = new users();
    $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $id = $userId['id'];
    $appointment = new appointments();
    if(!empty($_POST['dayappointmentmodif']) || (!empty($_POST['nameappointmentmodif'])) || (!empty($_POST['hourappointmentmodif'])) || (!empty($_POST['infosappointmentmodif'])) && (!empty($_POST['modifappointment']))) {  
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
            $appointment->newdayappointment = $requestdate['date_rendez_vous'];
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
    if(!empty($_POST['hourappointment'])) {
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
            if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['infosappointmentmodif'])) {
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
           $appointment->modifAppointment();
           echo 'Success';        
        }
    }
    else {
        echo 'Failed';
    }  
// -- // Notes à ajouter après rendez-vous
    if(!empty($_POST['remarque']) && (!empty($_POST['addremarque']))) {
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
    
    if(!empty($_POST['name']) && (!empty($_POST['hour'])) && (!empty($_POST['infos'])) && (!empty($_POST['suppr']))) {
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
