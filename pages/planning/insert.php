<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/item/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/planning/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/supplier/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/cut_number/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/shade/select.php'; ?>
<?php require_once '../../DB/section/select.php'; ?>
<?php require_once '../../DB/planning/insert.php'; ?>
<?php require_once '../../DB/shipment/select.php'; ?>

<?php
// echo '<pre>';
// print_r($curr_date);
// echo '</pre>';
// exit();
?>
<style>

    @media print {
        #printbtn {
            display :  none;
        }
        #reloadButton {
            display :  none;
        }
        #footer{
            display :  none;
        }
        #search{
            display :  none;
        }
        a[href]:after {
            content: none !important;
        }
    }

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

.sticky {
  display: block!important;
}
.sticky2 {
  display: block!important;
}

#itemName {
  z-index: 1000;
}
#headerName {
  position: absolute;
}
#headerName {
  z-index: 900;
}
#myDIV {
  z-index: 0;
}

.sticky {
  display: block!important;
}
#myDIV,
#itemName {
  position: absolute;
  top: 80;
}
#itemName {
  z-index: 1000;
}
#myDIV {
  z-index: 0;
}
</style>

<?php
$month = date('m');
$year = date('Y');
//$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
?>

<?php

$user_id = $_SESSION['id'];

if (isset($_POST['btn'])) {
    $count = $_POST['count'];
    $planning = new insert();

    for ($i = 1; $i <= $count; $i++) {
        $mgs = $planning->save(
                   $_POST['buyer_'.$i],
                   $_POST['style_id_'.$i],
                   $_POST['projected_qty_'.$i],
                   $_POST['po_id_'.$i],
                   $_POST['color_'.$i],
                   $_POST['dely_date_'.$i],
                   $_POST['order_qty_'.$i],
                   $_POST['cutting_plan_qty_'.$i],
                   $_POST['cutting_plan_'.$i],
                   $_POST['today_cut_pro_qty_'.$i],
                   $_POST['total_cut_pro_qty_'.$i],
                   $_POST['cutting_balance_'.$i],
                   $_POST['cutting_'.$i],
                   $_POST['cutting_status_'.$i],
                   $_POST['today_iissue_'.$i],
                   $_POST['total_iissue_'.$i],
                   $_POST['input_balance_'.$i],
                   $_POST['input_status_'.$i],
                   $_POST['today_soutput_'.$i],
                   $_POST['total_soutput_'.$i],
                   $_POST['sewing_rejection_qty_'.$i],
                   $_POST['wip_in_line_'.$i],
                   $_POST['today_wsend_'.$i],
                   $_POST['total_wsend_'.$i],
                   $_POST['wsend_balance_'.$i],
                   $_POST['w_rejection_'.$i],
                   $_POST['wip_at_wash_'.$i],
                   $_POST['today_fin_in_'.$i],
                   $_POST['total_fin_in_'.$i],
                   $_POST['today_fin_out_'.$i],
                   $_POST['total_fin_out_'.$i],
                   $_POST['fin_out_perc_'.$i],
                   $_POST['fin_rejection_qty_'.$i],
                   $_POST['wip_at_finish_'.$i],
                   $_POST['tot_fin_rejection_qty_'.$i],
                   $_POST['today_ship_'.$i],
                   $_POST['total_ship_'.$i],
                   $_POST['bal_to_ship_'.$i],
                   $_POST['order_to_ship_'.$i],
                   $_POST['cut_to_ship_'.$i],
                   $_POST['remarks_'.$i]
                   // $_POST['country_'.$i],
                   // $_POST['inspection_qty_'.$i],
                   // $_POST['skip_'.$i],
                   // $_POST['initial_pass_'.$i],
                   // $_POST['initial_fail_'.$i],
                   // $_POST['inline_pass_'.$i],
                   // $_POST['inline_fail_'.$i],
                   // $_POST['final_pass_'.$i],
                   // $_POST['final_fail_'.$i],
                   // $_POST['critical_fault_'.$i],
                   // $_POST['major_fault_'.$i],
                   // $_POST['defect_qty_'.$i],
                   // $_POST['defect_detail_'.$i],
                   // $_POST['remarks_'.$i],
                   // $_POST['ins_by_'.$i]
          );
    }

    // $mgs = $nqc_rqc->save_total_qty(
    //          $month,
    //          $year,
    //          $_POST['t_initial_pass'],
    //          $_POST['t_initial_fail'],
    //          $_POST['t_inline_pass'],
    //          $_POST['t_inline_fail'],
    //          $_POST['t_final_pass'],
    //          $_POST['t_final_fail'],
    //          $_POST['t_skip']
    // );
}

 $style_select_option     = '<option value="">Select Style</option>';
 $po_select_option        = '<option value="">Select PO Number</option>';

//
$selectPO = new select_po();
$po_list =  $selectPO->select_all();
//
$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectPlanning = new select_planning();
//$item_list =  $selectItem->select_all();

// foreach ($style_list as $row)
//     {
//       $style_select_option .= '<option value="'.$row['id'].'">'.$row['style_name'].'</option>';
//     }

foreach ($po_list as $row)
    {
      $po_select_option .= '<option value="'.$row['id'].'">'.$row['po_num'].'</option>';
    }
//


//--------------------------------------------  close select option ------------------------------------


