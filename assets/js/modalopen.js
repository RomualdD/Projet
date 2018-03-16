// -- // Ajouter une note dans la page modal          
$(document).ready(function () {
    $('#modalAppointment').on('show.bs.modal', function(event) {
        var appointment = $(event.relatedTarget);
        var idappointment = appointment.data('idappointment');
        var remarque = appointment.data('remarque');
        var recipient = appointment.data('nameappointment');
        var hour = appointment.data('hourappointment');
        var info = appointment.data('infoappointment');
        var modal = $(this);
        modal.find('#nameappointment').val(recipient);
        modal.find('#hourappointment').val(hour);
        modal.find('#infoappointment').val(info);
        modal.find('#id').val(idappointment);
    });   
    $('#modalAppointmentUp').on('show.bs.modal', function(event) {
        var appointment = $(event.relatedTarget)
        var idappointment = appointment.data('idappointment');
        var remarque = appointment.data('remarque');
        var recipient = appointment.data('nameappointment');
        var hour = appointment.data('hourappointment');
        var info = appointment.data('infoappointment');
        var modal = $(this);
        modal.find('#nameappointmentUp').val(recipient);
        modal.find('#hourappointmentUp').val(hour);
        modal.find('#infoappointmentUp').val(info);
        modal.find('#remarqueappointment').val(remarque);
        modal.find('#id').val(idappointment);
    });
    $('#submitremarqueadd').click(function() {
        $.post(
            'Controller/informationController.php', {
                remarque: $('#remarqueappointment').val(),
                name: $('#nameappointmentUp').val(),
                hour: $('#hourappointmentUp').val(),
                infos: $('#infoappointmentUp').val(),
                id: $('#id').val(),
                addremarque: 'add',
                ajaxready: 'ajax'
            },
            function(data) {
                if (data == 'Success') {
                    alert('Note enregistré !');
                    location.reload(true);
                } else {
                    $('#errorMessageModal').css('display','block');
                }
            },
            'text' // Recevoir success ou failed
        );
    }); 
    //    AJAX Page modal modification du rendez-vous 
    $('#submitmodif').click(function() {
        $.post(
            '../Controller/informationController.php', {
                dayappointmentmodif: $('#day').val(),
                nameappointmentmodif: $('#newnameappointment').val(),
                hourappointmentmodif: $('#hour').val(),
                infosappointmentmodif: $('#info').val(),
                id: $('#id').val(),
                name: $('#nameappointment').val(),
                hour: $('#hourappointment').val(),
                infos: $('#infoappointment').val(),
                modifappointment: 'modifappointment',
                ajaxready: 'ajax'
            }, 
            function(data) {
                if (data == 'Success') {
                    alert('Rendez-vous modifié !');
                    location.reload(true);
                }
                else if(data == 'FailedName') {
                    $('#errorDayMessageModal').css('display','none');
                    $('#errorHourMessageModal').css('display','none');
                    $('#errorInfoMessageModal').css('display','none');
                    $('#totalerror').css('display','none');
                    $('#errorNomMessageModal').css('display','block');
                }
                else if(data == 'FailedDay') {
                    $('#errorNomMessageModal').css('display','none');
                    $('#errorHourMessageModal').css('display','none');
                    $('#errorInfoMessageModal').css('display','none');
                    $('#totalerror').css('display','none');                    
                    $('#errorDayMessageModal').css('display','block');
                }
                else if(data == 'FailedHour') {
                    $('#errorNomMessageModal').css('display','none');
                    $('#errorDayMessageModal').css('display','none');
                    $('#errorInfoMessageModal').css('display','none');
                    $('#totalerror').css('display','none');                    
                    $('#errorHourMessageModal').css('display','block');
                }
                else if(data == 'FailedInfo') {
                    $('#errorNomMessageModal').css('display','none');
                    $('#errorDayMessageModal').css('display','none');
                    $('#errorHourMessageModal').css('display','none');
                    $('#totalerror').css('display','none');                     
                    $('#errorInfoMessageModal').css('display','block');
                }                
                else {
                    $('#errorNomMessageModal').css('display','none');
                    $('#errorDayMessageModal').css('display','none');
                    $('#errorHourMessageModal').css('display','none');
                    $('#errorInfoMessageModal').css('display','none');                     
                    $('#totalerror').css('display','block');
                }
            }, 
        );
    });
    // -- // AJAX Supprimé le rendez-vous dans la page modal    
    $('#submitdelete').click(function(e) {
        e.preventDefault();
        $.post(
            'Controller/informationController.php', {
                name: $('#nameappointment').val(),
                hour: $('#hourappointment').val(),
                infos: $('#infoappointment').val(),
                id: $('#id').val(),
                suppr: 'Supprimer',
                ajaxready: 'ajax'
            },
            function(data) {
                if(data == 'Success') {
                    alert('Rendez-vous supprimé !');
                    location.reload(true);
                } else {
                    alert('Rendez-vous non supprimé !');
                }
            },
            // Recevoir success ou failed
            'text'
        );
    });
});
