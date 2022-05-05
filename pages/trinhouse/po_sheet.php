<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/season/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/shade/select.php'; ?>
<?php require_once '../../DB/section/select.php'; ?>
<?php require_once '../../DB/item/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/supplier/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/insert.php'; ?>


<style>
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
#myDIV,
#itemName {
  position: absolute;
  top: 0;
}
#itemName {
  z-index: 900;
}
#headerName {
  position: absolute;
  z-index: 950;
}
#itemNameHeader {
  position: absolute;
  z-index: 1000;
}
#myDIV {
  z-index: 0;
}
</style>

<?php
$user_id = $_SESSION['id'];
$style_select_option     = '<option value="">Select Style</option>';
$po_select_option        = '<option value="">Select PO</option>';
$line_select_option      = '<option value="">Select Line</option>';
$item_select_option      = '<option value="">Select Item</option>';
$supplier_select_option  = '<option value="">Select Supplier</option>';
$size_select_option      = '<option value="">Select Size</option>';
$shade_select_option     = '<option value="">Select Shade</option>';
$color_select_option     = '<option value="">Select Color</option>';

$selectPO = new select_po();
$po_list_a =  $selectPO->select_all();

$selectStyle = new select_style();
$style_list_a =  $selectStyle->select_all();

$selectSupplier = new select_supplier();
$supplier_list = $selectSupplier->select_all();

$selectSeason = new select_season();
$season_list =  $selectSeason->select_all();

$selectColor = new select_color();
$color_list =  $selectColor->select_all();

$selectSection = new select_section();
$section_list =  $selectSection->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$select_item = new select_item();
$item_list = $select_item->select_all();

// echo '<pre/>';
// print_r($extras);
// exit();

// $item_num = mysqli_num_rows($item_list);
// $item_num_per_col = intval($item_num/3);
// $extras = $item_num%3;
// $all_items = array();
// $i = 1;
//
// while ($row = mysqli_fetch_assoc($item_list))
// {
//   $all_items[] = $row;
// }
// if($extras==1){$col_item = $item_num_per_col+1;$col_item2 = 2*$item_num_per_col+1; }
// elseif($extras==2){$col_item = $item_num_per_col+1;$col_item2 = 2*$item_num_per_col+2; }
// else{$col_item = $item_num_per_col;$col_item2 = 2*$item_num_per_col;}
//
// echo '<pre/>';
// print_r($col_item2);
// exit();

//--------------------------------------------- select option ------------------------------------------

$select_supplier = new select_supplier();
$supplier_list_a = $select_supplier->select_all();

while ($row = mysqli_fetch_assoc($supplier_list_a))
    {
      $supplier_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }

$select_style = new select_style();
$style_list = $select_style->select_all();

while ($row = mysqli_fetch_assoc($style_list))
    {
      $style_select_option .= '<option value="'.$row['id'].'">'.$row['style_name'].'</option>';
    }

$select_item = new select_item();
$all_item_list = $select_item->select_all();

while ($row = mysqli_fetch_assoc($all_item_list))
    {
      $item_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }


$select_po = new select_po();
$po_list = $select_po->select_all();

while ($row = mysqli_fetch_assoc($po_list))
    {
      $po_select_option .= '<option value="'.$row['id'].'">'.$row['po_num'].'</option>';
    }


$select_line = new select_line();
$line_list = $select_line->select_all();

while ($row = mysqli_fetch_assoc($line_list))
      {
        $line_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }


$selectSize = new select_size();
$size_list =  $selectSize->select_all();

while ($row = mysqli_fetch_assoc($size_list))
      {
        $size_select_option .= '<option value="'.$row['id'].'">'.$row['size_num'].'</option>';
      }


$selectShade = new select_shade();
$shade_list =  $selectShade->select_all();

while ($row = mysqli_fetch_assoc($shade_list))
      {
        $shade_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }


$selectColor = new select_color();
$color_list_a =  $selectColor->select_all();

while ($row = mysqli_fetch_assoc($color_list_a))
      {
        $color_select_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }

//--------------------------------------------  close select option ------------------------------------



$obInsert = new insert();

if (isset($_POST['create_ticket'])) {
      //$count = $_POST['count'];
      $type = $_POST['type'];
      $trinhouse_id = $obInsert->save(
                                 $type
                                );
}


if($trinhouse_id != null && $trinhouse_id > 0) {

      $count = $_POST['count'];
      $type = $_POST['type'];

      for ($i = 1; $i <= $count; $i++) {

          $mgs = $obInsert->trinhouse_name(
                                 $trinhouse_id,
                                 $_POST['item_select_'.$i],
                                 $_POST['challan_'.$i],
                                 $_POST['issue_date_'.$i],
                                 $_POST['line_select_'.$i],
                                 $_POST['style_select_'.$i],
                                 $_POST['po_select_'.$i],
                                 $_POST['pcd_'.$i],
                                 $_POST['tod_from_'.$i],
                                 $_POST['tod_to_'.$i],
                                 $_POST['country_'.$i],
                                 $_POST['supplier_select_'.$i],
                                 $_POST['color_select_'.$i],
                                 $_POST['size_select_'.$i],
                                 $_POST['shade_select_'.$i],
                                 $_POST['ref_no_'.$i],
                                 $_POST['unit_type_'.$i],
                                 $_POST['con_'.$i],
                                 $_POST['order_quantity_'.$i],
                                 $_POST['required_quantity_'.$i],
                                 $_POST['total_issue_quantity_'.$i],
                                 $_POST['balance_quantity_'.$i],
                                 $_POST['receive_quantity_'.$i],
                                 $_POST['remarks_'.$i],
                                 $type
                                );
      }
}


 if($mgs){
   $_SESSION['message'] = $message;
   header("Location: insert.php"); // redirect back to your form
   exit;
 }

?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    PO Sheet <label></label>
                </span>
                <h4 style="color: #fff; text-align: center" id="mgs">
                  <?php
                  if (isset($_SESSION['message'])) {
                      echo $_SESSION['message'];
                      unset($_SESSION['message']);
                  }
                  ?>
                 </h4>
            </div>


  <!-- modal for add country addition -->
  <!-- The Modal -->
