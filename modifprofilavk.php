<?php
// -- // Profil Avk
if($pathology == 3) {
        $succesAddmsg='';
        $errorDateMsg='';
        $errorAddOneClock='';
    if(isset($_POST['valid'])) {
        if(isset($_POST['time']) && (isset($_POST['notification'])) && (isset($_POST['clock']))) {
                if($_POST['notification'] == 'SMS') {
                    $notification = 0;
                }
                else {
                    $notification = 1;
                }
                if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['clockone'])) {
                    $oneclock = $_POST['clockone'];    
                }
                else {
                    $errorAddOneClock = 'Le format demandé est hh:mm';
                    $error++;
                }
                if(preg_match('#^[0-9]{2}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}[ ]{1}[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['time'])){
                    $time = $_POST['time'];
                    //On récupère la date
                    $verif = explode(' ', $time);
                    $firstverif = $verif['0'];
                    $hourverif = $verif['1'];
                    // On met dans le format date SQ
                    $dt = DateTime::createFromFormat('d/m/Y', $firstverif);
                    $firstverif =  $dt->format('Y-m-d');
                    $time = $firstverif.' '.$hourverif;
                }
                else {
                    $errorDateMsg = 'Le format demandé est jj/mm/YYYY hh:mm';
                    $error++;
                }
                if($error == 0) {
                    $requestverif = $db->prepare('INSERT INTO `verification`(`id_utilisateur`, `Heure1`, `notification`, `date_verification`) VALUES (:id, :hour1, :notification, :dateverification)');
                    $requestverif->execute(array(
                        'id' => $id,
                        'hour1' => $oneclock,
                        'notification' => $notification,
                        'dateverification' => $time
                    ));
                    $succesAddmsg = 'Les modifications sont prises en compte !';
                }
        }
        else {
            echo 'Les champs ne sont pas tous remplis !';
        }
    }
}
