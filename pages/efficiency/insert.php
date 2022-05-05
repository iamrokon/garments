<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/pe_operator/insert.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/operator/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php

$user_id = $_SESSION['id'];

$selectOperator = new select_operator();
$operator_list =  $selectOperator->select_all();

$selectLine = new select_line();
$line_list =  $selectLine->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$peOperatorInsert = new insert();

if (isset($_POST['btn'])) {

$pe_operator_id = $peOperatorInsert->save($_POST);

//insert operator list when process inserted
if($pe_operator_id != null && $pe_operator_id > 0)
{
    $operatorCount = $_POST['operatorCount'];

    for($i=1;$i<=$operatorCount;$i++)
    {
        $message = $peOperatorInsert->pe_child_save(
                                                    $pe_operator_id,
                                                    $_POST['operator_id_'.$i],
                                                    $_POST['operator_name_'.$i],
                                                    $_POST['line'],
                                                    $_POST['process_select_'.$i],
                                                    $_POST['smv_'.$i],
                                                    $_POST['target_'.$i],
                                                    $_POST['one_'.$i],
                                                    $_POST['two_'.$i],
                                                    $_POST['three_'.$i],
                                                    $_POST['four_'.$i],
                                                    $_POST['five_'.$i],
                                                    $_POST['six_'.$i],
                                                    $_POST['seven_'.$i],
                                                    $_POST['eight_'.$i],
                                                    $_POST['nine_'.$i],
                                                    $_POST['ten_'.$i]
                                                    );
    }

}

}

