<?php
session_start();
if(!isset($_SESSION['user'])) {
    include 'header.php';
}
else {
    include 'header1.php';
}
 ?>
<!-- Page d'accueil -->
  <div class="container">
    <div class="row">
        <div class="col-lg-offset-5"><h2>Accueil</h2></div>
    </div>
    <div class="row">
      <div class="welcome col-lg-offset-2"><h3>Bienvenue sur le site di-A-vk!</h3></div>
      <div class="subhead col-lg-offset-1"><h4>Pour qui est ce site?</h4></div>
      <p>Ce site est dédié aux personnes atteintes du Diabète ou de souci de santé nécessitant la prise d'anticoagulant (AVK) et utilisant principalement des appareils (par exemple coagucheck). Vous pourrez noter les résultats de vos prises de sang composant le suivi de votre diabète ou INR et ainsi observer l'évolution instantanément à chaque prise de sang.</p>
      <p>di-A-vk permet de vous aider à mémoriser la date à laquelle vous devez effectuez votre prise de sang grâce à un envoi de mail ou de SMS, et vous permet également de noter vos rendez-vous médicaux.</p>
      <p>Votre médecin pourra ainsi dans le même temps accéder à vos résultats de glycémie et d'INR, dans le cadre d'un accord patient-corps médical. Lors de vos consultations, l'ensemble de votre suivi pourra être visualisé facilitant vos interrogations éventuelles.</p>
      <div class="subhead col-lg-offset-1"><h4>En quoi ça consiste?</h4></div>
      <p>Lors de l'inscription, il est nécessaire d'indiquer la pathologie qui vous concerne. Ensuite il faut remplir les données de la fiche profil qui seront nécessaires dans le cadre du suivi. Celles-ci seront stockées et permettront d'actualiser les informations.</p>
      <p>Afin de faciliter l'utilisation du site, le patient a besoin d'ajouter uniquement le taux obtenu. La date de la prochaine vérification est automatiquement mise à jour et sera envoyé par sms ou mail. Il peut également compléter par les rendez-vous médicaux afin d'en être informés.</p>
      <p>L'utilisateur peut ajouter son médecin traitant de deux façons différentes. La première manière est de faire une recherche du médecin et de l'ajouter pour être suivi ou bien le médecin fait une demande pour pouvoir suivre le patient et il doit être accepté. La rubrique pour ajouter se situe tout en bas de votre profil, il est possible de voir quel médecin vous suit.</p>
      <div class="subhead col-lg-offset-1"><h4>Pourquoi?</h4></div>
      <p>De plus en plus de personne sont atteintes de ces maladies et il arrive que l'on peut oublier de surveiller à cause d'activité professionnelle ou privée. Le suivi est aussi plus pratique et écologique que d'avoir un carnet et noter tous les résultats, de plus les résultats peuvent être plus visuel et peuvent être facilement mis en contact avec notre médecin traitant.</p>
      <div class="subhead col-lg-offset-1"><h4>Informations Complémentaires</h4></div>
      <p>Afin de mieux comprendre votre maladie et de vous tenir informer des recherches en cours, certaines informations apparaîtrons aux furs et à mesure. De plus une rubrique contact permet de vous mettre en relation avec nos services si vous avez des informations intéressantes ou bien des remarques et des questions sur le site, nous pourrons y répondre et si il est nécessaire au vus de plusieurs demandes du même type, d'y mettre un encart.</p>
    </div>
  </div>

<?php
  include 'footer.php';
?>
