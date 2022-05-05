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
<?php require_once '../../DB/cproduction/update.php'; ?>
<?php require_once '../../DB/cproduction/insert.php'; ?>
<?php require_once '../../DB/process_c/select.php'; ?>

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

$selectCuttingProduction = new select_cproduction();
$cut_pro_result = $selectCuttingProduction->select_with_id($cut_pro_id);
$cut_pro_details = mysqli_fetch_assoc($cut_pro_result);
$cut_process_result = $selectCuttingProduction->select_process_by_cut_pro_id($cut_pro_id);

foreach ($cut_process_result as $key => $cut_process_result_info) {
    $previous_process_id[] = $cut_process_result_info['pro_id'];
}

if (isset($_POST['btn'])) {

    $total_pcs = $_POST['total_pcs'];
    $update = new update();
    $cproInsert = new insert();


    $cut_pro_id = $_POST['cut_pro_id'];
    $buyer_select = $_POST['buyer_select'];
    $po_select = $_POST['po_select'];
    $cut_num_select = $_POST['cut_num_select'];
    $color_select = $_POST['color_select'];
    $style_select = $_POST['style_select'];
    $shade_select = $_POST['shade_select'];
    $lay_number = $_POST['lay_number'];
    $section_select = $_POST['section_select'];
    $pcs = $_POST['pcs'];

        $allProcess = $_POST['cut_process'];

        for($i=0;$i<count($allProcess);$i++){
          $process_id = $allProcess[$i];
          if (!in_array($process_id, $previous_process_id))
            {
              $message = $cproInsert->production_process_save(
                                                              $cut_pro_id,
                                                              $process_id
                                                             );
            }
        }

        for($i=0;$i<count($previous_process_id);$i++){
          $pre_process_id = $previous_process_id[$i];
          if (!in_array($pre_process_id, $allProcess))
            {
              $message = $update->production_process_update(
                                                              $cut_pro_id,
                                                              $pre_process_id
                                                             );
            }
        }

    $message = $update->update_cutting_pro_info(
                                                $cut_pro_id,
                                                $buyer_select,
                                                $po_select,
                                                $cut_num_select,
                                                $color_select,
                                                $style_select,
                                                $shade_select,
                                                $lay_number,
                                                $section_select,
                                                $pcs
                                                );



    for($i=1; $i<= $total_pcs; $i++){
        $mgs = $update->update_cutting_pro_bundle_with_id(
                                                          $_POST['id_'.$i],
                                                          $_POST['serial_from_'.$i],
                                                          $_POST['serial_to_'.$i],
                                                          $_POST['quantity_'.$i],
                                                          $_POST['pattern_'.$i],
                                                          $_POST['shade_'.$i],
                                                          $_POST['country_'.$i]
                                                         );
    }
    for($k=1;$k<=$total_pcs;$k++)
    {
          $mgs = $update->production_size_update(
                                                    $cut_pro_id,
                                                    $_POST['label_'.$k],
                                                    $k,
                                                    $_POST['size_'.$k]
                                                    );
    }



    if($mgs){
      $_SESSION['mgs'] = $mgs;
      header('Location: details.php?id='.$cut_pro_id);
    } else if ($message){
      $_SESSION['mgs'] = $message;
      header('Location: details.php?id='.$cut_pro_id);
    }

}



$selectSize = new select_size();
$size_list =  $selectSize->select_all();
while ($row = mysqli_fetch_assoc($size_list)){
  $all_size[] = $row;
}
// echo '<pre>';
// print_r($all_size);
// echo '</pre>';

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

$cut_pro_child_list = $selectCuttingProduction->select_child_with_id($cut_pro_id);
$num_rows = mysqli_num_rows($cut_pro_child_list)/5;

$rows[] = null;

while($row = $cut_pro_child_list->fetch_row()) {
  $rows[] = $row;
}

