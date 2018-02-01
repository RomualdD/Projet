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
        $isCorrect = false;
        $requestInfo = $this->db->prepare('SELECT `nom_utilisateur`,`nom`, `prenom`, DATE_FORMAT(`date_anniversaire`,"%d/%m/%Y") AS `date_anniversaire`, `mail`, `phone`, `phone2`, CASE WHEN `pathologie` = 1 Then \'Diabète Type 1\' WHEN `pathologie` = 2 Then \'Diabète Type 2\' ELSE \'Anticoagulant (AVK)\' END AS `pathologieName`  FROM `utilisateurs` WHERE `nom_utilisateur` =:username');
        $requestInfo->bindValue('username',$this->username,PDO::PARAM_STR);
        if($requestInfo->execute()) {
                $infoUser = $requestInfo->fetch(PDO::FETCH_ASSOC); 
            if(is_array($infoUser)) {
                $this->name = $infoUser['nom'];
                $this->firstname = $infoUser['prenom'];
                $this->birthday = $infoUser['date_anniversaire'];
                $this->mail = $infoUser['mail'];
                $this->phone = $infoUser['phone'];
                $this->phone2 = $infoUser['phone2'];
                $this->pathology = $infoUser['pathologieName'];
                $isCorrect = true;
            }           
        }        
       return $isCorrect;
    }
    /**
     * Méthode qui récupère le mot de passe pour vérifier si c'est le bon
     * @return array
     */
    public function getPassword() {
        $password = array();
        $recuppassword = $this->db->query('SELECT `mot_de_passe` FROM `utilisateurs` WHERE `id` = '.$this->id);
        if(is_array($recuppassword)) {
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
    /**
     * Permet de trouver le code qrCode de l'utilisateur
     * @return array
     */
    public function getQrCode() {
        $researchqrcode = array();
        $researchqrcode = $this->db->query('SELECT `qrcode` FROM `utilisateurs` WHERE `nom_utilisateur` = \''.$this->username.'\'');
        if(is_object($researchqrcode)) {
            $researchqrcode = $researchqrcode->fetch(PDO::FETCH_ASSOC);     
        }
        return $researchqrcode;
    }
    /**
     * Méthode qui renvoie les patients avec le nom ou le prénom demandé
     * @return array
     */
    public function getPatientUserByName() {
        $patient = array();
        $requestSearchPatient = $this->db->prepare('SELECT `nom`, `prenom`, `nom_utilisateur` FROM `utilisateurs` WHERE (`nom` like :name OR `prenom` like :firstname) AND `role` = :role');
        $requestSearchPatient->bindValue('name',$this->name.'%',PDO::PARAM_STR);
        $requestSearchPatient->bindValue('firstname',$this->name.'%',PDO::PARAM_STR);
        $requestSearchPatient->bindValue('role','1',PDO::PARAM_INT);
        if($requestSearchPatient->execute()) {
            $patient = $requestSearchPatient->fetchAll(PDO::FETCH_ASSOC);
        }
       return $patient; 
    }
    /**
     * Méthode qui renvoie les médecins avec le nom ou le prénom demandé
     * @return array
     */
    public function getDoctorUserByName() {
        $doctor = array();
        $requestSearchDoctor = $this->db->prepare('SELECT `nom`, `prenom`, `nom_utilisateur` FROM `utilisateurs` WHERE (`nom` like :name OR `prenom` like :firstname) AND `role` = :role');
        $requestSearchDoctor->bindValue('name',$this->name.'%',PDO::PARAM_STR);
        $requestSearchDoctor->bindValue('firstname',$this->name.'%',PDO::PARAM_STR);
        $requestSearchDoctor->bindValue('role','0',PDO::PARAM_STR);
        if($requestSearchDoctor->execute()) {
            $doctor = $requestSearchDoctor->fetchAll(PDO::FETCH_ASSOC);
        }
       return $doctor;         
    }
    /**
     * Méthode qui retourne l'id de l'utilisateur a qui on a scanner le QRCode
     * @return array
     */
    public function getIdByQrCode() {
        $idParam = array();
        $researchId = $this->db->prepare('SELECT `id` FROM `utilisateurs` WHERE qrcode = :qrcode');
        $researchId->bindValue('qrcode',$this->qrcodeParam,PDO::PARAM_STR);
        if($researchId->execute()) {
            $idParam = $researchId->fetch(PDO::FETCH_ASSOC);            
        }
        return $idParam;     
    }
    /**
     * Méthode cherchant les informations importantes pour un envoie de mail et leur date de vérification
     * @return array
     */
    public function getInfoAndVerification() {
        $mail = array();
        $requestmail = $this->db->query('SELECT `nom`, `prenom`, `mail`, `date_verification` FROM `utilisateurs` LEFT JOIN `verification` ON `id_utilisateur` = id');
        if(is_object($requestmail)) {
            $mail = $requestmail->fetchAll(PDO::FETCH_ASSOC);         
        }
        return $mail;
    }
    /**
     * Méthode récupération des informations importantes pour l'envoie de mail et la date du rendez_vous
     * @return array
     */
    public function getInfoAndAppointment() {
        $mail = array();
        $requestmailappointment = $this->db->query('SELECT `nom`, `prenom`, `mail`, `date_rendez_vous`,`heure_rendez_vous`,`nom_rendez_vous`,`infos_complementaire` FROM `utilisateurs` LEFT JOIN `rendez_vous` ON `rendez_vous`.`id_utilisateur` = `utilisateurs`.`id`');
        if(is_object($requestmailappointment)) {
            $mail = $requestmailappointment->fetchAll(PDO::FETCH_ASSOC);                
        }
        return $mail;
    }
    /**
     * Récupère les informations si la clé est actif
     * @return array
     */
    public function getCleVerifActif() {
        $isCorrect = false;
        $recupcle = $this->db->prepare('SELECT `cleverif`, `actif` FROM `utilisateurs` WHERE `nom_utilisateur` = :user');
        $recupcle->bindValue('user',$this->username,PDO::PARAM_STR);
        if($recupcle->execute()) {
            $cle = $recupcle->fetch();
            $this->cleverif = $cle['cleverif'];
            $this->actif = $cle['actif'];
            $isCorrect = true;
        }
        return $isCorrect;
    }
    /**
     * Méthode qui modifie le compte de l'utilisateur en actif
     * @return bool
     */
    public function updateActif() {
        $modifActif = $this->db->prepare('UPDATE `utilisateurs` SET `actif` = 1 WHERE `nom_utilisateur` = :user ');
        $modifActif->bindValue(':user', $this->username,PDO::PARAM_STR);
        return $modifActif->execute();
    }
    
    public function __destruct() {
        
    }
}
