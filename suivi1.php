<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';

    $result = $bdd->query('SELECT id FROM utilisateurs WHERE nom_utilisateur ="'.$user.'"');
    $id = $result->fetch();
    $id= $id['id'];
?>
<!-- Page suivi patient -->
<div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <div class="row">
    <?php
    if(isset($_POST['submit'])) {
      if(!empty($_POST['rate'])){
        $rate=$_POST['rate'];
        $date = date('d/m/Y'); // Date du jour
        $nextverif = time() + (21 * 24 * 60 * 60); //On lui demande de calculer la date dans 21jours
        $futuredate = date('d/m/Y', $nextverif); // On récupère la nouvelle date
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
    <form method="post" action="suivi1.php" name="followedrate" >
    <div class="suivi form-group col-lg-offset-3">
      <label for="text">Résultats de la prise de sang :</label>
      <input type="text" name="rate" placeholder="Taux obtenus" class="col-lg-offset-1" id="result" />
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
        <tr>
          <?php
          $requestbdd = $bdd->query('SELECT date_du_jour, resultat, date_prochaine_verif FROM suivis WHERE id_utilisateur = "'.$id.'" ');
          while($requestarray = $requestbdd->fetch(PDO::FETCH_ASSOC)) { //PDO FETCH_ASSOC empêche d'avoir deux fois la même valeur
            ?><tr><?php
            foreach($requestarray as $element) {
              ?>
            <td><?php echo $element; ?></td><?php
            }?></tr><?php
          }
         ?>
        </tr>
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
$datechart = 'DD/MM/YYYY';
$resultchart = 0;
$requestbdd = $bdd->query('SELECT date_du_jour FROM suivis WHERE id_utilisateur = "'.$id.'"');
$requestbdd2 = $bdd->query('SELECT resultat FROM suivis WHERE id_utilisateur = "'.$id.'"');
while($requestdatechart = $requestbdd->fetch(PDO::FETCH_ASSOC))
{
  while($requestresultchart = $requestbdd2->fetch(PDO::FETCH_ASSOC)) {
  foreach ($requestdatechart as $datevalue) {
    foreach($requestresultchart as $resultvalue) {
      echo $datevalue." ".$resultvalue.' ';
  $chart = "<script>
    // Values for chart and chart declaration
    var chartValues = [];
    var chart = new CanvasJS.Chart('chartResult', { // Création du graphique
      animationEnabled: true, //Animation du graphique
      exportEnabled: true, // Can export chart
      theme: 'light2',  // Ligne du graphique
      title: {
        text: 'Résultats de vos analyses' // Titre du graphique
      },
      axisX: {
        includeZero: false,
        title:'Date de la vérification',  // Titre de l'axe X
        valueFormatString: 'DD/MM/YYYY'   // Format des valeurs de l'axe X
      },
      axisY:{
        title:'Résultats',  // Titre de l'axe Y
        includeZero: false  // On ne prends pas le 0
      },
      data: [{
        type: 'spline', // Type de courbe
        dataPoints: chartValues   // Tracé du graphique
      }]
    });

    $(window).load(function() {
        // Push values to chart
        chartValues.push({
          x: ".$datevalue.",
          y: parseFloat(".$resultchart.")
        });
        chart.render();
      });
    </script>";

    echo $chart;
    }
  }
}
}
  }
  include 'footer.php';
?>
