<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/iissue/insert.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>

<?php
$user_id = $_SESSION['id'];

$obScan = new insert();
$selectPO = new select_po();
$po_list =  $selectPO->select_all();

if (isset($_POST['btn'])) {

      // $pCode = $_POST['pCode'];
      $type = $_POST['type'];

      for ($i = 0; $i < count($type); $i++) {
          //$bundleCode = explode("-",$_POST['pCode'][$i]);
          $mgs = $obScan->save_iissue_info(
                                            $_POST['po'][$i],
                                            $_POST['cut_no_id'][$i],
                                            $_POST['type'][$i],
                                            $_POST['serial'][$i],
                                            $user_id
                                           );
      }
}

if($mgs) {
  $_SESSION['message'] = $mgs;
  header("Location: n_scan.php"); // redirect back to your form
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
<div class="content-inner">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
        <form method="post" action="" class="w3-animate-right">
            <div class="box-default">

                <!-- /.box-header -->

                <div class="box-body w3-card-4" style="padding:10px;margin:4px;">

                  <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 3px; margin-top: 3px;">
                      <h3 class="box-title"></h3>
                      <span style="font-size: 12px;color: #fff">
                          Issue Scan <label></label>
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
                                            <th>P.O.</th>
                                            <th>Cut No.</th>
                                            <th>Line</th>
                                            <th>Buyer</th>
                                            <th>Style</th>
                                            <th>Color</th>
                                            <th>Serial</th>
                                            <th>Quantity</th>
                                            <!-- <th>Size</th> -->
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
             <td>
              <select  name="po[]" class="pCode" id="spcode{TRID}" style="width: 100px;font-size:12px;" required="">
               <option>Select PO</option>
               <?php
                 while ($row = mysqli_fetch_assoc($po_list))
                     {
               ?>
               <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
               <?php
                     }
               ?>
             </select>
             </td>
             <!-- <td><input id="spcode{TRID}" type="text" name="po[]" class="pCode" style="width: 100px;font-size:12px;" required=""></td> -->
             <!-- <input type="hidden" name="po_id[]" class="po_id" style="width: 100px;font-size:12px;"> -->
             <td><input type="text" name="cut_no[]" class="cut_no" style="width: 90px;font-size:12px;" tabindex="3" onkeyup="showHeadInfo(this.value, '{TRID}');"></td>
             <input type="hidden" name="cut_no_id[]" class="cut_no_id" style="width: 90px;font-size:12px;" tabindex="3">
             <td>
               <select name="type[]" class="type" style="width: 80px;font-size:14px;" id="type" required="" onchange="updateLine(this.value)">
               </select>
             </td>
             <td><input type="text" name="buyer[]" class="buyer" style="width: 120px;font-size:12px;" tabindex="1"  readonly=""></td>
             <td><input type="text" name="style[]" class="style" style="width: 130px;font-size:12px;" tabindex="1"  readonly=""></td>
             <td><input type="text" name="color[]" class="color" style="width: 130px;font-size:12px;" tabindex="2"  readonly=""></td>
             <td><input type="text" name="serial[]" class="serial" style="width: 90px;font-size:12px;" tabindex="3"></td>
             <td><input type="text" name="quantity[]" class="quantity" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <!-- <td>
                <input type="text" name="size[]" class="size"  style="width: 100px;font-size:12px;" tabindex="4" readonly="">
             </td> -->

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

   $(document).ready(function () {
      voucherEntyrListNew();
   });

   function voucherEntyrListNew() {

       if(tr_sl_start <= 90){

        var trFr = $('#dd').html();
        var trID = makeUniqueString();
        trFr = trFr.replace(new RegExp("{TRID}", 'g'), trID);

        $("#chalanInfo").append('<tr id="' + trID + '" class="voucherRow">' + trFr + '</tr>');
        var len = document.getElementsByClassName("pCode").length;
        //document.getElementById(document.getElementsByClassName("pCode")[len-2].id).focus();

        setTrSerial();

        }
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

            if(tr_sl_start >= 91) alert('Maximum Limit Exceed !');
        });
    }

    function removeThisTrFromVoucherList(trID) {
        $('#' + trID).remove();
        rowIdExist = "";
        setTrSerial();
    }

    var rowIdExist;
     function showHeadInfo(cut_no, rowId) {

       var cutNo = cut_no;
       var PO = document.getElementById("spcode"+rowId).value;
       //alert(PO);
       // $.post("ajax/get_po_info_by_id.php?po="+PO, function(data, status){
         // var data =  JSON.parse(data);
         // var po_id = data['id'];

         $.post("ajax/get_cut_no_info_by_id.php?cut_no="+cutNo, function(data, status){
             var data =  JSON.parse(data);
             var cut_no_id = data['id'];

             $.post("ajax/get_cut_pro_info.php?cut_no="+cut_no_id+"&po="+PO, function(data2, status){
                 var data2 =  JSON.parse(data2);

                 // $('#' + rowId + ' .po_id').val(PO);
                 $('#' + rowId + ' .cut_no_id').val(cut_no_id);
                 $('#' + rowId + ' .buyer').val(data2['buyer_name']);
                 $('#' + rowId + ' .buyer').val(data2['buyer_name']);
                 $('#' + rowId + ' .style').val(data2['style_name']);
                 $('#' + rowId + ' .color').val(data2['color_name']);
                 $('#' + rowId + ' .quantity').val(data2['total_quantity_bundle']);
                 $('#' + rowId + ' .serial').val("1"+"-"+data2['total_quantity_bundle']);
               });

           // });



         });

       // $.post("ajax/get_cut_pro_info.php?cut_no="+cutNo+"&po="+PO, function(data, status){
       //   var data =  JSON.parse(data);
       //   alert(data['po']);
       //     // $('#' + rowId + ' .country').val(data['country_name']);
       //     // $('#' + rowId + ' .size').val(data['ticket_size']);
       //
       //   });

        // $.post("ajax/get_bundle_info.php?bundle_tkt="+id, function(data, status){
        //         var data =  JSON.parse(data);
        //         selectPart = "";
        //
        //         $('#' + rowId + ' .style').val(data['style_name']);
        //         $('#' + rowId + ' .buyer').val(data['buyer_name']);
        //         $('#' + rowId + ' .cut_no').val(data['cut_number']);
        //         $('#' + rowId + ' .color').val(data['color_name']);
        //         $('#' + rowId + ' .po').val(data['po']);
        //         $('#' + rowId + ' .serial').val(data['from_id']+"-"+data['to_id']);
        //         $('#' + rowId + ' .size').val(data['ticket_size']+"-"+data['label']);
        //         $('#' + rowId + ' .quantity').val(data['quantity']);
        //
                var selectPart = '';
                selectPart +=  '<option value="">Select Line</option>';

                jsonData.forEach(function(line){

                    selectPart +=  '<option value="'+line.id+'">'+line.name+'</option>';

                });

                $('#' + rowId + ' .type').append(selectPart);
        //
        //
                if(rowIdExist != rowId){
                  rowIdExist = rowId;
                  voucherEntyrListNew();
                }

        //      });
     }

     function updateLine(value){
       var x = document.getElementsByClassName("type");
       var i;
       for (i = 0; i < x.length; i++) {
         x[i].value = value;
       }

     }


</script>
