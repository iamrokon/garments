<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/size/insert.php'; ?>

<?php
      $size = new insert();

      if (isset($_POST['btn'])) {
      $message = $size->save($_POST);
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
                <form method="post" enctype="multipart/form-data" action="" class="needs-validation w3-card-4" novalidate>

                    <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                     <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Size Number <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="size_num" placeholder ="Enter Size Number" required="required">
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
                      <input type="text" class="form-control" name="details" placeholder ="Enter Details" required="required">
                  </div>

              </div>

        </div>

    </div>



    <div class="text-center" style="padding-bottom: 10px;">
        <button name="btn" class="btn btn-gradient-03" type="submit">Save Info</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>


</form>

</div>                        <!-- End Row -->

<!-- End Container -->
<!-- Begin Page Footer-->

<!-- Offcanvas Sidebar -->

<!-- End Offcanvas Sidebar -->
</div>
</div>
</div>
