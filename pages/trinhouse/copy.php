<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/item/select.php'; ?>
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
<?php require_once '../../DB/trims_inhouse/insert.php'; ?>

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
.sticky3 {
  display: block!important;
}
#itemName {
  position: absolute;
  top: 80;
  z-index: 900;
}
#myDIV {
  position: absolute;
  top: 80;
  z-index: 0;
}
#headerName {
  position: absolute;
  z-index: 950;
}
#itemNameHeader {
  position: absolute;
  z-index: 1000;
}
</style>

<?php

$user_id = $_SESSION['id'];
$trinhouse_id = $_GET['id'];

if (isset($_POST['btn'])) {

    //$total_pcs = $_POST['total_pcs'];
    //$update = new update();


    // echo '<pre>';
    // print_r($_POST);
    // echo  '</pre>';


    //$trinhouse_name_id = $_POST['trinhouse_name_id'];
    //$trinhouse_id = $_POST['trinhouse_id'];
    // $challan = $_POST['challan'];
    // $issue_date = $_POST['issue_date'];
    // $item_name = $_POST['item_name'];
    // $line_number = $_POST['line_number'];
    // $style_select = $_POST['style_select'];
    // $po_number = $_POST['po_number'];
    // $pcd = $_POST['pcd'];
    // $tod = $_POST['tod'];
    // $supplier = $_POST['supplier'];
    // $item_color = $_POST['item_color'];
    // $size = $_POST['size'];
    // $shade = $_POST['shade'];
    // $ref_no = $_POST['ref_no'];
    // $unit_type = $_POST['unit_type'];
    // $actual_quantity = $_POST['actual_quantity'];
    // $required_quantity = $_POST['required_quantity'];
    // $total_issue_quantity = $_POST['total_issue_quantity'];
    // $balance_quantity = $_POST['balance_quantity'];
    // $remarks = $_POST['remarks'];
    $count = $_POST['count'];

    $obInsert = new insert();

    $type = $_POST['type_select'];
    $new_trinhouse_id = $obInsert->save(
                               $_POST['type_select']
                              );

    if($new_trinhouse_id != null && $new_trinhouse_id > 0) {

          $count = $_POST['count'];
          $type = $_POST['type_select'];

          for ($i = 1; $i <= $count; $i++) {

// echo '<pre/>';
// print_r($_POST['item_name_'.$i]);
// exit();
              $mgs = $obInsert->trinhouse_name(
                                     $new_trinhouse_id,
                                     $_POST['item_name_'.$i],
                                     $_POST['challan_'.$i],
                                     $_POST['issue_date_'.$i],
                                     $_POST['line_number_'.$i],
                                     $_POST['style_name_'.$i],
                                     $_POST['po_number_'.$i],
                                     $_POST['pcd_'.$i],
                                     $_POST['tod_from_'.$i],
                                     $_POST['tod_to_'.$i],
                                     $_POST['country_'.$i],
                                     $_POST['supplier_'.$i],
                                     $_POST['item_color_'.$i],
                                     $_POST['size_'.$i],
                                     $_POST['shade_'.$i],
                                     $_POST['ref_no_'.$i],
                                     $_POST['unit_type_'.$i],
                                     $_POST['con_'.$i],
                                     $_POST['actual_quantity_'.$i],
                                     $_POST['required_quantity_'.$i],
                                     $_POST['total_issue_quantity_'.$i],
                                     $_POST['balance_quantity_'.$i],
                                     $_POST['receive_quantity_'.$i],
                                     $_POST['remarks_'.$i],
                                     $type
                                    );


          }
    }

    // echo '<pre>';
    // print_r($trinhouse_id);
    // echo  '</pre>';
    //$trinhouse_id = $new_trinhouse_id;
    if($mgs){
      $_SESSION['mgs'] = $mgs;
      header('Location: copy.php?id='.$new_trinhouse_id);
    } else if ($message){
      $_SESSION['mgs'] = $message;
      header('Location: copy.php?id='.$new_trinhouse_id);
    }


}



$selectSize = new select_size();
$size_list =  $selectSize->select_all();

$selectItem = new select_item();
$item_list =  $selectItem->select_all();
//$items = mysqli_fetch_assoc($item_list);
 while ($item = mysqli_fetch_assoc($item_list))
 {
   $items[] = $item;
     // echo '<pre>';
     // print_r($items);
     // echo  '</pre>';
}
// foreach ($items as $item) {
//   echo '<pre>';
//   print_r($item['name']);
//   echo  '</pre>';
// }

