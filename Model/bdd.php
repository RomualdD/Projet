<?php
try {
$bdd = new PDO('mysql:host=localhost;dbname=diavk;charset=utf8', 'project', 'projetdiavk');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (Exception $ex) {
  die('Erreur : '.$ex->getMessage()) ;
}