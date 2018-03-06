<?php
    if(isset($_COOKIE['user'])) {
        $_SESSION['user'] = $_COOKIE['user']; 
        $_SESSION['role'] = $_COOKIE['role'];
        $_SESSION['pathology'] = $_COOKIE['pathology'];
        $_SESSION['firstname'] = $_COOKIE['firstname'];
        $_SESSION['name'] = $_COOKIE['name'];  
    }
          $error =0;
          $errorName = '';
          $errorMail = '';
          $errorMessage = '';
          $errorSubject = '';
          $succesMsg = '';
            if(isset($_POST['submit'])) {
                if(!empty($_POST['name']) && (!empty($_POST['mail'])) && (!empty($_POST['subject'])) && (!empty($_POST['message']))) {
                    if(preg_match('#^[a-zA-Z]{1,50}+ [a-zA-Z]{3,50}$#',$_POST['name']) || (preg_match('#^[a-zA-Z]{3,50}$#',$_POST['name']))) {
                        $name = strip_tags($_POST['name']);     
                    }
                    else {
                        $error++;
                        $errorName = 'Le nom n\'est pas valide ! Vous devez entrez votre nom et prénom exemple: Steven Spielberg';                        
                    }
                    if(preg_match('#^[\w\-\.]+[a-z0-9]@[\w\-\.]+[a-z0-9]\.[a-z]{2,}$#',$_POST['mail'])) {
                       $mail = strip_tags($_POST['mail']);
                    }
                    else {
                        $error++;
                        $errorMail = 'Le mail n\'est pas valide ! Il doit ressembler à exemple@mail.fr';
                    }
                    if(preg_match('#^[a-zA-Z ÂÊéÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'\"!,;-]{5,50}$#',$_POST['subject'])) {
                       $subject = strip_tags($_POST['subject']); 
                    }
                     else {
                        $error++;
                        $errorSubject = 'Le sujet n\'est pas valide ! Il doit être entre 5 et 50 caractères.';
                    }
                    if(preg_match('#^[a-zA-Z ÂÊéÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğ_\'\"!,;-]{5,}$#',$_POST['message'])) {
                       $subject = strip_tags($_POST['message']); 
                    }
                     else {
                        $error++;
                        $errorMessage = 'Le message n\'est pas valide ! Il doit avoir un minimum de 5 caractères';
                    }
                    
                    if($error == 0) {
                        $message = strip_tags($_POST['message']);
                        $recipient = 'inscriptiondiavk@gmail.com';
                        $entete = 'From: '.$mail;
                        $message = 'Nom et Prénom : '.$name."\r\n"
                                    .' Adresse mail : '.$mail."\r\n"
                                    .' Message :'.$message;
                        mail($recipient, $subject,$message,$entete);
                        $succesMsg = 'Le mail a bien était envoyé, vous aurez bientôt une réponse.'; 
                        $_POST['name'] = '';
                        $_POST['mail'] = '';
                        $_POST['subject'] = '';
                        $_POST['message'] = '';
                    }  
                }
                else {
                    echo 'Les champs ne sont pas tous remplis !';
                }
            }
          ?>