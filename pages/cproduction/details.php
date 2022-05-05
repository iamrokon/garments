<?php require_once '../../layout/main.php';?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/cut_number/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/shade/select.php'; ?>
<?php require_once '../../DB/section/select.php'; ?>

<style>

    @media print {
        #printbtn {
            display :  none;
        }
        #reloadButton {
            display :  none;
        }
        #footer{
            display :  none;
        }
        #search{
            display :  none;
        }
        a[href]:after {
            content: none !important;
        }
    }

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>

<?php

$user_id = $_SESSION['id'];
$cut_pro_id = $_GET['id'];

$selectSize = new select_size();
$size_list =  $selectSize->select_all();
while ($row = mysqli_fetch_assoc($size_list)){
  $all_size[] = $row;
}

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
$section_list =  $selectShade->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectCuttingProduction = new select_cproduction();
$cut_pro_result = $selectCuttingProduction->select_with_id($cut_pro_id);
$cut_pro_details = mysqli_fetch_assoc($cut_pro_result);

// echo '<pre>';
// print_r($cut_pro_details);
// echo '</pre>';

$cut_pro_child_list = $selectCuttingProduction->select_child_with_id($cut_pro_id);
$num_rows = mysqli_num_rows($cut_pro_child_list)/$cut_pro_details['bundle_no'];
// echo '<pre>';
// print_r($num_rows);
// echo '</pre>';

$rows[] = null;

while($row = $cut_pro_child_list->fetch_row()) {
  $rows[] = $row;
}
// echo '<pre>';
// print_r($rows);
// echo '</pre>';
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>Cutting Production Details</label>
                    <a class="btn badge-text badge-text-small info" href="pages/cproduction/excel.php?id=<?php echo $cut_pro_id; ?>" style="margin-left:800px;">Excel</a>
                    <a class="btn badge-text badge-text-small info" href="pages/cproduction/update.php?id=<?php echo $cut_pro_id; ?>" style="">Update</a>
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

            <div class=" w3-card-4">


            <div id="form_1" class="box-body  w3-animate-right" style="padding:10px;">

              <div class="row" style="padding:10px;">

                <table class="w3-table-all w3-small" border="1">

                  <tr class="btn-gradient-01">
                    <th class="text-center">Buyer Name</th>
                    <th class="text-center">PO Number</th>
                    <th class="text-center">Cut Number</th>
                    <th class="text-center">Color Name</th>
                    <th class="text-center">Style Name</th>
                  </tr>

                  <tr style="color:black;">
                    <td class="text-center"> <?php echo $cut_pro_details['buyer_name']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['po_number']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['cut_number']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['color_name']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['style_name']; ?> </td>
                  </tr>

                </table>


                <table class="w3-table-all w3-small" border="1">

                  <tr class="btn-gradient-01">
                    <th class="text-center">Shade Group</th>
                    <th class="text-center">Lay Number</th>
                    <th class="text-center">Section</th>
                    <th class="text-center">Total Pcs</th>

                  </tr>

                  <tr style="color:black;">
                    <td class="text-center"> <?php echo $cut_pro_details['shade_name']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['lay']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['section_name']; ?> </td>
                    <td class="text-center"> <?php echo $cut_pro_details['total_pcs']; ?> </td>
                  </tr>

                </table>

              </div>

             <br>

       </div>


       <div class="row" style="margin-left:10px;">
       <div class="col-md-2">
       <label class="form-control-label">Print Number <span style="color:red;">*</span></label>

       <div class="input-group">
           <span class="input-group-addon addon-primary">
               <i class="la la-file-text"></i>
           </span>
           <input type="text" class="form-control" id="print_number" placeholder ="Enter Number" required="required">
       </div>
     </div>
     </div>
     <br>

        <div id="print_token" style="margin-left:10px;">


        </div>
        <br>


      <form method="post" enctype="multipart/form-data" action="">
      <div id="form_2" class="box-body  w3-animate-right" style="padding:10px;">


         <div class="row">

         <?php
              for($i = 1; $i<=$cut_pro_details['total_pcs']; $i++)
              {
                $bundleNo = (($i-1)*$cut_pro_details['bundle_no']) + 1;

                if($i%2 == 0){
          ?>

          <div class="col-md-6" >
            <div class="form-group">

                <table class="w3-table-all w3-small" id="odd_table">

                  <thead>
                    <tr style="color:black;" class="btn-gradient-01">
                    <th class="text-center"></th>
                    <th colspan="1" class="text-center"></th>
                    <th colspan="2" class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    </tr>

                    <tr style="color:black;">
                    <th class="text-center">Ticket</th>
                    <th colspan="1" class="text-center"><?php echo $i ?></th>
                    <th class="text-center"></th>
                    <th class="text-center">Group</th>
                    <th class="text-center">
                      <?php
                            if($rows[$bundleNo][20] != '0')
                            {
                             echo $rows[$bundleNo][20];
                           }
                       ?>
                    </th>
                    <th class="text-center">Size</th>
                    <th class="text-center">
                      <?php //echo $rows[$bundleNo][19]; ?>
                      <?php
                      foreach ($all_size as $row)
                      {
                        if($rows[$bundleNo][19] == $row['id']){
                          if($row['inseam']){
                            echo $row['size_num']."/".$row['inseam'];
                          }else {
                            echo $row['size_num'];
                          }
                        }
                      }
                      ?>
                    </th>
                    </tr>

                    <tr style="color:black;">
                    <th class="text-center">Bund No.</th>
                    <th class="text-center">Serial From</th>
                    <th class="text-center">Serial To</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Pattern</th>
                    <th class="text-center">Shade</th>
                    <th class="text-center">Country</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php
                         for($k = 0; $k<$cut_pro_details['bundle_no']; $k++){
                    ?>
                    <tr style="color:black;">
                    <td class="text-center"><?php echo ($bundleNo+$k); ?></td>
                    <td class="text-center">
                    <input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][4]; ?>"></input>
                    </td>
                    <td class="text-center"><input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][5]; ?>"></input></td>
                    <?php
                        // echo '<pre>';
                        // print_r($rows[($bundleNo+$k)][6]);
                        // echo '</pre>';
                    ?>
                    <td class="text-center"><input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][6]; ?>"></input></td>
                    <td class="text-center"><input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][7]; ?>"></input></td>
                    <td class="text-center"><input readonly style="width:60px;" value="<?php echo $rows[($bundleNo+$k)][18]; ?>"></input></td>
                    <td class="text-center">
                    <input readonly style="width:60px;" value="<?php echo $rows[($bundleNo+$k)][17]; ?>"></input>
                    </td>
                    </tr>
                    <?php
                     }
                    ?>

                    </tbody>

                </table>

            </div>
          </div>

        <?php
              } else {
         ?>

          <div class="col-md-6" >
            <div class="form-group">

              <table class="w3-table-all w3-small" id="even_table">

                <thead>
                  <tr style="color:black;" class="btn-gradient-01">
                  <th class="text-center"></th>
                  <th colspan="1" class="text-center"></th>
                  <th colspan="2" class="text-center"></th>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                  <th class="text-center"></th>
                  </tr>

                  <tr style="color:black;">
                  <th class="text-center">Ticket</th>
                  <th colspan="1" class="text-center"><?php echo $i ?></th>
                  <th class="text-center"></th>
                  <th class="text-center">Group</th>
                  <th class="text-center">
                    <?php
                          if($rows[$bundleNo][20] != '0')
                          {
                           echo $rows[$bundleNo][20];
                         }
                     ?>
                  </th>
                  <th class="text-center">Size</th>
                  <th class="text-center">
                    <?php //echo $rows[$bundleNo][19]; ?>


                    <?php
                    foreach ($all_size as $row)
                    {
                      if($rows[$bundleNo][19] == $row['id']){
                        if($row['inseam']){
                          echo $row['size_num']."/".$row['inseam'];
                        }else {
                          echo $row['size_num'];
                        }
                      }
                    }
                    ?>

                  </th>
                  </tr>

                  <tr style="color:black;">
                  <th class="text-center">Bund No.</th>
                  <th class="text-center">Serial From</th>
                  <th class="text-center">Serial To</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-center">Pattern</th>
                  <th class="text-center">Shade</th>
                  <th class="text-center">Country</th>
                  </tr>
                  </thead>

                  <tbody>
                    <?php
                         for($k = 0; $k<$cut_pro_details['bundle_no']; $k++){
                    ?>
                    <tr style="color:black;">
                    <td class="text-center"><?php echo ($bundleNo+$k); ?></td>
                    <td class="text-center">
                    <input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][4]; ?>"></input>
                    </td>
                    <td class="text-center"><input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][5]; ?>"></input></td>
                    <td class="text-center"><input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][6]; ?>"></input></td>
                    <td class="text-center"><input readonly style="width:60px;" type="text" value="<?php echo $rows[($bundleNo+$k)][7]; ?>"></input></td>
                    <td class="text-center"><input readonly style="width:60px;" value="<?php echo $rows[($bundleNo+$k)][18]; ?>"></input></td>
                    <td class="text-center">
                    <input readonly style="width:60px;" value="<?php echo $rows[($bundleNo+$k)][17]; ?>"></input>
                    </td>
                    </tr>
                    <?php
                     }
                    ?>
                  </tbody>

              </table>

            </div>
          </div>


        <?php
               }
             }
             ?>


        </div>

      </div>

    </form>


