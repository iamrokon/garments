<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/wsend/insert.php'; ?>

<?php
$user_id = $_SESSION['id'];

$obScan = new insert();

if (isset($_POST['btn'])) {

      $pCode = $_POST['pCode'];
      $production_id = $_POST['production_id'];

      for ($i = 0; $i < count($pCode); $i++) {
          $mgs = $obScan->wsend_scan_code($pCode[$i],$production_id[$i],$user_id);
      }
}

if($mgs) {
  $_SESSION['message'] = $mgs;
  header("Location: scan.php"); // redirect back to your form
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
          <!-- <input id="myInput" value="Some text.."> -->
            <div class="box-default">

                <!-- /.box-header -->

                <div class="box-body w3-card-4" style="padding:10px;margin:4px;">

                  <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 3px; margin-top: 3px;">
                      <h3 class="box-title"></h3>
                      <span style="font-size: 12px;color: #fff">
                          Wash Send Scan <label></label>
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
                                            <th>QR</th>
                                            <th>Line No</th>
                                            <th>Style</th>
                                            <th>P.O.</th>
                                            <th>Color</th>
                                            <th>Total QTY</th>
                                            <th>Country</th>
                                            <th>Size</th>
                                            <th>Cut No.</th>
                                            <th>Bundle</th>
                                            <th>Tod</th>
                                            <th>Shipment</th>
                                            <th>Shade/Pattern</th>
                                            <!-- <th>SL No</th> -->
                                            <th>Srinkage</th>
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
             <td><input id="'{TRID}spcode'" type="text" name="pCode[]" class="pCode" style="width: 100px;font-size:12px;"  onkeyup="showHeadInfo(this.value, '{TRID}');" required=""></td>
             <td>
               <input type="text" name="line[]" class="line" style="width: 130px;font-size:12px;" tabindex="1"  readonly="">
               <input type="hidden" name="production_id[]" class="production_id">
             </td>
             <td><input type="text" name="style[]" class="style" style="width: 130px;font-size:12px;" tabindex="1"  readonly=""></td>
             <td><input type="text" name="po[]" class="po" style="width: 130px;font-size:12px;" tabindex="3" readonly=""></td>
             <td><input type="text" name="color[]" class="color" style="width: 130px;font-size:12px;" tabindex="2"  readonly=""></td>
             <td><input type="text" name="quantity[]" class="quantity" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <td><input type="text" name="country[]" class="country" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <td><input type="text" name="size[]" class="size"  style="width: 100px;font-size:12px;" tabindex="4" readonly=""></td>
             <td><input type="text" name="cut_no[]" class="cut_no" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <td><input type="text" name="bundle[]" class="bundle"  style="width: 100px;font-size:12px;" tabindex="4" readonly=""></td>
             <td><input type="text" name="tod[]" class="tod" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <td><input type="text" name="shipment[]" class="shipment" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <td><input type="text" name="shade[]" class="shade" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>
             <!-- <td><input type="text" name="serial[]" class="serial" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td> -->
             <td><input type="text" name="strinkage[]" class="strinkage" style="width: 90px;font-size:12px;" tabindex="3" readonly=""></td>


             <!-- <td><input type="text" name="type[]" class="type" style="width: 80px;font-size:12px;" tabindex="5" readonly=""></td> -->
             <!-- <td>
               <select name="type[]" class="type" style="width: 80px;font-size:14px;" id="type" readonly="">
               </select>
             </td> -->

             <td style="width: 100px;">
                <a href="javascript:removeThisTrFromVoucherList('{TRID}');"
                   class="btn badge-text badge-text-small danger" style="float:left">
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
        document.getElementById(document.getElementsByClassName("pCode")[len-2].id).focus();

        setTrSerial();

        }
    }

    $.get("ajax/all_process_c_list.php", function(data, status){
             console.log("Process C : "+data);

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
        setTrSerial();
    }
      var rowIdExist;
     function showHeadInfo(bCode, rowId) {

       var inputQrCode = base_convert(bCode,36,10);

       //codeArray = base_convert(1000,2,8)
       //alert(codeArray);
       //var codeArray = bCode.split("-");
       //var type = codeArray[1];

       //if(type != '' && type != null){

        //$.post("ajax/get_bundle_info.php?bundle_tkt="+codeArray[0], function(data, status){
        $.post("ajax/get_qr_code_info.php?bundle_tkt="+inputQrCode, function(data, status){
                var data =  JSON.parse(data);
                var cut_pro_quantity = inputQrCode - data['qr_code'];
                var production_id = data['id'];

                $('#' + rowId + ' .production_id').val(production_id);
                //selectPart = "";
                //alert(production_id);
                $.post("ajax/get_qr_code_child_info.php?cut_pro_quantity="+cut_pro_quantity+"&production_id="+production_id, function(data2, status){
                  var data2 =  JSON.parse(data2);
                  //alert(data2['country_name']);

                    $('#' + rowId + ' .country').val(data2['country_name']);
                    $('#' + rowId + ' .size').val(data2['ticket_size']);
                    $('#' + rowId + ' .serial').val(data2['from_id']+"-"+data2['to_id']);
                    $('#' + rowId + ' .shade').val(data2['shade_name']+"/"+data2['pattern']);

                    $.post("ajax/get_qr_code_child_info2.php?production_id="+production_id, function(data3, status){
                      var data3 =  JSON.parse(data3);
                      $('#' + rowId + ' .bundle').val(data2['bundle_no']+"/"+data3['bundle_no']);
                      //alert(data3['bundle_no');
                    });

                    var cut_pro_bundle_id = data2['id'];
                    $.post("ajax/get_qr_code_tod.php?production_id="+production_id+"&cut_pro_bundle_id="+cut_pro_bundle_id, function(data4, status){
                      var data4 =  JSON.parse(data4);
                      $('#' + rowId + ' .tod').val(data4['tod']);
                    });

                    //$childLineName = $selectCProduction->select_line_name_by_child_id($row_c['id']);
                    $.post("ajax/get_line_name.php?cut_pro_bundle_id="+cut_pro_bundle_id, function(data6, status){
                      var data6 =  JSON.parse(data6);
                      $('#' + rowId + ' .line').val(data6['line_name']);
                    });

                  });


                $.post("ajax/get_shipment_info.php?production_id="+production_id, function(data5, status){
                  var data5 =  JSON.parse(data5);
                  //alert(data5['po']);
                  $('#' + rowId + ' .shipment').val(data5['shipment']);
                });


                $('#' + rowId + ' .style').val(data['style_name']);
                $('#' + rowId + ' .po').val(data['po_number']);
                $('#' + rowId + ' .color').val(data['color_name']);
                $('#' + rowId + ' .cut_no').val(data['cut_number']);
                $('#' + rowId + ' .quantity').val(cut_pro_quantity);

                // var selectPart = '';
                //
                // jsonData.forEach(function(process){
                //
                //   if(process.id == type)
                // {
                //     selectPart +=  '<option value="'+process.id+'" selected="selected">'+process.name+'</option>';
                // } else {
                //     selectPart +=  '<option value="'+process.id+'">'+process.name+'</option>';
                // }
                //
                // });
                //
                // $('#' + rowId + ' .type').append(selectPart);

                   //voucherEntyrListNew();

                  //alert(rowIdExist + ", " + rowId);
                  if(rowIdExist != rowId){
                    rowIdExist = rowId;
                    voucherEntyrListNew();
                  }
                  // if(!rowIdExist){
                  //   var rowIdExist = rowId;
                  //   voucherEntyrListNew();
                  // }
                  // else {
                  //   if(rowIdExist != rowId){
                  //     voucherEntyrListNew();
                  //   }
                  // }
                  //alert(rowIdExist + ", " + rowId);
                  //alert(rowId);
             });

        //}
     }
   //   $('#myInput').on('keypress', function (e) {
   //       if(e.which === 13){
   //         //console.log("Hello world!");
   //         voucherEntyrListNew();
   //       }
   // });
   function newRow() {
      voucherEntyrListNew();
    }
     // var input = document.getElementById("pCode");
     //
     // input.addEventListener("keyup", function(event) {
     //   //alert();
     //  if (event.keyCode == 13) {
     //    //alert("a");
     //    voucherEntyrListNew();
     //  }
     // });

     var base_convert = function(number, initial_base, change_base) {
        if ((initial_base && change_base) <2 || (initial_base && change_base)>36)
         return 'Base between 2 and 36';

         return parseInt(number + '', initial_base)
         .toString(change_base);
     }


</script>
