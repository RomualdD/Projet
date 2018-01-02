<?php
    include 'bdd.php';
    $day = date('d/m/Y');
    $hour = date('H:i');
    $date = $day.' '.$hour;
    echo $date;
    $requestmail = $bdd->prepare('SELECT id_utilisateur AS nom, prenom, mail FROM utilisateurs LEFT JOIN verification ON id = id_utilisateur WHERE verification = :day AND Heure1 = :heure OR Heure2 = :heure OR Heure3 = :heure OR Heure4 = :heure');
    $requestmail->bindValue('day', $day, PDO::PARAM_STR);
    $requestmail->bindValue('heure',$hour);
    $requestmail->execute();

    while($request = $requestmail->fetch(PDO::FETCH_ASSOC)) {
        if($date == $requestmail['date_verification'].' '.$requestmail['Heure1'] || $date == $requestmail['date_verification'].' '.$requestmail['Heure2'] || $date == $requestmail['date_verification'].' '.$requestmail['Heure3'] || $date == $requestmail['date_verification'].' '.$requestmail['Heure4']) {
                //Envoie du mail d'information pour vérification
                 $recipient = $requestmail['mail'];
                 $name = $requestmail['nom'];
                 $firstname = $requestmail['prenom'];
                 $subject = '[IMPORTANT] Prise de sang à faire';
                 $entete = "From: inscriptiondiavk@gmail.com";
                 $message = 'Bonjour '.$firstname.' '.$name.','
                         . 'Il est l\'heure de faire votre vérification ! '
                         . 'N\'oubliez pas de mettre le résultat dans le tableau afin de garder en mémoire votre résultat';
                 mail($recipient, $subject,$message,$entete);
        }
    }
?>