?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style="background: linear-gradient(to bottom, #0000ff 0%, #cc6600 100%);padding: 10px; margin-top: 3px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    <label>Cutting Production Details</label>
                </span>

            </div>

            <div class=" w3-card-4">

          <form method="post" enctype="multipart/form-data" action="">
            <div id="form_1" class="box-body  w3-animate-right" style="padding:10px;">

              <input type="hidden" name="cut_pro_id"  id="cut_pro_id" value="<?php echo $cut_pro_details['id']; ?>"></input>
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
                    <td class="text-center">
                      <?php //echo $cut_pro_details['buyer_name']; ?>


                      <select style="width:150px;" name="buyer_select" id="buyer_select">
                      <option>Select Buyer </option>
                      <?php
                        while ($row = mysqli_fetch_assoc($buyer_list))
                            {
                              if($cut_pro_details['buyer'] == $row['id'])
                              {
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>


                     </td>
                    <td class="text-center">
                      <?php //echo $cut_pro_details['po_number']; ?>

                      <select style="width:150px;" name="po_select" id="po_select">
                      <option>Select PO </option>
                      <?php
                        while ($row = mysqli_fetch_assoc($po_list))
                            {
                              if($cut_pro_details['po'] == $row['id'])
                              {
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>


                    </td>
                    <td class="text-center">
                      <?php //echo $cut_pro_details['cut_number']; ?>

                      <select style="width:150px;" name="cut_num_select" id="cut_num_select">
                      <option>Select Cut Number </option>
                      <?php
                        while ($row = mysqli_fetch_assoc($cut_number_list))
                            {
                              if($cut_pro_details['cut_num'] == $row['id'])
                              {
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['cut_num']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['cut_num']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>


                    </td>
                    <td class="text-center">
                      <?php //echo $cut_pro_details['color_name']; ?>

                      <select style="width:150px;" name="color_select" id="color_select">
                      <option>Select Color Name </option>
                      <?php
                        while ($row = mysqli_fetch_assoc($color_list))
                            {
                              if($cut_pro_details['color'] == $row['id'])
                              {
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>


                    </td>
                    <td class="text-center">

                      <select style="width:150px;" name="style_select" id="style_select">
                      <option>Select Name </option>
                      <?php
                        while ($row = mysqli_fetch_assoc($style_list))
                          {
                            if($cut_pro_details['style'] == $row['id'])
                            {
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>




                    </td>
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
                    <td class="text-center">
                       <?php //echo $cut_pro_details['shade_name']; ?>

                       <select style="width:160px;" name="shade_select" id="shade_select">
                       <option>Select Shade Group </option>
                       <?php
                         while ($row = mysqli_fetch_assoc($shade_list))
                             {
                               if($cut_pro_details['shade'] == $row['id'])
                               {
                       ?>
                       <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                       <?php
                              } else{
                        ?>
                               <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                           <?php
                         }
                       }
                       ?>
                       </select>


                     </td>
                    <td class="text-center">
                       <?php //echo $cut_pro_details['lay']; ?>
                       <input style="width:160px;" type="number" name="lay_number" id="lay_number" value="<?php echo $cut_pro_details['lay']; ?>" required="required">

                     </td>
                    <td class="text-center">
                       <?php //echo $cut_pro_details['section_name']; ?>

                       <select style="width:160px;" name="section_select" id="section_select">
                       <option>Select Section </option>
                       <?php
                         while ($row = mysqli_fetch_assoc($section_list))
                             {
                               if($cut_pro_details['section'] == $row['id'])
                               {
                       ?>
                       <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                       <?php
                              } else{
                        ?>
                               <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                           <?php
                         }
                       }
                       ?>
                       </select>


                     </td>
                    <td class="text-center">
                       <?php //echo $cut_pro_details['total_pcs']; ?>
                       <input style="width:160px;" type="number" name="pcs" id="pcs" value="<?php echo $cut_pro_details['total_pcs']; ?>" required="required">
                      </td>
                  </tr>

                </table>

              </div>

       </div>


      <div id="form_2" class="box-body  w3-animate-right" style="padding:10px;">


         <div class="row">

         <?php
              $totalPcsNumber = $cut_pro_details['total_pcs'] * $cut_pro_details['bundle_no'];
              $bundleNoPerT = $cut_pro_details['bundle_no'];?>
              <input name="total_pcs" type="hidden" value="<?php echo $totalPcsNumber; ?>"></input>
              <input name="bundleNoPerTicket" type="hidden" value="<?php echo $bundleNoPerT; ?>"></input>
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
                      <select style="width:80px;" name="label_<?php echo $i ?>" id="label_<?php echo $i ?>" >
                      <option value="0">Select Group </option>
                      <?php

                      $all_group = array("A", "B", "C","D", "E", "F","G", "H", "I","J", "K", "L","M", "N", "O","P", "Q", "R","S", "T", "U","V", "W", "X","Y", "Z",);
                      foreach ($all_group as $group)
                      {
                              if($rows[$bundleNo][20] == $group){
                      ?>
                      <option selected value="<?php echo $group; ?>"><?php echo $group; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $group; ?>"><?php echo $group; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>
                    </th>
                    <th class="text-center">Size</th>
                    <th class="text-center">
                      <select style="width:80px;" name="size_<?php echo $i ?>" id="size_<?php echo $i ?>" onchange="updateSize(this.value,<?php echo $i ?>)">
                      <option>Select Size </option>
                      <?php
                      foreach ($all_size as $row)
                          {
                              if($rows[$bundleNo][19] == $row['id']){
                                if($row['inseam']){
                                  ?>
                                  <option selected value="<?php echo $row['id']; ?>"><?php echo $row['size_num']."/".$row['inseam']; ?></option>
                                  <?php
                                }else {
                                  ?>
                                  <option selected value="<?php echo $row['id']; ?>"><?php echo $row['size_num'] ?></option>
                                  <?php
                                }

                             } else{
                               if($row['inseam']){
                                 ?>
                                     <option value="<?php echo $row['id']; ?>"><?php echo $row['size_num']."/".$row['inseam']; ?></option>
                                 <?php
                               }else {
                                 ?>
                                     <option value="<?php echo $row['id']; ?>"><?php echo $row['size_num']?></option>
                                 <?php
                               }

                             }
                          }
                      ?>
                      </select>
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
                         for($k=0; $k<$cut_pro_details['bundle_no']; $k++){
                    ?>

                    <tr style="color:black;">
                    <td class="text-center"><?php echo ($bundleNo+$k); ?></td>
                    <td class="text-center">
                    <input readonly id="serial_from_<?php echo ($bundleNo+$k); ?>" name="serial_from_<?php echo ($bundleNo+$k); ?>" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][4]; ?>"></input>
                    </td>
                    <td class="text-center"><input readonly id="serial_to_<?php echo ($bundleNo+$k); ?>" name="serial_to_<?php echo ($bundleNo+$k); ?>" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][5]; ?>"></input></td>
                    <td class="text-center"><input name="quantity_<?php echo ($bundleNo+$k); ?>" id="quantity_<?php echo ($bundleNo+$k); ?>" onkeyup="serialSum(this.value,<?php echo ($bundleNo+$k); ?>),updateQuantity(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus1(<?php echo ($bundleNo+$k); ?>)" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][6]; ?>"></input></td>
                    <td class="text-center">
                      <input name="pattern_<?php echo ($bundleNo+$k); ?>"  onkeyup="changeFocus2(<?php echo ($bundleNo+$k); ?>)" id="pattern_<?php echo ($bundleNo+$k); ?>" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][7]; ?>"></input>
                      <input type="hidden" name="id_<?php echo ($bundleNo+$k); ?>" value="<?php echo $rows[$bundleNo+$k][0]; ?>"></input>
                    </td>
                    <td class="text-center">
                      <select style="width:80px;" name="shade_<?php echo ($bundleNo+$k); ?>" id="shade_<?php echo ($bundleNo+$k); ?>" onchange="updateShade(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus3(<?php echo ($bundleNo+$k); ?>)">
                      <option>Select Shade </option>
                      <?php
                        $shade_list =  $selectShade->select_all();
                        while ($row = mysqli_fetch_assoc($shade_list))
                            {
                              if($rows[$bundleNo+$k][8] == $row['id']){
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>
                    </td>
                    <td class="text-center">

                      <select style="width:80px;" name="country_<?php echo ($bundleNo+$k ); ?>" id="country_<?php echo ($bundleNo+$k ); ?>" onchange="updateCountry(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus4(<?php echo ($bundleNo+$k); ?>)">
                      <option>Select Country </option>
                      <?php
                        $country_list =  $selectCountry->select_all();
                        while ($row = mysqli_fetch_assoc($country_list))
                            {
                              if($rows[$bundleNo+$k][9] == $row['id']){
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                          <?php
                        }
                          }
                      ?>
                      </select>
                    </td>
                    </tr>

                   <?php } ?>


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
                    <select style="width:80px;" name="label_<?php echo $i ?>" id="label_<?php echo $i ?>" >
                    <option value="0">Select Group </option>
                    <?php

                    $all_group = array("A", "B", "C","D", "E", "F","G", "H", "I","J", "K", "L","M", "N", "O","P", "Q", "R","S", "T", "U","V", "W", "X","Y", "Z",);
                    foreach ($all_group as $group)
                    {
                            if($rows[$bundleNo][20] == $group){
                    ?>
                    <option selected value="<?php echo $group; ?>"><?php echo $group; ?></option>
                    <?php
                           } else{
                     ?>
                            <option value="<?php echo $group; ?>"><?php echo $group; ?></option>
                        <?php
                      }
                    }
                    ?>
                    </select>
                  </th>
                  <th class="text-center">Size</th>
                  <th class="text-center">
                    <?php //echo $rows[$bundleNo][19]; ?>
                    <select style="width:80px;" name="size_<?php echo $i ?>" id="size_<?php echo $i ?>" onchange="updateSize(this.value,<?php echo $i ?>)">
                    <option>Select Size </option>
                    <?php
                      //$size_list =  $selectSize->select_all();
                      foreach ($all_size as $row)
                          {
                              if($rows[$bundleNo][19] == $row['id']){
                                if($row['inseam']){
                                  ?>
                                  <option selected value="<?php echo $row['id']; ?>"><?php echo $row['size_num']."/".$row['inseam']; ?></option>
                                  <?php
                                }else {
                                  ?>
                                  <option selected value="<?php echo $row['id']; ?>"><?php echo $row['size_num'] ?></option>
                                  <?php
                                }

                             } else{
                               if($row['inseam']){
                                 ?>
                                     <option value="<?php echo $row['id']; ?>"><?php echo $row['size_num']."/".$row['inseam']; ?></option>
                                 <?php
                               }else {
                                 ?>
                                     <option value="<?php echo $row['id']; ?>"><?php echo $row['size_num']?></option>
                                 <?php
                               }

                             }
                          }
                    ?>
                    </select>
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
                         for($k=0; $k<$cut_pro_details['bundle_no']; $k++){
                    ?>

                    <tr style="color:black;">
                    <td class="text-center"><?php echo ($bundleNo+$k); ?></td>
                    <td class="text-center">
                    <input readonly id="serial_from_<?php echo ($bundleNo+$k); ?>" name="serial_from_<?php echo ($bundleNo+$k); ?>" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][4]; ?>"></input>
                    </td>
                    <td class="text-center"><input readonly id="serial_to_<?php echo ($bundleNo+$k); ?>" name="serial_to_<?php echo ($bundleNo+$k); ?>" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][5]; ?>"></input></td>
                    <td class="text-center"><input name="quantity_<?php echo ($bundleNo+$k); ?>" id="quantity_<?php echo ($bundleNo+$k); ?>" onkeyup="serialSum(this.value,<?php echo ($bundleNo+$k); ?>),updateQuantity(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus1(<?php echo ($bundleNo+$k); ?>)" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][6]; ?>"></input></td>
                    <td class="text-center">
                      <input name="pattern_<?php echo ($bundleNo+$k); ?>"  id="pattern_<?php echo ($bundleNo+$k); ?>" onkeyup="updatePat(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus2(<?php echo ($bundleNo+$k); ?>)" style="width:60px;" type="text" value="<?php echo $rows[$bundleNo+$k][7]; ?>"></input>
                      <input type="hidden" name="id_<?php echo ($bundleNo+$k); ?>" value="<?php echo $rows[$bundleNo+$k][0]; ?>"></input>
                    </td>
                    <td class="text-center">
                      <select style="width:80px;" name="shade_<?php echo ($bundleNo+$k); ?>" id="shade_<?php echo ($bundleNo+$k); ?>" onchange="updateShade(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus3(<?php echo ($bundleNo+$k); ?>)">
                      <option>Select Shade </option>
                      <?php
                        $shade_list =  $selectShade->select_all();
                        while ($row = mysqli_fetch_assoc($shade_list))
                            {
                              if($rows[$bundleNo+$k][8] == $row['id']){
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>
                    </td>
                    <td class="text-center">

                      <select style="width:80px;" name="country_<?php echo ($bundleNo+$k ); ?>" id="country_<?php echo ($bundleNo+$k ); ?>" onchange="updateCountry(this.value,<?php echo ($bundleNo+$k); ?>),changeFocus4(<?php echo ($bundleNo+$k); ?>)">
                      <option>Select Country </option>
                      <?php
                        $country_list =  $selectCountry->select_all();
                        while ($row = mysqli_fetch_assoc($country_list))
                            {
                              if($rows[$bundleNo+$k][9] == $row['id']){
                      ?>
                      <option selected value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                      <?php
                             } else{
                       ?>
                              <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                          <?php
                        }
                          }
                      ?>
                      </select>
                    </td>
                    </tr>

                   <?php } ?>
                  </tbody>

              </table>

            </div>
          </div>


        <?php
               }
             }
             ?>


        </div>





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
                 $x=0;
                 foreach ($cut_process_result as $key => $cut_process_result_info) {
                   if($cut_process_result_info['pro_id'] == $row['id']){
                     $x=1;
                   }
                 }
                 if($x==1){
         ?>
         <div class="col-md-2">
         <input type="checkbox" checked class="checkItem" style="margin-left:10px;height:17px;width:17px;" name="cut_process[]" id="<?php echo "cproduction_id_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
         <text style="color:black;">  <?php echo $row['name']; ?><text>
         </div>
         <?php
            }else {?>
         <div class="col-md-2">
         <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;" name="cut_process[]" id="<?php echo "cproduction_id_".$row['id']; ?>" value="<?php echo $row['id']; ?>">
         <text style="color:black;">  <?php echo $row['name']; ?><text>
         </div>
       <?php
              }
            }
         ?>
        </div>
        </div>

          <br>
          <div id="selectedProcessList" style="display:none;">

          </div>


        <div class="text-center" style="padding-bottom: 10px;">
           <button name="btn" type="submit" class="btn btn-danger center-block">Update Tickets</button>
        </div>

      </div>

    </form>


</div>
</div>
</div>
</div>

<script>

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

  var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';

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




function updateShade(value,number){

   var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';
   var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';

   for(var i = 1; i<=totalPcsNumber; i++)
   {
       if(i%bundleNoPerTicket == number){
            document.getElementById('shade_'+i).value = value;
            var shadeSelect = document.getElementById("shade_"+i);
            document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       }else if(number == bundleNoPerTicket){
         if(i%bundleNoPerTicket == 0){
         document.getElementById('shade_'+i).value = value;
         var shadeSelect = document.getElementById("shade_"+i);
         document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
       }
     }
   }

}

// function updateShade(value,number){
//
//    var bundleNoPerTicket = parseInt(document.getElementById("bundle_no_ticket").value);
//    var totalPcsNumber = parseInt(document.getElementById("pcs").value)*bundleNoPerTicket;
//
//    for(var i = 1; i<=totalPcsNumber; i++)
//    {
//        if(i%bundleNoPerTicket == number){
//          document.getElementById('shade_'+i).value = value;
//          var shadeSelect = document.getElementById("shade_"+i);
//          document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
//        } else if(number == bundleNoPerTicket){
//          if(i%bundleNoPerTicket == 0){
//            document.getElementById('shade_'+i).value = value;
//            var shadeSelect = document.getElementById("shade_"+i);
//            document.getElementById("shade_"+i).value = shadeSelect.options[shadeSelect.selectedIndex].value;
//          }
//        }
//    }
// }


function updateCountry(value,number){

   var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';
   var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';

   for(var i = 1; i<=totalPcsNumber; i++)
   {
       if(i%bundleNoPerTicket == number){
            document.getElementById('country_'+i).value = value;
            var countrySelect = document.getElementById("country_"+i);
            document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
       }else if(number == bundleNoPerTicket){
         if(i%bundleNoPerTicket == 0){
           document.getElementById('country_'+i).value = value;
           var countrySelect = document.getElementById("country_"+i);
           document.getElementById("country_"+i).value = countrySelect.options[countrySelect.selectedIndex].value;
         }
       }
   }
}

function updateQuantity(value,number){
//alert(value);
  var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';
  var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';
//alert(totalPcsNumber);
  console.log("number : "+number);

  for(var i = 1; i<=totalPcsNumber; i++)
  {
      if(i%bundleNoPerTicket == number){
        //alert(i);
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

function updatePat(value,number){
  var bundleNoPerTicket = '<?php echo $bundleNoPerT; ?>';
  var totalPcsNumber = '<?php echo $totalPcsNumber; ?>';
  console.log("Total Pcs : "+totalPcsNumber);

  // for(var i = 1; i<=totalPcsNumber; i++)
  // {
  //     document.getElementById('pattern_'+i).value = value;
  // }
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

</script>
