    $('#delete').tap(function () {
        $.post(
            'Controller/profilController.php', {
                deleteajax: 'delete'
            },
            function (data) {
                if (data == 'Success') {
                    location.href = 'index.php';
                } else {
                    alert('Erreur lors de la désinscription');
                    location.href = 'profil.php';
                }
            },
            'text'
        );
    });
    $('#connexion').tap(function () {
        if($('#cookie').is(':checked')) {
            var cookie = 1
        };
        $.post(
            'Controller/connectionController.php', {
                username: $('#username').val(),
                password: $('#password').val(),
                cookie: cookie,
                connexion: 'connexion',
                testconnexionajax: 'valider'
            },
            function (data) {
                if (data == 'Success') {
                    location.href = 'profil.php';
                } else {
                    $('#errorMessageModal').show();
                }
            },
            'text' // Recevoir success ou failed
        );

    // -- Version mobile -- //
    $('#submitremarqueadd').tap(function() {
        $.post(
            'Controller/informationController.php', {
                remarque: $('#remarqueappointment').val(),
                name: $('#nameappointmentUp').val(),
                hour: $('#hourappointmentUp').val(),
                infos: $('#infoappointmentUp').val(),
                id: $('#id').val(),
                addremarque: 'add',
                ajaxready: 'ajax'
            },
            function(data) {
                if (data == 'Success') {
                    alert('Note enregistré !');
                } else {
                    $('#errorMessageModal').show();
                }
            },
            'text' // Recevoir success ou failed
        );
    });  
    $('#submitmodif').tap(function() {
        $.post(
            'Controller/informationController.php', {
                dayappointmentmodif: $('#day').val(),
                nameappointmentmodif: $('#name').val(),
                hourappointmentmodif: $('#hour').val(),
                infosappointmentmodif: $('#info').val(),
                id: $('#id').val(),
                name: $('#nameappointment').val(),
                hour: $('#hourappointment').val(),
                infos: $('#infoappointment').val(),
                modifappointment: 'modifappointment',
                ajaxready: 'ajax'
            }, 
            function(data) {
                alert('ok')
                if (data == 'Success') {
                    alert('Rendez-vous modifié !');
                } else {
                    alert('Rendez-vous non modifié !');
                    $('#errorMessageModal').show();
                }
            }, 
        );
    });
    $('#submitdelete').tap(function() {
        $.post(
            'Controller/informationController.php', {
                name: $('#nameappointment').val(),
                hour: $('#hourappointment').val(),
                infos: $('#infoappointment').val(),
                id: $('#id').val(),
                suppr: 'Supprimer',
                ajaxready: 'ajax'
            },
            function(data) {
                if(data == 'Success') {
                    alert('Rendez-vous supprimé !');
                } else {
                    alert('Rendez-vous non supprimé !');
                }
            },
            // Recevoir success ou failed
            'text'
        );
    });
    });


