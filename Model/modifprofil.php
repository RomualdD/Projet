<?php
// -- // Information des résultats
    $user = $_SESSION['user'];
    $request = $bdd->query('SELECT `nom`, `prenom`, DATE_FORMAT(`date_anniversaire`,"%d/%m/%Y") AS `date_anniversaire`, `mail`, `phone`, `phone2`, `pathologie` FROM `utilisateurs` WHERE `nom_utilisateur` ="'.$user.'"');
    $request = $request->fetch();
    $name = $request['nom'];
    $surname = $request['prenom'];
    $birthday = $request['date_anniversaire'];
    $mail = $request['mail'];
    $phone = $request['phone'];
    $otherphone = $request['phone2'];
    $pathology = $request['pathologie'];
    if($pathology == 1) {
        $pathologyname = 'Diabète Type 1';
    }
    elseif ($pathology == 2) {
        $pathologyname = 'Diabète Type 2';
    }
    else {
        $pathologyname = 'Anticoagulant (AVK)';
    }

// -- // Modification du profil
    $successMsg = '';
    $errorPassword = '';
    $errorPasswordFalse = '';
    if(isset($_POST['submitmodifpassword'])) {
        if(!empty($_POST['password']) && (!empty($_POST['newpassword'])) && (!empty($_POST['passwordverif']))) {
            $recuppassword = $bdd->query('SELECT `mot_de_passe` FROM `utilisateurs` WHERE `id` = ' . $id);
            $recuppassword = $recuppassword->fetch();
            $password = sha1(md5($_POST['password']));
            if ($password == $recuppassword['mot_de_passe']) {
                $newpassword = sha1(md5($_POST['newpassword']));
                $newpasswordverif = sha1(md5($_POST['passwordverif']));
                if ($newpassword == $newpasswordverif) {
                    $insertnewpassword = $bdd->prepare('UPDATE `utilisateurs` SET `mot_de_passe` = :password WHERE `id` = ' . $id);
                    $insertnewpassword->bindValue('password', $newpassword, PDO::PARAM_STR);
                    $insertnewpassword->execute();
                    $successMsg = 'Le mot de passe a bien était modifié !';
                }
                else {
                    $errorPassword = 'Les mots de passes ne sont pas identiques !';
                }
            }
            else {
                $errorPasswordFalse = 'Ce n\'est pas votre mot de passe !';
            }
        }
        else {
            echo 'Les champs ne sont pas tous remplis !';
        }
    }
// -- // Recherche demande suivi    
    $requestfollow = $bdd->prepare('SELECT `follow_from`, `follow_date`,`nom`,`prenom`,`nom_utilisateur` FROM `follow` LEFT JOIN `utilisateurs` ON `id`=`follow_from` WHERE `follow_to` = :id AND `follow_confirm` = :confirm');
    $requestfollow->bindValue(':id',$id, PDO::PARAM_INT);
    $requestfollow->bindValue(':confirm','0', PDO::PARAM_STR);
    $requestfollow->execute();

   