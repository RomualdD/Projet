<?php
include 'bdd.php';
// -- // Suppression du rendez-vous
    if(!empty($_POST['name']) && !empty($_POST['hour']) && !empty($_POST['infos']) && (!empty($_POST['suppr']))) {
        // Récupération des données du rendez-vous
        $nameappointment = $_POST['name'];
        $hourappointment = $_POST['hour'];
        $infosappointment = $_POST['infos'];
        // Requête pour supprimer le rendez-vous
        $requestsupprappointment = $db->prepare('DELETE FROM `rendez_vous` WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos');
        $requestsupprappointment->bindValue('name',$nameappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('hour',$hourappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('infos',$infosappointment,PDO::PARAM_STR);
        $requestsupprappointment->execute();
        // Permet de dire à l'AJAX que l'opération est effectué
        echo 'Success';
    }
    else {
        echo 'Failed';
    }    
?>