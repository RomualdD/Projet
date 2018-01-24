<?php
// -- // Recherche demande ami    
    $requestfollow = $bdd->query('SELECT follow_from, follow_date,nom,prenom,nom_utilisateur FROM follow LEFT JOIN utilisateurs ON id=follow_from WHERE follow_to = '.$id.' AND follow_confirm = "0"');
    $reqfollow = $requestfollow->fetchAll();

// -- //Acceptation ou Refus demande   
    $successAddMsg = '';
    $successDeniedMsg = '';
    if(isset($_POST['username']) && ($_POST['action'] == 'add') ) {
        $member = (int) $_POST['username'];
        $follow = $bdd->prepare('UPDATE follow SET follow_confirm = :confirm WHERE follow_from = :member AND follow_to = :id');
        $follow->bindValue(':confirm','1',PDO::PARAM_STR);
        $follow->bindValue(':member',$member, PDO::PARAM_INT);
        $follow->bindValue(':id', $id, PDO::PARAM_INT);
        $follow->execute();
        if($role == 1) {
            $successAddMsg = 'Votre médecin vous suit désormais !';
        }
        else {
            $successAddMsg = 'Votre patient vous suit désormais !';
        }
     }
    elseif(isset($_POST['username']) && (($_POST['action']) == 'delete')) {
        $member = (int) $_POST['username'];
        $requestrefuse = $bdd->prepare('DELETE FROM follow WHERE follow_from = :member AND follow_to = :id');
        $requestrefuse->bindValue(':member',$member,PDO::PARAM_INT);
        $requestrefuse->bindValue(':id',$id,PDO::PARAM_INT);
        $requestrefuse->execute();
        $successDeniedMsg = 'Refus enregistré';
    }
