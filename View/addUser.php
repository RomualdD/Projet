<?php
session_start();
$idFollow = $_GET['idFollow'];
if(!isset($_SESSION['user'])) {
    include 'header.php'; 
    ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <script src="../assets/js/canvasjs.min.js"></script>
    <script src="../assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <link rel="icon" href="../logo.ico" />
    <link rel="stylesheet" href="../assets/css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
        <title>Ajout!</title>
    </head>
        <body>
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
            <?php 
            include '../Model/qrcodeconnexion.php';
            ?>
          <!--  <p class=" col-lg-offset-5">Accéder à la connexion pour rester sur la page</p>
            <button data-toggle="modal" data-target="#myModalConnexion" class="button btn btn-default  col-lg-offset-5 col-lg-2">Connexion</button>
            <div class="modal fade" id="myModalConnexion" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
               <!-- <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title col-lg-offset-3 col-lg-9"> Connexion :</h3>
                  </div>
                  <div class="modal-body">
                      <form action="addUser.php?idFollow=<?php echo $idFollow; ?>" method="POST">
                          <div class="form-inline">
                            <label class="col-lg-offset-3 col-lg-9" for="username">Nom d'utilisateur :</label>
                            <div class="input-group username col-lg-offset-3">
                                <span class="input-group-addon up"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" id="username" placeholder="Nom d'utilisateur ou mail" required>
                            </div>
                          </div>
                          <div class="form-inline">
                            <label class="col-lg-offset-3 col-lg-9" for="password">Mot de passe :</label>  
                            <div class="input-group password col-lg-offset-3">
                                <span class="input-group-addon up"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" id="password" placeholder="Mot de passe" required>
                            </div>
                          </div>
                          <div class="form-group col-lg-offset-7">
                          <input type="checkbox">Se rappeler de moi !
                          </div>
                          <input id="connexion" type="submit" value="Se connecter !" name="connexion" class="button btn btn-default col-lg-offset-4">
                          <div class="explication col-lg-offset-5"><p>J'ai perdu mes identifiants,<a href="">cliquez ici</a></p></div>
                      </form>
                       <!-- <script>
                    // -- // Connexion dans la page modal          
                            $(document).ready(function() {
                                $('#myModalConnexion').modal('show');
                                $('#connexion').click(function() {
                                    $.post(
                                         '../Model/qrcodeconnexion.php', {
                                             username: $('#username').val(),
                                             password: $('#password').val()
                                        },
                                        function(data) {
                                            if(data == 'Success') {
                                                alert('Connexion réussie !');
                                            }
                                            else {
                                                alert('Connexion non réussie !');
                                            }
                                        },
                                        'text' // Recevoir success ou failed
                                    );
                                });
                            });        
                        </script>
                  </div>
                  <div class="modal-footer">
                   <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fermer</button>
                  </div>
                </div>
              </div>
            </div>-->
    <?php
}
else {
    include 'header1.php';
    $researchParam = $db->query('SELECT `id` FROM `utilisateurs` WHERE qrcode ="'.$idFollow.'"');
    $researchidParam = $researchParam->fetch(PDO::FETCH_ASSOC);
    $idTo = $researchidParam['id'];
    
    $verifFollow = $db->query('SELECT `follow_confirm` FROM `follow` WHERE (`follow_to` ='.$idTo.' OR `follow_from` ='.$idTo.') AND (`follow_to` ='.$id.' OR `follow_from` ='.$id.')');
    $verif = $verifFollow->fetchColumn();
    if($verif == 0) {
    $addfollow = $db->prepare('INSERT INTO `follow`(`follow_from`, `follow_to`, `follow_confirm`, `follow_date`) VALUES(:id,:id_to,:confirm,NOW())');
    $addfollow->bindValue('id',$id,PDO::PARAM_STR);
    $addfollow->bindValue('id_to',$idTo, PDO::PARAM_INT);
    $addfollow->bindValue('confirm','1',PDO::PARAM_INT);
    $addfollow->execute();
    
    ?><p>Suivi ajouté !</p><?php
    }
    else {
        ?><p>Il y'a déjà un suivi !</p><?php
    }
}
?>
        </body>
    </html>