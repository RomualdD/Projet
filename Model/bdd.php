<?php
try {
$db = new PDO('mysql:host=localhost;dbname=diavk;charset=utf8', 'project', 'projetdiavk');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (Exception $ex) {
  die('Erreur : '.$ex->getMessage()) ;
}