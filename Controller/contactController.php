<?php
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
                        $errorName = ERRORNAMECONTACT;                        
                    }
                    if(filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                       $mail = strip_tags($_POST['mail']);
                    }
                    else {
                        $error++;
                        $errorMail = ERRORMAILCONTACT;
                    }
                    if(preg_match('#^[a-zA-Z ÂÊéÎÔÛÄËÏÖÜÀÆæÇÉÈŒœéèêôàïîüÙğ_\'\"!,;-]{5,50}$#',$_POST['subject'])) {
                       $subject = strip_tags($_POST['subject']); 
                    }
                     else {
                        $error++;
                        $errorSubject = ERRORSUBJECTCONTACT;
                    }
                    if(preg_match('#^[a-zA-Z ÂÊéÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙğéèêôàïîü_\'\"!,;-]{5,}$#',$_POST['message'])) {
                       $subject = strip_tags($_POST['message']); 
                    }
                     else {
                        $error++;
                        $errorMessage = ERRORMESSAGECONTACT;
                    }
                    
                    if($error == 0) {
                        $message = strip_tags($_POST['message']);
                        $recipient = 'inscriptiondiavk@gmail.com';
                        $entete = 'From: '.$mail;
                        $message = 'Nom et Prénom : '.$name."\r\n"
                                    .' Adresse mail : '.$mail."\r\n"
                                    .' Message :'.$message;
                        mail($recipient, $subject,$message,$entete);
                        $succesMsg = CONTACTSUCCESS; 
                        $_POST['name'] = '';
                        $_POST['mail'] = '';
                        $_POST['subject'] = '';
                        $_POST['message'] = '';
                    }  
                }
                else {
                    echo ERRORINPUT;
                }
            }
          ?>