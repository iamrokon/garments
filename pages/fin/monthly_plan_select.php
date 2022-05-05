<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/fin_plan_monthly/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/unit/select.php'; ?>

<?php
      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectCountry = new select_country();
      $country_list =  $selectCountry->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();

      $selectUnit = new select_unit();
      $unit_list = $selectUnit->select_all();

      $selectFinishingPlan = new select_monthly_finishing_plan();
      $result = $selectFinishingPlan->select_all();

      if (isset($_POST['search'])) {
          $search= new search_c_plan();
          $result = $search->search($_POST);
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-top:15px;margin-bottom:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


              <!-- <div style="margin-right: 10px;margin-top: 10px;" id ="search">

                <form method="POST" action="">

                          <div class="row">

                            <div class="form-group col-md-4">
                                <label class="btn btn-info">Style Name</label>
                                <div class="input-group margin" style="margin-top: 0px">
                                               <select class="form-control col-md-12" name="style_select" id="style_select">
                                                  <option value="">Select Name</option>

                                                  <?php /*
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

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">Country</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="country_select" id="country_select">
                                           <option value="">Select Country</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($country_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                           <?php
                                         } */
                                           ?>
                                         </select>
                                      </div>
                                     </div>

                   </div>

                   <div class="row">

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">From Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="from_date" name="from_date" autocomplete="off">
                     </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">To Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="to_date" name="to_date" autocomplete="off">
                     </div>

                 </div>

                 <div class="text-center" style="padding-top: 10px;">
                 <button id="search" name="search" type="submit" class="btn btn-danger center-block">SEARCH</button>
                 </div>

                </form>
              </div> -->


              <?php
                while ($row = mysqli_fetch_assoc($unit_list))
                    {
                      $finishingPlanWeekList = $selectFinishingPlan->select_all_week_list_this_month();
                      $totalRows = mysqli_num_rows($finishingPlanWeekList);
                      $unitNumber = $row['id'];
              ?>

                          <table class="w3-table-all w3-small" border="1">
                              <thead style="background-color:gray;color:black;width:200px;">

                                <tr class="btn-gradient-01">
                                      <th style="width:80px;">Unit</th>
                                      <th style="width:140px;">Style Name</th>
                                      <th style="width:100px;">PO Number</th>
                                      <th style="width:100px;">Color</th>
                                      <th  colspan="100" class="text-center">Week</th>
                                      <!-- <th style="width:100px;">Total Quantity</th> -->
                                 </tr>
                                 <tr>
                                     <th style="width:80px;"><?php echo $row['name'];?></th>
                                     <th style="width:140px;"></th>
                                     <th style="width:100px;"></th>
                                     <th style="width:100px;"></th>
                                     <?php
                                         while ($week = mysqli_fetch_assoc($finishingPlanWeekList))
                                         {
                                           $finishingPlanDateList = $selectFinishingPlan->select_all_plan_date_with_week_number($week['week']);
                                           $numOfRows =  mysqli_num_rows($finishingPlanDateList);
                                           ?>
                                          <th style="width:80px;" class="text-center" colspan="<?php echo $numOfRows; ?>">
                                            <?php echo $week['week']; ?>
                                          </th>
                                       <?php
                                          }
                                          mysqli_free_result($finishingPlanWeekList);
                                      ?>
                                </tr>
                              </thead>
                              <tbody>

                                <?php

                                     $finishingPlanWeekList2 = $selectFinishingPlan->select_all_week_list_this_month();
                                     $totalRows = mysqli_num_rows($finishingPlanWeekList);

                                ?>
                                <tr>
                                    <td style="width:80px;"></td>
                                    <td style="width:140px;"></td>
                                    <td style="width:100px;"></td>
                                    <td style="width:100px;"></td>
                                    <?php
                                        while ($week = mysqli_fetch_assoc($finishingPlanWeekList2))
                                        {
                                            $finishingPlanDateList = $selectFinishingPlan->select_all_plan_date_with_week_number($week['week']);
                                            while ($date = mysqli_fetch_assoc($finishingPlanDateList))
                                            {
                                          ?>
                                            <td style="width:80px;color:black;" class="text-center"><?php echo $date['plan_date']; ?></td>
                                      <?php
                                             }
                                           }
                                      ?>
                                </tr>


                               <?php
                                    $unit_data_result = $selectFinishingPlan->select_all_finishing_plan_with_unit_id($row['id']);
                               ?>

                               <?php
                                  while ($unit_data = mysqli_fetch_assoc($unit_data_result))
                                  {
                                    $finishingPlanWeekList3 = $selectFinishingPlan->select_all_week_list_this_month();
                                ?>

                               <tr>
                                   <td style="width:80px;"></td>
                                   <td style="width:140px;color:black;"><?php echo $unit_data['style_name']; ?></td>
                                   <td style="width:100px;color:black;"><?php echo $unit_data['po_number']; ?></td>
                                   <td style="width:100px;color:black;"><?php echo $unit_data['color']; ?></td>

                                   <?php
                                       while ($week = mysqli_fetch_assoc($finishingPlanWeekList3))
                                       {
                                           $weekNumber = $week['week'];
                                           $finishingPlanDateList2 = $selectFinishingPlan->select_all_plan_date_with_week_number($week['week']);
                                           while ($date = mysqli_fetch_assoc($finishingPlanDateList2))
                                           {
                                            $finishingPlanQuantity = $selectFinishingPlan->select_all_finishing_plan_quantity_with_date_unit_week_style_po
                                                                           (
                                                                             $date['plan_date'],
                                                                             $unitNumber,
                                                                             $weekNumber,
                                                                             $unit_data['style_id'],
                                                                             $unit_data['po_id']
                                                                           );
                                            $quantityResult = mysqli_fetch_assoc($finishingPlanQuantity);
                                         ?>
                                           <td style="width:80px;color:black;" class="text-center"><?php echo $quantityResult['quantity']; ?></td>
                                     <?php
                                            }
                                          }
                                     ?>

                               </tr>

                            <?php } ?>


                              </tbody>


                          </table>
                          <br>
                        <?php
                             }
                        ?>
                      </div>
                  </div>
              </div>
