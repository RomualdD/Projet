<?php
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
                $hourappointment = $_POST['hourappointment'];
            }
            else {
                $errorMessageHour= 'L\'heure n\'est pas dans un format valide (ex:00:00)!';                            
                $error++;
            }
            if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointment']) || preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointment']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['dayappointment'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['dayappointment']))) { 
                $dayappointment = strip_tags($_POST['dayappointment']);               
            }
            else {
                $errorMessageDate = 'La date n\'est pas dans un format valide !';
                $error++;
            }
            if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'-]{2,}$#i', $_POST['nameappoitment'])) {
                $nameappointment = strip_tags($_POST['nameappoitment']);
            }
            else {
                $errorMessageName = 'Veuillez écrire votre nom de rendez-vous seulement avec des lettres !';
                $error++;
            }
            if(preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['informationappointment'])) {
                $informationappointment = strip_tags($_POST['informationappointment']);                
            }
            else {
                $errorMessageInfos = 'Veuillez écrire vos informations complémentaires seulement avec des lettres !';
                $error++;
            }
            if($error==0) {
                $searchappointment = $db->query('SELECT `date_rendez_vous` FROM `rendez_vous` WHERE `date_rendez_vous` = "'.$dayappointment.'" AND `heure_rendez_vous` = "'.$hourappointment.'" AND `id_utilisateur` = '.$id);
                $appointmentInTime = $searchappointment->fetchColumn();
                $searchappointment->closeCursor();
                if($appointmentInTime == 0) {
                    $requestappointment = $db->prepare('INSERT INTO `rendez_vous`(`id_utilisateur`,`nom_rendez_vous`, `date_rendez_vous`, `heure_rendez_vous`, `infos_complementaire`) VALUES(:id,:name, :date, :hour, :information)');
                    $requestappointment->bindValue('id',$id, PDO::PARAM_INT);
                    $requestappointment->bindValue('name',$nameappointment,PDO::PARAM_STR);
                    $requestappointment->bindValue('date',$dayappointment,PDO::PARAM_STR);
                    $requestappointment->bindValue('hour',$hourappointment,PDO::PARAM_STR);
                    $requestappointment->bindValue('information',$informationappointment,PDO::PARAM_STR);
                    $requestappointment->execute();
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
    $timeappoitment=array();
    // Recherche dans la base de données
    $researchappoitment = $db->query('SELECT `nom_rendez_vous`,DATE_FORMAT(`date_rendez_vous`,"%d") AS day,DATE_FORMAT(`date_rendez_vous`,"%m") AS month,DATE_FORMAT(`date_rendez_vous`,"%Y") AS year,`heure_rendez_vous`,`infos_complementaire`,`note` FROM `rendez_vous` WHERE `id_utilisateur`='.$id.' ORDER BY heure_rendez_vous');
    $appointment = $researchappoitment->fetchAll();
    $db = NULL;
    foreach($appointment as $appointmentResult) {
        // Récupération des inforations
        $nameappointment = $appointmentResult['nom_rendez_vous'];
        $hourappointment = $appointmentResult['heure_rendez_vous'];
        $informationappointment = $appointmentResult['infos_complementaire'];
        $remarque = $appointmentResult['note'];
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