<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
    include 'header1.php';
    ?>
    <div class="container">
      <div class="row">
          <div class="col-lg-offset-5"><h2> Demande de suivis</h2></div>
      </div>
    </div>
    <?php
    $requestfollow = $bdd->prepare('SELECT follow_from, follow_date,nom,prenom,nom_utilisateur FROM follow LEFT JOIN utilisateurs ON id=follow_from WHERE follow_to = :id AND follow_confirm = :confirm');
    $requestfollow->bindValue(':id',$id, PDO::PARAM_INT);
    $requestfollow->bindValue(':confirm','0', PDO::PARAM_STR);
    $requestfollow->execute();
        ?><table class="tablename table table-bordered result">
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
     while ($reqfollow = $requestfollow->fetch()) {
        ?><tr><td><?php echo stripslashes(htmlspecialchars($reqfollow['nom']));?></td><td><?php
        echo stripslashes(htmlspecialchars($reqfollow['prenom']));?></td><td><?php
        echo stripslashes(htmlspecialchars($reqfollow['nom_utilisateur']));?></td><td>
        <form method="post" action="demande.php">
            <input type="hidden" name="username" value="<?php echo $reqfollow['follow_from']; ?>"/>
            <input type="hidden" name="action" value="add"/>
            <input type="submit" value="Accepter"/>
        </form></td><td>
        <form method="post" action="demande.php">
            <input type="hidden" name="username" value="<?php echo $reqfollow['follow_from']; ?>"/>
            <input type="hidden" name="action" value="delete"/>
            <input type="submit" value="X"/>
        </form></td></tr> <?php
     }?>
      </tbody>
        </table>
     <?php
     if(isset($_POST['username']) && ($_POST['action'] == 'add') ) {
         $member = (int) $_POST['username'];
         $follow = $bdd->prepare('UPDATE follow SET follow_confirm = :confirm WHERE follow_from = :member AND follow_to = :id');
         $follow->bindValue(':confirm','1',PDO::PARAM_STR);
         $follow->bindValue(':member',$member, PDO::PARAM_INT);
         $follow->bindValue(':id', $id, PDO::PARAM_INT);
         $follow->execute();
         if($role == 1) {
             echo 'Votre médecin vous suit désormais !';
         }
         else {
             echo 'Votre patient vous suit désormais !';
         }
     }
     elseif(isset($_POST['username']) && (($_POST['action']) == 'delete')) {
         $member = (int) $_POST['username'];
         $requestrefuse = $bdd->prepare('DELETE FROM follow WHERE follow_from = :member AND follow_to = :id');
         $requestrefuse->bindValue(':member',$member,PDO::PARAM_INT);
         $requestrefuse->bindValue(':id',$id,PDO::PARAM_INT);
         $requestrefuse->execute();
         echo 'Refus enregistré';
   }
}
include 'footer.php';