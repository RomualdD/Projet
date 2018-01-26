<?php
// -- // Ajout du résultat 
$successAddMsg = '';
$errorResult = '';
if($pathology == 1 || $pathology == 2) {
    if(isset($_POST['submit'])) {
        // Vérification qu'il y'a bien un taux et qu'il est écrit en chiffre.chiffre ou chiffre
      if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]{2}$#',$_POST['rate']))){
          // Récupération du taux
        $rate= strip_tags($_POST['rate']);
        // Date du jour avec heure
        $date = date('Y-m-d H:i'); 
        // Date du jour
        $dateday = date('Y-m-d');
        // Horraire du jour afin de faire une comparaison
        $hour = date('Hi');
        // Récupération de la date de vérification et des heures demandés
        $searchfuturedate = $db->query('SELECT `id_utilisateur`,`date_verification`, `Heure1`, `Heure2`, `Heure3`, `Heure4` FROM `verification` WHERE `id_utilisateur` = "'.$id.'"');
        $searchfuturedate = $searchfuturedate->fetch();
        $iduser = $searchfuturedate['id_utilisateur'];
        $dateverif = $searchfuturedate['date_verification'];
        $oneclock = $searchfuturedate['Heure1'];
        $twoclock = $searchfuturedate['Heure2'];
        $threeclock = $searchfuturedate['Heure3'];
        $fourclock = $searchfuturedate['Heure4'];  
        // On ne récupère que les chiffres des heures et minutes
        $onehour = substr($oneclock,0,2).substr($oneclock,3,4);
        $twohour = substr($twoclock,0,2).substr($twoclock,3,4);
        $threehour = substr($threeclock,0,2).substr($threeclock,3,4);
        $fourhour = substr($fourclock,0,2).substr($fourclock,3,4);
        // Vérification de quelle date est la prochaine
        if($hour > $onehour && $hour < $twohour) {
            $futurehour = $twoclock;  
            $futuredate = $dateday;
        }
        elseif($hour > $twohour && $hour < $threehour) {
            $futurehour = $threeclock;      
            $futuredate = $dateday;
        }
        elseif($hour > $threehour && $hour < $fourhour) {
            $futurehour = $fourclock;
            $futuredate = $dateday;
        }
        elseif($hour < $onehour) {
                $futurehour = $oneclock;
                $futuredate = $dateday;
        }
        else {   
                $futurehour = $oneclock;
                $tomorrow = time() + (24*60*60); // calcul d'une journée
                $futuredate = date('Y-m-d', $tomorrow); // intégration pour passer au lendemain 
        }
        // Concaténation de la prochaine date avec l'heure correspondante
        $futuredate = $futuredate.' '.$futurehour.':00';
        if(($futuredate != $dateverif) && ($id == $iduser )) {
          // Ajout dans la table suivis pour récupéré ensuite les valeurs  
          $requestadd = $db->prepare('INSERT INTO suivis(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
          $requestadd->bindValue('id',$id,PDO::PARAM_INT);
          $requestadd->bindValue('daydate',$date,PDO::PARAM_STR);
          $requestadd->bindValue('result',$rate,PDO::PARAM_STR);
          $requestadd->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
          $requestadd->execute();
          $successAddMsg = 'Votre résultat a bien était ajouté !';
          // Modification de la prochaine vérifiacation dans la table vérification
          $requestmodif = $db->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
          $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
          $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
          $requestmodif->execute();
        }
        if($futuredate == $dateverif) {
            $requestverifresult = $db->query('SELECT `resultat` FROM `suivis` WHERE `id_utilisateur` = '.$id.' AND `date_prochaine_verif` = "'.$futuredate.'"');
            $verifresult = $requestverifresult->fetch(PDO::FETCH_ASSOC);
            $result = $verifresult['resultat'];
            if($rate != $result) {
                $requestmodif = $db->prepare('UPDATE `suivis` SET `resultat` = :result WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futureverif');
                $requestmodif->bindValue('result',$rate,PDO::PARAM_STR);
                $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
                $requestmodif->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
                $requestmodif->execute();
                $successAddMsg = 'Votre résultat a bien était modifié !';
            }
        }
      }
      else {
            $errorResult = 'Votre résultat ne correspond pas au résultat attendus. Veuillez entrez votre résultat sous le format comme l\'exemple: 1 ou 1.1 ou 1.11';
      }
    }  
}
elseif($pathology == 3) {
    if(isset($_POST['submit'])) {
        if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate']))) {
          $rate=$_POST['rate'];
          $date = date('Y-m-d').' 00:00:00'; // Date du jour
          $nextverif = time() + (21 * 24 * 60 * 60); //On lui demande de calculer la date dans 21jours (3semaines)
          $futuredate = date('Y-m-d', $nextverif); // On récupère la nouvelle date
          $resultdate = $db->query('SELECT `date_du_jour` FROM `suivis` WHERE `id_utilisateur`="'.$id.'"');
          $resultdate = $resultdate->fetchAll();
          $verifDateDay = '';
          foreach($resultdate as $datetime) {
              if($date == $datetime['date_du_jour']) {
                  $verifDateDay = $datetime['date_du_jour'];
              }         
          }
          if($date != $verifDateDay) {
            $requestAddResult = $db->prepare('INSERT INTO `suivis`(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
            $requestAddResult->bindValue('result',$rate,PDO::PARAM_STR);
            $requestAddResult->bindValue('id',$id,PDO::PARAM_INT);
            $requestAddResult->bindValue('daydate',$date,PDO::PARAM_STR);
            $requestAddResult->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
            $requestAddResult->execute();
            $successAddMsg = 'Votre résultat a bien était ajouté !';
          }
          else {
                  $requestverifresult = $db->query('SELECT `resultat` FROM `suivis` WHERE `id_utilisateur` = '.$id.' AND `date_prochaine_verif` = "'.$futuredate.'"');
                  $requestverifresult = $requestverifresult->fetch();
                  $result = $requestverifresult['resultat'];
                  if($rate != $result) {
                      $requestmodif = $db->prepare('UPDATE `suivis` SET `resultat` = :result WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futureverif');
                      $requestmodif->bindValue('result',$rate,PDO::PARAM_STR);
                      $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
                      $requestmodif->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
                      $requestmodif->execute();
                      $successAddMsg = 'Votre résultat a bien était modifié !';
                  }
          }        
          // Recherche de l'heure a laquelle il faudra envoyer le mail
          $searchfuturedate = $db->query('SELECT `Heure1` FROM `verification` WHERE `id_utilisateur` = "'.$id.'"');
          $searchfuturedate = $searchfuturedate->fetch();
          $oneclock = $searchfuturedate['Heure1'];
          $futuredate = $futuredate.' '.$oneclock;
          // Modification de la prochaine vérifiacation dans la table vérification
          $requestmodif = $db->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
          $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
          $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
          $requestmodif->execute();
        }
        else {
            $errorResult = 'Votre résultat ne correspond pas au résultat attendus. Veuillez entrez votre résultat sous le format comme l\'exemple: 1 ou 1.1 ou 1.11';
        }
    }    
}
