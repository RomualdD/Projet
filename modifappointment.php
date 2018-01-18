<?php
include 'bdd.php';
    $error = 0; 
if(!empty($_POST['dayappointment']) || !empty($_POST['nameappointment']) || !empty($_POST['hourappointment']) || !empty($_POST['infosappointment'])) {  
    $nameappointment = $_POST['name'];
       $hourappointment = $_POST['hour'];
       $infosappointment = $_POST['infos'];   
    if(!empty($_POST['dayappointment'])) {
        if(preg_match('#^[0-9]{2}[/]{1}[0]{1}[1-9]{1}[/]{1}[0-9]{4}$#', $_POST['dayappointment'])){                     
            $newdayappointment =  $_POST['dayappointment'];
        }
        else {
            echo 'FailedDay';
            $error++;
        }
   }
   else {
       $requestdate = $bdd->query('SELECT `date_rendez_vous` FROM `rendez_vous` WHERE `nom_rendez_vous` = "'.$nameappointment.'" AND `heure_rendez_vous` = "'.$hourappointment.'" AND `infos_complementaire` = "'.$infosappointment.'"');
          $requestdate=$requestdate->fetch();
          $newdayappointment = $requestdate['date_rendez_vous'];
   }
   if(!empty($_POST['nameappointment'])) {
        if(!preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['nameappointment'])) {
           $newnameappointment = $_POST['nameappointment'];        
        }
        else {
            echo 'FailedName';
            $error++;
        }
   }
   else {
       $newnameappointment = $nameappointment;
   }  
   if(!empty($_POST['hourappointment'])) {
       if(preg_match('#^[0-1]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment']) || preg_match('#^[2]{1}[0-3]{1}[:]{1}[0-5]{1}[0-9]{1}$#', $_POST['hourappointment'])) {
            $newhourappointment = $_POST['hourappointment'];
        }
        else {
            echo 'FailedHour'; 
            $error++;
        }
   }
   else {
       $newhourappointment = $hourappointment;
   } 
   if(!empty($_POST['infosappointment'])) {
        if(!preg_match('#^[a-zA-Z ÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'!,;-]{2,}$#i', $_POST['infosappointment'])) {
           $newinfoappointment = $_POST['nameappointment'];        
        }
        else {
            echo 'FailedInfos';
            $error++;
        }
   }
   else {
       $newinfoappointment = $infosappointment;
   }
    if($error == 0) {
       $requestmodifappointment = $bdd->prepare('UPDATE `rendez_vous` SET `date_rendez_vous` = :newday, `nom_rendez_vous` = :newname, `heure_rendez_vous` = :newhour, `infos_complementaire` = :newinfos  WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos');
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

}
else {
    echo 'Failed';
}    
?>