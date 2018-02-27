<?php
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/follow.php'; 
    $users = new users();
    $follows = new follow();
    $user = $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $follows->id = $id = $userId['id'];
    $role = $_SESSION['role'];
    $pathology = $_SESSION['pathology'];
    $requestfollow = $follows->getnbFollowQuest();
    $nbquest = $requestfollow['nbFollow'];

