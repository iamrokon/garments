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


        <div class="box-header with-border " style=" background-color: red;padding: 10px; margin-top: 3px;">
            <h3 class="box-title"></h3>
            <span style="font-size: 14px;color: #fff">
                Monthly Finishing Plan<label></label>
            </span>
        </div>

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


              <?php
                      $finishingPlanWeekList = $selectFinishingPlan->select_all_order_tod_week_list_this_month();
                      $totalRows = mysqli_num_rows($finishingPlanWeekList);
              ?>

                          <table class="w3-table-all w3-small" border="1">
                              <thead style="background-color:gray;color:black;width:200px;">

                                <tr class="btn-gradient-01">
                                      <th style="width:140px;">Style Name</th>
                                      <th style="width:100px;">PO Number</th>
                                      <th style="width:100px;">Country</th>
                                      <th colspan="100" class="text-center">Week</th>
                                 </tr>
                                 <tr>
                                     <th style="width:140px;"></th>
                                     <th style="width:100px;"></th>
                                     <th style="width:100px;"></th>
                                     <?php
                                         while ($week = mysqli_fetch_assoc($finishingPlanWeekList))
                                         {
                                           $finishingPlanDateList = $selectFinishingPlan->select_all_order_plan_date_with_week_number($week['week']);
                                           $numOfRows =  mysqli_num_rows($finishingPlanDateList);
                                           ?>
                                          <th style="width:80px;" class="text-center" colspan="<?php echo $numOfRows; ?>">
                                            <?php echo "Week-".$week['week']; ?>
                                          </th>
                                       <?php
                                          }
                                          mysqli_free_result($finishingPlanWeekList);
                                      ?>
                                </tr>
                              </thead>
                              <tbody>

                                <?php

                                     $finishingPlanWeekList2 = $selectFinishingPlan->select_all_order_tod_week_list_this_month();
                                     $totalRows = mysqli_num_rows($finishingPlanWeekList);

                                ?>
                                <tr>
                                    <td style="width:140px;"></td>
                                    <td style="width:100px;"></td>
                                    <td style="width:100px;"></td>
                                    <?php
                                        while ($week = mysqli_fetch_assoc($finishingPlanWeekList2))
                                        {
                                            $finishingPlanDateList = $selectFinishingPlan->select_all_order_plan_date_with_week_number($week['week']);
                                            while ($date = mysqli_fetch_assoc($finishingPlanDateList))
                                            {
                                          ?>
                                            <td style="width:80px;color:black;" class="text-center"><?php echo $date['plan_date']; ?></td>
                                      <?php
                                             }
                                           }
                                      ?>
                                      <td style="width:50px;" class="btn-gradient-01 text-center">Total</td>
                                </tr>


                               <?php
                                    $unit_data_result = $selectFinishingPlan->select_all_order_qtn_child_this_month_tod();
                               ?>

                               <?php
                                  while ($unit_data = mysqli_fetch_assoc($unit_data_result))
                                  {
                                    $finishingPlanWeekList3 = $selectFinishingPlan->select_all_order_tod_week_list_this_month();
                                    $total = 0;
                                ?>

                               <tr>
                                   <td style="width:140px;color:black;"><?php echo $unit_data['style_name']; ?></td>
                                   <td style="width:100px;color:black;"><?php echo $unit_data['po_number']; ?></td>
                                   <td style="width:100px;color:black;"><?php echo $unit_data['country_name']; ?></td>

                                   <?php
                                       while ($week = mysqli_fetch_assoc($finishingPlanWeekList3))
                                       {
                                           $weekNumber = $week['week'];
                                           $finishingPlanDateList2 = $selectFinishingPlan->select_all_order_plan_date_with_week_number($week['week']);
                                           while ($date = mysqli_fetch_assoc($finishingPlanDateList2))
                                           {
                                            $finishingPlanQuantity = $selectFinishingPlan->select_all_finishing_plan_quantity_with_date_country_week_style_po(
                                                                                                                            $date['plan_date'],
                                                                                                                            $unit_data['country_id'],
                                                                                                                            $weekNumber,
                                                                                                                            $unit_data['order_style_id'],
                                                                                                                            $unit_data['order_po_id']
                                                                                                                          );


                                            $quantityResult = mysqli_fetch_assoc($finishingPlanQuantity);
                                         ?>
                                           <td style="width:80px;color:black;" class="text-center"><?php
                                                                                                   echo $quantityResult['quantity'];
                                                                                                   $quantityTotal = $quantityResult['quantity'];
                                                                                                   ?></td>
                                     <?php
                                             $total += $quantityTotal;
                                            }
                                      ?>


                                    <?php
                                          }
                                     ?>


                                  <td style="width:50px;color:black;" class="text-center"><?php echo $total; ?></td>

                               </tr>

                            <?php } ?>


                              </tbody>


                          </table>
                          <br>

                      </div>
                  </div>
              </div>
