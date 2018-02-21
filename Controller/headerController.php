<?php
    include_once 'Model/dataBase.php';
    include_once 'Model/users.php';
    include_once 'Model/follow.php'; 
    $users = new users();
    $follow = new follow();
    $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $follow->id = $id = $userId['id'];
    $user = $_SESSION['user'];
    $role = $_SESSION['role'];
    $pathology = $_SESSION['pathology'];
    $requestfollow = $follow->getFollowQuest();
    $nbquest = count($requestfollow);