?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>Planning</label>
                </span>

            </div>


            <!-- The Modal -->
          <div id="item_modal" class="modal">

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
                                  <input type="text" class="form-control" id="item_name_input" placeholder ="Enter Item Name" required="required">
                              </div>

                          </div>
                          <label class="form-control-label" id="item_output" style="color:red;"></label>

              </div>

          </div>


          <div class="text-center" style="padding-bottom: 10px;">
          <button id="add_item_data" class="btn btn-gradient-03" type="submit">Save</button>
          <button id="close_i_btn" class="btn btn-gradient-05" onclick="addNewRow(),addItem()" type="submit">Close</button>
          </div>

          </div>                        <!-- End Row -->

            </div>

          </div>



            <div class=" w3-card-4">


          <form method="post" enctype="multipart/form-data" action="" name="form1">
            <div id="form_1" class="box-body  w3-animate-right" style="padding:10px;overflow-x:scroll;height:500px;" onscroll="myFunction()">

              <input type="hidden" name="trinhouse_id"  id="trinhouse_id" value="<?php echo $trinhouse_id; ?>"></input>


              <div border="1" style="margin:10px 0px;">

                <select class="form-control col-md-6" name="type_select" id="type_select" >
                <option>Select Type</option>
                <option value="0">Recieve</option>
                <option value="1">Inhouse</option>
                </select>

              </div>


            <div class="form-group" id="itemName" style="display:none;">
              <table class="w3-table-all w3-small" border="1" style="width:186px;">
                <tr class="btn-gradient-01" style="height:44px">
                  <td style="color:white;">SL</td>
                  <th class="text-center">Item Name</th>
                </tr>
                <?php
                 $i = 1;
                // foreach ($trinhouse_details_info as $trinhouse_details){
                  ?>
                <tr style="color:black;">
                  <td class="text-center" style="width:67px">
                    <?php echo $i++;?>
                  </td>
                  <td class="text-center">

                    <select style="width:100px;height: 22px" id="item_name_<?php echo $i;?>">
                    <option>Select Item Name </option>

                    </select>
                  </td>
                </tr>
              <?php ?>
              </table>
            </div>

            <div class="form-group" style="height:500px;" id="myDIV">
              <div class="w3-table-all w3-small" id="add_row">
                <table class="w3-table-all w3-small" border="1">
                  <thead>
                    <!-- <tr class="btn-gradient-01">
                      <td class="text-center" colspan="7">Order Information</td>
                      <td class="text-center" colspan="7">Cutting Status</td>
                      <td class="text-center" colspan="4">Input Status</td>
                      <td class="text-center" colspan="4">Sewing Status</td>
                      <td class="text-center" colspan="7">Washing Status</td>
                      <td class="text-center" colspan="6">Finishing Status</td>
                      <td class="text-center" colspan="6">Shipment Status</td>
                    </tr> -->
                    <!-- <tr class="btn-gradient-01">
                      <td class="text-center">Buyer</td>
                      <td class="text-center">Style</td>
                      <td class="text-center">Projected Qty</td>
                      <td class="text-center">PO</th>
                      <td class="text-center">Dely Date</td>
                      <td class="text-center">Cutting Status</td>
                      <td class="text-center">Sewing Rejection Qty</td>
                      <td class="text-center">Remarks</td>
                    </tr> -->

                    <tr class="btn-gradient-01">
                      <td class="text-center" colspan="7">Order Information</td>
                      <td class="text-center" colspan="7">Cutting Status</td>
                      <td class="text-center" colspan="4">Input Status</td>
                      <td class="text-center" colspan="4">Sewing Status</td>
                      <td class="text-center" colspan="7">Washing Status</td>
                      <td class="text-center" colspan="6">Finishing Status</td>
                      <td class="text-center" colspan="6">Shipment Status</td>
                    </tr>
                    <tr class="btn-gradient-01">
                      <td class="text-center">Buyer</td>
                      <td class="text-center">Style</td>
                      <td class="text-center">Projected Qty</td>
                      <td class="text-center">PO</th>
                      <td class="text-center">Color</td>
                      <td class="text-center">Dely Date</td>
                      <td class="text-center">Ord Qty</td>
                      <td class="text-center">Cutting Plan Qty</td>
                      <td class="text-center">Cut Plan %</td>
                      <td class="text-center">Today Cutting Production</td>
                      <td class="text-center">Total Cutting</td>
                      <td class="text-center">Bal to Cut</td>
                      <td class="text-center">Cutting %</td>
                      <td class="text-center">Cutting Status</td>
                      <td class="text-center">Today Input</td>
                      <td class="text-center">Total Input</td>
                      <td class="text-center">Bal to Input</td>
                      <td class="text-center">Input Status</td>
                      <td class="text-center">Today Output</td>
                      <td class="text-center">Total Output</td>
                      <td class="text-center">Sewing Rejection Qty</td>
                      <td class="text-center">Wip in Line</td>
                      <td class="text-center">Today Send Wash</td>
                      <td class="text-center">Total Send to Wash</td>
                      <td class="text-center">Bal to send wash</td>
                      <td class="text-center">Wash Rejection/Missing</td>
                      <td class="text-center">Wip at Wash</td>
                      <td class="text-center">Finishing Input</td>
                      <td class="text-center">Total Finishing Input</td>
                      <td class="text-center">Today Finishing Output</td>
                      <td class="text-center">Total Finishing Output</td>
                      <td class="text-center">Finishing Output %</td>
                      <td class="text-center">Finishing Rejection Qty</td>
                      <td class="text-center">Wip at Finish</td>
                      <td class="text-center">Total Finishing Rejection Qty</td>
                      <td class="text-center">Today Ship</td>
                      <td class="text-center">Total Ship Qty</td>
                      <td class="text-center">Bal to Ship</td>
                      <td class="text-center">Ord to Ship</td>
                      <td class="text-center">Cut to Ship</td>
                      <td class="text-center">Remarks</td>
                    </tr>

                  </thead>

                  <tbody id="add_row_table">
                  <?php
                  $i = 1;
                   foreach ($style_list as $style_info){
                     if($i>=5){
                       continue;
                     }
                     $order_info_by_style = $selectPlanning->select_po_by_style($style_info['id']);
                     foreach ($order_info_by_style as $order_info) {
                    ?>

                    <tr style="color:black;">

                    <td class="text-center">
                      <?php echo $order_info['buyer_name'];?>
                      <input type="hidden" name="buyer_<?php echo $i;?>" id="buyer_<?php echo $i?>" value="<?php echo $order_info['buyer']?>">
                    </td>

                    <td class="text-center">
                      <?php echo $style_info['style_name']; ?>
                      <input type="hidden" name="style_id_<?php echo $i;?>" id="style_id_<?php echo $i?>" value="<?php echo $style_info['id']?>">
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="text" name="projected_qty_<?php echo $i;?>" id="ttl_tod_<?php echo $i?>">
                    </td>

                     <td class="text-center">
                       <input type="hidden" name="po_id_<?php echo $i;?>" id="po_id_<?php echo $i?>" value="<?php echo $order_info['po'];?>">
                       <?php echo $order_info['po_number'];?>
                     </td>

                     <td class="text-center">
                       <?php echo $order_info['color_name'];?>
                       <input type="hidden" name="color_<?php echo $i;?>" id="color_<?php echo $i?>" value="<?php echo $order_info['color']?>">
                     </td>
                     <td class="text-center">
                       <input style="width:135px;" type="date" name="dely_date_<?php echo $i;?>" id="date_<?php echo $i;?>" value="" >
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="order_qty_<?php echo $i;?>" id="order_qty_<?php echo $i;?>" value="<?php echo $order_info['total_quantity']?>" readonly>
                     </td>
                     <td class="text-center">
                       <?php
                       $totalCuttingQuantity = 0;
                       $ob = new select_order();
                       $countryList = $ob->select_oder_country_with_id($order_info['id']);
                       $x=0;
                       while ($country = mysqli_fetch_assoc($countryList)) {
                             $x++;
                             $orderSumQuantity = $ob->select_quantity_sum_order_and_country($order_info['id'],$country['country_id']);

                             while ($orderQuantity = mysqli_fetch_assoc($orderSumQuantity)){
                                  $quantity = ceil((($orderQuantity['quantity']*4)/100)+$orderQuantity['quantity']);
                                  $totalCuttingQuantity += $quantity;
                             };
                         ?>

                         <?php
                       } ?>
                        <input style="width:90px;" type="number" step="0.01" name="cutting_plan_qty_<?php echo $i;?>" id="cutting_plan_qty_<?php echo $i;?>" value="<?php echo $totalCuttingQuantity;?>" readonly>
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="cutting_plan_<?php echo $i;?>" id="cutting_plan_<?php echo $i;?>" value="<?php $cutting_plan = $order_info['cutting_plan']." %"; echo $cutting_plan;?>" readonly>
                     </td>

                     <?php
                     $today_cut_pro_by_style_po = $selectPlanning->select_today_cut_pro_by_style_po($style_info['id'],$order_info['po']);
                     $today_cut_pro_qty = 0;
                     foreach ($today_cut_pro_by_style_po as $today_cut_pro__info) {
                       $today_cut_pro_qty += $today_cut_pro__info['cutting_production'];
                     }
                     $cut_pro_by_style_po = $selectPlanning->select_cut_pro_by_style_po($style_info['id'],$order_info['po']);
                     $total_cut_pro_qty = 0;
                     foreach ($cut_pro_by_style_po as $cut_pro_by_style_po_info) {
                       $total_cut_pro_qty += $cut_pro_by_style_po_info['cutting_production'];
                     }
                     ?>

                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="today_cut_pro_qty_<?php echo $i;?>" id="today_cut_pro_qty_<?php echo $i;?>" value="<?php echo $today_cut_pro_qty;?>" >
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="total_cut_pro_qty_<?php echo $i;?>" id="total_cut_pro_qty_<?php echo $i;?>" value="<?php echo $total_cut_pro_qty;?>" >
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="cutting_balance_<?php echo $i;?>" id="cutting_balance_<?php echo $i;?>" value="<?php echo ($totalCuttingQuantity-$total_cut_pro_qty);?>" >
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="cutting_<?php echo $i;?>" id="cutting_<?php echo $i;?>" value="<?php echo intval(($total_cut_pro_qty/$order_info['total_quantity'])*100)." %";?>" >
                     </td>
                     <td class="text-center">
                       <?php
                        $month = date('m');
                        $day = date('d');
                        $year = date('Y');

                        $today = $year . '-' . $month . '-' . $day;
                        ?>
                        <input style="width:135px;" type="date" name="cutting_status_<?php echo $i;?>" id="cutting_status_<?php echo $i;?>" value="<?php echo $today; ?>" >
                     </td>
                     <?php
                     $obs = new select_shipment();
                     $today_iissue_scan_qty = $obs->select_today_iissue_scan_qty($order_info['po']);
                     $today_iissue_scan_quantity = 0;
                     while ($today_iissue_scan_qty_info = mysqli_fetch_assoc($today_iissue_scan_qty)) {
                       $today_iissue_scan_quantity += $today_iissue_scan_qty_info['total_scan_quantity'];
                     }
                     $iissue_scan_qty = $obs->select_iissue_scan_qty2($order_info['po']);
                     $total_iissue_scan_quantity = 0;
                     while ($iissue_scan_qty_info2 = mysqli_fetch_assoc($iissue_scan_qty)) {
                       $total_iissue_scan_quantity += $iissue_scan_qty_info2['total_scan_quantity'];
                     }
                     ?>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="today_iissue_<?php echo $i;?>" id="today_iissue_<?php echo $i;?>" value="<?php echo $today_iissue_scan_quantity; ?>" >
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="total_iissue_<?php echo $i;?>" id="total_iissue_<?php echo $i;?>" value="<?php echo $total_iissue_scan_quantity; ?>" >
                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="input_balance_<?php echo $i;?>" id="input_balance_<?php echo $i;?>" value="<?php echo ($total_cut_pro_qty-$total_iissue_scan_quantity); ?>" >
                     </td>
                     <td class="text-center">
                       <?php
                        $month = date('m');
                        $day = date('d');
                        $year = date('Y');

                        $today = $year . '-' . $month . '-' . $day;
                        ?>
                        <input style="width:135px;" type="date" name="input_status_<?php echo $i;?>" id="input_status_<?php echo $i;?>" value="<?php echo $today; ?>" >
                     </td>

                     <?php
                     $cut_pro_id = $obs->select_all_cut_pro_id($order_info['po']);
                     $today_s_output_scan = 0;
                     $today_w_send_scan = 0;
                     $today_fin_in_scan = 0;
                     $today_fin_out_scan = 0;
                     $today_ship_scan = 0;
                     foreach ($cut_pro_id as $cut_pro_id_info) {
                       $today_s_output = $obs->select_today_s_output($cut_pro_id_info['cut_pro_id']);
                       while ($today_s_output_info = mysqli_fetch_assoc($today_s_output)) {
                         $today_s_output_scan++;
                       }
                       $w_send_scan_qty = $obs->select_today_w_send($cut_pro_id_info['cut_pro_id']);
                       while ($w_send_scan_qty_info = mysqli_fetch_assoc($w_send_scan_qty)) {
                         $today_w_send_scan++;
                       }
                       $fin_in_scan_qty = $obs->select_today_fin_in($cut_pro_id_info['cut_pro_id']);
                       while ($fin_in_scan_qty_info = mysqli_fetch_assoc($fin_in_scan_qty)) {
                         $today_fin_in_scan++;
                       }
                       $fin_out_scan_qty = $obs->select_today_fin_out($cut_pro_id_info['cut_pro_id']);
                       while ($fin_out_scan_qty_info = mysqli_fetch_assoc($fin_out_scan_qty)) {
                         $today_fin_out_scan++;
                       }
                       $today_ship_scan_qty = $obs->select_today_ship_scan($cut_pro_id_info['cut_pro_id']);
                       while ($today_ship_scan_qty_info = mysqli_fetch_assoc($today_ship_scan_qty)) {
                         $today_ship_scan++;
                       }
                     }

                     $total_s_output_scan = 0;
                     $total_w_send_scan = 0;
                     $total_fin_in_scan = 0;
                     $total_fin_scan = 0;
                     $total_ship_scan = 0;
                     foreach ($cut_pro_id as $cut_pro_id_info) {
                       $s_output_scan_qty = $obs->select_s_output_scan_qty($cut_pro_id_info['cut_pro_id']);
                       while ($s_output_scan_qty_info = mysqli_fetch_assoc($s_output_scan_qty)) {
                         $total_s_output_scan++;
                       }
                       $w_send_scan_qty = $obs->select_w_send_scan_qty($cut_pro_id_info['cut_pro_id']);
                       while ($w_send_scan_qty_info = mysqli_fetch_assoc($w_send_scan_qty)) {
                         $total_w_send_scan++;
                       }
                       $fin_in_scan_qty = $obs->select_fin_in_scan_qty($cut_pro_id_info['cut_pro_id']);
                       while ($fin_in_scan_qty_info = mysqli_fetch_assoc($fin_in_scan_qty)) {
                         $total_fin_in_scan++;
                       }
                       $fin_scan_qty = $obs->select_fin_scan_qty($cut_pro_id_info['cut_pro_id']);
                       while ($fin_scan_qty_info = mysqli_fetch_assoc($fin_scan_qty)) {
                         $total_fin_scan++;
                       }
                       $ship_scan_qty = $obs->select_ship_scan_qty($cut_pro_id_info['cut_pro_id']);
                       while ($ship_scan_qty_info = mysqli_fetch_assoc($ship_scan_qty)) {
                         $total_ship_scan++;
                       }
                     }
                     ?>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="today_soutput_<?php echo $i;?>" id="today_soutput_<?php echo $i;?>" value="<?php echo $today_s_output_scan; ?>" >
                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="total_soutput_<?php echo $i;?>" id="total_soutput_<?php echo $i;?>" value="<?php echo $total_s_output_scan; ?>" >
                     </td>
                    <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="sewing_rejection_qty_<?php echo $i;?>" id="sewing_rejection_qty_<?php echo $i;?>" onkeyup="wipInLine(this.value,<?php echo $i;?>)" >
                    </td>
                    <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="wip_in_line_<?php echo $i;?>" id="wip_in_line_<?php echo $i;?>" >
                    </td>

                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="today_wsend_<?php echo $i;?>" id="today_wsend_<?php echo $i;?>" value="<?php echo $today_w_send_scan; ?>" >
                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="total_wsend_<?php echo $i;?>" id="total_wsend_<?php echo $i;?>" value="<?php echo $total_w_send_scan; ?>" >
                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="wsend_balance_<?php echo $i;?>" id="wsend_balance_<?php echo $i;?>" value="<?php echo ($total_s_output_scan - $total_w_send_scan); ?>" >
                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="w_rejection_<?php echo $i;?>" id="w_rejection_<?php echo $i;?>" onkeyup="wipAtWash(this.value,<?php echo $i;?>)" >
                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="wip_at_wash_<?php echo $i;?>" id="wip_at_wash_<?php echo $i;?>" >
                     </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="today_fin_in_<?php echo $i;?>" id="today_fin_in_<?php echo $i;?>" value="<?php echo $today_fin_in_scan; ?>" >
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="total_fin_in_<?php echo $i;?>" id="total_fin_in_<?php echo $i;?>" value="<?php echo $total_fin_in_scan; ?>" >
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="today_fin_out_<?php echo $i;?>" id="today_fin_out_<?php echo $i;?>" value="<?php echo $today_fin_out_scan; ?>" >
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="total_fin_out_<?php echo $i;?>" id="total_fin_out_<?php echo $i;?>" value="<?php echo $total_fin_scan; ?>" >
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="fin_out_perc_<?php echo $i;?>" id="fin_out_perc_<?php echo $i;?>" value="<?php echo ($total_fin_scan/$order_info['total_quantity'])*100; ?>" >
                    </td>
                    <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="fin_rejection_qty_<?php echo $i;?>" id="fin_rejection_qty_<?php echo $i;?>" onkeyup="wipAtFinish(this.value,<?php echo $i;?>)" >
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="text" name="wip_at_finish_<?php echo $i;?>" id="wip_at_finish_<?php echo $i?>">
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="text" name="tot_fin_rejection_qty_<?php echo $i;?>" id="tot_fin_rejection_qty_<?php echo $i?>">
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="today_ship_<?php echo $i;?>" id="today_ship_<?php echo $i;?>" value="<?php echo $today_ship_scan; ?>" >
                    </td>
                    <td class="text-center">
                      <input style="width:90px;" type="number" step="0.01" name="total_ship_<?php echo $i;?>" id="total_ship_<?php echo $i;?>" value="<?php echo $total_ship_scan; ?>" >
                    </td>
                    <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="bal_to_ship_<?php echo $i;?>" id="bal_to_ship_<?php echo $i;?>" value="<?php echo ($order_info['total_quantity']-$total_ship_scan); ?>" >
                    </td>
                    <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="order_to_ship_<?php echo $i;?>" id="order_to_ship_<?php echo $i;?>" value="<?php echo ($total_ship_scan/$order_info['total_quantity']); ?>" >
                    </td>
                    <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="cut_to_ship_<?php echo $i;?>" id="cut_to_ship_<?php echo $i;?>" value="<?php echo ($total_ship_scan/$total_cut_pro_qty); ?>" >
                    </td>




                     <td class="text-center">
                        <input style="width:90px;" type="text" name="remarks_<?php echo $i;?>" id="remarks_<?php echo $i?>">
                     </td>

                  </tr>


                  <?php $i++; } } ?>
                  </tbody>
                  <!-- <tfoot>
                    <tr>
                      <td>Total</td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_skip" id="t_skip" value="" >
                      </td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_initial_pass" id="t_initial_pass" value="" >
                      </td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_initial_fail" id="t_initial_fail" value="" >
                      </td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_inline_pass" id="t_inline_pass" value="" >
                      </td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_inline_fail" id="t_inline_fail" value="" >
                      </td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_final_pass" id="t_final_pass" value="" >
                      </td>
                      <td>
                        <input style="width:90px;" type="number" step="0.01" name="t_final_fail" id="t_final_fail" value="" >
                      </td>
                      <td colspan="6"></td>
                    </tr>
                  </tfoot> -->
                </table>
              </div>
              <input type="hidden" value="<?php echo ($i-1);?>" id="count" name="count" >

              </div>

       </div>

       <p id="demo">as</p>
       <div class="text-center" style="padding-bottom: 10px;">
          <button name="btn" type="submit" class="btn btn-danger center-block">Submit</button>
          <button id="add_row" class="btn w3-pink center-block" name="add_row" onclick="addNewRow()" type="button">New Row</button>
          <button id="add_item" type="button" class="btn btn-danger center-block">+</button>
       </div>
    </form>


