<?php
  include 'header1.php';
?>

<!-- Page suivi patient -->
<div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <div class="row">
    <form name="followedrate" method="post" action="suivi.php">
    <div class="suivi form-group col-lg-offset-3">
      <label for="text">Résultats de la prise de sang :</label>
      <input type="text" name="rate" placeholder="Taux obtenus" class="col-lg-offset-1" id="result" />
    </div>
    <input type="submit" value="Valider !" name="valider" class="btn btn-default col-lg-offset-5 addresult" onclick="return false;" />
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
  //  echo $datetime;

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
        valueFormatString: 'DD/MM/YYYY HH:mm:ss'   // Format des valeurs de l'axe X
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

    $('.addresult').click(function() {
        var date = new Date(); //récupération date
        var futureDate = new Date(); //récupération date pour mettre au futur
        var year = date.getFullYear();  // Récupération de l'année
        var month = date.getMonth() + 1;//+1 pour avoir résultats du bon mois (0 à 11)
        var day = date.getDate(); // Récupération du jour
        var hours = date.getHours();  // Récupération de l'heure
        var minutes = date.getMinutes(); // Récupération des minutes
        var daydate = day + '/' + month + '/' + year; //INR
        //var daydate = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes; //Diabetes

        var resultValue = $('#result').val(); // Récupération du résultat de l'analyse

        futureDate.setDate(day + 21); // Ajout de 21jours (3semaines).
        var yearfutureverif = futureDate.getFullYear(); // Récupération de l'année de la prochaine vérification
        var monthfutureverif = futureDate.getMonth() + 1; // Récupération du mois de la prochaine vérification
        var dayfutureverif = futureDate.getDate();  // Récupération du jour de la prochaine vérification
        var futureverif = dayfutureverif + '/' + monthfutureverif + '/' + yearfutureverif; // Concaténation prochaine vérification
        $('.tableresult').append('<tr><td>' + daydate + '</td><td>' + resultValue + '</td><td>' + futureverif + '</td></tr>'); //Ajout dans le tableau

        // Push values to chart
        chartValues.push({
          x: date,
          y: parseFloat(resultValue)
        });
        chart.render();
      });
    </script>";
    echo $chart;
  ?>

<?php
  include 'footer.php';
?>