if($message){
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
                    Operator Wise Efficiency <label></label>
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


<!-- modal for add style addition -->
<div id="operator_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Operator Info <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="operator_name_input" placeholder ="Enter Operator Name" required="required">
                    </div>

                    <br>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="operator_id_input" placeholder ="Enter Operator ID" required="required">
                    </div>

                    <br>

                    <div class="input-group">

                      <select class="form-control" id="operator_line_select" name="operator_line_select">

                      </select>

                    </div>
                </div>

                <label class="form-control-label" id="operator_name_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_operator_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_operator_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




<div id="line_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Line Info <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="line_name_input" placeholder ="Enter Line Name" required="required">
                    </div>

                </div>

                <label class="form-control-label" id="line_name_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_line_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_line_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>


            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

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

                <div class="col-md-6">
                  <div class="input-group margin" style="margin-top: 0px">
                        <label class="form-control-label btn btn-success">Line Number <span style="color: red">*</span></label>
                        <select class="form-control col-md-6" name="line_select" id="line_select"  style="margin-left:10px;">
                        <option>Select Line</option>

                        <?php
                        while ($row = mysqli_fetch_assoc($line_list))
                        {
                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php
                         }
                        ?>
                      </select>
                      <button id="add_line" type="button" class="btn btn-danger center-block">+</button>
                   </div>

                </div>


             </div>

             <div class="row">
               <div class="col-md-4">
                 <div class="input-group margin">
                       <label class="form-control-label btn btn-success">Date<span style="color: red">*</span></label>
                     <input style="margin-left: 45px;" class="form-control" type="date" id="e_date" name="e_date" autocomplete="off">
               </div>
             </div>
              </div>

             <label class="form-control-label btn btn-success" style="margin-top:10px;margin-left:12px;">Operator List</label><button id="add_operator" style="margin-left:10px;" type="button" class="btn btn-danger center-block">+</button>
             <br>
             <input type="checkbox"  class="checkItem" style="margin-left:24px;height:15px;width:15px;" onchange="checkboxOperatorCheck(this.value),checkValidation(this.value)" name="checkAllOperator" id="checkAllOperator" value="0">
             <text style="color:black;margin-right:10px;">  ALL</text>
             <div id="operator_list_div" style="margin-left:10px;" class="row">

             </div>

            <br>

            <br>


            <div class="text-center" style="padding-bottom: 10px;">
            <button id="add_btn" type="button" class="btn btn-danger center-block">Create Form</button>
            </div>
       </div>

<div id="order_sheet">

  <div style="display:none;" id="form_2">
      <form method="post" enctype="multipart/form-data" action="" class="needs-validation w3-card-4">

        <!-- login user id is hidden here -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" id="operatorCount" value="0" name="operatorCount">
        <input type="hidden" id="date" value="0" name="date">
        <input type="hidden" id="style" value="0" name="style">
        <input type="hidden" id="line" value="0" name="line">
        <input type="hidden" id="edate" value="0" name="edate">

         <div class="row" style="padding-right: 10px;padding-left: 10px;">

           <div class="table-responsive" id="custom_table" style="margin:15px;height:500px;">


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

  var process_smv = {};

$(document).ready(function () {

  $('#checkAllSize').click(function () {
         //$(':checkbox.checkItem').prop('checked', this.checked);
         $("#operator_list_div :checkbox").attr('checked', true);
     });

  var process_e_list = '<option value="">Select Process</option>';

  $.get("ajax/all_process_e_list.php", function(data, status){
          var data_list = JSON.parse(data);

          data_list.forEach(function(process) {

          process_e_list += '<option value="'+process.id+'">'+process.name+'</option>';
          process_smv[process.id] = process.smv;
          });

       });

   var operator_line_select = '<option value="">Select Line</option>';

    $.get("ajax/all_line_list.php", function(data, status){
            var line_list = JSON.parse(data);

            line_list.forEach(function(line) {

            operator_line_select += '<option value="'+line.id+'">'+line.name+'</option>';

            });

         });



     //add operator modal
     document.getElementById("add_operator").onclick = function() {

        $('#operator_line_select').append(operator_line_select);
        document.getElementById('operator_modal').style.display = "block";

     }

     document.getElementById("add_operator_data").onclick = function() {

       var name = document.getElementById("operator_name_input").value;
       var id = document.getElementById("operator_id_input").value;
       var line = document.getElementById("operator_line_select").value;

       $.post("ajax/add_operator.php?name="+name
                                    +"&id="+id
                                    +"&line="+line
                                    , function(data, status){
                document.getElementById("operator_name_output").innerHTML = data;
                document.getElementById("operator_name_input").value = "";
                document.getElementById("operator_id_input").value = "";
             });

     }

     document.getElementById("close_operator_btn").onclick = function() {
        document.getElementById('operator_modal').style.display = "none";
        location.reload();
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


     //add line modal
     document.getElementById("add_line").onclick = function() {
        document.getElementById('line_modal').style.display = "block";
     }

     document.getElementById("add_line_data").onclick = function() {

       var name = document.getElementById("line_name_input").value;

       $.post("ajax/add_line.php?name="+name, function(data, status){
                document.getElementById("line_name_output").innerHTML = data;
                document.getElementById("line_name_input").value = "";
             });

     }

        document.getElementById("close_line_btn").onclick = function() {
        document.getElementById('line_modal').style.display = "none";
        location.reload();
     }

     var operator_list = [];

     var select_line = document.getElementById("line_select");
     select_line.onchange = function(){

              var line_value = this.value;

              $.get("ajax/all_operator_with_line.php?line="+line_value, function(data, status){
                     operator_list = JSON.parse(data);

                      var operator_div = document.getElementById("operator_list_div");
                      operator_div.innerHTML = '';

                      console.log(operator_list);
                      var operator_list_load = '';

                      operator_list.forEach(function(operator) {

                        operator_list_load +=  '<div class="col-md-3">'
                                              +'<input type="checkbox"  class="checkItem" style="margin-right:5px;height:15px;width:15px;" name="operator_'+operator.id+'" value="'+operator.id+'">'
                                              +'<text style="color:black;margin-right:10px;" id="operator_value_'+operator.id+'">  '+operator.name+' ('+operator.operator_id+')</text>'
                                              +'</div>';

                      });

                      $('#operator_list_div').append(operator_list_load);

                   });


              $('#checkAllOperator').click(function () {
                     $("#operator_list_div :checkbox").attr('checked', true);
                 });

            }



            $("#add_btn").click(function() {

                document.getElementById("add_btn").disabled = true;

                document.getElementById("form_1").style.display = "none";
                document.getElementById("form_2").style.display = "block";

                //setting style selection and line selection
                document.getElementById('style').value = document.getElementById('style_select').value;
                document.getElementById('line').value = document.getElementById('line_select').value;
                document.getElementById('edate').value = document.getElementById('e_date').value;

                document.getElementById("mgs").style.display = "none";

                var selectedOperator = [];

                $('#operator_list_div input:checked').each(function () {
                 selectedOperator.push($(this).attr('value'));
                });

                var table_rows = "";
                var i = 1;

                selectedOperator.forEach(function(operator) {
                          if(operator != '0'){

                          document.getElementById('operatorCount').value = i;

                           var name = "";
                           var idNo = "";

                            operator_list.forEach(function(operatorDetails) {
                                  if(operator == operatorDetails.id){
                                       name = operatorDetails.name;
                                       idNo = operatorDetails.operator_id;
                                  }
                            });

                table_rows  += '<tr style="color:black;">'
                            +'<td style="width:100px;">'
                            +'<label style="width:100px;">'+name+'</label>'
                            +'<input type="hidden" value="'+name+'" name="operator_name_'+i+'"></input>'
                            +'</td>'

                            +'<td>'
                            +'<label style="width:100px;" >'+idNo+'</label>'
                            +'<input type="hidden" value="'+idNo+'" name="operator_id_'+i+'"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<select style="width:190px;" name="process_select_'+i+'" id="process_select_'+i+'" onchange="updateSMV('+i+',this.value)" required>'
                            + process_e_list
                            +'</select>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" readonly id="smv_'+i+'" name="smv_'+i+'"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" readonly name="target_'+i+'" id="target_'+i+'" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="one_'+i+'" id="one_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',1)" onfocus="gotFocus('+i+',1)" onfocusout="lostFocus('+i+',1)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="two_'+i+'" id="two_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',2)" onfocus="gotFocus('+i+',2)" onfocusout="lostFocus('+i+',2)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="three_'+i+'" id="three_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',3)" onfocus="gotFocus('+i+',3)" onfocusout="lostFocus('+i+',3)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="four_'+i+'" id="four_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',4)" onfocus="gotFocus('+i+',4)" onfocusout="lostFocus('+i+',4)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="five_'+i+'" id="five_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',5)" onfocus="gotFocus('+i+',5)" onfocusout="lostFocus('+i+',5)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="six_'+i+'" id="six_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',6)" onfocus="gotFocus('+i+',6)" onfocusout="lostFocus('+i+',6)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="seven_'+i+'" id="seven_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',7)" onfocus="gotFocus('+i+',7)" onfocusout="lostFocus('+i+',7)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="eight_'+i+'" id="eight_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',8)" onfocus="gotFocus('+i+',8)" onfocusout="lostFocus('+i+',8)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="nine_'+i+'" id="nine_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',9)" onfocus="gotFocus('+i+',9)" onfocusout="lostFocus('+i+',9)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input style="width:70px;" type="text" name="ten_'+i+'" id="ten_'+i+'" onkeyup="summation('+i+',this.value),changeFocus('+i+',10)" onfocus="gotFocus('+i+',10)" onfocusout="lostFocus('+i+',10)" value="0"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input readonly style="width:70px;" type="text" name="total_'+i+'" id="total_'+i+'"></input>'
                            +'</td>'

                            +'<td class="text-center">'
                            +'<input readonly style="width:70px;" type="text" name="average_'+i+'" id="average_'+i+'"></input>'
                            +'</td>'

                            +'</tr>'

                          }

                          i++;
                    });


                var table = '<table class="w3-table-all w3-small" border="1">'

                           +'<thead style="background-color:gray;color:black;">'

                           +'<tr class="btn-gradient-01">'
                           +'<th>'
                           +'Operator'
                           +'</th>'

                           +'<th>'
                           +'ID Number'
                           +'</th>'

                           +'<th class="text-center">'
                           +'Process'
                           +'</th>'

                           +'<th class="text-center">'
                           +'SMV'
                           +'</th>'

                           +'<th class="text-center">'
                           +'Target'
                           +'</th>'

                           +'<th class="text-center">'
                           +'1st'
                           +'</th>'

                           +'<th class="text-center">'
                           +'2nd'
                           +'</th>'

                           +'<th class="text-center">'
                           +'3rd'
                           +'</th>'

                           +'<th class="text-center">'
                           +'4th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'5th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'6th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'7th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'8th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'9th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'10th'
                           +'</th>'

                           +'<th class="text-center">'
                           +'Total'
                           +'</th>'

                           +'<th class="text-center">'
                           +'Average'
                           +'</th>'

                           +'</tr>'

                           +'</thead>'

                           +'<tbody>'

                           +table_rows


                           +'</tbody>'

                           +'</table>'
                           +'<br>'

                           $('#custom_table').append(table);

             });



});


