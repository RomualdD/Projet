<?php
/**
 * Classe des contacts des personnes
 * @author romuald
 */
class follow extends dataBase {
    public $id;
    public $follow_from;
    public $follow_to;
    public $confirm;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getFollowQuest() {
        $nbfollow = array();
        $requestfollow = $this->db->query('SELECT `follow_from`, `follow_date`,`nom`,`prenom`,`nom_utilisateur` FROM `follow` LEFT JOIN `utilisateurs` ON `id`=`follow_from` WHERE `follow_to` = '.$this->id.' AND `follow_confirm` = 0');
        if(is_object($requestfollow)) {
            $nbfollow = $requestfollow->fetch();
        } 
        return $nbfollow;
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}
