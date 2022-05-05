<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/fin_plan_monthly/insert.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/unit/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>

<?php

$user_id = $_SESSION['id'];

$selectUnit = new select_unit();
$unit_list =  $selectUnit->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$finPlanInsert = new insert();

if (isset($_POST['btn'])) {
$message = $finPlanInsert->save($_POST);

if($message){
  header('Location: monthly_plan_input.php');
}

}
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: red;padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    Finishing Plan <label></label>
                </span>
                <h4 style="color: #fff; text-align: center" id="mgs">
                 <?php
                 if (isset($message)) {
                     echo $message;
                     unset($message);
                 }
                 ?>
                 </h4>
            </div>


  <!-- modal for add country addition -->
  <!-- The Modal -->
<div id="process_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">
                       Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="process_name_input" placeholder ="Enter Process Name" required="required">
                    </div>

                </div>
                <label class="form-control-label" id="process_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_process_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_process_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>



<div id="unit_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Unit<span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="unit_name_input" placeholder ="Enter Unit Number" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="unit_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_unit_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_unit_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




<!-- modal for add style addition -->
<div id="hour_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Hour <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="hour_name_input" placeholder ="Enter Hour Name" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="hour_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_hour_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_hour_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

            <form method="post" enctype="multipart/form-data" action="" class="needs-validation" novalidate>

              <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

              <div class="row">

                <div class="form-group col-md-4">
                    <label class="btn btn-info">Unit</label>
                    <div class="input-group margin" style="margin-top: 0px">
                                   <select class="form-control col-md-12" name="unit_select" id="unit_select">
                                      <option value="">Select Unit</option>

                                      <?php
                                        while ($row = mysqli_fetch_assoc($unit_list))
                                            {
                                      ?>
                                      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                      <?php
                                            }
                                      ?>
                                    </select>
                    </div>
              </div>

                <div class="form-group col-md-4">
                    <label class="btn btn-info">Style Name</label>
                    <div class="input-group margin" style="margin-top: 0px">
                                   <select class="form-control col-md-12" name="style_select" id="style_select">
                                      <option value="">Select Name</option>

                                      <?php
                                        while ($row = mysqli_fetch_assoc($style_list))
                                            {
                                      ?>
                                      <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                                      <?php
                                            }
                                      ?>
                                    </select>
                    </div>
              </div>


              <div class="form-group col-md-4">
                  <label class="btn btn-info">PO Number</label>
                  <div class="input-group margin" style="margin-top: 0px">
                                 <select class="form-control col-md-12" name="po_select" id="po_select">
                                    <option value="">Select PO</option>

                                    <?php
                                      while ($row = mysqli_fetch_assoc($po_list))
                                          {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                    <?php
                                          }
                                    ?>
                                  </select>
                     </div>
                 </div>

             </div>

            <div class="row">

              <div class="form-group col-md-4">
                  <label class="btn btn-info">Select Cutoff</label>
                  <div class="input-group margin" style="margin-top: 0px">
                                 <select class="form-control col-md-12" name="cutoff_select" id="cutoff_select">
                                    <option value="">Select Cutoff</option>
                                    <option value="1">1st</option>
                                 </select>
                  </div>
            </div>

              <div class="form-group col-md-4">
                  <label class="btn btn-info">Week Number</label>
                  <input style="margin-top: 2px;" class="form-control" type="text" id="week_number" name="week_number" autocomplete="off">
              </div>


              <div class="form-group col-md-4">
                  <label class="btn btn-info">Date</label>
                  <input style="margin-top: 2px;" class="form-control" type="date" id="plan_date" name="plan_date" autocomplete="off">
              </div>

            </div>

            <div class="row">

              <div class="form-group col-md-4">
                  <label class="btn btn-info">Color</label>
                  <input style="margin-top: 2px;" class="form-control" type="text" id="color" name="color" autocomplete="off">
              </div>

              <div class="form-group col-md-4">
                  <label class="btn btn-info">Quantity</label>
                  <input style="margin-top: 2px;" class="form-control" type="number" id="quantity" name="quantity" autocomplete="off">
              </div>

            </div>

            <br>


            <div class="text-center" style="padding-bottom: 10px;">
            <button name="btn" type="submit" class="btn btn-danger center-block">Save</button>
            </div>
       </div>

     </form>

</div>
</div>
</div>
