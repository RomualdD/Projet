<?php
/**
 * Classe users
 * Permet d'accéder à la table users
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
    public $pathology = 0;
    public $cleverif = '';
    public $actif = 0;
    public $qrcodeParam = '';
    
    public function __construct() {
        parent::__construct();
    }
// -- // Ajout  
    /**
     * Méthode permet d'ajouter un utilisateur
     */
    public function addUser() {
        $requestAdd = $this->db->prepare('INSERT INTO `users`(`lastname`, `firstname`, `username`, `mail`, `password`,`birthdate`, `phone`,`phone2`, `role`, `pathology`,`keyverif`,`active`,`qrcode`) VALUES(:name, :firstname, :username, :mail, :password,:birthday,:phone,:phone2,:role,:pathology,:cleverif,:actif,:qrcode)');
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
// -- // Récupération     
    /**
     * Méthode permet de vérifier si le nom d'utilisateur est déjà pris
     * @return array
     */
    public function getUsername() {
        $username = array();
        $resultUsername = $this->db->prepare('SELECT `username` FROM `users` WHERE `username` = :username');
        $resultUsername->bindValue('username',$this->username,PDO::PARAM_STR);
        if($resultUsername->execute()) {
            if(is_object($resultUsername)) {
                $username = $resultUsername->fetch(PDO::FETCH_ASSOC);
            }           
        }
        return $username;
    }
    /**
     * Méthode permet de chercher l'utilisateur et son mot de passe pour la connexion
     * @return array
     */
    public function getUser() {
           $user = array();
           $requestSearchUser = $this->db->query('SELECT `username`,`password` FROM `users` WHERE `password` = \''.$this->password.'\' AND `username` = \''.$this->username.'\'');
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
            $resultId = $this->db->query('SELECT `id` FROM `users` WHERE `username` =\''.$this->username.'\'');
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
        $requestInfo = $this->db->prepare('SELECT `username`,`lastname`, `firstname`, DATE_FORMAT(`birthdate`,"%d/%m/%Y") AS `birthdate`, `mail`, `phone`, `phone2`, CASE WHEN `pathology` = 1 Then \'Diabète Type 1\' WHEN `pathology` = 2 Then \'Diabète Type 2\' ELSE \'Anticoagulant (AVK)\' END AS `pathologyName`  FROM `users` WHERE `username` =:username');
        $requestInfo->bindValue('username',$this->username,PDO::PARAM_STR);
        if($requestInfo->execute()) {
            $infoUser = $requestInfo->fetch(PDO::FETCH_ASSOC); 
            if(is_array($infoUser)) {
                $this->name = $infoUser['lastname'];
                $this->firstname = $infoUser['firstname'];
                $this->birthday = $infoUser['birthdate'];
                $this->mail = $infoUser['mail'];
                $this->phone = $infoUser['phone'];
                $this->phone2 = $infoUser['phone2'];
                $this->pathology = $infoUser['pathologyName'];
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
        $recuppassword = $this->db->prepare('SELECT `password` FROM `users` WHERE `id` = '.$this->id);
        $recuppassword->bindValue('id',$this->id,PDO::PARAM_INT);
        if($recuppassword->execute()) {
            $password = $recuppassword->fetch(PDO::FETCH_ASSOC);
        }    
        return $password;    
    }
    /**
     * Méthode qui vérifie que le profil est bien actif
     * @return array
     */
    public function getVerif() {
        $actif = array();
        $search = $this->db->query('SELECT `active` FROM `users` WHERE `username` = \''.$this->username.'\'');
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
        $requestInfo = $this->db->query('SELECT `role`,`pathology` FROM `users` WHERE `username` = \''.$this->username.'\'');
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
        $researchqrcode = $this->db->query('SELECT `qrcode` FROM `users` WHERE `username` = \''.$this->username.'\'');
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
        $requestSearchPatient = $this->db->prepare('SELECT `lastname`, `firstname`, `username` FROM `users` WHERE (`lastname like :name OR `firstname` like :firstname) AND `role` = :role');
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
        $requestSearchDoctor = $this->db->prepare('SELECT `lastname`, `firstname`, `username` FROM `users` WHERE (`lastname` like :name OR `firstname` like :firstname) AND `role` = :role');
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
        $researchId = $this->db->prepare('SELECT `id` FROM `users` WHERE qrcode = :qrcode');
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
        $requestmail = $this->db->query('SELECT `lastname`, `firstname`, `mail`, `date_verification` FROM `users` LEFT JOIN `verification` ON `userId` = id');
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
        $requestmailappointment = $this->db->query('SELECT `lastname`, `firstname`, `mail`, `date_appointment`,`hour_appointment`,`name_appointment`,`additional_informations` FROM `users` LEFT JOIN `appointments` ON `appointments`.`userId` = `users`.`id`');
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
        $recupcle = $this->db->prepare('SELECT `keyverif`, `active` FROM `users` WHERE `username` = :user');
        $recupcle->bindValue('user',$this->username,PDO::PARAM_STR);
        if($recupcle->execute()) {
            $cle = $recupcle->fetch();
            $this->cleverif = $cle['keyverif'];
            $this->actif = $cle['active'];
            $isCorrect = true;
        }
        return $isCorrect;
    }
// -- // Modification    
    /**
     * Méthode qui modifie le compte de l'utilisateur en actif
     * @return bool
     */
    public function updateActif() {
        $modifActif = $this->db->prepare('UPDATE `users` SET `active` = 1 WHERE `username` = :user');
        $modifActif->bindValue(':user', $this->username,PDO::PARAM_STR);
        return $modifActif->execute();
    }
    /**
     * Méthode qui modifie le mot de passe de l'utilisateur
     */
    public function updatePassword() {
        $insertnewpassword = $this->db->prepare('UPDATE `users` SET `password` = :password WHERE `id` = '.$this->id);
        $insertnewpassword->bindValue('password', $this->password, PDO::PARAM_STR);
        return $insertnewpassword->execute();        
    }
    /**
     * Méthode qui modifie le mail de l'utilisateur
     */
    public function updateMail() {
        $modifMail = $this->db->prepare('UPDATE `users` SET `mail` = :mail WHERE `username` = :user');
        $modifMail->bindValue('mail',$this->mail,PDO::PARAM_STR);
        $modifMail->bindValue('user',$this->username,PDO::PARAM_STR);
        return $modifMail->execute();
    }
    /**
     * Méthode qui modifie le premier numéro de l'utilisateur
     */
    public function updatePhone() {
        $modifPhone = $this->db->prepare('UPDATE `users` SET `phone` = :phone WHERE `username` = :user');
        $modifPhone->bindValue('phone',$this->phone,PDO::PARAM_STR);
        $modifPhone->bindValue('user',$this->username,PDO::PARAM_STR);
        return $modifPhone->execute();
    }
    /**
     * Méthode qui modifie le second numéro de l'utilisateur
     */
    public function updateSecondPhone() {
        $modifPhone = $this->db->prepare('UPDATE `users` SET `phone2` = :phone WHERE `username` = :user');
        $modifPhone->bindValue('phone',$this->phone2,PDO::PARAM_STR);
        $modifPhone->bindValue('user',$this->username,PDO::PARAM_STR);
        return $modifPhone->execute();
    }
    public function __destruct() {
        
    }
}
