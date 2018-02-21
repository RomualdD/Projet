<?php
if(isset($_POST['ajax'])) {
    echo 'Success';
    include '../Model/dataBase.php';
    include '../Model/appointments.php';
    $appointment = new appointments();
   $appointment->id = $_POST['idModal'];
   $informations = $appointment->getInformationById();
}

