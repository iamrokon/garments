<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/process_e/select.php'; ?>
<?php require_once '../../DB/process_e/update.php'; ?>
<?php

$user_id = $_SESSION['id'];
$e_id = $_GET['id'];

$selectProcessE = new select_process_e();
$process_e = $selectProcessE->select_process_with_id($e_id);
$info = mysqli_fetch_assoc($process_e);

if(isset($_POST['btn'])){

$update = new update();
$message = $update->updateDataProcess($_POST);

}

if($message){
   $_SESSION['message'] = $message;
   header("Location: update_e.php?id=".$e_id); // redirect back to your form
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
                    UPDATE PROCESS
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

                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">


                      <div class="col-md-8">
                         <div class="form-group">

                             <label class="form-control-label">Process Name<span style="color:red;">*</span></label>

                             <div class="input-group">
                                 <span class="input-group-addon addon-primary">
                                     <i class="la la-user"></i>
                                 </span>
                                 <input type="text" name="p_name" class="form-control" placeholder ="Enter Process Name" value="<?php echo $info['name']; ?>">
                             </div>

                         </div>

                       </div>


             <div class="col-md-4">
                <div class="form-group">

                    <label class="form-control-label">SMV<span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-user"></i>
                        </span>
                        <input type="text" name="smv" class="form-control" placeholder ="Enter SMV" value="<?php echo $info['smv']; ?>">
                    </div>

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
