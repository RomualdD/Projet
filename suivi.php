<?php
session_start();
if(!isset($_SESSION['user'])) {
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
  $pathology = $_SESSION['pathology'];
  if($pathology == 3) {
    header('Location:suivi1.php');
  }
  elseif ($role==0) {
  header('Location:suivimedecin.php');
}
  else {
?>
<!-- Page suivi patient -->
<div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
    <?php
    if(isset($_POST['submit'])) {
        // Vérification qu'il y'a bien un taux et qu'il est écrit en chiffre.chiffre ou chiffre
      if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate']))){
          // Récupération du taux
        $rate= strip_tags($_POST['rate']);
        // Date du jour avec heure
        $date = date('d/m/Y H:i'); 
        // Date du jour
        $dateday = date('d/m/Y');
        // Horraire du jour afin de faire une comparaison
        $hour = date('Hi');
        // Récupération de la date de vérification et des heures demandés
        $searchfuturedate = $bdd->query('SELECT date_verification, Heure1, Heure2, Heure3, Heure4 FROM verification WHERE id_utilisateur = "'.$id.'"');
        $searchfuturedate = $searchfuturedate->fetch();
        $dateverif = $searchfuturedate['date_verification'];
        $oneclock = $searchfuturedate['Heure1'];
        $twoclock = $searchfuturedate['Heure2'];
        $threeclock = $searchfuturedate['Heure3'];
        $fourclock = $searchfuturedate['Heure4'];  
        // On ne récupère que les chiffres des heures
        $onehour = substr($oneclock,0,2).substr($oneclock,3,4);
        $twohour = substr($twoclock,0,2).substr($twoclock,3,4);
        $threehour = substr($threeclock,0,2).substr($threeclock,3,4);
        $fourhour = substr($fourclock,0,2).substr($fourclock,3,4);
      /*  $dateverif = date_create_from_format('d/m/Y H:i', $dateverif);
        $dateverif = date_format($dateverif, 'd/m/Y H:i');*/
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
            // Comparaison des heures et minutes pour savoir dans quel horaire on se situe
/*            if($hour < $onehour) {
                $futurehour = $oneclock;
                $futuredate = $dateday;
            }
            elseif ($hour > $onehour && $hour < $twohour) {
                $futurehour = $twoclock;
                $futuredate = $dateday;

            }
            elseif ($hour > $twohour && $hour < $threehour) {
                $futurehour = $threeclock;
                $futuredate = $dateday;
            }
            elseif($hour > $threehour && $hour < $fourhour) {
                $futurehour = $fourclock;
                $futuredate = $dateday;            
            }
            else {
                $futurehour = $oneclock;
                $tomorrow = time() + (24*60*60); // calcul d'une journée
                $futuredate = date('d/m/Y', $tomorrow); // intégration pour passer au lendemain     
            }*/
            
            $futurehour = $oneclock;
            $tomorrow = time() + (24*60*60); // calcul d'une journée
            $futuredate = date('d/m/Y', $tomorrow); // intégration pour passer au lendemain   
        }
        // Concaténation de la prochaine date avec l'heure correspondante
        $futuredate = $futuredate.' '.$futurehour;
        $resultdate = $bdd->query('SELECT date_du_jour FROM suivis WHERE date_du_jour ="'.$date.'"');
        $resultdate = $resultdate->fetch();
        if($date != $resultdate['date_du_jour'] && ($id != $resultdate['id_utilisateur'])) {
          // Ajout dans la table suivis pour récupéré ensuite les valeurs  
          $req = $bdd->prepare('INSERT INTO suivis(id_utilisateur, date_du_jour, resultat, date_prochaine_verif) VALUES(:id, :daydate, :result, :futureverif)');
          $req->execute(array(
          'id' => $id,
          'daydate' => $date,
          'result' => $rate,
          'futureverif' => $futuredate
          ));
          // Modification de la prochaine vérifiacation dans la table vérification
          $requestmodif = $bdd->prepare('UPDATE verification SET date_verification = :newdate WHERE id_utilisateur = :id');
          $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
          $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
          $requestmodif->execute();
        }
      }
    }
    ?>
  <div class="row">
    <form name="followedrate" method="POST" action="suivi.php">
    <div class="suivi form-group col-lg-offset-3">
      <label for="text">Résultats de la prise de sang :</label>
      <input type="text" name="rate" placeholder="Taux obtenus" class="col-lg-offset-1" id="result"/>
    </div>
    <input type="submit" value="Valider !" name="submit" class="btn btn-default col-lg-offset-5 addresult"/>
  </form>
  </div>
  <div class="row">
    <div class="col-lg-offset-4"><h3>Visualisations des résultats :</h3></div>
  </div>
  <div class="row">
    <div class="col-lg-offset-3">En tableau :</div>
  </div>
  <div class="row">
    <table class="tableresult table table-bordered result col-lg-offset-2 col-lg-3">
      <thead>
        <tr>
          <th>Date du résultat :</th>
          <th>Résultat :</th>
          <th>Date de la prochaine analyse :</th>
        </tr>
      </thead>
      <tbody>
          <?php
          // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant
          $requestbdd = $bdd->query('SELECT date_du_jour, resultat, date_prochaine_verif FROM suivis WHERE id_utilisateur = "'.$id.'"ORDER BY id DESC ');
          while($requestarray = $requestbdd->fetch(PDO::FETCH_ASSOC)) { //PDO FETCH_ASSOC empêche d'avoir deux fois la même valeur
            ?><tr><?php
            foreach($requestarray as $element) {
              ?>
            <td><?php echo $element; ?></td><?php
            }?></tr><?php
          }
         ?>
      </tbody>
    </table>
  </div>
  <div class="row">
      <div class="col-lg-offset-3">En graphique :</div>
  </div>
  <div class="row">
      <div id="chartResult"></div>
  </div>
</div>
<?php
    $dataPoints= array();
    $n = 0;
    // Récupération de la date du jour avec le résultat limité a 28 résultats (une semaine)
    $requestbdd = $bdd->query('SELECT date_du_jour,resultat FROM suivis WHERE id_utilisateur = "'.$id.'" ORDER BY id LIMIT 28');
    foreach($requestbdd->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE) as $cle => $result) {
        foreach($result as $resultchart) {
            $dataPoints[$n] = array('label'=>$cle, 'y'=>$resultchart);
        }
        $n++;
    }
  ?>
<script>
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
<?php  
  }
  }
  include 'footer.php';
?>
