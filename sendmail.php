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
    echo $day;
    // Récupération des valeurs indispensable à l'envoie de mail et la récupération de la date et l'heure de l'envoie du mail
    $requestmail = $bdd->query('SELECT nom, prenom, mail, date_verification FROM utilisateurs INNER JOIN verification ON id_utilisateur = id');
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
        $message = 'Bonjour '.$firstname.' '.$name.',
                Il est l\'heure de faire votre vérification !
                N\'oubliez pas de mettre le résultat dans le tableau afin de garder en mémoire votre résultat';
        mail($recipient, $subject,$message,$entete);
       }
    }
    ?>
      </body>
    </html>

