<?php
    include 'bdd.php';
    $error = 0;
// -- // Modifier rendez-vous
    if(!empty($_POST['dayappointmentmodif']) || !empty($_POST['nameappointmentmodif']) || !empty($_POST['hourappointmentmodif']) || !empty($_POST['infosappointmentmodif'])) {  
        // Récupération des informations du rendez-vous actuel
        $nameappointment = strip_tags($_POST['name']);
        $hourappointment = $_POST['hour'];
        $infosappointment = strip_tags($_POST['infos']);  
        /* Recherche du champ à modifier
         * Vérification des regex des champs à modifier
         * Si le champ est vide, on récupère la valeur actuelle du rendez-vous
         */
        if(!empty($_POST['dayappointmentmodif'])) {
            if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointmentmodif']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointmentmodif']))){                     
                $newdayappointment =  $_POST['dayappointmentmodif'];
            }
            else {
                echo 'FailedDay';
                $error++;
            }
       }
       else {
           $requestdate = $db->query('SELECT `date_rendez_vous` FROM `rendez_vous` WHERE `nom_rendez_vous` = "'.$nameappointment.'" AND `heure_rendez_vous` = "'.$hourappointment.'" AND `infos_complementaire` = "'.$infosappointment.'"');
              $requestdate=$requestdate->fetch();
              $newdayappointment = $requestdate['date_rendez_vous'];
       }
       if(!empty($_POST['nameappointmentmodif'])) {
            if(!preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['nameappointmentmodif'])) {
               $newnameappointment = $_POST['nameappointmentmodif'];        
            }
            else {
                echo 'FailedName';
                $error++;
            }
       }
       else {
           $newnameappointment = $nameappointment;
       }  
       if(!empty($_POST['hourappointment'])) {
           if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointmentmodif']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointmentmodif'])) {
                $newhourappointment = $_POST['hourappointmentmodif'];
            }
            else {
                echo 'FailedHour'; 
                $error++;
            }
       }
       else {
           $newhourappointment = $hourappointment;
       } 
       if(!empty($_POST['infosappointmentmodif'])) {
            if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['infosappointmentmodif'])) {
               $newinfoappointment = $_POST['infosappointmentmodif'];        
            }
            else {
                echo 'FailedInfos';
                $error++;
            }
       }
       else {
           $newinfoappointment = $infosappointment;
       }
       // Si pas d'erreur dans les regex
        if($error == 0) {
            // Modification des champs modifiés
           $requestmodifappointment = $db->prepare('UPDATE `rendez_vous` SET `date_rendez_vous` = :newday, `nom_rendez_vous` = :newname, `heure_rendez_vous` = :newhour, `infos_complementaire` = :newinfos  WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos');
           $requestmodifappointment->bindValue(':newday',$newdayappointment, PDO::PARAM_STR);
           $requestmodifappointment->bindValue(':newname',$newnameappointment,PDO::PARAM_STR);
           $requestmodifappointment->bindValue(':newhour',$newhourappointment,PDO::PARAM_STR);
           $requestmodifappointment->bindValue(':newinfos',$newinfoappointment,PDO::PARAM_STR);
           $requestmodifappointment->bindValue(':name',$nameappointment,PDO::PARAM_STR);
           $requestmodifappointment->bindValue(':hour',$hourappointment,PDO::PARAM_STR);
           $requestmodifappointment->bindValue(':infos',$infosappointment,PDO::PARAM_STR);
           $requestmodifappointment->execute(); 
           echo 'Success';        
        }
    }
    else {
        echo 'Failed';
    }  
// -- // Notes à ajouter après rendez-vous
    if(!empty($_POST['remarque'])) {
        // Récupération des champs du rendez-vous + Ajout de la note
       $remarqueappointment = strip_tags($_POST['remarque']);
        $nameappointment = strip_tags($_POST['name']);
        $hourappointment = $_POST['hour'];
        $infosappointment = strip_tags($_POST['infos']); 
        // On modifie la colonne note
       $addremarqueappointment = $db->prepare('UPDATE `rendez_vous` SET `note` = :remarque WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos ');
       $addremarqueappointment->bindValue(':remarque', $remarqueappointment, PDO::PARAM_STR);   
       $addremarqueappointment->bindValue(':name',$nameappointment,PDO::PARAM_STR);
       $addremarqueappointment->bindValue(':hour',$hourappointment,PDO::PARAM_STR);
       $addremarqueappointment->bindValue(':infos',$infosappointment,PDO::PARAM_STR);   
       $addremarqueappointment->execute();
       echo 'Success';
    }
    else {
        echo 'Failed';
    }
?>