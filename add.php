<?php
    include 'View/header.php';
if(isset($_SESSION['user'])) {
    include_once 'Model/follow.php';
    include_once 'Controller/addController.php';
    ?>
    <div class="container view">
      <div class="row">
          <div class="col-lg-offset-5"><h2><?php echo SUBTITLEADDFOLLOW; ?></h2></div>
      </div>
    </div>
    <?php if(isset($_POST['name'])) { ?>
    <div class="col-lg-12">
    <table class="tablename table table-bordered result view">
      <thead>
        <tr>
          <th class="col-lg-1"><?php echo NAMEFOLLOW; ?></th>
          <th class="col-lg-1"><?php echo FIRSTNAME; ?></th>
          <th class="col-lg-1"><?php echo USERNAME; ?></th>
          <th class="col-lg-1"><?php echo ADD; ?></th>
        </tr>
      </thead>
      <tbody>
             <?php foreach($requestresearch as $element) {
                   ?><tr>
                        <td><?php echo $element->lastname; ?></td>
                        <td><?php echo $element->firstname; ?></td>
                        <td><?php echo $element->username; ?></td>
                        <td><?php if($element->confirm == NULL) {
                            ?><form action="ajout" method="post"><input type="hidden" name="username" value="<?php echo $element->username;?>"/><button type="submit"><i class="fas fa-user-plus"></i></button></form>
                            <?php } elseif($element->confirm == 0) {
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
                        <p class="view"><?php echo ALREADYFOLLOW; ?> <a href="votre-profil"><?php echo CLICKHERE; ?></a></p><?php
                    }
                    elseif($id == $idfollow) {  ?>
                        <p class="view"><?php echo NOTPOSSIBLEFOLLOW; ?> <a href="votre-profil"><?php echo CLICKHERE; ?></a></p><?php
                    }
                   if($error == 0) { ?>
                        <p class="view"><?php echo SUCCESSFOLLOW; ?> <a href="votre-profil"><?php echo CLICKHERE; ?></a></p><?php
                    }
                }
                else {
                    ?><p class="view"><?php echo NAMENULL; ?> <a href="profil.php"><?php echo CLICKHERE; ?></a></p><?php
                }
            }
        }
?>
