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
    $day = date('d/m/Y H:i');
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
    
    $requestmailappointment = $bdd->query('SELECT `nom`, `prenom`, `mail`, `date_rendez_vous`,`heure_rendez_vous`,`nom_rendez_vous`,`infos_complementaire` FROM `utilisateurs` INNER JOIN `rendez_vous` ON `rendez_vous`.`id_utilisateur` = `utilisateurs`.`id`');
    while($request = $requestmailappointment->fetch()) {
        // Récupération du jour du rendez-vous
        $date = $request['date_rendez_vous'];
        $hourappointment = $request['heure_rendez_vous'];
        // Modification du rendez_vous fait
        if($day == $date.' '.$hourappointment) {
          $requestappoitmentup = $bdd->prepare('UPDATE `rendez_vous` SET `rendez_vous_fait` = :up WHERE `date_rendez_vous` = :day AND `heure_rendez_vous` = :hour');
          $requestappoitmentup->bindValue('up','1',PDO::PARAM_INT);
          $requestappoitmentup->bindValue('day',$date,PDO::PARAM_STR);
          $requestappoitmentup->bindValue('hour',$hourappointment,PDO::PARAM_STR);
          $requestappoitmentup->execute();
        }
        // On créer un format de date pour le modifier dans le format Y-m-d
        $dt = DateTime::createFromFormat('d/m/Y', $date);
        $date =  $dt->format('Y-m-d');
        // Je récupère le jour d'avant pour pouvoir envoyer le message la veille
        $dayappointment = date('d-m-Y', strtotime($date.' - 1 DAY'));
        // On remet dans l'ancien format
        $dt = DateTime::createFromFormat('d-m-Y', $dayappointment);
        $dayappointment =  $dt->format('d/m/Y');
        // On compare si c'est le moment d'envoyer le mail
       if($day == $dayappointment.' '.$hourappointment) {
        //Envoie du mail d'information pour vérification           
        $nameappointment = $request['nom_rendez_vous'];
        $infosappointment = $request['infos_complementaire'];
        $recipient = $request['mail'];
        $name = $request['nom'];
        $firstname = $request['prenom'];
        $subject = '[IMPORTANT] Rendez-vous du lendemain';
        $entete = 'From: inscriptiondiavk@gmail.com';
        $message = 'Bonjour '.$firstname.' '.$name.",\r\n"
        .'Votre rendez-vous "'.$nameappointment.'" est demain à '.$hourappointment." !\r\n"
        .'Les informations complémentaire que vous avez écrites sont '.$infosappointment;
        mail($recipient, $subject,$message,$entete);
       }
    }
    ?>
      </body>
    </html>

