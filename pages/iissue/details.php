<?php
error_reporting(E_ALL);
?>
<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/iissue/insert.php'; ?>
<?php require_once '../../DB/iissue/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>

<?php

$user_id = $_SESSION['id'];
$order_id = $_GET['id'];

//select order details
$selectOrder = new select_order();
$order_result = $selectOrder->select_with_id($order_id);
$order_details = mysqli_fetch_assoc($order_result);

//select country list with order id
$orderedCountryList = $selectOrder->select_oder_country_with_id($order_id);

//select child of order details
$order_child_result_quantity = $selectOrder->select_child_with_id($order_id);

$rowNumber = mysqli_num_rows($order_child_result_quantity);

$selectSize = new select_size();
$size_list =  $selectSize->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$iissueInsert = new insert();
$iissueSelect = new select_iissue();

if (isset($_POST['btn'])) {

    for($i=1; $i<=$rowNumber; $i++){

    $message = $iissueInsert->save(
                         $order_id,
                         $_POST['issue_country_'.$i],
                         $_POST['issue_size_'.$i],
                         $_POST['issue_quantity_'.$i],
                         $user_id
                         );

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
                    Cutting Details <label></label>
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
            <!-- End Page Header -->
            <div id="form_1" class="box-body  w3-animate-right w3-card-4" style="padding:10px;">

              <div class="row">
              <div class="col-md-6">
              <div class="input-group margin" style="margin-top: 0px">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">Style Name <span style="color: red">*</span></label>
                                <select disabled class="form-control col-md-6" name="style_select" id="style_select">
                                <option>Select Name</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($style_list))
                                    {
                                      if($order_details['style'] == $row['id'])
                                      {
                                ?>
                                <option selected value="<?php echo $row['id']; $style = $row['id'];?>"><?php echo $row['style_name']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
              </div>

              <div class="input-group margin" style="margin-top: 20px">
                                <label class="form-control-label btn btn-success" style="margin-right:48px;">Country <span style="color: red">*</span></label>
                                <select disabled class="form-control col-md-6" name="country_select" id="country_select">
                                <option>Select Country</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($country_list))
                                      {
                                        if($order_details['country'] == $row['id'])
                                        {
                                ?>
                                <option selected value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
              </div>

              <div class="input-group margin" style="margin-top: 20px">
                                <label class="form-control-label btn btn-success" style="margin-right:70px;">Time <span style="color: red">*</span></label>
                                <input disabled type="text" value="<?php echo $order_details['creation_time']; ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
               </div>

              </div>


              <div class="col-md-6">
              <div class="input-group margin">
                                <label class="form-control-label btn btn-success" style="margin-right:20px;">PO Number <span style="color: red">*</span></label>
                                <select disabled class="form-control col-md-6" name="po_select" id="po_select">
                                <option>Select PO</option>

                                <?php
                                  while ($row = mysqli_fetch_assoc($po_list))
                                      {
                                        if($order_details['po'] == $row['id'])
                                        {
                                ?>
                                <option selected value="<?php echo $row['id']; $po_number = $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                <?php
                                      }
                                    }
                                ?>
                              </select>
               </div>

               <div class="input-group margin" style="margin-top: 20px">
                                 <label class="form-control-label btn btn-success" style="margin-right:70px;">Date <span style="color: red">*</span></label>
                                 <input disabled type="text" value="<?php echo $order_details['creation_date']; ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
                </div>



                <div class="input-group margin" style="margin-top: 20px">
                                  <label class="form-control-label btn btn-success" style="margin-right:50px;">Cutting <span style="color: red">*</span></label>
                                  <input disabled type="text" value="<?php echo $cutting_plan = $order_details['cutting_plan']." %"; ?>" class="form-control col-md-6" name="creation_date" id="creation_date">
                 </div>


             </div>

             </div>

                <form method="post" enctype="multipart/form-data" action="">

                 <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                   <div class="table-responsive">

                     <?php

                      $i = 1;
                      while ($country = mysqli_fetch_assoc($orderedCountryList)) {

                       $order_child_size_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
                       $order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
                       $total = 0;
                       ?>
                       <table class="w3-table-all w3-small" border="1">
                           <thead style="background-color:gray;color:black;width:200px;">
                             <tr>
                                 <th style="width:140px;" class="btn-gradient-03">Country</th>
                                 <th style="width:100px;" class="btn-gradient-03"><?php echo $country['country_name']." "; ?></th>
                                 <th style="width:140px;" class="btn-gradient-03">TOD</th>
                                 <th style="width:100px;" class="btn-gradient-03"><?php echo $country['tod']." "; ?></th>
                                 <th style="width:140px;" class="btn-gradient-03">Shipment</th>
                                 <th style="width:100px;" class="btn-gradient-03"><?php echo $country['shipment']." "; ?></th>
                             </tr>
                             <tr class="btn-gradient-01">
                                   <th style="width:140px;">Style Name</th>
                                   <th style="width:100px;">PO Number</th>
                                   <th  colspan="<?php echo mysqli_num_rows($order_child_size_country); ?>" class="text-center">Size List</th>
                                   <th style="width:100px;">Total Quantity</th>
                              </tr>
                              <tr>
                                  <th style="width:140px;"><?php echo $order_details['style_name']; ?></th>
                                  <th style="width:100px;"><?php echo $order_details['po_number']; ?></th>
                              <?php
                                  while ($row = mysqli_fetch_assoc($order_child_size_country)){
                              ?>
                                  <th style="width:20px;" class="btn-gradient-02">
                                    <?php
                                          $size =  $row['size'];
                                          echo $row['size'];
                                    ?>
                                  </th>
                              <?php
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
                                   <td style="color:black;width:20px;"><?php echo $quantity = $row['quantity']; ?></td>
                               <?php
                                     $total += $quantity;
                                   }
                                   mysqli_free_result($order_child_quantity_country);
                               ?>

                                <td class="text-center" style="color:black;"><?php echo $total; ?></td>
                             </tr>

                             <tr>
                             <td style="width:140px;"></td>
                             <td style="width:100px;" class="text-center btn-gradient-01">Cutting</td>

                             <?php
                                 $order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
                                 $total = 0;
                                 while ($row = mysqli_fetch_assoc($order_child_quantity_country))
                                 {
                             ?>
                                 <td style="color:black;width:20px;"><?php echo $quantity = ceil((($cutting_plan*$row['quantity'])/100))+$row['quantity']; ?></td>
                             <?php
                                   $total += $quantity;
                                 }
                             ?>

                              <td class="text-center" style="color:black;"><?php echo $total; ?></td>
                           </tr>

                           <tr>
                           <td style="width:140px;"></td>
                           <td style="width:100px;" class="text-center btn-gradient-01">Input Issue</td>

                           <?php
                               $order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
                               while ($row = mysqli_fetch_assoc($order_child_quantity_country))
                               {
                                 $get = $iissueSelect->select_input_issue_quantity($po_number,$style,$country['country_id'],$row['size']);
                                 $value = mysqli_fetch_assoc($get);
                           ?>
                               <td style="color:black;width:20px;">
                                 <input type="number" name="issue_quantity_<?php echo $i; ?>" style="width:60px;" value="<?php echo $value['quantity'];?>"></input>
                                 <input type="hidden" name="issue_country_<?php echo $i; ?>" value="<?php echo $row['country_id']; ?>" style="width:60px;"></input>
                                 <input type="hidden" name="issue_size_<?php echo $i; ?>" value="<?php echo $row['size']; ?>" style="width:60px;"></input>
                               </td>
                           <?php
                               $i++;
                               }
                           ?>

                            <td class="text-center" style="color:black;"></td>
                         </tr>
                           </tbody>


                       </table>
                       <br>
                       <?php
                             mysqli_free_result($order_child_result_quantity);
                       }
                       ?>


                  </div>

                </div>


                <div class="text-center" style="padding-bottom: 10px;">
                <button name="btn" class="btn btn-gradient-03" type="submit">Save Info</button>
                </div>

         </form>

       </div>


</div>
</div>
<script>

$(document).ready(function () {


});

function checkQrCode(value)
{
  console.log(value);

  var arrayValue = value.split(',');
  console.log(arrayValue);

  var size = arrayValue[1].split('=');
  console.log("size : "+size[1]);

  var style = arrayValue[2].split('=');
  console.log("style : "+style[1]);

  var buyer = arrayValue[3].split('=');
  console.log("buyer : "+buyer[1]);

  var color = arrayValue[4].split('=');
  console.log("color : "+color[1]);

  var po = arrayValue[5].split('=');
  console.log("po : "+po[1]);

  var cutno = arrayValue[6].split('=');
  console.log("cutno : "+cutno[1]);

  var shade = arrayValue[7].split('=');
  console.log("shade : "+shade[1]);

}

</script>
