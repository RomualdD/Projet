<?php
    include 'View/header.php';
if(isset($_SESSION['user'])){
        include_once 'Model/follow.php';
        include_once 'Controller/questController.php';
    ?>
    <div class="container">
      <div class="row view">
          <div class="col-lg-offset-5"><h2><?php echo SUBTITLEQUEST; ?></h2></div>
      </div>     
    </div>
    <p class="col-lg-12"><?php echo $successAddMsg.' '.$successDeniedMsg ?></p>
    <?php if($requestFollow != NULL) { ?>
    <table class="tablename table table-bordered result view">
        <thead>
          <tr>
            <th class="col-lg-1"><?php echo LASTNAME ?></th>
            <th class="col-lg-1"><?php echo FIRSTNAME; ?></th>
            <th class="col-lg-1"><?php echo USERNAME; ?></th>
            <th class="col-lg-1"><?php echo ADD; ?></th>
            <th class="col-lg-1"><?php echo DENIED; ?></th>
          </tr>
        </thead>
        <tbody><?php
        foreach($requestFollow as $follow) {
          ?><tr>
              <td><?php echo stripslashes(strip_tags($follow->lastname));?></td>
              <td><?php echo stripslashes(strip_tags($follow->firstname));?></td>
              <td><?php echo stripslashes(strip_tags($follow->username));?></td>
              <td><form method="POST" action="demande">
              <input type="hidden" name="username" value="<?php echo $follow->to; ?>">
              <input type="hidden" name="action" value="add">
              <button type="submit"><i class="fas fa-user-plus"></i></button>
              </form></td>
              <td><form method="POST" action="demande">
              <input type="hidden" name="username" value="<?php echo $follow->to; ?>">
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
include 'View/footer.php';