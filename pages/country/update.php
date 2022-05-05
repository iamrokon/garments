<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/country/update.php'; ?>

<?php
  $id = $_GET['id'];

  $country = new select_country();
  $result = $country->select_with_id($id);
  $data = mysqli_fetch_assoc($result);

  $update_country = new update();

  if (isset($_POST['btn'])) {
     $message = $update_country->updateData($_POST);

     $result = $country->select_with_id($id);
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

                            <label class="form-control-label">Country Name <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="full_name" value="<?php echo $data['full_name']; ?>" placeholder ="Enter Country Name" required="">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $data['id']; ?>" required="">
                            </div>
                          </div>
                      </div>



                    <div class="col-md-6">

                      <div class="form-group">

                          <label class="form-control-label">Short Name <span style="color:red;">*</span></label>

                          <div class="input-group">
                              <span class="input-group-addon addon-primary">
                                  <i class="la la-file-text"></i>
                              </span>
                              <input type="text" class="form-control" name="short_name" value="<?php echo $data['short_name']; ?>" placeholder ="Enter Short Name" required="">
                          </div>
                          </div>
                      </div>

                    <div class="col-md-6">

                      <div class="form-group">

                          <label class="form-control-label">Cut Off<span style="color:red;">*</span></label>

                          <div class="input-group">
                              <span class="input-group-addon addon-primary">
                                  <i class="la la-file-text"></i>
                              </span>
                              <input type="text" class="form-control" name="cut_off" value="<?php echo $data['cut_off']; ?>" placeholder ="Enter Cut Off" required="">
                          </div>
                          </div>
                      </div>

                     <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Country Code <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="country_code" value="<?php echo $data['country_code']; ?>" placeholder ="Enter Country Code" required="">
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
