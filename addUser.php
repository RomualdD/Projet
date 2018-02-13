<?php
session_start();
include 'Model/dataBase.php';
include 'Model/users.php';
include 'Model/follow.php';
include 'Controller/qrcodeController.php';
$idFollow = $_GET['idFollow'];
if(!isset($_SESSION['user'])) {
     include 'View/header.php';
    ?>
    <div class="container">
        <div class="row view">
            <h2 class="col-lg-offset-5">Ajout à partir d'un QRcode</h2>
            <form action="addUser.php?idFollow=<?php echo $idFollow; ?>" method="POST">
              <div class="row">
                <div class="subtitle col-lg-offset-3"><h3>Informations de connexion :</h3></div>
              </div>
              <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9" for="username">Nom d'utilisateur :</label>
                <div class="input-group username col-lg-offset-3">
                    <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur ou mail" required>
                </div>
              </div>
              <div class="form-inline">
                <label class="col-lg-offset-3 col-lg-9" for="password">Mot de passe :</label>  
                <div class="input-group password col-lg-offset-3">
                    <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                </div>
              </div>
              <div class="form-group col-lg-offset-7">
              <input type="checkbox">Se rappeler de moi !
              </div>
              <input type="submit" value="Se connecter !" name="connexion" class="button btn btn-default col-lg-offset-4">
              <div class="explication col-lg-offset-5"><p>J'ai perdu mes identifiants,<a href="">cliquez ici</a></p></div>
            </form>
        </div>
    </div>
    <?php
    include 'View/footer.php';
}
else {   
    $role = $_SESSION['role'];
    include 'View/header.php';
    if($verif == 0 && $follow->follow_to != $follow->follow_from) {  
    ?><p>Suivi ajouté !</p><?php
    }
    else {
        ?><p>Il y'a déjà un suivi !</p><?php
    }
}
?>