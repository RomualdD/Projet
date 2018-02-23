<?php
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/follow.php'; 
    $users = new users();
    $follow = new follow();
    $user = $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $follow->id = $id = $userId['id'];
    $role = $_SESSION['role'];
    $pathology = $_SESSION['pathology'];
    $requestfollow = $follow->getnbFollowQuest();
    $nbquest = $requestfollow['nbFollow'];

