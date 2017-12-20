<?php

$bdd = new PDO('mysql:host=localhost;dbname=diavk;charset=utf8', 'root', 'pfdvv1996');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*$date = date('d/m/Y');
$verif = $bdd->query('SELECT id FROM suivis WHERE date_prochaine_verif = "'.$date.'"');
$verif = $verif->fetch();
foreach($verif as $element)
 {
   $sendmail = $bdd->query('SELECT nom, prénom, mail, phone FROM utilisateur WHERE id = "'.$element.'"');
 }
*/
