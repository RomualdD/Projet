        <?php 
    // L'utilisation de cette page est strictement réservé au crontab (tâche automatique ! )    
    include '../Model/dataBase.php';
    include '../Model/users.php';
    $users = new users();
    // Récupération de la date et l'heure du moment
    $day = date('Y-m-d H:i').':00';
    // -- // Mail prise de sang 
    // Récupération des valeurs indispensable à l'envoie de mail et la récupération de la date et l'heure de l'envoie du mail
    $requestMail = $users->getInfoAndVerification();
    foreach($requestMail as $infoMail) {
        // On compare si c'est le moment d'envoyer le mail
       if($day == $infoMail['date_verification']) {
        //Envoie du mail d'information pour rappel
        $recipient = $infoMail['mail'];
        $name = $infoMail['nom'];
        $firstname = $infoMail['prenom'];
        $subject = '[IMPORTANT] Prise de sang à faire';
        $entete = 'From: inscriptiondiavk@gmail.com';
        $message = 'Bonjour '.$firstname.' '.$name.",\r\n"
        .'Il est l\'heure de faire votre vérification !'."\r\n"
        .'N\'oubliez pas de mettre le résultat dans le tableau afin de garder en mémoire votre résultat';
        mail($recipient, $subject,$message,$entete);
       }
    }
// -- // Mail rendez-vous
    // Récupération du mail et des informations du rendez-vous
    $request = $users->getInfoAndAppointment();
    foreach($request as $informationAppointment) {
        // Récupération du jour du rendez-vous
        $date = $informationAppointment['date_rendez_vous'];
        $hourappointment = $informationAppointment['heure_rendez_vous'].':00';
        // Récupèration du jour d'avant pour pouvoir envoyer le message la veille
        $dayappointment = date('Y-m-d', strtotime($date.' - 1 DAY'));
        // Comparaison si c'est le moment d'envoyer le mail
       if($day == $dayappointment.' '.$hourappointment) {
        // Envoie du mail d'information pour informer           
        $nameappointment = $informationAppointment['nom_rendez_vous'];
        $infosappointment = $informationAppointment['infos_complementaire'];
        $recipient = $informationAppointment['mail'];
        $name = $informationAppointment['nom'];
        $firstname = $informationAppointment['prenom'];
        $subject = '[IMPORTANT] Rendez-vous du lendemain';
        $entete = 'From: inscriptiondiavk@gmail.com';
        $message = 'Bonjour '.$firstname.' '.$name.",\r\n"
        .'Votre rendez-vous "'.$nameappointment.'" est demain à '.$hourappointment." !\r\n"
        .'Les informations complémentaire que vous avez écrites sont "'.$infosappointment.'"';
        mail($recipient, $subject,$message,$entete);
       }
    }
    ?>
