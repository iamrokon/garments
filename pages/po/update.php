<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/po/update.php'; ?>

<?php
  $id = $_GET['id'];

  $obSelect= new select_po();
  $result = $obSelect->select_with_id($id);
  $data = mysqli_fetch_assoc($result);

  $obUpdate = new update();

  if (isset($_POST['btn'])) {
     $message = $obUpdate->updateData($_POST);

     $result = $obSelect->select_with_id($id);
     $data = mysqli_fetch_assoc($result);
    }
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: #3c8dbc;padding: 15px; margin-top: 5px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    All star marked ( <span style="color:red;">*</span> ) fields are mandatory, please fill up all mandatory fields.
                </span>
              <h4 style="color: #fff; text-align: center">
               <?php
               if (isset($message)) {
                   echo $message;
                   unset($message);
               }
               ?>
               </h4>
            </div>
            <!-- End Page Header -->
            <div class="box-body">
                <form method="post" enctype="multipart/form-data" action="" id="update-form" class="needs-validation w3-card-4" novalidate>

                    <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                     <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">PO Number <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="po_num" value="<?php echo $data['po_num']; ?>" placeholder ="Enter PO Number" required="">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $data['id']; ?>" required="">
                            </div>
                            </div>
            </div>



            <div class="col-md-6">

              <div class="form-group">

                  <label class="form-control-label">Details <span style="color:red;">*</span></label>

                  <div class="input-group">
                      <span class="input-group-addon addon-primary">
                          <i class="la la-file-text"></i>
                      </span>
                      <input type="text" class="form-control" name="details" value="<?php echo $data['details']; ?>" placeholder ="Enter Details" required="">
                  </div>
                  </div>

           </div>

    </div>


    <div class="text-center" style="padding-bottom: 10px;">
        <button name="btn" class="btn btn-gradient-03" type="submit">Update Info</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>


</form>

</div>
</div>
</div>
</div>
