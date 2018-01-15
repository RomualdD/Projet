<?php
include 'bdd.php';
if(!empty($_POST['dayappointment']) || !empty($_POST['nameappointment']) || !empty($_POST['hourappointment']) || !empty($_POST['infosappointment'])) {
       $nameappointment = $_POST['name'];
       $hourappointment = $_POST['hour'];
       $infosappointment = $_POST['infos'];   
    if(!empty($_POST['dayappointment'])) {
        $newdayappointment =  $_POST['dayappointment'];
   }
   else {
       $requestdate = $bdd->query('SELECT date_rendez_vous FROM rendez_vous WHERE nom_rendez_vous = "'.$nameappointment.'" AND heure_rendez_vous = "'.$hourappointment.'" AND infos_complementaire = "'.$infosappointment.'"');
          $requestdate=$requestdate->fetch();
          $newdayappointment = $requestdate['date_rendez_vous'];
   }
   if(!empty($_POST['nameappointment'])) {
       $newnameappointment = $_POST['nameappointment'];
   }
   else {
       $newnameappointment = $nameappointment;
   }  
   if(!empty($_POST['hourappointment'])) {
       $newhourappointment = $_POST['hourappointment'];
   }
   else {
       $newhourappointment = $hourappointment;
   } 
   if(!empty($_POST['infosappointment'])) {
       $newinfoappointment = $_POST['infosappointment'];
   }
   else {
       $newinfoappointment = $infosappointment;
   }
       $requestmodifappointment = $bdd->prepare('UPDATE rendez_vous SET date_rendez_vous = :newday, nom_rendez_vous = :newname, heure_rendez_vous = :newhour, infos_complementaire = :newinfos  WHERE nom_rendez_vous = :name AND heure_rendez_vous = :hour AND infos_complementaire = :infos');
          $requestmodifappointment->bindValue(':newday',$newdayappointment, PDO::PARAM_STR);
          $requestmodifappointment->bindValue(':newname',$newnameappointment,PDO::PARAM_STR);
          $requestmodifappointment->bindValue(':newhour',$newhourappointment,PDO::PARAM_STR);
          $requestmodifappointment->bindValue(':newinfos',$newinfoappointment,PDO::PARAM_STR);
          $requestmodifappointment->bindValue(':name',$nameappointment,PDO::PARAM_STR);
          $requestmodifappointment->bindValue(':hour',$hourappointment,PDO::PARAM_STR);
          $requestmodifappointment->bindValue(':infos',$infosappointment,PDO::PARAM_STR);
          $requestmodifappointment->execute(); 
            echo 'Success';
}
else {
    echo 'Failed';
}    
?>