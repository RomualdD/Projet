<?php
class Date{
  var $days = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
  var $months = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
  function getDate($years) {
    $r = array();
    $date = new DateTime($years.'-01-01');
    while ($date->format('Y')<= $years) {
      $year = $date->format('Y');
      $month = $date->format('n');
      $day = $date->format('j');
      $w = str_replace('0','7',$date->format('w'));
      $r[$year][$month][$day]=$w;
      $date->add(new DateInterval('P1D'));
    }
    return $r;
  }
}

 ?>