function updateSMV(index,value){

  document.getElementById("smv_"+index).value = process_smv[value];
  var target = Math.ceil(60/process_smv[value]);
  document.getElementById("target_"+index).value = target;

}

function summation(index,value){

  var totalValue = 0;

  totalValue += parseInt(document.getElementById("one_"+index).value);
  totalValue += parseInt(document.getElementById("two_"+index).value);
  totalValue += parseInt(document.getElementById("three_"+index).value);
  totalValue += parseInt(document.getElementById("four_"+index).value);
  totalValue += parseInt(document.getElementById("five_"+index).value);
  totalValue += parseInt(document.getElementById("six_"+index).value);
  totalValue += parseInt(document.getElementById("seven_"+index).value);
  totalValue += parseInt(document.getElementById("eight_"+index).value);
  totalValue += parseInt(document.getElementById("nine_"+index).value);
  totalValue += parseInt(document.getElementById("ten_"+index).value);

  document.getElementById("total_"+index).value = totalValue;
  document.getElementById("average_"+index).value = Number(totalValue/10);
}


function checkboxOperatorCheck(value){

  if(value == '0') {
     document.getElementById('checkAllOperator').value = '1';
     $("#operator_list_div :checkbox").attr('checked', true);
  }
  else if (value == '1') {
     document.getElementById('checkAllOperator').value = '0';
     $("#operator_list_div :checkbox").attr('checked', false);
  }

}


