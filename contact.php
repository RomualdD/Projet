<?php
  include 'header.php'; // Si visiteur
  /*include 'header1.php'; //Si profil connecté */
?>

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
        <div class="form-group">
          <label for="texte">Nom et Prénom :</label>
          <input type="text" placeholder="Nom">
        </div>
        <div class="form-group">
          <label for="texte">Adresse mail :</label>
          <input type="text" placeholder="mail">
        </div>
        <div class="form-group">
          <label for="texte">Sujet :</label>
          <input type="text" placeholder="Sujet">
        </div>
        <textarea rows="10" cols="100" placeholder="Veuillez entrer votre remarque, question ou information."></textarea>
        <input type="submit" value="Envoyez votre message !" class="button btn btn-default col-lg-offset-4">
      </div>
    </div>
  </div>

<?php
  include 'footer.php';
?>
