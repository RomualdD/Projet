<?php
    include_once 'configuration.php';
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/follow.php';
    // si il n'y a pas de session alors on fait un session start
    if(session_id() == '') {
        session_start(); 
    } 
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    switch ($lang) {
        case 'fr':
        case 'fr-fr':
            include_once 'assets/lang/FR_FR.php';
        break;
        case 'en':
        case 'en-en':
            include_once 'assets/lang/EN_EN.php';
        break;
        default:
            include_once 'assets/lang/EN_EN.php';
        break;
    }
    if(isset($_COOKIE['user'])) {
       $_SESSION['user'] = $_COOKIE['user']; 
       $_SESSION['role'] = $_COOKIE['role'];
       $_SESSION['pathology'] = $_COOKIE['pathology'];
       $_SESSION['firstname'] = $_COOKIE['firstname'];
       $_SESSION['name'] = $_COOKIE['name'];
    }
    if(!isset($_SESSION['user'])) {
            $errorConnexion = NOTCONNECT;
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

