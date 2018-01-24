<?php
include '../Model/verificationconnexion.php';
if(isset($_SESSION['user'])) {
    ?>
    <div class="container">
      <div class="row">
          <div class="col-lg-offset-5"><h2>Gestions de suivis</h2></div>
      </div>
    </div>
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
        <?php
        if(isset($_POST['name'])) {
                $name = $_POST['name'];
                $role = $_SESSION['role']; // on cherche le role pour chercher si il faut trouver les patients ou les médecins
                if($role == 1) {
                     $request = $bdd->query('SELECT `nom`, `prenom`, `nom_utilisateur` FROM `utilisateurs` WHERE `nom` like "'.$name.'" OR `prenom` like "'.$name.'" AND `role` = 0');
                 }
                 else {
                     $request = $bdd->query('SELECT `nom`, `prenom`, `nom_utilisateur` FROM `utilisateurs` WHERE `nom` like "'.$name.'" OR `prenom` like "'.$name.'" AND `role` = 1');
                 }
                 $requestbdd = $request->fetchAll(PDO::FETCH_ASSOC);
                 // On affectue NULL à l'objet PDO pour pouvoir fermer la connexion à la base de données
                $bdd = NULL;
                //while($requestbdd = $request->fetch(PDO::FETCH_ASSOC) ) {
                   foreach($requestbdd as $element) {
                   ?><tr>
                        <td><?php echo $element['nom']; ?></td>
                        <td><?php echo $element['prenom']; ?></td>
                        <td><?php echo $element['nom_utilisateur']; ?></td>
                    <td><form  action="ajout.php" method="post"/><input type="hidden" name="username" value="<?php echo $element['nom_utilisateur'];?>"/><input type="submit" /></form></td></tr><?php
                  } 
                  ?>
        </tbody>
    </div>
<?php
        }
        else {
                if(isset($_POST['username'])) {
                    $error = 0;
                    $username = $_POST['username'];
                    $idfollow = $bdd->query('SELECT `id` FROM `utilisateurs` WHERE `nom_utilisateur` = "'.$username.'"');
                    $idfollow = $idfollow->fetch();
                    $idfollow = $idfollow['id'];
                    $requestadd = $bdd->prepare('SELECT COUNT(*) AS nbfollow FROM `follow` WHERE `follow_from` = :id AND `follow_to` = :id_to');
                    $requestadd->bindValue(':id',$id,PDO::PARAM_INT);
                    $requestadd->bindValue(':id_to', $idfollow, PDO::PARAM_INT);
                    $requestadd->execute();
                    $alreadyfollow = $requestadd->fetchColumn();
                    $requestadd->closeCursor(); // Fin de requete
                    if($alreadyfollow != 0) {?>
                        <p>Ce membre est déjà vous suit déjà ! Retournez à votre profil pour faire une autre demande <a href="../profil.php">Cliquez ici !</a></p><?php
                        $error++;
                    }
                    if($id == $idfollow) {?>
                        <p>Vous ne pouvez pas vous ajoutez ! Retournez à votre profil pour faire une autre demande <a href="../profil.php">Cliquez ici !</a></p><?php
                        $error++;
                    }
                    if($error == 0) {
                        $requestadd = $bdd->prepare('INSERT INTO `follow`(`follow_from`, `follow_to`, `follow_confirm`, `follow_date`)VALUES(:id,:id_to,:confirm,NOW())');
                        $requestadd->execute(array(
                            'id' => $id,
                            'id_to' => $idfollow,
                            'confirm' => 0
                            ));?>
                        <p>Ajout réussi, la personne demandé va recevoir votre demande pour la valider. Retourner à votre <a href="../profil.php">profil</a></p><?php
                    }
                }
                else {
                    ?><p>Vous n'avez pas mis un nom à rechercher. Retourner à votre <a href="../profil.php">profil</a></p><?php
                }
            }
        }
?>