<div id="buyer_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Supplier Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="buyer_name_input" placeholder ="Enter Supplier Name" required="">
                    </div>

                </div>
                <label class="form-control-label" id="buyer_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_buyer_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_buyer_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>



<div id="item_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Item Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="item_name_input" placeholder ="Enter Item Name" required="">
                    </div>
                </div>

                <label class="form-control-label" id="item_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_item_data" class="btn btn-gradient-03" type="submit" onclick="save_item_name()">Save</button>
<button id="close_item_btn" class="btn btn-gradient-05" type="submit" onclick="close_item_modal()">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>



<div id="season_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Season Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="season_name_input" placeholder ="Enter Season" required="">
                    </div>
                </div>

                <label class="form-control-label" id="season_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_season_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_season_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

</div>

</div>



<div id="po_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">PO Number <span style="color:red;"> *</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="po_number_input" placeholder ="Enter PO Number" required="">
                    </div>

                </div>

               <label class="form-control-label" id="po_output" style="color:red;"></label>
             </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_po_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_po_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

</div>

</div>


<!-- modal for add style addition -->
<div id="color_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Color Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="color_name_input" placeholder ="Enter Color Name" required="">
                    </div>
                </div>

                <label class="form-control-label" id="color_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_color_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_color_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>



<div id="style_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Style Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="style_name_input" placeholder ="Enter Style Name" required="">
                    </div>
                </div>

                <label class="form-control-label" id="style_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_style_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_s_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

</div>

</div>




<!-- modal for add country addition -->
<!-- modal for add style addition -->
<div id="shade_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Shade <span style="color:red;"> *</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="shade_input" placeholder ="Enter Shade" required="">
                    </div>

                </div>

               <label class="form-control-label" id="shade_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_shade_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_shade_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




<div id="section_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Section <span style="color:red;"> *</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="section_input" placeholder ="Enter Section" required="">
                    </div>

                </div>

               <label class="form-control-label" id="section_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_section_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_section_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>
