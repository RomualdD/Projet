<?php
// -- // Inscription
    $errorMessageName = '';
    $errorMessageFirstname = '';
    $errorMessageMail = '';
    $errorMessageBirthday = '';
    $errorMessagePhone = '';
    $errorMessageUser = '';
    $errorMessagePassword = '';
    $errorMessagePathology = '';
  if(isset($_POST['submit'])) {
     // Vérification si les champs sont bien remplis
     if(!empty($_POST['name']) && (!empty($_POST['firstname'])) && (!empty($_POST['password'])) && (!empty($_POST['passwordverif'])) && (!empty($_POST['mail'])) && (!empty($_POST['birthday'])) && (!empty($_POST['phone'])))  {
        $error = 0;
        /* Enregistrement des données des champs
         * Vérifications des regex
         * On évite les éléments comme balise html/php
         */
        if(preg_match('#^[a-zA-Z]{1,20}$#', $_POST['name'])) {
            // Mise en majuscule du nom
            $name = strtoupper(strip_tags($_POST['name']));
        }
        else {
            $errorMessageName = 'Le nom n\'est pas valide';
            $error++;
        }
        if(preg_match('#^[a-zA-Z]{1,20}$#', $_POST['firstname'])) {
          $firstname = strip_tags($_POST['firstname']);     
        }
        else {
            $errorMessageFirstname = 'Le prénom n\'est pas valide';
            $error++;
        }
       $username = strip_tags($_POST['username']);
        if(preg_match('#^[\w\-\.]+[a-z0-9]@[\w\-\.]+[a-z0-9]\.[a-z]{2,}$#',$_POST['mail'])) {
            $mail = strip_tags($_POST['mail']);   
        }
        else {
            $errorMessageMail = 'Le mail n\'est pas valide !';
            $error++;
        }
        // Cryptage de données mdp
       $password = sha1(md5($_POST['password']));
       $passwordverif = sha1(md5($_POST['passwordverif']));
        if(preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['birthday']) || preg_match('#^[0-9]{4}[-]{1}[0]{1}[0-9]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['birthday']) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[3]{1}[0-1]{1}$#', $_POST['birthday'])) || (preg_match('#^[0-9]{4}[-]{1}[1]{1}[0-2]{1}[-]{1}[0-2]{1}[0-9]{1}$#', $_POST['birthday']))) {
           $birthday = strip_tags($_POST['birthday']);   
        }
        else {
            $errorMessageBirthday = 'La date n\'est pas valide';
            $error++;
        }
        if(preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['phone'])) {
            $phone = strip_tags($_POST['phone']);      
        }
        else {
            $errorMessagePhone = 'Le numéro de téléphone n\'est pas valide !';
            $error++;
        }
       $role = $_POST['role'];
       $pathology = $_POST['pathology'];
       $phone2 = 'Pas indiqué';
       $qrcodeParam = md5(microtime(TRUE)*100000);
       if($role == 0){
         $pathology = 0;
       }
        if($error == 0) {
            if(($role == 1 && $pathology != 0) || ($role == 0 && $pathology == 0)) {
             // On vérifie que les mots de passes sont identiques
                if($password == $passwordverif) {
                    // Vérification qu'un utilisateur n'a pas le même nom
                  $result = $db->query('SELECT `nom_utilisateur` FROM `utilisateurs` WHERE `nom_utilisateur` ="'.$username.'"');
                  $nameverif = $result->fetch();
                  if($username == $nameverif['nom_utilisateur']) {
                    $errorMessageUser = 'Nom d\'utilisateur déjà utilisé!';
                  }
                  else {
                    // Clé généré aléatoirement
                    $cle = md5(microtime(TRUE)*100000);
                    // Indique qu'il faut le vérifier
                    $actif = 0;

                    // Inclusion dans la bdd
                    $reqAdd = $db->prepare('INSERT INTO `utilisateurs`(`nom`, `prenom`, `nom_utilisateur`, `mail`, `mot_de_passe`,`date_anniversaire`, `phone`,`phone2`, `role`, `pathologie`,`cleverif`,`actif`,`qrcode`) VALUES(:name, :firstname, :username, :mail, :password,:birthday,:phone,:phone2,:role,:pathology,:cleverif,:actif,:qrcode)');
                    $reqAdd->bindValue('name',$name,PDO::PARAM_STR);
                    $reqAdd->bindValue('firstname',$firstname,PDO::PARAM_STR);
                    $reqAdd->bindValue('username',$username,PDO::PARAM_STR);
                    $reqAdd->bindValue('mail',$mail,PDO::PARAM_STR);
                    $reqAdd->bindValue('password',$password,PDO::PARAM_STR);
                    $reqAdd->bindValue('birthday',$birthday,PDO::PARAM_STR);
                    $reqAdd->bindValue('phone',$phone,PDO::PARAM_STR);
                    $reqAdd->bindValue('phone2',$phone2,PDO::PARAM_STR);
                    $reqAdd->bindValue('role',$role,PDO::PARAM_INT);
                    $reqAdd->bindValue('pathology',$pathology,PDO::PARAM_INT);
                    $reqAdd->bindValue('cleverif',$cle,PDO::PARAM_STR);
                    $reqAdd->bindValue('actif',$actif,PDO::PARAM_INT);
                    $reqAdd->bindValue('qrcode',$qrcodeParam,PDO::PARAM_STR);
                    $reqAdd->execute();
                    //Envoie du mail d'activation
                    $recipient = $mail;
                    $subject = "[IMPORTANT] Activation de votre compte di-A-vk";
                    $entete = "From: inscriptiondiavk@gmail.com";
                    $message = 'Bienvenue sur di-A-vk,'. "/r/n"
                    .'Afin de continuer sur le site veuillez activer votre compte en cliquant sur ce lien:'."\r\n"
                    .'http://diavk/View/validation.php?log='.urlencode($username).'&cle='.urlencode($cle)."\r\n"
                    .'Ne pas répondre à ce message.';
                    mail($recipient, $subject,$message,$entete);
                    //Informer l'utilisateur que l'inscription est bien prise en compte
                    //Redirection vers la page de connexion
                    header('Location:http://diavk/View/connexion.php');
                    exit();
                   }
                }
                else {
                  $errorMessagePassword = 'Mot de passe différent';
                }
            }
            else {
             $errorMessagePathology = 'Veuillez choisir votre pathologie !';
            }
        }
     }
    else {
        echo  'Les champs ne sont pas remplis.';
    }
  }
