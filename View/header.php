<?php 
    include_once 'Controller/headerController.php'; 
?>
<!-- Header non connecté -->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="/assets/js/canvasjs.min.js"></script>
    <script src="/assets/js/jquery-3.2.1.slim.min.js"></script>
    <link rel="icon" href="/logo.ico"/>
    <link href="/assets/css/fontawesome-free-5.0.6/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link href="/assets/css/style.css" rel="stylesheet"/>
    <link href="/assets/lang/FR_FR.php">
    <link rel="stylesheet" href="/assets/css/impression.css" media="print">
    <title><?php echo TITLE; ?></title>
  </head>
  <body>   
      <?php 
    if(!isset($_SESSION['user'])) {
?>
    <header>
      <div class="container-fluid">
        <div class="row">
          <div class="logo col-lg-1 col-xs-1" itemscope><img itemprop="image" src="/assets/img/logo.png" alt="logosite" title="Logo diavk" width="70px" height="70px"/></div>
          <div class="title col-lg-offset-4 col-lg-2 col-sm-offset-4 col-xs-offset-2 col-xs-5" itemscope<h1 itemprop="name">><?php echo WEBSITETITLE; ?></h1></div>
          <div class="hello col-lg-offset-3 col-lg-2 col-sm-offset-1" data-toggle="modal" data-target="#myModalConnexion"><p class="connexionheader"><?php echo MODALCONNECT; ?></p></div>        
          <div class="modal fade" id="myModalConnexion" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h3 class="modal-title"> <?php echo CONNECT; ?></h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                              <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 col-sm-offset-3 col-sm-9" for="username"><?php echo USERNAME; ?></label>
                                <div class="input-group username col-lg-offset-3 col-sm-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" id="username" class="form-control" name="username" placeholder="<?php echo USERNAMEPLACEHOLDER; ?>" required>
                                </div>
                              </div>
                              <div class="form-inline">
                                <label class="col-lg-offset-3 col-lg-9 col-sm-offset-3 col-sm-9" for="password"><?php echo PASSWORDCONNECT; ?></label>  
                                <div class="input-group password col-lg-offset-3 col-sm-offset-3">
                                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                    <input type="password" id="password" class="form-control" name="password" placeholder="<?php echo PASSWORDPLACEHOLDER; ?>" required>
                                </div>
                              </div>
                              <div class="form-group col-lg-offset-7 col-sm-offset-7 col-xs-offset-6">
                                <input type="checkbox" id="cookie" name="cookie"><?php echo RECALL; ?>
                              </div>
                              <div class="explication col-lg-offset-5 col-sm-offset-4 col-xs-offset-3"><p><?php echo LOOSELOGIN; ?> <a href="/mot-de-passe-oublier"><?php echo CLICK; ?></a></p></div>
                              <input type="submit" value="<?php echo CONNECTBUTTON; ?>" id="connexion" name="connexion" class="button btn btn-default col-lg-offset-4 col-sm-offset-4 col-xs-offset-4">
                                <p class="errormessage col-lg-offset-1 col-lg-9 errormessagemodal" id="errorMessageModal"><?php echo INCORRECTLOGIN; ?></p> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo CLOSE; ?></button>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
      </div>
      <nav class="navbar navbar-default">
	<div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                  <span class="sr-only"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="/" class="col-lg-offset-7 col-lg-5 col-md-offset-7 col-sm-offset-3 col-sm-9"><i class="fas fa-home"></i> <?php echo HOME; ?></a></li>
                    <li><a href="/inscription" rel-nofollow class="col-lg-offset-1 col-lg-12 col-sm-offset-1 col-sm-12"><i class="fas fa-user-plus"></i> <?php echo REGISTER; ?></a></li>
                    <li><a href="/connexion" rel-nofollow class="col-lg-offset-6 col-lg-6 col-sm-offset-6 col-sm-6"><i class="fas fa-sign-in-alt"></i> <?php echo CONNECTION; ?></a></li>
                    <li><a href="/contactez-nous" class="col-lg-offset-1 col-lg-12 col-sm-offset-1 col-sm-12"><i class="far fa-edit"></i> <?php echo CONTACT; ?></a></li>
                </ul>
            </div>
        </div>
      </nav>
    </header>
  <?php  }
    else { 
    ?>
      <!-- Header connecté -->
    <header>
      <div class="container-fluid">
        <div class="row">
          <div class="logo col-lg-1 col-xs-1"><img itemprop="image" src="../assets/img/logo.png" alt="logosite" title="Logo diavk" width="70px" height="70px"/></div>
          <div class="title col-lg-offset-4 col-lg-2 col-sm-offset-4 col-xs-offset-2 col-xs-5" itemprop="name"><h1><?php echo WEBSITETITLE; ?></h1></div>
          <div class="hello col-lg-offset-2 col-lg-3 col-sm-2"><p id="person"><?php echo HELLO ;?> <span itemprop="name"><?php echo $_SESSION['firstname'].' '.$_SESSION['name']; ?></span></p></div>
          <div class="quest col-lg-offset-2 col-lg-3" <?php echo ($nbquest == 0) ? 'hidden' : ''; ?>><p id="add"><i class="fas fa-user-plus"></i><span id="infoFollow" class="addQuest"><?php echo $nbquest; ?></span></p></div>
        </div>
      </div>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                      <span class="sr-only"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                </div>
                <?php if($role != 1) { ?>
                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="nav navbar-nav">
                          <li><a href="/" class="col-lg-offset-6 col-sm--offset-6"><i class="fas fa-home"></i> <?php echo HOME; ?></a></li>
                          <?php if($role == 3) { ?>
                          <li><a href="votre-profil" class="col-lg-offset-1 col-sm-offset-1"><i class="fas fa-user-md"></i> <?php echo PROFILE; ?></a></li>
                          <?php }
                          else { ?>
                          <li><a href="votre-profil" class="col-lg-offset-1 col-sm-offset-1"><i class="fas fa-user"></i> <?php echo PROFILE; ?></a></li>                
                        <?php  } ?>
                          <li><a href="rendez-vous" class="col-lg-offset-1 col-sm-offset-1"><i class="far fa-calendar-minus"></i> <?php echo INFORMATION; ?></a></li>
                          <li><a href="suivis" class="col-lg-offset-1 col-sm-offset-1"><i class="fas fa-stethoscope"></i> <?php echo FOLLOWED; ?></a></li>
                          <li><a href="contactez-nous" class="col-lg-offset-1 col-sm-offset-1"><i class="far fa-edit"></i> <?php echo CONTACT; ?></a></li>
                          <li><a href="Controller/deconnexion.php" class="col-lg-offset-1 col-sm-offset-1"><i class="fas fa-times-circle"></i> <?php echo DISCONNECT; ?></a></li>
                        </ul>
                    </div>                    
               <?php } else { ?>
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="nav navbar-nav">
                              <li><a href="/" class="col-lg-offset-6 col-sm--offset-6"><i class="fas fa-home"></i> <?php echo HOME; ?></a></li>
                              <li><a href="administratorpage.php" class="col-lg-offset-1 col-sm-offset-1"><i class="fab fa-adn"></i></i>Administration</a></li>
                              <li><a href="Controller/deconnexion.php" class="col-lg-offset-1 col-sm-offset-1"><i class="fas fa-times-circle"></i> <?php echo DISCONNECT; ?></a></li>
                            </ul>
                        </div>                       
              <?php } ?>
            </div>
        </nav>
    </header>
  <?php 
    }
  ?>