<?php
    include_once 'View/header.php';
    include_once 'Controller/userfallController.php';
?>
<!-- Page de connexion -->
  <div class="container view">
    <div class="row">
      <div class="col-lg-offset-4"><h2><?php echo FALLLOGIN; ?></h2></div>
    </div>
    <div class="row">
      <div class="connexion col-lg-offset-3 col-lg-5">
        <form action="userfall.php" method="post">
          <div class="row">
            <div class="subtitle col-lg-offset-3 col-sm-offset-3"><h3><?php echo USERINFORMATION; ?></h3></div>
          </div>
          <div class="form-inline">
            <label class="col-lg-offset-3 col-lg-9" for="username"><?php echo MAIL; ?></label>
            <div class="input-group username col-lg-offset-3">
                <span class="input-group-addon up"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                <input type="mail" class="form-control" name="mail" placeholder="<?php echo MAILPLACEHOLDER; ?>" required>
            </div>
          </div>
          <input type="submit" value="<?php echo VALID; ?>" name="fallSubmit" class="button btn btn-default col-lg-offset-4">
        </form>
    </div>
  </div>
</div>

<?php
  include 'View/footer.php'
?>