</div>
</div>
</div>
</div>

<script>
//country modal

function wipInLine(value,count){
  var total_input = document.getElementById("total_iissue_"+count).value;
  var total_soutput = document.getElementById("total_soutput_"+count).value;
  var wipInLine = total_input - total_soutput - value;
  document.getElementById("wip_in_line_"+count).value = wipInLine;
}

function wipAtWash(value,count){
  var total_input = document.getElementById("total_iissue_"+count).value;
  var total_soutput = document.getElementById("total_soutput_"+count).value;
  var wipInLine = total_input - total_soutput - value;
  document.getElementById("wip_in_line_"+count).value = wipInLine;
}

function wipAtFinish(value,count){
  var total_fin_in = document.getElementById("total_fin_in_"+count).value;
  var total_fin_out = document.getElementById("total_fin_out_"+count).value;
  var wipAtFinish = total_fin_in - total_fin_out - value;
  document.getElementById("wip_at_finish_"+count).value = wipAtFinish;
}

document.getElementById("add_item").onclick = function() {
   document.getElementById('item_modal').style.display = "block";
}
 document.getElementById("add_item_data").onclick = function() {
   var item_name = document.getElementById("item_name_input").value;
   $.post("ajax/add_maintenance_item.php?item_name="+item_name, function(data, status){
            console.log(data);
            document.getElementById("item_output").innerHTML = data;
            document.getElementById("item_name_input").value = "";
         });
 }

 function addItem() {
    document.getElementById('item_modal').style.display = "none";

    var count = document.getElementById("count").value;
    var selectCountry = '';
          $.post("ajax/select_last_item.php", function(data, status){
            var data =  JSON.parse(data);
            //console.log(data['id']);
            document.getElementById("item_name_"+count).value = data['id'];
            document.getElementById("item_"+count).value = data['name'];

          });
 }