</div>                        <!-- End Row -->
</div>
</div>


            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

              <div class="row">
              <div class="col-md-6">

                <div class="input-group margin" style="margin-top: 0px">
                                  <label class="form-control-label btn btn-success" style="margin-right:20px;">PO Number <span style="color: red">*</span></label>
                                  <select class="form-control col-md-6" name="po_select" id="po_select" onchange="loadInfo(this.value)">
                                  <option>Select PO</option>
                                  <?php
                                    while ($row = mysqli_fetch_assoc($po_list_a))
                                        {
                                  ?>
                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                  <?php
                                        }
                                  ?>
                                </select>
                                <button id="add_po" onclick="addPoFunction()" type="button" class="btn btn-danger center-block">+</button>
                 </div>


                 <br>



              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">Style Name <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="style_select" id="style_select" onchange="loadcInfo(this.value)">
                                <option>Select Style</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($style_list_a))
                                      {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                                <?php
                                      }
                                ?>
                              </select>
                              <button id="add_style" type="button" class="btn btn-danger center-block">+</button>
              </div>

              <br>

              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:45px;">Season <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="season_select" id="season_select">
                                <option>Select Season</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($season_list))
                                      {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                                      }
                                ?>
                              </select>
                              <button id="add_season" type="button" class="btn btn-danger center-block">+</button>
               </div>

                <br>

               <div class="input-group margin" style="margin-top: 0px">

                  <label class="form-control-label btn btn-success" style="margin-right:47px;">TOD To<span style="color: red">*</span></label>
                  <input type="date" class="form-control col-md-6" name="tod_t" id="tod_t" required="">

                 </div>

               <br>

               <div class="input-group margin" style="margin-top: 0px">

                 <label class="form-control-label btn btn-success" style="margin-right:15px;">Order Quantity <span style="color: red">*</span></label>
                 <input type="number" class="form-control col-md-6" name="order_quantity" id="order_quantity" required="">

                </div>


              </div>


              <div class="col-md-6">

               <div class="input-group margin" style="margin-top: 0px">
                                 <label class="form-control-label btn btn-success" style="margin-right:15px;">Supplier Name <span style="color: red">*</span></label>
                                 <select class="form-control col-md-6" name="buyer_select" id="buyer_select">
                                 <option>Select Supplier</option>

                                 <?php
                                   while ($row = mysqli_fetch_assoc($supplier_list))
                                       {
                                 ?>
                                 <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                 <?php
                                       }
                                 ?>
                               </select>
                               <button id="add_buyer" type="button" class="btn btn-danger center-block">+</button>
                </div>

               <br>


               <div class="input-group margin" style="margin-top: 0px">
                                 <label class="form-control-label btn btn-success" style="margin-right:18px;">Color Name <span style="color: red">*</span></label>
                                 <select class="form-control col-md-6" name="color_select" id="color_select">
                                 <option>Select Color</option>

                                 <?php
                                   while ($row = mysqli_fetch_assoc($color_list))
                                       {
                                 ?>
                                 <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                 <?php
                                       }
                                 ?>
                               </select>
                               <button id="add_color" type="button" class="btn btn-danger center-block">+</button>
                </div>

                <br>

                <div class="input-group margin" style="margin-top: 0px">
                  <label class="form-control-label btn btn-success" style="margin-right:32px;">TOD From<span style="color: red">*</span></label>
                  <input type="date" class="form-control col-md-6" name="tod_f" id="tod_f" required="">
                 </div>

                 <br>

                 <div class="input-group margin" style="margin-top: 0px">
                   <label class="form-control-label btn btn-success" style="margin-right:55px;">Cons <span style="color: red">*</span></label>
                   <input type="number" class="form-control col-md-6" name="cons_quantity" id="cons_quantity" step=".01" required="">
                 </div>

                 <br>

                 <div class="input-group margin" style="margin-top: 0px;">
                                   <label class="form-control-label btn btn-success" style="margin-right:20px;">Type<span style="color: red">*</span></label>
                                   <select class="form-control col-md-6" name="type_select" id="type_select" style="margin-left:40px;">
                                   <option value="0">Recieve</option>
                                   <option value="1">Inhouse</option>
                                 </select>
                 </div>

             </div>
             </div>

                           <br>

                           <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Item List</label>
                           <button id="add_new_item_btn" type="button" class="btn btn-danger center-block" onclick="addNewItem()">+</button>
                           <div>
                           <input id="checkAllItem" onchange="checkboxCheck(this.value)" style="margin-left:10px;height:17px;width:17px;" value="0" type="checkbox"><text style="color:black;">  All</text>
                           </div>
                           <div id="item_list_div">
                           <div class="row" id="item_list_creation">
                           <?php
                           $item_num = mysqli_num_rows($item_list);
                           $item_num_per_col = intval($item_num/3);
                           $extras = $item_num%3;
                           $all_items = array();
                           $i = 1;
                           while ($row = mysqli_fetch_assoc($item_list))
                           {
                             $all_items[$i] = $row;
                             $i++;
                           }
                           if($extras==1){$col_item = $item_num_per_col+1;$col_item2 = 2*$item_num_per_col+1; }
                           elseif($extras==2){$col_item = $item_num_per_col+1;$col_item2 = 2*$item_num_per_col+2; }
                           else{$col_item = $item_num_per_col;$col_item2 = 2*$item_num_per_col;}
                           ?>
                           <div class="col-md-4">
                           <?php
                           //foreach ($all_items as $row) {
                           for($j = 1;$j<=$col_item;$j++){
                             $row = $all_items[$j];
                             ?>
                             <div class="row">
                             <div class="col-md-2">
                             <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;float:left;" name="<?php echo "item_".$row['id']; ?>" id="<?php echo "item_id_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
                             </div>
                             <div class="col-md-6">
                             <text style="color:black;width:150px;">  <?php echo $row['name']; ?><text>
                             </div>
                             <div class="col-md-2">
                             <input type="number" style="width:50px;height:20px;" name="item_quantity_<?php echo $row['id']; ?>" id="item_quantity_<?php echo $row['id']; ?>" value="1">
                             </div>
                             </div>
                         <?php } ?>

                         </div>
                         <div class="col-md-4">
                         <?php for($j = ($col_item+1); $j<=$col_item2; $j++) {
                           $row = $all_items[$j];?>
                             <div class="row">
                             <div class="col-md-2">
                             <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;float:left;" name="<?php echo "item_".$row['id']; ?>" id="<?php echo "item_id_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
                             </div>
                             <div class="col-md-6">
                             <text style="color:black;width:150px;">  <?php echo $row['name']; ?><text>
                             </div>
                             <div class="col-md-2">
                             <input type="number" style="width:50px;height:20px;" name="item_quantity_<?php echo $row['id']; ?>" id="item_quantity_<?php echo $row['id']; ?>" value="1">
                             </div>
                             </div>
                         <?php }?>

                         </div>
                         <div class="col-md-4">
                         <?php for($j = ($col_item2+1); $j<=$item_num; $j++) {
                           $row = $all_items[$j];?>
                             <div class="row">
                             <div class="col-md-2">
                             <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;float:left;" name="<?php echo "item_".$row['id']; ?>" id="<?php echo "item_id_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
                             </div>
                             <div class="col-md-6">
                             <text style="color:black;width:150px;">  <?php echo $row['name']; ?><text>
                             </div>
                             <div class="col-md-2">
                             <input type="number" style="width:50px;height:20px;" name="item_quantity_<?php echo $row['id']; ?>" id="item_quantity_<?php echo $row['id']; ?>" value="1">
                             </div>
                             </div>
                         <?php }?>

                       </div>
                          </div>
                          </div>

             <br>


              <div id="size_list_div" class="text-center">
              </div>

             <br>


            <div class="text-center" style="padding-bottom: 10px;">
            <button id="create_form" type="button" class="btn btn-danger center-block">Create Form</button>
            </div>
       </div>


      <form method="post" enctype="multipart/form-data" action="">
      <div id="form_2" class="box-body  w3-animate-right w3-card-4" style="padding:10px;display:none;overflow-x:scroll;height:500px;" onscroll="myFunction()">

         <div id="selectedProcessList" style="display:none;">

         </div>

         <div class="row">

         <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
         <input type="hidden" name="buyer" id="buyer">
         <input type="hidden" name="po" id="po">
         <input type="hidden" name="color" id="color">
         <input type="hidden" name="style" id="style">
         <input type="hidden" name="season" id="season">
         <input type="hidden" name="tod_from" id="tod_from">
         <input type="hidden" name="tod_to" id="tod_to">
         <input type="hidden" name="cons" id="cons">
         <input type="hidden" name="order_quantity_" id="order_quantity_">
         <input type="hidden" name="line" id="line">
         <input type="hidden" name="shade" id="shade">
         <input type="hidden" name="count" id="count">
         <input type="hidden" name="type" id="type">

          <div class="col-md-12">



            <div class="form-group" id="itemName" style="display:none;">
            <div class="w3-table-all w3-small" id="add_row2">
              <table class="w3-table-all w3-small" style="margin-top: 0px;width:150px;">
                <thead>
                <tr class="btn-gradient-01">
                  <td style="color:white;">SL</td>
                  <td style="color:white;">Item Name</td>
                </tr>
                </thead>

                <tbody id="add_row_table2">
                </tbody>

              </table>
            </div>
            </div>

            <div class="form-group" id="itemNameHeader" style="display:none;">
            <div class="w3-table-all w3-small">
              <table class="w3-table-all w3-small" style="margin-top: 0px;width:210px;">
                <thead>
                <tr class="btn-gradient-01">
                  <td style="color:white;width:20px">SL</td>
                  <td style="color:white;">Item Name</td>
                </tr>
                </thead>

                <tbody id="add_row_table2">
                </tbody>

              </table>
            </div>
            </div>

            <div class="form-group" id="headerName" style="display:none" >
            <div class="w3-table-all w3-small" id="add_row3">
              <table class="w3-table-all w3-small" style="margin-top: 0px;width:2999px">
                <thead>
                <tr class="btn-gradient-01">
                  <td style="color:white;" width="39px">SL</td>
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
                  <td style="color:white;" width="108px">Recieve Cal.</td>
                  <td style="color:white;" width="108px">Total Recieve Qty</td>
                  <td style="color:white;" width="108px">Issue Cal.</td>
                  <td style="color:white;" width="108px">Total Issue Qty</td>
                  <td style="color:white;" width="108px">Balance Qty</td>
                  <td style="color:white;" width="108px">Remarks</td>
                </tr>
                </thead>


              </table>
            </div>
            </div>




            <div class="form-group" style="height:500px;" id="myDIV" >

                <div class="w3-table-all w3-small" id="add_row">

                <table class="w3-table-all w3-small" style="margin-top: 0px;">
                  <thead>
                  <tr class="btn-gradient-01">
                    <td style="color:white;">SL</td>
                    <td style="color:white;">Item Name</td>
                    <td style="color:white;">Challan No</td>
                    <td style="color:white;">Issue Date</td>
                    <td style="color:white;">Line No.</td>
                    <td style="color:white;">Style Name</td>
                    <td style="color:white;">P.O.</td>
                    <td style="color:white;">PCD</td>
                    <td style="color:white;">TOD From</td>
                    <td style="color:white;">TOD To</td>
                    <td style="color:white;">Country Name</td>
                    <td style="color:white;">Supplier</td>
                    <td style="color:white;">Item Color</td>
                    <td style="color:white;">Size</td>
                    <td style="color:white;">Shade</td>
                    <td style="color:white;">Ref. No.</td>
                    <td style="color:white;">Unit Type</td>
                    <td style="color:white;">Con</td>
                    <td style="color:white;">Actual Qty</td>
                    <td style="color:white;">Required Qty</td>
                    <td style="color:white;">Recieve Cal.</td>
                    <td style="color:white;">Total Recieve Qty</td>
                    <td style="color:white;">Issue Cal.</td>
                    <td style="color:white;">Total Issue Qty</td>
                    <td style="color:white;">Balance Qty</td>
                    <td style="color:white;">Remarks</td>
                  </tr>
                  </thead>

                  <tbody id="add_row_table">
                  </tbody>

                </table>


                </div>

            </div>
          </div>

        </div>

      </div>

      <p id="demo"></p>
      <div class="text-center" id="submit_button" style="padding-bottom: 10px;display:none;margin-top: 10px;">
         <button id="create_ticket" name="create_ticket" type="submit" class="btn btn-danger center-block">Create Sheet</button>
         <button id="add_row" class="btn w3-pink center-block" name="add_row" onclick="addNewRow()" type="button">New Row</button>
      </div>
    </form>


