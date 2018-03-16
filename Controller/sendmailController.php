    <?php 
    // L'utilisation de cette page est strictement réservé au crontab (tâche automatique ! ) 
    include '/home/romuald/www/ProjetFinal/assets/lang/FR_FR.php';
    include '/home/romuald/www/ProjetFinal/configuration.php';
    include '/home/romuald/www/ProjetFinal/Model/dataBase.php';
    include '/home/romuald/www/ProjetFinal/Model/users.php';
    $users = new users();
    // Récupération de la date et l'heure du moment
    $day = date('Y-m-d H:i').':00';
    // -- // Mail prise de sang 
    // Récupération des valeurs indispensable à l'envoie de mail et la récupération de la date et l'heure de l'envoie du mail
    $requestMail = $users->getInfoAndVerification();
    foreach($requestMail as $infoMail) {
        // On compare si c'est le moment d'envoyer le mail
       if($day == $infoMail->verification_date) {
        //Envoie du mail d'information pour rappel
        $recipient = $infoMail->mail;
        $name = $infoMail->lastname;
        $firstname = $infoMail->firstname;
        $subject = BLOODTESTSUBJECT;
        $entete = BLOODTESTHEADING;
        $message = HELLO.' '.$firstname.' '.$name.",\r\n"
        .BLOODTESTMESSAGE."\r\n"
        .BLOODTESTMESSAGETWO;
        mail($recipient, $subject,$message,$entete);
       }
    }
// -- // Mail rendez-vous
    // Récupération du mail et des informations du rendez-vous
    $request = $users->getInfoAndAppointment();
    foreach($request as $informationAppointment) {
        // Récupération du jour du rendez-vous
        $date = $informationAppointment->date_appointment;
        $hourappointment = $informationAppointment->hour_appointment.':00';
        // Récupèration du jour d'avant pour pouvoir envoyer le message la veille
        $dayappointment = date('Y-m-d', strtotime($date.' - 1 DAY'));
        // Comparaison si c'est le moment d'envoyer le mail
       if($day == $dayappointment.' '.$hourappointment) {
        // Envoie du mail d'information pour informer           
        $nameappointment = $informationAppointment->name_appointment;
        $infosappointment = $informationAppointment->additional_informations;
        $recipient = $informationAppointment->mail;
        $name = $informationAppointment->lastname;
        $firstname = $informationAppointment->firstname;
        $subject = APPOINTMENTSUBJECT;
        $entete = APPOINTMENTHEADING;
        $message = HELLO.' '.$firstname.' '.$name.",\r\n"
        .APPOINTMENTMAILMESSAGEONE.'"'.$nameappointment.'"'.APPOINTMENTMAILMESSAGETWO.$hourappointment." !\r\n"
        .APPOINTMENTMAILMESSAGETHREE.'"'.$infosappointment.'"';
        mail($recipient, $subject,$message,$entete);
       }
    }
    ?>
