<?php
    include 'View/header.php';
if(isset($_SESSION['user'])) {  
  include_once 'Model/verification.php';
  include_once 'Model/suivis.php';
  include_once 'Model/follow.php';
  include 'Controller/suiviController.php';
  ?><div class="container view">
        <div class="row">
            <div class="col-lg-offset-5 col-sm-offset-4 col-sm-6 col-xs-offset-2"><h2> <?php echo FOLLOWEDTITLE; ?></h2></div>
        </div><?php
    if($role == 3) {
       if(empty($_POST['patient'])) {
      ?>
    <div class="row">
      <form name="followedrate" method="POST" action="suivis">
          <div class="suivi form-group col-lg-offset-4 col-sm-offset-2 col-xs-offset-3">
            <label for="text"><?php echo CHOOSEPATIENT; ?></label>
            <select name="patient"><?php
                    foreach ($followDoctor as $followPatient) {
                      ?><option value="<?php echo $followPatient->username ?>"><?php echo $followPatient->lastname.' '.$followPatient->firstname;?></option><?php
                  }
                ?>
            </select>
          </div>
          <input type="submit" value="<?php echo VALID; ?>" name="valider" class="btn btn-default col-lg-offset-5 addresult col-xs-offset-4"/>
      </form>
    </div>
  </div>
      <?php
      }
       else {
      ?>
    <div class="row suivi">
        <form action="suivis" method="POST">
            <div class="suivi form-group col-lg-offset-4 col-xs-offset-4">
              <label for="text"><?php echo CHOOSEPATIENT; ?></label>
              <select name="patient"><?php
                      foreach($followDoctor as $followPatient) {
                        ?><option value="<?php echo $followPatient->username ?>" <?php echo $_POST['patient'] == $followPatient->username ? 'selected': ''?>><?php echo $followPatient->lastname.' '.$followPatient->firstname;?></option><?php
                    }
                  ?>
              </select>
            </div>       
            <div class="col-lg-offset-4"><p><?php echo CHOOSEDATE; ?></p></div>
            <div class="col-lg-offset-4 col-xs-offset-1">
              <label for="firstDate"><?php echo FIRSTDATE; ?></label>
              <input type="date" name="date1">
              <label for="secondeDate"><?php echo SECONDDATE; ?></label>
              <input type="date" name="date2">
          </div>  
          <input type="submit" value="<?php echo VALID; ?>" name="addDate" class="btn btn-default col-lg-offset-5 addresult col-xs-offset-4"/>
        </form>
    </div>
  <div class="row">
    <div class="col-lg-offset-4 col-sm-offset-3 col-sm-9"><h3><?php echo VIEWRESULT; ?></h3></div>
  </div>
  <div class="row">
    <div class="col-lg-offset-3"><?php echo INARRAY; ?></div>
  </div>
      <div class="row">
        <table class="tableresult table table-bordered result col-lg-1 col-xs-1">
          <thead>
            <tr>
              <th><?php echo RESULTDAY; ?></th>
              <th class="col-lg-3 col-xs-3"><?php echo RESULT; ?></th>
              <th><?php echo FUTUREDAY; ?></th>
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
      <div class="col-lg-offset-3"><?php echo INGRAPHIC; ?></div>
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
            <div class="col-lg-offset-3 col-sm-offset-3 col-xs-offset-1">
                <div class="form-inline">
                    <label for="rate"><?php echo RESULTBLOODTEST; ?> </label>
                    <div class="input-group subject col-lg-offset-1 col-lg-3 col-sm-4 col-md-4 col-xs-10">
                        <span class="input-group-addon"><i class="fa fa-medkit" aria-hidden="true"></i></span>
                        <input type="text" name="rate" placeholder="<?php echo BLOODTESTPLACEHOLDER; ?>" class="form-control" id="result"/>
                    </div>
                </div>
            </div>
        <input type="submit" value="<?php echo VALID; ?>" name="submit" class="btn btn-default col-lg-offset-5 addresult col-sm-offset-5 col-xs-offset-3"/>
      </form>
          <p class="successmessage col-lg-offset-4 col-lg-8 col-xs-offset-4"><?php echo $successAddMsg; ?></p>
          <p class="errormessage col-lg-offset-4 col-lg-8 col-xs-offset-4"><?php echo $errorResult; ?></p>
      </div>
    <?php
    if($total != 0) { ?>
      <div class="row">
        <div class="col-lg-offset-4 col-xs-offset-1"><h3><?php echo VIEWRESULT; ?></h3></div>
      </div>
      <div class="row">
          <div class="col-lg-offset-3"><p><?php echo INARRAY; ?></p></div>
      </div>
      <div class="row">
        <table class="tableresult table table-bordered result col-lg-3 col-xs-1">
          <thead>
            <tr>
              <th><?php echo RESULTDAY; ?></th>
              <th class="col-lg-3  col-xs-3"><?php echo RESULT; ?></th>
              <th><?php echo FUTUREDAY; ?></th>
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
        <nav class="col-lg-offset-3 col-lg-9 col-xs-offset-3">
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
          <div class="col-lg-offset-3 col-xs-offset-1"><p><?php echo INGRAPHIC; ?></p></div>
      </div>
      <div class="row suivi">
          <div class="col-lg-offset-4 "><p><?php echo CHOOSEDATE; ?></p></div>
          <form action="suivis" method="POST">
            <div class="col-lg-offset-2">
                <label for="firstDate" class="col-xs-offset-1"><?php echo FIRSTDATE; ?></label>
                <input type="date" name="date1">
                <label for="secondeDate" class="col-lg-offset-1 col-xs-offset-1"><?php echo SECONDDATE; ?></label>
                <input type="date" name="date2">
            </div>  
            <input type="submit" value="<?php echo VALID; ?>" name="addDate" class="btn btn-default col-lg-offset-5 col-xs-offset-3"/>
          </form>
      </div>
      <div class="row">
          <div id="chartResult"></div>
      </div>
      <?php 
        } else {
            ?><p><?php echo NORESULT; ?></p> <?php
        }  
    } ?>
</div>
 <?php } else {
    ?><p><?php echo $errorConnexion; ?></p><?php
  }  
  include 'View/footer.php';
?>