</div>
</div>
</div>
<script>

$(document).ready(function () {

   var rowItem = "";
   var rowItem2 = "";
   var count = 0;

   $('#checkAllItem').click(function () {
         $("#item_list_div :checkbox").attr('checked', true);
     });

     var selectSize = '<option value="">Select Size</option>';

     $.get("ajax/all_size_list.php", function(data, status){

              var data = JSON.parse(data);

              data.forEach(function(size){

                if(size.inseam == '')
                selectSize +=  '<option value="'+size.id+'">'+size.size_num+'</option>';
                else selectSize +=  '<option value="'+size.id+'">'+size.inseam+"-"+size.size_num+'</option>';

              });

           });

     //buyer modal
     document.getElementById("add_buyer").onclick = function() {
        document.getElementById('buyer_modal').style.display = "block";
     }

     document.getElementById("add_buyer_data").onclick = function() {

       var buyer_name = document.getElementById("buyer_name_input").value;
       $.post("ajax/add_supplier.php?supplier_name="+buyer_name, function(data, status){
                console.log(data);
                document.getElementById("buyer_output").innerHTML = data;
                document.getElementById("buyer_name_input").value = "";
             });
     }

     document.getElementById("close_buyer_btn").onclick = function() {

        document.getElementById('buyer_modal').style.display = "none";
        document.getElementById('buyer_select').innerHTML = "";

        var selectBuyer = '<option value="">Select Supplier</option>';

        $.get("ajax/all_supplier_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(buyer){
                   console.log(buyer);

                   selectBuyer +=  '<option value="'+buyer.id+'">'+buyer.name+'</option>';

                 });

                 $('#buyer_select').append(selectBuyer);
              });
     }

     //season modal
     document.getElementById("add_season").onclick = function() {
        document.getElementById('season_modal').style.display = "block";
     }

     document.getElementById("add_season_data").onclick = function() {

       var season_name = document.getElementById("season_name_input").value;
       $.post("ajax/add_season.php?season_name="+season_name, function(data, status){
                console.log(data);
                document.getElementById("season_name_input").value = "";
                document.getElementById("season_output").innerHTML = data;
             });
     }

     document.getElementById("close_season_btn").onclick = function() {
        document.getElementById('season_modal').style.display = "none";
        document.getElementById('season_select').innerHTML = '';

        var selectSeason = '<option value="">Select Season</option>';

        $.get("ajax/all_season_list.php", function(data, status){
                 var data = JSON.parse(data);

                 data.forEach(function(season){
                   selectSeason +=  '<option value="'+season.id+'">'+season.name+'</option>';
                 });
                 $('#season_select').append(selectSeason);
              });
     }

     //color modal
     document.getElementById("add_color").onclick = function() {
        document.getElementById('color_modal').style.display = "block";
     }

     document.getElementById("add_color_data").onclick = function() {

       var color_name = document.getElementById("color_name_input").value;
       $.post("ajax/add_color.php?color_name="+color_name, function(data, status){
                console.log(data);
                document.getElementById("color_output").innerHTML = data;
                document.getElementById("color_name_input").value = "";
             });

     }

        document.getElementById("close_color_btn").onclick = function() {
        document.getElementById('color_modal').style.display = "none";
        document.getElementById('color_select').innerHTML = '';

        var selectColor = '<option value="">Select Color</option>';

        $.get("ajax/all_color_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(color){
                   selectColor +=  '<option value="'+color.id+'">'+color.name+'</option>';
                 });

                 $('#color_select').append(selectColor);
              });
     }


     //style modal
     document.getElementById("add_style").onclick = function() {
        document.getElementById('style_modal').style.display = "block";
     }

     document.getElementById("add_style_data").onclick = function() {

       var style_name = document.getElementById("style_name_input").value;
       $.post("ajax/add_style.php?style_name="+style_name, function(data, status){
                console.log(data);
                document.getElementById("style_output").innerHTML = data;
                document.getElementById("style_name_input").value = "";
             });

     }

        document.getElementById("close_s_btn").onclick = function() {
        document.getElementById('style_modal').style.display = "none";
        document.getElementById('style_select').innerHTML = '';

        var selectStyle = '<option value="">Select Style</option>';

        $.get("ajax/all_style_list.php", function(data, status){
                 var data = JSON.parse(data);

                 data.forEach(function(style){
                   selectStyle +=  '<option value="'+style.id+'">'+style.style_name+'</option>';
                 });

                 $('#style_select').append(selectStyle);
              });
     }


     //po modal

     document.getElementById("add_po_data").onclick = function() {

       var po_number = document.getElementById("po_number_input").value;
       $.post("ajax/add_po.php?po_num="+po_number, function(data, status){
                console.log(data);
                document.getElementById("po_output").innerHTML = data;
                document.getElementById("po_number_input").value = "";
             });

     }

     document.getElementById("close_po_btn").onclick = function() {
        document.getElementById('po_modal').style.display = "none";
        document.getElementById('po_select').innerHTML = '';

        var selectPo = '<option value="">Select Po</option>';

        $.get("ajax/all_po_list.php", function(data, status){
                 var data = JSON.parse(data);

                 data.forEach(function(po){
                   selectPo +=  '<option value="'+po.id+'">'+po.po_num+'</option>';
                 });

                 $('#po_select').append(selectPo);
              });
     }


       //create ticket button
       document.getElementById("create_form").onclick = function() {

             document.getElementById("form_1").style.display = "none";
             document.getElementById("form_2").style.display = "block";
             document.getElementById("submit_button").style.display = "block";


             var po = document.getElementById("po_select");
             document.getElementById("po").value = po.options[po.selectedIndex].value;

             var buyer = document.getElementById("buyer_select");
             document.getElementById("buyer").value = buyer.options[buyer.selectedIndex].value;

             var style = document.getElementById("style_select");
             document.getElementById("style").value = style.options[style.selectedIndex].value;

             var color = document.getElementById("color_select");
             document.getElementById("color").value = color.options[color.selectedIndex].value;

             var season = document.getElementById("season_select");
             document.getElementById("season").value = season.options[season.selectedIndex].value;

             var tod_from = document.getElementById("tod_f").value;
             var tod_to = document.getElementById("tod_t").value;
             var cons = document.getElementById("cons_quantity").value;
             var order_quantity = document.getElementById("order_quantity").value;
             var required_quantity = cons * order_quantity;
             var balance_quantity = -(cons * order_quantity);
             var type = document.getElementById("type_select").value;

             document.getElementById("type").value = type;

             $('#item_list_div input:checked').each(function () {

              if($(this).attr('value') != 0){
              var id = $(this).attr('value');
              var quantity = parseInt(document.getElementById("item_quantity_"+id).value);

              console.log(quantity);

              for (var i = 1; i <= quantity; i++) {

              count++;
              document.getElementById('count').value = count;

              rowItem = '<tr>'
                         +'<div style="width:60px">'
                         +'<td style="color:black;">'+count+'</td>'
                         +'</div>'
                         +'<td>'
                         +'<select id="item_select_'+count+'" name="item_select_'+count+'" style="width:101px" onkeyup="changeFocus1('+count+')"  >'
                         +'<?php echo $item_select_option; ?>'
                         +'</select>'
                         +'</td>'
                         +'<td><input type="text" style="width:101px;" id="challan_'+count+'" name="challan_'+count+'" onkeyup="changeFocus2('+count+')" ></td>'
                         +'<td><input type="date" style="width:136px;" id="issue_date_'+count+'" name="issue_date_'+count+'" value="<?php echo date("Y-m-d"); ?>" onkeyup="changeFocus3('+count+')" ></td>'

                         +'<td>'
                         +'<select id="line_select_'+count+'" name="line_select_'+count+'" style="width:101px" onkeyup="changeFocus4('+count+')" >'
                         +'<?php echo $line_select_option; ?>'
                         +'</select>'
                         +'</td>'

                         +'<td>'
                         +'<select id="style_select_'+count+'" name="style_select_'+count+'" onchange="updateStyle(this.value)" style="width:101px" onkeyup="changeFocus5('+count+')" >'
                         +'<?php echo $style_select_option; ?>'
                         +'</select>'
                         +'</td>'

                         +'<td>'
                         +'<select id="po_select_'+count+'" name="po_select_'+count+'" onchange="updatePO(this.value)" style="width:101px" onkeyup="changeFocus6('+count+')" >'
                         +'<?php echo $po_select_option; ?>'
                         +'</select>'
                         +'</td>'

                         +'<td><input type="date" style="width:136px;" id="pcd_'+count+'" name="pcd_'+count+'" value="<?php echo date("Y-m-d"); ?>" onchange="updatePCD(this.value)" onkeyup="changeFocus7('+count+')" ></td>'
                         +'<td><input type="date" style="width:136px;" id="tod_from_'+count+'" name="tod_from_'+count+'" value="'+tod_from+'" onchange="updateTODFrom(this.value)" onkeyup="changeFocus8('+count+')" ></td>'
                         +'<td><input type="date" style="width:136px;" id="tod_to_'+count+'" name="tod_to_'+count+'" value="'+tod_to+'" onchange="updateTODTo(this.value)" onkeyup="changeFocus9('+count+')" ></td>'
                         +'<td><input type="text" style="width:101px;" id="country_'+count+'" name="country_'+count+'" onkeyup="changeFocus10('+count+')" ></td>'

                         +'<td>'
                         +'<select id="supplier_select_'+count+'" name="supplier_select_'+count+'" style="width:101px;" onkeyup="changeFocus11('+count+')">'
                         +'<?php echo $supplier_select_option; ?>'
                         +'</select>'
                         +'</td>'

                         +'<td><input type="text" style="width:101px;" id="color_select_'+count+'" name="color_select_'+count+'" onkeyup="changeFocus12('+count+')" ></td>'

                         +'<td><input type="text" style="width:91px;" id="size_select_'+count+'" name="size_select_'+count+'" onkeyup="changeFocus13('+count+')" ></td>'
                         +'<td><input type="text" style="width:91px;" id="shade_select_'+count+'" name="shade_select_'+count+'" onkeyup="changeFocus14('+count+')" ></td>'

                         +'<td><input type="text" style="width:91px;" id="ref_no_'+count+'" name="ref_no_'+count+'" onkeyup="changeFocus15('+count+')" ></td>'
                         +'<td><input type="text" style="width:91px;" id="unit_type_'+count+'" name="unit_type_'+count+'" onkeyup="changeFocus16('+count+')" ></td>'
                         +'<td><input type="number" style="width:91px;" id="con_'+count+'" name="con_'+count+'" step="0.01" value="'+cons+'" onkeyup="requiredQuantity('+count+'),changeFocus17('+count+')" ></td>'
                         +'<td><input type="number" style="width:91px;" id="order_quantity_'+count+'" name="order_quantity_'+count+'" step="0.01" value="'+order_quantity+'" onkeyup="requiredQuantity('+count+'),changeFocus18('+count+')" ></td>'
                         +'<td><input type="number" style="width:91px;" id="required_quantity_'+count+'" name="required_quantity_'+count+'" step="0.01" value="'+Math.round(required_quantity)+'" readonly></td>'
                         +'<td><input style="width:91px;" id="receive_cal_'+count+'" name="receive_cal_'+count+'" onkeyup="receiveCal(event, '+count+'),balanceQuantity('+count+')" ></td>'
                         +'<td><input type="number" style="width:91px;" id="receive_quantity_'+count+'" name="receive_quantity_'+count+'" step="0.01" onkeyup="balanceQuantity('+count+'),changeFocus19('+count+')" ></td>'
                         +'<td><input style="width:91px;" id="issue_cal_'+count+'" name="issue_cal_'+count+'" onkeyup="issueCal(event, '+count+'),balanceQuantity('+count+')" ></td>'
                         +'<td><input type="number" style="width:91px;" id="total_issue_quantity_'+count+'" name="total_issue_quantity_'+count+'" step="0.01" onkeyup="balanceQuantity('+count+'),changeFocus20('+count+')" ></td>'
                         +'<td><input type="number" style="width:91px;" id="balance_quantity_'+count+'" name="balance_quantity_'+count+'" step="0.01" value="'+Math.round(balance_quantity)+'" onkeyup="changeFocus21('+count+')" ></td>'
                         +'<td><input type="text" style="width:91px;" id="remarks_'+count+'" name="remarks_'+count+'" onkeyup="changeFocus22('+count+')" ></td>'
                         +'</tr>';

              rowItem2 = '<tr>'
                         +'<td style="color:black;width:60px">'+count+'</td>'
                         +'<td>'
                         +'<select id="item_select2_'+count+'" name="item_select_'+count+'" width="101px" readonly>'
                         +'<?php echo $item_select_option; ?>'
                         +'</select>'
                         +'</td>'
                         +'</tr>';

                         $('#add_row_table').append(rowItem);
                         $('#add_row_table2').append(rowItem2);

                         document.getElementById('item_select_'+count).value     = id;
                         document.getElementById('item_select2_'+count).value     = id;
                         document.getElementById('style_select_'+count).value    = document.getElementById("style").value ;
                         document.getElementById('po_select_'+count).value       = document.getElementById("po").value ;
                         document.getElementById('supplier_select_'+count).value = document.getElementById("buyer").value ;
                         //document.getElementById('color_select_'+count).value    = document.getElementById("color").value ;





                    }
                }
             });
       }
});

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
     var con = document.getElementById("con_"+count).value;
     var order_quantity = parseInt(document.getElementById("order_quantity_"+count).value);
     if(con){
       required_quantity *= con;
     }
     if(order_quantity){
       required_quantity *= order_quantity;
     }
   document.getElementById("required_quantity_"+count).value = Math.round(required_quantity);
}

