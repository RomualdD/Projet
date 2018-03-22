<?php
/**
 * Classe de la table medical_followup
 */
class suivis extends dataBase{
    public $id = 0;
    public $userId = 0;
    public $dateday = '01/01/1900';
    public $rate = 0;
    public $datefutureverif = '01/01/1900';
    public $offset = 0;
    public $nbPage = 0;
    public $firstDate = '01/01/1900';
    public $secondDate = '01/01/1900';
    public $dategraphic = '01/01/1900';
    public $resultgraphic = 0;
    private $prefix = PREFIX ;
    
    public function __construct() {
        parent::__construct();
    }
// -- // Ajout    
    /**
     * Méthode permettant d'ajouter le résultat du patient
     * @return bool
     */
    public function addRate() {
        $requestAddRate = $this->db->prepare('INSERT INTO `'.$this->prefix.'medical_followup`(`id_'.$this->prefix.'users`, `current_date`, `result`, `next_date_check`) VALUES(:id, :daydate, :result, :futureverif)');
        $requestAddRate->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestAddRate->bindValue('daydate',$this->dateday,PDO::PARAM_STR);
        $requestAddRate->bindValue('result',$this->rate,PDO::PARAM_STR);
        $requestAddRate->bindValue('futureverif', $this->datefutureverif,PDO::PARAM_STR);
        return $requestAddRate->execute();
    }
// -- // Sélection    
    /**
     * Méthode qui permet de trouver le résultat de l'utilisateur a une date précise
     * @return array
     */
    public function getResultByDateverif() {
        $verifresul = array();
        $requestverifresult = $this->db->prepare('SELECT `result` FROM `'.$this->prefix.'medical_followup` WHERE `id_'.$this->prefix.'users` = :id AND `next_date_check` = :futuredate');
        $requestverifresult->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestverifresult->bindValue('futuredate',$this->datefutureverif,PDO::PARAM_STR);
        if($requestverifresult->execute()) {
            $verifresult = $requestverifresult->fetch(PDO::FETCH_OBJ);    
        }
        return $verifresult;
    }
    /**
     * Méthode pour trouver la date du jour
     * @return array
     */
    public function getDateDay() {
        $date = array();
        $resultdate = $this->db->prepare('SELECT `current_date` FROM `'.$this->prefix.'verification` WHERE `id_'.$this->prefix.'users`= :id');
        $resultdate->bindValue('id',$this->userId,PDO::PARAM_INT);
        if($resultdate->execute()) {
            $date = $resultdate->fetchAll(PDO::FETCH_OBJ);            
        }
        return $date;
    }
    /**
     * Méthode permet de compter le nombre de suivi de l'utilisateur utile a la pagination
     * @return array
     */
    public function countRate() {
        $total = array();
        $researchTotal = $this->db->prepare('SELECT COUNT(*) AS total FROM `'.$this->prefix.'medical_followup` WHERE `id_'.$this->prefix.'users` = :id');
        $researchTotal->bindValue('id',$this->userId,PDO::PARAM_INT);
        if($researchTotal->execute()) {   
            $total = $researchTotal->fetch(PDO::FETCH_OBJ);
        }
        return $total;
    }
    /**
     * Méthode permettant de voir les résultats du patient dans le tableau
     * @return array
     */
    public function getRateInArray() {
        $array = array();
        $requestSearchInfo = $this->db->prepare('SELECT CASE WHEN `id_'.$this->prefix.'pathology` = 2 THEN DATE_FORMAT(`current_date`,\'%d/%m/%Y %H:%i\') ELSE DATE_FORMAT(`current_date`,\'%d/%m/%Y\') END AS date_now ,`result`, CASE WHEN `id_'.$this->prefix.'pathology` = 2 THEN DATE_FORMAT(`next_date_check`,\'%d/%m/%Y %H:%i\') ELSE DATE_FORMAT(`next_date_check`,\'%d/%m/%Y\') END AS next_date_check FROM `'.$this->prefix.'medical_followup` LEFT JOIN `'.$this->prefix.'users` ON `'.$this->prefix.'users`.`id` = `id_'.$this->prefix.'users` WHERE `id_'.$this->prefix.'users` = :id ORDER BY date_now DESC LIMIT 10 OFFSET :offset');
        $requestSearchInfo->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('offset',$this->offset,PDO::PARAM_INT);
        if($requestSearchInfo->execute()) {
            $array = $requestSearchInfo->fetchAll(PDO::FETCH_OBJ);            
        }
        return $array;
    }
    /**
     * Méthode permettant de voir les résultats du patient dans le graphique
     * @return array
     */
    public function getRateInGraphic() {
        $graphic = array();
        $requestSearchGraphic = $this->db->prepare('SELECT CASE WHEN `id_'.$this->prefix.'pathology` = 2 THEN DATE_FORMAT(`current_date`,\'%d/%m/%Y %H:%i\') ELSE DATE_FORMAT(`current_date`,\'%d/%m/%Y\') END AS `date_now`,`result` FROM `'.$this->prefix.'medical_followup` LEFT JOIN `'.$this->prefix.'users` ON `'.$this->prefix.'users`.`id` = `id_'.$this->prefix.'users` WHERE `id_'.$this->prefix.'users` = :id AND `current_date` BETWEEN :firstdate AND :secondedate ORDER BY `current_date`');        
        $requestSearchGraphic->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue('firstdate',$this->firstDate,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue('secondedate', $this->secondDate, PDO::PARAM_INT);
        if($requestSearchGraphic->execute()) {
            $graphic = $requestSearchGraphic->fetchAll(PDO::FETCH_OBJ);
        }
       return $graphic;
    }
// -- // Modification    
    /**
     * Méthode qui modifie le résultat si le résultat est différent de celui qui correspond à celui qui correspond avec la prochaine date
     * @return bool
     */
    public function updateRate() {
        $requestModifRate = $this->db->prepare('UPDATE `'.$this->prefix.'medical_followup` SET `result` = :result WHERE `id_'.$this->prefix.'users` = :id AND `next_date_check` = :futureverif');
        $requestModifRate->bindValue('result',$this->rate,PDO::PARAM_STR);
        $requestModifRate->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestModifRate->bindValue('futureverif',$this->datefutureverif,PDO::PARAM_STR);
        return $requestModifRate->execute();
    }    
    /**
     * Méthode supprime les suivis
     * @return bool
     */
    public function deleteRate() {
        $requestdelete =  $this->db->prepare('DELETE FROM `'.$this->prefix.'medical_followup` WHERE `id_'.$this->prefix.'users` = :id');
        $requestdelete->bindValue('id',$this->id,PDO::PARAM_INT);
        return $requestdelete->execute();
    }
    public function __destruct() {
        parent::__destruct();
    }
}
