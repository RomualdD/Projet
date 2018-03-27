<?php
/**
 * Classe des contacts des personnes
 * @author romuald
 */
class follow extends dataBase{
    public $id = 0;
    public $from = 0;
    public $to = 0;
    public $confirm = '0';
    public $name = '';
    public $firstname = '';
    public $username = '';
    public $firstDate = '01/01/1900';
    public $secondDate = '01/01/1900';
    private $prefix = PREFIX ;
    
    public function __construct() {
        parent::__construct();
    }
// -- // Ajout    
    /**
     * Méthode qui permet d'enregistrer la demande de suivi
     * @return bool
     */
    public function addFollow() {
        $requestadd = $this->db->prepare('INSERT INTO `'.$this->prefix.'follow`(`id_'.$this->prefix.'users`, `id_'.$this->prefix.'users_1`, `confirm`, `date`)VALUES(:id,:id_to,:confirm,NOW())');
        $requestadd->bindValue('id',$this->from,PDO::PARAM_INT);
        $requestadd->bindValue('id_to',$this->to,PDO::PARAM_INT);
        $requestadd->bindValue('confirm',$this->confirm,PDO::PARAM_STR);
        return $requestadd->execute();
    } 
// -- // Sélection
    /**
     * Méthode qui compte le nombre de demande
     * @return array
     */
    public function getnbFollowQuest() {
        $nbFollow = array();
        $requestfollow = $this->db->prepare('SELECT COUNT(`'.$this->prefix.'follow`.`id`) AS nbFollow FROM `'.$this->prefix.'follow` WHERE `id_'.$this->prefix.'users_1` = :id AND `confirm` = :confirm');
        $requestfollow->bindValue('id',$this->id,PDO::PARAM_INT);
        $requestfollow->bindValue('confirm',$this->confirm,PDO::PARAM_STR);
        if($requestfollow->execute()) {
            $nbFollow = $requestfollow->fetch(PDO::FETCH_OBJ);
        } 
        return $nbFollow;
    }    
    /**
     * Méthode qui renvoie les demandes avec les informations du demandeur
     * @return array
     */
    public function getFollowQuest() {
        $follow = array();
        $requestfollow = $this->db->prepare('SELECT `id_'.$this->prefix.'users` AS `to`, `date`,`lastname`,`firstname`,`username` FROM `'.$this->prefix.'follow` LEFT JOIN `'.$this->prefix.'users` ON `'.$this->prefix.'users`.`id`=`id_'.$this->prefix.'users` WHERE `id_'.$this->prefix.'users_1` = :id AND `confirm` = :confirm');
        $requestfollow->bindValue('id',$this->to,PDO::PARAM_INT);
        $requestfollow->bindValue('confirm',$this->confirm,PDO::PARAM_STR);
        if($requestfollow->execute()) {
            $follow = $requestfollow->fetchAll(PDO::FETCH_OBJ);
        } 
        return $follow;
    }
    /**
     * Méthode qui cherche les utilisateurs que le médecin suit
     * @return array
     */
    public function getPatientByDoctor() {
        $follow = array();
        $requestfollow = $this->db->prepare('SELECT DISTINCT (`id_'.$this->prefix.'users`'
                . ' OR `id_'.$this->prefix.'users_1`) AS `id`,'
                . ' `lastname`, `firstname`, `username`,`id_pbvhfjt_role` AS `role`'
                . ' FROM `'.$this->prefix.'follow`'
                . ' LEFT JOIN `'.$this->prefix.'users`'
                . ' ON `'.$this->prefix.'users`.`id` = `id_'.$this->prefix.'users`'
                . ' OR `'.$this->prefix.'users`.`id` = `id_'.$this->prefix.'users_1`'
                . ' WHERE (`id_'.$this->prefix.'users` = :id OR `id_'.$this->prefix.'users_1` = :id)'
                . ' AND `confirm` = :confirm'
                . ' AND `id_pbvhfjt_role` = 2 ORDER BY `lastname`');    
        $requestfollow->bindValue('confirm','1', PDO::PARAM_STR);
        $requestfollow->bindValue('id',$this->id, PDO::PARAM_INT);
        if($requestfollow->execute()) {
            $follow = $requestfollow->fetchAll(PDO::FETCH_OBJ);
        }
        return $follow;
    }
    /**
     * Méthode permet de voir le graphique de l'utilisateur tout en vérifiant si l'utilisateur entré est bien suivi
     * @return array
     */
    public function getRateGraphicForDoctor() {
        $rateGraphic = array();
        $requestsearch = $this->db->prepare('SELECT DISTINCT '
                . 'CASE WHEN `id_pbvhfjt_pathology` = 2 '
                . 'THEN DATE_FORMAT(`current_date`,\'%d/%m/%Y %H:%i\') '
                . 'ELSE DATE_FORMAT(`current_date`,\'%d/%m/%Y\') END AS `date_now`,'
                . ' `result`'
                . ' FROM `'.$this->prefix.'medical_followup`LEFT JOIN `'.$this->prefix.'users`'
                . ' ON `pbvhfjt_medical_followup`.`id_pbvhfjt_users` = `pbvhfjt_users`.`id` '
                . 'LEFT JOIN `'.$this->prefix.'follow`'
                . ' ON (`pbvhfjt_users`.`id` = `pbvhfjt_follow`.`id_pbvhfjt_users`'
                . ' OR `pbvhfjt_users`.`id` = `pbvhfjt_follow`.`id_pbvhfjt_users_1`) '
                . 'WHERE `username` = :username'
                . ' AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :idpatient'
                . ' OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :idpatient)'
                . ' AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :id'
                . ' OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :id)'
                . ' AND confirm = :confirm AND `id_pbvhfjt_role` = :role'
                . ' AND `current_date` BETWEEN :firstdate AND :secondedate');  
        $requestsearch->bindValue('id',$this->id, PDO::PARAM_INT);
        $requestsearch->bindValue('confirm','1', PDO::PARAM_STR);
        $requestsearch->bindValue('role','2', PDO::PARAM_INT);
        $requestsearch->bindValue('idpatient',$this->to, PDO::PARAM_INT);
        $requestsearch->bindValue('username',$this->username, PDO::PARAM_STR);
        $requestsearch->bindValue('firstdate',$this->firstDate, PDO::PARAM_STR);
        $requestsearch->bindValue('secondedate',$this->secondDate, PDO::PARAM_STR);
        if($requestsearch->execute()) {
            $rateGraphic = $requestsearch->fetchAll(PDO::FETCH_OBJ);
        }
        return $rateGraphic;
    }
    /**
     * Méthode permet de voir le tableau de l'utilisateur tout en vérifiant si l'utilisateur entré est bien suivi
     * @return array
     */    
    public function getRateArrayForDoctor() {
        $rateArray = array();
        $requestsearcharray = $this->db->prepare('SELECT DISTINCT `current_date`,'
                . 'CASE WHEN `id_pbvhfjt_pathology` = 2 THEN DATE_FORMAT(`current_date`,\'%d/%m/%Y %H:%i\')'
                . ' ELSE DATE_FORMAT(`current_date`,\'%d/%m/%Y\') END AS `date_now`, '
                . '`result`, '
                . 'CASE WHEN `id_pbvhfjt_pathology` = 2 THEN DATE_FORMAT(`next_date_check`,\'%d/%m/%Y %H:%i\')'
                . ' ELSE DATE_FORMAT(`next_date_check`,\'%d/%m/%Y\') END AS `next_date_check` '
                . 'FROM `'.$this->prefix.'medical_followup` LEFT JOIN `'.$this->prefix.'users`'
                . ' ON `pbvhfjt_medical_followup`.`id_pbvhfjt_users` = `pbvhfjt_users`.`id` '
                . 'LEFT JOIN `'.$this->prefix.'follow`'
                . ' ON (`pbvhfjt_users`.`id` = `pbvhfjt_follow`.`id_pbvhfjt_users`'
                . ' OR `pbvhfjt_users`.`id` = `pbvhfjt_follow`.`id_pbvhfjt_users_1`) '
                . 'WHERE `username` = :username'
                . ' AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :idpatient'
                . ' OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :idpatient)'
                . ' AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :id'
                . ' OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :id)'
                . ' AND confirm = :confirm AND `id_pbvhfjt_role` = :role'
                . ' AND `current_date` BETWEEN :firstdate AND :secondedate'
                . ' ORDER BY `current_date` DESC');
        $requestsearcharray->bindValue('id',$this->id, PDO::PARAM_INT);
        $requestsearcharray->bindValue('confirm','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue('role','2', PDO::PARAM_INT);
        $requestsearcharray->bindValue('idpatient',$this->to, PDO::PARAM_INT);
        $requestsearcharray->bindValue('username',$this->username, PDO::PARAM_STR);
        $requestsearcharray->bindValue('firstdate',$this->firstDate, PDO::PARAM_STR);
        $requestsearcharray->bindValue('secondedate',$this->secondDate, PDO::PARAM_STR);
        if($requestsearcharray->execute()) {
            $rateArray = $requestsearcharray->fetchAll(PDO::FETCH_OBJ);
        }
        return $rateArray;
    }
    /**
     * Méthode qui vérifie si il y'a déjà un suivi
     * @return array
     */
    public function getFollowAlready() {
        $verif = array();
        $verifFollow = $this->db->prepare('SELECT `confirm` FROM `'.$this->prefix.'follow`'
                . ' WHERE (`id_'.$this->prefix.'users_1` = :id_to'
                . ' OR `id_'.$this->prefix.'users` = :id_to)'
                . ' AND (`id_'.$this->prefix.'users_1` = :id_from'
                . ' OR `id_'.$this->prefix.'users` = :id_from)');
        $verifFollow->bindValue('id_to',$this->to,PDO::PARAM_INT);
        $verifFollow->bindValue('id_from', $this->from,PDO::PARAM_INT);
        if($verifFollow->execute()) {
            $verif = $verifFollow->fetch(PDO::FETCH_COLUMN,0);        
        }
        return $verif;
    }
// -- // Modification     
    /**
     * Méthode qui permet à l'utilisateur d'accpter la demande de suivi
     * @return bool
     */
    public function updateAddFollow() {
        $acceptFollow = $this->db->prepare('UPDATE `'.$this->prefix.'follow` SET `confirm` = :confirm WHERE (`id_'.$this->prefix.'users` = :member OR `id_'.$this->prefix.'users_1` = :member) AND (`id_'.$this->prefix.'users_1` = :id OR `id_'.$this->prefix.'users` = :id)');
        $acceptFollow->bindValue('confirm','1',PDO::PARAM_STR);
        $acceptFollow->bindValue('member',$this->from, PDO::PARAM_INT);
        $acceptFollow->bindValue('id', $this->to, PDO::PARAM_INT);
        return $acceptFollow->execute();
    }    
// -- // Suppression   
    /**
     * Méthode qui permet à l'utilisateur de refuser la demande
     * @return bool
     */
    public function deleteFollow() {
        $requestrefuse = $this->db->prepare('DELETE FROM `'.$this->prefix.'follow` WHERE `id_'.$this->prefix.'users` = :member AND `id_'.$this->prefix.'users_1` = :id');
        $requestrefuse->bindValue('member',$this->from,PDO::PARAM_INT);
        $requestrefuse->bindValue('id',$this->id,PDO::PARAM_INT);
        return $requestrefuse->execute();
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}
