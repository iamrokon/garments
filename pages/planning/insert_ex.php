<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/item/select.php'; ?>
<?php require_once '../../DB/item_maintenance/select.php'; ?>
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
<?php require_once '../../DB/nqc_rqc/insert.php'; ?>

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
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>

<?php

$user_id = $_SESSION['id'];

if (isset($_POST['btn'])) {
    $count = $_POST['count'];
    $nqc_rqc = new insert();

    for ($i = 1; $i <= $count; $i++) {
        $mgs = $nqc_rqc->save(
                   $_POST['date_'.$i],
                   $_POST['style_'.$i],
                   $_POST['po_'.$i],
                   $_POST['ttl_tod_'.$i],
                   $_POST['season_'.$i],
                   $_POST['order_qty_'.$i],
                   $_POST['ship_qty_'.$i],
                   $_POST['country_'.$i],
                   $_POST['inspection_qty_'.$i],
                   $_POST['skip_'.$i],
                   $_POST['initial_pass_'.$i],
                   $_POST['initial_fail_'.$i],
                   $_POST['inline_pass_'.$i],
                   $_POST['inline_fail_'.$i],
                   $_POST['final_pass_'.$i],
                   $_POST['final_fail_'.$i],
                   $_POST['critical_fault_'.$i],
                   $_POST['major_fault_'.$i],
                   $_POST['defect_qty_'.$i],
                   $_POST['defect_detail_'.$i],
                   $_POST['remarks_'.$i],
                   $_POST['ins_by_'.$i]
          );
    }

    $mgs = $nqc_rqc->save_total_qty(
             $month,
             $year,
             $_POST['t_initial_pass'],
             $_POST['t_initial_fail'],
             $_POST['t_inline_pass'],
             $_POST['t_inline_fail'],
             $_POST['t_final_pass'],
             $_POST['t_final_fail'],
             $_POST['t_skip']
    );
}

//
// $selectSize = new select_size();
// $size_list =  $selectSize->select_all();
//
// $selectItem = new select_item();
// $item_list =  $selectItem->select_all();
//  while ($item = mysqli_fetch_assoc($item_list))
//  {
//    $items[] = $item;
//      // echo '<pre>';
//      // print_r($items);
//      // echo  '</pre>';
// }
//
//
//
 $style_select_option     = '<option value="">Select Style</option>';
 $po_select_option        = '<option value="">Select PO Number</option>';
// $line_select_option      = '<option value="">Select Line</option>';
// $item_select_option      = '<option value="">Select Item</option>';
// $supplier_select_option  = '<option value="">Select Supplier</option>';
// $size_select_option      = '<option value="">Select Size</option>';
// $shade_select_option     = '<option value="">Select Shade</option>';
// $color_select_option     = '<option value="">Select Color</option>';
//
//
//
//
//
// $selectLine = new select_line();
// $line_list =  $selectLine->select_all();
//
$selectPO = new select_po();
$po_list =  $selectPO->select_all();
//
$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectItem = new select_item_maintenance();
$item_list =  $selectItem->select_all();
//
// $selectSupplier = new select_supplier();
// $supplier_list =  $selectSupplier->select_all();
//
// $selectBuyer = new select_buyer();
// $buyer_list =  $selectBuyer->select_all();
//
// $selectColor = new select_color();
// $color_list =  $selectColor->select_all();
//
// $selectShade = new select_shade();
// $shade_list =  $selectShade->select_all();
//
// $selectSection = new select_section();
// $section_list =  $selectSection->select_all();
//
// $selectCountry = new select_country();
// $country_list =  $selectCountry->select_all();
//
// $selectCuttingProduction = new select_cproduction();
// $cut_pro_result = $selectCuttingProduction->select_with_id($trinhouse_id);
// $cut_pro_details = mysqli_fetch_assoc($cut_pro_result);
//
// $selectTrimsInhouse = new select_trims_inhouse();
// $trinhouse_info_by_id = $selectTrimsInhouse->select_with_id($trinhouse_id);
// $trinhouse_result = $selectTrimsInhouse->select_child_with_id($trinhouse_id);
// $trinhouse_by_id = mysqli_fetch_assoc($trinhouse_info_by_id);
// $cut_pro_child_list = $selectCuttingProduction->select_child_with_id($trinhouse_id);
// $num_rows = mysqli_num_rows($cut_pro_child_list)/5;
//
// $rows[] = null;
//
// while($row = $cut_pro_child_list->fetch_row()) {
//   $rows[] = $row;
// }


