// -- // Ajouter une note dans la page modal          
$(document).ready(function () {
    $('#modalAppointment').on('show.bs.modal', function(event) {
        var appointment = $(event.relatedTarget)
        var remarque = appointment.data('remarque')
        var recipient = appointment.data('nameappointment')
        var hour = appointment.data('hourappointment')
        var info = appointment.data('infoappointment')
        var modal = $(this)
        modal.find('#nameappointment').val(recipient)
        modal.find('#hourappointment').val(hour)
        modal.find('#infoappointment').val(info)
    });
    $('#modalAppointmentUp').on('show.bs.modal', function(event) {
        var appointment = $(event.relatedTarget)
        var remarque = appointment.data('remarque')
        var recipient = appointment.data('nameappointment')
        var hour = appointment.data('hourappointment')
        var info = appointment.data('infoappointment')
        var modal = $(this)
        modal.find('#nameappointmentUp').val(recipient)
        modal.find('#hourappointmentUp').val(hour)
        modal.find('#infoappointmentUp').val(info)
        modal.find('#remarqueappointment').val(remarque)
    });
    $('#submitremarqueadd').click(function() {
        $.post(
            'Controller/informationController.php', {
                remarque: $('#remarqueappointment').val(),
                name: $('#nameappointmentUp').val(),
                hour: $('#hourappointmentUp').val(),
                infos: $('#infoappointmentUp').val(),
                addremarque: 'add',
                ajaxready: 'ajax'
            },
            function(data) {
                if (data == 'Success') {
                    alert('Note enregistré !');
                } else {
                    $('#errorMessageModal').show();
                }
            },
            'text' // Recevoir success ou failed
        );
    });
    //    AJAX Page modal modification du rendez-vous 
    $('#submitmodif').click(function() {
        $.post(
            'Controller/informationController.php', {
                dayappointmentmodif: $('#day').val(),
                nameappointmentmodif: $('#name').val(),
                hourappointmentmodif: $('#hour').val(),
                infosappointmentmodif: $('#info').val(),
                name: $('#nameappointment').val(),
                hour: $('#hourappointment').val(),
                infos: $('#infoappointment').val(),
                modifappointment: 'modifappointment',
                ajaxready: 'ajax'
            }, 
            function(data) {
                alert('ok')
                if (data == 'Success') {
                    alert('Rendez-vous modifié !');
                } else {
                    alert('Rendez-vous non modifié !');
                    $('#errorMessageModal').show();
                }
            }, 
        );
    });
    // -- // AJAX Supprimé le rendez-vous dans la page modal    
    $('#submitdelete').click(function() {
        $.post(
            'Controller/informationController.php', {
                name: $('#nameappointment').val(),
                hour: $('#hourappointment').val(),
                infos: $('#infoappointment').val(),
                suppr: 'Supprimer',
                ajaxready: 'ajax'
            },
            function(data) {
                if(data == 'Success') {
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
