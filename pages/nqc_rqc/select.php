<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/nqc_rqc/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/search.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
      $ob = new select_nqc();
      $result = $ob->select_all();
      //$nqc_by_month_info = mysqli_fetch_assoc($result);

      // $selectSize = new select_size();
      // $size_list =  $selectSize->select_all();
      //
      // $selectLine = new select_line();
      // $line_list =  $selectLine->select_all();
      //
      // $selectPO = new select_po();
      // $po_list =  $selectPO->select_all();
      //
      // $selectStyle = new select_style();
      // $style_list =  $selectStyle->select_all();
      //
      // if (isset($_POST['search'])) {
      //
      //     $search= new search_trims_inhouse();
      //     $result = $search->search($_POST);
      // }
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
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>

<?php

// $user_id = $_SESSION['id'];
//
//
// $selectStyle = new select_style();
// $style_list =  $selectStyle->select_all();
//
// $selectItem = new select_item_maintenance();
// $item_list =  $selectItem->select_all();

?>
<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>NQC List</label>
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

              <input type="hidden" name="trinhouse_id"  id="trinhouse_id" value="<?php //echo $trinhouse_id; ?>"></input>


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
                <?php
                $i = 1;
                 foreach ($result as $nqc_by_month_info){
                    $monthName = date("F", mktime(0, 0, 0, $nqc_by_month_info['month'], 10));
                    echo $monthName;
                  ?>
                <table class="w3-table-all w3-small" border="1">
                  <thead>
                    <tr class="btn-gradient-01">
                      <td class="text-center">INSPECTION</td>
                      <td class="text-center">TOTAL INSPECTION/QTY</td>
                      <td class="text-center">TOTAL</td>
                      <td class="text-center">PASS</th>
                      <td class="text-center">PASS %</td>
                      <td class="text-center">FAIL</td>
                      <td class="text-center">FAIL %</td>
                    </tr>
                  </thead>

                  <tbody id="add_row_table">


                    <tr style="color:black;">


                    <td class="text-center">
                      <div style="width:40px">INITIAL
                        <?php //echo "$nqc_left_menuInfo";?>
                      </div>
                    </td>

                     <td class="text-center"></td>


                     <td class="text-center">
                       <?php echo $nqc_by_month_info['t_initial_pass']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $nqc_by_month_info['t_initial_pass']; ?>
                      </td>
                     <td class="text-center">
                           <?php echo $maintenaceInfo['box_no']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['item']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['parts_number']; ?>
                      </td>
                  </tr>

                  <tr style="color:black;">


                    <td class="text-center">
                      <div style="width:40px">INLINE
                        <?php //echo "$nqc_left_menuInfo";?>
                      </div>
                    </td>

                     <td class="text-center"></td>


                     <td class="text-center">
                       <?php echo $nqc_by_month_info['t_inline_pass']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $nqc_by_month_info['t_inline_pass']; ?>
                      </td>
                     <td class="text-center">
                           <?php echo $maintenaceInfo['box_no']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['item']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['parts_number']; ?>
                      </td>
                  </tr>

                  <tr style="color:black;">


                    <td class="text-center">
                      <div style="width:40px">FINAL</div>
                    </td>

                     <td class="text-center"></td>


                     <td class="text-center">
                       <?php echo $nqc_by_month_info['t_final_pass']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $nqc_by_month_info['t_final_pass']; ?>
                      </td>
                     <td class="text-center">
                           <?php echo $maintenaceInfo['box_no']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['item']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['parts_number']; ?>
                      </td>
                  </tr>

                    <tr style="color:black;">


                    <td class="text-center">
                      <div style="width:40px">SKIP
                        <?php //echo "$nqc_left_menuInfo";?>
                      </div>
                    </td>

                     <td class="text-center"></td>


                     <td class="text-center">
                       <?php echo $nqc_by_month_info['t_initial_pass']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $nqc_by_month_info['t_initial_pass']; ?>
                      </td>
                     <td class="text-center">
                           <?php echo $maintenaceInfo['box_no']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['item']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['parts_number']; ?>
                      </td>
                  </tr>

                    <tr style="color:black;">


                    <td class="text-center">
                      <div style="width:40px">O/QTY
                        <?php //echo "$nqc_left_menuInfo";?>
                      </div>
                    </td>

                     <td class="text-center"></td>


                     <td class="text-center">
                       <?php echo $nqc_by_month_info['t_initial_pass']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $nqc_by_month_info['t_initial_pass']; ?>
                      </td>
                     <td class="text-center">
                           <?php echo $maintenaceInfo['box_no']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['item']; ?>
                      </td>
                     <td class="text-center">
                         <?php echo $maintenaceInfo['parts_number']; ?>
                      </td>
                  </tr>

                  </tbody>
                </table>
                <br>
                <?php $i++; } ?>
              </div>
              <input type="hidden" value="<?php echo ($i-1);?>" id="count" name="count" >

              </div>

       </div>

       <p id="demo">as</p>
       <!-- <div class="text-center" style="padding-bottom: 10px;">
          <button name="btn" type="submit" class="btn btn-danger center-block">Insert</button>
          <button id="add_row" class="btn w3-pink center-block" name="add_row" onclick="addNewRow()" type="button">New Row</button>
          <button id="add_item" type="button" class="btn btn-danger center-block">+</button>
       </div> -->
    </form>


