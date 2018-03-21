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
                    $('#errorMessageModal').css('display','block');
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
                    if(navigator.language != 'fr') {
                        alert('You are now unregistered  !');
                    } else {
                        alert('Vous êtes désormais désinscris ');
                    }
                    location.href = 'index.php';
                } else {
                    if(navigator.language != 'fr') {
                        alert('Error during unsubscribe !');
                    } else {
                        alert('Erreur lors de la désinscription');
                    }
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
                        $('#allreadyusernameerror').css('display','block');                         
                    }
                    else {   
                        $('#allreadyusernameerror').css('display','none');
                    }
                }
                else {
                    $('#allreadyusernameerror').css('display','none');
                }
            },
            'text'
        );
    }); 
    
    $('#passwordverif').blur(function () {
        var passwordverif = $('#passwordverif').val();
        var password = $('#passwordregister').val();
        if(password != passwordverif) {
            $('#errorPasswordIdentic').css('display','block'); 
        } 
        else {
           $('#errorPasswordIdentic').css('display','none');
        }
    });
});
