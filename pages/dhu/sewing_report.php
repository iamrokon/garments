<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/dhu/insert.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/rejection/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>

<?php

$user_id = $_SESSION['id'];

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectRejection = new select_rejection();
$rejection_list =  $selectRejection->select_all();

$selectLine = new select_line();
$line_list =  $selectLine->select_all();

$dhuInsert = new insert();

if (isset($_POST['btn'])) {
$sewing_dhu_report_id = $dhuInsert->save_sewing_dhu_report($_POST);

//insert dhu detail child when dhu id created inserted
if($sewing_dhu_report_id != null && $sewing_dhu_report_id > 0)
{
    $rejectCount = $_POST['rejectCount'];

    for($i=1;$i<=$rejectCount;$i++)
    {
      //if($_POST['quantity_'.$i] > 0){

      $message = $dhuInsert->save_sewing_dhu_report_details(
                                     $sewing_dhu_report_id,
                                     $_POST['rejection_'.$i],
                                     $_POST['front_'.$i],
                                     $_POST['back_'.$i],
                                     $_POST['waist_band_'.$i],
                                     $_POST['output_top_side_'.$i],
                                     $_POST['total_'.$i],
                                     $_POST['process_percent_'.$i],
                                     $_POST['fixed_value_'.$i]
                                   );
       //}
    }
    for($j=1;$j<=3;$j++)
        {

          $message = $dhuInsert->save_sewing_dhu_report_totals(
                                         $sewing_dhu_report_id,
                                         $_POST['rejection2_'.$j],
                                         $_POST['front2_'.$j],
                                         $_POST['back2_'.$j],
                                         $_POST['waist_band2_'.$j],
                                         $_POST['output_top_side2_'.$j],
                                         $_POST['total2_'.$j],
                                         $_POST['process_percent2_'.$j],
                                         $_POST['fixed_value2_'.$j]
                                       );
        }
    $styleCount = $_POST['styleCount'];
    // for($k=1;$k<=$styleCount;$k++)
    // {
    //   $message = $dhuInsert->save_dhu_category_details(
    //                                                        $dhu_id,
    //                                                        $_POST['style_id_'.$k],
    //                                                        $_POST['input_quantity_'.$k],
    //                                                        $_POST['remarks_'.$k]
    //                                                       );
    // }

}

if($message){
   $_SESSION['message'] = $message;
   header("Location: sewing_report.php"); // redirect back to your form
   exit;
}

}
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    DHU Plan <label></label>
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


