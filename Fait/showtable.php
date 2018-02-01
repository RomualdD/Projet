<?php
// -- // Recherche a mettre dans le tableau
if($pathology == 1 || $pathology == 2) {
    // Pagination
    $total = $db->query('SELECT COUNT(*) AS total FROM `suivis` WHERE `id_utilisateur` = '.$id);
    $total = $total->fetch();
    $total = $total['total'];
    $nbresultat = 3;
    // Arrondit au nombre supérieur
    $nbPagesForResult = ceil($total/$nbresultat);
    if(isset($_GET['page'])) {
        $actuallyPage = intval($_GET['page']);
        if($actuallyPage > $nbPagesForResult) { // Si page actuelle est supérieur à nombres de pages
            $actuallyPage = $nbPagesForResult;
        }
        elseif ($actuallyPage==0) {
           $actuallyPage = 1; 
        }
    }
    else {
       $actuallyPage = 1; // page actuelle 1
    }
    $first = ($actuallyPage-1)*$nbresultat; // Calcule la première entrée
   // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant
   $requestbdd = $db->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'"ORDER BY `id` DESC LIMIT '.$first.', '.$nbPagesForResult);
   $requestarray = $requestbdd->fetchAll(PDO::FETCH_ASSOC); //PDO FETCH_ASSOC empêche d'avoir deux fois la même valeur  
}
elseif($pathology == 3) {
    // Pagination
    $total = $db->query('SELECT COUNT(*) AS total FROM `suivis` WHERE `id_utilisateur` = '.$id);
    $total = $total->fetch();
    $total = $total['total'];
    $nbresultat = 3;
    // Arrondit au nombre supérieur
    $nbPagesForResult = ceil($total/$nbresultat);
    if(isset($_GET['page'])) {
        $actuallyPage = intval($_GET['page']);
        if($actuallyPage > $nbPagesForResult) { // Si page actuelle est supérieur à nombres de pages
            $actuallyPage = $nbPagesForResult;
        }
        elseif ($actuallyPage==0) {
           $actuallyPage = 1; 
        }
    }
    else {
       $actuallyPage = 1; // page actuelle 1
    }
    $first = ($actuallyPage-1)*$nbresultat; // Calcule la première entrée
    // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant
    $requestbdd = $db->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y") AS `date_prochaine_verif` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'"ORDER BY `id` DESC limit '.$first.', '.$nbPagesForResult);
    $requestarray = $requestbdd->fetchAll(PDO::FETCH_ASSOC); //PDO FETCH_ASSOC empêche d'avoir deux fois la même valeur  
}
