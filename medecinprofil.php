<?php
  include 'header1.php';
?>
<!-- Page profil médecin -->
<div class="container">
  <div class="row">
    <div class="col-lg-offset-5"><h2>Profil</h2></div>
  </div>
  <div class="row">
    <div class="profil col-lg-offset-3 col-lg-5">
      <div class="subtitle col-lg-offset-3"><h3>Informations du patient :</h3></div>
      <div class="form-inline">
        <div class="input-group name col-lg-offset-3">
            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group surname col-lg-offset-3">
            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group birthday col-lg-offset-3">
            <span class="input-group-addon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="name">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group username col-lg-offset-3">
            <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="username">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group password col-lg-offset-3">
            <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
            <input type="password" class="form-control" name="password">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group passwordverif col-lg-offset-3">
            <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
            <input type="password" class="form-control" name="passwordverif">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group mail col-lg-offset-3">
            <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="mail">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group phone col-lg-offset-3">
            <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="phone">
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group otherphone col-lg-offset-3">
            <span class="input-group-addon phoneup"><i class="fa fa-mobile" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="otherphone">
        </div>
      </div>
    </div>
    <div class="modificate col-lg-offset-3 col-lg-5">
      <div class="row">
        <div class="subtitle col-lg-offset-1"><h3>Informations du compte à modifier :</h3></div>
        <div class="form-inline">
          <div class="input-group password col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="password" placeholder="Mot de passe actuel">
          </div>
         </div>
          <div class="form-inline">
            <div class="input-group newpassword col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="newpassword" placeholder="Nouveau mot de passe">
            </div>
          </div>
          <div class="form-inline">
            <div class="input-group passwordverif col-lg-offset-3">
              <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" name="passwordverif" placeholder="Vérfication nouveau mot de passe">
            </div>
          </div>
        <input type="submit" value="Valider !" name="valid" class="button btn btn-default col-lg-offset-5">
        </div>
        <div class="row">
          <div class="modificatemail col-lg-offset-3">
            <div class="form-inline">
              <div class="input-group mail">
                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="newmail" placeholder="Nouvelle adresse mail">
              </div>
            </div>
            <input type="submit" value="Modifier !" name="modificatemail" class="button btn btn-default col-lg-offset-3">
          </div>
        </div>
        <div class="row">
          <div class="modificatenum col-lg-offset-3">
            <div class="form-inline">
              <div class="input-group mail">
                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="newnum" placeholder="Modifier numéro de téléphone">
              </div>
            </div>
            <input type="submit" value="Modifier !" name="addnum" class="button btn btn-default col-lg-offset-3">
          </div>
        </div>
        <div class="row">
          <div class="newnum col-lg-offset-3">
            <div class="form-inline">
              <div class="input-group mail">
                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="newnum" placeholder="Nouveau numéro de téléphone">
              </div>
            </div>
            <input type="submit" value="Modifier !" name="addnum" class="button btn btn-default col-lg-offset-3">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="search col-lg-offset-3">
        <div class="form-inline">
          <div class="input-group search">
            <span class="input-group-addon"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
            <input type="text" class="form-control" name="searchpatient" placeholder="Rechercher son patient">
          </div>
          <input type="submit" value="Voir les demandes" name="answerpatient" class="button btn btn-default col-lg-offset-1" data-toggle="modal" data-target="#myModal">
          <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Demande suivi du patient :</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="array">
                      <table class="patienttable" id="Patient">
                        <thead>
                          <tr>
                            <th>Nom : </th>
                            <th>Prénom : </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <input type="submit" value="Rechercher !" name="addpatient" class="button btn btn-default col-lg-offset-1" data-toggle="modal" data-target="#myModal">
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Recherche du patient :</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="array">
                    <table class="doctortable" id="doctorarray">
                      <thead>
                        <tr>
                          <th>Nom : </th>
                          <th>Prénom :</th>
                          <th>Localité :</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  include 'footer.php';
?>
