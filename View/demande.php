<?php
include '../Controller/verificationconnexion.php';
if(isset($_SESSION['user'])){
        include '../Model/follow.php';
        include '../Controller/demandeController.php';
      //  include '../Model/addfollow.php';
    ?>
    <div class="container">
      <div class="row">
          <div class="col-lg-offset-5"><h2> Demande de suivis</h2></div>
      </div>     
    </div>
    <p class="col-lg-12"><?php echo $successAddMsg.' '.$successDeniedMsg ?></p>
    <?php if($requestFollow != NULL) { ?>
    <table class="tablename table table-bordered result">
        <thead>
          <tr>
            <th class="col-lg-1">Nom :</th>
            <th class="col-lg-1">Prénom :</th>
            <th class="col-lg-1">Nom d'utilisateur :</th>
            <th class="col-lg-1">Accepter :</th>
            <th class="col-lg-1">Refuser :</th>
          </tr>
        </thead>
        <tbody><?php
        foreach($requestFollow as $follow) {
          ?><tr>
              <td><?php echo stripslashes(strip_tags($follow['nom']));?></td>
              <td><?php echo stripslashes(strip_tags($follow['prenom']));?></td>
              <td><?php echo stripslashes(strip_tags($follow['nom_utilisateur']));?></td>
              <td><form method="POST" action="demande.php">
              <input type="hidden" name="username" value="<?php echo $follow['follow_from']; ?>">
              <input type="hidden" name="action" value="add">
              <input type="submit" value="Accepter">
              </form></td>
              <td><form method="POST" action="demande.php">
              <input type="hidden" name="username" value="<?php echo $follow['follow_from']; ?>">
              <input type="hidden" name="action" value="delete">
              <input type="submit" value="X"/>
          </form></td>
          </tr> 
        <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    }
}
include 'footer.php';