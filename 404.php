
<?php
session_start();
    include 'View/header.php';
if(isset($_SESSION['user'])) {   
    include 'Model/dataBase.php';
    include 'Model/users.php';
    $users = new users();
    $users->username = $_SESSION['user'];
    $userId = $users->getUserId();
    $id = $userId['id'];
    $user = $_SESSION['user'];
    $role = $_SESSION['role'];
    $pathology = $_SESSION['pathology'];
}
    
?>
<h2 class="error404">Attention ! Erreur 404</h2>
<p>Cette page n'existe pas ! Afin de continuer votre poursuite du suite, veuillez cliquer <a href='View/index.php'>ici pour aller à l'accueil</a></p>
<?php
include 'View/footer.php';
?>
