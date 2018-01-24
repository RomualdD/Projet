<?php
    $dataPoints= array();
    $nbresult = 0;
if($pathology == 1 || $pathology == 2) {
    // Pagination
    $totalgraphic = $bdd->query('SELECT COUNT(*) AS total FROM `suivis` WHERE `id_utilisateur` = '.$id);
    $totalgraphic = $totalgraphic->fetch();
    $totalgraphic = $totalgraphic['total'];
    $nbResultatGraphic = 4;
    // Arrondit au nombre supérieur
    $nbPagesForResultGraphic = ceil($total/$nbResultatGraphic);
    $actuallyPageGraphic = $nbPagesForResultGraphic-1;
    $firstGraphic = ($actuallyPageGraphic-1)*$nbResultatGraphic; // Calcule la première entrée
    
    // Récupération de la date du jour avec le résultat limité a 28 résultats (une semaine)
    $requestSearchGraphic = $bdd->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_du_jour`,`resultat` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'" ORDER BY `id` LIMIT '.$firstGraphic.', '.$nbPagesForResultGraphic);

}
elseif ($pathology == 3) {
    $requestSearchGraphic = $bdd->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y"),`resultat` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'" ORDER BY `id` LIMIT 28');

}