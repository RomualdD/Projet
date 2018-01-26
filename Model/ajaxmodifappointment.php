    <script>       
// -- // AJAX Page modal modification du rendez-vous          
        $(document).ready(function() {
            $('#submitmodif<?php echo $nbmodal;?>').click(function() {
                $.post(
                     '../Model/modifappointment.php', {
                        dayappointmentmodif : $('#day<?php echo $nbmodal;?>').val(),
                        nameappointmentmodif : $('#name<?php echo $nbmodal;?>').val(),
                        hourappointmentmodif : $('#hour<?php echo $nbmodal;?>').val(),
                        infosappointmentmodif : $('#info<?php echo $nbmodal;?>').val(),
                        name : $('#nameappointment<?php echo $nbmodal;?>').val(),
                        hour : $('#hourappointment<?php echo $nbmodal;?>').val(),
                        infos : $('#infoappointment<?php echo $nbmodal;?>').val()
                    },
                    function(data) {
                        if(data == 'Success') {
                            alert('Rendez-vous modifié !');
                        }
                        else {
                            alert('Rendez-vous non modifié !');
                        }
                    },
                    'text' // Recevoir success ou failed
                );
            });
        });
    </script> 

