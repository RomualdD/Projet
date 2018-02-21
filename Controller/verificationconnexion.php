<?php
session_start();
$nbquest = 4;
if(!isset($_SESSION['user'])) {
    $errorConnexion = 'Vous n\'êtes pas connecté pour accéder au contenu';
}
    include 'View/header.php';
    