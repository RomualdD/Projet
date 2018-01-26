<?php
  include '../Model/verificationconnexion.php';
  if(isset($_SESSION['user'])) { 
    if($role == 1) {
          header('Location:../suivi.php');
    } 
    else {   
  include '../Model/voiceresultpatient.php';
  ?>
  <div class="container">
  <div class="row">
      <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
  </div>
      <?php
       if(empty($_POST['patient'])) {
      ?>
  <div class="row">
    <form name="followedrate" method="POST" action="suivimedecin.php">
    <div class="suivi form-group col-lg-offset-4">
      <label for="text">Choisir son patient :</label>
      <select name="patient"><?php
              foreach ($follow as $followPatient) {
                ?><option value="<?php echo $followPatient['nom_utilisateur'] ?>"><?php echo $followPatient['nom'].' '.$followPatient['prenom'];?></option><?php
            }
          ?>
      </select>
    </div>
    <input type="submit" value="Valider !" name="valider" class="btn btn-default col-lg-offset-5 addresult"/>
  </form>
  </div>
      <?php
      }
       else {
      ?>
         <div class="row">
        <form action="suivimedecin.php" method="POST">
            <div class="suivi form-group col-lg-offset-4">
              <label for="text">Choisir son patient :</label>
              <select name="patient"><?php
                      foreach ($follow as $followPatient) {
                        ?><option value="<?php echo $followPatient['nom_utilisateur'] ?>"><?php echo $followPatient['nom'].' '.$followPatient['prenom'];?></option><?php
                    }
                  ?>
              </select>
            </div>       
            <div class="col-lg-offset-4"><p>Entrez les dates pour voir le suivi d'une période :</p></div>
            <div class="col-lg-offset-3">
              <label for="firstDate">Première date :</label>
              <input type="date" name="date1">
              <label for="secondeDate">Seconde date :</label>
              <input type="date" name="date2">
          </div>  
          <input type="submit" value="Valider !" name="addDate" class="btn btn-default col-lg-offset-5 addresult"/>
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
                foreach($requestarray as $result) { 
                ?><tr>
                    <td><?php echo $result['date_day']; ?></td>
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
    foreach($requestsearch->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE) as $day => $result) {
        foreach($result as $resultchart) {
            $dataPoints[$nbresult] = array('label'=>$day, 'y'=>$resultchart);
        }
        $nbresult++;
    }
    $bdd = NULL;
    include '../Model/viewgraphic.php';
    }
    ?></div><?php
  }
}
include 'footer.php';