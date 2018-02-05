<?php
/**
 * Classe medical_followup
 * @author romuald
 */
class suivis extends dataBase{
    public $id = 0;
    public $userId = 0;
    public $dateday = '01/01/1900';
    public $rate = 0;
    public $datefutureverif = '01/01/1900';
    public $firstpage = 0;
    public $nbPage = 0;
    public $firstDate = '01/01/1900';
    public $secondDate = '01/01/1900';
    public $dategraphic = '01/01/1900';
    public $resultgraphic = 0;
    
    public function __construct() {
        parent::__construct();
    }
// -- // Ajout    
    /**
     * Méthode permettant d'ajouter le résultat du patient
     * @return bool
     */
    public function addRate() {
        $requestAddRate = $this->db->prepare('INSERT INTO medical_followup(`userId`, `today_date`, `result`, `next_date_check`) VALUES(:id, :daydate, :result, :futureverif)');
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
        $requestverifresult = $this->db->prepare('SELECT `result` FROM `medical_followup` WHERE `userId` = :id AND `next_date_check` = :futuredate');
        $requestverifresult->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestverifresult->bindValue('futuredate',$this->datefutureverif,PDO::PARAM_STR);
        if($requestverifresult->execute()) {
            $verifresult = $requestverifresult->fetch(PDO::FETCH_ASSOC);    
        }
        return $verifresult;
    }
    /**
     * Méthode pour trouver la date du jour
     * @return array
     */
    public function getDateDay() {
        $date = array();
        $resultdate = $this->db->prepare('SELECT `today_date` FROM `medical_followup` WHERE `userId`= :id');
        $resultdate->bindValue('id',$this->userId,PDO::PARAM_INT);
        if($resultdate->execute()) {
            $date = $resultdate->fetchAll();            
        }
        return $date;
    }
    /**
     * Méthode permet de compter le nombre de suivi de l'utilisateur utile a la pagination
     * @return array
     */
    public function countRate() {
        $total = array();
        $researchTotal = $this->db->prepare('SELECT COUNT(*) AS total FROM `medical_followup` WHERE `userId` = :id');
        $researchTotal->bindValue('id',$this->userId,PDO::PARAM_INT);
        if($researchTotal->execute()) {   
            $total = $researchTotal->fetch();
        }
        return $total;
    }
    /**
     * Méthode permettant de voir les résultats du patient dans le tableau
     * @return array
     */
    public function getRateInArray() {
        $array = array();
        $requestSearchInfo = $this->db->prepare('SELECT CASE WHEN `pathology` = 3 THEN DATE_FORMAT(`today_date`,\'%d/%m/%Y\') ELSE DATE_FORMAT(`today_date`,\'%d/%m/%Y %H:%i\') END AS date_now ,`result`, CASE WHEN `pathology` = 3 THEN DATE_FORMAT(`next_date_check`,\'%d/%m/%Y\') ELSE DATE_FORMAT(`next_date_check`,\'%d/%m/%Y %H:%i\') END AS next_date_check FROM `medical_followup` LEFT JOIN `users` ON `users`.`id` = `userId` WHERE `userId` = :id ORDER BY today_date DESC limit :firstpage, :nbpage');
        $requestSearchInfo->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('firstpage',$this->firstpage,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('nbpage', $this->nbPage, PDO::PARAM_INT);
        if($requestSearchInfo->execute()) {
            $array = $requestSearchInfo->fetchAll(PDO::FETCH_ASSOC);            
        }
        return $array;
    }
    /**
     * Méthode permettant de voir les résultats du patient dans le graphique
     * @return array
     */
    public function getRateInGraphic() {
        $graphic = array();
        $requestSearchGraphic = $this->db->prepare('SELECT CASE WHEN `pathology` = 3 THEN DATE_FORMAT(`today_date`,\'%d/%m/%Y\') ELSE DATE_FORMAT(`today_date`,\'%d/%m/%Y %H:%i\') END AS `date_now`,`result` FROM `medical_followup` LEFT JOIN `users` ON `users`.`id` = `userId` WHERE `userId` = :id AND `today_date` BETWEEN :firstdate AND :secondedate ORDER BY `today_date`');        
        $requestSearchGraphic->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue(':firstdate',$this->firstDate,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue(':secondedate', $this->secondDate, PDO::PARAM_INT);
        if($requestSearchGraphic->execute()) {
            $graphic = $requestSearchGraphic->fetchAll(PDO::FETCH_ASSOC);
        }
       return $graphic;
    }
// -- // Modification    
    /**
     * Méthode qui modifie le résultat si le résultat est différent de celui qui correspond à celui qui correspond avec la prochaine date
     * @return bool
     */
    public function updateRate() {
        $requestModifRate = $this->db->prepare('UPDATE `medical_followup` SET `result` = :result WHERE `userId` = :id AND `next_date_check` = :futureverif');
        $requestModifRate->bindValue('result',$this->rate,PDO::PARAM_STR);
        $requestModifRate->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestModifRate->bindValue('futureverif',$this->datefutureverif,PDO::PARAM_STR);
        return $requestModifRate->execute();
    }    
    public function __destruct() {
        parent::__destruct();
    }
}
