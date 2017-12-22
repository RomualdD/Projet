<?php
session_start();
if(!isset($_SESSION['user'])){
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
      if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate']))){
        $rate=$_POST['rate'];
        $date = date('d/m/Y H:i'); // Date du jour
        $futuredate = date('d/m/Y H:i');
        $resultdate = $bdd->query('SELECT date_du_jour FROM suivis WHERE date_du_jour ="'.$date.'"');
        $resultdate = $resultdate->fetch();
        if($date != $resultdate['date_du_jour']) {
          $req = $bdd->prepare('INSERT INTO suivis(id_utilisateur, date_du_jour, resultat, date_prochaine_verif) VALUES(:id, :daydate, :result, :futureverif)');
          $req->execute(array(
          'id' => $id,
          'daydate' => $date,
          'result' => $rate,
          'futureverif' => $futuredate
          ));
        }
      }
    }
    ?>
  <div class="row">
    <form name="followedrate" method="post" action="suivi.php">
    <div class="suivi form-group col-lg-offset-3">
      <label for="text">Résultats de la prise de sang :</label>
      <input type="text" name="rate" placeholder="Taux obtenus" class="col-lg-offset-1" id="result"/>
    </div>
    <input type="submit" value="Valider !" name="valider" class="btn btn-default col-lg-offset-5 addresult"/>
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
          $requestbdd = $bdd->query('SELECT date_du_jour, resultat, date_prochaine_verif FROM suivis WHERE id_utilisateur = "'.$id.'"ORDER BY date_du_jour DESC ');
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
$requestbdd = $bdd->query('SELECT date_du_jour,resultat FROM suivis WHERE id_utilisateur = "'.$id.'"');
while($requestchart = $requestbdd->fetch(PDO::FETCH_ASSOC))
{
  foreach ($requestchart as $datevalue) {
    $dataPoints[$n] = array('label'=>$requestchart['date_du_jour'], 'y'=>$requestchart['resultat']);
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
