<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/order/update.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/insert.php'; ?>

<?php require_once '../../DB/color/select.php'; ?>

<?php
$user_id = $_SESSION['id'];
$order_id = $_GET['id'];

$totalQuantity = 0;

//select order details
$selectOrder = new select_order();
$order_result = $selectOrder->select_with_id($order_id);
$order_details = mysqli_fetch_assoc($order_result);

//select country list with order id
$orderedCountryList = $selectOrder->select_oder_country_with_id($order_id);

//select child of order details
$order_child_result_size = $selectOrder->select_child_with_id($order_id);
$order_child_result_quantity = $selectOrder->select_child_with_id($order_id);

$selectSize = new select_size();
$size_list =  $selectSize->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$selectColor = new select_color();
$color_list =  $selectColor->select_all();
while ($row_color = mysqli_fetch_assoc($color_list)){
  $colors[] = $row_color;
}
$color_list =  $selectColor->select_all();
while ($row_country = mysqli_fetch_assoc($country_list)){
  $countries[] = $row_country;
}

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$orderUpdate = new update();
$totalSizeWiseQuantity = 1;
$totalSizeWiseQuantity2 = 1;


if (isset($_POST['btn'])) {
    // echo '<pre>';
    // print_r($_POST['previous_countries']);
    // echo '</pre>';
    // exit();
    $previous_countries = $_POST['previous_countries'];

    $order_details_id = $order_details['id'];
    $style_select = $_POST['style_select'];
    $po_select = $_POST['po_select'];
    $color_id = $_POST['country_color_1'];

    $message = $orderUpdate->update_order_parent(
                                                 $po_select,
                                                 $style_select,
                                                 $order_details_id,
                                                 $color_id,
                                                 $user_id
                                                );

    $totalSizeWiseQuantity = $_POST['totalSizeWiseQuantity'];

    for($i = 1; $i<=$totalSizeWiseQuantity; $i++)
    {
       $mgs = $orderUpdate->update_size_quantity_with_id(
                                                         $_POST['id_'.$i],
                                                         $_POST['country_size_'.$i],
                                                         $_POST['quantity_'.$i],
                                                         $_POST['sizeCountry_'.$i],
                                                         $user_id
                                                        );
    }


    $countryCount = $_POST['countryCount'];
    for($k=1;$k<=$countryCount;$k++)
    {
      $message = $orderUpdate->order_country_update(
                                                    $order_id,
                                                    $_POST['country_order_'.$k],
                                                    $_POST['old_country_id_'.$k],
                                                    $_POST['country_color_'.$k],
                                                    $_POST['tod_'.$k],
                                                    $_POST['shipment_'.$k],
                                                    $user_id
                                                   );
    }


    //new country addition logic
    $newInsert = $_POST['newInsert'];

    if($newInsert > 0){

      $orderInsert = new insert();
      $sizeCount = $_POST['sizeCount'];

      for($i=1;$i<=$sizeCount;$i++)
      {
        if (!in_array($_POST['country_insert_'.$i], $previous_countries)){
        $size = "";
        $message = $orderInsert->order_quantity_save(
                                                 $order_id,
                                                 $size,
                                                 $_POST['size_id_'.$i],
                                                 $_POST['quantity_insert_'.$i],
                                                 $_POST['country_insert_'.$i],
                                                 $user_id
                                                );
        }
      }

      for($k=1;$k<=$newInsert;$k++)
      {
        if (!in_array($_POST['country_select_'.$k], $previous_countries)){
        $message = $orderInsert->order_country_save(
                                                    $order_id,
                                                    $_POST['country_select_'.$k],
                                                    $_POST['country_color_'.$k],
                                                    $_POST['tod_insert_'.$k],
                                                    $_POST['shipment_insert_'.$k],
                                                    $user_id
                                                    );
        }
      }
    }

    $message = $orderUpdate->update_cutting_plan($order_id,$_POST['cutting_plan'],$user_id);

    if($mgs){
        $_SESSION['mgs'] = $message;
        header('Location: order_details.php?id='.$order_id);
    }

}


