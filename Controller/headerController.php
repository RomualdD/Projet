<?php
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/follow.php';
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
    else {
        $users = new users();
        $follows = new follow();
        $user = $users->username = $_SESSION['user'];
        $userId = $users->getUserId();
        $follows->id = $id = $userId->id;
        $role = $_SESSION['role'];
        $pathology = $_SESSION['pathology'];
        $requestfollow = $follows->getnbFollowQuest();
        $nbquest = $requestfollow->nbFollow; 
    }


