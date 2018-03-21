<?php
session_start();
if($_SESSION['role' == 1]) {
    $successAddMsg = '';
   $role = new role();
   $pathology = new pathology();
   if(isset($_POST['submit'])) {
       if(!empty($_POST['table']) && (!empty($_POST['data']))) {
           if($_POST['table'] == 1) {
               $role->name = $_POST['data'];
               if($role->addRole()) {
                   $successAddMsg = 'Role bien ajouté';
               }
           } 
           else {
               $pathology->name = $_POST['data'];
               if($pathology->addPathology()) {
                   $successAddMsg = 'Pathologie bien ajouté';
               }
               else {
                   $successAddMsg = 'Pathologie non ajouté';
               }
           }
       }
   }   
}
else {
    header('Location: 404');
}