</div>
</div>
</div>
</div>

<script>

$(document).ready(function () {

  var totalTokenNumber = '<?php echo $num_rows; ?>';
  var cut_pro_id = '<?php echo $cut_pro_id; ?>';
  var print_number = 5;

  if(isNaN(print_number)) print_number = 0;

  var totalBtn = '<a href="./pages/cproduction/qr/generate_all.php?cut_pro_id='+cut_pro_id+'" class="form-control-label btn badge-text badge-text-small info" style="color:white;margin-left:10px;margin-top:10px;" target="_blank">Print All</a>';

  for(var i=1; i<=totalTokenNumber; i++){
  totalBtn += '<a class="form-control-label btn badge-text badge-text-small info" style="margin-left:10px;margin-top:10px;color:white;" onclick="getBtnId('+i+')" id="ticket_'+i+'" target="_blank">Token '+i+'</a>';
  };

  $('#print_token').append(totalBtn);

});


function getBtnId(ticketNo){

  var printNumber = document.getElementById('print_number').value;
  var cut_pro_id = '<?php echo $cut_pro_id; ?>';

  var link = './pages/cproduction/qr/generate.php?cut_pro_id='
              +cut_pro_id+'&&ticket='+ticketNo+'&&print_number='+printNumber;

  document.getElementById('ticket_'+ticketNo).href = link;
  document.getElementById("ticket_"+ticketNo).style.backgroundColor = "red";

}

</script>