?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 8px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>Order Details</label>
                </span>
            </div>
            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">


              <form method="post" enctype="multipart/form-data" action="">

              <div class="row">
              <div class="col-md-6">
              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">Style Name <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="style_select" id="style_select">
                                <option>Select Name</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($style_list))
                                    {
                                      if($order_details['style'] == $row['id'])
                                      {
                                ?>
                                <option selected value="<?php echo $row['id'] ?>"><?php echo $row['style_name']; ?></option>
                                <?php
                                      }
                                      else
                                      {
                                ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['style_name']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
              </div>

              <div class="input-group margin" style="margin-top: 20px">
                              <label class="form-control-label btn btn-success" style="margin-right:48px;">Country <span style="color: red">*</span></label>
                              <div class="form-control col-md-6">
                                <?php
                                $countryList = $selectOrder->select_oder_country_with_id($order_id);
                                while ($country = mysqli_fetch_assoc($countryList)) {
                                          echo $country['country_name']." ";?>
                                <input type="hidden" name="previous_countries[]" value="<?php echo $country['country_id'];?>">
                                          <?php
                                } ?>
                              </div>
              </div>

               <div class="input-group margin" style="margin-top: 20px">
                                <label class="form-control-label btn btn-success" style="margin-right:70px;">Time <span style="color: red">*</span></label>
                                <input disabled type="text" value="<?php echo $order_details['creation_time']; ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
               </div>

              </div>


              <div class="col-md-6">
              <div class="input-group margin">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">PO Number <span style="color: red">*</span></label>
                                <select class="form-control col-md-6" name="po_select" id="po_select">
                                <option>Select PO</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($po_list))
                                      {
                                        if($order_details['po'] == $row['id'])
                                        {
                                ?>
                                <option selected value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                <?php
                                      }
                                        else
                                        {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
               </div>

               <div class="input-group margin" style="margin-top: 20px">
                                 <label class="form-control-label btn btn-success" style="margin-right:70px;">Date <span style="color: red">*</span></label>
                                 <input disabled type="text" value="<?php
                                 if($order_details['creation_date']){
                                    echo $order_details['creation_date'];
                                    }
                                  ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
               </div>

               <div class="input-group margin" style="margin-top: 20px">
                                <label class="form-control-label btn btn-success" style="margin-right:50px;">Cutting(%) Update<span style="color: red">*</span></label>
                                 <input type="text" value="<?php echo $cutting_plan = $order_details['cutting_plan']; ?>" class="form-control col-md-6" name="cutting_plan" id="cutting_plan">
               </div>

             </div>

             </div>



                  <input type="hidden" name="newInsert"  id="newInsert" value="0"></input>
                  <input type="hidden" name="sizeCount"  id="sizeCount" value="0"></input>

                 <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">


                   <div id="tableDiv" class="table-responsive">

                     <?php
                     $countryNumber = 0;
                     while ($country = mysqli_fetch_assoc($orderedCountryList)) {
                       $sizeClass = 1;
                       $sizeString = "";
                       $quantityString = "";
                       $totalSizeCount = 0;
                       $order_child_size_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
                       $order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
                       $total = 0;
                       $countryNumber++;
                       ?>

                       <input type="hidden" name="countryCount" class="countryCount" value="<?php echo $countryNumber; ?>"></input>
                       <!-- <input type="hidden" name="countryID_<?php echo $countryNumber; ?>" value="<?php echo $country['country_id']; ?>"></input> -->

                       <div class="table-responsive table-striped w3-hoverable w3-small">
                       <table class="table-responsive w3-table-all w3-small" border="1">
                           <thead style="background-color:gray;color:black;width:300px;">
                             <tr>
                                 <th style="width:140px;" class="btn-gradient-03">Country</th>
                                 <th style="width:100px;" class="btn-gradient-03">
                                   <?php //echo $country['country_name']." "; ?>
                                   <select style="height:20px;" name="country_order_<?php echo $countryNumber; ?>" id="country_order_<?php echo $countryNumber; ?>" onchange="countryChange(this.value,<?php echo $countryNumber; ?>)">
                                   <option>Select Country</option>


                                   <?php

                                     foreach ($countries as $key => $countryInfo)
                                         {
                                           if($countryInfo['id'] == $country['country_id'] )
                                           {
                                   ?>
                                   <option selected value="<?php echo $countryInfo['id']; ?>"><?php echo $countryInfo['full_name']; ?></option>
                                   <?php
                                         }
                                           else
                                           {
                                   ?>
                                   <option value="<?php echo $countryInfo['id']; ?>"><?php echo $countryInfo['full_name']; ?></option>
                                   <?php
                                         }
                                       }
                                   ?>
                                   </select>
                                 </th>
                                 <th style="width:100px;" class="btn-gradient-03">Color</th>
                                 <th style="width:100px;" class="btn-gradient-03">
                                   <?php
                                        $countryColor = $country['color_id'];
                                        $color_name = $country['color_name']." ";
                                   ?>

                                  <select style="width:140px;height:20px" name="country_color_<?php echo $countryNumber; ?>" onchange="changeColor(this.value)" id="country_color_<?php echo $countryNumber; ?>">
                                  <option>Select Color</option>


                                  <?php
                                    foreach ($colors as $key => $color)
                                        {
                                          if($color['id'] == $country['color_id'] )
                                          {
                                  ?>
                                  <option selected value="<?php echo $color['id']; ?>"><?php echo $color['name']; ?></option>
                                  <?php
                                          }
                                          else
                                          {
                                  ?>
                                  <option value="<?php echo $color['id']; ?>"><?php echo $color['name']; ?></option>
                                  <?php
                                        }
                                      }
                                  ?>
                                  </select>


                                 </th>
                                 <th style="width:140px;" class="btn-gradient-03">TOD</th>
                                 <th style="width:100px;" class="btn-gradient-03"><input style="width:145px;" type="date" name="tod_<?php echo $countryNumber; ?>" id="tod_<?php echo $countryNumber; ?>" value="<?php echo $country['tod']; ?>"></input></th>
                                 <th style="width:140px;" class="btn-gradient-03">Shipment</th>
                                 <th style="width:100px;" class="btn-gradient-03"><input style="width:145px;" type="date" name="shipment_<?php echo $countryNumber; ?>" id="shipment_<?php echo $countryNumber; ?>" value="<?php echo $country['shipment']; ?>"></input></th>
                             </tr>
                             <tr class="btn-gradient-01">
                                   <th style="width:140px;">Style Name</th>
                                   <th style="width:100px;">PO Number</th>
                                   <th  colspan="<?php echo $size_country_number = mysqli_num_rows($order_child_size_country); ?>" class="text-center">Size List</th>
                                   <th style="width:100px;">Total Quantity</th>
                              </tr>
                              <tr>
                                  <th style="width:140px;"><?php echo $style_name = $order_details['style_name']; ?></th>
                                  <th style="width:100px;"><?php echo $po_number = $order_details['po_number']; ?></th>
                              <?php
                                  //$sizeNumber = 1;
                                  while ($row = mysqli_fetch_assoc($order_child_size_country)){
                              ?>


                                  <th style="width:20px;" class="btn-gradient-02">

                                    <!-- <input type="hidden"  name="old_country_id_<?php //echo $countryNumber; ?>" id="old_country_id_<?php //echo $countryNumber; ?>" value="<?php //echo $country['country_id']; ?>">

                                    <input name="sizeCountry_<?php //echo $totalSizeWiseQuantity; ?>" type="hidden" class="sizeCountry_<?php //echo $countryNumber;?>" value="<?php //echo $country['country_id']; ?>"></input> -->
                                    <?php
                                         // $quantity = $row['quantity'];
                                         // $id = $row['id'];
                                         // echo '<input name="quantity_'.$totalSizeWiseQuantity.'" id="quantity_'.$totalSizeWiseQuantity.'" onfocus="gotFocus('.$totalSizeWiseQuantity.')" onfocusout="lostFocus('.$totalSizeWiseQuantity.')" onkeyup="quantityUpdate('.$countryNumber.'),changeFocus('.$totalSizeWiseQuantity.')" type="number" value='.$quantity.'></input>';
                                         // echo '<input name="id_'.$totalSizeWiseQuantity.'" type="hidden" value='.$id.'></input>';
                                         // echo '<input name="totalSizeWiseQuantity" id="totalSizeWiseQuantity" type="hidden" value='.$totalSizeWiseQuantity.'></input>';
                                         // $totalSizeWiseQuantity++;
                                     ?>




                                    <select style="width:140px;height:20px" class="country_size_<?php echo $sizeClass; ?>" name="country_size_<?php echo $totalSizeWiseQuantity2; ?>" onchange="changeSize(this.value,<?php echo $sizeClass; ?>)" id="country_size_<?php echo $totalSizeWiseQuantity2; ?>">
                                    <option>Select Size</option>


                                    <?php
                                      foreach ($size_list as $key => $size)
                                          {
                                            if($size['id'] == $row['size_id'] )
                                            {
                                    ?>
                                    <option selected value="<?php echo $size['id']; ?>"><?php echo $size['size_num']; ?></option>
                                    <?php
                                            }
                                            else
                                            {
                                    ?>
                                    <option value="<?php echo $size['id']; ?>"><?php echo $size['size_num']; ?></option>
                                    <?php
                                          }
                                        }
                                        $totalSizeWiseQuantity2++;
                                    ?>
                                    </select>
                                    <?php
                                          //echo $row['size'];
                                    ?>
                                  </th>
                              <?php

                                    $sizeString .= '<th style="width:20px;" class="btn-gradient-02">'
                                                    .$row['size'].
                                                     '</th>';

                                    $totalSizeCount ++;

                                    $sizeClass++;

                                    }
                              ?>
                              <th style="width:100px;"></th>
                             </tr>
                           </thead>
                           <tbody>
                               <tr>
                               <td style="width:140px;"></td>
                               <td style="width:100px;" class="text-center btn-gradient-01">Order</td>

                               <?php
                                   while ($row = mysqli_fetch_assoc($order_child_quantity_country))
                                   {
                               ?>
                                   <td style="color:black;width:20px;">

                                     <input type="hidden"  name="old_country_id_<?php echo $countryNumber; ?>" id="old_country_id_<?php echo $countryNumber; ?>" value="<?php echo $country['country_id']; ?>">

                                     <input name="sizeCountry_<?php echo $totalSizeWiseQuantity; ?>" type="hidden" class="sizeCountry_<?php echo $countryNumber;?>" value="<?php echo $country['country_id']; ?>"></input>
                                     <?php
                                          $quantity = $row['quantity'];
                                          $id = $row['id'];
                                          echo '<input name="quantity_'.$totalSizeWiseQuantity.'" id="quantity_'.$totalSizeWiseQuantity.'" onfocus="gotFocus('.$totalSizeWiseQuantity.')" onfocusout="lostFocus('.$totalSizeWiseQuantity.')" onkeyup="quantityUpdate('.$countryNumber.'),changeFocus('.$totalSizeWiseQuantity.')" type="number" value='.$quantity.'></input>';
                                          echo '<input name="id_'.$totalSizeWiseQuantity.'" type="hidden" value='.$id.'></input>';
                                          echo '<input name="totalSizeWiseQuantity" id="totalSizeWiseQuantity" type="hidden" value='.$totalSizeWiseQuantity.'></input>';
                                          $totalSizeWiseQuantity++;
                                      ?>
                                   </td>
                               <?php
                                     $total += $quantity;

                                     $quantityString .= '<td style="color:black;width:20px;">'
                                                        .'<input name="quantity_" id="quantity_"  type="number" value="0"></input>'.
                                                         '</td>';
                                   }
                               ?>

                                <td class="text-center" style="color:black;"><text id="countryTotalQuantity_<?php echo $countryNumber; ?>"><?php echo $total; ?></text></td>
                             </tr>
                           </tbody>


                       </table>
                     </div>
                       <br>
                       <?php
                             $totalQuantity += $total;
                             //mysqli_free_result($order_child_result_quantity);
                             mysqli_free_result($order_child_quantity_country);
                       }
                       ?>


                  </div>

       </div>

       <div class="text-center" style="padding-bottom: 10px;">
       <label name="add_country" onclick="addNewCountry()" class="btn btn-gradient-02" style="margin-top:8px;">Add Country</label>
       <button name="btn" class="btn btn-gradient-03" type="submit">UPDATE</button>
       <div readonly class="btn btn-gradient-01">Total Quantity <text id="totalQuantityOrder"><?php echo $totalQuantity;?></text> </div>
       </div>

     </form>

       </div>

</div>
</div>
<script>

var countryCombo = '<option value="">Select Country</option>';
var count = 1;
var sizeArray = [];

//get all country list
$.get("ajax/all_country_list.php", function(data, status){

         data = JSON.parse(data);
         data.forEach(function(item){
           countryCombo += '<option value="'+item.id+'">'+item.full_name+'</option>'
         });

       });


$.get("ajax/get_order_unique_size_list.php?id=<?php echo $order_id; ?>", function(data, status){
                data = JSON.parse(data);
                data.forEach(function(item){
                sizeArray.push(item['size_id']);
             });
        });
function countryChange(value,rowClass){
  var x = document.getElementsByClassName("sizeCountry_"+rowClass);
  //document.getElementById("old_country_id_"+rowClass).value = x[0];
  var i;
  for (var i = 0; i < x.length; i++) {
    x[i].value = value;
  }
}
function changeSize(value,rowClass){
  // var x = document.getElementsByClassName("country_size_"+rowClass);
  // var i;
  // for (var i = 0; i < x.length; i++) {
  //   x[i].value = value;
  // }
}

function quantityUpdate(countryNumber){
      var totalSizeList = '<?php echo ($totalSizeWiseQuantity-1); ?>';
      var totalCountry = '<?php echo $countryNumber; ?>';
      var perCountry = parseInt(totalSizeList/totalCountry);

      var start = ((countryNumber-1)*perCountry)+1;
      var end = (countryNumber)*perCountry;
      var totalAmount = 0;
      var gtotalAmount = 0;

      for(var i = start; i<= end; i++){
         totalAmount += parseInt(document.getElementById("quantity_"+i).value);
      }

      document.getElementById("countryTotalQuantity_"+countryNumber).innerHTML = totalAmount;

      for(var j = 1; j<= totalCountry; j++){
          gtotalAmount += parseInt(document.getElementById("countryTotalQuantity_"+j).innerHTML);
      }

      document.getElementById("totalQuantityOrder").innerHTML = gtotalAmount;
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

function addNewCountry(){

   $(document).ready(function () {

   var totalSizeCount = '<?php echo $totalSizeCount; ?>';
   var quantityString = "";
   console.log(sizeArray);

   for (i = 0; i < sizeArray.length; i++) {

        var quantityId = (i+1) + ((count-1) * totalSizeCount);

        quantityString += '<td style="color:black;width:20px;">'
                         +'<input name="quantity_insert_'+quantityId+'" id="quantity_insert_'+quantityId+'"  type="number" value="0" onfocus="gotFocus('+quantityId+')" onfocusout="lostFocus('+quantityId+')" onkeyup="changeFocus('+quantityId+')"></input>'
                         +'<input name="size_insert_'+quantityId+'" id="size_insert_'+quantityId+'"  type="hidden" value="'+sizeArray[i]+'"></input>'
                         +'<input name="size_id_'+quantityId+'" id="size_id_'+quantityId+'" type="hidden" value="'+sizeArray[i]+'"></input>'
                         +'<input name="country_insert_'+quantityId+'" id="country_insert_'+quantityId+'"  type="hidden" value="0"></input>'
                         +'</td>';

           document.getElementById('sizeCount').value = quantityId;
        }


   var tableDesign = '<br><div class="table-responsive table-striped w3-hoverable w3-small">'
                    +'<table class="table-responsive w3-table-all w3-small" border="1">'
                    +'<thead style="background-color:gray;color:black;width:200px;">'
                    +'<tr>'
                    +'<th style="width:140px;" class="btn-gradient-03">Country</th>'
                    +'<th style="width:100px;" class="btn-gradient-03">'
                    +'<select name="country_select_'+count+'" onchange="checkedCountry(this.value,'+count+','+sizeArray.length+')" required>'
                    +countryCombo
                    +'</select>'
                    +'</th>'
                    +'<th style="width:140px;" class="btn-gradient-03">Color</th>'
                    +'<th style="width:100px;" class="btn-gradient-03"><?php echo $color_name; ?></th>'
                    +'<th style="width:140px;" class="btn-gradient-03">TOD</th>'
                    +'<th style="width:100px;" class="btn-gradient-03">'
                    +'<input style="width:145px;" type="date" name="tod_insert_'+count+'" id="tod_'+count+'" value="" required>'
                    +'<input style="width:145px;" type="hidden" name="country_color_'+count+'" id="country_color_'+count+'" value="<?php echo $countryColor; ?>" >'
                    +'</input></th>'
                    +'<th style="width:140px;" class="btn-gradient-03">Shipment</th>'
                    +'<th style="width:100px;" class="btn-gradient-03"><input style="width:145px;" type="date" name="shipment_insert_'+count+'" id="shipment_'+count+'" value="" required></input></th>'
                    +'</tr>'
                    +'<tr class="btn-gradient-01">'
                    +'<th style="width:140px;">Style Name</th>'
                    +'<th style="width:100px;">PO Number</th>'
                    +'<th  colspan="<?php echo $size_country_number; ?>" class="text-center">Size List</th>'
                    +'<th style="width:100px;">Total Quantity</th>'
                    +'</tr>'
                    +'<tr>'
                    +'<th style="width:140px;"><?php echo $style_name; ?></th>'
                    +'<th style="width:100px;"><?php echo $po_number; ?></th>'
                    +'<?php echo $sizeString; ?>'
                    +'<th style="width:100px;"></th>'
                    +'</tr>'
                    +'</thead>'
                    +'<tbody>'
                    +'<tr>'
                    +'<td style="width:140px;"></td>'
                    +'<td style="width:100px;" class="text-center btn-gradient-01">Order</td>'
                    + quantityString
                    +'<td class="text-center" style="color:black;"><text id="countryTotalQuantity_'+count+'"></text></td>'
                    +'</tr>'
                    +'</tbody>'
                    +'</table>'
                    +'</div>'
                    +'<br>';

         document.getElementById('newInsert').value = count;
         count++;
         $('#tableDiv').append(tableDesign);

       });
}


function checkedCountry(value,count,arrayLength){

    var totalSizeCount = '<?php echo $totalSizeCount; ?>';
    for (i = 0; i < arrayLength; i++) {
       var quantityId = (i+1) + ((count-1) * totalSizeCount);
       document.getElementById('country_insert_'+quantityId).value = value;
     }

}

function changeColor(value){
    var countryCount = document.getElementsByClassName("countryCount");
    for (i = 1; i <= countryCount.length; i++) {
       document.getElementById('country_color_'+i).value = value;
    }
}

function gotFocus(index){
  document.getElementById("quantity_"+index).style.backgroundColor = "red";
  document.getElementById("quantity_"+index).style.color = "white";
}

function lostFocus(index){
  document.getElementById("quantity_"+index).style.backgroundColor = "white";
  document.getElementById("quantity_"+index).style.color = "black";
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
// function changeFocus(index){
//   document.onkeydown = function(event) {
//     switch (event.keyCode) {
//        case 37:
//              var value = parseInt(index) - 1;
//              document.getElementById("quantity_"+value).focus();
//           break;
//        case 39:
//              var value = parseInt(index) + 1;
//              document.getElementById("quantity_"+value).focus();
//           break;
//     }
//   };
// }

</script>