</div>
</div>
</div>
</div>

<script>
//country modal
// document.getElementById("add_item").onclick = function() {
//    document.getElementById('item_modal').style.display = "block";
// }
//  document.getElementById("add_item_data").onclick = function() {
//    var item_name = document.getElementById("item_name_input").value;
//    $.post("ajax/add_maintenance_item.php?item_name="+item_name, function(data, status){
//             console.log(data);
//             document.getElementById("item_output").innerHTML = data;
//             document.getElementById("item_name_input").value = "";
//          });
//  }
//
//  function addItem() {
//     document.getElementById('item_modal').style.display = "none";
//
//     var count = document.getElementById("count").value;
//     var selectCountry = '';
//           $.post("ajax/select_last_item.php", function(data, status){
//             var data =  JSON.parse(data);
//             //console.log(data['id']);
//             document.getElementById("item_name_"+count).value = data['id'];
//             document.getElementById("item_"+count).value = data['name'];
//
//           });
//  }
//
// function totalReceived(value,count){
//   //alert(count);
//   var today_received = parseFloat(document.getElementById('today_received_'+count).value);
//   var prev_received = parseFloat(document.getElementById('prev_received_'+count).value);
//   if(today_received){
//       var tot_received = today_received;
//   }
//   if(prev_received){
//     var tot_received = today_received + prev_received;
//   }
//   document.getElementById('tot_received_'+count).value = tot_received;
// }
//
// function totalStock(value,count){
//   //alert(count);
//   var prev_stock = parseFloat(document.getElementById('prev_stock_'+count).value);
//   var tot_received = parseFloat(document.getElementById('tot_received_'+count).value);
//   if(prev_stock){
//     var tot_stock_qty = prev_stock + tot_received;
//   }
//   document.getElementById('tot_stock_qty_'+count).value = tot_stock_qty;
// }
//
// function totalDailyIssue(value,count){
//   var x = document.getElementsByClassName('daily_issue_qty_'+count);
//   var i;
//   var day_issue = 0;
//   for (i = 0; i < x.length; i++) {
//     if(x[i].value){
//       day_issue += parseFloat(x[i].value);
//     }
//   }
//   document.getElementById('day_issue_'+count).value = day_issue;
// }
//
// function totalIssue(value,count){
//   var day_issue = parseFloat(document.getElementById('day_issue_'+count).value);
//   var prev_issue = parseFloat(value);
//   if(prev_issue){
//     var tot_issue = day_issue + prev_issue;
//   }
//   document.getElementById('tot_issue_'+count).value = tot_issue;
// }
//
// function totalBalance(count){
//   var tot_stock_qty = parseFloat(document.getElementById('tot_stock_qty_'+count).value);
//   var tot_issue = parseFloat(document.getElementById('tot_issue_'+count).value);
//   if(tot_issue){
//     var tot_balance = tot_stock_qty - tot_issue;
//   }
//   document.getElementById('tot_balance_'+count).value = tot_balance;
// }
//
// function totalPrice(count){
//   var tot_balance = parseFloat(document.getElementById('tot_balance_'+count).value);
//   var unit_price = parseFloat(document.getElementById('unit_price_'+count).value);
//   if(tot_balance){
//     var tot_price = tot_balance * unit_price;
//   }
//   document.getElementById('tot_price_'+count).value = tot_price;
// }
//
//
//
//
// function addNewRow(){
//   var count = document.getElementById('count').value;
//               count++;
//               document.getElementById('count').value = count;
//
//   rowItem = '<tr>'
//              +'<td style="color:black;">'+count+'</td>'
//              +'<td>'
//              +'<input style="width:90px;" type="text" name="mc_model_'+count+'" id="mc_model_'+count+'">'
//              +'<input type="hidden" name="month_'+count+'" id="month_'+count+'" value="<?php //echo $month;?>">'
//              +'<input type="hidden" name="year_'+count+'" id="year_'+count+'" value="<?php //echo $year;?>">'
//              +'</td>'
//              +'<td><input style="width:90px;" type="text" name="mc_type_'+count+'" id="mc_type_'+count+'"></td>'
//              +'<td><input style="width:90px;" type="text" name="rack_no_'+count+'" id="rack_no_'+count+'"></td>'
//
//
//              +'<td>'
//              +'<input style="width:90px;" type="text" name="box_no_'+count+'" id="box_no_'+count+'">'
//              +'</td>'
//
//              +'<td>'
//              +'<input style="width:90px;" type="text" value="" id="item_'+count+'" >'
//              +'<input style="width:90px;" type="hidden" name="item_name_'+count+'" id="item_name_'+count+'" value="" >'
//              +'</td>'
//
//              +'<td>'
//              +'<input style="width:90px;" type="text" name="parts_number_'+count+'" id="parts_number_'+count+'" value="" >'
//              +'</td>'
//
//              +'<td><input style="width:90px;" type="text" name="rec_challan_no_'+count+'" id="rec_challan_no_'+count+'" value="" ></td>'
//              +'<td><input style="width:135px;" type="date" name="today_rec_date_'+count+'" id="today_rec_date_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="today_received_'+count+'" id="today_received_'+count+'" onkeyup="totalReceived(this.value,'+count+')" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="prev_received_'+count+'" id="prev_received_'+count+'" onkeyup="totalReceived(this.value,'+count+')" value="" ></td>'
//              +'<td>'
//              +'<input style="width:90px;" type="number" step="0.01" name="tot_received_'+count+'" id="tot_received_'+count+'" value="" >'
//              +'</td>'
//
//              +'<td><input style="width:90px;" type="text" name="prev_stock_'+count+'" id="prev_stock_'+count+'" value="" onkeyup="totalStock(this.value,'+count+')"  ></td>'
//
//              +'<td><input style="width:90px;" type="number" step="0.01" name="tot_stock_qty_'+count+'" id="tot_stock_qty_'+count+'" value="" ></td>'
//
//              +'<td><input style="width:90px;" type="text" name="unit_'+count+'" id="unit_'+count+'" value="" ></td>'
//
//              +'<td><input style="width:90px;" type="number" step="0.01" name="unit_price_'+count+'" id="unit_price_'+count+'" value="" onkeyup="totalPrice('+count+')" ></td>'
//              <?php
//              //for($j=1;$j<=$days_in_month;$j++){
//              ?>
//             +'<td class="text-center">'
//             +'<input type="hidden" step="0.01" name="day_<?php //echo $j;?>" value="<?php //echo $j;?>" >'
//             +'<input style="width:40px;" type="number" step="0.01" name="daily_issue_qty_<?php //echo $j;?>" class="daily_issue_qty_'+count+'" onkeyup="totalDailyIssue(this.value,'+count+')" >'
//             +'</td>'
//              <?php //} ?>
//              +'<td><input style="width:90px;" type="number" step="0.01" name="day_issue_'+count+'" id="day_issue_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="prev_issue_'+count+'" id="prev_issue_'+count+'" value="" onkeyup="totalIssue(this.value,'+count+'),totalBalance('+count+'),totalPrice('+count+')" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="tot_issue_'+count+'" id="tot_issue_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="tot_balance_'+count+'" id="tot_balance_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="tot_price_'+count+'" id="tot_price_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="next_order_qty_'+count+'" id="next_order_qty_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="next_unit_price_'+count+'" id="next_unit_price_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="number" step="0.01" name="next_tot_price_'+count+'" id="next_tot_price_'+count+'" value="" ></td>'
//              +'<td><input style="width:90px;" type="text" name="remarks_'+count+'" id="remarks_'+count+'" value="" ></td>'
//              +'</tr>';
//
//   rowItem2 = '<tr>'
//              +'<td>'
//              +'<select id="item_select_'+count+'" name="item_select_'+count+'" >'
//              +'<?php //echo $item_select_option; ?>'
//              +'</select>'
//              +'</td>'
//              +'</tr>';
//
//              $('#add_row_table').append(rowItem);


