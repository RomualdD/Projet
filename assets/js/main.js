if(window.Worker) {
   // setTimeOut(function() {
        $.post(
            'Controller/notification.php', {
                name: $('#person').text()
            },
            function(data) {
                if(data == 'Success') {                   
                    var myWorker = new Worker('notificationdemande.php');
                }
            }
        )
    //},1000);
}

