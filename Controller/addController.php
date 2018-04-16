<?php
    $user = new users();
    $follow = new follow();
    $user->id = $id;
// -- // On cherche le médecin ou le patient
    if(isset($_POST['name'])) {
        $user->name = $_POST['name'];
        $user->role = $_SESSION['role']; // on cherche le role pour chercher si il faut trouver les patients ou les médecins
        if($user->role == 2) {
            $requestresearch = $user->getDoctorUserByName();
        }
        else {
            $requestresearch = $user->getPatientUserByName();
        }
    }
    else {
// -- // Ajout du patient + vérification si on le suit déjà   
        if(isset($_POST['username'])) {
            $follow->from = $id;
            $error = 0;
            $user->username = $_POST['username'];
            $idfollow = $user->getUserId();
            if($idfollow == TRUE) {
                $follow->to = $idfollow->id;
                $alreadyfollow = $follow->getFollowAlready();
                if($alreadyfollow != 0) { 
                    $error++;
                }
                if($follow->from == $follow->to) { 
                    $error++;
                }
                if($error == 0) {
                    $follow->addFollow();
                }   
            }
        }
    }
