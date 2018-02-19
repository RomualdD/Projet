<?php
/**
 * Classe des contacts des personnes
 * @author romuald
 */
class follow extends dataBase{
    public $id = 0;
    public $follow_from = 0;
    public $follow_to = 0;
    public $confirm = '0';
    public $name = '';
    public $firstname = '';
    public $username = '';
    public $firstDate = '01/01/1900';
    public $secondDate = '01/01/1900';
    
    public function __construct() {
        parent::__construct();
    }
// -- // Ajout    
    /**
     * Méthode qui permet d'enregistrer la demande de suivi
     * @return bool
     */
    public function addFollow() {
        $requestadd = $this->db->prepare('INSERT INTO `pbvhfjt_follow`(`id_pbvhfjt_users`, `id_pbvhfjt_users_1`, `follow_confirm`, `follow_date`)VALUES(:id,:id_to,:confirm,NOW())');
        $requestadd->bindValue('id',$this->follow_from,PDO::PARAM_INT);
        $requestadd->bindValue('id_to',$this->follow_to,PDO::PARAM_INT);
        $requestadd->bindValue('confirm',$this->confirm,PDO::PARAM_INT);
        return $requestadd->execute();
    } 
// -- // Sélection    
    /**
     * Méthode qui renvoie les demandes avec les informations du demandeur
     * @return array
     */
    public function getFollowQuest() {
        $follow = array();
        $requestfollow = $this->db->prepare('SELECT `id_pbvhfjt_users`, `follow_date`,`lastname`,`firstname`,`username` FROM `pbvhfjt_follow` LEFT JOIN `pbvhfjt_users` ON `pbvhfjt_users`.`id`=`id_pbvhfjt_users` WHERE `id_pbvhfjt_users_1` = :id AND `follow_confirm` = :confirm');
        $requestfollow->bindValue('id',$this->id,PDO::PARAM_INT);
        $requestfollow->bindValue('confirm',$this->confirm,PDO::PARAM_INT);
        if($requestfollow->execute()) {
            $follow = $requestfollow->fetchAll(PDO::FETCH_ASSOC);
        } 
        return $follow;
    }
    /**
     * Méthode qui vérifie s'il n'y a pas déjà un suivi
     * @return array
     */
    public function getNbFollow() {
        $alreadyfollow = array();
        $requestadd = $this->db->prepare('SELECT COUNT(*) AS nbfollow FROM `pbvhfjt_follow` WHERE `id_pbvhfjt_users` = :id AND `id_pbvhfjt_users_1` = :id_to');
        $requestadd->bindValue(':id',$this->id,PDO::PARAM_INT);
        $requestadd->bindValue(':id_to', $this->follow_to, PDO::PARAM_INT);
        if($requestadd->execute()) {
            $alreadyfollow = $requestadd->fetchColumn();                    
        }
        return $alreadyfollow;
        $requestadd->closeCursor(); // Fin de requete
    }
    /**
     * Méthode qui cherche les utilisateurs que le médecin suit
     * @return array
     */
    public function getPatientByDoctor() {
        $follow = array();
        $requestfollow = $this->db->prepare('SELECT DISTINCT `id_pbvhfjt_users` = :id OR `id_pbvhfjt_users_1` = :id AS `follow_id`, `lastname`, `firstname`, `username`,`role` FROM `pbvhfjt_follow` LEFT JOIN `pbvhfjt_users` ON `pbvhfjt_users`.`id` = `id_pbvhfjt_users` OR `pbvhfjt_users`.`id` = `id_pbvhfjt_users_1` WHERE (`id_pbvhfjt_users` = :id OR `id_pbvhfjt_users_1` = :id) AND `follow_confirm` = :confirm AND `role` = 1 ORDER BY `lastname`');    
        $requestfollow->bindValue('confirm','1', PDO::PARAM_INT);
        $requestfollow->bindValue('id',$this->id, PDO::PARAM_INT);
        if($requestfollow->execute()) {
            $follow = $requestfollow->fetchAll(PDO::FETCH_ASSOC);
        }
        return $follow;
    }
    /**
     * Méthode permet de voir le graphique de l'utilisateur tout en vérifiant si l'utilisateur entré est bien suivi
     * @return array
     */
    public function getRateGraphicForDoctor() {
        $rateGraphic = array();
        $requestsearch = $this->db->prepare('SELECT DISTINCT CASE WHEN `pathology` = 3 THEN DATE_FORMAT(`today_date`,\'%d/%m/%Y\') ELSE DATE_FORMAT(`today_date`,\'%d/%m/%Y %H:%i\') END AS `date_now`, `result` FROM `pbvhfjt_medical_followup` LEFT JOIN `pbvhfjt_users` ON `pbvhfjt_medical_followup`.`id_pbvhfjt_users` = :idpatient LEFT JOIN `pbvhfjt_follow` ON `role` = :role WHERE `username` = :user AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :id OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :id) AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :idpatient OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :idpatient) AND follow_confirm = :confirm AND `today_date` BETWEEN :firstdate AND :secondedate');  
        $requestsearch->bindValue('idpatient',$this->follow_to, PDO::PARAM_STR);
        $requestsearch->bindValue('id',$this->id, PDO::PARAM_INT);
        $requestsearch->bindValue('confirm','1', PDO::PARAM_STR);
        $requestsearch->bindValue('role','1', PDO::PARAM_STR);
        $requestsearch->bindValue('user',$this->username, PDO::PARAM_STR);
        $requestsearch->bindValue('firstdate',$this->firstDate, PDO::PARAM_STR);
        $requestsearch->bindValue('secondedate',$this->secondDate, PDO::PARAM_STR);
        if($requestsearch->execute()) {
            $rateGraphic = $requestsearch->fetchAll(PDO::FETCH_ASSOC);
        }
        return $rateGraphic;
    }
    /**
     * Méthode permet de voir le tableau de l'utilisateur tout en vérifiant si l'utilisateur entré est bien suivi
     * @return array
     */    
    public function getRateArrayForDoctor() {
        $rateArray = array();
        $requestsearcharray = $this->db->prepare('SELECT DISTINCT `today_date`,CASE WHEN `pathology` = 3 THEN DATE_FORMAT(`today_date`,\'%d/%m/%Y\') ELSE DATE_FORMAT(`today_date`,\'%d/%m/%Y %H:%i\') END AS `date_now`, `result`, CASE WHEN pathology = 3 THEN DATE_FORMAT(`next_date_check`,\'%d/%m/%Y\') ELSE DATE_FORMAT(`next_date_check`,\'%d/%m/%Y %H:%i\') END AS `next_date_check` FROM `pbvhfjt_medical_followup` LEFT JOIN `pbvhfjt_users` ON `pbvhfjt_medical_followup`.`id_pbvhfjt_users` = :idpatient LEFT JOIN `pbvhfjt_follow` ON `role` = :role WHERE `username` = :user AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :id OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :id) AND (`pbvhfjt_follow`.`id_pbvhfjt_users` = :idpatient OR `pbvhfjt_follow`.`id_pbvhfjt_users_1` = :idpatient) AND follow_confirm = :confirm AND `today_date` BETWEEN :firstdate AND :secondedate ORDER BY `today_date` DESC');
        $requestsearcharray->bindValue('id',$this->id, PDO::PARAM_INT);
        $requestsearcharray->bindValue('confirm','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue('role','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue('idpatient',$this->follow_to, PDO::PARAM_STR);
        $requestsearcharray->bindValue('user',$this->username, PDO::PARAM_STR);
        $requestsearcharray->bindValue('firstdate',$this->firstDate, PDO::PARAM_STR);
        $requestsearcharray->bindValue('secondedate',$this->secondDate, PDO::PARAM_STR);
        if($requestsearcharray->execute()) {
            $rateArray = $requestsearcharray->fetchAll(PDO::FETCH_ASSOC);
        }
        return $rateArray;
    }
    /**
     * Méthode qui vérifie si il y'a déjà un suivi
     * @return array
     */
    public function getFollowAlready() {
        $verif = array();
        $verifFollow = $this->db->prepare('SELECT `follow_confirm` FROM `pbvhfjt_follow` WHERE (`id_pbvhfjt_users_1` = :id_to OR `id_pbvhfjt_users` = :id_to) AND (`id_pbvhfjt_users_1` = :id_from OR `id_pbvhfjt_users` = :id_from)');
        $verifFollow->bindValue('id_to',$this->follow_to,PDO::PARAM_INT);
        $verifFollow->bindValue('id_from', $this->follow_from,PDO::PARAM_INT);
        if($verifFollow->execute()) {
            $verif = $verifFollow->fetchColumn();        
        }
        return $verif;
    }
// -- // Modification     
    /**
     * Méthode qui permet à l'utilisateur d'accpter la demande de suivi
     * @return bool
     */
    public function updateAddFollow() {
        $acceptFollow = $this->db->prepare('UPDATE `pbvhfjt_follow` SET `follow_confirm` = :confirm WHERE `id_pbvhfjt_users` = :member AND `id_pbvhfjt_users_1` = :id');
        $acceptFollow->bindValue(':confirm','1',PDO::PARAM_INT);
        $acceptFollow->bindValue(':member',$this->follow_from, PDO::PARAM_INT);
        $acceptFollow->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $acceptFollow->execute();
    }    
// -- // Suppression   
    /**
     * Méthode qui permet à l'utilisateur de refuser la demande
     * @return bool
     */
    public function deleteFollow() {
        $requestrefuse = $this->db->prepare('DELETE FROM `pbvhfjt_follow` WHERE `id_pbvhfjt_users` = :member AND `id_pbvhfjt_users_1` = :id');
        $requestrefuse->bindValue(':member',$this->follow_from,PDO::PARAM_INT);
        $requestrefuse->bindValue(':id',$this->id,PDO::PARAM_INT);
        return $requestrefuse->execute();
    }
    
    public function deleteFollowById() {
        $requestdelete =  $this->db->prepare('DELETE FROM `pbvhfjt_follow` WHERE `id_pbvhfjt_users` = :id OR `id_pbvhfjt_users_1` = :id');
        $requestdelete->bindValue(':id',$this->id,PDO::PARAM_INT);
        return $requestdelete->execute();
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}
