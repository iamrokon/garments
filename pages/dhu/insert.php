<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/dhu/insert.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/rejection/select.php'; ?>

<?php

$user_id = $_SESSION['id'];

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectRejection = new select_rejection();
$rejection_list =  $selectRejection->select_all();

$dhuInsert = new insert();

if (isset($_POST['btn'])) {
$dhu_id = $dhuInsert->save($_POST['user_id']);

//insert dhu detail child when dhu id created inserted
if($dhu_id != null && $dhu_id > 0)
{
    $rejectCount = $_POST['rejectCount'];

    for($i=1;$i<=$rejectCount;$i++)
    {
      if($_POST['quantity_'.$i] > 0){

      $message = $dhuInsert->save_dhu_child(
                                     $dhu_id,
                                     $_POST['rejection_'.$i],
                                     $_POST['style_'.$i],
                                     $_POST['quantity_'.$i]
                                   );
       }
    }

    $styleCount = $_POST['styleCount'];
    for($k=1;$k<=$styleCount;$k++)
    {
      $message = $dhuInsert->save_dhu_category_details(
                                                           $dhu_id,
                                                           $_POST['style_id_'.$k],
                                                           $_POST['input_quantity_'.$k],
                                                           $_POST['remarks_'.$k]
                                                          );
    }

}

if($message){
   $_SESSION['message'] = $message;
   header("Location: insert.php"); // redirect back to your form
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

             <label class="form-control-label btn btn-success" style="margin-left:10px;margin-top:10px;">Style List</label>
             <div id="style_list_div" style="margin-left:17px;">
             <input id="checkAllStyle" value="0" style="margin-left:10px;height:20px;width:20px;" type="checkbox"><text style="color:black;">  All</text>
             <div class="row" id="style_list_creation">
             <?php
                   while ($row = mysqli_fetch_assoc($style_list))
                        {
             ?>
             <div class="col-md-3">
             <input type="checkbox" style="margin-left:10px;height:20px;width:20px;"  class="checkItem" style="margin-right:5px;" name="<?php echo "process_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
             <text style="color:black;" id="<?php echo "process_value_".$row['id']; ?>">  <?php echo $row['style_name']; ?></text>
             </div>
             <?php
                        }
              ?>
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
        <input type="hidden" id="styleCount" value="0" name="styleCount">
        <input type="hidden" id="rejectCount" value="0" name="rejectCount">
        <input type="hidden" id="date" value="0" name="date">

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

     $('#checkAllStyle').click(function () {
         $("#style_list_div :checkbox").attr('checked', true);
     });

     $('#checkAllRejection').click(function () {
            $("#rejection_list_div :checkbox").attr('checked', true);
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


     var style_list = [];

     $.get("ajax/all_style_list.php", function(data, status){
           style_list = JSON.parse(data);
          });



  $("#add_btn").click(function() {

       document.getElementById("add_btn").disabled = true;

       document.getElementById("form_1").style.display = "none";
       document.getElementById("form_2").style.display = "block";

       document.getElementById("mgs").style.display = "none";

       var selectedRejection = [];

       $('#rejection_list_div input:checked').each(function () {
        selectedRejection.push($(this).attr('value'));
       });

       var selectedStyle = [];

       $('#style_list_div input:checked').each(function () {
        selectedStyle.push($(this).attr('value'));
       });

       var rejectionTableHeader = "";
       var rejectionTableStyle = "";

       var i = 1;
       var k = 1;

       selectedRejection.forEach(function(rejection) {
                 if(rejection != '0'){

                   var rejectionNameString = "";

                   rejection_list.forEach(function(rejectionName) {
                        if(rejectionName.id == rejection)
                          rejectionNameString = rejectionName.name;
                   });

                 rejectionTableHeader += '<th style="width:40px;" class="btn-gradient-02 text-center">'
                                          + rejectionNameString
                                          + '</th>';
                    }

                 });



                 selectedStyle.forEach(function(style) {
                           if(style != '0'){

                            document.getElementById('styleCount').value = k;

                             var styleNameString = "";
                             var rejectionTableData = "";

                             style_list.forEach(function(styleName) {
                                  if(styleName.id == style)
                                    styleNameString = styleName.style_name;
                             });


                             selectedRejection.forEach(function(rejection) {
                                       if(rejection != '0'){

                                           document.getElementById('rejectCount').value = i;

                                           rejectionTableData +=    '<td style="width:40px;">'
                                                                  + '<input class="text-center" type="number" style="width:80px;" value="" name="quantity_'+i+'">'
                                                                  + '</input>'
                                                                  + '<input type="hidden" value="'+rejection+'" name="rejection_'+i+'"></input>'
                                                                  + '<input type="hidden" value="'+style+'" name="style_'+i+'"></input>'
                                                                  + '</td>';

                                                                  i++;
                                             }
                                        });



                           rejectionTableStyle +=    '<tr>'
                                                    +'<td style="width:40px;" class="btn-gradient-02 text-center">'
                                                    + styleNameString
                                                    + '</td>'
                                                    + rejectionTableData

                                                    +'<td style="width:40px;">'
                                                    + '<input class="text-center" type="number" style="width:80px;" value="" name="total_'+k+'">'
                                                    +'</input>'
                                                    + '<input type="hidden" value="'+style+'" name="style_id_'+k+'"></input>'
                                                    + '</td>'

                                                    +'<td style="width:40px;">'
                                                    + '<input class="text-center" type="number" style="width:80px;" value="" name="input_quantity_'+k+'">'
                                                    +'</input>'
                                                    + '</td>'

                                                    +'<td style="width:40px;">'
                                                    + '<input class="text-center" type="number" style="width:80px;" value="" name="reject_'+k+'">'
                                                    +'</input>'
                                                    + '</td>'

                                                    +'<td style="width:40px;">'
                                                    + '<input class="text-center" type="number" style="width:80px;" value="" name="remarks_'+k+'">'
                                                    +'</input>'
                                                    + '</td>'

                                                    + '</tr>';

                                                    k++;
                              }

                           });



       var table = '<table class="w3-table-all w3-small" border="1">'

                  +'<thead style="background-color:gray;color:black;">'

                  +'<tr class="btn-gradient-01">'
                  +'<th style="width:80px;">'
                  +'Style'
                  +'</th>'

                  + rejectionTableHeader

                  +'<th class="text-center" style="width:80px;">'
                  +'Total'
                  +'</th>'

                  +'<th class="text-center" style="width:80px;">'
                  +'Input Quantity'
                  +'</th>'

                  +'<th class="text-center" style="width:80px;">'
                  +'Reject %'
                  +'</th>'

                  +'<th class="text-center" style="width:80px;">'
                  +'Remarks'
                  +'</th>'

                  +'</tr>'


                  +'</thead>'

                  +'<tbody>'

                  + rejectionTableStyle

                  +'</tbody>'

                  +'</table>'
                   +'<br>'

         $('#custom_table').append(table);

   });
});

</script>
