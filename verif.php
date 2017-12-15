<?php
  session_start();
  if(!isset($_SESSION['user'])){
    echo "Vous n'êtes pas connecté pour accéder au contenu";
  }
?>