function totalSkip(){
  //alert(count);
  var skip=0;
  var totalSkip=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    skip = parseFloat(document.getElementById('skip_'+i).value);
    if(skip){
      totalSkip += skip;
    }
  }
  //alert(totalSkip);
  document.getElementById('t_skip').value = totalSkip;
}

function totalInitialPass(){
  //alert(count);
  var initialPass=0;
  var totalInitialPass=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    initialPass = parseFloat(document.getElementById('initial_pass_'+i).value);
    if(initialPass){
      totalInitialPass += initialPass;
    }
  }
  document.getElementById('t_initial_pass').value = totalInitialPass;
}

function totalInitialFail(){
  //alert(count);
  var initialFail=0;
  var totalInitialFail=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    initialFail = parseFloat(document.getElementById('initial_fail_'+i).value);
    if(initialFail){
      totalInitialFail += initialFail;
    }
  }
  document.getElementById('t_initial_fail').value = totalInitialFail;
}

function totalInlinePass(){
  //alert(count);
  var inlinePass=0;
  var totalInlinePass=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    inlinePass = parseFloat(document.getElementById('inline_pass_'+i).value);
    if(inlinePass){
      totalInlinePass += inlinePass;
    }
  }
  document.getElementById('t_inline_pass').value = totalInlinePass;
}

