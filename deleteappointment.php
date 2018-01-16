<?php
include 'bdd.php';
if(!empty($_POST['name']) && !empty($_POST['hour']) && !empty($_POST['infos'])) {
       $nameappointment = $_POST['name'];
       $hourappointment = $_POST['hour'];
       $infosappointment = $_POST['infos'];
       $requestsupprappointment = $bdd->prepare('DELETE FROM `rendez_vous` WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos');
          $requestsupprappointment->bindValue('name',$name,PDO::PARAM_STR);
          $requestsupprappointment->bindValue('hour',$hourappointment,PDO::PARAM_STR);
          $requestsupprappointment->bindValue('infos',$infosappointment,PDO::PARAM_STR);
          $requestsupprappointment->execute(); 
            echo 'Success';
}
else {
    echo 'Failed';
}    
?>