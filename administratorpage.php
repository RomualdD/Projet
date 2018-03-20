<?php 
     include 'View/header.php';
if($_SESSION['role'] == 1) {
    include_once 'configuration.php';
    include_once 'Model/dataBase.php';
    include_once 'Model/pathology.php';
    include_once 'Model/role.php';
    include 'Controller/administratorpageController.php';
    ?>
<div class="container view">
    <h2 class="col-lg-offset-2">Ajout informations dans la base de données</h2>
    <div class="col-lg-offset-3 col-lg-5">
        <form method="post" action="administratorpage.php">
            <div class="form-inline">
                <label class="col-lg-offset-1 col-lg-5" for="table">Choix de la table</label>
                <select name="table">
                  <option value="1">Role</option>
                  <option value="2">Pathologie</option>
                </select>           
            </div>
            <div class="form-group">
                <label for="role" class="col-lg-offset-1 col-lg-5">Nouvelle donnée</label>
                <div class="input-group surname col-lg-offset-3">
                    <input type="text" class="form-control" name="data" placeholder="Données" required>
                </div>
            </div>
            <div>
                <label for="submit" class="col-lg-offset-3  col-xs-offset-4"><input type="submit" name="submit" value="<?php echo VALID; ?>" class="button btn btn-default col-lg-offset-4"></label>
            </div>
        </form>
        <p class="successmessage"><?php echo $successAddMsg ?></p>
    </div>
</div>
<?php 
include 'View/footer.php';
} else {
    header('Location: /');
}
?>
