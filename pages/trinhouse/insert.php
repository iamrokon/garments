<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/trims_inhouse/insert.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/item/select.php'; ?>
<?php require_once '../../DB/supplier/select.php'; ?>

<?php
$user_id = $_SESSION['id'];
$style_select_option     = '<option value="">Select Style</option>';
$po_select_option        = '<option value="">Select PO</option>';
$line_select_option      = '<option value="">Select Line</option>';
$item_select_option      = '<option value="">Select Item</option>';
$supplier_select_option  = '<option value="">Select Supplier</option>';

$select_supplier = new select_supplier();
$supplier_list = $select_supplier->select_all();

while ($row = mysqli_fetch_assoc($supplier_list))
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
$item_list = $select_item->select_all();

while ($row = mysqli_fetch_assoc($item_list))
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


$obInsert = new insert();

if (isset($_POST['btn'])) {

      $challan = $_POST['challan'];
      $iissuedate  = $_POST['iissuedate'];
      $item_name = $_POST['item_name'];
      $line_number  = $_POST['line_number'];
      $style_name = $_POST['style_name'];
      $po_number  = $_POST['po_number'];
      $pcd = $_POST['pcd'];
      $tod  = $_POST['tod'];
      $supplier = $_POST['supplier'];
      $item_color  = $_POST['item_color'];
      $size = $_POST['size'];
      $shade  = $_POST['shade'];
      $ref_no = $_POST['ref_no'];
      $unit_type  = $_POST['unit_type'];
      $actual_quantity = $_POST['actual_quantity'];
      $required_quantity  = $_POST['required_quantity'];
      $total_issue_quantity = $_POST['total_issue_quantity'];
      $balance_quantity  = $_POST['balance_quantity'];
      $remarks = $_POST['remarks'];


      for ($i = 0; $i < count($challan); $i++) {

          $mgs = $obInsert->save(
                                 $_POST['challan'][$i],
                                 $_POST['iissuedate'][$i],
                                 $_POST['item_name'][$i],
                                 $_POST['line_number'][$i],
                                 $_POST['style_name'][$i],
                                 $_POST['po_number'][$i],
                                 $_POST['pcd'][$i],
                                 $_POST['tod'][$i],
                                 $_POST['supplier'][$i],
                                 $_POST['item_color'][$i],
                                 $_POST['size'][$i],
                                 $_POST['shade'][$i],
                                 $_POST['ref_no'][$i],
                                 $_POST['unit_type'][$i],
                                 '0',
                                 $_POST['actual_quantity'][$i],
                                 $_POST['required_quantity'][$i],
                                 $_POST['total_issue_quantity'][$i],
                                 $_POST['balance_quantity'][$i],
                                 $_POST['remarks'][$i],
                                 '0'
                                );
      }
}

if($mgs) {
  $_SESSION['message'] = $mgs;
  header("Location: insert.php"); // redirect back to your form
  exit;
}

?>

<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        color:black;
    }

    th, td {
        border: none;
        text-align: left;
        padding: 4px;
    }

    tr:nth-child(even){background-color: #f2f2f2}


    #tot {
        position: fixed;
        bottom: 0;
        width: 100%;
    }
    .redSignal,.redSignal:focus {
        border-color: red;
    }
</style>



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
                        <input type="text" class="form-control" id="item_name_input" placeholder ="Enter Item Name" required="required">
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



<div id="supplier_modal" class="modal">

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
                        <input type="text" class="form-control" id="supplier_name_input" placeholder ="Enter Supplier Name" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="supplier_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_supplier_data" class="btn btn-gradient-03" type="submit" onclick="save_supplier_name()">Save</button>
<button id="close_supplier_btn" class="btn btn-gradient-05" type="submit" onclick="close_supplier_modal()">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>



