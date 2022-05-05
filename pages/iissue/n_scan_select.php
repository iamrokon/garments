<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/iissue/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>

<?php
      $ob = new select_iissue();
      $result = $ob->select_all();

      $obSelect = new select_cproduction();
      //$result = $ob->select_scan_iissue_history();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectCountry = new select_country();
      $country_list =  $selectCountry->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();


      if (isset($_POST['search'])) {
          $search= new search_c_plan();
          $result = $search->search($_POST);
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-right:10px;margin-left:10px;">

            <div class="w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


              <div style="margin-right: 10px;margin-top: 10px;" id ="search">

                <form method="POST" action="">

                          <div class="row">

                            <div class="form-group col-md-4">
                                <label class="btn btn-info">Style Name</label>
                                <div class="input-group margin" style="margin-top: 0px">
                                               <select class="form-control col-md-12" name="style_select" id="style_select">
                                                  <option value="">Select Name</option>

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
                          </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">PO Number</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                          <select class="form-control col-md-12" name="po_select" id="po_select">
                                           <option value="">Select PO</option>

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
                        </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">Country</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="country_select" id="country_select">
                                           <option value="">Select Country</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($country_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                                      </div>
                                     </div>

                   </div>

                   <div class="row">

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">From Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="from_date" name="from_date" autocomplete="off">
                     </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">To Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="to_date" name="to_date" autocomplete="off">
                     </div>

                 </div>

                 <div class="text-center" style="padding-top: 10px;">
                 <button id="search" name="search" type="submit" class="btn btn-danger center-block">SEARCH</button>
                 </div>

                </form>
              </div>



          <div class="table-responsive table-striped w3-hoverable w3-small" style="padding:25px;">
              <table id="export-table" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Cut Number</th>
                                    <!-- <th style="color:white;"><span style="width:100px;">Bundle Code</span></th> -->
                                    <th style="color:white;">Line</th>
                                    <!-- <th style="color:white;">Size</th> -->
                                    <th style="color:white;">Serial</th>
                                    <th style="color:white;">Quantity</th>
                                    <th style="color:white;">Buyer</th>
                                    <th style="color:white;">Color</th>
                                    <th style="color:white;">Style</th>
                                    <!-- <th style="color:white;">Shade</th>
                                    <th style="color:white;">Lay</th> -->
                                    <th style="color:white;">Scan Date</th>
                                    <th style="color:white;">Scan Time</th>
                                    <!-- <th style="color:white;">Scan User</th> -->
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                     $c_pro_result = $obSelect->select_with_po_cut_no($info['cut_num'],$info['po']);
                                     while ($row2 = mysqli_fetch_assoc($c_pro_result))
                                     {
                                       $buyer_name = $row2['buyer_name'];
                                       $style_name = $row2['style_name'];
                                       $color_name = $row2['color_name'];
                                       $quantity = $row2['total_quantity_bundle'];
                                     }
                                   ?>
                                  <tr>
                                      <td style="color:black;" class="text-center"><?php echo $info['id']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['po_number']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['cut_number']; ?> </td>
                                      <!-- <td style="color:black;" class="text-center"><?php //echo dechex($info['t_code']); ?> </td> -->
                                      <td style="color:black;" class="text-center"><?php echo $info['line_name']; ?> </td>
                                      <!-- <td style="color:black;" class="text-center"><?php //echo $info['size_number']; ?> </td> -->
                                      <td style="color:black;" class="text-center"><?php echo $info['serial']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $quantity; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $buyer_name; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $color_name; ?> </td>
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $style_name; ?> </td>
                                      <!-- <td style="color:black;" class="text-center"><?php //echo $info['shade']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php //echo $info['lay']; ?> </td> -->
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $info['date']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['time']; ?> </td>
                                      <!-- <td style="color:black;" class="text-center"><?php echo $info['user_name']; ?> </td> -->
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                       </div>
                    </div>
                  </div>
              </div>
