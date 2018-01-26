    <script>
// -- // Connexion dans la page modal          
        $(document).ready(function() {
            $('#connexion').click(function() {
                $.post(
                     '../Model/qrcodeconnexion.php', {
                         username: $('#username').val(),
                         password: $('#password').val()
                    },
                    function(data) {
                        if(data == 'Success') {
                            alert('Connexion réussi !');
                        }
                        else {
                            alert('Connexion non réussie !');
                        }
                    },
                    'text' // Recevoir success ou failed
                );
            });
        });                                                                                                                  
    </script>
