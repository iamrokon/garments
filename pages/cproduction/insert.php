<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/insert.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/cut_number/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/shade/select.php'; ?>
<?php require_once '../../DB/section/select.php'; ?>
<?php require_once '../../DB/process_c/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php';?>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>

<?php

$user_id = $_SESSION['id'];

$selectSize = new select_size();
$size_list =  $selectSize->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectBuyer = new select_buyer();
$buyer_list =  $selectBuyer->select_all();

$selectCutNumber = new select_cut_number();
$cut_number_list =  $selectCutNumber->select_all();

$selectColor = new select_color();
$color_list =  $selectColor->select_all();

$selectShade = new select_shade();
$shade_list =  $selectShade->select_all();

$selectSection = new select_section();
$section_list =  $selectSection->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectProcessC = new select_process_c();
$process_c_list =  $selectProcessC->select_all();


          $selectCProduction = new select_cproduction();
          $last_cproduction = $selectCProduction->select_last_cproduction();
          $last_cproduction_value = mysqli_fetch_assoc($last_cproduction);
          // print "<pre>";
          // print_r($last_cproduction_value);
          // print "</pre>";
          // $cProductionValues = $selectCProduction->select_all_lower_id_values($last_cproduction_value['id']+1);
          //
          // while ($info = mysqli_fetch_assoc($cProductionValues)) {
          //           $total_c_p_val = $total_c_p_val + $info['cutting_production'];
          // }
          // print "<pre>";
          // print_r($total_c_p_val);
          // print "</pre>";

$cproInsert = new insert();

