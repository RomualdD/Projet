<?php
  include 'header.php'; // Si visiteur
  /*include 'header1.php'; //Si profil connecté */
?>
<!-- Page contact -->
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5"><h2>Contact</h2></div>
    </div>
    <div class="message col-lg-offset-2"><p>Bonjour, veuillez entrer votre Nom d'utilisateur et votre adresse mail pour obtenir une réponse à votre message.</p>
      <p>Des questions? Des remarques? N'hésitez pas à nous contacter.</p></div>
    <div class="row">
      <div class="contact col-lg-offset-3 col-lg-9">
        <div class="row">
          <div class="subtitle col-lg-offset-4"><h3>Contactez-nous :</h3></div>
        </div>
        <div class="form-inline">
          <div class="input-group name col-lg-offset-2">
              <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="name" placeholder="Nom de Famille et Prénom">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group mail col-lg-offset-2">
              <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="mail" placeholder="Adresse mail">
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group subject col-lg-offset-2">
              <span class="input-group-addon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="subject" placeholder="Sujet du message">
          </div>
        </div>
        <textarea rows="10" cols="100" placeholder="Veuillez entrer votre remarque, question ou information."></textarea>
        <input type="submit" value="Envoyez votre message !" class="button btn btn-default col-lg-offset-4">
      </div>
    </div>
  </div>
<?php
  include 'footer.php';
?>