//--------------------------------------------- select option ------------------------------------------

// $select_supplier = new select_supplier();
// $supplier_list_a = $select_supplier->select_all();
//
// while ($row = mysqli_fetch_assoc($supplier_list_a))
//     {
//       $supplier_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
//     }
//
// $select_style = new select_style();
// $style_list = $select_style->select_all();

foreach ($style_list as $row)
    {
      $style_select_option .= '<option value="'.$row['id'].'">'.$row['style_name'].'</option>';
    }
//
// $select_item = new select_item();
// $all_item_list = $select_item->select_all();
//
// while ($row = mysqli_fetch_assoc($all_item_list))
//     {
//       $item_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
//     }
//
//
// $select_po = new select_po();
// $po_list = $select_po->select_all();
//
foreach ($po_list as $row)
    {
      $po_select_option .= '<option value="'.$row['id'].'">'.$row['po_num'].'</option>';
    }
//
//
// $select_line = new select_line();
// $line_list = $select_line->select_all();
//
// while ($row = mysqli_fetch_assoc($line_list))
//       {
//         $line_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
//       }
//
//
// $selectSize = new select_size();
// $size_list =  $selectSize->select_all();
//
// while ($row = mysqli_fetch_assoc($size_list))
//       {
//         $size_select_option .= '<option value="'.$row['id'].'">'.$row['size_num'].'</option>';
//       }
//
//
// $selectShade = new select_shade();
// $shade_list =  $selectShade->select_all();
//
// while ($row = mysqli_fetch_assoc($shade_list))
//       {
//         $shade_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
//       }
//
//
// $selectColor = new select_color();
// $color_list_a =  $selectColor->select_all();
//
// while ($row = mysqli_fetch_assoc($color_list_a))
//       {
//         $color_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
//       }

//--------------------------------------------  close select option ------------------------------------