<!-- modal for add style addition -->
<div id="rejection_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Rejection Category <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="rejection_name_input" placeholder ="Enter Rejection Category Name" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="rejection_category_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_rejection_category_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_rejection_category_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

              <div class="row">

                <div class="col-md-6">
                <div class="input-group margin" style="margin-left: 15px">
                                  <label class="form-control-label btn btn-success" style="margin-right:70px;">Date <span style="color: red">*</span></label>
                                  <input class="form-control col-md-6" type="date" name="date" id="date"></input>
                </div>

                </div>

             </div>

             <br>



             <!-- modal for add style addition -->
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
                                                  <input type="text" class="form-control" id="style_name_input" placeholder ="Enter Style Name" required="required">
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



             <div class="row">
                 <div class="col-md-6">
                   <div class="input-group margin" style="margin-top: 0px">
                                     <label class="form-control-label btn btn-success" style="margin-right:20px;">Style Name <span style="color: red">*</span></label>
                                     <select class="col-md-6" name="style_select" id="style_select">
                                     <option>Select Name</option>

                                     <?php
                                       while ($row = mysqli_fetch_assoc($style_list))
                                           {
                                     ?>
                                     <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                                     <?php
                                           }
                                     ?>
                                   </select>
                                   <button id="add_style" type="button" class="btn btn-danger center-block">+</button>
                   </div>


                 </div>
               </div>


            <br>

            <label class="form-control-label btn btn-success" style="margin-left:10px;margin-top:10px;">Rejection Category</label><button id="add_rejection" type="button" class="btn btn-danger center-block">+</button>
            <div id="rejection_list_div" style="margin-left:17px;">
            <input id="checkAllRejection" value="0" style="margin-left:10px;height:20px;width:20px;" type="checkbox"><text style="color:black;">  All</text>
            <div class="row" id="rejection_list_creation">
            <?php
                  while ($row = mysqli_fetch_assoc($rejection_list))
                       {
            ?>
            <div class="col-md-3">
            <input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="<?php echo "process_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
            <text style="color:black;" id="<?php echo "process_value_".$row['id']; ?>">  <?php echo $row['name']; ?></text>
            </div>
            <?php
                       }
             ?>
            </div>
            </div>

            <br>

            <label class="form-control-label btn btn-success" style="margin-left:10px;margin-top:10px;">Line No</label>
            <!-- <button id="add_rejection" type="button" class="btn btn-danger center-block">+</button> -->
            <div id="line_list_div" style="margin-left:17px;">
              <input id="checkAllLine" value="0" style="margin-left:10px;height:20px;width:20px;" type="checkbox"><text style="color:black;">  All</text>
              <div class="row" id="line_list_creation">
              <?php
                    while ($row = mysqli_fetch_assoc($line_list))
                         {
              ?>
              <div class="col-md-3">
              <input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="<?php echo "process_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
              <text style="color:black;" id="<?php echo "process_value_".$row['id']; ?>">  <?php echo $row['name']; ?></text>
              </div>
            <?php
                       }
             ?>
            </div>
            </div>

            <br>

            <br>


            <div class="text-center" style="padding-bottom: 10px;">
            <button id="add_btn" type="button" class="btn btn-danger center-block">Create Form</button>
            </div>
       </div>

<div id="order_sheet">

  <div style="display:none;" id="form_2" class="box-body">
      <form method="post" enctype="multipart/form-data" action="" class="needs-validation w3-card-4" novalidate>

        <!-- login user id is hidden here -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <!-- <input type="hidden" id="styleCount" value="0" name="styleCount"> -->
        <input type="hidden" id="rejectCount" value="0" name="rejectCount">
        <input type="hidden" id="date" value="0" name="date">

         <!-- <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">
          <div class="col-md-8">
           <h3 style="float:left;margin-left: 15px;">Style:</h3>
           <div id="style_show" style="margin-left: 25px;float:left;">


           </div>
         </div>
          <div class="col-md-4">
           <h3 style="float:left;margin-left: 15px;">Date:</h3>
           <div id="date_show" style="margin-left: 25px;float:left;">


           </div>
         </div>
         </div>

         <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">
            <div class="col-md-8">
             <h3 style="float:left;margin-left: 15px;">Line:</h3>
             <div id="line_show" style="margin-left: 25px;float:left;">


             </div>
           </div>
         </div> -->

         <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">
           <div class="table-responsive" id="custom_table" style="margin:15px;">


           </div>

         </div>


<div class="text-center" style="padding-bottom: 10px;">
<button name="btn" class="btn btn-gradient-03" type="submit">Save Info</button>
</div>


</form>

</div>

</div>

</div>
</div>
</div>

<script>

