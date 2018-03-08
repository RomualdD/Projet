<?php
session_start();
include_once 'Model/dataBase.php';
include_once 'Model/users.php';
include_once 'Model/follow.php';
include_once 'Controller/qrcodeController.php';
include_once 'View/header.php';
if(!isset($_SESSION['user'])) {
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
}
else { 
    if($researchidParam != FALSE) {
        if($verif == '' && $follow->follow_to != $follow->follow_from && $roleUser != $role) {  
            ?><p>Suivi ajouté !</p><?php
        }
        elseif($verif == 0 && $follow->follow_to != $follow->follow_from && $roleUser != $role) {
            ?><p>Suivi modifié !</p><?php
        }
        elseif($roleUser == $role) {
            ?><p>Vous ne pouvez pas ajouter cette personne !</p><?php  
        }
        elseif($follow->follow_to == $follow->follow_from) {
            ?><p>Vous ne pouvez pas vous ajouter !</p><?php  
        }
        else {
            ?><p>Il y'a déjà un suivi !</p><?php
        }   
    }
    else {
        ?><p>Le paramètre est incorrect !</p><?php
    }
}
include 'View/footer.php';
?>