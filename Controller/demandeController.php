<?php
    $follow = new follow();
    $user = new users();
    $follow->id = $id;
// -- //Acceptation ou Refus demande   
    $successAddMsg = '';
    $successDeniedMsg = '';
    if(isset($_POST['username']) && ($_POST['action'] == 'add') ) {
        $follow->follow_from = (int) $_POST['username'];
        $follow->updateAddFollow();
        if($role == 1) {
            $successAddMsg = 'Votre médecin vous suit désormais !';
        }
        else {
            $successAddMsg = 'Votre patient vous suit désormais !';
        }
    }
    elseif(isset($_POST['username']) && (($_POST['action']) == 'delete')) {
        $follow->follow_from = (int) $_POST['username'];
        $follow->deleteFollow();
        $successDeniedMsg = 'Refus enregistré';
    }
// -- // Recherche demande ami    
    $requestFollow = $follow->getFollowQuest();



