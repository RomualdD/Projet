<?php
/**
 * Classe des contacts des personnes
 * @author romuald
 */
class follow extends dataBase{
    public $id;
    public $follow_from;
    public $follow_to;
    public $confirm;
    public $name;
    public $firstname;
    public $username;
    public $firstDate;
    public $secondDate;
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Méthode qui renvoie les demandes avec les informations du demandeur
     * @return array
     */
    public function getFollowQuest() {
        $follow = array();
        $requestfollow = $this->db->prepare('SELECT `follow_from`, `follow_date`,`nom`,`prenom`,`nom_utilisateur` FROM `follow` LEFT JOIN `utilisateurs` ON `id`=`follow_from` WHERE `follow_to` = :id AND `follow_confirm` = :confirm');
        $requestfollow->bindValue('id',$this->id,PDO::PARAM_INT);
        $requestfollow->bindValue('confirm','0',PDO::PARAM_INT);
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
        $requestadd = $this->db->prepare('SELECT COUNT(*) AS nbfollow FROM `follow` WHERE `follow_from` = :id AND `follow_to` = :id_to');
        $requestadd->bindValue(':id',$this->id,PDO::PARAM_INT);
        $requestadd->bindValue(':id_to', $this->follow_to, PDO::PARAM_INT);
        if($requestadd->execute()) {
            $alreadyfollow = $requestadd->fetchColumn();                    
        }
        return $alreadyfollow;
        $requestadd->closeCursor(); // Fin de requete
    }
    /**
     * Méthode qui permet d'enregistrer la demande de suivi
     */
    public function addFollow() {
        $requestadd = $this->db->prepare('INSERT INTO `follow`(`follow_from`, `follow_to`, `follow_confirm`, `follow_date`)VALUES(:id,:id_to,:confirm,NOW())');
        $requestadd->bindValue('id',$this->follow_from,PDO::PARAM_INT);
        $requestadd->bindValue('id_to',$this->follow_to,PDO::PARAM_INT);
        $requestadd->bindValue('confirm','0',PDO::PARAM_INT);
        return $requestadd->execute();
    }
    /**
     * Méthode qui permet à l'utilisateur d'accpter la demande de suivi
     * @return bool
     */
    public function updateAddFollow() {
        $acceptFollow = $this->db->prepare('UPDATE `follow` SET `follow_confirm` = :confirm WHERE `follow_from` = :member AND `follow_to` = :id');
        $acceptFollow->bindValue(':confirm','1',PDO::PARAM_INT);
        $acceptFollow->bindValue(':member',$this->follow_from, PDO::PARAM_INT);
        $acceptFollow->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $acceptFollow->execute();
    }
    /**
     * Méthode qui permet à l'utilisateur de refuser la demande
     * @return bool
     */
    public function deleteFollow() {
        $requestrefuse = $this->db->prepare('DELETE FROM `follow` WHERE `follow_from` = :member AND `follow_to` = :id');
        $requestrefuse->bindValue(':member',$this->follow_from,PDO::PARAM_INT);
        $requestrefuse->bindValue(':id',$this->id,PDO::PARAM_INT);
        return $requestrefuse->execute();
    }
    /**
     * Méthode qui cherche les utilisateurs que le médecin suit
     * @return array
     */
    public function searchPatientByDoctor() {
        $follow = array();
        $requestfollow = $this->db->prepare('SELECT DISTINCT `follow_from` = :id OR `follow_to` = :id AS `follow_id`, `nom`, `prenom`, `nom_utilisateur`,`role` FROM `follow` LEFT JOIN `utilisateurs` ON `id` = `follow_from` OR `id` = `follow_to` WHERE (`follow_from` = :id OR `follow_to` = :id) AND `follow_confirm` = :confirm AND `role` = 1 ORDER BY `nom`');    
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
        $requestsearch = $this->db->prepare('SELECT DISTINCT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS date_now, `resultat` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm AND `date_du_jour` BETWEEN :firstdate AND :secondedate ');  
        $requestsearch->bindValue('idpatient',$this->follow_to, PDO::PARAM_STR);
        $requestsearch->bindValue('id',$this->id, PDO::PARAM_INT);
        $requestsearch->bindValue('confirm','1', PDO::PARAM_STR);
        $requestsearch->bindValue('role','1', PDO::PARAM_STR);
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
        $requestsearcharray = $this->db->prepare('SELECT DISTINCT `date_du_jour`,DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_now`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `nom_utilisateur` = :user AND `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm ORDER BY `date_du_jour` DESC');
        $requestsearcharray->bindValue('id',$this->id, PDO::PARAM_INT);
        $requestsearcharray->bindValue('confirm','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue('role','1', PDO::PARAM_STR);
        $requestsearcharray->bindValue('idpatient',$this->follow_to, PDO::PARAM_STR);
        $requestsearcharray->bindValue('user',$this->username, PDO::PARAM_STR);
        if($requestsearcharray->execute()) {
            $rateArray = $requestsearcharray->fetchAll(PDO::FETCH_ASSOC);
        }
        return $rateArray;
    }
    /**
     * Méthode qui vérifie si il y'a déjà un suivi
     * 
     */
    public function getFollowAlready() {
        $verif = array();
        $verifFollow = $this->db->prepare('SELECT `follow_confirm` FROM `follow` WHERE (`follow_to` = :id_to OR `follow_from` = :id_to) AND (`follow_to` = :id_from OR `follow_from` = :id_from)');
        $verifFollow->bindValue('id_to',$this->follow_to,PDO::PARAM_INT);
        $verifFollow->bindValue('id_from', $this->follow_from,PDO::PARAM_INT);
        if($verifFollow->execute()) {
            $verif = $verifFollow->fetchColumn();        
        }
        return $verif;
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}