//}


//
// function totalReceiveQty(count){
//    var receive_quantity = 0;
//    var d_receive_quantity = parseInt(document.getElementById("d_receive_quantity_"+count).value);
//    receive_quantity = parseInt(document.getElementById("prev_receive_quantity_"+count).value);
//    if(d_receive_quantity){
//      receive_quantity = receive_quantity + d_receive_quantity;
//    }
//    document.getElementById("receive_quantity_"+count).value = receive_quantity;
// }
//
// function totalIssueQty(count){
//    var total_issue_quantity = 0;
//    var d_issue_quantity = parseInt(document.getElementById("d_issue_quantity_"+count).value);
//    total_issue_quantity = parseInt(document.getElementById("prev_total_issue_quantity_"+count).value);
//    if(d_issue_quantity){
//      total_issue_quantity = total_issue_quantity + d_issue_quantity;
//    }
//    document.getElementById("total_issue_quantity_"+count).value = total_issue_quantity;
// }
//
// function balanceQuantity(count){
//
//   var receive_quantity = parseInt(document.getElementById("receive_quantity_"+count).value);
//   var total_issue_quantity = parseInt(document.getElementById("total_issue_quantity_"+count).value);
//   if(receive_quantity){
//     balance_quantity = receive_quantity;
//   }
//   if(total_issue_quantity){
//     balance_quantity = receive_quantity - total_issue_quantity;
//   }
//   document.getElementById("balance_quantity_"+count).value = balance_quantity;
//
// }
// function requiredQuantity(count){
//      var required_quantity = 1;
//      var con = document.getElementById("con_"+count).value;
//      var actual_quantity = parseInt(document.getElementById("actual_quantity_"+count).value);
//      if(con){
//        required_quantity *= con;
//      }
//      if(actual_quantity){
//        required_quantity *= actual_quantity;
//      }
//    document.getElementById("required_quantity_"+count).value = Math.round(required_quantity);
// }
//
//
// function serialSum(value,bundleNo) {
//
//   var totalPcsNumber = '<?php //echo $totalPcsNumber; ?>';
//
//   for(var i = 1; i<=totalPcsNumber; i++)
//   {
//     var previousValue = 0;
//     var currentValue = 0;
//
//     try{
//     previousValue = parseInt(document.getElementById('serial_to_'+(i-1)).value);
//     } catch (err){
//       previousValue = 0;
//     }
//
//     try{
//       currentValue = parseInt(document.getElementById('quantity_'+(i)).value);
//     } catch (err){
//       currentValue = 0;
//     }
//
//     if (isNaN(previousValue)) previousValue = 0;
//     if (isNaN(currentValue)) currentValue = 0;
//
//     if(i == 1) previousValue = 0;
//
//     var serialFrom = (parseInt(previousValue)+1);
//     var serialTo = (parseInt(previousValue)+parseInt(currentValue));
//
//     document.getElementById('serial_from_'+i).value = serialFrom;
//     document.getElementById('serial_to_'+i).value = serialTo;
//   }
//
//
// }
//
// function updateShade(value,number){
//
//    var totalPcsNumber = '<?php //echo $totalPcsNumber; ?>';
//    var bundleNoPerTicket = '<?php //echo $bundleNoPerT; ?>';
//
//    for(var i = 1; i<=totalPcsNumber; i++)
//    {
//        if(i%bundleNoPerTicket == number){
//             document.getElementById('shade_'+i).value = value;
//             var shadeSelect = document.getElementById("shade_"+i);
//             document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
//        }else if(i%bundleNoPerTicket == 0){
//          document.getElementById('shade_'+i).value = value;
//          var shadeSelect = document.getElementById("shade_"+i);
//          document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
//        }
//    }
//
// }
//
// function updateCountry(value,number){
//
//    var totalPcsNumber = '<?php //echo $totalPcsNumber; ?>';
//    var bundleNoPerTicket = '<?php //echo $bundleNoPerT; ?>';
//
//    for(var i = 1; i<=totalPcsNumber; i++)
//    {
//        if(i%bundleNoPerTicket == number){
//             document.getElementById('country_'+i).value = value;
//             var countrySelect = document.getElementById("country_"+i);
//             document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
//        }else if(i%bundleNoPerTicket == 0){
//          document.getElementById('country_'+i).value = value;
//          var countrySelect = document.getElementById("country_"+i);
//          document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
//        }
//    }
//
// }
//
//
//
// function updateQuantity(value,number){
//
//   var bundleNoPerTicket = '<?php //echo $bundleNoPerT; ?>';
//   var totalPcsNumber = '<?php //echo $totalPcsNumber; ?>'*bundleNoPerTicket;
//
//   console.log("number : "+number);
//
//   for(var i = 1; i<=totalPcsNumber; i++)
//   {
//       if(i%bundleNoPerTicket == number){
//            document.getElementById('quantity_'+i).value = value;
//            serialSum(value,i);
//       } else if(i%bundleNoPerTicket == 0){
//            document.getElementById('quantity_'+i).value = value;
//            serialSum(value,i);
//       }
//   }
//
// }
//
// function updatePat(value){
//   var bundleNoPerTicket = '<?php //echo $bundleNoPerT; ?>';
//   var totalPcsNumber = '<?php //echo $totalPcsNumber; ?>'*bundleNoPerTicket;
//   console.log("Total Pcs : "+totalPcsNumber);
//
//   for(var i = 1; i<=totalPcsNumber; i++)
//   {
//       document.getElementById('pattern_'+i).value = value;
//   }
//
// }
//
// document.forms['form1'].elements['type_select'].value = <?php //echo $trinhouse_by_id['type'];?>
//
// function updateStyle(value){
//   var myCount = parseInt(document.getElementById("count").value);
//   //alert(myCount);
//    for(var i = 1; i<=myCount; i++)
//    {
//       document.getElementById('style_name_'+i).value = value;
//    }
// }
//
// function updatePO(value){
//   var myCount = parseInt(document.getElementById("count").value);
//
//   for(var i = 1; i<=myCount; i++)
//   {
//       document.getElementById('po_number_'+i).value = value;
//   }
// }
//
// function updatePCD(value){
//   //alert(value);
//   var myCount = parseInt(document.getElementById("count").value);
//
//   for(var i = 1; i<=myCount; i++)
//   {
//       document.getElementById('pcd_'+i).value = value;
//   }
// }
//
// function updateTODFrom(value){
//   //alert(value);
//   var myCount = parseInt(document.getElementById("count").value);
//
//   for(var i = 1; i<=myCount; i++)
//   {
//       document.getElementById('tod_from_'+i).value = value;
//   }
// }
//
// function updateTODTo(value){
//   //alert(value);
//   var myCount = parseInt(document.getElementById("count").value);
//
//   for(var i = 1; i<=myCount; i++)
//   {
//       document.getElementById('tod_to_'+i).value = value;
//   }
// }
//
// function updateColor(value){
//   //alert(value);
//   var myCount = parseInt(document.getElementById("count").value);
//   for(var i = 1; i<=myCount; i++)
//   {
//       document.getElementById('item_color_'+i).value = value;
//   }
// }

