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
<?php require_once '../../DB/maintenance/update.php'; ?>
<?php require_once '../../DB/maintenance/select.php'; ?>

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
$month1 = date('F');
$year = date('Y');
////$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
$days_in_month = 31;
?>

<?php

$user_id = $_SESSION['id'];
$maintenance_id = $_GET['id'];
$ob = new select_maintenance();
$maintenance_result = $ob->select_with_id($maintenance_id);
$maintenance_details = mysqli_fetch_assoc($maintenance_result);

if (isset($_POST['btn'])) {
    //$count = $_POST['count'];
    //$maintenanceInsert = new insert();
    $maintenanceUpdate = new update();

    //for ($i = 1; $i <= $count; $i++) {
    $i = 1;
        $message = $maintenanceUpdate->update_maintenance(
                   $maintenance_id,
                   $_POST['mc_model'],
                   $_POST['mc_type_'.$i],
                   $_POST['rack_no_'.$i],
                   $_POST['box_no_'.$i],
                   $_POST['item_name_'.$i],
                   $_POST['parts_number_'.$i],
                   $_POST['prev_stock_'.$i],
                   $_POST['rec_challan_no_'.$i],
                   $_POST['today_rec_date_'.$i],
                   $_POST['today_received_'.$i],
                   $_POST['prev_received_'.$i],
                   $_POST['tot_received_'.$i],
                   $_POST['tot_stock_qty_'.$i],
                   $_POST['unit_'.$i],
                   $_POST['unit_price_'.$i],
                   $_POST['day_issue_'.$i],
                   $_POST['prev_issue_'.$i],
                   $_POST['tot_issue_'.$i],
                   $_POST['tot_balance_'.$i],
                   $_POST['tot_price_'.$i],
                   $_POST['next_order_qty_'.$i],
                   $_POST['next_unit_price_'.$i],
                   $_POST['next_tot_price_'.$i],
                   $_POST['remarks_'.$i],
                   $_POST['month'],
                   $_POST['year']
          );
        for ($j = 1; $j <= $days_in_month; $j++) {
          $ij = $i."_".$j;
          $mgs = $maintenanceUpdate->update_daily_issue_qty(
                   $_POST['maintenance_id'],
                   $_POST['day_'.$j],
                   $_POST['daily_issue_qty_'.$ij],
                   $_POST['month'],
                   $_POST['year']
          );
        }
        if($message){
          $_SESSION['mgs'] = $message;
          header('Location: update.php?id='.$maintenance_id);
        }
        //  else if ($message){
        //   $_SESSION['mgs'] = $message;
        //   header('Location: update.php?id='.$trinhouse_id);
        // }
    //}
}

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectItem = new select_item_maintenance();
$item_list =  $selectItem->select_all();

//--------------------------------------------  close select option ------------------------------------


