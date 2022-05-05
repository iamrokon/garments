<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/pe_operator/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/pe_operator/update.php'; ?>

<?php
      $selectOperator = new select_pe();
      $operator_list = $selectOperator->select_all();

      $selectLine = new select_line();
      $line_list = $selectLine->select_all();

      $update = new update();

      if (isset($_POST['btn'])) {
           $message = $update->updateData($_POST);
      }


      if($message){
         $_SESSION['message'] = $message;
         header("Location: transfer_operator.php"); // redirect back to your form
         exit;
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-left:15px;margin-right:15px;">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
          <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
              <h3 class="box-title"></h3>
              <span style="font-size: 14px;color: #fff">
                  Transfer Operator <label></label>
              </span>
              <h4 style="color: #fff; text-align: center" id="mgs">
               <?php
               if (isset($_SESSION['message'])) {
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
               }
               ?>
               </h4>
          </div>
            <!-- End Page Header -->
                <form method="post" enctype="multipart/form-data" action="" class="box-body needs-validation w3-card-4" novalidate>

                    <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                      <div class="form-group col-md-6">
                          <label class="btn btn-info">Operator</label>
                          <div class="input-group margin" style="background-color:white;">
                                           <select class="form-control col-md-12" name="operator_select" id="operator_select">
                                            <option value="">Select Operator</option>

                                            <?php
                                              while ($row = mysqli_fetch_assoc($operator_list))
                                                  {
                                            ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']."(".$row['operator_id'].")"." ".$row['line_name'].""; ?></option>
                                            <?php
                                                  }
                                            ?>
                                          </select>
                         </div>
                         </div>


                         <div class="form-group col-md-6">
                             <label class="btn btn-info">Line</label>
                             <div class="input-group margin" style="background-color:white;">
                                              <select class="form-control col-md-12" name="line_select" id="line_select">
                                               <option value="">Select Line</option>

                                               <?php
                                                 while ($row = mysqli_fetch_assoc($line_list))
                                                     {
                                               ?>
                                               <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                               <?php
                                                     }
                                               ?>
                                             </select>
                            </div>
                            </div>

                   </div>


    <div class="text-center" style="padding-bottom: 10px;">
        <button name="btn" class="btn btn-gradient-03" type="submit">Transfer</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>

</form>


</div>
</div>
</div>
