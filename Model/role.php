<?php
/**
 * Classe des roles
 * @author romuald
 */
class role extends dataBase{
    public $id;
    public $name;
    private $prefix = PREFIX ;
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Méthode permet d'ajouter les pathologies
     * @return bool
     */
    public function addRole(){
        $addpathology = $this->db->prepare('INSERT INTO `'.$this->prefix.'role`(`name`) VALUES (:name)');
        $addpathology->bindValue('name',$this->name,PDO::PARAM_STR);
        return $addpathology->execute();
    }    
    /**
     * Méthode récupère les données des pathology sauf la première qui est égale à l'administrateur
     * @return array
     */
    public function getRole() {
        $role = array();
        $getRole = $this->db->query('SELECT `id`, `name` FROM '.$this->prefix.'role WHERE id != 1 ORDER BY `name`');
        if(is_object($getRole)) {
            $role = $getRole->fetchAll(PDO::FETCH_OBJ);
        }
        return $role;
    }
    
    public function __destruct() {
        parent::__construct();
    }
}
