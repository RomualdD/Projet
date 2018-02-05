    <script>
// -- // AJAX Supprimé le rendez-vous dans la page modal           
        $(document).ready(function() {
            $('#submitdelete<?php echo $nbmodal;?>').click(function() {
                $.post(
                     '../Controller/modifappointmentController.php', {
                        name : $('#nameappointment<?php echo $nbmodal;?>').val(),
                        hour : $('#hourappointment<?php echo $nbmodal;?>').val(),
                        infos : $('#infoappointment<?php echo $nbmodal;?>').val(),
                        suppr : 'Supprimer'
                    },
                    function(data) {
                        if(data == 'Success') {
                            alert('Rendez-vous supprimé !');
                        }
                        else {
                            alert('Rendez-vous non supprimé !');
                        }
                    },
                    // Recevoir success ou failed
                    'text' 
                );
            });
        });  
    </script>
