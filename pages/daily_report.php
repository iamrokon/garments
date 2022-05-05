<?php require_once dirname(__FILE__).'/../DB/dashboard.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/trims_inhouse/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/trims_inhouse/search.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/swoutput/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/wsend/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/fin/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/shipment/select.php'; ?>
<?php

$dashboard = new dashboard();

$totalOrderQuantity = $dashboard->getTotalOrderQuantity();
$allOrderQuantity = $dashboard->allOrderQuantity();
$dailyOrderQuantity = $dashboard->dailyOrderQuantity();

$totalCutProQuantity = $dashboard->getTotalCuttingProductionQuantity();
$allCutProQuantity = $dashboard->allCuttingProductionQuantity();
$dailyCutProQuantity = $dashboard->dailyCuttingProductionQuantity();

$totalInputIssue = $dashboard->getTotalInputIssue();
$allInputIssue = $dashboard->allInputIssue();
$dailyInputIssue = $dashboard->dailyInputIssue();

?>


<?php
// $ob = new select_trims_inhouse();
// $result = $ob->select_all();
// $i = 1; $Balance = 0;
// while ($info = mysqli_fetch_assoc($result)){
// $Balance += $info['total_balance'];}
?>


<?php
// $ob = new select_swoutput();
// $result = $ob->select_scan_swoutput_total();
// while ($info = mysqli_fetch_assoc($result)) {
// $total_scan = $info['total_scan']; }
?>




<?php
// $ob_f = new select_finishing();
// $result_finp = $ob_f->select_inp_scan_fin_total();
// while ($info_finp = mysqli_fetch_assoc($result_finp)) {
// $total_scan_finp = $info_finp['total_scan'];
// }
?>


<?php
// $ob_f = new select_finishing();
// $result_f = $ob_f->select_scan_fin_total();
// while ($info_f = mysqli_fetch_assoc($result_f)) {
// $total_scan_f = $info_f['total_scan'];
// }
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
* {
  box-sizing: border-box;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 150px; /* Should be removed. Only for demonstration */
}

/* Create three equal columns that floats next to each other */
.column2 {
  float: left;
  width: 25%;
  padding: 10px;
  height: 120px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}


</style>

</head>

<body style="background-color:#98FB98; align:center; background-color:SNOW;">

<div  style="color:#000;">

<center><h1> SDL HOURLY DATA PROGRESS SUMMARY </h1></center>

</div>


<div class="row">

  <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #993300 120%);">
    <center> <h2 style="padding-top:20px;color:#000;"> Daily Order Entry Qty </h2> </center>
    <center><p style="font-size:30px;color:white;"><b> <?php echo $dailyOrderQuantity; ?> </b></p></center>
  </div>

  <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #339966 120%);">
    <center> <h2 style="padding-top:20px;color:#000;"> Monthly Order Entry Qty </h2> </center>
    <center><p style="font-size:30px;color:white;"><b> <?php echo $totalOrderQuantity; ?> </b></p></center>
  </div>

  <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #339966 120%);">
    <center> <h2 style="padding-top:20px;color:#000;"> Total Order Entry Qty </h2> </center>
    <center><p style="font-size:30px;color:white;"><b> <?php echo $allOrderQuantity; ?> </b></p></center>
  </div>


</div>



<div class="row">

  <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #ff5050 100%)">
    <center> <h2 style="padding-top:10px;color:#000;"> Daily Cutting Production </h2></center>
    <center><p style="font-size:30px;color:white;"><b> <?php echo $dailyCutProQuantity; ?> </b></p></center>
  </div>


  <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #9933ff 100%)">
    <center> <h2 style="padding-top:10px;color:#000;"> Monthly Cutting Production </h2></center>
    <center><p style="font-size:30px;color:white;"><b> <?php echo $totalCutProQuantity; ?> </b></p></center>
  </div>


  <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #9933ff 100%)">
    <center> <h2 style="padding-top:10px;color:#000;"> Total Cutting Production </h2></center>
    <center><p style="font-size:30px;color:white;"><b> <?php echo $allCutProQuantity; ?> </b></p></center>
  </div>


</div>


  <div class="row">



     <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #339966 100%);">
    <center> <h2 style="padding-top:10px;color:#000;">  Daily Input Issue QTY </h2></center>
    <center><p style="font-size:30px;color:white;"><b><?php echo $dailyInputIssue; ?></b></p></center>
    </div>

     <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #993300 100%);">
    <center> <h2 style="padding-top:10px;color:#000;">  Monthly Input Issue QTY </h2></center>
    <center><p style="font-size:30px;color:white;"><b><?php echo $totalInputIssue; ?></b></p></center>
    </div>


    <div class="column" style="background: linear-gradient(to bottom, #ffcc99 0%, #993300 100%);">
    <center> <h2 style="padding-top:10px;color:#000;">  Total Input Issue QTY </h2></center>
    <center><p style="font-size:30px;color:white;"><b><?php echo $allInputIssue; ?></b></p></center>
    </div>

  </div>

<div class="row" style="margin-top:9px;">

    <div class="col-md-12">

           <marquee direction="left" scrollamount="3" bgcolor="#ff5050"><b><span style="color:#000;font-size:40px;">

          <b>

          <span style="color:#000;font-size:40px;">

            ORDER QTY               : <?php echo $totalOrderQuantity; ?>

          | CUTTING PRODUCTION      : <?php echo $totalCutProQuantity; ?>

          | CUTTING WIP             : <?php echo $totalCutProQuantity-$totalInputIssue; ?>

          | INPUT ISSUE TO SEWING   : <?php echo $totalInputIssue; ?>

          | FINISHING INPUT         : <?php //echo $total_scan_finp; ?>

          | FINISHING OUTPUT        : <?php //echo $total_scan_f; ?>

          | FINISHING WIP           : <?php //echo $total_scan_finp - $total_scan_f; ?>



        </span>
        </b>
        </marquee>
    </div>
</div>


</body>
</html>


<script>

             window.setTimeout(function(){
             window.location.href = "http://sewing.sdlcutps.com/pages/display2.php";
             }, 20000);


</script>
