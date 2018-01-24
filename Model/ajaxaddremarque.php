    <script>
// -- // Ajouter une note dans la page modal          
        $(document).ready(function() {
            $('#submitremarqueadd<?php echo $nbmodal;?>').click(function() {
                $.post(
                     'Model/modifappointment.php', {
                        remarque : $('#remarqueappointment<?php echo $nbmodal;?>').val(),
                        name : $('#nameappointment<?php echo $nbmodal;?>').val(),
                        hour : $('#hourappointment<?php echo $nbmodal;?>').val(),
                        infos : $('#infoappointment<?php echo $nbmodal;?>').val()
                    },
                    function(data) {
                        if(data == 'Success') {
                            alert('Note enregistré !');
                        }
                        else {
                            alert('Note non enregistré !');
                        }
                    },
                    'text' // Recevoir success ou failed
                );
            });
        });                                                                                                                  
    </script>