function checkboxCheck(value){

  if(value == '0') {
     document.getElementById('checkAllItem').value = '1';
     $("#item_list_div :checkbox").attr('checked', true);
  }
  else if (value == '1') {
     document.getElementById('checkAllItem').value = '0';
     $("#item_list_div :checkbox").attr('checked', false);
  }

}


//item description save Modal
function addNewItem(){
    document.getElementById('item_modal').style.display = "block";
}

function addNewItem_Two(){
    document.getElementById('item_modal').style.display = "block";
}

function close_item_modal(){
  document.getElementById('item_modal').style.display = "none";
  document.getElementById('item_name_input').value = '';
  document.getElementById('item_list_creation').innerHTML = '';

  var selectItem = '';

  $.get("ajax/all_item_list.php", function(data, status){

           var data = JSON.parse(data);

           var item_num = data.length;
           //alert(item_num);
           var item_num_per_col = parseInt(item_num/3);
           var extras = item_num%3;
           // var all_items = new Array();
           // var i = 1;
           // data.forEach(function(item){
           // //{
           //   all_items[] = item;
           //   i++;
           // });
           // console.log(all_items);
           if(extras==1){var col_item = item_num_per_col+1;var col_item2 = 2*item_num_per_col+1; }
           else if(extras==2){var col_item = item_num_per_col+1;var col_item2 = 2*item_num_per_col+2; }
           else{var col_item = item_num_per_col;var col_item2 = 2*item_num_per_col;}
           //alert(col_item2);

           selectItem +='<div class="col-md-4">';
           var i = 1;
           data.forEach(function(item){
             if(i <= col_item){
                  selectItem +='<div class="row">'
                              +'<div class="col-md-2">'
                              +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="item_'+item.id+'" value="'+item.id+'">'
                              +'</div>'
                              +'<div class="col-md-6">'
                              +'<text style="color:black;margin-left:10px;" id="item_name_'+item.id+'">'+item.name+'</text>'
                              +'</div>'
                              +'<div class="col-md-2">'
                              +'<input type="number" style="width:50px;height:20px;" name="item_quantity_'+item.id+'" id="item_quantity_'+item.id+'" value="1">'
                              +'</div>'
                              +'</div>';
                 }
                 i++;

           });
           selectItem +='</div>';

           selectItem +='<div class="col-md-4">';
           var j = 1;
           data.forEach(function(item){
             if(j > col_item && j <= col_item2){
                  selectItem +='<div class="row">'
                              +'<div class="col-md-2">'
                              +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="item_'+item.id+'" value="'+item.id+'">'
                              +'</div>'
                              +'<div class="col-md-6">'
                              +'<text style="color:black;margin-left:10px;" id="item_name_'+item.id+'">'+item.name+'</text>'
                              +'</div>'
                              +'<div class="col-md-2">'
                              +'<input type="number" style="width:50px;height:20px;" name="item_quantity_'+item.id+'" id="item_quantity_'+item.id+'" value="1">'
                              +'</div>'
                              +'</div>';
                 }
                 j++;

           });
           selectItem +='</div>';

           selectItem +='<div class="col-md-4">';
           var j = 1;
           data.forEach(function(item){
             if(j > col_item2 && j <= item_num){
                  selectItem +='<div class="row">'
                              +'<div class="col-md-2">'
                              +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="item_'+item.id+'" value="'+item.id+'">'
                              +'</div>'
                              +'<div class="col-md-6">'
                              +'<text style="color:black;margin-left:10px;" id="item_name_'+item.id+'">'+item.name+'</text>'
                              +'</div>'
                              +'<div class="col-md-2">'
                              +'<input type="number" style="width:50px;height:20px;" name="item_quantity_'+item.id+'" id="item_quantity_'+item.id+'" value="1">'
                              +'</div>'
                              +'</div>';
                 }
                 j++;

           });
           selectItem +='</div>';

           $('#item_list_creation').append(selectItem);
        });
}

