<?php
/**
 * classe pathology
 * @author romuald
 */
class pathology extends dataBase {
    public $id;
    public $name;  
    private $prefix = PREFIX ;  
    
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Méthode permet d'ajouter les pathologies
     * @return bool
     */
    public function addPathology(){
        $addpathology = $this->db->prepare('INSERT INTO `'.$this->prefix.'pathology`(`name`)VALUES(:name)');
        $addpathology->bindValue('name',$this->name,PDO::PARAM_STR);
        return $addpathology->execute();
    }    
    /**
     * Méthode récupère les données des pathology sauf la première qui est égale à NULL (pour les médecins et l'administrateur)
     * @return array
     */
    public function getPathology() {
        $pathology = array();
        $getPathology = $this->db->query('SELECT `id`, `name` FROM '.$this->prefix.'pathology WHERE id != 1');
        if(is_object($getPathology)) {
            $pathology = $getPathology->fetchAll(PDO::FETCH_OBJ);
        }
        return $pathology;
    }
    
    public function __destruct()
    {
        parent::__destruct();
    }
}
