<?php
session_start();
if(isset($_SESSION['user'])) {
  include 'header1.php';
}
else {
    include 'header.php';
  }
?>
<!-- Page contact -->
  <div class="container">
    <div class="row">
      <div class="col-lg-offset-5 col-xs-offset-4"><h2>Contact</h2></div>
    
    <div class="message col-lg-offset-2 col-lg-10 col-sm-4 col-md-4 col-xs-12">
      <p>Veuillez entrer votre Nom, Prénom et votre adresse mail pour obtenir une réponse à votre message.</p>
      <p>Des questions? Des remarques? N'hésitez pas à nous contacter.</p>
    </div>
      </div>
    <div class="row">
      <div class="contact col-lg-offset-2 col-lg-9">
        <div class="row">
          <div class="subtitle col-lg-offset-4 col-xs-offset-3"><h3>Contactez-nous :</h3></div>
        </div>
          <form action="contact.php" method="POST">
            <div class="form-inline">
              <div class="input-group name col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="name" placeholder="Nom de Famille et Prénom">
              </div>
            </div>
            <div class="form-inline">
              <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                  <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="mail" placeholder="Adresse mail">
              </div>
            </div>
            <div class="form-inline">
              <div class="input-group subject col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                  <span class="input-group-addon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="subject" placeholder="Sujet du message">
              </div>
            </div>
            <div class="form-inline">
                <div class="input-group subject">
                    <textarea class="form-control" rows="10" cols="100" placeholder="Veuillez entrer votre remarque, question ou information." name="message"></textarea>
                </div>
            </div>
            <input type="submit" value="Envoyez votre message !" class="button btn btn-default col-lg-offset-4" name="submit">
          </form>
          <?php
            if(isset($_POST['submit'])) {
                if(!empty($_POST['name']) && (!empty($_POST['mail'])) && (!empty($_POST['subject']))) {
                    if(preg_match('#^[a-zA-Z]{1,50}+ [a-zA-Z]{1,50}$#',$_POST['name']) && (preg_match('#^[\w\-\.]+[a-z0-9]@[\w\-\.]+[a-z0-9]\.[a-z]{2,}$#',$_POST['mail']))) {
                        $name = strip_tags($_POST['name']);
                        $mail = strip_tags($_POST['mail']);
                        $subject = strip_tags($_POST['subject']);
                        $message = strip_tags($_POST['message']);
                        $recipient = 'inscriptiondiavk@gmail.com';
                        $entete = 'From: '.$mail;
                        $message = 'Nom et Prénom : '.$name."\r\n"
                                .' Adresse mail : '.$mail."\r\n"
                                . ' Message :'.$message;
                        mail($recipient, $subject,$message,$entete);
                        echo 'Le mail a bien était envoyé, vous aurez bientôt une réponse.';
                    }
                    else {
                        echo 'Champs de saisis non respectés !';
                    } 
                }
                else {
                    echo 'Les champs ne sont pas tous remplis !';
                }
            }
          ?>
      </div>
    </div>
  </div>
<?php
  include 'footer.php';
?>
