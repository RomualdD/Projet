<?php
    // -- // Recherche patient 
    $requestfollow = $db->prepare('SELECT DISTINCT `follow_from` = :id OR `follow_to` = :id AS `follow_id`, `nom`, `prenom`, `nom_utilisateur`,`role` FROM `follow` LEFT JOIN `utilisateurs` ON `id` = `follow_from` OR `id` = `follow_to` WHERE (`follow_from` = :id OR `follow_to` = :id) AND `follow_confirm` = :confirm AND `role` = 1 ORDER BY `nom`');    
    $requestfollow->bindValue('confirm','1', PDO::PARAM_INT);
    $requestfollow->bindValue('id',$id, PDO::PARAM_INT);
    $requestfollow->execute();
    $follow = $requestfollow->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($_POST['patient'])) {
        // -- // Tableau
        $patient = $_POST['patient'];
        $request = $db->query('SELECT `id` FROM `utilisateurs` WHERE `nom_utilisateur` = "'.$patient.'"');
        $request = $request->fetch(); 
        $idpatient = $request['id'];
        // Possibilité de mettre 2 dates pour voir son suivi   
        if(!empty($_POST['date1'])&&(!empty($_POST['date2']))) {
          $dateFirst = $_POST['date1'];
          $dateSecond = $_POST['date2'];
          $dateSecond = date('Y-m-d', strtotime($dateSecond.' +1 DAY'));
          $requestsearcharray = $db->prepare('SELECT DISTINCT `date_du_jour`,DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_day`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `nom_utilisateur` = :user AND `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm AND `date_du_jour` BETWEEN "'.$dateFirst.'" AND "'.$dateSecond.'" ORDER BY `date_du_jour` DESC');
          $requestsearch = $db->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS date_du_jour, `resultat` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm AND `date_du_jour` BETWEEN "'.$dateFirst.'" AND "'.$dateSecond.'" ');  
        }
        else {
          $dateFirst = date('Y-m-d', strtotime(date('Y-m-d').' -1 WEEK')); 
          $dateSecond = date('Y-m-d', strtotime(date('Y-m-d').' +1 DAY'));
          $requestsearcharray = $db->prepare('SELECT DISTINCT `date_du_jour`,DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_day`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `nom_utilisateur` = :user AND `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm ORDER BY `date_du_jour` DESC');
          $requestsearch = $db->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS date_du_jour, `resultat` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm');
        }

        $requestsearcharray->bindValue(':idpatient',$idpatient, PDO::PARAM_INT); 
        $requestsearcharray->bindValue(':id',$id, PDO::PARAM_INT);
        $requestsearcharray->bindValue(':confirm','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue(':role','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue(':user',$patient, PDO::PARAM_STR);
        $requestsearcharray->execute();
        // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant
        $requestarray = $requestsearcharray->fetchAll(PDO::FETCH_ASSOC);
        
        // -- // Graphique       
        $dataPoints= array();
        $nbresult = 0;
        $requestsearch->bindValue(':id',$id, PDO::PARAM_INT);
        $requestsearch->bindValue(':confirm','1', PDO::PARAM_STR);
        $requestsearch->bindValue(':role','1', PDO::PARAM_STR);
        $requestsearch->bindValue(':idpatient',$idpatient, PDO::PARAM_STR);
        $requestsearch->execute();
        $db = NULL;
    } 
?>
