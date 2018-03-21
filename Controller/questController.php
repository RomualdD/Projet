<?php
    $follow = new follow();
    $user = new users();
    $follow->to = $id;
// -- //Acceptation ou Refus demande   
    $successAddMsg = '';
    $successDeniedMsg = '';
    if(isset($_POST['username']) && ($_POST['action'] == 'add') ) {
        $follow->from = (int)$_POST['username'];
        $follow->updateAddFollow();
        if($role == 1) {
            $successAddMsg = SUCCESSADDPATIENT;
        }
        else {
            $successAddMsg = SUCCESSADDDOCTOR;
        }
    }
    elseif(isset($_POST['username']) && (($_POST['action']) == 'delete')) {
        $follow->from = (int)$_POST['username'];
        $follow->deleteFollow();
        $successDeniedMsg = REFUSEFOLLOW;
    }
// -- // Recherche demande ami    
    $requestFollow = $follow->getFollowQuest();