if (isset($_POST['create_ticket'])) {
  //$cProductionValues = $selectCProduction->select_all_lower_id_values($last_cproduction_value['id']+1);
  $cProductionResult = $selectCProduction->select_last_id();
  $cProductionInfo = mysqli_fetch_assoc($cProductionResult);
  $cutProQty = $selectCProduction->select_last_cut_pro_qty();
  $lastCutProQtyInfo = mysqli_fetch_assoc($cutProQty);

  // while ($info = mysqli_fetch_assoc($cProductionValues)) {
  //           $total_c_p_val = $total_c_p_val + $info['cutting_production'];
  // }
// echo '<pre/>';
// print_r($cProductionInfo['qr_code']);
// exit();
  if($lastCutProQtyInfo['cutting_production'] == 0){
    header("Location: delete.php?id=".$cpro_id."&loc=".$loc);
    exit;
  }
  $total_c_p_val = $cProductionInfo['qr_code'] + $lastCutProQtyInfo['cutting_production'];
try{
  $cpro_id = $cproInsert->save($_POST,$total_c_p_val);

  //insert cutting production bundle
  if($cpro_id != null && $cpro_id > 0)
  {
      $count = ($_POST['total_pcs'] * $_POST['bundle_no_t']);

      for($i=1;$i<=$count;$i++)
      {
        $mgs = $cproInsert->production_bundle_save(
                                               $cpro_id,
                                               $_POST['ticket_no_'.$i],
                                               $i,
                                               $_POST['serial_from_'.$i],
                                               $_POST['serial_to_'.$i],
                                               $_POST['quantity_'.$i],
                                               $_POST['pattern_'.$i],
                                               $_POST['shade_'.$i],
                                               $_POST['country_'.$i],
                                               $user_id
                                               );
      }

      $totalPcs = $_POST['total_pcs'];

      for($k=1;$k<=$totalPcs;$k++)
      {
            $mgs = $cproInsert->production_size_save(
                                                      $cpro_id,
                                                      $_POST['label_'.$k],
                                                      $k,
                                                      $_POST['size_'.$k]
                                                      );
      }


      $totalProcess = $_POST['total_process'];

      for($l=1;$l<=$totalProcess;$l++)
      {
            $message = $cproInsert->production_process_save(
                                                            $cpro_id,
                                                            $_POST['process_id_'.$l]
                                                           );
      }

  }
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

 if($message){
   $_SESSION['message'] = $message;
   header("Location: insert.php"); // redirect back to your form
   exit;
 }

}
?>
<?php
  $cProductionResult = $selectCProduction->select_last_id();
  $cProductionInfo = mysqli_fetch_assoc($cProductionResult);
  // echo '<pre/>';
  // print_r($cProductionInfo);
  // exit();
  $cutProQty = $selectCProduction->select_last_cut_pro_qty();
  $lastCutProQtyInfo = mysqli_fetch_assoc($cutProQty);
  $cpro_id = $cProductionInfo['id'];
  $loc = "insert.php";
  // if($lastCutProQtyInfo['cutting_production'] == 0){
  //   header("Location: delete.php?id=".$cpro_id."&loc=".$loc);
  //   exit;
  // }
?>
<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    Cutting Production <label></label>
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

                    <label class="form-control-label">Buyer Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="buyer_name_input" placeholder ="Enter Buyer Name" required="required">
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



<div id="cut_number_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Cut Number <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="cut_number_input" placeholder ="Enter Cut Number" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="cut_number_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_cut_number_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_cut_number_btn" class="btn btn-gradient-05" type="submit">Close</button>
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
                        <input type="text" class="form-control" id="color_name_input" placeholder ="Enter Color Name" required="required">
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


<!-- modal for cutting process_c -->

<div id="process_c_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                    <label class="form-control-label">Process Name <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="process_c_name_input" placeholder ="Enter Process Name" required="required">
                    </div>
                </div>

                <label class="form-control-label" id="process_c_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_process_c_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_process_c_btn" class="btn btn-gradient-05" type="submit">Close</button>
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
                        <input type="text" class="form-control" id="shade_input" placeholder ="Enter Shade" required="required">
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
                        <input type="text" class="form-control" id="section_input" placeholder ="Enter Section" required="required">
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
                                    while ($row = mysqli_fetch_assoc($po_list))
                                        {
                                  ?>
                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                  <?php
                                        }
                                  ?>
                                </select>
                 </div>


                 <br>



              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">Style Name <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="style_select" id="style_select" onchange="loadcInfo(this.value)">
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
              </div>

              <br>

              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:15px;">Cut Number <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="cut_num_select" id="cut_num_select">
                                <option>Select Cut Number</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($cut_number_list))
                                      {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['cut_num']; ?></option>
                                <?php
                                      }
                                ?>
                              </select>
                              <button id="add_cut_number" type="button" class="btn btn-danger center-block">+</button>
               </div>


               <br>


              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:15px;">Lay Number <span style="color: red">*</span></label>
                                <input type="number" class="form-control col-md-6" name="lay_number" id="lay_number" placeholder ="Enter Lay Number" required="required">

              </div>

              <br>

              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:35px;">Total Pcs <span style="color: red">*</span></label>
                                <input type="number" class="form-control col-md-6" name="pcs" id="pcs" placeholder ="Enter Pcs Number" required="required">

              </div>

              <br>

              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:45px;">Bundle <span style="color: red">*</span></label>
                                <input type="number" class="form-control col-md-6" name="bundle_no_ticket" id="bundle_no_ticket" placeholder ="Enter Bundle Number" required="required" value="5">

              </div>


              </div>


              <div class="col-md-6">

               <div class="input-group margin" style="margin-top: 0px">
                                 <label class="form-control-label btn btn-success" style="margin-right:15px;">Buyer Name <span style="color: red">*</span></label>
                                 <select class="form-control col-md-6" name="buyer_select" id="buyer_select">
                                 <option>Select Buyer</option>

                                 <?php
                                   while ($row = mysqli_fetch_assoc($buyer_list))
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
                                  <label class="form-control-label btn btn-success" style="margin-right:10px;">Shade Group <span style="color: red">*</span></label>
                                  <select class="form-control col-md-6" name="shade_select" id="shade_select">
                                  <option>Select Shade</option>

                                  <?php
                                    while ($row = mysqli_fetch_assoc($shade_list))
                                        {
                                  ?>
                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                  <?php
                                        }
                                  ?>
                                </select>
                                <button id="add_shade" type="button" class="btn btn-danger center-block">+</button>
                 </div>


                 <br>


                 <div class="input-group margin" style="margin-top: 0px">
                                   <label class="form-control-label btn btn-success" style="margin-right:50px;">Section <span style="color: red">*</span></label>
                                   <select class="form-control col-md-6" name="section_select" id="section_select">
                                   <option>Select Section</option>

                                   <?php
                                     while ($row = mysqli_fetch_assoc($section_list))
                                         {
                                   ?>
                                   <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                   <?php
                                         }
                                   ?>
                                 </select>
                                 <button id="add_section" type="button" class="btn btn-danger center-block">+</button>
                  </div>

                  <br>

                  <div class="input-group margin" style="margin-top: 0px">
                                    <label class="form-control-label btn btn-success" style="margin-right:50px;">Country <span style="color: red">*</span></label>
                                    <select class="form-control col-md-6" name="country_select" id="country_select">
                                    <option>Select Country</option>

                                    <?php
                                      while ($row = mysqli_fetch_assoc($country_list))
                                          {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                    <?php
                                          }
                                    ?>
                                  </select>
                                  <!-- <button id="add_country" type="button" class="btn btn-danger center-block">+</button> -->
                   </div>

             </div>
             </div>


                           <br>

                           <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Cutting Process List</label>
                           <button id="add_process_c" type="button" class="btn btn-danger center-block">+</button>
                           <div>
                           <input id="checkAllProcessC" onchange="checkboxCheck(this.value)" style="margin-left:10px;height:17px;width:17px;" value="0" type="checkbox"><text style="color:black;">  All</text>
                           </div>
                           <div id="process_c_list_div">
                           <div class="row" id="process_c_list_creation">
                           <?php
                             while ($row = mysqli_fetch_assoc($process_c_list))
                                 {
                           ?>
                           <div class="col-md-2">
                           <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;" name="<?php echo "cproduction_".$row['id']; ?>" id="<?php echo "cproduction_id_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
                           <text style="color:black;">  <?php echo $row['name']; ?><text>
                           </div>
                           <?php
                                 }
                           ?>
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
      <div id="form_2" class="box-body  w3-animate-right w3-card-4" style="padding:10px;display:none;">


         <div id="selectedProcessList" style="display:none;">

         </div>

         <div class="row">

         <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
         <input type="hidden" name="buyer" id="buyer">
         <input type="hidden" name="po" id="po">
         <input type="hidden" name="cut_num" id="cut_num">
         <input type="hidden" name="color" id="color">
         <input type="hidden" name="style" id="style">
         <input type="hidden" name="shade" id="shade">
         <input type="hidden" name="country_id" id="country_id">
         <input type="hidden" name="lay" id="lay">
         <input type="hidden" name="section_name" id="section_name">
         <input type="hidden" name="total_pcs" id="total_pcs">
         <input type="hidden" name="bundle_no_t" id="bundle_no_t">
         <!-- <input type="hidden" name="qr_code" id="qr_code" value="<?php //echo $total_c_p_val;?>"> -->

          <div class="col-md-6" >
            <div class="form-group">

                <table class="w3-table-all w3-small" id="odd_table">

                </table>

            </div>
          </div>


          <div class="col-md-6" >
            <div class="form-group">

              <table class="w3-table-all w3-small" id="even_table">

              </table>

            </div>
          </div>



        </div>



        <div class="text-center" style="padding-bottom: 10px;">
           <button id="create_ticket" name="create_ticket" type="submit" class="btn btn-danger center-block">Create Tickets</button>
        </div>
      </div>

    </form>


