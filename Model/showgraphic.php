<?php
// -- // Recherche des résultats à mettre dans le graphique
    $dataPoints= array();
    $nbresult = 0;
    
 // Possibilité de mettre 2 dates pour voir son suivi   
if(!empty($_POST['date1'])&&(!empty($_POST['date2']))) {
  $dateFirst = $_POST['date1'];
  $dateSecond = $_POST['date2'];
  $dateSecond = date('Y-m-d', strtotime($dateSecond.' +1 DAY'));
}
else { 
    if ($pathology == 3) {
        $dateFirst = date('Y-m-d', strtotime(date('Y-m-d').' -3 MONTH'));    
    }
    else {
        $dateFirst = date('Y-m-d', strtotime(date('Y-m-d').' -1 WEEK'));
    }
          $dateSecond = date('Y-m-d', strtotime(date('Y-m-d').' +1 DAY'));    
}
    
if($pathology == 1 || $pathology == 2) {
    $requestSearchGraphic = $db->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_now`,`resultat` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'" AND `date_du_jour` BETWEEN "'.$dateFirst.'" AND "'.$dateSecond.'" ORDER BY `date_du_jour`');
}
elseif ($pathology == 3) {
    $requestSearchGraphic = $db->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y") AS `date_now`,`resultat` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'" AND `date_du_jour` BETWEEN "'.$dateFirst.'" AND "'.$dateSecond.'" ORDER BY `date_du_jour` LIMIT 28');
}