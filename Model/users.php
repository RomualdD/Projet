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
    public $language = 'fr';
    public $cleverif = '';
    public $actif = 0;
    public $qrcodeParam = '';
    private $prefix = PREFIX ;
    
    public function __construct() {
        parent::__construct();
    }
// -- // Ajout  
    /**
     * Méthode permet d'ajouter un utilisateur
     * @return bool
     */
    public function addUser() {
        $requestAdd = $this->db->prepare('INSERT INTO `'.$this->prefix.'users`(`lastname`, `firstname`, `username`, `mail`, `password`,`birthdate`, `phone`,`phone2`, `id_'.$this->prefix.'role`, `id_'.$this->prefix.'pathology`,`language`,`keyverif`,`active`,`qrcode`) VALUES(:name, :firstname, :username, :mail, :password,:birthday,:phone,:phone2,:role,:pathology,:language,:cleverif,:actif,:qrcode)');
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
        $requestAdd->bindValue('language',$this->language,PDO::PARAM_STR);
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
        $resultUsername = $this->db->prepare('SELECT `username` FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $resultUsername->bindValue('username',$this->username,PDO::PARAM_STR);
        if($resultUsername->execute()) {
            if(is_object($resultUsername)) {
                $username = $resultUsername->fetch(PDO::FETCH_OBJ);
            }           
        }
        return $username;
    }
    /**
     * Récupère le mail de l'utilisateur
     * @return array
     */
    public function getMailByUsername(){
        $mail = array();
        $resultMail = $this->db->prepare('SELECT `mail` FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $resultMail->bindValue('username', $this->username,PDO::PARAM_STR);
        if($resultMail->execute()) {
            if(is_object($resultMail)) {
                $mail = $resultMail->fetch(PDO::FETCH_OBJ);
            }           
        }
        return $mail;
    }
    /**
     * Méthode permet de vérifier si le nom d'utilisateur est déjà pris
     * @return array
     */
    public function getUsernameByMail() {
        $username = array();
        $resultUsername = $this->db->prepare('SELECT `username`,`keyverif` FROM `'.$this->prefix.'users` WHERE `mail` = :mail');
        $resultUsername->bindValue('mail',$this->mail,PDO::PARAM_STR);
        if($resultUsername->execute()) {
            if(is_object($resultUsername)) {
                $username = $resultUsername->fetch(PDO::FETCH_OBJ);
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
        $requestSearchUser = $this->db->prepare('SELECT `username`,`password` FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $requestSearchUser->bindValue(':username',$this->username,PDO::PARAM_STR);
        if($requestSearchUser->execute()) {
            if(is_object($requestSearchUser)) {
                $user = $requestSearchUser->fetch(PDO::FETCH_OBJ); 
            }       
        }
        return $user;
    }
    /**
     * Récupère l'id de l'utilisateur
     * @return array
     */
    public function getUserId() {
        $userId = array();
        $resultId = $this->db->prepare('SELECT `id` FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $resultId->bindValue('username',$this->username,PDO::PARAM_STR);
        if($resultId->execute()) {
            if(is_object($resultId)) {
                $userId = $resultId->fetch(PDO::FETCH_OBJ);
            }    
        }
        return $userId;
    }
    /**
     * Méthode qui récupère les informations de l'utilisateur 
     * @return array
     */
    public function getUserInfo() {
        $isCorrect = false;
        $requestInfo = $this->db->prepare('SELECT `username`,`lastname`, `firstname`, DATE_FORMAT(`birthdate`,"%d/%m/%Y") AS `birthdate`, `mail`, `phone`, `phone2`, `'.$this->prefix.'pathology`.`name` AS `pathologyName` FROM `'.$this->prefix.'users` LEFT JOIN `'.$this->prefix.'pathology` ON `id_'.$this->prefix.'pathology` = `'.$this->prefix.'pathology`.`id` WHERE `username` =:username');
        $requestInfo->bindValue('username',$this->username,PDO::PARAM_STR);
        if($requestInfo->execute()) {
            $infoUser = $requestInfo->fetch(PDO::FETCH_OBJ); 
            if(is_object($infoUser)) {
                $this->name = $infoUser->lastname;
                $this->firstname = $infoUser->firstname;
                $this->birthday = $infoUser->birthdate;
                $this->mail = $infoUser->mail;
                $this->phone = $infoUser->phone;
                $this->phone2 = $infoUser->phone2;
                $this->pathology = $infoUser->pathologyName;
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
        $recuppassword = $this->db->prepare('SELECT `password` FROM `'.$this->prefix.'users` WHERE `id` = :id');
        $recuppassword->bindValue('id',$this->id,PDO::PARAM_INT);
        if($recuppassword->execute()) {
            $password = $recuppassword->fetch(PDO::FETCH_OBJ);
        }    
        return $password;    
    }
    /**
     * Méthode qui vérifie que le profil est bien actif
     * @return array
     */
    public function getVerif() {
        $actif = array();
        $search = $this->db->prepare('SELECT `active` FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $search->bindValue('username',$this->username,PDO::PARAM_STR);
        if($search->execute()) {
            if(is_object($search)) {
                $actif = $search->fetch(PDO::FETCH_OBJ);
            }            
        }
        return $actif;
    }
    /**
     * Méthode qui récupère les informations importantes de l'utilisateur lors de sa connexion
     * @return array
     */
    public function getInfoConnexion() {
        $infosUser = array();
        $requestInfo = $this->db->prepare('SELECT `firstname`,`lastname`,`id_'.$this->prefix.'role` AS role,`id_'.$this->prefix.'pathology` AS pathology FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $requestInfo->bindValue('username',$this->username,PDO::PARAM_STR);
        if($requestInfo->execute()) {
            if(is_object($requestInfo)) {
                $infosUser = $requestInfo->fetch(PDO::FETCH_OBJ);
            }            
        }
        return $infosUser;
    }
    /**
     * Permet de trouver le code qrCode de l'utilisateur
     * @return array
     */
    public function getQrCode() {
        $researchqrcode = array();
        $researchqrcode = $this->db->prepare('SELECT `qrcode` FROM `'.$this->prefix.'users` WHERE `username` = :username');
        $researchqrcode->bindValue('username',$this->username,PDO::PARAM_STR);
        if($researchqrcode->execute()) {
            if(is_object($researchqrcode)) {
                $researchqrcode = $researchqrcode->fetch(PDO::FETCH_OBJ);     
            }            
        }
        return $researchqrcode;
    }
    /**
     * Méthode qui renvoie les patients avec le nom ou le prénom demandé
     * @return array
     */
    public function getPatientUserByName() {
        $patient = array();
        $requestSearchPatient = $this->db->prepare('SELECT `lastname`, `firstname`, `username`, `confirm` FROM `'.$this->prefix.'users` LEFT JOIN `'.$this->prefix.'follow` ON (`id_'.$this->prefix.'users_1` = `'.$this->prefix.'users`.`id` OR `id_'.$this->prefix.'users` = `'.$this->prefix.'users`.`id`) AND (`id_'.$this->prefix.'users` = :id OR `id_'.$this->prefix.'users_1` = :id) WHERE `id_'.$this->prefix.'role` = :role AND (`lastname` LIKE :name OR `firstname` LIKE :firstname)');
        $requestSearchPatient->bindValue('name',$this->name.'%',PDO::PARAM_STR);
        $requestSearchPatient->bindValue('firstname',$this->name.'%',PDO::PARAM_STR);
        $requestSearchPatient->bindValue('role','2',PDO::PARAM_INT);
        $requestSearchPatient->bindValue('id',$this->id,PDO::PARAM_INT);
        if($requestSearchPatient->execute()) {
            $patient = $requestSearchPatient->fetchAll(PDO::FETCH_OBJ);
        }
       return $patient; 
    }
    /**
     * Méthode qui renvoie les médecins avec le nom ou le prénom demandé
     * @return array
     */
    public function getDoctorUserByName() {
        $doctor = array();
        $requestSearchDoctor = $this->db->prepare('SELECT `lastname`, `firstname`, `username`, `confirm` FROM `'.$this->prefix.'users` LEFT JOIN `'.$this->prefix.'follow` ON (`id_'.$this->prefix.'users_1` = `'.$this->prefix.'users`.`id` OR `id_'.$this->prefix.'users` = `'.$this->prefix.'users`.`id`) AND (`id_'.$this->prefix.'users` = :id OR `id_'.$this->prefix.'users_1` = :id) WHERE `id_'.$this->prefix.'role` = :role AND (`lastname` LIKE :name OR `firstname` LIKE :firstname)');
        $requestSearchDoctor->bindValue('name','%'.$this->name.'%',PDO::PARAM_STR);
        $requestSearchDoctor->bindValue('firstname','%'.$this->name.'%',PDO::PARAM_STR);
        $requestSearchDoctor->bindValue('role','3',PDO::PARAM_STR);
        $requestSearchDoctor->bindValue('id',$this->id,PDO::PARAM_INT);
        if($requestSearchDoctor->execute()) {
            $doctor = $requestSearchDoctor->fetchAll(PDO::FETCH_OBJ);
        }
       return $doctor;         
    }
    /**
     * Méthode qui retourne l'id de l'utilisateur a qui on a scanner le QRCode
     * @return array
     */
    public function getIdByQrCode() {
        $idParam = array();
        $researchId = $this->db->prepare('SELECT `id`,`id_'.$this->prefix.'role` AS `role` FROM `'.$this->prefix.'users` WHERE qrcode = :qrcode');
        $researchId->bindValue('qrcode',$this->qrcodeParam,PDO::PARAM_STR);
        if($researchId->execute()) {
            $idParam = $researchId->fetch(PDO::FETCH_OBJ);            
        }
        return $idParam;     
    }
    /**
     * Méthode cherchant les informations importantes pour un envoie de mail et leur date de vérification
     * @return array
     */
    public function getInfoAndVerification() {
        $mail = array();
        $requestmail = $this->db->query('SELECT `lastname`, `firstname`, `mail`, `verification_date`,`language` FROM `'.$this->prefix.'users` LEFT JOIN `'.$this->prefix.'verification` ON `id_'.$this->prefix.'users` = `'.$this->prefix.'users`.`id`');
        if(is_object($requestmail)) {
            $mail = $requestmail->fetchAll(PDO::FETCH_OBJ);         
        }
        return $mail;
    }
    /**
     * Méthode récupération des informations importantes pour l'envoie de mail et la date du rendez_vous
     * @return array
     */
    public function getInfoAndAppointment() {
        $mail = array();
        $requestmailappointment = $this->db->query('SELECT `lastname`, `firstname`, `mail`,`language`, `date`,`hour`,`name`,`additional_informations` FROM `'.$this->prefix.'users` LEFT JOIN `'.$this->prefix.'appointments` ON `'.$this->prefix.'appointments`.`id_'.$this->prefix.'users` = `'.$this->prefix.'users`.`id`');
        if(is_object($requestmailappointment)) {
            $mail = $requestmailappointment->fetchAll(PDO::FETCH_OBJ);                
        }
        return $mail;
    }
    /**
     * Récupère les informations si la clé est actif
     * @return array
     */
    public function getCleVerifActif() {
        $isCorrect = false;
        $recupcle = $this->db->prepare('SELECT `keyverif`, `active` FROM `'.$this->prefix.'users` WHERE `username` = :user');
        $recupcle->bindValue('user',$this->username,PDO::PARAM_STR);
        if($recupcle->execute()) {
            $cle = $recupcle->fetch(PDO::FETCH_OBJ);
            $this->cleverif = $cle->keyverif;
            $this->actif = $cle->active;
            $isCorrect = true;
        }
        return $isCorrect;
    }
// -- // Modification   
    /**
     * Méthode qui modifie le mot de passe de l'utilisateur si oublie
     * @return bool
     */
    public function updatePasswordFall() {
        $insertnewpassword = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `password` = :password WHERE `mail` = :mail AND `username` = :username');
        $insertnewpassword->bindValue('username',$this->username,PDO::PARAM_STR);
        $insertnewpassword->bindValue('mail',$this->mail,PDO::PARAM_STR);
        $insertnewpassword->bindValue('password', $this->password, PDO::PARAM_STR);
        return $insertnewpassword->execute();        
    }    
    /**
     * Méthode qui modifie le compte de l'utilisateur en actif
     * @return bool
     */
    public function updateActif() {
        $modifActif = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `active` = 1 WHERE `username` = :user');
        $modifActif->bindValue(':user', $this->username,PDO::PARAM_STR);
        return $modifActif->execute();
    } 
    /**
     * Méthode qui modifie le mot de passe de l'utilisateur
     * @return bool
     */
    public function updatePassword() {
        $insertnewpassword = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `password` = :password WHERE `id` = :id');
        $insertnewpassword->bindValue('password', $this->password, PDO::PARAM_STR);
        $insertnewpassword->bindValue('id', $this->id, PDO::PARAM_INT);
        return $insertnewpassword->execute();        
    }
    /**
     * Méthode qui modifie le mail de l'utilisateur
     * @return bool
     */
    public function updateMail() {
        $modifMail = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `mail` = :mail WHERE `username` = :user');
        $modifMail->bindValue('mail',$this->mail,PDO::PARAM_STR);
        $modifMail->bindValue('user',$this->username,PDO::PARAM_STR);
        return $modifMail->execute();
    }
    /**
     * Méthode qui modifie le premier numéro de l'utilisateur
     * @return bool
     */
    public function updatePhone() {
        $modifPhone = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `phone` = :phone WHERE `username` = :user');
        $modifPhone->bindValue('phone',$this->phone,PDO::PARAM_STR);
        $modifPhone->bindValue('user',$this->username,PDO::PARAM_STR);
        return $modifPhone->execute();
    }
    /**
     * Méthode qui modifie le second numéro de l'utilisateur
     * @return bool
     */
    public function updateSecondPhone() {
        $modifPhone = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `phone2` = :phone WHERE `username` = :user');
        $modifPhone->bindValue('phone',$this->phone2,PDO::PARAM_STR);
        $modifPhone->bindValue('user',$this->username,PDO::PARAM_STR);
        return $modifPhone->execute();
    }
    /**
     * Méthode qui supprime le second numéro de l'utilisateur
     * @return bool
     */
    public function deleteSecondPhone() {
        $deletePhone = $this->db->prepare('UPDATE `'.$this->prefix.'users` SET `phone2` = :phone WHERE `username` = :user');
        $deletePhone->bindValue('phone','Pas indiqué',PDO::PARAM_STR);
        $deletePhone->bindValue('user',$this->username,PDO::PARAM_STR);
        return $deletePhone->execute();
    }
    /**
     * Méthode qui supprime le compte
     * @return bool
     */
    public function deleteAccount() {
        $delete = $this->db->prepare('DELETE FROM `'.$this->prefix.'users` WHERE `id` = :id');
        $delete->bindValue('id',$this->id,PDO::PARAM_STR);
        return $delete->execute();
    }
    public function __destruct() {
        
    }
}
