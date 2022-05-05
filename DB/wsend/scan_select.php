<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/wsend/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>



<?php
      $ob = new select_washsend();
      $result = $ob->select_scan_wsend_history();


      $ob_c = new select_cproduction();

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
              <table id="export-table" class="table table-soutput table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th>ID</th>
                                    <th>QR Code</th>
                                    <th>Line No</th>
                                    <th>Style</th>
                                    <th>P.O.</th>
                                    <th>Color</th>
                                    <th>Total QTY</th>
                                    <th>Country</th>
                                    <th>Size</th>
                                    <th>Cut No.</th>
                                    <th>Bundle</th>
                                    <th>Tod</th>
                                    <th>Shipment</th>
                                    <!-- <th>SL No</th> -->
                                    <th>Shade/Pattern</th>
                                    <th>Strinkage</th>
                                    <th>Creation Date</th>
                                    <th>Creation Time</th>

                                    <!-- <th style="color:white;">Line</th>
                                    <th style="color:white;">Size</th>
                                    <th style="color:white;">Quantity</th>
                                    <th style="color:white;">Buyer</th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Cut Number</th>
                                    <th style="color:white;">Color</th>
                                    <th style="color:white;">Style</th>
                                    <th style="color:white;">Shade</th>
                                    <th style="color:white;">Lay</th>
                                    <th style="color:white;">Scan Date</th>
                                    <th style="color:white;">Scan Time</th>
                                    <th style="color:white;">Scan User</th> -->
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:black;" class="text-center"><?php echo $info['id']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['complete_qr_code']; ?> </td>
                                      <?php
                                        $qrCode = base_convert($info['complete_qr_code'],36,10);

                                        $row_c_info = $ob_c->select_cut_pro_by_qrcode($qrCode);
                                        $row_c = mysqli_fetch_assoc($row_c_info);

                                        $cut_pro_quantity = $qrCode - $row_c['qr_code'];
                                        $production_id = $row_c['id'];

                                        $row_c_c_info = $ob_c->select_cut_pro_child_by_qrcode($cut_pro_quantity,$production_id);
                                        $row_c_c = mysqli_fetch_assoc($row_c_c_info);

                                        $row_c_c_info2 = $ob_c->select_cut_pro_child2_by_qrcode($production_id);
                                        $row_c_c2 = mysqli_fetch_assoc($row_c_c_info2);

                                        $cut_pro_bundle_id =$row_c_c['id'];
                                        $getTodInfo = $ob_c->select_tod_complete_qr_code($production_id,$cut_pro_bundle_id);
                                        $getTod = mysqli_fetch_assoc($getTodInfo);

                                        $lineNameInfo = $ob_c->select_line_name_by_child_id($cut_pro_bundle_id);
                                        $lineName = mysqli_fetch_assoc($lineNameInfo);

                                        $shipmentInfo = $ob_c->select_shipment_info_by_order($production_id);
                                        $shipment = mysqli_fetch_assoc($shipmentInfo);
                                        // echo '<pre>';
                                        // print_r($row_c);line_name
                                        // echo  '</pre>';
                                      ?>


                                      <td style="color:black;" class="text-center"><?php echo $lineName['line_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c['style_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c['po_number']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c['color_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $cut_pro_quantity; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c_c['country_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c_c['ticket_size']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c['cut_number']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $row_c_c['bundle_no']."/".$row_c_c2['bundle_no']; ?> </td>
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $getTod['tod']; ?> </td>
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $shipment['shipment']; ?> </td>
                                      <!-- <td style="color:black;width:100px;" class="text-center"><?php //echo $row_c_c['from_id']."-".$row_c_c['to_id']; ?> </td> -->
                                      <td style="color:black;" class="text-center"><?php echo $row_c_c['shade_name']."/".$row_c_c['pattern']; ?> </td>
                                      <td style="color:black;" class="text-center"> </td>
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $info['date']; ?> </td>
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $info['time']; ?> </td>
                                      <!-- <td style="color:black;" class="text-center"><?php echo $info['time']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['user_name']; ?> </td> -->
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                       </div>
                    </div>
                  </div>
              </div>