$(document).ready(function () {

     $('#checkAllRejection').click(function () {
            $("#rejection_list_div :checkbox").attr('checked', true);
     });
     $('#checkAllLine').click(function () {
            $("#line_list_div :checkbox").attr('checked', true);
     });


     //add rejection modal
     document.getElementById("add_rejection").onclick = function() {
        document.getElementById('rejection_modal').style.display = "block";
     }

     document.getElementById("add_rejection_category_data").onclick = function() {

       var name = document.getElementById("rejection_name_input").value;
       $.post("ajax/add_rejection_name.php?name="+name, function(data, status){
                console.log(data);
                document.getElementById("rejection_category_output").innerHTML = data;
                document.getElementById("rejection_name_input").value = "";
             });

     }

     document.getElementById("close_rejection_category_btn").onclick = function() {
        document.getElementById('rejection_modal').style.display = "none";
        location.reload();
     }



     var rejection_list = [];

     $.get("ajax/all_rejection_list.php", function(data, status){
           rejection_list = JSON.parse(data);
          });


     var line_list = [];

     $.get("ajax/all_line_list.php", function(data, status){
           line_list = JSON.parse(data);
          });



  $("#add_btn").click(function() {

       document.getElementById("add_btn").disabled = true;

       document.getElementById("form_1").style.display = "none";
       document.getElementById("form_2").style.display = "block";

       document.getElementById("mgs").style.display = "none";


       //alert(styleName);

       var selectedLine = [];
       $('#line_list_div input:checked').each(function () {
        selectedLine.push($(this).attr('value'));
       });

       //var lineTableStyle = "";

       var rejectionTableData2 = "";

       var i = 1;
       var k = 1;
       var l = 1;

        selectedLine.forEach(function(line) {
          if(line != '0'){
            //alert(line);
            var lineNameString = "";
            line_list.forEach(function(lineName) {
                 if(lineName.id == line){
                   lineNameString = lineName.name;
                }
            });
            //alert(lineNameString);




           var rejectionTableData = "";

            var selectedRejection = [];

            $('#rejection_list_div input:checked').each(function () {
             selectedRejection.push($(this).attr('value'));
            });

            var styleName = $("#style_select option:selected").text();
            var style = $("#style_select option:selected").val();
            var selectedDate = $('#date').val();

            selectedRejection.forEach(function(rejection) {
                      if(rejection != '0'){
                        document.getElementById('rejectCount').value = k;
                        var rejectionNameString = "";
                        //var lineTableData = "";

                        rejection_list.forEach(function(rejectionName) {
                             if(rejectionName.id == rejection)
                               rejectionNameString = rejectionName.name;
                        });

                      rejectionTableData += '<tr>'
                                               +'<td style="width:40px;" class="btn-gradient-02 text-center">'
                                               + rejectionNameString
                                               + '<input type="hidden" value="'+rejection+'" name="rejection_'+k+'"></input>'
                                               + '</td>'
                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="front_'+k+'" id="front_'+k+'" onkeyup="totalColQuantity('+k+') ,totalQuantity('+k+')">'
                                               +'</input>'
                                               + '</td>'

                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="back_'+k+'" id="back_'+k+'" onkeyup="totalColQuantity('+k+') ,totalQuantity('+k+')">'
                                               +'</input>'
                                               + '</td>'

                                               // +'<td class="text-center">'
                                               // + '<input required type="number" name="quantity_'+i+'" id="quantity_'+i+'" onfocus="gotFocus('+i+')" onfocusout="lostFocus('+i+')" onkeyup="totalQuantity('+i+'),countryWiseTotal('+country+','+i+','+k+'),changeFocus('+i+')" style="width:60px;" value="0"></input>'
                                               // + '<input type="hidden" name="country_input_'+i+'" style="width:60px;" value="'+country+'"></input>'
                                               // + '<input type="hidden" name="size_'+i+'" style="width:60px;" value="'+size+'"></input>'
                                               // + '</td>'

                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="waist_band_'+k+'" id="waist_band_'+k+'" onkeyup="totalColQuantity('+k+') ,totalQuantity('+k+')">'
                                               +'</input>'
                                               + '</td>'

                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="output_top_side_'+k+'" id="output_top_side_'+k+'" onkeyup="totalColQuantity('+k+') ,totalQuantity('+k+')">'
                                               +'</input>'
                                               + '</td>'

                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="total_'+k+'" id="total_'+k+'">'
                                               +'</input>'
                                               + '</td>'

                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="process_percent_'+k+'" id="process_percent_'+k+'">'
                                               +'</input>'
                                               + '</td>'

                                               +'<td style="width:40px;">'
                                               + '<input class="text-center" type="number" style="width:80px;" value="" name="fixed_value_'+k+'" id="fixed_value_'+k+'" onkeyup="processPercentage('+k+')">'
                                               +'</input>'
                                               + '</td>'
                                               + '</tr>';
                                               k++;
                         }

                      });

                      var rejection2 = ["process_pass_qty", "process_defect_qty", "process_def_percent"];
                       var rejection2_name = ["Process Wise Pass Qty", "Process Wise Defects Qty", "Process Wise Defects %"];
                       while (l < 4) {
                       rejectionTableData2 += '<tr>'
                                                +'<td style="width:40px;" class="btn-gradient-02 text-center">'
                                                + rejection2_name[l-1]
                                                + '<input type="hidden" value="'+rejection2[l-1]+'" name="rejection2_'+l+'"></input>'
                                                + '</td>'
                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="front2_'+l+'" id="front2_'+l+'" onkeyup="totalColQuantity('+l+') , process_def_per('+l+')">'
                                                +'</input>'
                                                + '</td>'

                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="back2_'+l+'" id="back2_'+l+'" onkeyup="totalColQuantity('+l+') ,totalQuantity('+l+')">'
                                                +'</input>'
                                                + '</td>'

                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="waist_band2_'+l+'" id="waist_band2_'+l+'" onkeyup="totalColQuantity('+l+') ,totalQuantity('+l+')">'
                                                +'</input>'
                                                + '</td>'

                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="output_top_side2_'+l+'" id="output_top_side2_'+l+'" onkeyup="totalColQuantity('+l+') ,totalQuantity('+l+')">'
                                                +'</input>'
                                                + '</td>'

                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="total2_'+l+'" id="total2_'+l+'">'
                                                +'</input>'
                                                + '</td>'

                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="process_percent2_'+l+'" id="process_percent2_'+l+'">'
                                                +'</input>'
                                                + '</td>'

                                                +'<td style="width:40px;">'
                                                + '<input class="text-center" type="number" style="width:80px;" value="" name="fixed_value2_'+l+'" id="fixed_value_'+l+'" onkeyup="processPercentage('+l+')">'
                                                +'</input>'
                                                + '</td>'
                                                + '</tr>';
                                                l++;
                                    }

                                    var table = '<table class="w3-table-all w3-small" border="1">'
                                               +'<thead style="background-color:gray;color:black;">'
                                               +'<tr class="btn-gradient-01">'
                                               +'<th style="width:80px;">'
                                               +'Line'
                                               +'</th>'
                                               +'<th class="text-center" style="width:80px;">'
                                               + '<input type="text" value="'+lineNameString+'"></input>'
                                               +'</th>'
                                               +'<th style="width:80px;">'
                                               +'Style'
                                               +'</th>'
                                               +'<th class="text-center" style="width:80px;">'
                                               + '<input type="hidden" value="'+line+'" name="line"></input>'
                                               + '<input type="text" value="'+styleName+'"></input>'
                                               +'</th>'

                                               +'<th style="width:80px;">'
                                               +'Date'
                                               +'</th>'
                                               +'<th class="text-center" style="width:80px;">'
                                               + '<input type="text" value="'+selectedDate+'"></input>'
                                               +'</th>'
                                               +'</tr>'

                                               +'<tr class="btn-gradient-01">'
                                               +'<th style="width:80px;">'
                                               +'DEFECTS NAME'
                                               +'</th>'


                                               +'<th class="text-center" style="width:80px;">'
                                               +'FRONT'
                                               +'</th>'

                                               +'<th class="text-center" style="width:80px;">'
                                               +'BACK'
                                               +'</th>'

                                               +'<th class="text-center" style="width:80px;">'
                                               +'WAIST BAND'
                                               +'</th>'

                                               +'<th class="text-center" style="width:80px;">'
                                               +'OUTPUT TOP SIDE'
                                               +'</th>'

                                               +'<th class="text-center" style="width:80px;">'
                                               +'TOTAL'
                                               +'</th>'

                                               +'<th class="text-center" style="width:80px;">'
                                               +'PROCESS WISE %'
                                               +'</th>'

                                               +'<th class="text-center" style="width:80px;">'
                                               +''
                                               +'</th>'

                                               +'</tr>'


                                               +'</thead>'

                                               +'<tbody>'

                                               + rejectionTableData
                                               + rejectionTableData2

                                               +'</tbody>'

                                               +'</table>'
                                                +'<br>'

                                      $('#custom_table').append(table);

                                      // var style_show = '<h3 style="color:#2c304d;">'
                                      //                   +styleName
                                      //                   + '<input type="hidden" value="'+style+'" name="style"></input>'
                                      //                   +'</h3>'
                                      // $('#style_show').append(style_show);
                                      //
                                      // var line_show = '<h3 style="color:#2c304d;">'
                                      //                   +lineNameString
                                      //                   + '<input type="hidden" value="'+line+'" name="line"></input>'
                                      //                   +'</h3>'
                                      // $('#line_show').append(line_show);
                                      //
                                      // var date_show = '<h3 style="color:#2c304d">'
                                      //                   +selectedDate
                                      //                   + '<input type="hidden" value="'+selectedDate+'" name="date"></input>'
                                      //                   +'</h3>'
                                      // $('#date_show').append(date_show);





          }
        });



                 // selectedRejection.forEach(function(rejection) {
                 //           if(rejection != '0'){
                 //
                 //               document.getElementById('rejectCount').value = i;
                 //
                 //               rejectionTableData +=    '<td style="width:40px;">'
                 //                                      + '<input class="text-center" type="number" style="width:80px;" value="" name="quantity_'+i+'">'
                 //                                      + '</input>'
                 //                                      + '<input type="hidden" value="'+rejection+'" name="rejection_'+i+'"></input>'
                 //                                      + '<input type="hidden" value="'+style+'" name="style_'+i+'"></input>'
                 //                                      + '</td>';
                 //
                 //                                      i++;
                 //                 }
                 //            });



               // rejectionTableStyle +=    '<tr>'
               //                          +'<td style="width:40px;" class="btn-gradient-02 text-center">'
               //                          + styleNameString
               //                          + '</td>'
               //                          + rejectionTableData
               //
               //                          +'<td style="width:40px;">'
               //                          + '<input class="text-center" type="number" style="width:80px;" value="" name="total_'+k+'">'
               //                          +'</input>'
               //                          + '<input type="hidden" value="'+style+'" name="style_id_'+k+'"></input>'
               //                          + '</td>'
               //
               //                          +'<td style="width:40px;">'
               //                          + '<input class="text-center" type="number" style="width:80px;" value="" name="input_quantity_'+k+'">'
               //                          +'</input>'
               //                          + '</td>'
               //
               //                          +'<td style="width:40px;">'
               //                          + '<input class="text-center" type="number" style="width:80px;" value="" name="reject_'+k+'">'
               //                          +'</input>'
               //                          + '</td>'
               //
               //                          +'<td style="width:40px;">'
               //                          + '<input class="text-center" type="number" style="width:80px;" value="" name="remarks_'+k+'">'
               //                          +'</input>'
               //                          + '</td>'
               //
               //                          + '</tr>';
               //
               //                          k++;
               //    }
               //
               // });





//alert(k-1);



   });
});

