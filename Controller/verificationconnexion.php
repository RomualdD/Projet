<?php
session_start();
    if(isset($_COOKIE['user'])) {
        $_SESSION['user'] = $_COOKIE['user']; 
        $_SESSION['role'] = $_COOKIE['role'];
        $_SESSION['pathology'] = $_COOKIE['pathology'];
        $_SESSION['firstname'] = $_COOKIE['firstname'];
        $_SESSION['name'] = $_COOKIE['name'];  
    }
if(!isset($_SESSION['user'])) {
    $errorConnexion = 'Vous n\'êtes pas connecté pour accéder au contenu';
}
    include 'View/header.php';
    