function totalInlineFail(){
  //alert(count);
  var inlineFail=0;
  var totalInlineFail=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    inlineFail = parseFloat(document.getElementById('inline_fail_'+i).value);
    if(inlineFail){
      totalInlineFail += inlineFail;
    }
  }
  document.getElementById('t_inline_fail').value = totalInlineFail;
}

function totalFinalPass(){
  //alert(count);
  var finalPass=0;
  var totalFinalPass=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    finalPass = parseFloat(document.getElementById('final_pass_'+i).value);
    if(finalPass){
      totalFinalPass += finalPass;
    }
  }
  document.getElementById('t_final_pass').value = totalFinalPass;
}

function totalFinalFail(){
  //alert(count);
  var finalFail=0;
  var totalFinalFail=0;
  var count = parseFloat(document.getElementById('count').value);
  for(var i=1; i<=count; i++){
    finalFail = parseFloat(document.getElementById('final_fail_'+i).value);
    if(finalFail){
      totalFinalFail += finalFail;
    }
  }
  document.getElementById('t_final_fail').value = totalFinalFail;
}

function totalStock(value,count){
  //alert(count);
  var prev_stock = parseFloat(document.getElementById('prev_stock_'+count).value);
  var tot_received = parseFloat(document.getElementById('tot_received_'+count).value);
  if(prev_stock){
    var tot_stock_qty = prev_stock + tot_received;
  }
  document.getElementById('tot_stock_qty_'+count).value = tot_stock_qty;
}

function totalDailyIssue(value,count){
  var x = document.getElementsByClassName('daily_issue_qty_'+count);
  var i;
  var day_issue = 0;
  for (i = 0; i < x.length; i++) {
    if(x[i].value){
      day_issue += parseFloat(x[i].value);
    }
  }
  document.getElementById('day_issue_'+count).value = day_issue;
}

function totalIssue(value,count){
  var day_issue = parseFloat(document.getElementById('day_issue_'+count).value);
  var prev_issue = parseFloat(value);
  if(prev_issue){
    var tot_issue = day_issue + prev_issue;
  }
  document.getElementById('tot_issue_'+count).value = tot_issue;
}

function totalBalance(count){
  var tot_stock_qty = parseFloat(document.getElementById('tot_stock_qty_'+count).value);
  var tot_issue = parseFloat(document.getElementById('tot_issue_'+count).value);
  if(tot_issue){
    var tot_balance = tot_stock_qty - tot_issue;
  }
  document.getElementById('tot_balance_'+count).value = tot_balance;
}

