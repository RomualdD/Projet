<?php
    if(isset($_POST['connexion'])) {
        if(!empty($_POST['username']) && (!empty($_POST['password']))) {
               $user = $_POST['username'];          
               // Cryptage du mot de passe entré
               $pass = sha1(md5($_POST['password']));
               // Cherche le nom d'utilisateur et le mot de passe entré
               $request = $db->query('SELECT `nom_utilisateur`,`mot_de_passe` FROM `utilisateurs` WHERE `mot_de_passe` = \''.$pass.'\' AND `nom_utilisateur` = \''.$user.'\'');
               $requestUser = $request->fetch(PDO::FETCH_ASSOC);
               $verifUser = $requestUser['nom_utilisateur'];
               $verifPassword = $requestUser['mot_de_passe'];
              // Si les champs correspondent dans la base de données
              if($verifUser == $user && $pass == $verifPassword) {
                  // Vérification si le compte est bien actif
                 $search = $db->prepare('SELECT `actif` FROM `utilisateurs` WHERE `nom_utilisateur` = :user');
                 if($search->execute(array(':user' => $user)) && $row = $search->fetch()){
                   $actif = $row['actif'];
                 }
                 if($actif == '1') {
                   // Démarrage d'une session
                  // session_start();
                   $requestInfo = $db->query('SELECT `role`,`pathologie` FROM `utilisateurs` WHERE `nom_utilisateur` = \''.$user.'\'');
                   $infosUser = $requestInfo->fetch(PDO::FETCH_ASSOC);
                   $db = NULL;
                   //Enregistement dans la session:
                   $_SESSION['user'] = $_POST['username'];
                   $_SESSION['password'] = $_POST['password'];
                   $_SESSION['role'] = $infosUser['role'];
                   $_SESSION['pathology']= $infosUser['pathologie'];
                 }
               }
             else {
                 echo 'Failed';
              }
           }
        else {
           echo 'Tous les champs n\'ont pas était remplis !';
        }
    } 
if(isset($_SESSION['user'])) {
   /* $researchParam = $db->query('SELECT `id` FROM `utilisateurs` WHERE qrcode = \''.$idFollow.'\'');
    $researchidParam = $researchParam->fetch(PDO::FETCH_ASSOC);
    $idTo = $researchidParam['id'];*/
    
    $verifFollow = $db->query('SELECT `follow_confirm` FROM `follow` WHERE (`follow_to` ='.$idTo.' OR `follow_from` ='.$idTo.') AND (`follow_to` ='.$id.' OR `follow_from` ='.$id.')');
    $verif = $verifFollow->fetchColumn();
    if($verif == 0 && $idTo != $id) {
        $addfollow = $db->prepare('INSERT INTO `follow`(`follow_from`, `follow_to`, `follow_confirm`, `follow_date`) VALUES(:id,:id_to,:confirm,NOW())');
        $addfollow->bindValue('id',$id,PDO::PARAM_STR);
        $addfollow->bindValue('id_to',$idTo, PDO::PARAM_INT);
        $addfollow->bindValue('confirm','1',PDO::PARAM_INT);
        $addfollow->execute();        
    }
}    