<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/fin_plan/insert.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/unit/select.php'; ?>
<?php require_once '../../DB/process/select.php'; ?>
<?php require_once '../../DB/hour/select.php'; ?>

<?php

$user_id = $_SESSION['id'];

$selectUnit = new select_unit();
$unit_list =  $selectUnit->select_all();

$selectProcess = new select_process();
$process_list =  $selectProcess->select_all();

$selectHour = new select_hour();
$hour_list =  $selectHour->select_all();

$finPlanInsert = new insert();

if (isset($_POST['btn'])) {
$fin_plan_id = $finPlanInsert->save($_POST['user_id']);

//insert quantity of size when order inserted
if($fin_plan_id != null && $fin_plan_id > 0)
{
    $hourCount = $_POST['hourCount'];

    for($i=1;$i<=$hourCount;$i++)
    {
      if($_POST['quantity_input_'.$i] > 0){

      $message = $finPlanInsert->finishing_plan_hour_quantity_save(
                                                                   $fin_plan_id,
                                                                   $_POST['unit_id_'.$i],
                                                                   $_POST['hour_id_'.$i],
                                                                   $_POST['quantity_input_'.$i],
                                                                   $_POST['target_input_'.$i],
                                                                   $_POST['process_input_'.$i]
                                                                  );
       }
    }

    $unitCount = $_POST['unitCount'];
    for($k=0;$k<=$unitCount;$k++)
    {
      if($_POST['unit_id_plan_'.$k] > 0){
      $message = $finPlanInsert->finishing_planning_unit_save(
                                                              $fin_plan_id,
                                                              $_POST['unit_id_plan_'.$k],
                                                              $user_id
                                                             );
      }
    }

}

}
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: red;padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    Finishing Plan <label></label>
                </span>
                <h4 style="color: #fff; text-align: center" id="mgs">
                 <?php
                 if (isset($message)) {
                     echo $message;
                     unset($message);
                 }
                 ?>
                 </h4>
            </div>


  <!-- modal for add country addition -->
  <!-- The Modal -->
<div id="process_modal" class="modal">

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
                        <input type="text" class="form-control" id="process_name_input" placeholder ="Enter Process Name" required="required">
                    </div>

                </div>
                <label class="form-control-label" id="process_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_process_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_process_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>



<div id="unit_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Unit<span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="unit_name_input" placeholder ="Enter Unit Number" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="unit_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_unit_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_unit_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




