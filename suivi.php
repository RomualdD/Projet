<?php
  include 'header1.php'
?>
<!-- Page suivi patient -->
<div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <div class="row">
    <form method="post" action="suivi.php">
    <div class="suivi form-group col-lg-offset-3">
      <label for="texte">Résultats de la prise de sang :</label>
      <input type="text" name="rate" placeholder="Taux obtenus" class="col-lg-offset-1" id="result">
    </div>
    <input type="button" value="Valider !" class="btn btn-default col-lg-offset-5 addresult" required>
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
$year = 2017;
$chart ="<script>
$('.addresult').click(function(){
  var date = new Date();
  var futureDate = new Date();
  console.log(futureDate);
  var year = date.getFullYear();
  var month = date.getMonth() + 1;//+1 pour avoir résultats du bon mois
  var day = date.getDate();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var result = $('#result').val();

  var daydate = day + '/' + month + '/' + year; //INR
  //var daydate = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes; Diabetes
  futureDate.setDate(day + 21);
  var yearfutureverif = futureDate.getFullYear();
  var monthfutureverif = futureDate.getMonth() + 1;
  var dayfutureverif = futureDate.getDate();
  var futureverif = dayfutureverif + '/' + monthfutureverif + '/' + yearfutureverif;
  console.log(date);
  console.log(result);
  $('.tableresult').append('<tr><td>' + daydate + '</td><td>' + result + '</td><td>' + futureverif);

  var chart = new CanvasJS.Chart('chartResult', {
    animationEnabled: true,
    theme: 'light2',
    title: {
      text: 'Résultats de vos analyses',},
    axisX: {
      title:'Date de la vérification',
      valueFormatString: 'DD/MM/YYYY',},
    axisY:{
      title:'Résultats',
      includeZero: false},
    data: [{
      type: 'spline',
      dataPoints: [
        {x: date,y: 1},
        {x: new Date(".$year.",10,30),y: 2}
      ]
    }]
  });
  chart.render();
});
</script>";
echo $chart; ?>

<?php
  include 'footer.php';
?>