$selectLine = new select_line();
$line_list =  $selectLine->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectSupplier = new select_supplier();
$supplier_list =  $selectSupplier->select_all();

$selectBuyer = new select_buyer();
$buyer_list =  $selectBuyer->select_all();

$selectColor = new select_color();
$color_list =  $selectColor->select_all();

$selectShade = new select_shade();
$shade_list =  $selectShade->select_all();

$selectSection = new select_section();
$section_list =  $selectSection->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectCuttingProduction = new select_cproduction();
$cut_pro_result = $selectCuttingProduction->select_with_id($trinhouse_id);
$cut_pro_details = mysqli_fetch_assoc($cut_pro_result);

$selectTrimsInhouse = new select_trims_inhouse();
$trinhouse_info_by_id = $selectTrimsInhouse->select_with_id($trinhouse_id);
$trinhouse_result = $selectTrimsInhouse->select_child_with_id($trinhouse_id);
$trinhouse_by_id = mysqli_fetch_assoc($trinhouse_info_by_id);
// while ($row = mysqli_fetch_assoc($trinhouse_result)){
    // echo '<pre>';
    // print_r($trinhouse_by_id);
    // echo  '</pre>';
// }
$cut_pro_child_list = $selectCuttingProduction->select_child_with_id($trinhouse_id);
$num_rows = mysqli_num_rows($cut_pro_child_list)/5;

$rows[] = null;

while($row = $cut_pro_child_list->fetch_row()) {
  $rows[] = $row;
}

