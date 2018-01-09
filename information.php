<?php
session_start();
if(!isset($_SESSION['user'])) {
    include 'header.php';
    echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
    include 'header1.php';
    // Récupération des mois avec leur numéro
    $months = array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');
    // Vérification si on a choisi un mois et une année
    if(isset($_POST['months']) && isset($_POST['years'])) {
        $month = $_POST['months'];
        $year = $_POST['years'];
    }
    else {
        //Sinon attribution du mois et de l'année en cours
        $month = date('n');
        $year = date('Y');
    }
    // Nombre de nombres de jours dans un mois
    $numberDaysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
    // Premier jour de la semaine
    $firstWeekDayOfMonth = date('N', mktime(0, 0, 0, $month, 1, $year));
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4">
                <h2>Informations de vos rendez-vous</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-4">
                <form action="information.php" method="POST">
                    <select name="months">
                        <?php
                        foreach ($months as $monthNumber => $monthName) {
                            ?>
                            <option value="<?= $monthNumber ?>" <?= $month == $monthNumber ? 'selected' : '' ?>><?= $monthName ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <select name="years">
                        <?php
                        for ($yearsList = 2018; $yearsList <= 2100; $yearsList++) {
                            ?>
                            <option value="<?= $yearsList ?>" <?= $year == $yearsList ? 'selected' : '' ?>><?= $yearsList ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <input type="submit" name="send" value="Valider">      
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive-sm">
        <table class="calendar table table-bordered">
          <thead>
            <tr>
              <th class="thcalendar">Lundi :</th>
              <th class="thcalendar">Mardi :</th>
              <th class="thcalendar">Mercredi :</th>
              <th class="thcalendar">Jeudi :</th>
              <th class="thcalendar">Vendredi :</th>
              <th class="thcalendar">Samedi :</th>
              <th class="thcalendar">Dimanche :</th>
            </tr>
           </thead>
           <tbody>
              <tr>
                <?php
                // jour en cours
                $currentDay = 1;
                // bon nombre de cases dans le mois
                for($daysCases = 1; $daysCases <= $numberDaysInMonth + $firstWeekDayOfMonth - 1; $daysCases++) {
                    // On cherche le premier jour du mois
                    if($firstWeekDayOfMonth <= $daysCases) {
                    ?>
                        <td class="tdcalendar"><?= $currentDay ?></td>
                        <?php 
                        $currentDay++;
                    }
                    else {
                    ?>
                        <td class="tdcalendar"></td>
                    <?php
                    }
                    // Si c'est un multiple de 7 alors changement de semaines
                    if($daysCases % 7 == 0) {
                    ?>
                        </tr><tr>
                    <?php    
                        }
                    }
                    ?>
               </tr>
           </tbody>
        </table>
    </div>
<?php
}
include 'footer.php';
?>
