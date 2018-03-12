<?php
/**
 * Classe dataBase
 * connexion à la base de données
 */
class dataBase {
    protected $db;
    
    protected function __construct()
    {
        try {
            $this->db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', LOGIN, PASSWORD);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        } 
    }
    
    protected function __destruct() {
     $this->db = NULL;
    }
}