<div class="content-inner">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
        <form method="post" action="" class="w3-animate-right">
            <div class="box-default">

                <!-- /.box-header -->

                <div class="box-body w3-card-4" style="padding:10px;margin:4px;">

                  <button type="" name="add_new_btn" id="add_new_item_btn" class="btn w3-pink" onclick="addNewItem()">
                      <i class="ace-icon la la-plus-square bigger-110"></i>
                      New Item
                  </button>

                  <button type="" name="add_supplier_btn" id="add_supplier_btn" class="btn w3-blue" onclick="addNewSupplier()">
                      <i class="ace-icon la la-plus-square bigger-110"></i>
                      New Supplier
                  </button>

                  <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 3px; margin-top: 3px;">
                      <h3 class="box-title"></h3>
                      <span style="font-size: 12px;color: #fff">
                          Insert Trims Inhouse <label></label>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x:auto;">
                                <table>
                                    <thead >
                                        <tr class="btn-info" style="font-size:12;">
                                            <th>SL</th>
                                            <th>Challan No</th>
                                            <th>Issue Date</th>
                                            <th>Item Name</th>
                                            <th>Line No.</th>
                                            <th>Style Name</th>
                                            <th>P.O.</th>
                                            <th>PCD</th>
                                            <th>TOD</th>
                                            <th>Supplier</th>
                                            <th>Item Color</th>
                                            <th>Size</th>
                                            <th>Shade</th>
                                            <th>Ref. No.</th>
                                            <th>Unit Type</th>
                                            <th>Actual Quantity</th>
                                            <th>Required Quantity</th>
                                            <th>Total Issue Quantity</th>
                                            <th>Balance Quantity</th>
                                            <th>Remarks</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chalanInfo">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix form-actions" style="margin-top:20px;">
                        <div class="col-md-offset-5 col-md-7">
                          <button type="" name="add_new_btn" id="add_new_btn" class="btn btn-success" onclick="addNewRow()">
                              <i class="ace-icon la la-plus-square bigger-110"></i>
                              New Row
                          </button>
                            <button type="submit" name="btn" class="btn btn-info">
                                <i class="ace-icon la la-check-circle bigger-110"></i>
                                Submit
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" type="reset">
                                <i class="ace-icon la la-undo bigger-110"></i>
                                Reset
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
</div>
<div style="display: none;">
    <table class="table table-bordered table-striped table-hover" style="margin-top: 40px;">
        <tr id="dd">
             <td style="text-align:center" class="tr_sl_no"></td>
             <td><input id="'{TRID}spcode'" type="text" name="challan[]" class="challan" style="width: 100px;font-size:12px;"  onkeyup="showHeadInfo(this.value, '{TRID}');" required=""></td>
             <td><input type="date" name="iissuedate[]" class="iissuedate" value="<?php echo date("Y-m-d"); ?>" style="width: 120px;font-size:12px;" tabindex="1" required=""></td>

             <td>
               <select name="item_name[]" class="item_name" required="">
               <?php echo $item_select_option; ?>
               </select>
             </td>

             <td>
                 <select name="line_number[]" class="line_number" required="">
                 <?php echo $line_select_option; ?>
                 </select>
             </td>

             <td>
                  <select name="style_name[]" class="style_name" required="">
                  <?php echo $style_select_option; ?>
                  </select>
             </td>

             <td>
               <select name="po_number[]" class="po_number" required="">
               <?php echo $po_select_option; ?>
               </select>
             </td>

             <td><input type="date" name="pcd[]" class="pcd" value="<?php echo date("Y-m-d"); ?>" style="width: 120px;font-size:12px;" tabindex="1" required=""></td>
             <td><input type="date" name="tod[]" class="tod" value="<?php echo date("Y-m-d"); ?>" style="width: 120px;font-size:12px;" tabindex="1" required=""></td>

             <td>
               <select name="supplier[]" class="supplier" required="">
               <?php echo $supplier_select_option; ?>
               </select>
             </td>

             <td>
                <input type="text" name="item_color[]" class="item_color"  style="width: 100px;font-size:12px;" tabindex="4" required="">
             </td>

             <td><input type="text" name="size[]" class="size" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="shade[]" class="shade" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="ref_no[]" class="ref_no" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="unit_type[]" class="unit_type" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="actual_quantity[]" class="actual_quantity" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="required_quantity[]" class="required_quantity" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="total_issue_quantity[]" class="total_issue_quantity" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="balance_quantity[]" class="balance_quantity" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>
             <td><input type="text" name="remarks[]" class="remarks" style="width: 90px;font-size:12px;" tabindex="3" required=""></td>

             <td style="width: 40px;">
                <a href="javascript:removeThisTrFromVoucherList('{TRID}');"
                   class="btn badge-text badge-text-small danger">
                    <i class="la la-trash-o" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    </table>
</div>
<script>

   var tr_sl_start = 0;
   var jsonData;

   var styleDropdown = '<option value="">Select Style</option>';

   $(document).ready(function () {
      voucherEntyrListNew();
   });


   function voucherEntyrListNew() {

       //if(tr_sl_start <= 90){

        var trFr = $('#dd').html();
        var trID = makeUniqueString();
        trFr = trFr.replace(new RegExp("{TRID}", 'g'), trID);

        $("#chalanInfo").append('<tr id="' + trID + '" class="voucherRow">' + trFr + '</tr>');
        var len = document.getElementsByClassName("challan").length;
        document.getElementById(document.getElementsByClassName("challan")[len-2].id).focus();

        setTrSerial();

        //}
    }

    $.get("ajax/all_line_list.php", function(data, status){

             console.log("Line Number : "+data);
             jsonData = JSON.parse(data);

          });

    function makeUniqueString() {
        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 7; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }

    function setTrSerial() {
        tr_sl_start = 1;
        $('.tr_sl_no').each(function () {
            $(this).html(tr_sl_start);
            tr_sl_start++;
        });
    }

    function removeThisTrFromVoucherList(trID) {
        $('#' + trID).remove();
        setTrSerial();
    }

    function addNewRow(){
      voucherEntyrListNew();
    }

    function addNewItem(){
        document.getElementById('item_modal').style.display = "block";
    }

    function close_item_modal(){
      document.getElementById('item_modal').style.display = "none";
      document.getElementById('item_name_input').value = '';
    }

    function save_item_name(){
      var item_name = document.getElementById("item_name_input").value;
      $.post("ajax/add_item.php?item_name="+item_name, function(data, status){
               console.log(data);
               document.getElementById("item_output").innerHTML = data;
               document.getElementById("item_name_input").value = "";
            });
    }


    //supplier modal funtionality
    function addNewSupplier(){
        document.getElementById('supplier_modal').style.display = "block";
    }

    function close_supplier_modal(){
      document.getElementById('supplier_modal').style.display = "none";
      document.getElementById('supplier_name_input').value = '';
    }

    function save_supplier_name(){
      var supplier_name = document.getElementById("supplier_name_input").value;
      $.post("ajax/add_supplier.php?supplier_name="+supplier_name, function(data, status){
               console.log(data);
               document.getElementById("supplier_output").innerHTML = data;
               document.getElementById("supplier_name_input").value = "";
            });
    }


     function showHeadInfo(bCode, rowId) {


     }


</script>
