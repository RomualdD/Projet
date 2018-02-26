<?php
/**
 * Classe des rendez-vous
 * Visualisation dans la page information
 */
class appointments extends dataBase {
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
     * Méthode pour ajouter une note d'un rendez-vous
     */
    public function addRemarque() {
        $addremarqueappointment = $this->db->prepare('UPDATE `'.self::prefix.'appointments` SET `remarque` = :remarque WHERE `name_appointment` = :name AND `hour_appointment` = :hour AND `additional_informations` = :infos');
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
        $requestappointment = $this->db->prepare('INSERT INTO `'.self::prefix.'appointments`(`id_'.self::prefix.'users`,`name_appointment`, `date_appointment`, `hour_appointment`, `additional_informations`) VALUES(:id,:name, :date, :hour, :information)');
        $requestappointment->bindValue('id',$this->userId, PDO::PARAM_INT);
        $requestappointment->bindValue('name',$this->nameappointment,PDO::PARAM_STR);
        $requestappointment->bindValue('date',$this->dayappointment,PDO::PARAM_STR);
        $requestappointment->bindValue('hour',$this->hourappointment,PDO::PARAM_STR);
        $requestappointment->bindValue('information',$this->informationappointment,PDO::PARAM_STR);
        return $requestappointment->execute();
    }
// -- // Sélection  
    /**
     * Méthode qui permet de vérifier si l'utilisateur a déjà un rendez-vous à la même hour
     */
    public function getVerifInformation() {
        $verifappointment = array();
        $searchappointment = $this->db->query('SELECT `date_appointment` FROM `'.self::prefix.'appointments` WHERE `date_appointment` = \''.$this->dayappointment.'\' AND `hour_appointment` = \''.$this->hourappointment.'\' AND `id_'.self::prefix.'users` = '.$this->userId);   
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
        $requestdate = $this->db->query('SELECT `date_appointment` FROM `'.self::prefix.'appointments` WHERE `name_appointment` = \''.$this->nameappointment.'\' AND `hour_appointment` = \''.$this->hourappointment.'\' AND `additional_informations` = \''.$this->infosappointment.'\' AND `id_'.self::prefix.'users` = '.$this->userId);
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
        $researchappoitment = $this->db->query('SELECT `id`,`name_appointment`,DATE_FORMAT(`date_appointment`,\'%d/%m/%Y\') AS date_appointment,DATE_FORMAT(`date_appointment`,\'%d\') AS day,DATE_FORMAT(`date_appointment`,\'%m\') AS month,DATE_FORMAT(`date_appointment`,\'%Y\') AS year,`hour_appointment`,`additional_informations`,`remarque` FROM `'.self::prefix.'appointments` WHERE `id_'.self::prefix.'users`='.$this->userId.' ORDER BY hour_appointment');
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
        $requestmodifappointment = $this->db->prepare('UPDATE `'.self::prefix.'appointments` SET `date_appointment` = :newday, `name_appointment` = :newname, `hour_appointment` = :newhour, `additional_informations` = :newinfos  WHERE `name_appointment` = :name AND `hour_appointment` = :hour AND `additional_informations` = :infos');
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
        $requestsupprappointment = $this->db->prepare('DELETE FROM `'.self::prefix.'appointments` WHERE `name_appointment` = :name AND `hour_appointment` = :hour AND `additional_informations` = :infos');
        $requestsupprappointment->bindValue('name',$this->nameappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('hour',$this->hourappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('infos',$this->infosappointment,PDO::PARAM_STR);
        return $requestsupprappointment->execute();
    }
    
    public function __destruct() {
        
    }
}
