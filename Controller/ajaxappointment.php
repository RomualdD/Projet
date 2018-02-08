<script>
// -- // Ajouter une note dans la page modal          
    $(document).ready(function() {
        $('#submitremarqueadd<?php echo $nbmodal; ?>').click(function () {
            $.post(
                    'Controller/informationController.php', {
                        remarque: $('#remarqueappointment<?php echo $nbmodal; ?>').val(),
                        name: $('#nameappointment<?php echo $nbmodal; ?>').val(),
                        hour: $('#hourappointment<?php echo $nbmodal; ?>').val(),
                        infos: $('#infoappointment<?php echo $nbmodal; ?>').val(),
                        addremarque: 'add',
                        ajaxready: 'ajax'
                    },
                    function (data) {
                        if (data == 'Success') {
                            alert('Note enregistré !');
                        } else {
                            alert('Note non enregistré !');
                        }
                    },
                    'text' // Recevoir success ou failed
                    );
        });
        //    AJAX Page modal modification du rendez-vous 
        $('#submitmodif<?php echo $nbmodal; ?>').click(function () {
            $.post(
                    'Controller/informationController.php', {
                        dayappointmentmodif: $('#day<?php echo $nbmodal; ?>').val(),
                        nameappointmentmodif: $('#name<?php echo $nbmodal; ?>').val(),
                        hourappointmentmodif: $('#hour<?php echo $nbmodal; ?>').val(),
                        infosappointmentmodif: $('#info<?php echo $nbmodal; ?>').val(),
                        name: $('#nameappointment<?php echo $nbmodal; ?>').val(),
                        hour: $('#hourappointment<?php echo $nbmodal; ?>').val(),
                        infos: $('#infoappointment<?php echo $nbmodal; ?>').val(),
                        modifappointment: 'modifappointment',
                        ajaxready: 'ajax'
                    },
                    function (data) {
                        if (data == 'Success') {
                            alert('Rendez-vous modifié !');
                        } else {
                            alert('Rendez-vous non modifié !');
                        }
                    },
                    'text' // Recevoir success ou failed
                    );
        });
        // -- // AJAX Supprimé le rendez-vous dans la page modal    
        $('#submitdelete<?php echo $nbmodal; ?>').click(function () {
            $.post(
                    'Controller/informationController.php', {
                        name: $('#nameappointment<?php echo $nbmodal; ?>').val(),
                        hour: $('#hourappointment<?php echo $nbmodal; ?>').val(),
                        infos: $('#infoappointment<?php echo $nbmodal; ?>').val(),
                        suppr: 'Supprimer',
                        ajaxready: 'ajax'
                    },
                    function (data) {
                        if (data == 'Success') {
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
</script>