function changeFocus(index,number){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             var number2 = parseInt(number) - 1;

             var inputId = numberToLetter(number2);
             document.getElementById(inputId+"_"+index).focus();
          break;
       case 39:
             var number2 = parseInt(number) + 1;

             var inputId = numberToLetter(number2);
             document.getElementById(inputId+"_"+index).focus();
          break;

          case 38:
                var number2 = parseInt(number);
                var index2 = parseInt(index) - 1;

                var inputId = numberToLetter(number2);
                document.getElementById(inputId+"_"+index2).focus();
             break;

             case 40:
                   var number2 = parseInt(number);
                   var index2 = parseInt(index) + 1;

                   var inputId = numberToLetter(number2);
                   document.getElementById(inputId+"_"+index2).focus();
                break;
    }
  };
}

function gotFocus(index,number){
  var inputId = numberToLetter(number);

  document.getElementById(inputId+"_"+index).style.backgroundColor = "red";
  document.getElementById(inputId+"_"+index).style.color = "white";
}

function lostFocus(index,number){
  var inputId = numberToLetter(number);

  document.getElementById(inputId+"_"+index).style.backgroundColor = "white";
  document.getElementById(inputId+"_"+index).style.color = "black";
}

function numberToLetter(number){

  var letter = "";

  if(number == '1'){
      letter = "one";
  }else if(number == '2'){
      letter = "two";
  }else if(number == '3'){
      letter = "three";
  }else if(number == '4'){
      letter = "four";
  }else if(number == '5'){
      letter = "five";
  }else if(number == '6'){
      letter = "six";
  }else if(number == '7'){
      letter = "seven";
  }else if(number == '8'){
      letter = "eight";
  }else if(number == '9'){
      letter = "nine";
  }else if(number == '10'){
      letter = "ten";
  }

  return letter;
}

</script>
