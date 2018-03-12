$(document).ready(function () {
    $('#connexion').click(function () {
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
                    $('#connexion').after('<p class="errormessage col-lg-offset-1 col-lg-9" id="errorMessageModal">Nom d\'utilisateur ou mot de passe incorrect !</p>');
                }
            },
            'text' // Recevoir success ou failed
        );
    });
    $('#delete').click(function () {
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
    $('#inscriptionUsername').keyup(function () {
        $.post(
            'Controller/registerController.php', {
                inscriptionusername: $('#inscriptionUsername').val()
            },
            function (data) {
                if (data.indexOf('Failed') >= 0) {
                    if($('#inscriptionUsername').val() != '') {
                        $('#usernameerror').text('Nom d\'utilisateur déjà pris !');                         
                    }
                    else {   
                        $('#usernameerror').text('');
                    }
                }
                else {
                    $('#usernameerror').text('');
                }
            },
            'text'
        );
    });    
});
