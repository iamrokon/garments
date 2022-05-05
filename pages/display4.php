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
$totalCutProQuantity = $dashboard->getTotalCuttingProductionQuantity();
$totalInputIssue = $dashboard->getTotalInputIssue();
?>

<?php
$ob = new select_trims_inhouse();
$result = $ob->select_all();
$i = 1; $Balance = 0;
while ($info = mysqli_fetch_assoc($result)){
$Balance += $info['total_balance'];}
?>

<?php
$ob = new select_swoutput();
$result = $ob->select_scan_swoutput_total();
while ($info = mysqli_fetch_assoc($result)) {
$total_scan = $info['total_scan']; }
?>

<?php
$ob_w = new select_washsend();
$result_w = $ob_w->select_scan_wsend_total();
while ($info_w = mysqli_fetch_assoc($result_w)) {
$total_scan_w = $info_w['total_scan'];}
?>

<?php
$ob_w = new select_washsend();
$result_rw = $ob_w->select_scan_wrece_total();
while($info_rw = mysqli_fetch_assoc($result_rw)) {
$total_scan_wr = $info_rw['total_scan']; }
?>


<?php
$ob_f = new select_finishing();
$result_finp = $ob_f->select_inp_scan_fin_total();
while ($info_finp = mysqli_fetch_assoc($result_finp)) {
$total_scan_finp = $info_finp['total_scan'];
}
?>

<?php
$ob_f = new select_finishing();
$result_f = $ob_f->select_scan_fin_total();
while ($info_f = mysqli_fetch_assoc($result_f)) {
$total_scan_f = $info_f['total_scan'];
}
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
  width: 24.5%;
  padding: 3px;
  height: 110px; /* Should be removed. Only for demonstration */
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
<body style="background-color:white;align:center;background-color:#ADFF2F;">

<div  style="color:#000;">
<center><h1> SDL HOURLY DATA PROGRESS SUMMARY </h1></center>
</div>


<div class="row">
  <div class="column" style="background: red;margin:3px;">
    <center style="color:#000;">Order Quantity</center>
    <center><p style="font-size:25px;color:white;"><b><?php echo $totalOrderQuantity; ?></b></p></center>
  </div>
  <div class="column" style="background: orange;margin:3px;">
    <center style="color:#000;">Cutting Production</center>
    <center><p style="font-size:25px;color:white;"><b><?php echo $totalCutProQuantity; ?></b></p></center>
  </div>
  <div class="column" style="background: Lemon;margin:3px;">
    <center style="color:#000;">Cutting WIP</center>
    <center><p style="font-size:25px;color:white;"><?php echo $totalCutProQuantity-$totalInputIssue; ?></p></center>
  </div>
  <div class="column" style="background: green;margin:3px;">
    <center style="color:#000;">Trims Store</center>
    <center><p style="font-size:25px;color:white;"><?php echo $Balance; ?></p></center>
  </div>
</div>



<div class="row">
  <div class="column" style="background: crimson;margin:3px;">
    <center style="color:#000;">Maintenance</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: chocolate;margin:3px;">
    <center style="color:#000;">Input Issue Status</center>
    <center><p style="font-size:25px;color:white;"><b><?php echo $totalInputIssue; ?></b></p></center>
  </div>
  <div class="column" style="background: darkgoldenrod;margin:3px;">
    <center style="color:#000;">Production Planning</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: darkolivegreen;margin:3px;">
    <center style="color:#000;">Sewing Output</center>
    <center><p style="font-size:25px;color:white;"><?php echo $total_scan; ?></p></center>
  </div>
</div>


<div class="row">
  <div class="column" style="background: Lime;margin:3px;">
    <center style="color:#000;">Sewing WIP</center>
    <center><p style="font-size:25px;color:white;"><?php echo $totalInputIssue-$total_scan; ?></p></center>
  </div>
  <div class="column" style="background: fuchsia;margin:3px;">
    <center style="color:#000;">HR Department</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: indianred;margin:3px;">
    <center style="color:#000;">IE Department</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: Electric blue;margin:3px;">
    <center style="color:#000;">QA Department</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
</div>

<div class="row">
  <div class="column" style="background: orangered;margin:3px;">
    <center style="color:#000;">NQC Department</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: teal;margin:3px;">
    <center style="color:white;">RQS Department</center>
    <center><p style="font-size:25px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: olive;margin:3px;">
    <center style="color:#000;">Wash Send</center>
   <center><p style="font-size:25px;color:white;"><?php echo $total_scan_w; ?></p></center>
  </div>
  <div class="column" style="background: Cyan;margin:3px;margin:3px;">
    <center style="color:#000;">Wash Received</center>
    <center><p style="font-size:25px;color:white;"><?php echo $total_scan_wr; ?></p></center>
  </div>
</div>

<div class="row">
  <div class="column" style="background: brown;margin:3px;">
    <center style="color:#000;">Wash WIP</center>
    <center><p style="font-size:25px;color:white;"><?php echo $total_scan_w-$total_scan_wr; ?></p></center>
  </div>
  <div class="column" style="background: DarkSlateBlue;margin:3px;">
    <center style="color:#000;">Finishing Input</center>
    <center><p style="font-size:25px;color:white;"><?php echo $total_scan_finp;?></p></center>
  </div>

  <div class="column" style="background: brown;margin:3px;">
    <center style="color:#000;">Finishing Output</center>
    <center><p style="font-size:25px;color:white;"><?php echo $total_scan_f; ?></p></center>
  </div>
  <div class="column" style="background: DarkSlateBlue;margin:3px;">
    <center style="color:#000;">Finishing WIP</center>
    <center><p style="font-size:25px;color:white;"><?php echo $total_scan_finp - $total_scan_f;?></p></center>
  </div>
 
</div>

<div class="row" style="margin-top:10px;">
    <div class="col-md-12">
          <marquee direction="left" scrollamount="3" bgcolor="lightgreen">
          <b>
          <span style="color:#000;font-size:40px;">
              
            ORDER QTY               : <?php echo $totalOrderQuantity; ?>
          | CUTTING PRODUCTION      : <?php echo $totalCutProQuantity; ?>
          | CUTTING WIP             : <?php echo 0; ?>
          | DAILY TRIMS INHOUSE     : <?php echo 0; ?>
          | INPUT ISSUE TO SEWING   : <?php echo $totalInputIssue; ?>
          | PRODUCTION PLANNING     : <?php echo 0; ?>
          | SEWING OUTPUT           : <?php echo 0; ?>
          | WASH SEND               : <?php echo 0;?>
          | WASH RECIEVED           : <?php echo 0;?>
          | FINISHING INPUT         : <?php echo 0; ?>
          | FINISHING OUTPUT        : <?php echo 0?>
          
        </span>
        </b>
        </marquee>
    </div>
</div>


</body>
</html>


<script>

             window.setTimeout(function(){
             window.location.href = "http://fabricstore.sdlcutps.com/Display/dashboard_5.php";
             }, 120000);


</script>
