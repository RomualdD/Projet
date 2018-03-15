<?php
$verification = new verification();
$suivi = new suivis();
$follow = new follow();
$userPatient = new users();
$verification->userId = $id;
$follow->id = $suivi->userId = $id;
// -- // Ajout du résultat 
$successAddMsg = '';
$errorResult = '';
// -- // Recherche des résultats à mettre dans le graphique
    $dataPoints= array();
    $nbresult = 0;
    
 // Possibilité de mettre 2 dates pour voir son suivi   
if(!empty($_POST['date1'])&&(!empty($_POST['date2']))) {
  $suivi->firstDate = $_POST['date1'];
  $dateSecond = $_POST['date2'];
  $suivi->secondDate = date('Y-m-d', strtotime($dateSecond.' +1 DAY'));
}
else { 
    if ($pathology == 2 || $pathology == 3) {
        $suivi->firstDate = date('Y-m-d', strtotime(date('Y-m-d').' -3 MONTH'));    
    }
    else {
        $suivi->firstDate = date('Y-m-d', strtotime(date('Y-m-d').' -1 WEEK'));
    }
        $suivi->secondDate = date('Y-m-d', strtotime(date('Y-m-d').' +1 DAY'));    
}
if($role != 0) {
// Pagination
    $total = $suivi->countRate();
    if($total != NULL) {
        $total = $total->total;  
    }
    else {
        $total = 1;
    }
    $nbresultat = 10;
    // Arrondit au nombre supérieur
    $nbPage = $suivi->nbPage = ceil($total/$nbresultat);
    if($suivi->nbPage > 1) {
        if(isset($_GET['page'])) {
            $actuallyPage = intval($_GET['page']);
            if($actuallyPage > $suivi->nbPage) { // Si page actuelle est supérieur à nombres de pages
                $actuallyPage = $suivi->nbPage;
            }
            elseif ($actuallyPage==0) {
               $actuallyPage = 1; 
            }
        }
        else {
           $actuallyPage = 1; // page actuelle 1
        }
        $suivi->offset = ($actuallyPage-1)*$nbresultat; // Calcule la première entrée     
    } else {
       $actuallyPage = 1;
       $nbPage = 1;
       $suivi->nbPage = 4;
    }
    if($pathology == 1) {
        if(isset($_POST['submit'])) {
            // Vérification qu'il y'a bien un taux et qu'il est écrit en chiffre.chiffre ou chiffre
            if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]{2}$#',$_POST['rate']))){
              // Récupération du taux
                $suivi->rate= strip_tags($_POST['rate']);
                // Date du jour avec heure
                $suivi->dateday = date('Y-m-d H:i'); 
                // Date du jour
                $dateday = date('Y-m-d');
                // Horraire du jour afin de faire une comparaison
                $hour = date('Hi');
                // Récupération de la date de vérification et des heures demandés
                $searchfuturedate = $verification->getVerification();
                if($searchfuturedate != NULL) {
                    $iduser = $searchfuturedate->id_pbvhfjt_users;
                    $dateverif = $searchfuturedate->verification_date;
                    $oneclock = $searchfuturedate->onehour;
                    $twoclock = $searchfuturedate->twohour;
                    $threeclock = $searchfuturedate->threehour;
                    $fourclock = $searchfuturedate->fourhour;  
                    // On ne récupère que les chiffres des heures et minutes
                    $onehour = substr($oneclock,0,2).substr($oneclock,3,4);
                    $twohour = substr($twoclock,0,2).substr($twoclock,3,4);
                    $threehour = substr($threeclock,0,2).substr($threeclock,3,4);
                    $fourhour = substr($fourclock,0,2).substr($fourclock,3,4);
                    // Vérification de quelle date est la prochaine
                    if($hour > $onehour && $hour < $twohour) {
                        $futurehour = $twoclock;  
                        $futuredate = $dateday;
                    }
                    elseif($hour > $twohour && $hour < $threehour) {
                        $futurehour = $threeclock;      
                        $futuredate = $dateday;
                    }
                    elseif($hour > $threehour && $hour < $fourhour) {
                        $futurehour = $fourclock;
                        $futuredate = $dateday;
                    }
                    elseif($hour < $onehour) {
                            $futurehour = $oneclock;
                            $futuredate = $dateday;
                    }
                    else {   
                            $futurehour = $oneclock;
                            $tomorrow = time() + (24*60*60); // calcul d'une journée
                            $futuredate = date('Y-m-d', $tomorrow); // intégration pour passer au lendemain 
                    }
                    // Concaténation de la prochaine date avec l'heure correspondante
                    $verification->dateverification = $suivi->datefutureverif = $futuredate.' '.$futurehour.':00';
                    if(($suivi->datefutureverif != $dateverif) && ($suivi->userId == $iduser )) {
                      // Ajout dans la table suivis pour récupéré ensuite les valeurs  
                      $suivi->addRate();  
                      $successAddMsg = RESULTADD;
                      // Modification de la prochaine vérifiacation dans la table vérification
                      $verification->updateDateVerif();
                    }
                    if($suivi->datefutureverif == $dateverif) {
                        $verifresult = $suivi->getResultByDateverif();
                        $result = $verifresult->result;
                        if($suivi->rate != $result) {
                            $suivi->updateRate();
                            $successAddMsg = MODIFICATERESULT;
                        }
                    }
                }
                else {
                    $errorResult = VERIFICATIONERRORRESULT;
                }
            }
            else {
                $errorResult = ERRORRESULT;
            }
        }
    }
    elseif($pathology == 2 || $pathology == 3) {
        if(isset($_POST['submit'])) {
            if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate']))) {
                $searchfuturedate = $verification->getVerification();
                if($searchfuturedate != NULL) {                
                    $suivi->rate=$_POST['rate'];
                    $suivi->dateday = date('Y-m-d').' 00:00:00'; // Date du jour
                    $date = date('Y-m-d');
                    if($pathology == 3) {
                        $suivi->datefutureverif = $nextverif = date('Y-m-d', strtotime($date.' + 21 day')); //On lui demande de calculer la date dans 21jours (3semaines)
                    }
                    else {
                        $suivi->datefutureverif = $nextverif = date('Y-m-d', strtotime($date.' + 3 month'));
                    }
                    $resultdate = $suivi->getDateDay();
                    if($resultdate != NULL) {
                        $verifDateDay = '';
                        foreach($resultdate as $datetime) {
                            if($suivi->dateday == $datetime->today_date) {
                                $verifDateDay = $datetime->today_date;
                            }         
                        }           
                    } 
                    else {
                        $verifDateDay = '';
                    }
                        if($suivi->dateday != $verifDateDay) {
                            $suivi->addRate();
                            $successAddMsg = 'Votre résultat a bien était ajouté !';
                        }
                        
                        else {
                            $requestverifresult = $suivi->getResultByDateverif();
                            $result = $requestverifresult->result;
                            if($suivi->rate != $result) {
                                $suivi->updateRate();
                                $successAddMsg = 'Votre résultat a bien était modifié !';  
                            }
                        }      
                    $oneclock = $searchfuturedate->onehour;
                    $verification->dateverification = $suivi->datefutureverif.' '.$oneclock;
                    // Modification de la prochaine vérifiacation dans la table vérification
                    $verification->updateDateVerif();
                }
                else {
                    $errorResult = 'Veuillez entrer vos horraires dans votre profil !';
                }
            }                
            else {
                $errorResult = 'Votre résultat ne correspond pas au résultat attendus. Veuillez entrez votre résultat sous le format comme l\'exemple: 1 ou 1.1 ou 1.11';
            }
        }            
    }
    // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant 
    $requestarray = $suivi->getRateInArray();
    $requestSearchGraphic = $suivi->getRateInGraphic();
    foreach($requestSearchGraphic as $result) {
        foreach($result as $resultchart) {
            $dataPoints[$nbresult] = array('label'=>$result->date_now, 'y'=>$result->result);
        }
    $nbresult++;
    } 
}
else {
  // -- // Recherche patient 
    $followDoctor = $follow->getPatientByDoctor();
    if(!empty($_POST['patient'])) {
        // -- // Tableau
        $follow->username = $userPatient->username = $patient = $_POST['patient'];
       /* $request = $db->query('SELECT `id` FROM `utilisateurs` WHERE `nom_utilisateur` = "'.$patient.'"');
        $request = $request->fetch(); */
        $requestPatient = $userPatient->getUserId();
        $follow->follow_to = $requestPatient->id;
        // Possibilité de mettre 2 dates pour voir son suivi   
        if(!empty($_POST['date1'])&&(!empty($_POST['date2']))) {
          $follow->firstDate = $_POST['date1'];
          $dateSecond = $_POST['date2'];
          $follow->secondDate = date('Y-m-d', strtotime($dateSecond.' +1 DAY'));
        }
        else {
          $follow->firstDate = date('Y-m-d', strtotime(date('Y-m-d').' -1 WEEK')); 
          $follow->secondDate = date('Y-m-d', strtotime(date('Y-m-d').' +1 DAY'));
        }
        $requestarray = $follow->getRateArrayForDoctor();
        
        // -- // Graphique       
        $dataPoints= array();
        $nbresult = 0;
        $requestSearchGraphic = $follow->getRateGraphicForDoctor();
        foreach($requestSearchGraphic as $result) {
            foreach($result as $resultchart) {
                $dataPoints[$nbresult] = array('label'=>$result->date_now, 'y'=>$result->result);
            }
        $nbresult++;
        } 
    } 
}
?>
    <script>
// -- // Graphique
        $(window).on('load', function() {
            var chart = new CanvasJS.Chart("chartResult", {
                theme: "light2",
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Résultats de vos analyses"
                },
                axisX: {
                  includeZero: false,
                  title:'Date de la vérification',  // Titre de l'axe X
                },
                axisY:{
                  title:'Résultats',  // Titre de l'axe Y
                  includeZero: false  // On ne prends pas le 0
                },
                  data: [
                  {
                      type: "line",

                      dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                  }
                ]
              });
              chart.render();
          });
    </script>

