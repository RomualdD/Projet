<?php
include_once 'View/header.php';
 ?>
<!-- Page d'accueil -->
  <div class="container">
    <div class="row">
        <div class="col-lg-offset-5 col-sm-offset-3 col-xs-offset-3"><h2><?php echo HOME; ?></h2></div>
    </div>
    <div class="row view">
      <div class="welcome col-lg-offset-2 col-xs-10"><h3><?php echo HOMEMESSAGE; ?></h3></div>
      <div class="subhead col-lg-offset-1 col-xs-12"><h4><?php echo WHO; ?></h4></div>
      <p class="col-xs-12"><?php echo WHOEEXPLAINONE; ?></p>
      <p class="col-xs-12"><?php echo WHOEXPLAINTWO; ?></p>
      <p class="col-xs-12"><?php echo WHOELAINTHREE; ?></p>
      <div class="subhead col-lg-offset-1 col-xs-12"><h4><?php echo WHAT; ?></h4></div>
      <p class="col-xs-12"><?php echo WHATEXPLAINONE; ?></p>
      <p class="col-xs-12"><?php echo WHATEXPLAINTWO; ?></p>
      <p class="col-xs-12"><?php echo WHATEXPLAINTHREE; ?></p>
      <div class="subhead col-lg-offset-1 col-xs-12"><h4><?php echo WHY; ?></h4></div>
      <p class="col-xs-12"><?php echo WHYEXPLAIN; ?></p>
      <div class="subhead col-lg-offset-1 col-xs-12"><h4><?php echo COMPLEMENTARYINFORMATIONS; ?></h4></div>
      <p class="col-xs-12"><?php echo COMPLEMENTARYINFORMATIONSEXPLAIN; ?></p>
    </div>
  </div>
<?php
  include_once 'View/footer.php';
?>
