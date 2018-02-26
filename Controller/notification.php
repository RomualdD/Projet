<?php
if(isset($_POST)) {
    session_start();
    if(isset($_SESSION['user'])) {
        include_once '../Model/dataBase.php';
        include_once '../Model/users.php';
        include_once '../Model/follow.php';
        $users = new users();
        $follow = new follow();
        $users->username = $_SESSION['user'];
        $userId = $users->getUserId();
        $follow->id = $userId['id'];    
        $requestfollow = $follow->getnbFollowQuest();
        $nbquest = $requestfollow['nbFollow'];
        if($nbquest > 0 && $_POST['info'] != $nbquest && $_POST['info'] > $nbquest) {
            echo $nbquest;
        }
        else{
            echo 'Failed';
        }        
    }
    else{
        echo 'Failed';
    }  
}

