$(document).ready(function () {
    $('#connexion').click(function () {
        $.post(
                'Controller/connexionController.php', {
                    username: $('#username').val(),
                    password: $('#password').val(),
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
            '../../Controller/inscriptionController.php', {
                inscriptionusername: $('#inscriptionUsername').val()
            },
            function (data) {
                if (data.indexOf('Failed') >= 0) {
                    if($('#inscriptionUsername').val() != '') {
                        $('#usernameerror').text('Nom d\'utilisateur déjà pris !');
                        $('#usernamesuccess').text('');                                
                    }
                    else {
                        $('#usernamesuccess').text('');   
                        $('#usernameerror').text('');
                    }
                }
                else {
                    $('#usernamesuccess').text('Nom d\'utiisateur non pris !');
                    $('#usernameerror').text('');
                }
            },
            'text'
        );
    });
});
