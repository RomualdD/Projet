<?php
/*
 * Création du QRCode
 * appel de la bibliotheque qrlib
 */
    include_once '../configuration.php';
    include '../Model/dataBase.php';
    include '../Model/users.php';
    include '../assets/phpqrcode/qrlib.php';
    $user = new users();
    session_start();
    $user->username = $_SESSION['user'];
    $researchqrcode = $user->getQrCode();
    $idParam = $researchqrcode->qrcode;
    // Lien redirection du QRCode
   // $codeText = 'https://diavk/idFollow='.$idParam;
    $codeText = 'https://192.168.1.160/idFollow='.$idParam;
    QRcode::png($codeText);

