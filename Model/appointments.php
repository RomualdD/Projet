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
    private $prefix = PREFIX ;

    public function __construct() {
        parent::__construct();
    }
// -- // Ajout     
    /**
     * Méthode pour ajouter une note d'un rendez-vous
     */
    public function addRemarque() {
        $addremarqueappointment = $this->db->prepare('UPDATE `'.$this->prefix.'appointments` SET `remarque` = :remarque WHERE `name` = :name AND `hour` = :hour AND `additional_informations` = :infos');
        //$addremarqueappointment->bindValue(':tableappointment', $this->prefix.'appointments', PDO::PARAM_STR); 
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
        $requestappointment = $this->db->prepare('INSERT INTO `'.$this->prefix.'appointments`(`id_'.$this->prefix.'users`,`name`, `date`, `hour`, `additional_informations`) VALUES(:id,:name, :date, :hour, :information)');
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
        $searchappointment = $this->db->prepare('SELECT `date` FROM `'.$this->prefix.'appointments` WHERE `date` = :dayappointment AND `hour` = :hourappointment AND `id_'.$this->prefix.'users` = :idUser');   
        $searchappointment->bindValue('dayappointment',$this->dayappointment,PDO::PARAM_STR);
        $searchappointment->bindValue('hourappointment',$this->hourappointment,PDO::PARAM_STR);
        $searchappointment->bindValue('idUser',$this->userId,PDO::PARAM_INT);
        if($searchappointment->execute()) {
            if(is_object($searchappointment)) {
                $verifappointment = $searchappointment->fetchColumn(); 
            }
            $searchappointment->closeCursor();  
        } 
        return $verifappointment;     
    }
    /**
     * Méthode cherche la date d'un rendez-vous
     * @return array
     */
    public function getDateAppointment() {
        $dateAppointment = array();
        $requestdate = $this->db->prepare('SELECT `date` FROM `'.$this->prefix.'appointments` WHERE `name` = :nameappointment AND `hour` = :hourappointment AND `additional_informations` = :infosappointment AND `id_'.$this->prefix.'users` = :userId');
        $requestdate->bindValue('nameappointment',$this->nameappointment,PDO::PARAM_STR);
        $requestdate->bindValue('hourappointment',$this->hourappointment,PDO::PARAM_STR);
        $requestdate->bindValue('infosappointment',$this->infosappointment,PDO::PARAM_STR);
        $requestdate->bindValue('userId',$this->userId,PDO::PARAM_INT);
        if($requestdate->execute()) {
            if(is_object($requestdate)) {
                $dateAppointment = $requestdate->fetch(PDO::FETCH_OBJ);
            }            
        }
        return $dateAppointment;
    }
    /**
     * Méthode qui renvoie les rendez-vous de l'utilisateur
     * @return array
     */
    public function getAppointment() {
        $appointment = array();
        $researchappoitment = $this->db->prepare('SELECT `id`,`name`,DATE_FORMAT(`date`,\'%d/%m/%Y\') AS date,DATE_FORMAT(`date`,\'%d\') AS day,DATE_FORMAT(`date`,\'%m\') AS month,DATE_FORMAT(`date`,\'%Y\') AS year,`hour`,`additional_informations`,`remarque` FROM `'.$this->prefix.'appointments` WHERE `id_'.$this->prefix.'users`= :userId ORDER BY hour');
        $researchappoitment->bindValue('userId',$this->userId,PDO::PARAM_INT);
       if($researchappoitment->execute()) {
            if(is_object($researchappoitment)) {
                $appointment = $researchappoitment->fetchAll(PDO::FETCH_OBJ);            
            }
        }
        return $appointment;
    }
// -- // Modification     
    /**
     * Méthode qui permet à l'utilisateur de modifier son rendez-vous
     */
    public function updateAppointment() {
        $requestmodifappointment = $this->db->prepare('UPDATE `'.$this->prefix.'appointments` SET `date` = :newday, `name` = :newname, `hour` = :newhour, `additional_informations` = :newinfos  WHERE `name` = :name AND `hour` = :hour AND `additional_informations` = :infos');
       // $requestmodifappointment->bindValue(':tableappointment', $this->prefix.'appointments', PDO::PARAM_STR);
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
        $requestsupprappointment = $this->db->prepare('DELETE FROM `'.$this->prefix.'appointments` WHERE `name` = :name AND `hour` = :hour AND `additional_informations` = :infos');
        //$requestsupprappointment->bindValue(':tableappointment', $this->prefix.'appointments', PDO::PARAM_STR);
        $requestsupprappointment->bindValue('name',$this->nameappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('hour',$this->hourappointment,PDO::PARAM_STR);
        $requestsupprappointment->bindValue('infos',$this->infosappointment,PDO::PARAM_STR);
        return $requestsupprappointment->execute();
    }
    /**
     * Supprime tous les rendez-vous de l'utilisateur
     * @return bool
     */
    public function deleteFollowup() {
        $requestdelete =  $this->db->prepare('DELETE FROM `'.$this->prefix.'appointments` WHERE `id_'.$this->prefix.'users` = :id');
        $requestdelete->bindValue('id',$this->id,PDO::PARAM_INT);
        return $requestdelete->execute();
    }
    public function __destruct() {
        
    }
}
