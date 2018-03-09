<?php 
  session_start(); 
  session_unset();
  session_destroy();
  setcookie('user','',time() - 3600,'/',null,0,1);
  setcookie('firstname','',time() - 3600,'/',null,0,1);
  setcookie('name','',time() - 3600,'/',null,0,1);
  setcookie('role','',time() - 3600,'/',null,0,1);
  setcookie('pathology','',time() - 3600,'/',null,0,1);
  header('Location:../');
?>
