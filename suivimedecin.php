<?php
session_start();
if(!isset($_SESSION['user'])) {
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
  if($role == 1) {
        header('Location:suivi.php');
  } else {
  ?>
  <div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <div class="row">
    <form name="followedrate" method="POST" action="suivimedecin.php">
    <div class="suivi form-group col-lg-offset-3">
      <label for="text">Choisir son patient :</label>
        <?php 
          $requestfollow = $bdd->prepare('SELECT `follow_from` = :id OR `follow_to` = :id AS `follow_id`, `nom`, `prenom`, `nom_utilisateur` FROM `follow` LEFT JOIN `utilisateurs` ON `id` = `follow_from` OR `id` = `follow_to` WHERE `follow_from` = :id OR `follow_to` = :id AND `follow_confirm` = :confirm AND `role` = 1 ORDER BY `nom`');
          $requestfollow->bindValue('confirm','1', PDO::PARAM_INT);
          $requestfollow->bindValue('id',$id, PDO::PARAM_INT);
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
            $request = $bdd->prepare('SELECT `id` FROM `utilisateurs` WHERE `nom_utilisateur` = :user');
            $request->bindValue(':user',$patient, PDO::PARAM_STR);
            $request->execute();
            $request = $request->fetch();
            $idpatient = $request['id'];
            $requestsearch = $bdd->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `nom_utilisateur` = :user AND `follow_to` = :id OR `follow_from` = :id AND `follow_confirm` = :confirm ORDER BY `suivis`.`id` DESC');
            $requestsearch->bindValue(':idpatient',$idpatient, PDO::PARAM_INT); 
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
              // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant
               $requestarray = $requestsearch->fetchAll(PDO::FETCH_ASSOC);
              //while()
                foreach($requestarray as $result) { 
                ?><tr>
                    <td><?php echo $result['date_du_jour']; ?></td>
                    <td><?php echo $result['resultat']; ?></td>
                    <td><?php echo $result['date_prochaine_verif']; ?></td>
                </tr><?php
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
$nbresult = 0;
    $patient = $_POST['patient'];
    $requestsearch = $bdd->prepare('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y H:i") AS date_du_jour, `resultat` FROM `suivis` LEFT JOIN `utilisateurs` ON `suivis`.`id_utilisateur` = :idpatient LEFT JOIN `follow` ON `role` = :role WHERE `follow_to` = :id OR `follow_from` = :id AND `follow_confirm` = :confirm');
    $requestsearch->bindValue(':id',$id, PDO::PARAM_INT);
    $requestsearch->bindValue(':confirm','1', PDO::PARAM_STR);
    $requestsearch->bindValue(':role','1', PDO::PARAM_STR);
    $requestsearch->bindValue(':idpatient',$idpatient, PDO::PARAM_STR);
    $requestsearch->execute();
    foreach($requestsearch->fetchAll(PDO::FETCH_UNIQUE) as $day => $result) {
        foreach($result as $resultchart) {
            $dataPoints[$nbresult] = array('label'=>$day, 'y'=>$resultchart);
        }
        $nbresult++;
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
  }
include 'footer.php';