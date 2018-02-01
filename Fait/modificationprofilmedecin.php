<?php
// -- // Information du profil
    $requestInfoProfil = $db->query('SELECT nom, prenom, mail,nom_utilisateur, phone, phone2, DATE_FORMAT(`date_anniversaire`,"%d/%m/%Y") AS `date_anniversaire` FROM utilisateurs WHERE nom_utilisateur = "'.$user.'"');
    $requestInfoProfil = $requestInfoProfil->fetch(PDO::FETCH_ASSOC);
    $name = $requestInfoProfil['nom'];
    $surname = $requestInfoProfil['prenom'];
    $user = $requestInfoProfil['nom_utilisateur'];
    $birthday = $requestInfoProfil['date_anniversaire'];
    $mail = $requestInfoProfil['mail'];
    $phone = $requestInfoProfil['phone'];
    $otherphone = $requestInfoProfil['phone2'];

// -- // Vérification si demande de suivis
    // Initialisation du nombre de requete faite
    $nbquest = 0;
    // Recherche si il y'a des demandes de suivis
    $requestfollow = $db->prepare('SELECT follow_from, follow_date,nom,prenom,nom_utilisateur FROM follow LEFT JOIN utilisateurs ON id=follow_from WHERE follow_to = :id AND follow_confirm = :confirm');
    $requestfollow->bindValue(':id', $id, PDO::PARAM_INT);
    $requestfollow->bindValue(':confirm', '0', PDO::PARAM_STR);
    $requestfollow->execute();    