<?php
    $follow = new follow();
    $user = new users();
    $follow->follow_to = $id;
// -- //Acceptation ou Refus demande   
    $successAddMsg = '';
    $successDeniedMsg = '';
    if(isset($_POST['username']) && ($_POST['action'] == 'add') ) {
        $follow->follow_from = (int)$_POST['username'];
        $follow->updateAddFollow();
        if($role == 1) {
            $successAddMsg = SUCCESSADDPATIENT;
        }
        else {
            $successAddMsg = SUCCESSADDDOCTOR;
        }
    }
    elseif(isset($_POST['username']) && (($_POST['action']) == 'delete')) {
        $follow->follow_from = (int)$_POST['username'];
        $follow->deleteFollow();
        $successDeniedMsg = REFUSEFOLLOW;
    }
// -- // Recherche demande ami    
    $requestFollow = $follow->getFollowQuest();



