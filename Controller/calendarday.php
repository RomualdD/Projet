<?php
// -- // Vérification dans calendrier
    // Vérification du jour du rendez-vous
      foreach($timeappoitment as $appointment) {
         // Si jour du rendez-vous est le jour d'aujourd'hui alors on récupère les informations
        if($appointment['day'] == $currentDay) {
            $idappointment = $appointment['id'];
            $day=$appointment['day'];
            $hour=$appointment['hour'];
            $name=$appointment['name'];
            $infos=$appointment['infos'];
            $monthDay=$appointment['month'];
            $yearDay=$appointment['year'];
            $dateappointment = $appointment['date'];
            $remarqueForAppointment = $appointment['remarque'];
            // On écrit pour récupéré les informations qu'on veut
            $infocle=  array('id'=>$idappointment,'date' => $dateappointment,'year'=>$yearDay,'month'=>$monthDay,'day' => $day,'hour'=>$hour,'nameappointment'=>$name,'infoappointment'=>$infos,'remarque'=>$remarqueForAppointment);
            $informations = array_push($infoappointment, $infocle);
         } 
     }   

