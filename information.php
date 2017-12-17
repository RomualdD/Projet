<?php
session_start();
if(!isset($_SESSION['user'])){
  include 'header.php';
  echo "Vous n'êtes pas connecté pour accéder au contenu";
}
else {
  include 'header1.php';
?>
<div class="container">
  <div class="row">
    <div class="col-lg-offset-4">
      <h2>Informations de vos rendez-vous</h2>
    </div>
  </div>
  <?php
    require('date.php');
    $date = new Date();
    $years = date('Y');
    $calendar = $date->getDate($years);
   ?>
   <div class="period">
     <div class="year">
       <select class="month" name="month">
         <?php foreach ($date->months as $id => $month) {?>
           <option value="<?php echo $month; ?>" id="linkMonth<?php echo $id+1; ?>"><?php echo $month;?></option>
        <?php }?>
       </select>
     </div>
   </div>
   <table>
     <thead>
       <tr>
         <th></th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td></td>
       </tr>
     </tbody>
   </table>
</div>

<?php
  }
  include 'footer.php';
 ?>
