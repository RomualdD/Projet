<?php
  include '../Model/verificationconnexion.php';
if(isset($_SESSION['user'])) {  
  $pathology = $_SESSION['pathology'];
  include '../Model/addResult.php';
  include '../Model/showtable.php';
  include '../Model/showgraphic.php';
  if ($role==0) {
    header('Location:suivimedecin.php');
    exit();
  }
  else {
?>
    <!-- Page suivi patient -->
    <div class="container">
      <div class="row">
          <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
      </div>
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
    // Résultats indexé selon la valeur de la première colonne soit date du jour
    foreach($requestSearchGraphic->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE) as $day => $result) {
        foreach($result as $resultchart) {
            $dataPoints[$nbresult] = array('label'=>$day, 'y'=>$resultchart);
        }
        $nbresult++;
    }
    $bdd = NULL;
    include '../Model/graphic.php';
  }
}  
  include 'footer.php';
?>
