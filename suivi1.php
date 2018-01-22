<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
?>
<!-- Page suivi patient -->
<div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
  <div class="row">
    <?php
    if(isset($_POST['submit'])) {
      if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate']))){
        $rate=$_POST['rate'];
        $date = date('Y-m-d').' 00:00:00'; // Date du jour
        $nextverif = time() + (21 * 24 * 60 * 60); //On lui demande de calculer la date dans 21jours (3semaines)
        $futuredate = date('Y-m-d', $nextverif); // On récupère la nouvelle date
        $resultdate = $bdd->query('SELECT `date_du_jour` FROM `suivis` WHERE `id_utilisateur`="'.$id.'"');
        $resultdate = $resultdate->fetch();
        if($date != $resultdate['date_du_jour'] && ($id == $resultdate['id_utilisateur'])) {
          $req = $bdd->prepare('INSERT INTO `suivis`(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
          $req->execute(array(
          'id' => $id,
          'daydate' => $date,
          'result' => $rate,
          'futureverif' => $futuredate
          ));
        }
        else {
                $requestverifresult = $bdd->query('SELECT `resultat` FROM `suivis` WHERE `id_utilisateur` = '.$id.' AND `date_prochaine_verif` = "'.$futuredate.'"');
                $requestverifresult = $requestverifresult->fetch();
                $result = $requestverifresult['resultat'];
                if($rate != $result) {
                    $requestmodif = $bdd->prepare('UPDATE `suivis` SET `resultat` = :result WHERE `id_utilisateur` = :id AND `date_prochaine_verif` = :futureverif');
                    $requestmodif->bindValue('result',$rate,PDO::PARAM_STR);
                    $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
                    $requestmodif->bindValue('futureverif',$futuredate,PDO::PARAM_STR);
                    $requestmodif->execute();
                }
        }        
        // Recherche de l'heure a laquelle il faudra envoyer le mail
        $searchfuturedate = $bdd->query('SELECT `Heure1` FROM `verification` WHERE `id_utilisateur` = "'.$id.'"');
        $searchfuturedate = $searchfuturedate->fetch();
        $oneclock = $searchfuturedate['Heure1'];
        $futuredate = $futuredate.' '.$oneclock;
        // Modification de la prochaine vérifiacation dans la table vérification
        $requestmodif = $bdd->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
        $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
        $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
        $requestmodif->execute();
        }
      }
    ?>
    <form method="POST" action="suivi1.php" name="followedrate" >
    <div class="suivi form-group col-lg-offset-3">
      <label for="rate">Résultats de la prise de sang :</label>
      <input type="text" name="rate" placeholder="Taux obtenus" class="col-lg-offset-1" id="result" />
    </div>
    <input type="submit" value="Valider !" name="submit" class="btn btn-default col-lg-offset-5 addresult"/>
  </form>
  </div>
  <div class="row">
    <div class="col-lg-offset-4"><h3>Visualisation des résultats :</h3></div>
  </div>
  <div class="row">
    <div class="col-lg-offset-3"><p>En tableau :</p></div>
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
              // Pagination
                $total = $bdd->query('SELECT COUNT(*) AS total FROM `suivis` WHERE `id_utilisateur` = '.$id);
                $total = $total->fetch();
                $total = $total['total'];

                $nbresultat = 3;
                // Arrondit au nombre supérieur
                $nbPagesForResult = ceil($total/$nbresultat);

                if(isset($_GET['page'])) {
                    $actuallyPage = intval($_GET['page']);
                    if($actuallyPage > $nbPagesForResult) { // Si page actuelle est supérieur à nombres de pages
                        $actuallyPage = $nbPagesForResult;
                    }
                    elseif ($actuallyPage==0) {
                       $actuallyPage = 1; 
                    }
                }
                else {
                   $actuallyPage = 1; // page actuelle 1
                }

                $first = ($actuallyPage-1)*$nbresultat; // Calcule la première entrée

              // Récupération des valeurs date de la prise, le résultat et la date de la prochaine vérification du jour correspondant
                $requestbdd = $bdd->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y") AS `date_prochaine_verif` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'"ORDER BY `id` DESC limit '.$first.', '.$nbPagesForResult);
                $requestarray = $requestbdd->fetchAll(PDO::FETCH_ASSOC); //PDO FETCH_ASSOC empêche d'avoir deux fois la même valeur   
                foreach($requestarray as $result) {
                ?><tr>
                    <td><?php 
                    echo $result['date_du_jour']; ?></td>
                    <td><?php echo $result['resultat']; ?></td>
                    <td><?php echo $result['date_prochaine_verif']; ?></td>
                </tr><?php
              }
             ?>
          </tbody>
        </table>
        <nav class="col-lg-offset-4">
            <ul class="pagination">
            <?php
                    for($numberPage=1; $numberPage<=$nbPagesForResult; $numberPage++) { 
                        // Vérification que le numéro de page est égal à la page voulu
                        if($numberPage == $actuallyPage) { // Si page actuelle alors on lui attribue un id pageactive
                           ?><li class="page-item"><a id="pageactive" href="suivi1.php?page=<?php echo $numberPage;?>"><?php echo $numberPage; ?></a></li><?php
                        }	
                        else { // Sinon on écrit juste le nombre en rouge

                            ?><li class="page-item"><a href="suivi1.php?page=<?php echo $numberPage;?>"><?php echo $numberPage; ?></a></li><?php
                        }
                    }                       
            ?>
            </ul>
          </nav>
      </div>
  <div class="row">
      <div class="col-lg-offset-3"><p>En graphique :</p></div>
  </div>
  <div class="row">
      <div id="chartResult"></div>
  </div>
</div>
<?php
$dataPoints= array();
$nbresult = 0;
    $requestbdd = $bdd->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y"),`resultat` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'" ORDER BY `id` LIMIT 28');
    foreach($requestbdd->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE) as $day => $result) {
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
  include 'footer.php';
?>
