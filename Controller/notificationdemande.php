    <script>   
        $(document).ready(function () {
            if (!('Notification' in window)) {
              alert('Ce navigateur ne supporte pas les notifications desktop');
            }
            // Vérification si notification bien accepté
            else if (Notification.permission === 'granted') {
              // Si c'est ok, créons une notification
              <?php if($nbquest > 1) {
               ?> var notification = new Notification('Vous avez <?php echo $nbquest; ?> demandes!'); <?php
              } elseif($nbquest == 1) { ?>
                var notification = new Notification('Vous avez <?php echo $nbquest; ?> demande !');               
              <?php } ?>
            }
            // Vérification que l'utiisateur n'a pas refusé
            else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function(permission) {
                // On récupère la réponse de l'utilisateur
                if(!('permission' in Notification)) {
                  Notification.permission = permission;
                }
                // Création de la notification si utilisateur accepte
                if (permission === 'granted') {
              <?php if($nbquest > 1) {
               ?> var notification = new Notification('Vous avez <?php echo $nbquest; ?> demandes!'); <?php
              } elseif($nbquest == 1) { ?>
                var notification = new Notification('Vous avez <?php echo $nbquest; ?> demande !');               
              <?php } ?>
                }
            });
          }
        });  
    </script>    
