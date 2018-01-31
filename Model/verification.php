<?php
/**
 * Classe verification permet d'ajouter les heures et les dates d'informations des prises de sang
 * @author romuald
 */
class verification extends dataBase {
    public $userId;
    public $verification;
    public $oneclock;
    public $twoclock;
    public $threeclock;
    public $fourclock;
    public $notification;
    public $dateverification;
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Méthode de vérification qu'il y'a bien des informations de vérification propre à l'utilisateur
     * @return array
     */
    public function getVerification() {
        $infoVerification = array();
        $searchinfo = $this->db->prepare('SELECT `id_utilisateur`,`date_verification`,`verification`,`Heure1`,`Heure2`,`Heure3`,`Heure4`,`notification` FROM `verification` WHERE `id_utilisateur` = :id');
        $searchinfo->bindValue('id',$this->userId,PDO::PARAM_INT);
        if($searchinfo->execute()) {
            $infoVerification = $searchinfo->fetch(PDO::FETCH_ASSOC);       
        }
        return $infoVerification;
    }
    /**
     * Méthode qui permet de modifier les informations de vérifications de l'utilisateur
     * @return bool
     */
    public function updateVerification() {
        $modifverification = $this->db->prepare('UPDATE `verification` SET `verification` = :verif,`notification` = :notif, `Heure1` = :oneclock, `Heure2` = :twoclock, `Heure3` = :threeclock, `Heure4` = :fourclock WHERE `id_utilisateur` = :id');
        $modifverification->bindValue('verif',$this->verification,PDO::PARAM_STR);
        $modifverification->bindValue('notif',$this->notification,PDO::PARAM_INT);
        $modifverification->bindValue('oneclock',$this->oneclock,PDO::PARAM_STR);
        $modifverification->bindValue('twoclock',$this->twoclock,PDO::PARAM_STR);
        $modifverification->bindValue('threeclock',$this->threeclock,PDO::PARAM_STR);
        $modifverification->bindValue('fourclock',$this->fourclock,PDO::PARAM_STR);
        $modifverification->bindValue('id',$this->userId,PDO::PARAM_INT);
        return $modifverification->execute();
    }
    /**
     * Méthode permettant d'ajouter les informations de vérification de l'utilisateur diabétique
     * @return bool
     */
    public function addVerificationDiabete() {
        $requestverif = $this->db->prepare('INSERT INTO `verification`(`id_utilisateur`, `verification`, `Heure1`, `Heure2`, `Heure3`, `Heure4`, `notification`, `date_verification`) VALUES (:id, :verification, :hour1, :hour2, :hour3, :hour4, :notification, :dateverification)');
        $requestverif->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestverif->bindValue('verification',$this->verification,PDO::PARAM_STR);
        $requestverif->bindValue('hour1',$this->oneclock,PDO::PARAM_STR);
        $requestverif->bindValue('hour2',$this->twoclock,PDO::PARAM_STR);
        $requestverif->bindValue('hour3',$this->threeclock,PDO::PARAM_STR);
        $requestverif->bindValue('hour4',$this->fourclock,PDO::PARAM_STR);
        $requestverif->bindValue('hour4',$this->fourclock,PDO::PARAM_STR);
        $requestverif->bindValue('notification',$this->notification,PDO::PARAM_STR);
        $requestverif->bindValue('dateverification',$this->dateverification,PDO::PARAM_STR);
        return $requestverif->execute();        
    }
    /**
     * Méthode permettant d'ajouter les informations de vérification de l'utilisateur sous antivitamine K
     * @return bool
     */
    public function addVerificationAvk() {
        $requestAddverif = $this->db->prepare('INSERT INTO `verification`(`id_utilisateur`, `Heure1`, `notification`, `date_verification`) VALUES (:id, :hour1, :notification, :dateverification)');
        $requestAddverif->bindValue('id', $this->userId,PDO::PARAM_INT);
        $requestAddverif->bindValue('hour1',$this->oneclock,PDO::PARAM_STR);
        $requestAddverif->bindValue('notification', $this->notification,PDO::PARAM_STR);
        $requestAddverif->bindValue('dateverification', $this->dateverification,PDO::PARAM_STR);
        return $requestAddverif->execute();     
    }
    /**
     * Méthode permettant de modifier les informations de l'utilisateur sous antivitamine K
     * @return bool
     */
    public function updateVerificationAvk() {
        $requestUpdateverif = $this->db->prepare('UPDATE `verification` SET `Heure1` = :oneclock, `notification` = :notification WHERE `id_utilisateur` = :id');
        $requestUpdateverif->bindValue('id', $this->userId,PDO::PARAM_INT);
        $requestUpdateverif->bindValue('oneclock',$this->oneclock,PDO::PARAM_STR);
        $requestUpdateverif->bindValue('notification', $this->notification,PDO::PARAM_STR);
        return $requestUpdateverif->execute();          
    }
     /**
      * Modification de la date de vérification utile pour l'envoie de mail
      * @return bool
      */
    public function updateDateVerif() {
        $requestmodif = $this->db->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
        $requestmodif->bindValue('newdate',$this->dateverification,PDO::PARAM_STR);
        $requestmodif->bindValue('id',$this->userId,PDO::PARAM_INT);
        return $requestmodif->execute();
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}
