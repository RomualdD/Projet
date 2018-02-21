<?php
/**
 * Classe dataBase
 * connexion à la base de données
 */
class dataBase {
    protected $db;
    CONST prefix = 'pbvhfjt_';
    
    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=diavk;charset=utf8', 'project', 'projetdiavk');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        } 
    }
    
    public function __destruct() {
     $this->db = NULL;
    }
}
