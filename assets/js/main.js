setInterval(function() {
    if(window.Worker) {
        $.post(
            'Controller/notification.php', {
                info: $('#infoFollow').text()
            },
            function(info) {
                if(info != 'Failed') {
                    //console.log(info)
                    $('#infoFollow').text(info);
                    if(info == 1) {
                        $('.addQuest').show();
                    }
                    //var myWorker = new Worker('assets/js/notification.js');
                  //  myWorker.onmessage=function(event){
                        if (!('Notification' in window)) {
                            alert('Ce navigateur ne supporte pas les notifications desktop');
                        }
                        // Vérification si notification bien accepté
                        else if (Notification.permission === 'granted') {
                          // Si c'est ok, créons une notification
                            var notification = new Notification('Vous avez une nouvelle demande !');
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
                                var notification = new Notification('Vous avez une nouvelle demande !');
                            }
                        });
                      }
                   // };
                }
            },
        );
    }
},60000);    