function save_item_name(){
  var item_name = document.getElementById("item_name_input").value;
  $.post("ajax/add_item.php?item_name="+item_name, function(data, status){
           console.log(data);
           document.getElementById("item_output").innerHTML = data;
           document.getElementById("item_name_input").value = "";
        });
}

function addPoFunction(){
document.getElementById('po_modal').style.display = "block";
}

function addNewRow(){
  var count = document.getElementById('count').value;
              count++;
              document.getElementById('count').value = count;

  rowItem = '<tr>'
             +'<div style="width:60px">'
             +'<td style="color:black;" style="width:60px">'+count+'</td>'
             +'</div>'
             +'<td>'
             +'<select id="item_select_'+count+'" name="item_select_'+count+'" style="width:101px" onkeyup="changeFocus1('+count+')"  >'
             +'<?php echo $item_select_option; ?>'
             +'</select>'
             +'</td>'
             +'<td><input type="text" style="width:101px;" id="challan_'+count+'" name="challan_'+count+'" onkeyup="changeFocus2('+count+')"  ></td>'
             +'<td><input type="date" style="width:136px;" id="issue_date_'+count+'" name="issue_date_'+count+'" value="<?php echo date("Y-m-d"); ?>" onkeyup="changeFocus3('+count+')"  ></td>'

             +'<td>'
             +'<select id="line_select_'+count+'" name="line_select_'+count+'" style="width:101px" onkeyup="changeFocus4('+count+')"  >'
             +'<?php echo $line_select_option; ?>'
             +'</select>'
             +'</td>'
             +'<td>'
             +'<select id="style_select_'+count+'" name="style_select_'+count+'" onchange="updateStyle(this.value)" style="width:101px" onkeyup="changeFocus5('+count+')" >'
             +'<?php echo $style_select_option; ?>'
             +'</select>'
             +'</td>'

             +'<td>'
             +'<select id="po_select_'+count+'" name="po_select_'+count+'" onchange="updatePO(this.value)" style="width:101px" onkeyup="changeFocus6('+count+')"  >'
             +'<?php echo $po_select_option; ?>'
             +'</select>'
             +'</td>'

             +'<td><input type="date" style="width:136px;" id="pcd_'+count+'" name="pcd_'+count+'" value="<?php echo date("Y-m-d"); ?>" onchange="updatePCD(this.value)" onkeyup="changeFocus7('+count+')"  ></td>'
             +'<td><input type="date" style="width:136px;" id="tod_from_'+count+'" name="tod_from_'+count+'" value="<?php echo date("Y-m-d"); ?>" onchange="updateTODFrom(this.value)" onkeyup="changeFocus8('+count+')"  ></td>'
             +'<td><input type="date" style="width:136px;" id="tod_to_'+count+'" name="tod_to_'+count+'" value="<?php echo date("Y-m-d"); ?>" onchange="updateTODTo(this.value)" onkeyup="changeFocus9('+count+')"  ></td>'
             +'<td><input type="text" style="width:101px;" id="country_'+count+'" name="country_'+count+'" onkeyup="changeFocus10('+count+')" ></td>'

             +'<td>'
             +'<select id="supplier_select_'+count+'" name="supplier_select_'+count+'" style="width:101px" onkeyup="changeFocus11('+count+')" >'
             +'<?php echo $supplier_select_option; ?>'
             +'</select>'
             +'</td>'
             +'<td><input type="text" style="width:101px;" id="color_select_'+count+'" name="color_select_'+count+'" onkeyup="changeFocus12('+count+')" ></td>'
             +'<td><input type="text" style="width:91px;" id="size_select_'+count+'" name="size_select_'+count+'" onkeyup="changeFocus13('+count+')" ></td>'
             +'<td><input type="text" style="width:91px;" id="shade_select_'+count+'" name="shade_select_'+count+'" onkeyup="changeFocus14('+count+')" ></td>'

             +'<td><input type="text" style="width:91px;" id="ref_no_'+count+'" name="ref_no_'+count+'" onkeyup="changeFocus15('+count+')" ></td>'
             +'<td><input type="text" style="width:91px;" id="unit_type_'+count+'" name="unit_type_'+count+'" onkeyup="changeFocus16('+count+')" ></td>'
             +'<td><input type="number" style="width:91px;" id="con_'+count+'" name="con_'+count+'" step="0.01" value="'+cons+'" onkeyup="requiredQuantity('+count+'), changeFocus17('+count+')" ></td>'
             +'<td><input type="number" style="width:91px;" id="order_quantity_'+count+'" name="order_quantity_'+count+'" step="0.01" value="'+order_quantity+'" onkeyup="requiredQuantity('+count+'), changeFocus18('+count+')" ></td>'
             +'<td><input type="number" style="width:91px;" id="required_quantity_'+count+'" name="required_quantity_'+count+'" step="0.01" readonly ></td>'
             +'<td><input style="width:91px;" id="receive_cal_'+count+'" name="receive_cal_'+count+'" onkeyup="receiveCal(event, '+count+'),balanceQuantity('+count+')" ></td>'
             +'<td><input type="number" style="width:91px;" id="receive_quantity_'+count+'" name="receive_quantity_'+count+'" step="0.01" onkeyup="balanceQuantity('+count+'), changeFocus19('+count+')" ></td>'
             +'<td><input style="width:91px;" id="issue_cal_'+count+'" name="issue_cal_'+count+'" onkeyup="issueCal(event, '+count+'),balanceQuantity('+count+')" ></td>'
             +'<td><input type="number" style="width:91px;" id="total_issue_quantity_'+count+'" name="total_issue_quantity_'+count+'" step="0.01" onkeyup="balanceQuantity('+count+'),changeFocus20('+count+')" ></td>'
             +'<td><input type="number" style="width:91px;" id="balance_quantity_'+count+'" name="balance_quantity_'+count+'" step="0.01" onkeyup="changeFocus21('+count+')" ></td>'
             +'<td><input type="text" style="width:91px;" id="remarks_'+count+'" name="remarks_'+count+'" onkeyup="changeFocus22('+count+')" ><input type="hidden" style="width:91px;" value="'+count+'" id="count" name="count" ></td>'

             +'</tr>';

  rowItem2 = '<tr>'
             +'<td style="color:black;width:60px">'+count+'</td>'
             +'<td>'
             +'<select id="item_select_'+count+'" name="item_select_'+count+'" width="101px" readonly>'
             +'<?php echo $item_select_option; ?>'
             +'</select>'
             +'</td>'
             +'</tr>';

             $('#add_row_table').append(rowItem);
             $('#add_row_table2').append(rowItem2);
}


