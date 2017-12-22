<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';?>
  <div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <div class="row">
    <form name="followedrate" method="post" action="suivimedecin.php">
    <div class="suivi form-group col-lg-offset-3">
      <label for="text">Choisir son patient :</label>
                <?php 
          $requestfollow = $bdd->prepare('SELECT follow_from, follow_to, nom, prenom,nom_utilisateur FROM utilisateurs LEFT JOIN follow ON role = :role WHERE follow_to = :id OR follow_from = :id AND follow_confirm = :confirm ORDER BY nom');
          $requestfollow->bindValue(':id',$id, PDO::PARAM_INT);
          $requestfollow->bindValue(':confirm','1', PDO::PARAM_STR);
          $requestfollow->bindValue(':role','1', PDO::PARAM_STR);
          $requestfollow->execute();
                          ?>
      <select name="patient"><?php
                while($follow = $requestfollow->fetch(PDO::FETCH_ASSOC)) {

                ?><option value="<?php echo $follow['nom_utilisateur'] ?>"><?php echo $follow['nom'].' '.$follow['prenom'];?></option><?php
            }
          ?>
      </select>
    </div>
    <input type="submit" value="Valider !" name="valider" class="btn btn-default col-lg-offset-5 addresult"/>
  </form>
  </div>
      <?php
        if(isset($_POST['patient'])) {
            $patient = $_POST['patient'];
            $requestsearch = $bdd->prepare('SELECT date_du_jour, resultat, date_prochaine_verif FROM suivis LEFT JOIN utilisateurs ON nom_utilisateur = :user LEFT JOIN follow ON role = :role WHERE follow_to = :id OR follow_from = :id AND follow_confirm = :confirm ORDER BY date_du_jour DESC');
            $requestsearch->bindValue(':id',$id, PDO::PARAM_INT);
            $requestsearch->bindValue(':confirm','1', PDO::PARAM_STR);
            $requestsearch->bindValue(':role','1', PDO::PARAM_STR);
            $requestsearch->bindValue(':user',$patient, PDO::PARAM_STR);
            $requestsearch->execute();
      ?>
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
          while($requestarray = $requestsearch->fetch(PDO::FETCH_ASSOC)) { 
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
<?php
$dataPoints= array();
$n = 0;
    $patient = $_POST['patient'];
    $requestsearch = $bdd->prepare('SELECT date_du_jour, resultat FROM suivis LEFT JOIN utilisateurs ON nom_utilisateur = :user LEFT JOIN follow ON role = :role WHERE follow_to = :id OR follow_from = :id AND follow_confirm = :confirm');
    $requestsearch->bindValue(':id',$id, PDO::PARAM_INT);
    $requestsearch->bindValue(':confirm','1', PDO::PARAM_STR);
    $requestsearch->bindValue(':role','1', PDO::PARAM_STR);
    $requestsearch->bindValue(':user',$patient, PDO::PARAM_STR);
    $requestsearch->execute();
while($requestchart = $requestsearch->fetch(PDO::FETCH_ASSOC))
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
       ?> </div><?php
}
include 'footer.php';