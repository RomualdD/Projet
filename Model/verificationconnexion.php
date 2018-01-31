<?php
session_start();
if(!isset($_SESSION['user'])) {
    include '../View/header.php';
    echo 'Vous n\'êtes pas connecté pour accéder au contenu';
}
else {    
    include 'dataBase.php';
    include 'users.php';
    $users = new users();
    $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $id = $userId['id'];
    $user = $_SESSION['user'];
    $role = $_SESSION['role'];
    $pathology = $_SESSION['pathology'];
    include '../View/header1.php';
}
    