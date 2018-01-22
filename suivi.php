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
          if(!empty($_POST['rate']) && (preg_match('#^[0-9]+\.[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]$#',$_POST['rate'])) || (preg_match('#^[0-9]{2}$#',$_POST['rate']))){
              // Récupération du taux
            $rate= strip_tags($_POST['rate']);
            // Date du jour avec heure
            $date = date('Y-m-d H:i'); 
            // Date du jour
            $dateday = date('Y-m-d');
            // Horraire du jour afin de faire une comparaison
            $hour = date('Hi');
            // Récupération de la date de vérification et des heures demandés
            $searchfuturedate = $bdd->query('SELECT `id_utilisateur`,`date_verification`, `Heure1`, `Heure2`, `Heure3`, `Heure4` FROM `verification` WHERE `id_utilisateur` = "'.$id.'"');
            $searchfuturedate = $searchfuturedate->fetch();
            $iduser = $searchfuturedate['id_utilisateur'];
            $dateverif = $searchfuturedate['date_verification'];
            $oneclock = $searchfuturedate['Heure1'];
            $twoclock = $searchfuturedate['Heure2'];
            $threeclock = $searchfuturedate['Heure3'];
            $fourclock = $searchfuturedate['Heure4'];  
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
            $futuredate = $futuredate.' '.$futurehour.':00';
            if(($futuredate != $dateverif) && ($id == $iduser )) {
              // Ajout dans la table suivis pour récupéré ensuite les valeurs  
              $requestadd = $bdd->prepare('INSERT INTO suivis(`id_utilisateur`, `date_du_jour`, `resultat`, `date_prochaine_verif`) VALUES(:id, :daydate, :result, :futureverif)');
              $requestadd->execute(array(
              'id' => $id,
              'daydate' => $date,
              'result' => $rate,
              'futureverif' => $futuredate
              ));
              // Modification de la prochaine vérifiacation dans la table vérification
              $requestmodif = $bdd->prepare('UPDATE `verification` SET `date_verification` = :newdate WHERE `id_utilisateur` = :id');
              $requestmodif->bindValue('newdate',$futuredate,PDO::PARAM_STR);
              $requestmodif->bindValue('id',$id,PDO::PARAM_INT);
              $requestmodif->execute();
            }
            if($futuredate == $dateverif) {
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
          }
        }
        ?>
      <div class="row">
        <form name="followedrate" method="POST" action="suivi.php">
            <div class="col-lg-offset-3">
                <div class="form-inline">
                    <label for="rate">Résultats de la prise de sang : </label>
                    <div class="input-group subject col-lg-offset-1 col-lg-3 col-sm-4 col-md-4 col-xs-10">
                        <span class="input-group-addon"><i class="fa fa-medkit" aria-hidden="true"></i></span>
                        <input type="text" name="rate" placeholder="Taux obtenus" class="form-control" id="result"/>
                    </div>
                </div>
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
              $requestbdd = $bdd->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_du_jour`, `resultat`, DATE_FORMAT(`date_prochaine_verif`,"%d/%m/%Y %H:%i") AS `date_prochaine_verif` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'"ORDER BY `id` DESC LIMIT '.$first.', '.$nbPagesForResult);
              $requestarray = $requestbdd->fetchAll(PDO::FETCH_ASSOC); //PDO FETCH_ASSOC empêche d'avoir deux fois la même valeur
                foreach($requestarray as $result) {
                ?><tr>
                    <td><?php echo $result['date_du_jour'];?></td>
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
                           ?><li class="page-item"><a id="pageactive" href="suivi.php?page=<?php echo $numberPage;?>"><?php echo $numberPage; ?></a></li><?php
                        }	
                        else { // Sinon on écrit juste le nombre en rouge

                            ?><li class="page-item"><a href="suivi.php?page=<?php echo $numberPage;?>"><?php echo $numberPage; ?></a></li><?php
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
    // Pagination
    $total = $bdd->query('SELECT COUNT(*) AS total FROM `suivis` WHERE `id_utilisateur` = '.$id);
    $total = $total->fetch();
    $total = $total['total'];
    $nbresultat = 4;
    // Arrondit au nombre supérieur
    $nbPagesForResult = ceil($total/$nbresultat);
    $actuallyPage = $nbPagesForResult-1;
    $first = ($actuallyPage-1)*$nbresultat; // Calcule la première entrée
    
    $dataPoints= array();
    $nbresult = 0;
    // Récupération de la date du jour avec le résultat limité a 28 résultats (une semaine)
    $requestbdd = $bdd->query('SELECT DATE_FORMAT(`date_du_jour`,"%d/%m/%Y %H:%i") AS `date_du_jour`,`resultat` FROM `suivis` WHERE `id_utilisateur` = "'.$id.'" ORDER BY `id` LIMIT '.$first.', '.$nbPagesForResult);
    foreach($requestbdd->fetchAll(PDO::FETCH_UNIQUE) as $day => $result) {
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
  }
  include 'footer.php';
?>