</div>
</div>
</div>
<script>

$(document).ready(function () {

   var selectLabel = '<option value="0">NA</option>'
                    +'<option value="A">A</option>'
                    +'<option value="B">B</option>'
                    +'<option value="C">C</option>'
                    +'<option value="D">D</option>'
                    +'<option value="E">E</option>'
                    +'<option value="F">F</option>'
                    +'<option value="G">G</option>'
                    +'<option value="H">H</option>'
                    +'<option value="I">I</option>'
                    +'<option value="J">J</option>'
                    +'<option value="K">K</option>'
                    +'<option value="L">L</option>'
                    +'<option value="M">M</option>'
                    +'<option value="N">N</option>'
                    +'<option value="O">O</option>'
                    +'<option value="P">P</option>'
                    +'<option value="Q">Q</option>'
                    +'<option value="R">R</option>'
                    +'<option value="S">S</option>'
                    +'<option value="T">T</option>'
                    +'<option value="U">U</option>'
                    +'<option value="V">V</option>'
                    +'<option value="W">W</option>'
                    +'<option value="X">X</option>'
                    +'<option value="Y">Y</option>'
                    +'<option value="Z">Z</option>';

   $('#checkAllProcessC').click(function () {
         $("#process_c_list_div :checkbox").attr('checked', true);
     });

     var selectSize = '<option value="">Select Size</option>';

     $.get("ajax/all_size_list.php", function(data, status){

              var data = JSON.parse(data);

              data.forEach(function(size){

                if(size.inseam == '')
                selectSize +=  '<option value="'+size.id+'">'+size.size_num+'</option>';
                else selectSize +=  '<option value="'+size.id+'">'+size.size_num+"/"+size.inseam+'</option>';

              });

           });

     //buyer modal
     document.getElementById("add_buyer").onclick = function() {
        document.getElementById('buyer_modal').style.display = "block";
     }

     document.getElementById("add_buyer_data").onclick = function() {

       var buyer_name = document.getElementById("buyer_name_input").value;
       $.post("ajax/add_buyer.php?buyer_name="+buyer_name, function(data, status){
                console.log(data);
                document.getElementById("buyer_output").innerHTML = data;
                document.getElementById("buyer_name_input").value = "";
             });

     }

     document.getElementById("close_buyer_btn").onclick = function() {

        document.getElementById('buyer_modal').style.display = "none";
        document.getElementById('buyer_select').innerHTML = "";

        var selectBuyer = '<option value="">Select Buyer</option>';

        $.get("ajax/all_buyer_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(buyer){
                   console.log(buyer);

                   selectBuyer +=  '<option value="'+buyer.id+'">'+buyer.name+'</option>';

                 });

                 $('#buyer_select').append(selectBuyer);
              });
     }

     //cut number modal
     document.getElementById("add_cut_number").onclick = function() {
        document.getElementById('cut_number_modal').style.display = "block";
     }

     document.getElementById("add_cut_number_data").onclick = function() {

       var cut_number = document.getElementById("cut_number_input").value;
       $.post("ajax/add_cut_number.php?cut_number="+cut_number, function(data, status){
                console.log(data);
                document.getElementById("cut_number_output").innerHTML = data;
                document.getElementById("cut_number_input").value = "";
             });

     }

        document.getElementById("close_cut_number_btn").onclick = function() {
        document.getElementById('cut_number_modal').style.display = "none";
        document.getElementById("cut_num_select").innerHTML = '';

        var selectCutNumber = '<option value="">Select Cut Number</option>';

        $.get("ajax/all_cut_number_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(cut){
                   selectCutNumber +=  '<option value="'+cut.id+'">'+cut.cut_num+'</option>';
                 });

                 $('#cut_num_select').append(selectCutNumber);
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


     //process c modal
     document.getElementById("add_process_c").onclick = function() {
        document.getElementById('process_c_modal').style.display = "block";
     }

     document.getElementById("add_process_c_data").onclick = function() {

       var process_name = document.getElementById("process_c_name_input").value;
       $.post("ajax/add_process_c.php?process_name="+process_name, function(data, status){
                console.log(data);
                document.getElementById("process_c_output").innerHTML = data;
                document.getElementById("process_c_name_input").value = "";
             });

     }

     document.getElementById("close_process_c_btn").onclick = function() {
        document.getElementById('process_c_modal').style.display = "none";
        document.getElementById('process_c_list_creation').innerHTML = '';

        var selectProcessC = '';

        $.get("ajax/all_process_c_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(process){

                   selectProcessC +=  '<div class="col-md-2">'
                                    +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="cproduction_'+process.id+'" value="'+process.id+'">'
                                    +'<text style="color:black;" id="cproduction_'+process.id+'">'+process.name+'</text>'
                                    +'</div>';

                 });

                 $('#process_c_list_creation').append(selectProcessC);
              });
     }


     //shade modal
     document.getElementById("add_shade").onclick = function() {
        document.getElementById('shade_modal').style.display = "block";
     }

     document.getElementById("add_shade_data").onclick = function() {

       var shade_name = document.getElementById("shade_input").value;
       $.post("ajax/add_shade.php?shade_name="+shade_name, function(data, status){
                console.log(data);
                document.getElementById("shade_output").innerHTML = data;
                document.getElementById("shade_input").value = "";
             });

     }

     document.getElementById("close_shade_btn").onclick = function() {
        document.getElementById('shade_modal').style.display = "none";
        document.getElementById('shade_select').innerHTML = '';

        var selectShade = '<option value="">Select Shade</option>';

        $.get("ajax/all_shade_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(shade){
                   selectShade +=  '<option value="'+shade.id+'">'+shade.name+'</option>';
                 });

                 $('#shade_select').append(selectShade);
              });
     }



     //section modal
     document.getElementById("add_section").onclick = function() {
        document.getElementById('section_modal').style.display = "block";
     }

     document.getElementById("add_section_data").onclick = function() {

       var section_name = document.getElementById("section_input").value;
       $.post("ajax/add_section.php?section_name="+section_name, function(data, status){
                console.log(data);
                document.getElementById("section_output").innerHTML = data;
                document.getElementById("section_input").value = "";
             });
     }

        document.getElementById("close_section_btn").onclick = function() {
        document.getElementById('section_modal').style.display = "none";
        document.getElementById('section_select').innerHTML = '';

        var selectSection = '<option value="">Select Section</option>';

        $.get("ajax/all_section_list.php", function(data, status){
                 var data = JSON.parse(data);

                 data.forEach(function(section){
                   selectSection +=  '<option value="'+section.id+'">'+section.name+'</option>';
                 });

                 $('#section_select').append(selectSection);
              });
     }

       //create ticket button
       document.getElementById("create_form").onclick = function() {

       document.getElementById("form_1").style.display = "none";
       document.getElementById("form_2").style.display = "block";

       var selectedProcessDiv = "";
       var count = 0;

       $('#process_c_list_div input:checked').each(function () {

        if($(this).attr('value') != 0){
        count++;
        selectedProcessDiv += '<input type="hidden" value='+$(this).attr('value')+' name="process_id_'+ count +'"></input><br>';
        }

       });

       selectedProcessDiv += '<input type="hidden" name="total_process" id="total_process" value='+count+'>';
       $('#selectedProcessList').append(selectedProcessDiv);
       console.log(selectedProcessDiv);
       console.log("Length : "+count);

       var country = document.getElementById("country_select");
       document.getElementById("country_id").value = country.options[country.selectedIndex].value;

       var buyer = document.getElementById("buyer_select");
       document.getElementById("buyer").value = buyer.options[buyer.selectedIndex].value;

       var po_select = document.getElementById("po_select");
       document.getElementById("po").value = po_select.options[po_select.selectedIndex].value;

       var section_name = document.getElementById("section_select");
       document.getElementById("section_name").value = section_name.options[section_name.selectedIndex].value;

       var cut_number = document.getElementById("cut_num_select");
       document.getElementById("cut_num").value = cut_number.options[cut_number.selectedIndex].value;

       var color_name = document.getElementById("color_select");
       document.getElementById("color").value = color_name.options[color_name.selectedIndex].value;

       var style_name = document.getElementById("style_select");
       document.getElementById("style").value = style_name.options[style_name.selectedIndex].value;

       var shade_type = document.getElementById("shade_select");
       document.getElementById("shade").value = shade_type.options[shade_type.selectedIndex].value;

       document.getElementById("lay").value = document.getElementById("lay_number").value;

       document.getElementById("total_pcs").value = document.getElementById("pcs").value;
       document.getElementById("bundle_no_t").value = document.getElementById("bundle_no_ticket").value;


       var totalPcsNumber = document.getElementById("pcs").value;
       var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);

       for(var i = 1; i<=totalPcsNumber; i++)
       {

         var bundleNo = ((i-1)*bundleNoPerTicket) + 1;

         if(i%2 == 0)
         {

           var tableBodyBundle = "";

           for(var k = 0; k< bundleNoPerTicket; k++){
             tableBodyBundle += '<tr style="color:black;">'
             +'<td class="text-center">'+(bundleNo+k)+'</td>'
             +'<td class="text-center">'
             +'<input type="hidden" value="'+i+'" name="ticket_no_'+(bundleNo+k)+'"></input>'
             +'<input readonly style="width:60px;" type="number" name="serial_from_'+(bundleNo+k)+'" id="serial_from_'+(bundleNo+k)+'"></input>'
             +'</td>'
             +'<td class="text-center"><input readonly style="width:60px;" type="number" name="serial_to_'+(bundleNo+k)+'" id="serial_to_'+(bundleNo+k)+'"></input></td>'
             +'<td class="text-center"><input style="width:60px;" type="number" onkeyup="serialSum(this.value,'+(bundleNo+k)+'),updateQuantity(this.value,'+(bundleNo+k)+'),changeFocus1('+(bundleNo+k)+')" name="quantity_'+(bundleNo+k)+'" id="quantity_'+(bundleNo+k)+'"></input></td>'
             +'<td class="text-center"><input style="width:60px;" type="text" onkeyup="updatePat(this.value,'+(bundleNo+k)+'),changeFocus2('+(bundleNo+k)+')" name="pattern_'+(bundleNo+k)+'" id="pattern_'+(bundleNo+k)+'"></input></td>'
             +'<td class="text-center">'
             +'<select id="shade_'+(bundleNo+k)+'" name="shade_'+(bundleNo+k)+'" onchange="updateShade(this.value,'+(bundleNo+k)+'),changeFocus3('+(bundleNo+k)+')">'
             +'</select>'
             +'</td>'
             +'<td class="text-center">'
             +'<select id="country_'+(bundleNo+k)+'" name="country_'+(bundleNo+k)+'" onchange="updateCountry(this.value,'+(bundleNo+k)+'),changeFocus4('+(bundleNo+k)+')">'
             +'</select>'
             +'</td>'
             +'</tr>';
           }

           $('#even_table').append('<thead>'
             +'<tr style="color:black;" class="btn-gradient-01">'
             +'<th class="text-center"></th>'
             +'<th colspan="1" class="text-center"></th>'
             +'<th colspan="1" class="text-center"></th>'
             +'<th class="text-center"></th>'
             +'<th class="text-center"></th>'
             +'<th class="text-center"></th>'
             +'<th class="text-center"></th>'
             +'</tr>'

             +'<tr style="color:black;">'
             +'<th class="text-center">Ticket</th>'
             +'<th colspan="1" class="text-center">'+i+'</th>'
             +'<th class="text-center"></th>'
             +'<th class="text-center"></th>'
             +'<th class="text-center">'
             +'<select name="label_'+i+'" required>'
             +selectLabel
             +'</select>'
             +'</th>'
             +'<th class="text-center">Size</th>'
             +'<th class="text-center">'
             +'<div style="width:87px"><select name="size_'+i+'" required>'
             +selectSize
             +'</select></div>'
             +'</th>'
             +'</tr>'

             +'<tr style="color:black;">'
             +'<th class="text-center">Bund No.</th>'
             +'<th class="text-center">Serial From</th>'
             +'<th class="text-center">Serial To</th>'
             +'<th class="text-center">Quantity</th>'
             +'<th class="text-center">Pattern</th>'
             +'<th class="text-center">Shade</th>'
             +'<th class="text-center">Country</th>'
             +'</tr>'
             +'</thead>'

             +'<tbody>'

             +tableBodyBundle

             +'</tbody>');

         } else{

           var tableBodyBundle = "";

           for(var k = 0; k< bundleNoPerTicket; k++){
             tableBodyBundle += '<tr style="color:black;">'
             +'<td class="text-center">'+(bundleNo+k)+'</td>'
             +'<td class="text-center">'
             +'<input type="hidden" value="'+i+'" name="ticket_no_'+(bundleNo+k)+'"></input>'
             +'<input readonly style="width:60px;" type="number" name="serial_from_'+(bundleNo+k)+'" id="serial_from_'+(bundleNo+k)+'"></input>'
             +'</td>'
             +'<td class="text-center"><input readonly style="width:60px;" type="number" name="serial_to_'+(bundleNo+k)+'" id="serial_to_'+(bundleNo+k)+'"></input></td>'
             +'<td class="text-center"><input style="width:60px;" type="number" onkeyup="serialSum(this.value,'+(bundleNo+k)+'),updateQuantity(this.value,'+(bundleNo+k)+'),changeFocus1('+(bundleNo+k)+')" name="quantity_'+(bundleNo+k)+'" id="quantity_'+(bundleNo+k)+'"></input></td>'
             +'<td class="text-center"><input style="width:60px;" type="text" onkeyup="updatePat(this.value,'+(bundleNo+k)+'),changeFocus2('+(bundleNo+k)+')" name="pattern_'+(bundleNo+k)+'" id="pattern_'+(bundleNo+k)+'"></input></td>'
             +'<td class="text-center">'
             +'<select id="shade_'+(bundleNo+k)+'" name="shade_'+(bundleNo+k)+'" onchange="updateShade(this.value,'+(bundleNo+k)+'),changeFocus3('+(bundleNo+k)+')">'
             +'</select>'
             +'</td>'
             +'<td class="text-center">'
             +'<select id="country_'+(bundleNo+k)+'" name="country_'+(bundleNo+k)+'" onchange="updateCountry(this.value,'+(bundleNo+k)+'),changeFocus4('+(bundleNo+k)+')">'
             +'</select>'
             +'</td>'
             +'</tr>';
           }

           $('#odd_table').append('<thead>'
           +'<tr style="color:black;" class="btn-gradient-01">'
           +'<th class="text-center"></th>'
           +'<th colspan="1" class="text-center"></th>'
           +'<th colspan="1" class="text-center"></th>'
           +'<th class="text-center"></th>'
           +'<th class="text-center"></th>'
           +'<th class="text-center"></th>'
           +'<th class="text-center"></th>'
           +'</tr>'

           +'<tr style="color:black;">'
           +'<th class="text-center">Ticket</th>'
           +'<th colspan="1" class="text-center">'+i+'</th>'
           +'<th class="text-center"></th>'
           +'<th class="text-center"></th>'
           +'<th class="text-center">'
           +'<select name="label_'+i+'" required>'
           +selectLabel
           +'</select>'
           +'</th>'
           +'<th class="text-center">Size</th>'
           +'<th class="text-center">'
           +'<div style="width:87px"><select name="size_'+i+'" required>'
           +selectSize
           +'</select></div>'
           +'</th>'
           +'</tr>'

           +'<tr style="color:black;">'
           +'<th class="text-center">Bund No.</th>'
           +'<th class="text-center">Serial From</th>'
           +'<th class="text-center">Serial To</th>'
           +'<th class="text-center">Quantity</th>'
           +'<th class="text-center">Pattern</th>'
           +'<th class="text-center">Shade</th>'
           +'<th class="text-center">Country</th>'
           +'</tr>'
           +'</thead>'

           +'<tbody>'

           +tableBodyBundle

           +'</tbody>');

         }
       }


       //get all country list
       $.get("ajax/all_country_list.php", function(data, status){
                var countryCombo = "";
                var countryId = document.getElementById('country_select').selectedIndex;

                data = JSON.parse(data);
                data.forEach(function(item){
                  countryCombo += '<option value="'+item.id+'">'+item.full_name+'</option>'
                });


                for(var i = 1; i<=totalPcsNumber; i++)
                {
                  var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
                  var bundleNo = ((i-1)*bundleNoPerTicket) + 1;

                  for(var k = 0 ;k< bundleNoPerTicket; k++){
                    $('#country_'+(bundleNo+k)).append(countryCombo);
                    document.getElementById('country_'+(bundleNo+k)).selectedIndex = countryId-1;
                  }

                }

             });



         //get all shade list
         $.get("ajax/all_shade_list.php", function(data, status){
                  var shadeCombo = "";
                  var shade = document.getElementById("shade_select").selectedIndex;

                  console.log("shade : "+shade);

                  data = JSON.parse(data);
                  data.forEach(function(item){
                    shadeCombo += '<option value="'+item.id+'">'+item.name+'</option>'
                  });

                  for(var i = 1; i<=totalPcsNumber; i++)
                  {
                    var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
                    var bundleNo = ((i-1)*bundleNoPerTicket) + 1;

                    for(var k = 0 ;k< bundleNoPerTicket; k++){
                      $('#shade_'+(bundleNo+k)).append(shadeCombo);
                      document.getElementById('shade_'+(bundleNo+k)).selectedIndex = shade-1;
                    }

                  }

               });
     }
});


