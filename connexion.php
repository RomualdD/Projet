<?php
  include 'header.php'
?>

  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Connexion</h2></div>
    </div>
    <div class="message col-lg-offset-2"><p>Bonjour, veuillez entrer votre Nom d'utilisateur et votre de mot de passe afin de continuer sur le site.</p>
    <p>Si vous n'êtes pas inscrit, veuillez-vous rendre sur la page <a href="inscription.php" class="link">inscription</a>.</p></div>
    <div class="row">
      <div class="connexion col-lg-offset-3 col-lg-5">
        <form action="" method="post">
          <div class="row">
            <div class="subtitle col-lg-offset-3"><h3>Informations de connexion :</h3></div>
          </div>
          <div class="form-group">
            <label for="texte">Nom d'utilisateur :</label>
            <input type="text" name="user" placeholder="Nom d'utilisateur" class="col-lg-offset-1">
          </div>
          <div class="form-group">
            <label for="texte">Mot de passe :</label>
            <input type="password" name="password" placeholder="Mot de Passe" class="col-lg-offset-1">
          </div>
          <div class="form-group col-lg-offset-7">
          <input type="checkbox">Se rappeler de moi !
          </div>
          <input type="submit" value="Se connecter !" class="button btn btn-default col-lg-offset-4">
          <div class="explication col-lg-offset-5"><p>J'ai perdu mes identifiants,<a href="">cliquez ici</a></p></div>
        </form>
    </div>
  </div>
</div>

<?php
/*  // Si les champs sont remplis
  if(isset($_POST['user']) && ($_POST['password']))
   {
      // SI les champs correspondent dans la base de données
      if($_POST['user'] == 'user') && ($_POST['password'] == 'password'))
       {
         // Démarrage d'une session
         session_start();

         //Enregistement dans la session:
         $_SESSION['user'] = $_POST['user'];
         $_SESSION['password'] = $_POST['password'];
       }
       //Le mot de passe ou le nom d'utilisateur n'a pas était reconnu
     else
      {
         echo "Utilisateur ou mot de passe incorrect !";
      }
   }
   // Les champs n'ont pas était remplis
   else
    {
      echo "Tous les champs n'ont pas était remplis !";
    }*/

  include 'footer.php'
?>
