<?php
    include '../Model/dataBase.php';
    include '../Model/users.php';
    include '../assets/phpqrcode/qrlib.php';
    $user = new users();
    ob_start('callback'); 
    session_start();
    $user->username = $_SESSION['user'];
    $researchqrcode = $user->getQrCode();
    $idParam = $researchqrcode['qrcode'];
    $codeText = 'https://diavk/addUser.php?idFollow='.$idParam;
    $debugLog = ob_get_contents();
    ob_end_clean();
    QRcode::png($codeText);

