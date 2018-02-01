<?php
/**
 * Classe des rendez-vous
 * Visualisation dans la page information
 */
class appointments extends dataBase{
    public $id = 0;
    public $userId = 0;
    public $nameappointment = '';
    public $dayappointment = '01/01/1900';
    public $hourappointment = '00:00';
    public $infosappointment = '';
    public $remarqueappointment = '';
    public $newdayappointment = '01/01/1900';
    public $newhourappointment = '00:00';
    public $newnameappointment = '';
    public $newinfoappointment = '';

    public function __construct() {
        parent::__construct();
    }
// -- // Ajout     
    /**
     * Méthode pour ajouter une remarque d'un rendez-vous
     */
    public function addRemarque() {
        $addremarqueappointment = $this->db->prepare('UPDATE `rendez_vous` SET `note` = :remarque WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos ');
        $addremarqueappointment->bindValue(':remarque', $this->remarqueappointment, PDO::PARAM_STR);   
        $addremarqueappointment->bindValue(':name',$this->nameappointment,PDO::PARAM_STR);
        $addremarqueappointment->bindValue(':hour',$this->hourappointment,PDO::PARAM_STR);
        $addremarqueappointment->bindValue(':infos',$this->infosappointment,PDO::PARAM_STR);   
        return $addremarqueappointment->execute();
    }
    /**
     * Méthode qui permet à l'utilisateur d'ajouter un rendez-vous
     */
    public function addAppointment() {
        $requestappointment = $this->db->prepare('INSERT INTO `rendez_vous`(`id_utilisateur`,`nom_rendez_vous`, `date_rendez_vous`, `heure_rendez_vous`, `infos_complementaire`) VALUES(:id,:name, :date, :hour, :information)');
        $requestappointment->bindValue('id',$this->userId, PDO::PARAM_INT);
        $requestappointment->bindValue('name',$this->nameappointment,PDO::PARAM_STR);
        $requestappointment->bindValue('date',$this->dayappointment,PDO::PARAM_STR);
        $requestappointment->bindValue('hour',$this->hourappointment,PDO::PARAM_STR);
        $requestappointment->bindValue('information',$this->informationappointment,PDO::PARAM_STR);
        return $requestappointment->execute();
    }
// -- // Sélection    
    /**
     * Méthode qui permet de vérifier si l'utilisateur a déjà un rendez-vous à la même heure
     */
    public function getVerifInformation() {
        $verifappointment = array();
        $searchappointment = $this->db->query('SELECT `date_rendez_vous` FROM `rendez_vous` WHERE `date_rendez_vous` = \''.$this->dayappointment.'\' AND `heure_rendez_vous` = \''.$this->hourappointment.'\' AND `id_utilisateur` = '.$this->userId);   
        if(is_object($searchappointment)) {
            $verifappointment = $searchappointment->fetchColumn(); 
        }
        return $verifappointment;
        $searchappointment->closeCursor();        
    }
    /**
     * Méthode cherche la date d'un rendez-vous
     * @return array
     */
    public function getDateAppointment() {
        $dateAppointment = array();
        $requestdate = $this->db->query('SELECT `date_rendez_vous` FROM `rendez_vous` WHERE `nom_rendez_vous` = \''.$this->nameappointment.'\' AND `heure_rendez_vous` = \''.$this->hourappointment.'\' AND `infos_complementaire` = \''.$this->infosappointment.'\' AND id_utilisateur = '.$this->userId);
        if(is_object($requestdate)) {
            $dateAppointment = $requestdate->fetch(PDO::FETCH_ASSOC);
        }
        return $dateAppointment;
    }
    /**
     * Méthode qui renvoie les rendez-vous de l'utilisateur
     * @return array
     */
    public function getAppointment() {
        $appointment = array();
        $researchappoitment = $this->db->query('SELECT `nom_rendez_vous`,DATE_FORMAT(`date_rendez_vous`,"%d") AS day,DATE_FORMAT(`date_rendez_vous`,"%m") AS month,DATE_FORMAT(`date_rendez_vous`,"%Y") AS year,`heure_rendez_vous`,`infos_complementaire`,`note` FROM `rendez_vous` WHERE `id_utilisateur`='.$this->userId.' ORDER BY heure_rendez_vous');
        if(is_object($researchappoitment)) {
            $appointment = $researchappoitment->fetchAll(PDO::FETCH_ASSOC);            
        }
        return $appointment;
    }
// -- // Modification     
    /**
     * Méthode qui permet à l'utilisateur de modifier son rendez-vous
     */
    public function updateAppointment() {
        $requestmodifappointment = $this->db->prepare('UPDATE `rendez_vous` SET `date_rendez_vous` = :newday, `nom_rendez_vous` = :newname, `heure_rendez_vous` = :newhour, `infos_complementaire` = :newinfos  WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos');
        $requestmodifappointment->bindValue(':newday',$this->newdayappointment, PDO::PARAM_STR);
        $requestmodifappointment->bindValue(':newname', $this->newnameappointment,PDO::PARAM_STR);
        $requestmodifappointment->bindValue(':newhour',$this->newhourappointment,PDO::PARAM_STR);
        $requestmodifappointment->bindValue(':newinfos',$this->newinfoappointment,PDO::PARAM_STR);
        $requestmodifappointment->bindValue(':name',$this->nameappointment,PDO::PARAM_STR);
        $requestmodifappointment->bindValue(':hour',$this->hourappointment,PDO::PARAM_STR);
        $requestmodifappointment->bindValue(':infos',$this->infosappointment,PDO::PARAM_STR);
        return $requestmodifappointment->execute(); 
    }
// -- // Suppression    
    /**
     * Supprimer le rendez-vous
     */
    public function deleteAppointment() {
        $requestsupprappointment = $this->db->prepare('DELETE FROM `rendez_vous` WHERE `nom_rendez_vous` = :name AND `heure_rendez_vous` = :hour AND `infos_complementaire` = :infos');
        $requestsupprappointment->bindValue('name',$this->nameappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('hour',$this->hourappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('infos',$this->infosappointment,PDO::PARAM_STR);
        return $requestsupprappointment->execute();
    }
    
    public function __destruct() {
        
    }
}