?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>Insert Maintenance</label>
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

            <div class="row">

              <div class="form-group col-md-4">
                  <label class="btn btn-info">Month</label>
                  <div class="input-group margin" style="margin-top: 0px">
                     <select class="form-control col-md-12" name="month" id="month">
                        <option value="">Select Month</option>

                        <?php
                          for($i=1;$i<=12;$i++)
                          {
                                if($maintenance_details['month'] == $i){
                        ?>
                        <option value="<?php echo $i; ?>" selected><?php $monthName = date("F", mktime(0, 0, 0, $i, 10)); echo $monthName; ?></option>
                        <?php
                          }else {
                            ?>
                            <option value="<?php echo $i; ?>"><?php $monthName = date("F", mktime(0, 0, 0, $i, 10)); echo $monthName; ?></option>
                            <?php
                          }
                          }
                        ?>
                      </select>
                  </div>
                </div>

            <div class="form-group col-md-4">
            <label class="btn btn-info">Year</label>
            <div class="input-group margin" style="margin-top: 0px">
                <select class="form-control col-md-12" name="year" id="year">
                 <option value="">Select Year</option>

                 <?php
                  for($i=1;$i<=15;$i++)
                  {
                    if($maintenance_details['year'] == (2018+$i)){
                 ?>
                 <option value="<?php echo (2018+$i); ?>" selected><?php echo (2018+$i); ?></option>
                 <?php
                    }
                    else {
                      ?>
                      <option value="<?php echo (2018+$i); ?>"><?php echo (2018+$i); ?></option>
                      <?php
                    }
                  }
                 ?>
               </select>
            </div>
            </div>



            </div>

            <div id="form_1" class="box-body  w3-animate-right" style="padding:10px;overflow-x:scroll;height:500px;" onscroll="myFunction()">

              <input type="hidden" name="trinhouse_id"  id="trinhouse_id" value="<?php echo $trinhouse_id; ?>"></input>


              <!-- <div border="1" style="margin:10px 0px;">

                <select class="form-control col-md-6" name="type_select" id="type_select" >
                <option>Select Type</option>
                <option value="0">Recieve</option>
                <option value="1">Inhouse</option>
                </select>

              </div> -->
              <!-- <div border="1" style="margin:10px 0px;"> -->
                <?php //echo $month1;?>
                <!-- <select class="form-control col-md-6" name="type_select" id="type_select" >
                <option>Cp</option>
                <option value="0">Recieve</option>
                <option value="1">Inhouse</option>
                </select> -->

              <!-- </div> -->



            <?php
            // while ($trinhouse_details_in = mysqli_fetch_assoc($trinhouse_result)){
            //   $trinhouse_details_info[] = $trinhouse_details_in;
            // }
            ?>

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
                      <td class="text-center">SL</td>
                      <td class="text-center">M/C Model</td>
                      <td class="text-center">M/C TYPE</td>
                      <td class="text-center">RACK NO.</th>
                      <td class="text-center">BOX NO.</td>
                      <td class="text-center">ITEM NAME</td>
                      <td class="text-center">Parts Number</td>
                      <td class="text-center">Receive Challan No</td>
                      <td class="text-center">Today Receive Date</td>
                      <td class="text-center">Today Received</td>
                      <td class="text-center">Previous Received</td>
                      <td class="text-center">Total Received</td>
                      <td class="text-center">Previous Stock</td>
                      <td class="text-center">Total Stock  Qty </td>
                      <td class="text-center">Unit</td>
                      <td class="text-center">Unit Price</td>
                      <td class="text-center" colspan="<?php echo $days_in_month;?>">Daily Issue Qty</td>
                      <td class="text-center">Day Issue</td>
                      <td class="text-center">Previous Issue</td>
                      <td class="text-center">Total Issue</td>
                      <td class="text-center">Total Balance</td>
                      <td class="text-center">Total Price</td>
                      <td class="text-center">Next Order Qty</td>
                      <td class="text-center">unit price</td>
                      <td class="text-center">Total Price</td>
                      <td class="text-center">Remarks</td>
                    </tr>
                    <tr class="btn-gradient-01">
                      <td class="text-center" colspan="16"></td>
                      <?php
                      for($j=1;$j<=$days_in_month;$j++){
                      ?>
                      <td class="text-center"><?php echo $j;?></td>
                      <?php } ?>
                      <td class="text-center" colspan="9"></td>
                    </tr>
                  </thead>

                  <tbody id="add_row_table">
                  <?php
                  $i = 1;
                   //foreach ($item_list as $item_name){
                    ?>

                    <tr style="color:black;">


                    <td class="text-center">
                      <div style="width:40px">
                        <?php echo ($i); ?>
                      </div>
                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="text" name="mc_model" id="mc_model_<?php echo $i?>" value="<?php echo $maintenance_details['mc_model']?>">
                       <!-- <input type="hidden" name="month_<?php //echo $i;?>" id="month_<?php //echo $i?>" value="<?php //echo $maintenance_details['month']?>">
                       <input type="hidden" name="year_<?php //echo $i;?>" id="year_<?php //echo $i?>" value="<?php //echo $maintenance_details['year']?>"> -->
                       <input type="hidden" name="maintenance_id" id="maintenance_id" value="<?php echo $maintenance_id;?>">
                     </td>


                     <td class="text-center">
                       <input style="width:90px;" type="text" name="mc_type_<?php echo $i;?>" id="mc_type_<?php echo $i?>" value="<?php echo $maintenance_details['mc_type']?>">

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="text" name="rack_no_<?php echo $i;?>" id="rack_no_<?php echo $i?>" value="<?php echo $maintenance_details['rack_no']?>">

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="text" name="box_no_<?php echo $i;?>" id="box_no_<?php echo $i?>" value="<?php echo $maintenance_details['box_no']?>">

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="item_name_<?php echo $i;?>" id="item_name_<?php echo $i;?>" value="<?php echo $maintenance_details['item_name']?>" >
                        <!-- <input style="width:90px;" type="hidden" name="item_name_<?php //echo $i;?>" id="item_name_<?php //echo $i;?>" value="<?php //echo $item_name['id'];?>" > -->

                     </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="parts_number_<?php echo $i;?>" id="parts_number_<?php echo $i;?>" value="<?php echo $maintenance_details['parts_number']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="rec_challan_no_<?php echo $i;?>" id="rec_challan_no_<?php echo $i;?>" value="<?php echo $maintenance_details['rec_challan_no']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:135px;" type="date" name="today_rec_date_<?php echo $i;?>" id="today_rec_date_<?php echo $i;?>" value="<?php echo $maintenance_details['today_rec_date']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="today_received_<?php echo $i;?>" id="today_received_<?php echo $i;?>" onkeyup="totalReceived(this.value,<?php echo $i;?>)" value="<?php echo $maintenance_details['today_received']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="prev_received_<?php echo $i;?>" id="prev_received_<?php echo $i;?>" onkeyup="totalReceived(this.value,<?php echo $i;?>)" value="<?php echo $maintenance_details['prev_received']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="tot_received_<?php echo $i;?>" id="tot_received_<?php echo $i;?>" value="<?php echo $maintenance_details['tot_received']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="prev_stock_<?php echo $i;?>" id="prev_stock_<?php echo $i;?>" onkeyup="totalStock(this.value,<?php echo $i;?>)" value="<?php echo $maintenance_details['prev_stock']?>" >

                     </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="tot_stock_qty_<?php echo $i;?>" id="tot_stock_qty_<?php echo $i;?>" value="<?php echo $maintenance_details['tot_stock_qty']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="unit_<?php echo $i;?>" id="unit_<?php echo $i;?>" value="<?php echo $maintenance_details['unit']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="unit_price_<?php echo $i;?>" id="unit_price_<?php echo $i;?>" onkeyup="totalPrice(<?php echo $i;?>)" value="<?php echo $maintenance_details['unit_price']?>" >

                      </td>

                      <?php
                      for($j=1;$j<=$days_in_month;$j++){
                      $daily_issue_qty_by_id = $ob->select_daily_issue_qty_by_id($maintenance_id,$j);
                      $daily_issue_qty_info_by_id = mysqli_fetch_assoc($daily_issue_qty_by_id);
                      ?>
                     <td class="text-center">
                        <input type="hidden" step="0.01" name="day_<?php echo $j;?>" value="<?php echo $j;?>" >
                        <input style="width:40px;" type="number" step="0.01" name="daily_issue_qty_<?php echo $j;?>" class="daily_issue_qty_<?php echo $i;?>" onkeyup="totalDailyIssue(this.value,<?php echo $i;?>)" value="<?php echo $daily_issue_qty_info_by_id['daily_issue_qty'];?>" >

                      </td>
                      <?php } ?>
                     <td class="text-center">
                        <input style="width:90px;" type="number" step="0.01" name="day_issue_<?php echo $i;?>" id="day_issue_<?php echo $i;?>" value="<?php echo $maintenance_details['day_issue']?>" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="prev_issue_<?php echo $i;?>" id="prev_issue_<?php echo $i;?>" value="<?php echo $maintenance_details['prev_issue']?>" onkeyup="totalIssue(this.value,<?php echo $i;?>),totalBalance(<?php echo $i;?>),totalPrice(<?php echo $i;?>)" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="tot_issue_<?php echo $i;?>" id="tot_issue_<?php echo $i;?>" value="<?php echo $maintenance_details['tot_issue']?>" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="tot_balance_<?php echo $i;?>" id="tot_balance_<?php echo $i;?>" value="<?php echo $maintenance_details['tot_balance']?>" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="tot_price_<?php echo $i;?>" id="tot_price_<?php echo $i;?>" value="<?php echo $maintenance_details['tot_price']?>" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="next_order_qty_<?php echo $i;?>" id="next_order_qty_<?php echo $i;?>" onkeyup="nextTotal(<?php echo $i;?>)" value="<?php echo $maintenance_details['next_order_qty']?>" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="next_unit_price_<?php echo $i;?>" id="next_unit_price_<?php echo $i;?>" onkeyup="nextTotal(<?php echo $i;?>)" value="<?php echo $maintenance_details['next_unit_price']?>" >

                      </td>
                     <td class="text-center">
                       <input style="width:90px;" type="number" step="0.01" name="next_tot_price_<?php echo $i;?>" id="next_tot_price_<?php echo $i;?>" value="<?php echo $maintenance_details['next_tot_price']?>" >

                      </td>
                     <td class="text-center">
                        <input style="width:90px;" type="text" name="remarks_<?php echo $i;?>" id="remarks_<?php echo $i;?>" value="<?php echo $maintenance_details['remarks']?>" >
                      </td>


                  </tr>


                  <?php //$i++; } ?>
                  </tbody>
                </table>
              </div>
              <input type="hidden" value="<?php echo ($i);?>" id="count" name="count" >

              </div>

       </div>

       <p id="demo">as</p>
       <div class="text-center" style="padding-bottom: 10px;">
          <button name="btn" type="submit" class="btn btn-danger center-block">Submit</button>
          <button id="add_row" class="btn w3-pink center-block" name="add_row" onclick="addNewRow()" type="button">New Row</button>
          <!-- <button id="add_item" type="button" class="btn btn-danger center-block">+</button>
       </div> -->
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

