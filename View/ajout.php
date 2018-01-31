<?php
include '../Controller/verificationconnexion.php';
if(isset($_SESSION['user'])) {
    include '../Model/follow.php';
    include '../Controller/ajoutController.php';
    ?>
    <div class="container">
      <div class="row">
          <div class="col-lg-offset-5"><h2>Gestions de suivis</h2></div>
      </div>
    </div>
    <?php if(isset($_POST['name'])) { ?>
    <div class="col-lg-12">
    <table class="tablename table table-bordered result">
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
                        <td><?php echo $element['nom']; ?></td>
                        <td><?php echo $element['prenom']; ?></td>
                        <td><?php echo $element['nom_utilisateur']; ?></td>
                    <td><form  action="ajout.php" method="post"/><input type="hidden" name="username" value="<?php echo $element['nom_utilisateur'];?>"/><input type="submit" /></form></td></tr><?php
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
                        <p>Il y a déjà un suivi avec ce membre ! Retournez à votre profil pour faire une autre demande <a href="profil.php">Cliquez ici !</a></p><?php
                    }
                    elseif($id == $idfollow) {  ?>
                        <p>Vous ne pouvez pas vous ajoutez ! Retournez à votre profil pour faire une autre demande <a href="profil.php">Cliquez ici !</a></p><?php
                    }
                   if($error == 0) {
?>
                        <p>Ajout réussi, la personne demandé va recevoir votre demande pour la valider. Retourner à votre <a href="profil.php">profil</a></p><?php
                    }
                }
                else {
                    ?><p>Vous n'avez pas mis un nom à rechercher. Retourner à votre <a href="profil.php">profil</a></p><?php
                }
            }
        }
?>