//var total_quantity = 0;
function process_def_per(count){
     var total_quantity = 0;
     var front_total = 0;
     var front_quantity1 = parseInt(document.getElementById("front2_1").value);
     var front_quantity2 = parseInt(document.getElementById("front2_2").value);
     if(front_quantity1){
       if(front_quantity2){
         front_defect_percent = front_quantity1;
       }
     }

     document.getElementById("front2_2").value = front_total;
   //   var rejectCount = parseInt(document.getElementById('rejectCount').value);
   //   var front_quantity = parseInt(document.getElementById("front_"+count).value);
   //   var back_quantity = parseInt(document.getElementById("back_"+count).value);
   //   var waist_band_quantity = parseInt(document.getElementById("waist_band_"+count).value);
   //   var output_top_side_quantity = parseInt(document.getElementById("output_top_side_"+count).value);
   //   if(front_quantity){
   //     total_quantity += front_quantity;
   //   }
   //   if(back_quantity){
   //     total_quantity += back_quantity;
   //   }
   //   if(waist_band_quantity){
   //     total_quantity += waist_band_quantity;
   //   }
   //   if(output_top_side_quantity){
   //     total_quantity += output_top_side_quantity;
   //   }
   // alert(rejectCount);
   // for(i=1; i<=rejectCount;i++){
   //   var front_quantity1 = parseInt(document.getElementById("front_"+i).value);
   //   if(front_quantity1){
   //     front_total += front_quantity1;
   //   }
   //
   //   document.getElementById("front2_2").value = front_total;
   // }
   // document.getElementById("total_"+count).value = total_quantity;
}
function totalQuantity(count){
     var total_quantity = 0;
     var front_total = 0;
     var rejectCount = parseInt(document.getElementById('rejectCount').value);
     var front_quantity = parseInt(document.getElementById("front_"+count).value);
     var back_quantity = parseInt(document.getElementById("back_"+count).value);
     var waist_band_quantity = parseInt(document.getElementById("waist_band_"+count).value);
     var output_top_side_quantity = parseInt(document.getElementById("output_top_side_"+count).value);
     if(front_quantity){
       total_quantity += front_quantity;
     }
     if(back_quantity){
       total_quantity += back_quantity;
     }
     if(waist_band_quantity){
       total_quantity += waist_band_quantity;
     }
     if(output_top_side_quantity){
       total_quantity += output_top_side_quantity;
     }
   //alert(rejectCount);
   for(i=1; i<=rejectCount;i++){
     var front_quantity1 = parseInt(document.getElementById("front_"+i).value);
     if(front_quantity1){
       front_total += front_quantity1;
     }

     document.getElementById("front2_2").value = front_total;
   }
   //console.log(rejectCount);
   document.getElementById("total_"+count).value = total_quantity;
}


