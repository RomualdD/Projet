<?php
session_start();
if(!isset($_SESSION['user'])) {
    include '../View/header.php';
    echo 'Vous n\'êtes pas connecté pour accéder au contenu';
}
else {
    include '../View/header1.php';
}
    