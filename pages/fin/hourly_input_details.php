<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/fin_plan/select.php'; ?>

<?php

$user_id = $_SESSION['id'];
$finishing_plan_id = $_GET['id'];

//select finishing plan details
$selectFinishingPlan = new select_finishing_plan();
$finishing_plan_result = $selectFinishingPlan->select_with_id($finishing_plan_id);
$finishing_plan_details = mysqli_fetch_assoc($finishing_plan_result);

//select unit list with finishing plan id
$finishingPlanUnitList = $selectFinishingPlan->select_finishing_plan_unit_with_id($finishing_plan_id);

//select child of finishing plan hour details
$finishing_plan_child_hour = $selectFinishingPlan->select_child_with_id($finishing_plan_id);

if (isset($_POST['btn'])) {
$order_id = $orderUpdate->update_cutting_plan($order_id,$_POST['cutting_plan'],$user_id);
}
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: red;padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    Hourly Production Details <label></label>
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
            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

              <!-- <div class="row">
              <div class="col-md-6">
              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">Style Name <span style="color: red">*</span></label>
                                <select disabled class="form-control col-md-6" name="style_select" id="style_select">
                                <option>Select Name</option>

                                <?php /*
                                  while ($row = mysqli_fetch_assoc($style_list))
                                    {
                                      if($order_details['style'] == $row['id'])
                                      {
                                ?>
                                <option selected value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
              </div>

              <div class="input-group margin" style="margin-top: 20px">
                                <label class="form-control-label btn btn-success" style="margin-right:48px;">Country <span style="color: red">*</span></label>
                                <select disabled class="form-control col-md-6" name="country_select" id="country_select">
                                <option>Select Country</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($country_list))
                                      {
                                        if($order_details['country'] == $row['id'])
                                        {
                                ?>
                                <option selected value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
              </div>

              <div class="input-group margin" style="margin-top: 20px">
                                <label class="form-control-label btn btn-success" style="margin-right:70px;">Time <span style="color: red">*</span></label>
                                <input disabled type="text" value="<?php echo $order_details['creation_time']; ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
               </div>

              </div>


              <div class="col-md-6">
              <div class="input-group margin">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">PO Number <span style="color: red">*</span></label>
                                <select disabled class="form-control col-md-6" name="po_select" id="po_select">
                                <option>Select PO</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($po_list))
                                      {
                                        if($order_details['po'] == $row['id'])
                                        {
                                ?>
                                <option selected value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
               </div>

               <div class="input-group margin" style="margin-top: 20px">
                                 <label class="form-control-label btn btn-success" style="margin-right:70px;">Date <span style="color: red">*</span></label>
                                 <input disabled type="text" value="<?php echo $order_details['creation_date']; ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
                </div>



                <div class="input-group margin" style="margin-top: 20px">
                                  <label class="form-control-label btn btn-success" style="margin-right:50px;">Cutting <span style="color: red">*</span></label>
                                  <input disabled type="text" value="<?php echo $cutting_plan = $order_details['cutting_plan']." %"; */ ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
                 </div>


             </div>

             </div> -->

                 <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">


                   <div class="table-responsive">

                     <?php
                      while ($unit = mysqli_fetch_assoc($finishingPlanUnitList)) {

                       $hourListTable = $selectFinishingPlan->select_finishing_plan_hour_with_plan_id_and_unit_id($unit['plan_id'],$unit['unit_id']);
                       $processList = $selectFinishingPlan->select_finishing_plan_hour_with_plan_id_and_unit_id($unit['plan_id'],$unit['unit_id']);

                       $total = 0;
                       ?>

                     <table class="w3-table-all w3-small" border="1">

                                <thead style="background-color:gray;color:black;">

                                <tr class="btn-gradient-01">
                                <th>
                                Unit
                                </th>

                                <th>
                                Process
                                </th>

                                <th style="width:100px;" class="text-center">
                                Target
                                </th>

                                <th colspan="<?php echo mysqli_num_rows($hourListTable); ?>" class="text-center">
                                Hour List
                                </th>

                                </tr>

                                <tr>
                                <th>
                                <?php echo $unit['unit_name']; ?>
                                </th>

                                <th class="btn-gradient-02">

                                </th>

                                <th class="btn-gradient-02">
                                </th>

                                <?php
                                 while ($hourChild = mysqli_fetch_assoc($hourListTable)) {
                                ?>
                                <th style="width:100px;" class="btn-gradient-02 text-center">
                                      <?php echo $hourChild['hour_name']; ?>
                                </th>

                                <?php

                                $hourListInputs .=   '<td class="text-center">'
                                                    .'<input type="number" name="quantity_input_" style="width:60px;" value="'.$hourChild['hour_value'].'"></input>'
                                                    .'</td>';

                                      }
                                ?>

                                </tr>

                                </thead>

                                <tbody>

                                <!-- +processList -->
                                <?php
                                 while ($process = mysqli_fetch_assoc($processList)) {
                                ?>
                                <tr>
                                  <td style="width:140px;"></td>
                                  <td style="width:100px;" class="text-center btn-gradient-01"><?php echo $process['process_name']; ?></td>
                                  <td style="color:black;" class="text-center">
                                  <?php echo $process['target']; ?>
                                  </td>
                                         <!-- + hourListInputs -->
                                         <?php
                                               echo $hourListInputs;
                                         ?>
                                </tr>

                                <?php
                                      }

                                      $hourListInputs  = "";
                                ?>

                                </tbody>

                                </table>
                                <br>
                                <?php
                                   }
                                ?>


                  </div>


       </div>

       </div>


</div>
</div>
<script>

</script>
