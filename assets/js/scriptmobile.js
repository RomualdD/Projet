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
    });