// function myFunction() {
//   var elmnt = document.getElementById("form_1");
//   var itemName = document.getElementById("itemName");
//   var x = elmnt.scrollLeft;
//   var y = elmnt.scrollTop;
//   document.getElementById ("demo").innerHTML = "Horizontally: " + x + "px<br>Vertically: " + y + "px";
//   if (x > 55) {
//     itemName.classList.add("sticky");
//   } else {
//     itemName.classList.remove("sticky");
//   }
//   if (y > 75) {
//     headerName.classList.add("sticky2");
//   } else {
//     headerName.classList.remove("sticky2");
//   }
//
// }

// function changeFocus1(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              var value = parseInt(index)-1;
//              document.getElementById("remarks_"+value).focus();
//           break;
//        case 39:
//              //var value = parseInt(index);
//              document.getElementById("challan_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus2(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              //var value = parseInt(index);
//              document.getElementById("item_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              //var value = parseInt(index);
//              document.getElementById("issue_date_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus3(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              //var value = parseInt(index);
//              document.getElementById("challan_"+parseInt(index)).focus();
//           break;
//        case 39:
//              //var value = parseInt(index);
//              document.getElementById("line_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus4(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("issue_date_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("style_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus5(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("line_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("po_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus6(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("style_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("pcd_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus7(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("po_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("tod_from_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus8(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("pcd_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("tod_to_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus9(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("tod_from_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("country_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus10(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("tod_to_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("supplier_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus11(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("country_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("color_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus12(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("supplier_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("size_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus13(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("color_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("shade_select_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus14(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("size_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("ref_no_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus15(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("shade_select_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("unit_type_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus16(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("ref_no_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("con_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus17(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("unit_type_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("order_quantity_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus18(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("con_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("receive_quantity_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus19(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("order_quantity_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("total_issue_quantity_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus20(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("receive_quantity_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("balance_quantity_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus21(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("total_issue_quantity_"+parseInt(index)).focus();
//           break;
//        case 39:
//              document.getElementById("remarks_"+parseInt(index)).focus();
//           break;
//     }
//   };
// }
// function changeFocus22(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              document.getElementById("balance_quantity_"+parseInt(index)).focus();
//           break;
//        case 39:
//              var value = parseInt(index)+1;
//              document.getElementById("item_select_"+value).focus();
//           break;
//     }
//   };
// }


</script>
