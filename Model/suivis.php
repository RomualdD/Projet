<?php
/**
 * Classe suivis
 * @author romuald
 */
class suivis extends dataBase{
    public $id;
    public $userId;
    public $dateday;
    public $rate;
    public $datefutureverif;
    public $firstpage;
    public $nbPage;
    public $firstDate;
    public $secondDate;
    public $dategraphic;
    public $resultgraphic;
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Méthode permettant d'ajouter le résultat du patient
     * @return bool
     */
    public function addRate() {
        $requestAddRate = $this->db->prepare('INSERT INTO suivis(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
        $requestAddRate->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestAddRate->bindValue('daydate',$this->dateday,PDO::PARAM_STR);
        $requestAddRate->bindValue('result',$this->rate,PDO::PARAM_STR);
        $requestAddRate->bindValue('futureverif', $this->datefutureverif,PDO::PARAM_STR);
        return $requestAddRate->execute();
    }
    /**
     * Méthode qui permet de trouver le résultat de l'utilisateur a une date précise
     * @return array
     */
    public function searchResultByDateverif() {
        $verifresul = array();
        $requestverifresult = $this->db->prepare('SELECT `resultat` FROM `suivis` WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futuredate');
        $requestverifresult->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestverifresult->bindValue('futuredate',$this->datefutureverif,PDO::PARAM_STR);
        if($requestverifresult->execute()) {
            $verifresult = $requestverifresult->fetch(PDO::FETCH_ASSOC);    
        }
        return $verifresult;
    }
    /**
     * Méthode qui modifie le résultat si le résultat est différent de celui qui correspond à celui qui correspond avec la prochaine date
     * @return bool
     */
    public function updateRate() {
        $requestModifRate = $this->db->prepare('UPDATE `suivis` SET `resultat` = :result WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futureverif');
        $requestModifRate->bindValue('result',$this->rate,PDO::PARAM_STR);
        $requestModifRate->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestModifRate->bindValue('futureverif',$this->datefutureverif,PDO::PARAM_STR);
        return $requestModifRate->execute();
    }
    /**
     * Méthode pour trouver la date du jour
     * @return array
     */
    public function searchDateDay() {
        $date = array();
        $resultdate = $this->db->prepare('SELECT `date_du_jour` FROM `suivis` WHERE `id_utilisateur`= :id');
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
        $researchTotal = $this->db->prepare('SELECT COUNT(*) AS total FROM `suivis` WHERE `id_utilisateur` = :id');
        $researchTotal->bindValue('id',$this->userId,PDO::PARAM_INT);
        if($researchTotal->execute()) {   
            $total = $researchTotal->fetch();
        }
        return $total;
    }
    /**
     * Méthode permettant de voir les résultats de l'utilisateur diabétique dans le tableau
     * @return array
     */
    public function getRateDiabeteInArray() {
        $array = array();
        $requestSearchInfo = $this->db->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` WHERE `id_utilisateur` = :id ORDER BY `id` DESC LIMIT :firstpage, :nbpage');
        $requestSearchInfo->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('firstpage',$this->firstpage,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('nbpage', $this->nbPage, PDO::PARAM_INT);
        if($requestSearchInfo->execute()) {
            $array = $requestSearchInfo->fetchAll(PDO::FETCH_ASSOC);            
        }
        return $array;
    }
    /**
     * Méthode permettant de voir les résultats de l'utilisateur sous antivitamine K dans le tableau
     * @return array
     */    
    public function getRateAvkInArray() {
        $array = array();
        $requestSearchInfo = $this->db->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y") AS `date_prochaine_verif` FROM `suivis` WHERE `id_utilisateur` = :id ORDER BY `id` DESC limit :firstpage, :nbpage');
        $requestSearchInfo->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('firstpage',$this->firstpage,PDO::PARAM_INT);
        $requestSearchInfo->bindValue('nbpage', $this->nbPage, PDO::PARAM_INT);
        if($requestSearchInfo->execute()) {
            $array = $requestSearchInfo->fetchAll(PDO::FETCH_ASSOC);            
        }
        return $array;    
    }
    /**
     * Méthode permettant de voir les résultats de l'utilisateur diabétique dans le graphique
     * @return array
     */
    public function getRateDiabeteInGraphic() {
        $graphic = array();
        $requestSearchGraphic = $this->db->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_now`,`resultat` FROM `suivis` WHERE `id_utilisateur` = :id AND `date_du_jour` BETWEEN :firstdate AND :secondedate ORDER BY `date_du_jour`');        
        $requestSearchGraphic->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue(':firstdate',$this->firstDate,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue(':secondedate', $this->secondDate, PDO::PARAM_INT);
        if($requestSearchGraphic->execute()) {
            $graphic = $requestSearchGraphic->fetchAll(PDO::FETCH_ASSOC);
        }
       return $graphic;
    }
    /**
     * Méthode permettant de voir les résultats de l'utilisateur sous antivitamine K dans le graphique
     * @return array
     */       
    public function getRateAvkInGraphic() {
        $graphic = array();
        $requestSearchGraphic = $this->db->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y") AS `date_now`,`resultat` FROM `suivis` WHERE `id_utilisateur` = :id AND `date_du_jour` BETWEEN :firstdate AND :secondedate ORDER BY `date_du_jour` LIMIT 28');
        $requestSearchGraphic->bindValue('id',$this->userId,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue('firstdate',$this->firstDate,PDO::PARAM_INT);
        $requestSearchGraphic->bindValue('secondedate', $this->secondDate, PDO::PARAM_INT);
        if($requestSearchGraphic->execute()) {
            $graphic = $requestSearchGraphic->fetchAll(PDO::FETCH_ASSOC);
        }
       return $graphic;
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}
