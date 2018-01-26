<?php
    include 'bdd.php';
    include '../assets/phpqrcode/qrlib.php';
    ob_start("callback"); 
    session_start();
    $user=$_SESSION['user'];
    $researchqrcode = $db->query('SELECT `qrcode` FROM `utilisateurs` WHERE `nom_utilisateur` = "'.$user.'"');
    $researchqrcode = $researchqrcode->fetch(PDO::FETCH_ASSOC);
    $idParam = $researchqrcode['qrcode'];
  //  $idParam = md5(microtime(TRUE)*100000);
    $codeText = 'http://diavk/View/addUser.php?idFollow='.$idParam;
    $debugLog = ob_get_contents();
    ob_end_clean();
    QRcode::png($codeText);