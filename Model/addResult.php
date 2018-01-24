<?php
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
        $searchfuturedate = $bdd->query('SELECT `id_utilisateur`,`date_verification`, `Heure1`, `Heure2`, `Heure3`, `Heure4` FROM `verification` WHERE `id_utilisateur` = "'.$id.'"');
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
          $requestadd = $bdd->prepare('INSERT INTO suivis(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
          $requestadd->execute(array(
          'id' => $id,
          'daydate' => $date,
          'result' => $rate,
          'futureverif' => $futuredate
          ));
          // Modification de la prochaine vérifiacation dans la table vérification
          $requestmodif = $bdd->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
          $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
          $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
          $requestmodif->execute();
        }
        if($futuredate == $dateverif) {
            $requestverifresult = $bdd->query('SELECT `resultat` FROM `suivis` WHERE `id_utilisateur` = '.$id.' AND `date_prochaine_verif` = "'.$futuredate.'"');
            $verifresult = $requestverifresult->fetch(PDO::FETCH_ASSOC);
            $result = $verifresult['resultat'];
            if($rate != $result) {
                $requestmodif = $bdd->prepare('UPDATE `suivis` SET `resultat` = :result WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futureverif');
                $requestmodif->bindValue('result',$rate,PDO::PARAM_STR);
                $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
                $requestmodif->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
                $requestmodif->execute();
            }
        }
      }
    }    
}
elseif($pathology == 3) {
    if(isset($_POST['submit'])) {
        if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate']))){
          $rate=$_POST['rate'];
          $date = date('Y-m-d').' 00:00:00'; // Date du jour
          $nextverif = time() + (21 * 24 * 60 * 60); //On lui demande de calculer la date dans 21jours (3semaines)
          $futuredate = date('Y-m-d', $nextverif); // On récupère la nouvelle date
          $resultdate = $bdd->query('SELECT `date_du_jour` FROM `suivis` WHERE `id_utilisateur`="'.$id.'"');
          $resultdate = $resultdate->fetch();
          if($date != $resultdate['date_du_jour']) {
            $req = $bdd->prepare('INSERT INTO `suivis`(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
            $req->execute(array(
            'id' => $id,
            'daydate' => $date,
            'result' => $rate,
            'futureverif' => $futuredate
            ));
          }
          else {
                  $requestverifresult = $bdd->query('SELECT `resultat` FROM `suivis` WHERE `id_utilisateur` = '.$id.' AND `date_prochaine_verif` = "'.$futuredate.'"');
                  $requestverifresult = $requestverifresult->fetch();
                  $result = $requestverifresult['resultat'];
                  if($rate != $result) {
                      $requestmodif = $bdd->prepare('UPDATE `suivis` SET `resultat` = :result WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futureverif');
                      $requestmodif->bindValue('result',$rate,PDO::PARAM_STR);
                      $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
                      $requestmodif->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
                      $requestmodif->execute();
                  }
          }        
          // Recherche de l'heure a laquelle il faudra envoyer le mail
          $searchfuturedate = $bdd->query('SELECT `Heure1` FROM `verification` WHERE `id_utilisateur` = "'.$id.'"');
          $searchfuturedate = $searchfuturedate->fetch();
          $bdd = NULL;
          $oneclock = $searchfuturedate['Heure1'];
          $futuredate = $futuredate.' '.$oneclock;
          // Modification de la prochaine vérifiacation dans la table vérification
          $requestmodif = $bdd->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
          $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
          $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
          $requestmodif->execute();
        }
    }    
}