function changeFocus1(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             var value = parseInt(index)-1;
             document.getElementById("country_"+value).focus();
          break;
       case 39:
             //var value = parseInt(index);
             document.getElementById("pattern_"+parseInt(index)).focus();
          break;
    }
  };
}

function changeFocus2(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             //var value = parseInt(index);
             document.getElementById("quantity_"+parseInt(index)).focus();
          break;
       case 39:
             //var value = parseInt(index);
             document.getElementById("shade_"+parseInt(index)).focus();
          break;
    }
  };
}

function changeFocus3(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             //var value = parseInt(index);
             document.getElementById("pattern_"+parseInt(index)).focus();
          break;
       case 39:
             //var value = parseInt(index);
             document.getElementById("country_"+parseInt(index)).focus();
          break;
    }
  };
}

function changeFocus4(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             document.getElementById("shade_"+parseInt(index)).focus();
          break;
       case 39:
             var value = parseInt(index)+1;
             document.getElementById("quantity_"+value).focus();
          break;
    }
  };
}

function serialSum(value,bundleNo) {

  var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
  var totalPcsNumber = parseInt(document.getElementById("pcs").value)*bundleNoPerTicket;

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


function loadInfo(id){

   $('#process_c_list_div :checkbox:enabled').prop('checked', false);

   $.post("ajax/get_order_info.php?id="+id, function(data, status){
            data = JSON.parse(data);

            document.getElementById('buyer_select').value = data.buyer;
            document.getElementById('color_select').value = data.color;
            document.getElementById('style_select').value = data.style;

            $.post("ajax/get_style_process_with_id.php?id="+data.style, function(pro_data, status){

                  pro_data = JSON.parse(pro_data);

                  pro_data.forEach(function(pro){
                    document.getElementById("cproduction_id_"+pro.pro_id).checked = true;
                    console.log(pro.pro_id);
                  });

            });

         });
}



function loadcInfo(id){

            $('#process_c_list_div :checkbox:enabled').prop('checked', false);
            console.log(id);

            $.post("ajax/get_style_process_with_id.php?id="+id, function(pro_data, status){

                  pro_data = JSON.parse(pro_data);

                  pro_data.forEach(function(pro){
                    document.getElementById("cproduction_id_"+pro.pro_id).checked = true;
                    console.log(pro.pro_id);
                  });

             });
}


function updatePat(value,number){
  var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
  var totalPcsNumber = parseInt(document.getElementById("pcs").value)*bundleNoPerTicket;
  console.log("Total Pcs : "+totalPcsNumber);

  if(number <= 1){
    for(var i = 1; i<=totalPcsNumber; i++)
    {
        document.getElementById('pattern_'+i).value = value;
    }
  }

  for(var i = 1; i<=totalPcsNumber; i++)
  {
      if(i%bundleNoPerTicket == number){
           document.getElementById('pattern_'+i).value = value;
      } else if(number == bundleNoPerTicket){
        if(i%bundleNoPerTicket == 0){
          document.getElementById('pattern_'+i).value = value;
        }
      }
  }

}


function updateQuantity(value,number){
  var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
  var totalPcsNumber = parseInt(document.getElementById("pcs").value)*bundleNoPerTicket;
// alert(totalPcsNumber);
  for(var i = 1; i<=totalPcsNumber; i++)
  {
      if(i%bundleNoPerTicket == number){
           document.getElementById('quantity_'+i).value = value;
           serialSum(value,i);
      } else if(number == bundleNoPerTicket){
        if(i%bundleNoPerTicket == 0){
          document.getElementById('quantity_'+i).value = value;
          serialSum(value,i);
        }
      }
  }

}


function checkboxCheck(value){

  if(value == '0') {
     document.getElementById('checkAllProcessC').value = '1';
     $("#process_c_list_div :checkbox").attr('checked', true);
  }
  else if (value == '1') {
     document.getElementById('checkAllProcessC').value = '0';
     $("#process_c_list_div :checkbox").attr('checked', false);
  }

}


function updateShade(value,number){

   var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
   var totalPcsNumber = parseInt(document.getElementById("pcs").value)*bundleNoPerTicket;

   for(var i = 1; i<=totalPcsNumber; i++)
   {
       // if(i%bundleNoPerTicket == number){
       //      document.getElementById('shade_'+i).value = value;
       //      var shadeSelect = document.getElementById("shade_"+i);
       //      document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       // }else if(i%bundleNoPerTicket == 0){
       //   document.getElementById('shade_'+i).value = value;
       //   var shadeSelect = document.getElementById("shade_"+i);
       //   document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       // }

       if(i%bundleNoPerTicket == number){
         document.getElementById('shade_'+i).value = value;
         var shadeSelect = document.getElementById("shade_"+i);
         document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       } else if(number == bundleNoPerTicket){
         if(i%bundleNoPerTicket == 0){
           document.getElementById('shade_'+i).value = value;
           var shadeSelect = document.getElementById("shade_"+i);
           document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
         }
       }


   }

}



function updateCountry(value,number){

   var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
   var totalPcsNumber = parseInt(document.getElementById("pcs").value)*bundleNoPerTicket;

   for(var i = 1; i<=totalPcsNumber; i++)
   {
       // if(i%bundleNoPerTicket == number){
       //      document.getElementById('country_'+i).value = value;
       //      var countrySelect = document.getElementById("country_"+i);
       //      document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
       // }else if(i%bundleNoPerTicket == 0){
       //   document.getElementById('country_'+i).value = value;
       //   var countrySelect = document.getElementById("country_"+i);
       //   document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
       // }

       if(i%bundleNoPerTicket == number){
         document.getElementById('country_'+i).value = value;
         var countrySelect = document.getElementById("country_"+i);
         document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
       } else if(number == bundleNoPerTicket){
         if(i%bundleNoPerTicket == 0){
           document.getElementById('country_'+i).value = value;
           var countrySelect = document.getElementById("country_"+i);
           document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
         }
       }
   }

}


</script>
