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

<body style="background-color:white;align:center;background-color:FFEFD5;">

<div  style="color:#000;">
<center><h1> SDL HOURLY DATA PROGRESS SUMMARY </h1></center>
</div>


<div style="width:100%;float:left" >
  
  <?php
  
   
?>
 <div><br>
 
 <marquee behavior="scroll"  dir="ltr" align="absbottom">
 
 <img src="display-1.jpg" width="1000" height="400"/>
 
 <img src="display-2.jpg" width="1000" height="400"/>
 
 <img src="display-3.jpg" width="1000" height="400"/>
 
 <img src="display-4.jpg" width="1000" height="400"/>
 
 <img src="display-5.jpg" width="1000" height="400"/>
 
 </marquee>
 
 </div>
 	
</div>


<div class="row" style="margin-top:10px;">

    <div class="col-md-12">
	
          <marquee direction="left" scrollamount="3" bgcolor="coral">
          <b>
          <span style="color:#000;font-size:40px;">
              
		   Line Wise Production :
		   
		    
            Line-1     : <?php echo 0; ?>
          | Line-2     : <?php echo 0; ?>
          | Line-3     : <?php echo 0; ?>
          | Line-4     : <?php echo 0; ?>
          | Line-5     : <?php echo 0; ?>
          | Line-6     : <?php echo 0; ?>
          | Line-7     : <?php echo 0; ?>
          | Line-8     : <?php echo 0; ?>
          | Line-9     : <?php echo 0; ?>
          | Line-10    : <?php echo 0; ?>
          | Line-11    : <?php echo 0; ?>
		  | Line-12    : <?php echo 0; ?>
		  | Line-13    : <?php echo 0; ?>
		  | Line-14    : <?php echo 0; ?>
		  | Line-15    : <?php echo 0; ?>
		  | Line-16    : <?php echo 0; ?>
		  | Line-17    : <?php echo 0; ?>
		  | Line-18    : <?php echo 0; ?>
		  | Line-19    : <?php echo 0; ?>
		  | Line-20    : <?php echo 0; ?>
          
        </span>
        </b>
        </marquee>
    </div>
</div>


</body>
</html>


<script>

             window.setTimeout(function(){
             window.location.href = "http://fabricstore.sdlcutps.com/Display/dashboard_4.php";
             }, 120000);


</script>