function updateStyle(value){
  var myCount = parseInt(document.getElementById("count").value);

  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('style_select_'+i).value = value;
  }
}

function updatePO(value){
  var myCount = parseInt(document.getElementById("count").value);

  for(var i = 1; i<=myCount; i++)
  {
      document.getElementById('po_select_'+i).value = value;
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
      document.getElementById('color_select_'+i).value = value;
  }
}

function myFunction() {
  var elmnt = document.getElementById("form_2");
  var itemName = document.getElementById("itemName");
  var itemNameHeader = document.getElementById("itemNameHeader");
  var headerName = document.getElementById("headerName");
  var x = elmnt.scrollLeft;
  var y = elmnt.scrollTop;
  // document.getElementById ("demo").innerHTML = "Horizontally: " + x + "px<br>Vertically: " + y + "px";
  document.getElementById("itemName").style.left = x;
  document.getElementById("headerName").style.top = y-10;
  document.getElementById("itemNameHeader").style.left = x;
  document.getElementById("itemNameHeader").style.top = y-10;
  //document.getElementById("itemName").style.color = "blue";
  if (x > 55) {
    itemName.classList.add("sticky");
  } else {
    itemName.classList.remove("sticky");
  }
  if (y > 20) {
    headerName.classList.add("sticky2");
  } else {
    headerName.classList.remove("sticky2");
  }
  if (x > 55 && y > 20) {
    itemNameHeader.classList.add("sticky3");
  } else {
    itemNameHeader.classList.remove("sticky3");
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
// function gotFocus1(index){
//   document.getElementById("item_select_"+index).style.backgroundColor = "red";
//   document.getElementById("item_select_"+index).style.color = "white";
// }
//
// function lostFocus1(index){
//   document.getElementById("item_select_"+index).style.backgroundColor = "white";
//   document.getElementById("item_select_"+index).style.color = "black";
// }
// function gotFocus2(index){
//   document.getElementById("challan_"+index).style.backgroundColor = "red";
//   document.getElementById("challan_"+index).style.color = "white";
// }
//
// function lostFocus2(index){
//   document.getElementById("item_select_"+index).style.backgroundColor = "white";
//   document.getElementById("item_select_"+index).style.color = "black";
// }
// function gotFocus3(index){
//   document.getElementById("issue_date_"+index).style.backgroundColor = "red";
//   document.getElementById("issue_date_"+index).style.color = "white";
// }
//
// function lostFocus3(index){
//   document.getElementById("challan_"+index).style.backgroundColor = "white";
//   document.getElementById("challan_"+index).style.color = "black";
//   document.getElementById("line_select_"+index).style.backgroundColor = "white";
//   document.getElementById("line_select_"+index).style.color = "black";
// }
// function gotFocus4(index){
//   document.getElementById("line_select_"+index).style.backgroundColor = "red";
//   document.getElementById("line_select_"+index).style.color = "white";
// }
//
// function lostFocus4(index){
//   document.getElementById("issue_date_"+index).style.backgroundColor = "white";
//   document.getElementById("issue_date_"+index).style.color = "black";
// }
</script>