function totalPrice(count){
  var tot_balance = parseFloat(document.getElementById('tot_balance_'+count).value);
  var unit_price = parseFloat(document.getElementById('unit_price_'+count).value);
  if(tot_balance){
    var tot_price = tot_balance * unit_price;
  }
  document.getElementById('tot_price_'+count).value = tot_price;
}




function addNewRow(){
  var count = document.getElementById('count').value;
              count++;
              document.getElementById('count').value = count;

  rowItem = '<tr>'
             +'<td style="color:black;">'
             +'<input style="width:90px;" type="date" name="date_'+count+'" id="date_'+count+'">'
             +'</td>'
              +'<td>'
              +'<select style="width:100px;" id="style_select_'+count+'" name="style_select_'+count+'" >'
              +'<?php echo $style_select_option; ?>'
              +'</select>'
              +'</td>'
               +'<td>'
               +'<select style="width:100px;" id="po_select_'+count+'" name="po_select_'+count+'" >'
               +'<?php echo $po_select_option; ?>'
               +'</select>'
               +'</td>'
             +'<td>'
             +'<input style="width:90px;" type="text" name="ttl_tod_'+count+'" id="ttl_tod_'+count+'">'
             +'<input type="hidden" name="month_'+count+'" id="month_'+count+'" value="<?php echo $month;?>">'
             +'<input type="hidden" name="year_'+count+'" id="year_'+count+'" value="<?php echo $year;?>">'
             +'</td>'

             +'<td><input style="width:90px;" type="text" name="season_'+count+'" id="season_'+count+'"></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="order_qty_'+count+'" id="order_qty_'+count+'"></td>'


             +'<td>'
             +'<input style="width:90px;" type="number" step="0.01" name="ship_qty_'+count+'" id="ship_qty_'+count+'">'
             +'</td>'

             +'<td>'
             +'<input style="width:90px;" type="text" name="country_'+count+'" id="country_'+count+'" value="" >'
             +'</td>'

             +'<td>'
             +'<input style="width:90px;" type="number" step="0.01" name="inspection_qty_'+count+'" id="inspection_qty_'+count+'" value="" >'
             +'</td>'



             +'<td><input style="width:90px;" type="text" name="skip_'+count+'" id="skip_'+count+'" value="" onkeyup="totalSkip()" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="initial_pass_'+count+'" id="initial_pass_'+count+'" value="" onkeyup="totalInitialPass()" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="initial_fail_'+count+'" id="initial_fail_'+count+'" onkeyup="totalInitialFail()" ></td>'
             +'<td>'
             +'<input style="width:90px;" type="number" step="0.01" name="inline_pass_'+count+'" id="inline_pass_'+count+'" value="" onkeyup="totalInlinePass()" >'
             +'</td>'

             +'<td><input style="width:90px;" type="number" step="0.01" name="inline_fail_'+count+'" id="inline_fail_'+count+'" onkeyup="totalInlineFail()"  ></td>'

             +'<td><input style="width:90px;" type="number" step="0.01" name="final_pass_'+count+'" id="final_pass_'+count+'" value="" onkeyup="totalFinalPass()" ></td>'

             +'<td><input style="width:90px;" type="number" step="0.01" name="final_fail_'+count+'" id="final_fail_'+count+'" value="" onkeyup="totalFinalFail()" ></td>'

             +'<td><input style="width:90px;" type="number" step="0.01" name="critical_fault_'+count+'" id="critical_fault_'+count+'" value="" onkeyup="totalPrice('+count+')" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="major_fault_'+count+'" id="major_fault_'+count+'" value="" onkeyup="totalPrice('+count+')" ></td>'


             +'<td><input style="width:90px;" type="number" step="0.01" name="defect_qty_'+count+'" id="defect_qty_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="text" step="0.01" name="defect_detail_'+count+'" id="defect_detail_'+count+'" value="" onkeyup="totalIssue(this.value,'+count+'),totalBalance('+count+'),totalPrice('+count+')" ></td>'
             +'<td><input style="width:90px;" type="text" step="0.01" name="remarks_'+count+'" id="remarks_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="text" step="0.01" name="ins_by_'+count+'" id="ins_by_'+count+'" value="" ></td>'
             +'</tr>';

  rowItem2 = '<tr>'
             +'<td>'
             +'<select id="item_select_'+count+'" name="item_select_'+count+'" >'
             +'<?php echo $item_select_option; ?>'
             +'</select>'
             +'</td>'
             +'</tr>';

             $('#add_row_table').append(rowItem);






             //
             // rowItem = '<tr>'
             //            +'<td style="color:black;" style="width:60px">'+count+'</td>'
             //            +'<td>'
             //            +'<select id="item_select_'+count+'" name="item_select_'+count+'" style="width:100px" onkeyup="changeFocus1('+count+')"  >'
             //            +'<?php echo $item_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //            +'<td><input type="text" style="width:100px;height:18px;" id="challan_'+count+'" name="challan_'+count+'" onkeyup="changeFocus2('+count+')"  ></td>'
             //            +'<td><input type="date" style="width:135px;height:18px;" id="issue_date_'+count+'" name="issue_date_'+count+'" value="<?php echo date("Y-m-d"); ?>" onkeyup="changeFocus3('+count+')"  ></td>'
             //
             //            +'<td>'
             //            +'<select id="line_select_'+count+'" name="line_select_'+count+'" style="width:100px" onkeyup="changeFocus4('+count+')"  >'
             //            +'<?php echo $line_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td>'
             //            +'<select id="style_select_'+count+'" name="style_select_'+count+'" style="width:100px" onkeyup="changeFocus5('+count+')"  >'
             //            +'<?php echo $style_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td>'
             //            +'<select id="po_select_'+count+'" name="po_select_'+count+'" style="width:100px" onkeyup="changeFocus6('+count+')"  >'
             //            +'<?php echo $po_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td><input type="date" style="width:135px;height:18px;" id="pcd_'+count+'" name="pcd_'+count+'" value="<?php echo date("Y-m-d"); ?>" onkeyup="changeFocus7('+count+')"  ></td>'
             //            +'<td><input type="date" style="width:135px;height:18px;" id="tod_from_'+count+'" name="tod_from_'+count+'" value="<?php echo date("Y-m-d"); ?>" onkeyup="changeFocus8('+count+')"  ></td>'
             //            +'<td><input type="date" style="width:135px;height:18px;" id="tod_to_'+count+'" name="tod_to_'+count+'" value="<?php echo date("Y-m-d"); ?>" onkeyup="changeFocus9('+count+')"  ></td>'
             //            +'<td><input type="text" style="width:100px;height:18px;" id="country_'+count+'" name="country_'+count+'" onkeyup="changeFocus10('+count+')" onkeyup="changeFocus10('+count+')"  ></td>'
             //
             //            +'<td>'
             //            +'<select id="supplier_select_'+count+'" name="supplier_select_'+count+'" style="width:100px" onkeyup="changeFocus11('+count+')" >'
             //            +'<?php echo $supplier_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td>'
             //            +'<select id="color_select_'+count+'" name="color_select_'+count+'" style="width:100px" onkeyup="changeFocus12('+count+')" >'
             //            +'<?php echo $color_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td>'
             //            +'<select id="size_select_'+count+'" name="size_select_'+count+'" style="width:90px" onkeyup="changeFocus13('+count+')" >'
             //            +'<?php echo $size_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td>'
             //            +'<select id="shade_select_'+count+'" name="shade_select_'+count+'" style="width:90px" onkeyup="changeFocus14('+count+')" >'
             //            +'<?php echo $shade_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //
             //            +'<td><input type="text" style="width:90px;height:18px;" id="ref_no_'+count+'" name="ref_no_'+count+'" onkeyup="changeFocus15('+count+')" ></td>'
             //            +'<td><input type="text" style="width:90px;height:18px;" id="unit_type_'+count+'" name="unit_type_'+count+'" onkeyup="changeFocus16('+count+')" ></td>'
             //            +'<td><input type="number" style="width:90px;height:18px;" id="con_'+count+'" name="con_'+count+'" step="0.01" value="'+cons+'" onkeyup="requiredQuantity('+count+'), changeFocus17('+count+')" ></td>'
             //            +'<td><input type="number" style="width:90px;height:18px;" id="order_quantity_'+count+'" name="order_quantity_'+count+'" step="0.01" value="'+order_quantity+'" onkeyup="requiredQuantity('+count+'), changeFocus18('+count+')" ></td>'
             //            +'<td><input type="number" style="width:90px;height:18px;" id="required_quantity_'+count+'" name="required_quantity_'+count+'" step="0.01" readonly ></td>'
             //            +'<td><input type="number" style="width:90px;height:18px;" id="receive_quantity_'+count+'" name="receive_quantity_'+count+'" step="0.01" onkeyup="balanceQuantity('+count+'), changeFocus19('+count+')" ></td>'
             //            +'<td><input type="number" style="width:90px;height:18px;" id="total_issue_quantity_'+count+'" name="total_issue_quantity_'+count+'" step="0.01" onkeyup="balanceQuantity('+count+'),changeFocus20('+count+')" ></td>'
             //            +'<td><input type="number" style="width:90px;height:18px;" id="balance_quantity_'+count+'" name="balance_quantity_'+count+'" step="0.01" onkeyup="changeFocus21('+count+')" ></td>'
             //            +'<td><input type="text" style="width:90px;height:18px;" id="remarks_'+count+'" name="remarks_'+count+'" onkeyup="changeFocus22('+count+')" ></td>'
             //            +'<td><input type="hidden" style="width:90px;height:18px;" value="'+count+'" id="count" name="count" ></td>'
             //            +'</tr>';
             //
             // rowItem2 = '<tr>'
             //            +'<td style="color:black;width:60px">'+count+'</td>'
             //            +'<td>'
             //            +'<select id="item_select_'+count+'" name="item_select_'+count+'" width="100px" readonly>'
             //            +'<?php echo $item_select_option; ?>'
             //            +'</select>'
             //            +'</td>'
             //            +'</tr>';
             //
             //            //$('#add_row_table');
             //            $('#add_row_table').append(rowItem2);
             //            //$('#add_row_table2').append(rowItem2);
}