?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>NQC / RQC</label>
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




            <!-- <div class="form-group" id="headerName" style="display:none" >
              <div class="w3-table-all w3-small" id="add_row3">
                <table class="table table-bordered table-striped table-hover" style="margin-top: 0px;width:3020px">
                  <thead>
                  <tr class="btn-gradient-01">
                    <td style="color:white;" width="66px">SL</td>
                    <td style="color:white;" width="118px">Item Name</td>
                    <td style="color:white;" width="118px">Challan No</td>
                    <td style="color:white;" width="153px">Issue Date</td>
                    <td style="color:white;" width="118px">Line No.</td>
                    <td style="color:white;" width="118px">Style Name</td>
                    <td style="color:white;" width="118px">P.O.</td>
                    <td style="color:white;" width="153px">PCD</td>
                    <td style="color:white;" width="153px">TOD From</td>
                    <td style="color:white;" width="153px">TOD To</td>
                    <td style="color:white;" width="118px">Country Name</td>
                    <td style="color:white;" width="118px">Supplier</td>
                    <td style="color:white;" width="118px">Item Color</td>
                    <td style="color:white;" width="108px">Size</td>
                    <td style="color:white;" width="108px">Shade</td>
                    <td style="color:white;" width="108px">Ref. No.</td>
                    <td style="color:white;" width="108px">Unit Type</td>
                    <td style="color:white;" width="108px">Con</td>
                    <td style="color:white;" width="108px">Actual Qty</td>
                    <td style="color:white;" width="108px">Required Qty</td>
                    <td style="color:white;" width="108px">Daily Recieve Qty</td>
                    <td style="color:white;" width="108px">Total Recieve Qty</td>
                    <td style="color:white;" width="108px">Daily Issue Qty</td>
                    <td style="color:white;" width="108px">Total Issue Qty</td>
                    <td style="color:white;" width="108px">Balance Qty</td>
                    <td style="color:white;" width="108px">Remarks</td>
                  </tr>
                  </thead>


                </table>
              </div>
            </div> -->



              <!-- <div class="row" style="padding:10px;"> -->



            <div class="form-group" style="height:500px;" id="myDIV">
              <div class="w3-table-all w3-small" id="add_row">
                <table class="w3-table-all w3-small" border="1">
                  <thead>
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
                   //foreach ($po_list as $po_info){
                    ?>

                    <tr style="color:black;">


                    <td class="text-center">
                      <input style="width:135px;" type="date" name="date_<?php echo $i;?>" id="date_<?php echo $i;?>" value="" >
                    </td>
                    <td class="text-center">
                       <select style="width:100px;" name="style_<?php echo $i;?>" id="style_<?php echo $i;?>" onchange="updateStyle(this.value)">
                       <option>Select Style </option>
                       <?php
                       foreach ($style_list as $row){
                           if($trinhouse_details['style_name'] == $row['id'])
                           {
                       ?>
                       <option selected value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                       <?php
                           } else{
                        ?>
                           <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                           <?php
                         }
                       }
                       ?>
                       </select>
                     </td>


                     <td class="text-center">
                       <select style="width:100px;" name="po_<?php echo $i;?>" id="po_<?php echo $i;?>" onchange="updatePO(this.value)">
                       <option>Select PO Number </option>
                       <?php
                       foreach ($po_list as $row){
                         if($trinhouse_details['po_number'] == $row['id'])
                            {
                       ?>
                       <option selected value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                       <?php
                            } else{
                        ?>
                               <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                           <?php
                         }
                       }
                       ?>
                       </select>
                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="text" name="ttl_tod_<?php echo $i;?>" id="ttl_tod_<?php echo $i?>">

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="text" name="season_<?php echo $i;?>" id="season_<?php echo $i?>">

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="order_qty_<?php echo $i;?>" id="order_qty_<?php echo $i;?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="ship_qty_<?php echo $i;?>" id="ship_qty_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="country_<?php echo $i;?>" id="country_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="inspection_qty_<?php echo $i;?>" id="inspection_qty_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="skip_<?php echo $i;?>" id="skip_<?php echo $i;?>" onkeyup="totalSkip()" value="" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="initial_pass_<?php echo $i;?>" id="initial_pass_<?php echo $i;?>" onkeyup="totalInitialPass()" value="" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="initial_fail_<?php echo $i;?>" id="initial_fail_<?php echo $i;?>" onkeyup="totalInitialFail()" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="inline_pass_<?php echo $i;?>" id="inline_pass_<?php echo $i;?>" value="" onkeyup="totalInlinePass()"  >

                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="inline_fail_<?php echo $i;?>" id="inline_fail_<?php echo $i;?>" onkeyup="totalInlineFail()" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="final_pass_<?php echo $i;?>" id="final_pass_<?php echo $i;?>" value="" onkeyup="totalFinalPass()" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="final_fail_<?php echo $i;?>" id="final_fail_<?php echo $i;?>" value="" onkeyup="totalFinalFail()" >

                      </td>

                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="critical_fault_<?php echo $i;?>" id="critical_fault_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="major_fault_<?php echo $i;?>" id="major_fault_<?php echo $i;?>" value="" onkeyup="totalIssue(this.value,<?php echo $i;?>),totalBalance(<?php echo $i;?>),totalPrice(<?php echo $i;?>)" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="defect_qty_<?php echo $i;?>" id="defect_qty_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="defect_detail_<?php echo $i;?>" id="defect_detail_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="remarks_<?php echo $i;?>" id="remarks_<?php echo $i;?>" value="" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="ins_by_<?php echo $i;?>" id="ins_by_<?php echo $i;?>" value="" >

                      </td>


                  </tr>


                  <?php $i++; //} ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="9">Total</td>
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
                  </tfoot>
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
