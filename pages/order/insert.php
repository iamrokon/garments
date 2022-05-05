<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/order/insert.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/season/select.php'; ?>

<?php
$user_id = $_SESSION['id'];

$selectBuyer = new select_buyer();
$buyer_list =  $selectBuyer->select_all();

$selectColor = new select_color();
$color_list =  $selectColor->select_all();

$selectSize = new select_size();
$size_list =  $selectSize->select_all();
$size_list_with_p =  $selectSize->select_size_with_p();
$select_size_without_p =  $selectSize->select_size_without_p();
while ($row = mysqli_fetch_assoc($size_list_with_p))
{
  $rows_p[] = $row;
}
while ($row = mysqli_fetch_assoc($select_size_without_p))
{
  $size_rows[] = $row;
}
foreach ($rows_p as $key => $row_p) {
  $size_rows[] = $row_p;
}
// echo '<pre>';
// print_r($size_rows);
// echo  '</pre>';

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectSeason = new select_season();
$season_list =  $selectSeason->select_all();

$orderInsert = new insert();

if (isset($_POST['btn'])) {
$order_id = $orderInsert->save($_POST);

//insert quantity of size when order inserted
if($order_id != null && $order_id > 0)
{
    $sizeCount = $_POST['sizeCount'];

    for($i=1;$i<=$sizeCount;$i++)
    {
      $mgs = $orderInsert->order_quantity_save(
                                               $order_id,
                                               $_POST['size_'.$i],
                                               $_POST['size_id_'.$i],
                                               $_POST['quantity_'.$i],
                                               $_POST['country_input_'.$i],
                                               $user_id
                                              );
    }


    $countryCount = $_POST['countryCount'];
    for($k=0;$k<=$countryCount;$k++)
    {
      if($_POST['country_order_'.$k] > 0){
      $message = $orderInsert->order_country_save(
                                                  $order_id,
                                                  $_POST['country_order_'.$k],
                                                  $_POST['country_color_'.$k],
                                                  $_POST['tod_'.$k],
                                                  $_POST['shipment_'.$k],
                                                  $user_id
                                                  );
      }
    }

    if($message){
       $_SESSION['message'] = $message;
       header("Location: insert.php"); // redirect back to your form
       exit;
    }
}

}
?>

 <!-- table data  -->
<?php
      $ob = new select_order();


      $selectSizeTable = new select_size();
      $size_list_table =  $selectSize->select_all();

      $selectCountryTable = new select_country();

      $selectPOTable = new select_po();

      $selectStyleTable = new select_style();



?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    Order Processing <label></label>
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
<div id="country_modal" class="modal">

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
                        <input type="text" class="form-control" id="country_name_input" placeholder ="Enter Country Name" required="required">
                    </div>

                    <br>

                    <label class="form-control-label">
                       Cut Off <span style="color:red;">*</span></label>

                    <div class="input-group">
                       <select class="form-control" name="country_cut_off" id="country_cut_off">
                         <option value="">Select Cut Off</option>
                         <option value="1">1st Cut Off</option>
                         <option value="2">2nd Cut Off</option>
                         <option value="3">3rd Cut Off</option>
                       </select>
                    </div>

                    <br>

                    <label class="form-control-label">
                       Country Code <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="country_code_input" placeholder ="Enter Country Code" required="required">
                    </div>

                </div>
                <label class="form-control-label" id="country_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_country_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_c_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>


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
                        <input type="text" class="form-control" id="season_name_input" placeholder ="Enter Season" required="required">
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



<div id="size_modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="box-body">

            <div class="row">

             <div class="col-md-12">
                <div class="form-group">

                  <br>
                  <label class="form-control-label">Inseam Number <span style="color:red;">*</span></label>

                  <div class="input-group">
                      <span class="input-group-addon addon-primary">
                          <i class="la la-file-text"></i>
                      </span>
                      <input type="text" class="form-control" id="inseam_number_input" placeholder ="Enter Inseam Number" required="required">
                  </div>

                  <br>

                    <label class="form-control-label">Size Number <span style="color:red;">*</span></label>

                    <div class="input-group">
                        <span class="input-group-addon addon-primary">
                            <i class="la la-file-text"></i>
                        </span>
                        <input type="text" class="form-control" id="size_number_input" placeholder ="Enter Size Number" required="required">
                    </div>


                </div>

                <label class="form-control-label" id="size_output" style="color:red;"></label>

    </div>

</div>


<div class="text-center" style="padding-bottom: 10px;">
<button id="add_size_data" class="btn btn-gradient-03" type="submit">Save</button>
<button id="close_size_btn" class="btn btn-gradient-05" type="submit">Close</button>
</div>