function totalColQuantity(count){
   //   var total_quantity = 0;
   //   var front_total = 0;
   //   var rejectCount = parseInt(document.getElementById('rejectCount').value);
   //   //alert(rejectCount);
   //   var front_quantity = parseInt(document.getElementById("front_"+count).value);
   //   var back_quantity = parseInt(document.getElementById("back_"+count).value);
   //   var waist_band_quantity = parseInt(document.getElementById("waist_band_"+count).value);
   //   var output_top_side_quantity = parseInt(document.getElementById("output_top_side_"+count).value);
   //   if(front_quantity){
   //     f_total_quantity += front_quantity;
   //   }
   //   if(back_quantity){
   //     b_total_quantity += back_quantity;
   //   }
   //   if(waist_band_quantity){
   //     w_total_quantity += waist_band_quantity;
   //   }
   //   if(output_top_side_quantity){
   //     o_total_quantity += output_top_side_quantity;
   //   }
   // //alert(rejectCount);
   // for(i=1; i<=rejectCount;i++){
   //   var front_quantity1 = parseInt(document.getElementById("front_"+i).value);
   //   if(front_quantity1){
   //     front_total += front_quantity1;
   //   }
   //
   //   document.getElementById("front2_2").value = front_total;
   // }
   // //console.log(rejectCount);
   // document.getElementById("total_"+count).value = total_quantity;
}


