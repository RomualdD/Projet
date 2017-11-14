<?php
  include 'header1.php';
?>

<div class="container">
  <div class="row">
    <div class="col-lg-offset-5"><h2>Profil</h2></div>
  </div>
  <div class="row">
    <div class="profil col-lg-offset-3 col-lg-5">
      <div class="subtitle col-lg-offset-3"><h3>Informations du patient :</h3></div>
      <div class="form-inline">
        <div class="input-group name">
            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group surname">
            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group birthday">
            <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group username">
            <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="username">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group password">
            <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="password">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group passwordverif">
            <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="passwordverif">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group mail">
            <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="mail">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group phone">
            <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="phone">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group otherphone">
            <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="otherphone">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group pathology">
            <span class="input-group-addon"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="pathology">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="formular col-lg-offset-3 col-lg-5">
        <div class="subtitle col-lg-offset-1"><h3>Formulaire d'informations médicales :</h3></div>
        <div class="form-inline">
          <div class="input-group rate">
              <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="name" value="Taux de glycémie">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
              <select class="timeverif">
                <option>Vérification par :</option>
                <option name="date">Heure</option>
                <option name="date">Jours</option>
                <option name="date">Mois</option>
              </select>
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group clock">
              <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="clock" value="Heures de vérification">
              <input type="text" class="form-control" name="clock">
              <input type="text" class="form-control" name="clock">
              <input type="text" class="form-control" name="clock">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group time">
              <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="time" value="Première vérification">
          </div>
          <div class="info">Format jj/mm/aaaa</div>
        </div>
        <div class="form-inline">
          <div class="input-group notif">
              <span class="input-group-addon"><i class="fa fa-bell" aria-hidden="true"></i></span>
              <select class="timeverif">
                <option>Notifications par :</option>
                <option name="notif">SMS</option>
                <option name="notif">Mail</option>
              </select>
          </div>
        </div>
        <input type="submit" value="Valider !" name="valid" class="button btn btn-default col-lg-offset-5">
      </div>
    </div>
  </div>
</div>

<?php
  include 'footer.php';
?>
