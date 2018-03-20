    <footer>
          <div class="col-lg-offset-1 col-lg-2 col-xs-3"><?php echo WEBSITETITLE; ?></div>
          <div class="col-lg-offset-2 col-lg-4 col-xs-5"><i class="far fa-copyright"></i> <?php echo COPYRIGHT; ?></div>
          <div class="col-lg-offset-1 col-lg-2 col-xs-1"><a href="contactez-nous"><?php echo CONTACT; ?></a></div>
    </footer>
    <script src="/assets/js/jquery.mobile.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/cookie.js"></script>
    <script src="assets/js/scriptmobile.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        $(function () {
            var nua = navigator.userAgent
            var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
            if (isAndroid) {
              $('select.form-control').removeClass('form-control').css('width', '100%')
            }
            if (navigator.language != 'fr') {
                document.addEventListener 
                ('DOMContentLoaded', function(event) { cookieChoices.showCookieConsentBar 
                ('This site uses cookies to offer you the best service. By continuing your navigation, you accept the use of cookies.', 'I agree', 'Learn more', 'https://diavk/mentions-legales'); });
            } else {
                document.addEventListener 
                ('DOMContentLoaded', function(event) { cookieChoices.showCookieConsentBar 
                ('Ce site utilise des cookies pour vous offrir le meilleur service. En poursuivant votre navigation, vous acceptez l’utilisation des cookies.', 'J’accepte', 'En savoir plus', 'https://diavk/mentions-legales'); });
            }
        });
    </script>
  </body>
</html>
<?php
  session_write_close();
 ?>