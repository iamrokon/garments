<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/process_e/select.php'; ?>
<?php require_once '../../DB/process_e/update.php'; ?>
<?php

$user_id = $_SESSION['id'];
$e_id = $_GET['id'];

$selectProcessE = new select_process_e();
$process_e_list = $selectProcessE->select_child_with_id($e_id);
$info = mysqli_fetch_assoc($process_e_list);

if(isset($_POST['btn'])){

$update = new update();
$message = $update->updateData($_POST);

}

if($message){
   $_SESSION['message'] = $message;
   header("Location: update.php?id=".$e_id); // redirect back to your form
   exit;
}

?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 15px;color: #fff;margin-left:10px;">
                    EFFICIENCY UPDATION
                </span>
                <h4 style="color: #fff; text-align: center">
                  <?php
                  if (isset($_SESSION['message'])) {
                      echo $_SESSION['message'];
                      unset($_SESSION['message']);
                  }
                  ?>
                 </h4>
            </div>
            <!-- End Page Header -->
            <div class="box-body  w3-card-4">
                <form method="post" enctype="multipart/form-data" action="" class="needs-validation" novalidate>

                    <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                      <?php
                            $total = $info['one'] + $info['two'] + $info['three'] + $info['four'] + $info['five']
                                   + $info['six'] + $info['seven'] + $info['eight'] + $info['nine'] + $info['ten'];
                      ?>

                     <div class="col-md-4">
                       <div class="form-group">
                           <label class="form-control-label" style="margin-right:30px;">Operator</label>
                           <label><?php echo $info['opt_name']; ?>
                             <input type="hidden" name="id" id="id" value="<?php echo $info['id']; ?>">
                       </div>


                      <div class="form-group">

                      <label class="form-control-label" style="margin-right:58px;">SMV</label>
                      <label><?php echo $info['smv']; ?>

                      </div>

                        <div class="form-group">
                           <label class="form-control-label" style="margin-right:60px;">3RD</label>
                           <input type="number" name="three" id="three" value="<?php echo $info['three']; ?>" onkeyup="summary(this.value)">
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" style="margin-right:60px;">6TH</label>
                            <input type="number" name="six" id="six" value="<?php echo $info['six']; ?>" onkeyup="summary(this.value)">
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" style="margin-right:60px;">9TH</label>
                            <input type="number" name="nine" id="nine" value="<?php echo $info['nine']; ?>" onkeyup="summary(this.value)">
                        </div>

            </div>



            <div class="col-md-4">

              <div class="form-group">

                  <label class="form-control-label" style="margin-right:30px;">Operator ID</label>
                  <label><?php echo $info['opt_id']; ?>

              </div>


              <div class="form-group">
                  <label class="form-control-label" style="margin-right:80px;">1ST</label>
                  <input type="number" name="one" id="one" value="<?php echo $info['one']; ?>" onkeyup="summary(this.value)">
              </div>

                <div class="form-group">
                    <label class="form-control-label" style="margin-right:80px;">4TH</label>
                    <input type="number" name="four" id="four" value="<?php echo $info['four']; ?>" onkeyup="summary(this.value)">
                </div>

                <div class="form-group">
                    <label class="form-control-label" style="margin-right:80px;">7TH</label>
                    <input type="number" name="seven" id="seven" value="<?php echo $info['seven']; ?>" onkeyup="summary(this.value)">
                </div>


                <div class="form-group">
                    <label class="form-control-label" style="margin-right:70px;">10TH</label>
                    <input type="number" name="ten" id="ten" value="<?php echo $info['ten']; ?>" onkeyup="summary(this.value)">
                </div>

        </div>



        <div class="col-md-4">

          <div class="form-group">

              <label class="form-control-label" style="margin-right:30px;">Process Name</label>
              <label><?php echo $info['process_name']; ?>

          </div>


            <div class="form-group">
                <label class="form-control-label" style="margin-right:100px;">2ND</label>
                <input type="number" name="two" id="two" value="<?php echo $info['two']; ?>" onkeyup="summary(this.value)">
            </div>


            <div class="form-group">
                <label class="form-control-label" style="margin-right:100px;">5TH</label>
                <input type="number" name="five" id="five" value="<?php echo $info['five']; ?>" onkeyup="summary(this.value)">
            </div>

            <div class="form-group">
                <label class="form-control-label" style="margin-right:100px;">8TH</label>
                <input type="number" name="eight" id="eight" value="<?php echo $info['eight']; ?>" onkeyup="summary(this.value)">
            </div>

            <div class="form-group">
                <label class="form-control-label" style="margin-right:80px;">TOTAL</label>
                <input readonly type="number" name="total" id="total" value="<?php echo $total; ?>">
            </div>

    </div>

    </div>

    <div class="text-center" style="padding-bottom: 10px;">
        <button name="btn" class="btn btn-gradient-03" type="submit">Update</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>


</form>

</div>
</div>
</div>
</div>


<script>

function summary(value){

   var totalValue = 0;
   var one = parseInt(document.getElementById('one').value);
   var two = parseInt(document.getElementById('two').value);
   var three = parseInt(document.getElementById('three').value);
   var four = parseInt(document.getElementById('four').value);
   var five = parseInt(document.getElementById('five').value);
   var six = parseInt(document.getElementById('six').value);
   var seven = parseInt(document.getElementById('seven').value);
   var eight = parseInt(document.getElementById('eight').value);
   var nine = parseInt(document.getElementById('nine').value);
   var ten = parseInt(document.getElementById('ten').value);

   totalValue = one + two + three + four + five + six + seven + eight + nine + ten;

  document.getElementById('total').value = totalValue;
}

</script>
