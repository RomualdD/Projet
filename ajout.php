<?php
include_once 'Controller/verificationconnexion.php';
if(isset($_SESSION['user'])) {
    include_once 'Model/follow.php';
    include_once 'Controller/ajoutController.php';
    ?>
    <div class="container view">
      <div class="row">
          <div class="col-lg-offset-5"><h2>Gestions de suivis</h2></div>
      </div>
    </div>
    <?php if(isset($_POST['name'])) { ?>
    <div class="col-lg-12">
    <table class="tablename table table-bordered result view">
      <thead>
        <tr>
          <th class="col-lg-1">Nom :</th>
          <th class="col-lg-1">Prénom :</th>
          <th class="col-lg-1">Nom d'utilisateur :</th>
          <th class="col-lg-1">Ajouter :</th>
        </tr>
      </thead>
      <tbody>
             <?php foreach($requestresearch as $element) {
                   ?><tr>
                        <td><?php echo $element->lastname; ?></td>
                        <td><?php echo $element->firstname; ?></td>
                        <td><?php echo $element->username; ?></td>
                        <td><?php if($element->follow_confirm == NULL) {
                        ?><form action="ajout.php" method="post"><input type="hidden" name="username" value="<?php echo $element->username;?>"/><input type="submit"/></form>
                            <?php } elseif($element->follow_confirm == 0) {
                            ?><i class="fas fa-hourglass-half"></i>
                            <?php } else {
                                ?><i class="far fa-check-circle"></i></td></tr><?php
                            }
                        } 
                  ?>
        </tbody>
    </table>
    </div>
<?php
        }
        else {
                if(isset($_POST['username'])) {
                    if($alreadyfollow != 0) {  ?>
                        <p class="view">Il y a déjà un suivi avec ce membre ! Retournez à votre profil pour faire une autre demande <a href="profil.php">Cliquez ici !</a></p><?php
                    }
                    elseif($id == $idfollow) {  ?>
                        <p class="view">Vous ne pouvez pas vous ajoutez ! Retournez à votre profil pour faire une autre demande <a href="profil.php">Cliquez ici !</a></p><?php
                    }
                   if($error == 0) { ?>
                        <p class="view">Ajout réussi, la personne demandé va recevoir votre demande pour la valider. Retourner à votre <a href="profil.php">profil</a></p><?php
                    }
                }
                else {
                    ?><p class="view">Vous n'avez pas mis un nom à rechercher. Retourner à votre <a href="profil.php">profil</a></p><?php
                }
            }
        }
?>