function totalReceived(value,count){
  //alert(count);
  var today_received = parseFloat(document.getElementById('today_received_'+count).value);
  var prev_received = parseFloat(document.getElementById('prev_received_'+count).value);
  if(today_received){
      var tot_received = today_received;
  }
  if(prev_received){
    var tot_received = today_received + prev_received;
  }
  document.getElementById('tot_received_'+count).value = tot_received;
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

function nextTotal(count){
  var next_order_qty = parseFloat(document.getElementById('next_order_qty_'+count).value);
  var next_unit_price = parseFloat(document.getElementById('next_unit_price_'+count).value);
  if(next_unit_price){
    var next_tot_price = next_order_qty * next_unit_price;
  }
  document.getElementById('next_tot_price_'+count).value = next_tot_price;
}


function addNewRow(){
  var count = document.getElementById('count').value;
              count++;
              document.getElementById('count').value = count;

  rowItem = '<tr>'
             +'<td style="color:black;">'+count+'</td>'
             +'<td>'
             +'<input style="width:90px;" type="text" name="mc_model_'+count+'" id="mc_model_'+count+'">'
             +'<input type="hidden" name="month_'+count+'" id="month_'+count+'" value="<?php echo $month;?>">'
             +'<input type="hidden" name="year_'+count+'" id="year_'+count+'" value="<?php echo $year;?>">'
             +'</td>'
             +'<td><input style="width:90px;" type="text" name="mc_type_'+count+'" id="mc_type_'+count+'"></td>'
             +'<td><input style="width:90px;" type="text" name="rack_no_'+count+'" id="rack_no_'+count+'"></td>'


             +'<td>'
             +'<input style="width:90px;" type="text" name="box_no_'+count+'" id="box_no_'+count+'">'
             +'</td>'

             +'<td>'
             +'<input style="width:90px;" type="text" name="item_name_'+count+'" id="item_name_'+count+'" value="" >'
             +'</td>'

             +'<td>'
             +'<input style="width:90px;" type="text" name="parts_number_'+count+'" id="parts_number_'+count+'" value="" >'
             +'</td>'

             +'<td><input style="width:90px;" type="text" name="rec_challan_no_'+count+'" id="rec_challan_no_'+count+'" value="" ></td>'
             +'<td><input style="width:135px;" type="date" name="today_rec_date_'+count+'" id="today_rec_date_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="today_received_'+count+'" id="today_received_'+count+'" onkeyup="totalReceived(this.value,'+count+')" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="prev_received_'+count+'" id="prev_received_'+count+'" onkeyup="totalReceived(this.value,'+count+')" value="" ></td>'
             +'<td>'
             +'<input style="width:90px;" type="number" step="0.01" name="tot_received_'+count+'" id="tot_received_'+count+'" value="" >'
             +'</td>'

             +'<td><input style="width:90px;" type="text" name="prev_stock_'+count+'" id="prev_stock_'+count+'" value="" onkeyup="totalStock(this.value,'+count+')"  ></td>'

             +'<td><input style="width:90px;" type="number" step="0.01" name="tot_stock_qty_'+count+'" id="tot_stock_qty_'+count+'" value="" ></td>'

             +'<td><input style="width:90px;" type="text" name="unit_'+count+'" id="unit_'+count+'" value="" ></td>'

             +'<td><input style="width:90px;" type="number" step="0.01" name="unit_price_'+count+'" id="unit_price_'+count+'" value="" onkeyup="totalPrice('+count+')" ></td>'
             <?php
             for($j=1;$j<=$days_in_month;$j++){
             ?>
            +'<td class="text-center">'
            +'<input type="hidden" step="0.01" name="day_<?php echo $j;?>" value="<?php echo $j;?>" >'
            +'<input style="width:40px;" type="number" step="0.01" name="daily_issue_qty_'+count+'_<?php echo $j;?>" class="daily_issue_qty_'+count+'" onkeyup="totalDailyIssue(this.value,'+count+')" >'
            +'</td>'
             <?php } ?>
             +'<td><input style="width:90px;" type="number" step="0.01" name="day_issue_'+count+'" id="day_issue_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="prev_issue_'+count+'" id="prev_issue_'+count+'" value="" onkeyup="totalIssue(this.value,'+count+'),totalBalance('+count+'),totalPrice('+count+')" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="tot_issue_'+count+'" id="tot_issue_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="tot_balance_'+count+'" id="tot_balance_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="tot_price_'+count+'" id="tot_price_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="next_order_qty_'+count+'" id="next_order_qty_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="next_unit_price_'+count+'" id="next_unit_price_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="number" step="0.01" name="next_tot_price_'+count+'" id="next_tot_price_'+count+'" value="" ></td>'
             +'<td><input style="width:90px;" type="text" name="remarks_'+count+'" id="remarks_'+count+'" value="" ></td>'
             +'</tr>';

  rowItem2 = '<tr>'
             +'<td>'
             +'<select id="item_select_'+count+'" name="item_select_'+count+'" >'
             +'<?php echo $item_select_option; ?>'
             +'</select>'
             +'</td>'
             +'</tr>';

             $('#add_row_table').append(rowItem);

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