?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>Trinhouse Details</label>
                </span>

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





              <?php
              while ($trinhouse_details_in = mysqli_fetch_assoc($trinhouse_result)){
                $trinhouse_details_info[] = $trinhouse_details_in;
              }
              ?>

                          <div class="form-group" id="itemName" style="left: 271;display:none;">
                            <table class="w3-table-all w3-small" border="1" style="margin-top: 1px;width:178px;">
                              <thead>
                                <tr class="btn-gradient-01">
                                  <td style="color:white;" width="60px">SL</td>
                                  <th class="text-center" width="118px">Item Name</th>
                                </tr>
                              </thead>

                              <tbody id="add_row_table2">
                              <?php
                              $i = 1;
                              foreach ($trinhouse_details_info as $trinhouse_details){
                                ?>
                              <tr style="color:black;">
                                <td class="text-center" style="width:60px">
                                  <?php echo $i++;?>
                                </td>

                                <td class="text-center">

                                  <select style="width:100px;" id="item_name2_<?php echo $i;?>">
                                  <option>Select Item Name </option>
                                  <?php
                                     foreach ($items as $row)
                                     {
                                          if($trinhouse_details['item_name'] == $row['id'])
                                          {
                                  ?>
                                  <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                  <?php
                                        } else{
                                   ?>
                                          <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                  </select>
                                </td>
                              </tr>
                            <?php } ?>
                            </tbody>
                            </table>
                          </div>

                          <div class="form-group" id="itemNameHeader" style="left: 271;display:none;">
                            <table class="w3-table-all w3-small" border="1" style="margin-top: 1px;width:178px;">
                              <thead>
                                <tr class="btn-gradient-01">
                                  <td style="color:white;" width="60px">SL</td>
                                  <th class="text-center" width="118px">Item Name</th>
                                </tr>
                              </thead>
                            </table>
                          </div>

<style media="screen">
   .txt-ctr td{
     text-align: center;
   }
</style>

                          <div class="form-group" id="headerName" style="display:none" >
                            <div class="w3-table-all w3-small" id="add_row3">
                              <table class="w3-table-all w3-small txt-ctr" style="margin-top: 0px;width:3020px">
                                <thead>
                                <tr class="btn-gradient-01">
                                  <td style="color:white;" width="60px">SL</td>
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
                                  <td style="color:white;" width="108px">Receive Cal.</td>
                                  <td style="color:white;" width="108px">Recieve Qty</td>
                                  <td style="color:white;" width="108px">Issue Cal.</td>
                                  <td style="color:white;" width="108px">Total Issue Qty</td>
                                  <td style="color:white;" width="108px">Balance Qty</td>
                                  <td style="color:white;" width="108px">Remarks</td>
                                </tr>
                                </thead>


                              </table>
                            </div>
                          </div>





                          <div class="form-group" style="height:500px;" id="myDIV">
                            <div class="w3-table-all w3-small" id="add_row">
                              <table class="w3-table-all w3-small" border="1">
                               <thead>
                                <tr class="btn-gradient-01">
                                  <td class="text-center">SL</td>
                                  <td class="text-center">Item Name</td>
                                  <td class="text-center">Challan No</td>
                                  <td class="text-center">Issue Date</td>
                                  <td class="text-center">Line No.</td>
                                  <td class="text-center">Style Name</td>
                                  <td class="text-center">PO Number</td>
                                  <td class="text-center">PCD</td>
                                  <td class="text-center">TOD From</td>
                                  <td class="text-center">TOD To</td>
                                  <td class="text-center">Country Name</td>
                                  <td class="text-center">Supplier</td>
                                  <td class="text-center">Item Color</td>
                                  <td class="text-center">Size</td>
                                  <td class="text-center">Shade</td>
                                  <td class="text-center">Ref No.</td>
                                  <td class="text-center">Unit Type</td>
                                  <td class="text-center">Cons</td>
                                  <td class="text-center">Actual Qty</td>
                                  <td class="text-center">Required Qty</td>
                                  <td class="text-center">Receive Cal.</td>
                                  <td class="text-center">Receive Qty</td>
                                  <td class="text-center">Issue Cal.</td>
                                  <td class="text-center">Total Issue Qty</td>
                                  <td class="text-center">Balance Qty</td>
                                  <td class="text-center">Remarks</td>
                                </tr>
                               </thead>

                               <tbody id="add_row_table">
                                <tr style="color:black;">

                                  <?php
                                  $i = 1;
                                  foreach ($trinhouse_details_info as $trinhouse_details){
                                    ?>
                                  <td class="text-center">
                                    <div style="width:34px">
                                      <?php echo $i;  ?>
                                    </div>
                                    <input type="hidden" name="trinhouse_name_id_<?php echo $i;?>"  id="trinhouse_name_id_<?php echo $i;?>" value="<?php echo $trinhouse_details['id']; ?>"></input>

                                   </td>
                                   <td class="text-center">

                                     <select style="width:101px;" name="item_name_<?php echo $i;?>" id="item_name_<?php echo $i;?>">
                                     <option>Select Item Name </option>
                                     <?php
                                        foreach ($items as $row)
                                        {
                                             if($trinhouse_details['item_name'] == $row['id'])
                                             {
                                     ?>
                                     <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                     <?php
                                           } else{
                                      ?>
                                             <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                         <?php
                                       }
                                     }
                                     ?>
                                     </select>
                                   </td>
                                  <td class="text-center">
                                    <input style="width:101px;" type="text" name="challan_<?php echo $i;?>" id="challan_<?php echo $i;?>" value="<?php echo $trinhouse_details['challan']; ?>" >

                                   </td>
                                  <td class="text-center">

                                    <input style="width:136px;" type="date" name="issue_date_<?php echo $i;?>" id="issue_date_<?php echo $i;?>" value="<?php echo $trinhouse_details['issue_date']; ?>">
                                  </td>
                                  <td class="text-center">

                                    <select style="width:101px;" name="line_number_<?php echo $i;?>" id="line_number_<?php echo $i;?>">
                                    <option>Select Line No </option>
                                    <?php
                                      while ($line = mysqli_fetch_assoc($line_list))
                                          {
                                            $lines[] = $line;
                                          }
                                            foreach ($lines as $row)
                                            {
                                            if($trinhouse_details['line_number'] == $row['id'])
                                            {
                                    ?>
                                    <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                           } else{
                                     ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                       }
                                     }
                                    ?>
                                    </select>

                                  </td>
                                  <td class="text-center">

                                    <select style="width:101px;" name="style_name_<?php echo $i;?>" id="style_name_<?php echo $i;?>" onchange="updateStyle(this.value)">
                                    <option>Select Style </option>
                                    <?php
                                      while ($style = mysqli_fetch_assoc($style_list))
                                        {
                                          $styles[] = $style;
                                        }
                                                foreach ($styles as $row)
                                                {
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

                                    <select style="width:101px;" name="po_number_<?php echo $i;?>" id="po_number_<?php echo $i;?>" onchange="updatePO(this.value)">
                                    <option>Select PO Number </option>
                                    <?php
                                      while ($po = mysqli_fetch_assoc($po_list))
                                          {
                                                $pos[] = $po;
                                              }
                                                      foreach ($pos as $row)
                                                      {
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
                                    <input style="width:136px;" type="date" name="pcd_<?php echo $i;?>" value="<?php echo $trinhouse_details['pcd']; ?>" id="pcd_<?php echo $i;?>" onchange="updatePCD(this.value)" >
                                  </td>
                                  <td class="text-center">
                                      <input style="width:136px;" type="date" name="tod_from_<?php echo $i;?>" value="<?php echo $trinhouse_details['tod_from']; ?>" id="tod_from_<?php echo $i;?>" onchange="updateTODFrom(this.value)" >
                                  </td>
                                  <td class="text-center">
                                      <input style="width:136px;" type="date" name="tod_to_<?php echo $i;?>" value="<?php echo $trinhouse_details['tod_to']; ?>" id="tod_to_<?php echo $i;?>" onchange="updateTODTo(this.value)" >
                                  </td>

                                   <td class="text-center">
                                     <input style="width:101px;" type="text" name="country_<?php echo $i;?>" id="country_<?php echo $i;?>" value="<?php echo $trinhouse_details['country']; ?>" >
                                   </td>

                                  <td class="text-center">

                                    <select style="width:101px;" name="supplier_<?php echo $i;?>" id="supplier_<?php echo $i;?>">
                                    <option>Select Supplier</option>
                                    <?php
                                      while ($supplier = mysqli_fetch_assoc($supplier_list))
                                          {
                                                      $suppliers[] = $supplier;
                                                    }
                                                            foreach ($suppliers as $row)
                                                            {
                                            if($trinhouse_details['supplier'] == $row['id'])
                                            {
                                    ?>
                                    <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                           } else{
                                     ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                      }
                                    }
                                    ?>
                                    </select>
                                  </td>
                                  <td class="text-center">
                                    <input style="width:101px;" type="text" name="item_color_<?php echo $i;?>" id="item_color_<?php echo $i;?>" value="<?php echo $trinhouse_details['item_color']; ?>" >

                                  </td>

                                  <td class="text-center">
                                    <input style="width:91px;" type="text" name="size_<?php echo $i;?>" id="size_<?php echo $i;?>" value="<?php echo $trinhouse_details['size']; ?>" >
                                  </td>

                                  <td class="text-center">
                                    <input style="width:91px;" type="text" name="shade_<?php echo $i;?>" id="shade_<?php echo $i;?>" value="<?php echo $trinhouse_details['shade']; ?>" >
                                  </td>

                                  <td class="text-center">
                                    <input style="width:91px;" type="text" name="ref_no_<?php echo $i;?>" id="ref_no_<?php echo $i;?>" value="<?php echo $trinhouse_details['ref_no']; ?>" >

                                  </td>
                                  <td class="text-center">
                                    <input style="width:91px;" type="text" name="unit_type_<?php echo $i;?>" id="unit_type_<?php echo $i;?>" value="<?php echo $trinhouse_details['unit_type']; ?>" >

                                  </td>
                                  <td class="text-center">
                                    <input style="width:91px;" type="number" step="0.01" name="con_<?php echo $i;?>" id="con_<?php echo $i?>" value="<?php echo $trinhouse_details['cons']; ?>" onkeyup="requiredQuantity(<?php echo ($i);?>)" >

                                   </td>
                                   <td class="text-center">
                                     <input style="width:91px;" type="number" step="0.01" name="actual_quantity_<?php echo $i;?>" id="actual_quantity_<?php echo $i?>" value="<?php echo $trinhouse_details['actual_quantity']; ?>"  onkeyup="requiredQuantity(<?php echo ($i);?>)" >
                                   </td>
                                   <td class="text-center">
                                     <input style="width:91px;" type="number" step="0.01" name="required_quantity_<?php echo $i;?>" id="required_quantity_<?php echo $i?>" value="<?php
                                     $required_quantity= $trinhouse_details['cons'] * $trinhouse_details['actual_quantity'];
                                     echo(round($required_quantity));
                                      ?>" >

                                    </td>
                                   <td class="text-center">
                                     <input style="width:91px;" name="receive_cal_<?php echo $i;?>" id="receive_cal_<?php echo $i?>" value="" onkeyup="receiveCal(event, <?php echo ($i);?>),balanceQuantity(<?php echo ($i);?>)">
                                    </td>
                                   <td class="text-center">
                                     <input style="width:91px;" type="number" step="0.01" name="receive_quantity_<?php echo $i;?>" id="receive_quantity_<?php echo $i?>" value="<?php echo $trinhouse_details['receive_quantity']; ?>" onkeyup="balanceQuantity(<?php echo ($i);?>)">
                                   </td>
                                  <td class="text-center">
                                     <input style="width:91px;" name="issue_cal_<?php echo $i;?>" id="issue_cal_<?php echo $i?>" value="" onkeyup="issueCal(event, <?php echo ($i);?>),balanceQuantity(<?php echo ($i);?>)">
                                   </td>
                                   <td class="text-center">
                                      <input style="width:91px;" type="number" step="0.01" name="total_issue_quantity_<?php echo $i;?>" id="total_issue_quantity_<?php echo $i?>" value="<?php echo $trinhouse_details['total_issue_quantity']; ?>" onkeyup="balanceQuantity(<?php echo ($i);?>)">

                                    </td>
                                   <td class="text-center">
                                     <input style="width:91px;" type="number" step="0.01" name="balance_quantity_<?php echo $i;?>" id="balance_quantity_<?php echo $i?>" value="<?php echo $trinhouse_details['balance_quantity']; ?>" >

                                    </td>

                                   <td class="text-center">
                                      <input style="width:91px;" type="text" name="remarks_<?php echo $i;?>" id="remarks_<?php echo $i;?>" value="<?php echo $trinhouse_details['remarks']; ?>">
                                     </td>
                                </tr>

                                <?php $i++; } ?>
                                </tbody>
                              </table>
                            </div>
                            <input type="hidden" value="<?php echo ($i-1);?>" id="count" name="count" >

                          </div>

       </div>
       <div class="text-center" style="padding-bottom: 10px;">
          <button name="btn" type="submit" class="btn btn-danger center-block">Create Sheet</button>
       </div>

    </form>


</div>
</div>
</div>
</div>

<script>

function receiveCal(event, count){
   var input = document.getElementById("receive_cal_"+count);
     if(event.keyCode === 13){
       var receive_cal = document.getElementById("receive_cal_"+count).value;
       var received_val = receive_cal.split("+");
       var length = received_val.length;
       var total = 0;
       for(i=0;i<length;i++){
         var rec_val = parseInt(received_val[i]);
         total += rec_val;
       }
       //alert(total);
       receive_quantity = parseInt(document.getElementById("receive_quantity_"+count).value);
       // d_receive_quantity = parseInt(document.getElementById("d_receive_quantity_"+count).value);
       if(!receive_quantity){
         receive_quantity = 0;
       }
       // if(!d_receive_quantity){
       //   d_receive_quantity = 0;
       // }
       //d_receive_quantity_n = total + d_receive_quantity;
       receive_quantity += total;
       //document.getElementById("d_receive_quantity_"+count).value = d_receive_quantity_n;
       document.getElementById("receive_quantity_"+count).value = receive_quantity;
       document.getElementById("receive_cal_"+count).value = "";
     }
}

function issueCal(event, count){
   var input = document.getElementById("issue_cal_"+count);
     if(event.keyCode === 13){
       var issue_cal = document.getElementById("issue_cal_"+count).value;
       var issue_val = issue_cal.split("+");
       var length = issue_val.length;
       var total = 0;
       for(i=0;i<length;i++){
         var iss_val = parseInt(issue_val[i]);
         total += iss_val;
       }
       //alert(total);
       issue_quantity = parseInt(document.getElementById("total_issue_quantity_"+count).value);
       // d_issue_quantity = parseInt(document.getElementById("d_issue_quantity_"+count).value);
       if(!issue_quantity){
         issue_quantity = 0;
       }
       // if(!d_issue_quantity){
       //   d_issue_quantity = 0;
       // }
       // d_issue_quantity_n = total + d_issue_quantity;
       issue_quantity = total + issue_quantity;
       // document.getElementById("d_issue_quantity_"+count).value = d_issue_quantity_n;
       document.getElementById("total_issue_quantity_"+count).value = issue_quantity;
       document.getElementById("issue_cal_"+count).value = "";
     }
}

function balanceQuantity(count){
     var balance_quantity = 0;
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
  var itemNameHeader = document.getElementById("itemNameHeader");
  var x = elmnt.scrollLeft;
  var y = elmnt.scrollTop;
  document.getElementById("itemName").style.left = x;
  document.getElementById("headerName").style.top = y-5;
  document.getElementById("itemNameHeader").style.left = x;
  document.getElementById("itemNameHeader").style.top = y-5;
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
  if (x > 55 && y > 75) {
    itemNameHeader.classList.add("sticky3");
  } else {
    itemNameHeader.classList.remove("sticky3");
  }
}
// function myFunction() {
//   var elmnt = document.getElementById("form_1");
//   var itemName = document.getElementById("itemName");
//   var x = elmnt.scrollLeft;
//   var y = elmnt.scrollTop;
//   document.getElementById ("demo").innerHTML = "Horizontally: " + x + "px<br>Vertically: " + y + "px";
//   document.getElementById("itemName").style.left = x;
//   document.getElementById("headerName").style.top = y-5;
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
