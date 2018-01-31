<?php
/**
 * Classe users
 * Permet d'accéder à la table utilisateurs
 */
class users extends dataBase {
    public $id = 0;
    public $name = '';
    public $firstname = '';
    public $username = '';
    public $mail = '';
    public $password = '';
    public $birthday = '01/01/1900';
    public $phone = '';
    public $phone2 = '';
    public $role = 0;
    public $pathology = '0';
    public $cleverif = '';
    public $actif = 0;
    public $qrcodeParam = '';
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Méthode permet de vérifier si le nom d'utilisateur est déjà pris
     * @return array
     */
    public function getUsername() {
        $username = array();
        $resultUsername = $this->db->prepare('SELECT `nom_utilisateur` FROM `utilisateurs` WHERE `nom_utilisateur` = :username');
        $resultUsername->bindValue('username',$this->username,PDO::PARAM_STR);
        if($resultUsername->execute()) {
            if(is_object($resultUsername)) {
                $username = $resultUsername->fetch(PDO::FETCH_ASSOC);
            }           
        }
        return $username;
    }
    /**
     * Méthode permet d'ajouter un utilisateur
     */
    public function addUser() {
        $requestAdd = $this->db->prepare('INSERT INTO `utilisateurs`(`nom`, `prenom`, `nom_utilisateur`, `mail`, `mot_de_passe`,`date_anniversaire`, `phone`,`phone2`, `role`, `pathologie`,`cleverif`,`actif`,`qrcode`) VALUES(:name, :firstname, :username, :mail, :password,:birthday,:phone,:phone2,:role,:pathology,:cleverif,:actif,:qrcode)');
        $requestAdd->bindValue('name',$this->name,PDO::PARAM_STR);
        $requestAdd->bindValue('firstname',$this->firstname,PDO::PARAM_STR);
        $requestAdd->bindValue('username',$this->username,PDO::PARAM_STR);
        $requestAdd->bindValue('mail',$this->mail,PDO::PARAM_STR);
        $requestAdd->bindValue('password',$this->password,PDO::PARAM_STR);
        $requestAdd->bindValue('birthday',$this->birthday,PDO::PARAM_STR);
        $requestAdd->bindValue('phone',$this->phone,PDO::PARAM_STR);
        $requestAdd->bindValue('phone2',$this->phone2,PDO::PARAM_STR);
        $requestAdd->bindValue('role',$this->role,PDO::PARAM_INT);
        $requestAdd->bindValue('pathology',$this->pathology,PDO::PARAM_INT);
        $requestAdd->bindValue('cleverif',$this->cleverif,PDO::PARAM_STR);
        $requestAdd->bindValue('actif',$this->actif,PDO::PARAM_INT);
        $requestAdd->bindValue('qrcode',$this->qrcodeParam,PDO::PARAM_STR);
        return $requestAdd->execute();
    }
    /**
     * Méthode permet de chercher l'utilisateur et son mot de passe pour la connexion
     * @return array
     */
    public function getUser() {
           $user = array();
           $requestSearchUser = $this->db->query('SELECT `nom_utilisateur`,`mot_de_passe` FROM `utilisateurs` WHERE `mot_de_passe` = \''.$this->password.'\' AND `nom_utilisateur` = \''.$this->username.'\'');
           if(is_object($requestSearchUser)) {
              $user = $requestSearchUser->fetch(PDO::FETCH_ASSOC); 
           }
           return $user;
    }
    /**
     * Récupère l'id de l'utilisateur
     * @return array
     */
    public function getUserId() {
            $userId = array();
            $resultId = $this->db->query('SELECT `id` FROM `utilisateurs` WHERE `nom_utilisateur` =\''.$this->username.'\'');
            if(is_object($resultId)) {
                $userId = $resultId->fetch(PDO::FETCH_ASSOC);
            }
           return $userId;
    }
    /**
     * Méthode qui récupère les informations de l'utilisateur 
     * @return array
     */
    public function getUserInfo() {
        $infoUser = array();
        $requestInfo = $this->db->prepare('SELECT `nom_utilisateur`,`nom`, `prenom`, DATE_FORMAT(`date_anniversaire`,"%d/%m/%Y") AS `date_anniversaire`, `mail`, `phone`, `phone2`, CASE WHEN `pathologie` = 1 Then \'Diabète Type 1\' WHEN `pathologie` = 2 Then \'Diabète Type 2\' ELSE \'Anticoagulant (AVK)\' END AS `pathologieName`  FROM `utilisateurs` WHERE `nom_utilisateur` =:username');
        $requestInfo->bindValue('username',$this->username,PDO::PARAM_STR);
        if($requestInfo->execute()) {
            if(is_object($requestInfo)) {
                $infoUser = $requestInfo->fetch(PDO::FETCH_ASSOC);
                $this->name = $infoUser['nom'];
                $this->firstname = $infoUser['prenom'];
                $this->birthday = $infoUser['date_anniversaire'];
                $this->mail = $infoUser['mail'];
                $this->phone = $infoUser['phone'];
                $this->phone2 = $infoUser['phone2'];
                $this->pathology = $infoUser['pathologieName'];
            }           
        }        
       return $infoUser;
    }
    /**
     * Méthode qui récupère le mot de passe pour vérifier si c'est le bon
     * @return array
     */
    public function getPassword() {
        $password = array();
        $recuppassword = $this->db->query('SELECT `mot_de_passe` FROM `utilisateurs` WHERE `id` = '.$this->id);
        if(is_object($recuppassword)) {
            $password = $recuppassword->fetch();
        }    
        return $password;    
    }
    /**
     * Méthode qui modifie le mot de passe de l'utilisateur
     */
    public function modifPassword() {
        $insertnewpassword = $this->db->prepare('UPDATE `utilisateurs` SET `mot_de_passe` = :password WHERE `id` = '.$this->id);
        $insertnewpassword->bindValue('password', $newpassword, PDO::PARAM_STR);
        return $insertnewpassword->execute();        
    }
    /**
     * Méthode qui vérifie que le profil est bien actif
     * @return array
     */
    public function getVerif() {
        $actif = array();
        $search = $this->db->query('SELECT `actif` FROM `utilisateurs` WHERE `nom_utilisateur` = \''.$this->username.'\'');
        if(is_object($search)) {
            $actif = $search->fetch();
        }
        return $actif;
    }
    /**
     * Méthode qui récupère les informations importantes de l'utilisateur lors de sa connexion
     * @return array
     */
    public function getInfoConnexion() {
        $infosUser = array();
        $requestInfo = $this->db->query('SELECT `role`,`pathologie` FROM `utilisateurs` WHERE `nom_utilisateur` = \''.$this->username.'\'');
        if(is_object($requestInfo)) {
            $infosUser = $requestInfo->fetch(PDO::FETCH_ASSOC);
        }
        return $infosUser;
    }
    
    public function getQrCode() {
        $researchqrcode = array();
        $researchqrcode = $this->db->query('SELECT `qrcode` FROM `utilisateurs` WHERE `nom_utilisateur` = \''.$this->username.'\'');
        if(is_object($researchqrcode)) {
            $researchqrcode = $researchqrcode->fetch(PDO::FETCH_ASSOC);     
        }
        return $researchqrcode;
    }

    
    public function __destruct() {
        
    }
}
