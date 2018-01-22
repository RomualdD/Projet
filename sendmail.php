<!DOCTYPE html PUBLIC>
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Envoie de mail automatique</title>
      </head>
      <body>
        <?php 
    // L'utilisation de cette page est strictement réservé au crontab (tâche automatique ! )    
    include 'bdd.php';
    // Récupération de la date et l'heure du moment
    $day = date('Y-m-d H:i').':00';
    // Récupération des valeurs indispensable à l'envoie de mail et la récupération de la date et l'heure de l'envoie du mail
    $requestmail = $bdd->query('SELECT `nom`, `prenom`, `mail`, `date_verification` FROM `utilisateurs` INNER JOIN `verification` ON `id_utilisateur` = id');
    // On recherche dans toute table
    while($request = $requestmail->fetch()) {
        // On compare si c'est le moment d'envoyer le mail
       if($day == $request['date_verification']) {
        //Envoie du mail d'information pour vérification
        $recipient = $request['mail'];
        $name = $request['nom'];
        $firstname = $request['prenom'];
        $subject = '[IMPORTANT] Prise de sang à faire';
        $entete = 'From: inscriptiondiavk@gmail.com';
        $message = 'Bonjour '.$firstname.' '.$name.",\r\n"
        .'Il est l\'heure de faire votre vérification !'."\r\n"
        .'N\'oubliez pas de mettre le résultat dans le tableau afin de garder en mémoire votre résultat';
        mail($recipient, $subject,$message,$entete);
       }
    }
    
    $requestmailappointment = $bdd->query('SELECT `nom`, `prenom`, `mail`, `date_rendez_vous`,`heure_rendez_vous`,`nom_rendez_vous`,`infos_complementaire` FROM `utilisateurs` LEFT JOIN `rendez_vous` ON `rendez_vous`.`id_utilisateur` = `utilisateurs`.`id`');
    $request = $requestmailappointment->fetchAll();
    foreach($request as $informationAppointment) {
        // Récupération du jour du rendez-vous
        $date = $informationAppointment['date_rendez_vous'];
        $hourappointment = $informationAppointment['heure_rendez_vous'].':00';
        // Je récupère le jour d'avant pour pouvoir envoyer le message la veille
        $dayappointment = date('Y-m-d', strtotime($date.' - 1 DAY'));
        // On compare si c'est le moment d'envoyer le mail
       if($day == $dayappointment.' '.$hourappointment) {
        //Envoie du mail d'information pour vérification           
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
      </body>
    </html>