function totalReceiveQty(count){
   var receive_quantity = 0;
   var d_receive_quantity = parseInt(document.getElementById("d_receive_quantity_"+count).value);
   receive_quantity = parseInt(document.getElementById("prev_receive_quantity_"+count).value);
   if(d_receive_quantity){
     receive_quantity = receive_quantity + d_receive_quantity;
   }
   document.getElementById("receive_quantity_"+count).value = receive_quantity;
}

function totalIssueQty(count){
   var total_issue_quantity = 0;
   var d_issue_quantity = parseInt(document.getElementById("d_issue_quantity_"+count).value);
   total_issue_quantity = parseInt(document.getElementById("prev_total_issue_quantity_"+count).value);
   if(d_issue_quantity){
     total_issue_quantity = total_issue_quantity + d_issue_quantity;
   }
   document.getElementById("total_issue_quantity_"+count).value = total_issue_quantity;
}
//
// function totalIssueQty(count){
//    var d_issue_quantity = parseInt(document.getElementById("d_issue_quantity_"+count).value);
//    var total_issue_quantity = parseInt(document.getElementById("prev_total_issue_quantity_"+count).value);
//    total_issue_quantity += d_issue_quantity;
//    document.getElementById("total_issue_quantity_"+count).value = total_issue_quantity;
// }

function balanceQuantity(count){

  var receive_quantity = parseInt(document.getElementById("receive_quantity_"+count).value);
  var total_issue_quantity = parseInt(document.getElementById("total_issue_quantity_"+count).value);
  if(receive_quantity){
    balance_quantity = receive_quantity;
  }
  if(total_issue_quantity){
    balance_quantity = receive_quantity - total_issue_quantity;
  }
  document.getElementById("balance_quantity_"+count).value = balance_quantity;

}
function requiredQuantity(count){
     var required_quantity = 1;
     //var con = parseInt(document.getElementById("con_1").value);
     var con = document.getElementById("con_"+count).value;
     var actual_quantity = parseInt(document.getElementById("actual_quantity_"+count).value);
     if(con){
       required_quantity *= con;
     }
     if(actual_quantity){
       required_quantity *= actual_quantity;
     }
     //alert(required_quantity);
   document.getElementById("required_quantity_"+count).value = Math.round(required_quantity);
}


function serialSum(value,bundleNo) {

  var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';

  for(var i = 1; i<=totalPcsNumber; i++)
  {
    var previousValue = 0;
    var currentValue = 0;

    try{
    previousValue = parseInt(document.getElementById('serial_to_'+(i-1)).value);
    } catch (err){
      previousValue = 0;
    }

    try{
      currentValue = parseInt(document.getElementById('quantity_'+(i)).value);
    } catch (err){
      currentValue = 0;
    }

    if (isNaN(previousValue)) previousValue = 0;
    if (isNaN(currentValue)) currentValue = 0;

    if(i == 1) previousValue = 0;

    var serialFrom = (parseInt(previousValue)+1);
    var serialTo = (parseInt(previousValue)+parseInt(currentValue));

    document.getElementById('serial_from_'+i).value = serialFrom;
    document.getElementById('serial_to_'+i).value = serialTo;
  }


}