<!-- modal for add style addition -->
<div id="hour_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Hour <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="hour_name_input" placeholder ="Enter Hour Name" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="hour_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_hour_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_hour_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

              <div class="row">

             </div>

             <br>

             <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Unit List</label><button id="add_unit" type="button" class="btn btn-danger center-block">+</button>
             <div id="unit_list_div">
             <input id="checkAllUnit" value="0" type="checkbox"><text style="color:black;">  All</text>
             <?php
                   while ($row = mysqli_fetch_assoc($unit_list))
                        {
             ?>
             <input type="checkbox"  class="checkItem" style="margin-left:10px;" name="<?php echo "unit_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
             <text style="color:black;" id="<?php echo "unit_value_".$row['id']; ?>">  <?php echo $row['name']; ?></text>
             <?php
                        }
              ?>
             </div>



            <br>

            <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Process List</label><button id="add_process" type="button" class="btn btn-danger center-block">+</button>
            <div id="process_list_div">
            <input id="checkAllProcess" value="0" type="checkbox"><text style="color:black;">  All</text>
            <?php
                  while ($row = mysqli_fetch_assoc($process_list))
                       {
            ?>
            <input type="checkbox"  class="checkItem" style="margin-left:10px;" name="<?php echo "process_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
            <text style="color:black;" id="<?php echo "process_value_".$row['id']; ?>">  <?php echo $row['name']; ?></text>
            <?php
                       }
             ?>
            </div>

            <br>

            <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Hour List</label><button id="add_hour" type="button" class="btn btn-danger center-block">+</button>
            <div id="hour_list_div">
            <input id="checkAllHour" value="0" type="checkbox"><text style="color:black;">  All</text>
            <?php
              while ($row = mysqli_fetch_assoc($hour_list))
                  {
            ?>
            <input type="checkbox"  class="checkItem" style="margin-left:10px;" name="<?php echo "hour_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
            <text style="color:black;">  <?php echo $row['name']; ?><text>
            <?php
                  }
            ?>
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
        <input type="hidden" id="count" value="0" name="count">
        <input type="hidden" id="unitCount" value="0" name="unitCount">
        <input type="hidden" id="hourCount" value="0" name="hourCount">
        <input type="hidden" id="targetCount" value="0" name="targetCount">

         <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

           <div class="table-responsive" id="order_table" style="margin:15px;">


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

  $('#checkAllUnit').click(function () {
         //$(':checkbox.checkItem').prop('checked', this.checked);
         $("#unit_list_div :checkbox").attr('checked', true);
     });


    $('#checkAllProcess').click(function () {
        $("#process_list_div :checkbox").attr('checked', true);
    });

    $('#checkAllHour').click(function () {
        $("#hour_list_div :checkbox").attr('checked', true);
    });

     //country modal
     document.getElementById("add_unit").onclick = function() {
        document.getElementById('unit_modal').style.display = "block";
     }

     document.getElementById("add_unit_data").onclick = function() {

       var unit_name = document.getElementById("unit_name_input").value;
       $.post("ajax/add_unit.php?unit="+unit_name, function(data, status){
                console.log(data);
                document.getElementById("unit_output").innerHTML = data;
                document.getElementById("unit_name_input").value = "";
             });

     }

     document.getElementById("close_unit_btn").onclick = function() {
        document.getElementById('unit_modal').style.display = "none";
        location.reload();
     }

     //style modal
     document.getElementById("add_process").onclick = function() {
        document.getElementById('process_modal').style.display = "block";
     }

     document.getElementById("add_process_data").onclick = function() {

       var process = document.getElementById("process_name_input").value;
       $.post("ajax/add_process.php?process="+process, function(data, status){
                console.log(data);
                document.getElementById("process_output").innerHTML = data;
                document.getElementById("process_name_input").value = "";
             });

     }

     document.getElementById("close_process_btn").onclick = function() {
        document.getElementById('process_modal').style.display = "none";
        location.reload();
     }


     //po modal
     document.getElementById("add_hour").onclick = function() {
        document.getElementById('hour_modal').style.display = "block";
     }

     document.getElementById("add_hour_data").onclick = function() {

       var hour = document.getElementById("hour_name_input").value;
       $.post("ajax/add_hour.php?hour="+hour, function(data, status){
                console.log(data);
                document.getElementById("hour_output").innerHTML = data;
                document.getElementById("hour_name_input").value = "";
             });

     }

     document.getElementById("close_hour_btn").onclick = function() {
        document.getElementById('hour_modal').style.display = "none";
        location.reload();
     }


     var unit_list = [];

     $.get("ajax/all_unit_list.php", function(data, status){
        unit_list = JSON.parse(data);
        });


     var process_list = [];

     $.get("ajax/all_process_list.php", function(data, status){
          process_list = JSON.parse(data);
         });


     var hour_list = [];

     $.get("ajax/all_hour_list.php", function(data, status){
           hour_list = JSON.parse(data);
          });

  $("#add_btn").click(function() {

      document.getElementById("add_btn").disabled = true;

      document.getElementById("form_1").style.display = "none";
      document.getElementById("form_2").style.display = "block";

      document.getElementById("mgs").style.display = "none";

       var selectedUnit = [];
       var selectedProcess = [];
       var selectedHour = [];

       $('#unit_list_div input:checked').each(function () {
        selectedUnit.push($(this).attr('value'));
       });

       $('#process_list_div input:checked').each(function () {
        selectedProcess.push($(this).attr('value'));
       });

       $('#hour_list_div input:checked').each(function () {
        selectedHour.push($(this).attr('value'));
       });

       var k = 0;
       var i = 1;
       var unitName = "";
       var processName = "";
       var hourName = "";

       var count = 1;

        selectedUnit.forEach(function(unit) {
                  if(unit != '0'){
                  document.getElementById('unitCount').value = k;

                  var hourListTable = "";
                  var hourListInputs = "";

                  unit_list.forEach(function(unitDetail) {
                       if(unitDetail.id == unit){
                          unitName = unitDetail.name;
                       }
                  });



                   var processList = "";

                   selectedProcess.forEach(function(process) {

                   if(process != 0){

                      hourListTable = "";
                      hourListInputs = "";

                      selectedHour.forEach(function(hour) {

                          if(hour != 0){

                             hour_list.forEach(function(hourDetail) {
                             if(hourDetail.id == hour){
                                     hourName = hourDetail.name;
                                        }
                              });

                              document.getElementById('hourCount').value = i;

                              hourListTable +=   '<th style="width:20px;" class="btn-gradient-02 text-center">'
                                                + hourName
                                                + '</th>';

                              hourListInputs +=   '<td class="text-center">'
                                                  + '<input type="number" name="quantity_input_'+i+'" style="width:60px;" value=""></input>'
                                                  + '<input type="hidden" name="hour_id_'+i+'" style="width:60px;" value="'+hour+'"></input>'
                                                  + '<input type="hidden" name="unit_id_'+i+'" style="width:60px;" value="'+unit+'"></input>'
                                                  + '</td>';

                                            i++;
                                 }

                               });

                   process_list.forEach(function(processDetail) {
                          if(processDetail.id == process){
                             processName = processDetail.name;
                          }
                     });

                   processList +=   '<tr>'
                                   +'<td style="width:140px;"></td>'
                                   +'<td style="width:100px;" class="text-center btn-gradient-01">'+processName+'</td>'
                                   +'<td style="">'
                                   +'<input type="number" name="target_input_'+count+'" style="width:60px;" value=""></input>'
                                   +'<input type="hidden" name="process_input_'+count+'" style="width:60px;" value="'+process+'"></input>'
                                   +'</td>'
                                   + hourListInputs
                                   +'</tr>';

                         count++;
                      }

                   });


                  var table = '<table class="w3-table-all w3-small" border="1">'

                             +'<thead style="background-color:gray;color:black;">'

                             +'<tr class="btn-gradient-01">'
                             +'<th>'
                             +'Unit'
                             +'</th>'

                             +'<th>'
                             +'Process'
                             +'</th>'

                             +'<th>'
                             +'Target'
                             +'</th>'

                             +'<th colspan="'+selectedHour.length+'" class="text-center">'
                             +'Hour List'
                             +'</th>'

                             +'</tr>'

                             +'<tr>'
                             +'<th>'
                             + unitName
                             +'</th>'

                             +'<th class="btn-gradient-02">'
                             + ''
                             +'</th>'

                             +'<th class="btn-gradient-02">'
                             +'<input type="hidden" name="unit_id_plan_'+k+'" style="width:60px;" value="'+unit+'"></input>'
                             +'</th>'

                             + hourListTable

                             +'</tr>'

                             +'</thead>'

                             +'<tbody>'

                             +processList

                             +'</tbody>'

                             +'</table>'
                              +'<br>'

                    $('#order_table').append(table);

                    k++;
                  }
         });
   });
});

</script>