</div>                        <!-- End Row -->

  </div>

</div>




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



<!-- modal for add country addition -->
<!-- modal for add style addition -->
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
                        <input type="text" class="form-control" id="po_number_input" placeholder ="Enter PO Number" required="required">
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
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">PO Number <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="po_select" id="po_select">
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
                              <button id="add_po" type="button" class="btn btn-danger center-block">+</button>
               </div>

             </div>
             </div>

             <br>

             <div class="row">

               <div class="col-md-6">
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

              </div>

             </div>

             <br>

             <div class="row">

             <div class="col-md-6">

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

             </div>

             </div>

            <br>

            <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Country List</label>
            <button id="add_country" type="button" class="btn btn-danger center-block">+</button>
            <div>
            <input id="checkAllCountry" onchange="checkboxCountryCheck(this.value)" value="0" type="checkbox" style="margin-left:10px;height:20px;width:20px;">
            <text style="color:black;">  All</text>
            </div>
            <div id="country_list_div">
            <div class="row" id="country_list_creation">
            <?php
                  while ($row = mysqli_fetch_assoc($country_list))
                       {
            ?>
            <div class="col-md-2">
            <input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="<?php echo "country_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
            <text style="color:black;" id="<?php echo "country_value_".$row['id']; ?>">  <?php echo $row['full_name']; ?></text>
            </div>
            <?php
                       }
             ?>
            </div>
            </div>

            <br>

            <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Size List</label>
            <button id="add_size" type="button" class="btn btn-danger center-block">+</button>
            <div>
            <input id="checkAllSize" onchange="checkboxSizeCheck(this.value)" style="height:20px;width:20px;margin-left:10px;" value="0" type="checkbox">
            <text style="color:black;">  All</text>
            </div>
            <div id="size_list_div">
            <div class="row" id="size_list_creation">
            <?php
              foreach ($size_rows as $key => $row) {
            ?>
            <div class="col-md-2">
            <input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="<?php echo "size_".$row['id']; ?>"
             data-val="<?php echo $row['id']; ?>" value="<?php
             if($row['inseam'] == '') echo $row['size_num'];
             else echo $row['size_num']."-".$row['inseam'];
             ?>">
            <input type="hidden" name="<?php echo "size_id_".$row['id']; ?>" value="<?php echo $row['id'];?>">
             <text style="color:black;">
              <?php
                   if($row['inseam'] == '') echo $row['size_num'];
                   else echo $row['size_num']."-".$row['inseam'];

              ?>
              <text>
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

  <div style="display:none;" id="form_2" class="box-body  w3-card-4">

      <form method="post" enctype="multipart/form-data" action="" class="needs-validation">

        <!-- login user id is hidden here -->
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="style" id="style">
        <input type="hidden" name="country" id="country">
        <input type="hidden" name="po" id="po">
        <input type="hidden" name="season_id" id="season_id">
        <input type="hidden" name="buyer_id" id="buyer_id">
        <input type="hidden" name="color_id" id="color_id">
        <input type="hidden" id="count" value="0" name="count">
        <input type="hidden" id="countryCount" value="0" name="countryCount">
        <input type="hidden" id="sizeCount" value="0" name="sizeCount">
        <div id="hiddenCountry" style="display:none;"></div>

         <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

           <div class="table-responsive" id="order_table" style="margin:15px;">


           </div>

         </div>


<div class="text-center" style="padding-bottom: 10px;">
<button name="btn" class="btn btn-gradient-03" type="submit">Save Info</button>
<div readonly class="btn btn-gradient-01">Total Quantity <text id="totalQuantityOrder">0</text> </div>
</div>


</form>

</div>

</div>

</div>
</div>
</div>

<script>

 var totalSize = 0;

var size_numbers = [];


$(document).ready(function () {

  $('#checkAllSize').click(function () {
         $("#size_list_div :checkbox").attr('checked', true);
     });


    $('#checkAllCountry').click(function () {
        $("#country_list_div :checkbox").attr('checked', true);
    });

    //pre loading combo data
    var country_list = [];
    var color_list = [];
    var colorCombo = '<option value="">Select Color</option>';
    var countryName = '<option value="">Select Country</option>';
    var sizeName = '<option value="">Select Size</option>';

    $.get("ajax/all_country_list.php", function(data, status){
             country_list = JSON.parse(data);

             country_list.forEach(function(country) {
                  countryName += '<option value="'+country.id+'">'+country.full_name+'</option>';
             });
          });
    $.get("ajax/all_size_list.php", function(data, status){
             size_list = JSON.parse(data);

             size_list.forEach(function(size) {
                  sizeName += '<option value="'+size.id+'">'+size.size_num+'</option>';
             });
          });

    $.get("ajax/all_color_list.php", function(data, status){
             color_list = JSON.parse(data);

             color_list.forEach(function(color) {
                  colorCombo += '<option value="'+color.id+'">'+color.name+'</option>';
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


     //country modal
     document.getElementById("add_country").onclick = function() {
        document.getElementById('country_modal').style.display = "block";
     }

     document.getElementById("add_country_data").onclick = function() {
       var country_name = document.getElementById("country_name_input").value;
       var cut = document.getElementById("country_cut_off").value;
       var country_code = document.getElementById("country_code_input").value;
       $.post("ajax/add_country.php?country_name="+country_name+"&cut="+cut+"&country_code="+country_code, function(data, status){
                console.log(data);
                document.getElementById("country_output").innerHTML = data;
                document.getElementById("country_name_input").value = "";
             });
     }

     document.getElementById("close_c_btn").onclick = function() {
        document.getElementById('country_modal').style.display = "none";
        document.getElementById('country_list_creation').innerHTML = '';

        var selectCountry = '';

        $.get("ajax/all_country_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(country){

                   selectCountry +=  '<div class="col-md-2">'
                                    +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="country_'+country.id+'" value="'+country.id+'">'
                                    +'<text style="color:black;" id="country_value_'+country.id+'">'+country.full_name+'</text>'
                                    +'</div>';

                 });

                 $('#country_list_creation').append(selectCountry);
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
     document.getElementById("add_po").onclick = function() {
        document.getElementById('po_modal').style.display = "block";
     }

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


     //size modal
     document.getElementById("add_size").onclick = function() {
        document.getElementById('size_modal').style.display = "block";
     }

     document.getElementById("add_size_data").onclick = function() {

       var size_number = document.getElementById("size_number_input").value;
       var inseam_number = document.getElementById("inseam_number_input").value;
       $.post("ajax/add_size.php?size_number="+size_number+"&&inseam="+inseam_number, function(data, status){
                console.log(data);
                document.getElementById("size_output").innerHTML = data;
                document.getElementById("size_number_input").value = "";
                document.getElementById("inseam_number_input").value = "";
             });

     }

     document.getElementById("close_size_btn").onclick = function() {
        document.getElementById('size_modal').style.display = "none";
        document.getElementById('size_list_creation').innerHTML = '';

        var selectSize = '';

        $.get("ajax/all_size_list.php", function(data, status){
                 var data = JSON.parse(data);


                 data.forEach(function(size){
                   if(size.inseam == '')
                   {
                       selectSize +=  '<div class="col-md-2">'
                                  +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="size_'+size.id+'" value="'+size.size_num+'">'
                                  +'<input type="hidden" name="size_id_'+size.id+'" value="'+size.id+'">'
                                  +'<text style="color:black;">'+size.size_num+'</text>'
                                  +'</div>';
                   }else {
                       selectSize +=  '<div class="col-md-2">'
                                  +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="size_'+size.id+'" value="'+size.size_num+'">'
                                  +'<input type="hidden" name="size_id_'+size.id+'" value="'+size.id+'">'
                                  +'<text style="color:black;">'+size.size_num+"/"+size.inseam+'</text>'
                                  +'</div>';
                   }

                 });

                 $('#size_list_creation').append(selectSize);
              });
     }


  $("#add_btn").click(function() {
      document.getElementById("add_btn").disabled = true;

      document.getElementById("form_1").style.display = "none";
      document.getElementById("form_2").style.display = "block";

      document.getElementById("mgs").style.display = "none";

       var selectedSize = [];
       var selectedCountry = [];

       $('#size_list_div input:checked').each(function () {
         var index = $(this).data('val');
         var value = $(this).attr('value');
         var obj = {
             [index]: value
         };
        //obj[$(this).data('val')] = $(this).attr('value');
        //selectedSize.push(obj);
        //selectedSize.push($(this).attr('value'));
        selectedSize.push({
            [index]: value
        });
        //selectedSize.push($(this).data('val'));
       });
      console.log(selectedSize);

       $('#country_list_div input:checked').each(function () {
        selectedCountry.push($(this).attr('value'));
       });

       var season = document.getElementById("season_select");
       document.getElementById("season_id").value = season.options[season.selectedIndex].value;

       var color = document.getElementById("color_select").value;
       document.getElementById("color_id").value = color;

       var buyer = document.getElementById("buyer_select").value;
       document.getElementById("buyer_id").value = buyer;

       var style = document.getElementById("style_select");
       document.getElementById("style").value = style.options[style.selectedIndex].value;
       var styleName = $("#style_select option:selected").text();

       var po = document.getElementById("po_select");
       document.getElementById("po").value = po.options[po.selectedIndex].value;
       var poNumber = $("#po_select option:selected").text();

       var k = 0;
       var i = 1;
       var j = 1;

        selectedCountry.forEach(function(country) {
                  if(country != '0'){
                  document.getElementById('countryCount').value = k;

                  var sizeListTable = "";
                  var sizeListInputs = "";
                  totalSize = 0;

                  selectedSize.forEach(function(size) {
                    for (var key in size) {

                    if(key){

                    document.getElementById('sizeCount').value = i;
                    totalSize += 1;

                    sizeListTable +=   '<th style="width:20px;" class="btn-gradient-02 text-center order_color3">'
                                      //+ size[key]

                                      +'<select name="size_id_'+i+'" id="size_id_'+i+'" required>'
                                      +sizeName
                                      +'</select>'
                                     + '</th>';

                    sizeListInputs +=   '<td class="text-center">'
                                      + '<input required type="number" name="quantity_'+i+'" id="quantity_'+i+'" onfocus="gotFocus('+i+')" onfocusout="lostFocus('+i+')" onkeyup="totalQuantity('+i+'),countryWiseTotal('+country+','+i+','+k+'),changeFocus('+i+')" style="width:60px;" value="0"></input>'
                                      + '<input type="hidden" name="country_input_'+i+'" style="width:60px;" value="'+country+'" class="country_order_'+k+'"></input>'
                                      + '<input type="hidden" name="size_'+i+'" style="width:60px;" value="'+size[key]+'"></input>'
                                      // + '<input type="hidden" name="size_id_'+i+'" style="width:60px;" value="'+key+'"></input>'
                                      + '</td>';


                    i++;
                    }

                   };
                  });

                  var table = '<div class="table-responsive"><table class="w3-table-all w3-small" border="1">'

                             +'<thead style="background-color:gray;color:black;" class="btn-gradient-03">'
                             +'<tr>'
                             +'<th style="width:60px;" class="btn-gradient-03 order_color1">'
                             +'Total'
                             +'</th>'

                             +'<th style="width:140px;" class="btn-gradient-03 order_color1">'
                             +'<text disabled id="country_total_'+country+'" type="text" >0</text>'
                             +'</th>'
                             +'</tr>'

                             +'<tr>'
                             +'<th style="width:140px;" class="btn-gradient-03 order_color2">'
                             +'Country'
                             +'</th>'

                             // +'<th style="width:140px;" class="btn-gradient-03 order_color2">'
                             // + document.getElementById('country_value_'+country).innerText
                             // + '<input type="hidden" name="country_order_'+k+'" value="'+country+'"></input>'
                             // +'</th>'
                             +'<th style="width:140px;" class="btn-gradient-03 order_color2">'
                             +'<select name="country_order_'+k+'" id="country_order_'+k+'" onchange="changeCountry('+k+')" required>'
                             +countryName
                             +'</select>'
                             +'</th>'

                             +'<th style="width:140px;" class="btn-gradient-03 order_color2">'
                             +'Color'
                             +'</th>'

                             +'<th style="width:140px;" class="btn-gradient-03 order_color2">'
                             +'<select name="country_color_'+k+'" id="country_color_'+k+'" required>'
                             +colorCombo
                             +'</select>'
                             +'</th>'

                             +'<th style="width:60px;" class="btn-gradient-03 order_color2">'
                             +'TOD'
                             +'</th>'

                             +'<th style="width:140px; class="btn-gradient-03 order_color2">'
                             +'<input style="width:145px;" type="date" value="<?php echo date('Y-m-d'); ?>" name="tod_'+k+'" id="tod_'+k+'" onchange="updateShipment(this.value, '+k+', '+country+',)" required></input>'
                             +'</th>'

                             +'<th style="width:60px;" class="btn-gradient-03 order_color2">'
                             +'Shipment'
                             +'</th>'

                             +'<th style="width:140px; class="btn-gradient-03 order_color2">'
                             +'<input style="width:145px;" type="date" name="shipment_'+k+'" id="shipment_'+k+'" required></input>'
                             +'</th>'

                             +'</tr>'


                             +'<tr class="btn-gradient-01">'
                             +'<th>'
                             +'Style Name'
                             +'</th>'

                             +'<th>'
                             +'Po Number'
                             +'</th>'

                             +'<th colspan="'+selectedSize.length+'" class="text-center">'
                             +'Size List'
                             +'</th>'

                             +'</tr>'

                             +'<tr>'
                             +'<th>'
                             + styleName
                             +'</th>'

                             +'<th>'
                             + poNumber
                             +'</th>'

                             + sizeListTable

                             +'</tr>'

                             +'</thead>'

                             +'<tbody>'
                             +'<tr>'
                             +'<td style="width:140px;"></td>'
                             +'<td style="width:100px;" class="text-center btn-gradient-01">Order</td>'
                             + sizeListInputs

                             +'</tr>'
                             +'</tbody>'

                             +'</table></div>'
                              +'<br>'

                    $('#order_table').append(table);

                    document.getElementById('country_color_'+k).value = color;
                    document.getElementById('country_order_'+k).value = country;
                    // document.getElementById('size_id_'+k).value = 275;


                    selectedSize.forEach(function(size) {
                      for (var key in size) {

                      if(key){
                      document.getElementById('size_id_'+j).value = key;
                      j++;
                      }
                     };
                    });






                    k++;
                  }
         });
   });
});


function updateShipment(value, k, country_id){
  var myDate = new Date(value);
  var countryId = document.getElementById("country_order_"+k).value;
  $.post("ajax/get_cut_off_info.php?country_id="+countryId, function(data, status){
    var data =  JSON.parse(data);

    if(data['cut_off']==1){
      myDate.setDate(myDate.getDate() - 1);
    }
    if(data['cut_off']==2){
      myDate.setDate(myDate.getDate() + 1);
    }
    if(data['cut_off']==3){
      myDate.setDate(myDate.getDate() + 3);
    }

    var curr_date = myDate.getDate();
    if(curr_date < 10 ){
      curr_date = '0'+curr_date;
    }
    var curr_month = myDate.getMonth() + 1; //Months are zero based
    if(curr_month < 10 ){
      curr_month = '0'+curr_month;
    }
    var curr_year = myDate.getFullYear();
    newDate = curr_year + "-" + curr_month + "-" + curr_date;
    document.getElementById('shipment_'+k).value = newDate;

  });

}

function totalQuantity(count){

    var totalQuantity = 0;
    var totalInputField = parseInt(document.getElementById("sizeCount").value);

    for(var i = 1; i<=totalInputField; i++)
    {
       var quantity = parseInt(document.getElementById("quantity_"+i).value);

       if(isNaN(quantity)) quantity = 0;

       totalQuantity += quantity;
    }

    document.getElementById("totalQuantityOrder").innerHTML = totalQuantity;
}

function changeCountry(count){

    var countryId = document.getElementById("country_order_"+count).value;
    var x = document.getElementsByClassName("country_order_"+count);
    var i;
    for (i = 0; i < x.length; i++) {
    //alert(x[i].value);
      x[i].value = countryId;
    }

    //document.getElementsByClassName("country_order_"+count).value = countryId;
}

function countryWiseTotal(country,count,countryNumber){

   var startingID = (totalSize*countryNumber);
   var totalQuantityCountry = 0;

   for(var i=1; i<= totalSize; i++)
   {
     startingID ++;
     var quantity = parseInt(document.getElementById("quantity_"+startingID).value);
     if(isNaN(quantity)) quantity = 0;

     totalQuantityCountry += quantity;
   }

   document.getElementById("country_total_"+country).innerHTML = totalQuantityCountry;
}


function changeFocus(index){
  document.onkeydown = function(event) {
    switch (event.keyCode) {
       case 37:
             var value = parseInt(index) - 1;
             document.getElementById("quantity_"+value).focus();
          break;
       case 39:
             var value = parseInt(index) + 1;
             document.getElementById("quantity_"+value).focus();
          break;
    }
  };
}

function gotFocus(index){
  document.getElementById("quantity_"+index).style.backgroundColor = "red";
  document.getElementById("quantity_"+index).style.color = "white";
}

function lostFocus(index){
  document.getElementById("quantity_"+index).style.backgroundColor = "white";
  document.getElementById("quantity_"+index).style.color = "black";
}

function checkboxSizeCheck(value){

  if(value == '0') {
     document.getElementById('checkAllSize').value = '1';
     $("#size_list_div :checkbox").attr('checked', true);
  }
  else if (value == '1') {
     document.getElementById('checkAllSize').value = '0';
     $("#size_list_div :checkbox").attr('checked', false);
  }

}


function checkboxCountryCheck(value){

  if(value == '0') {
     document.getElementById('checkAllCountry').value = '1';
     $("#country_list_div :checkbox").attr('checked', true);
  }
  else if (value == '1') {
     document.getElementById('checkAllCountry').value = '0';
     $("#country_list_div :checkbox").attr('checked', false);
  }

}

</script>
