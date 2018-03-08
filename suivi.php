<?php
  include_once 'Controller/verificationconnexion.php';
if(isset($_SESSION['user'])) {  
  include_once 'Model/verification.php';
  include_once 'Model/suivis.php';
  include_once 'Model/follow.php';
  include 'Controller/suiviController.php';
  ?><div class="container view">
        <div class="row">
            <div class="col-lg-offset-5"><h2> Suivi du patient</h2></div>
        </div><?php
    if($role == 0) {
       if(empty($_POST['patient'])) {
      ?>
    <div class="row">
      <form name="followedrate" method="POST" action="suivis">
          <div class="suivi form-group col-lg-offset-4">
            <label for="text">Choisir son patient :</label>
            <select name="patient"><?php
                    foreach ($followDoctor as $followPatient) {
                      ?><option value="<?php echo $followPatient->username ?>"><?php echo $followPatient->lastname.' '.$followPatient->firstname;?></option><?php
                  }
                ?>
            </select>
          </div>
          <input type="submit" value="Valider !" name="valider" class="btn btn-default col-lg-offset-5 addresult"/>
      </form>
    </div>
  </div>
      <?php
      }
       else {
      ?>
    <div class="row suivi">
        <form action="suivis" method="POST">
            <div class="suivi form-group col-lg-offset-4">
              <label for="text">Choisir son patient :</label>
              <select name="patient"><?php
                      foreach($followDoctor as $followPatient) {
                        ?><option value="<?php echo $followPatient->username ?>" <?php echo $_POST['patient'] == $followPatient->username ? 'selected': ''?>><?php echo $followPatient->lastname.' '.$followPatient->firstname;?></option><?php
                    }
                  ?>
              </select>
            </div>       
            <div class="col-lg-offset-4"><p>Entrez les dates pour voir le suivi d'une période :</p></div>
            <div class="col-lg-offset-4">
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
        <table class="tableresult table table-bordered result col-lg-1">
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
                    <td><?php echo $result->date_now; ?></td>
                    <td><?php echo $result->result; ?></td>
                    <td><?php echo $result->next_date_check; ?></td>
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
      <?php }
    } 
    else {    
    ?>
    <!-- Page suivi patient -->
      <div class="row suivi">
        <form name="followedrate" method="POST" action="suivis">
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
          <p class="successmessage col-lg-offset-4 col-lg-8"><?php echo $successAddMsg; ?></p>
          <p class="errormessage col-lg-offset-4 col-lg-8"><?php echo $errorResult; ?></p>
      </div>
    <?php
    if($total != 0) { ?>
      <div class="row">
        <div class="col-lg-offset-4"><h3>Visualisation des résultats :</h3></div>
      </div>
      <div class="row">
          <div class="col-lg-offset-3"><p>En tableau :</p></div>
      </div>
      <div class="row">
        <table class="tableresult table table-bordered result col-lg-3">
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
                    <td><?php echo $result->date_now;?></td>
                    <td><?php echo $result->result; ?></td>
                    <td><?php echo $result->next_date_check; ?></td>
                </tr><?php
              }
             ?>
          </tbody>
        </table>
        <nav class="col-lg-offset-3 col-lg-9">
            <ul class="pagination">
            <?php
                for($numberPage=1; $numberPage<=$nbPage; $numberPage++) { 
                    // Vérification que le numéro de page est égal à la page voulu
                    if($numberPage == $actuallyPage) { // Si page actuelle alors on lui attribue un id pageactive
                       ?><li class="page-item"><a id="pageactive" href="suivis?page=<?php echo $numberPage;?>"><?php echo $numberPage; ?></a></li><?php
                    }	
                    else { // Sinon on écrit juste le nombre en rouge
                        ?><li class="page-item"><a href="suivis?page=<?php echo $numberPage;?>"><?php echo $numberPage; ?></a></li><?php
                    }
                }                       
            ?>
            </ul>
        </nav>
      </div>
      <div class="row">
          <div class="col-lg-offset-3"><p>En graphique :</p></div>
      </div>
      <div class="row suivi">
          <div class="col-lg-offset-4"><p>Entrez les dates pour voir le suivi d'une période :</p></div>
          <form action="suivis" method="POST">
            <div class="col-lg-offset-3">
                <label for="firstDate">Première date :</label>
                <input type="date" name="date1">
                <label for="secondeDate" class="col-lg-offset-1">Seconde date :</label>
                <input type="date" name="date2">
            </div>  
            <input type="submit" value="Valider !" name="addDate" class="btn btn-default col-lg-offset-5"/>
          </form>
      </div>
      <div class="row">
          <div id="chartResult"></div>
      </div>
      <?php 
        } else {
            ?><p>Aucun résultat entré !</p> <?php
        }  
    } ?>
</div>
 <?php } else {
    ?><p><?php echo $errorConnexion; ?></p><?php
  }  
  include 'View/footer.php';
?>
