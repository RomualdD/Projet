<?php
    include_once 'View/header.php';
    include_once 'Controller/userfallController.php';
?>
<!-- Page de connexion -->
  <div class="container view">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Identifiant oublié</h2></div>
    </div>
    <div class="row">
      <div class="connexion col-lg-offset-3 col-lg-5">
        <form action="userfall.php" method="post">
          <div class="row">
            <div class="subtitle col-lg-offset-3 col-sm-offset-3"><h3>Informations de l'utilisateur :</h3></div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="username">Mail :</label>
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="mail" class="form-control" name="mail" placeholder="mail" required>
            </div>
          </div>
          <input type="submit" value="Se connecter !" name="fallSubmit" class="button btn btn-default col-lg-offset-4">
        </form>
    </div>
  </div>
</div>

<?php
  include 'View/footer.php'
?>
