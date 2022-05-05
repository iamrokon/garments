<?php require_once dirname(__FILE__).'/../DB/dashboard.php'; ?>
<?php
$dashboard = new dashboard();

$totalOrderQuantity = $dashboard->getTotalOrderQuantity();
$totalCutProQuantity = $dashboard->getTotalCuttingProductionQuantity();
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
  padding: 10px;
  height: 200px; /* Should be removed. Only for demonstration */
}

/* Create three equal columns that floats next to each other */
.column2 {
  float: left;
  width: 25%;
  padding: 10px;
  height: 200px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>
<body style="background-color:white;align:center;">

<div  style="color:black;">
<center><h1>SDL DENIMS SUMMARY</h1></center>
</div>

<div class="row">
  <div class="column" style="background: red;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">ORDER</h2></center>
    <center><p style="font-size:30px;color:white;"><?php echo $totalOrderQuantity; ?></p></center>
  </div>
  <div class="column" style="background: orange;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">CUTTING PRODUCTION</h2></center>
    <center><p style="font-size:30px;color:white;"><?php echo $totalCutProQuantity; ?></p></center>
  </div>
  <div class="column" style="background: purple;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">CUTTING WIP</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: green;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">DAILY TRIMS INHOUSE</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
</div>



<div class="row">
  <div class="column" style="background: crimson;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">MAINTENANCE</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: chocolate;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">INPUT ISSUE TO SWING</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: darkgoldenrod;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">PRODUCTION PLANNING</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: darkolivegreen;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">SWING OUTPUT</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
</div>


<div class="row">
  <div class="column" style="background: darkslategray;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">SWEING WIP</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: fuchsia;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">HR</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: indianred;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">IE DEPARTMENT</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: maroon;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">QA DEPARTMENT</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
</div>

<div class="row">
  <div class="column" style="background: orangered;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">NCQ INLINE INSPECTION</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: teal;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">RQS INSPECTION AND EDIT</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: olive;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">WASH SEND</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: darkblue;margin:3px;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">WASH RECIEVED</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
</div>

<div class="row">
  <div class="column" style="background: brown;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">WASH WIP</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
  <div class="column" style="background: DarkSlateBlue;margin:3px;">
    <center><h2 style="padding-top:10px;color:white;">FINISHING INPUT</h2></center>
    <center><p style="font-size:30px;color:white;">0</p></center>
  </div>
</div>

</body>
</html>


<script>

        setTimeout(function(){
        window.location.reload(1);
        }, 20000);


</script>