function updateShade(value,number){

   var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';
   var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';

   for(var i = 1; i<=totalPcsNumber; i++)
   {
       if(i%bundleNoPerTicket == number){
            document.getElementById('shade_'+i).value = value;
            var shadeSelect = document.getElementById("shade_"+i);
            document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       }else if(i%bundleNoPerTicket == 0){
         document.getElementById('shade_'+i).value = value;
         var shadeSelect = document.getElementById("shade_"+i);
         document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       }
   }

}



function updateCountry(value,number){

   var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';
   var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';

   for(var i = 1; i<=totalPcsNumber; i++)
   {
       if(i%bundleNoPerTicket == number){
            document.getElementById('country_'+i).value = value;
            var countrySelect = document.getElementById("country_"+i);
            document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
       }else if(i%bundleNoPerTicket == 0){
         document.getElementById('country_'+i).value = value;
         var countrySelect = document.getElementById("country_"+i);
         document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
       }
   }

}



function updateQuantity(value,number){

  var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';
  var totalPcsNumber = '<?php echo $totalPcsNumber; ?>'*bundleNoPerTicket;

  console.log("number : "+number);

  for(var i = 1; i<=totalPcsNumber; i++)
  {
      if(i%bundleNoPerTicket == number){
           document.getElementById('quantity_'+i).value = value;
           serialSum(value,i);
      } else if(i%bundleNoPerTicket == 0){
           document.getElementById('quantity_'+i).value = value;
           serialSum(value,i);
      }
  }

}

function updatePat(value){
  var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';
  var totalPcsNumber = '<?php echo $totalPcsNumber; ?>'*bundleNoPerTicket;
  console.log("Total Pcs : "+totalPcsNumber);

  for(var i = 1; i<=totalPcsNumber; i++)
  {
      document.getElementById('pattern_'+i).value = value;
  }

}

document.forms['form1'].elements['type_select'].value = <?php echo $trinhouse_by_id['type'];?>

function updateStyle(value){
  var myCount = parseInt(document.getElementById("count").value);
  //alert(myCount);
   for(var i = 1; i<=myCount; i++)
   {
      document.getElementById('style_name_'+i).value = value;
   }
}

function updatePO(value){
  var myCount = parseInt(document.getElementById("count").value);

  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('po_number_'+i).value = value;
  }
}

function updatePCD(value){
  //alert(value);
  var myCount = parseInt(document.getElementById("count").value);

  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('pcd_'+i).value = value;
  }
}

function updateTODFrom(value){
  //alert(value);
  var myCount = parseInt(document.getElementById("count").value);

  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('tod_from_'+i).value = value;
  }
}

function updateTODTo(value){
  //alert(value);
  var myCount = parseInt(document.getElementById("count").value);

  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('tod_to_'+i).value = value;
  }
}

function updateColor(value){
  //alert(value);
  var myCount = parseInt(document.getElementById("count").value);
  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('item_color_'+i).value = value;
  }
}

function myFunction() {
  var elmnt = document.getElementById("form_1");
  var itemName = document.getElementById("itemName");
  var x = elmnt.scrollLeft;
  var y = elmnt.scrollTop;
  document.getElementById ("demo").innerHTML = "Horizontally: " + x + "px<br>Vertically: " + y + "px";
  // document.getElementById("itemName").style.left = x;
  // document.getElementById("headerName").style.top = y-5;
  //document.getElementById("itemName").style.color = "blue";
  if (x > 55) {
    itemName.classList.add("sticky");
  } else {
    itemName.classList.remove("sticky");
  }
  if (y > 75) {
    headerName.classList.add("sticky2");
  } else {
    headerName.classList.remove("sticky2");
  }

}


// function myFunction() {
//   var elmnt = document.getElementById("form_2");
//   var itemName = document.getElementById("itemName");
//   var headerName = document.getElementById("headerName");
//   var x = elmnt.scrollLeft;
//   var y = elmnt.scrollTop;
//   document.getElementById ("demo").innerHTML = "Horizontally: " + x + "px<br>Vertically: " + y + "px";
//   document.getElementById("itemName").style.left = x;
//   document.getElementById("headerName").style.top = y-10;
//   if (x > 55) {
//     itemName.classList.add("sticky");
//   } else {
//     itemName.classList.remove("sticky");
//   }
//   if (y > 20) {
//     headerName.classList.add("sticky2");
//   } else {
//     headerName.classList.remove("sticky2");
//   }
// }






function changeFocus1(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             var value = parseInt(index)-1;
             document.getElementById("remarks_"+value).focus();
          break;
       case 39:
             //var value = parseInt(index);
             document.getElementById("challan_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus2(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             //var value = parseInt(index);
             document.getElementById("item_select_"+parseInt(index)).focus();
          break;
       case 39:
             //var value = parseInt(index);
             document.getElementById("issue_date_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus3(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             //var value = parseInt(index);
             document.getElementById("challan_"+parseInt(index)).focus();
          break;
       case 39:
             //var value = parseInt(index);
             document.getElementById("line_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus4(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("issue_date_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("style_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus5(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("line_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("po_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus6(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("style_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("pcd_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus7(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("po_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("tod_from_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus8(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("pcd_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("tod_to_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus9(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("tod_from_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("country_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus10(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("tod_to_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("supplier_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus11(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("country_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("color_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus12(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("supplier_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("size_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus13(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("color_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("shade_select_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus14(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("size_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("ref_no_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus15(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("shade_select_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("unit_type_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus16(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("ref_no_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("con_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus17(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("unit_type_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("order_quantity_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus18(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("con_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("receive_quantity_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus19(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("order_quantity_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("total_issue_quantity_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus20(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("receive_quantity_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("balance_quantity_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus21(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("total_issue_quantity_"+parseInt(index)).focus();
          break;
       case 39:
             document.getElementById("remarks_"+parseInt(index)).focus();
          break;
    }
  };
}
function changeFocus22(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("balance_quantity_"+parseInt(index)).focus();
          break;
       case 39:
             var value = parseInt(index)+1;
             document.getElementById("item_select_"+value).focus();
          break;
    }
  };
}


</script>
