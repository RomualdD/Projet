<?php
include_once 'View/header.php';
include_once 'Controller/contactController.php';
?>
<!-- Page contact -->
  <div class="container view">
    <div class="row">
      <div class="col-lg-offset-5 col-xs-offset-4"><h2><?php echo CONTACT; ?></h2></div>   
    <div class="message col-lg-offset-2 col-lg-10 col-sm-4 col-md-4 col-xs-12">
      <p><?php echo CONTACTMESSAGE; ?></p>
      <p><?php echo CONTACTMESSAGETWO; ?></p>
    </div>
      </div>
    <div class="row">
      <div class="contact col-lg-offset-2 col-lg-9">
        <div class="row">
          <div class="subtitle col-lg-offset-4 col-xs-offset-3"><h3><?php echo CONTACTSUBTITLE; ?></h3></div>
        </div>
          <form action="contact.php" method="POST">
            <div class="form-inline">
              <div class="input-group name col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? strip_tags($_POST['name']) : ''; ?>" placeholder="<?php echo NAMEFIRSTNAME; ?>" required>
              </div>
                <p class="errormessage col-lg-offset-1 col-lg-11"><?php echo $errorName; ?></p>
            </div>
            <div class="form-inline">
              <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                  <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="mail" value="<?php echo isset($_POST['mail']) ? strip_tags($_POST['mail']) : ''; ?>" placeholder="<?php echo MAILPLACEHOLDER; ?>" required>
              </div>
                <p class="errormessage col-lg-offset-1 col-lg-11"><?php echo $errorMail; ?></p>
            </div>
            <div class="form-inline">
              <div class="input-group subject col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10">
                  <span class="input-group-addon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="subject" value="<?php echo isset($_POST['subject']) ? strip_tags($_POST['subject']) : ''; ?>" placeholder="<?php echo SUBJECTCONTACT; ?>" required>
              </div>
                <p class="errormessage col-lg-offset-1 col-lg-11"><?php echo $errorSubject; ?></p>
            </div>
            <div class="form-inline">
                <div class="input-group subject">
                    <textarea class="form-control" rows="10" cols="100" placeholder="<?php echo MESSAGECONTACTFORM; ?>" name="message" required><?php echo isset($_POST['message']) ? strip_tags($_POST['message']) : ''; ?></textarea>
                </div>
                <p class="errormessage col-lg-offset-1 col-lg-11"><?php echo $errorMessage; ?></p>
            </div>
            <input type="submit" value="Envoyez votre message !" class="button btn btn-default col-lg-offset-4" name="submit">
          </form>
          <p class="successmessage"><?php echo $succesMsg; ?></p>
      </div>
    </div>
  </div>
<?php
  include 'View/footer.php';
?>