function processPercentage(count){
     //var total_quantity = 0;
     var fixed_value_quantity = parseInt(document.getElementById("fixed_value_"+count).value);
     var total_quantity = parseInt(document.getElementById("total_"+count).value);
     if(fixed_value_quantity){
       process_percent_full = (total_quantity/fixed_value_quantity)*100;
       process_percent = Math.round(process_percent_full * 100) / 100;
     }

   //alert(k-1);
   document.getElementById("process_percent_"+count).value = process_percent;
   count +=1;
   for(i=1;i<count;i++){
     document.getElementById("fixed_value_"+i).value = fixed_value_quantity;
   }
}
//style modal
document.getElementById("add_style").onclick = function() {
   document.getElementById('style_modal').style.display = "block";
}

document.getElementById("close_s_btn").onclick = function() {
document.getElementById('style_modal').style.display = "none";
// document.getElementById('style_select').innerHTML = '';
//
// var selectStyle = '<option value="">Select Style</option>';
//
// $.get("ajax/all_style_list.php", function(data, status){
//          var data = JSON.parse(data);
//
//          data.forEach(function(style){
//            selectStyle +=  '<option value="'+style.id+'">'+style.style_name+'</option>';
//          });
//
//          $('#style_select').append(selectStyle);
//       });
}
</script>
