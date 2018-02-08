$(document).ready(function() {
    $('#connexion').click(function() {
       $.post(
            'Controller/connexionController.php', {
               username: $('#username').val(),
               password: $('#password').val(),
               connexion:'connexion',
               testconnexionajax: 'valider'
            },
            function (data) {
                if (data == 'Success') {
                    location.href = 'profil.php';
                } else {
                    alert('Il y a eu un problème lors de la connexion, Veuillez réessayer ou vérifier si vous avez bien activez votre compte!');
                    location.href = 'connexion.php';
                }
            },
            'text' // Recevoir success ou failed
            );
    });
});
