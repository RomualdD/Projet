<?php
  include 'header1.php';
?>
<!-- Page suivi patient -->
<div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <?php
  $nextverif = time() + (1814400); //Récupération du timestamp pour avoir toutes les trois semaines
  $datetime = date('d/m/Y');
  $afterverifdate=date("d/m/Y", $nextverif);
  if(!empty($_POST['rate'])){
    $rate=$_POST['rate'];
    echo $rate;
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
$chart = "<script>
  $('.addresult').click(function(){
    var resultat = '".$rate."';
    console.log(resultat);
    var date = new Date(); //récupération date
    console.log(date);
    var futureDate = new Date(); //récupération date pour mettre au futur
    var year = date.getFullYear();  // Récupération de l'année
    var month = date.getMonth() + 1;//+1 pour avoir résultats du bon mois (0 à 11)
    var day = date.getDate(); // Récupération du jour
    var hours = date.getHours();  // Récupération de l'heure
    var minutes = date.getMinutes(); // Récupération des minutes

    var daydate = day + '/' + month + '/' + year; //INR
    //var daydate = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes; Diabetes
    futureDate.setDate(day + 21); // Ajout de 21jours (3semaines).
    var yearfutureverif = futureDate.getFullYear(); // Récupération de l'année de la prochaine vérification
    var monthfutureverif = futureDate.getMonth() + 1; // Récupération du mois de la prochaine vérification
    var dayfutureverif = futureDate.getDate();  // Récupération du jour de la prochaine vérification
    var futureverif = dayfutureverif + '/' + monthfutureverif + '/' + yearfutureverif; // Concaténation prochaine vérification
    $('.tableresult').append('<tr><td>' + daydate + '</td><td>'+resultat+'</td><td>' + futureverif + '</td></tr>'); //Ajout dans le tableau

        var chart = new CanvasJS.Chart('chartResult', { // Création du graphique
          animationEnabled: true, //Animation du graphique
          theme: 'light2',  // Ligne du graphique
          title: {
            text: 'Résultats de vos analyses' // Titre du graphique
          },
          axisX: {
            title:'Date de la vérification',  // Titre de l'axe X
            valueFormatString: 'DD/MM/YYYY'   // Format des valeurs de l'axe X
          },
          axisY:{
            title:'Résultats',  // Titre de l'axe Y
            includeZero: false  // On ne prends pas le 0
          },
          data: [{
            type: 'spline', // Type de courbe
            dataPoints: [   // Tracé du graphique
              {x: date, y: resultat}
            ]
          }]
        });
        chart.render(); // Affichage du graphique
  });
  </script>";
echo $chart;
  ?>

<?php
  include 'footer.php';
?>
