<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/swoutput/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>



<?php

      $selectLine = new select_line();

      $ob = new select_swoutput();
      $date = date("d-m-Y");
      $result = $ob->select_scan_swoutput_today($date);

      $selectLine = new select_line();
      $line_list =  $selectLine->select_all();

      // echo '<pre>';
      // print_r($date);
      // echo '</pre>';
      // $count = 0;
      // foreach ($result as $key => $value) {
      //   $time = explode(':', $value['time']);
      //   $format = explode(' ', $time['2']);
      //   if($time['0']=='11' && $format['1'=='AM']){
      //     $count++;
      //   }
      // }

      // echo '<pre>';
      // print_r($count);
      // echo '</pre>';
      // exit();


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
                         <label class="btn btn-info">Line</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="line_select" id="line_select">
                                           <option value="">Select Line</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($line_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
                          
                            <th style="color:white;">Line No</th>
                            
                            <th style="color:white;">Style</th>
                            
                            <th style="color:white;">1st HR(7-8)AM</th>
                            <th style="color:white;">2nd HR(8-9)AM</th>
                            <th style="color:white;">3rd HR(9-10)AM</th>
                            <th style="color:white;">4th HR(10-11)AM</th>
                            <th style="color:white;">5th HR(11-12)AM</th>
                            <th style="color:white;">6th HR(12-1)PM</th>
                            <th style="color:white;">7th HR(1-2)PM</th>
                            <th style="color:white;">8th HR(2-3)PM</th>
                            <th style="color:white;">9th HR(3-4)PM</th>
                            <th style="color:white;">10th HR(4-5)PM</th>
                            <th style="color:white;">11th HR(5-6)PM</th>
                            <th style="color:white;">12th HR(6-7)PM</th>
                            <th style="color:white;">13th HR(7-8)PM</th>
                            <th style="color:white;">14th HR(8-9)PM</th>
                            <th style="color:white;">15th HR(9-10)PM</th>
                            <th>Total Output Qty</th>
                            <th>Output Date</th>
                            <th>Create by</th>
                            
                            <!-- <th>Tod</th>
                            <th>Shipment</th>
                            <th>Shade/Pattern</th>
                            <th>Strinkage</th>
                            <th>Creation Date</th>
                            <th>Creation Time</th> -->

                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        // foreach ($result as $key => $value) {
                        //   echo '<pre>';
                        //   print_r($value['id']);
                        //   echo '</pre>';
                        // }

                        foreach ($line_list as $key => $value) {
                          // echo '<pre>';
                          // print_r($value['name']);
                          // echo '</pre>';


                        ?>

                        <tr>
                          <td style="color:black;" class="text-center"><?php echo $value['name'];?></td>
                          <td style="color:black;" class="text-center"></td>
                          <td style="color:black;" class="text-center">
                            <?php
                            $count7 = 0;
                            $count8 = 0;
                            $count9 = 0;
                            $count10 = 0;
                            $count11 = 0;
                            $count12 = 0;
                            $count13 = 0;
                            $count14 = 0;
                            $count15 = 0;
                            $count16 = 0;
                            $count17 = 0;
                            $count18 = 0;
                            $count19 = 0;
                            $count20 = 0;
                            $count21 = 0;
                            $exactLine = "";
                            $totOutputQty = 0;
                            foreach ($result as $key => $info) {





                              $qrCode = base_convert($info['complete_qr_code'],36,10);

                              $row_c_info = $ob_c->select_cut_pro_by_qrcode($qrCode);
                              $row_c = mysqli_fetch_assoc($row_c_info);
                              $linesName = "";
                              $cut_pro_quantity = $qrCode - $row_c['qr_code'];
                              $production_id = $row_c['id'];

                              $row_c_c_info = $ob_c->select_cut_pro_child_by_qrcode($cut_pro_quantity,$production_id);
                              // if(!empty($request['search']['value'])){
                              //     $row_c_c_info2 = $ob_c->select_cut_pro_child_by_qrcode2($cut_pro_quantity,$production_id,$request['search']['value']);
                              //     $row_c_c = mysqli_fetch_assoc($row_c_c_info2);
                              //
                              //     if(!$row_c_c['country_name']){
                              //       continue;
                              //     }
                              // }else{
                                  $row_c_c = mysqli_fetch_assoc($row_c_c_info);
                              //}


                              $row_c_c_info2 = $ob_c->select_cut_pro_child2_by_qrcode($production_id);
                              $row_c_c2 = mysqli_fetch_assoc($row_c_c_info2);

                              $cut_pro_bundle_id =$row_c_c['id'];
                              // $getTodInfo = $ob_c->select_tod_complete_qr_code($production_id,$cut_pro_bundle_id);
                              // $getTod = mysqli_fetch_assoc($getTodInfo);

                              $lineNameInfo = $ob_c->select_line_name_by_child_id($cut_pro_bundle_id);
                              $lineName = mysqli_fetch_assoc($lineNameInfo);

                              $lineId = $ob_c->select_line_name($row_c['po'],$row_c['cut_num']);
                              foreach ($lineId as $key => $row4) {

                              $serial = explode("-",$row4['serial']);
                              $serial_from = $serial['0'];
                              $serial_to = $serial['1'];

                              if($cut_pro_quantity>=$serial_from && $cut_pro_quantity<=$serial_to){
                                $line = $row4['line'];


                                $lineNameInfo =  $selectLine->select_with_id($line);
                                $line_name = mysqli_fetch_assoc($lineNameInfo);
                                $linesName = $line_name['name'];

                              }

                              }

                              $shipmentInfo = $ob_c->select_shipment_info_by_order($production_id,$row_c_c['country_id']);
                              $shipment = mysqli_fetch_assoc($shipmentInfo);

                              if($lineName['line_name'])
                              {
                                $exactLine = $lineName['line'];
                              }
                              else {
                                if($linesName){
                                  $exactLine = $line;
                                }
                              }






                              $time = explode(':', $info['time']);
                              $format = explode(' ', $time['2']);
                              if($time['0']=='7' && $format['1']=='AM' && $value['id']==$exactLine){
                                $count7++;
                              } elseif ($time['0']=='8' && $format['1']=='AM' && $value['id']==$exactLine){
                                $count8++;
                              } elseif ($time['0']=='9' && $format['1']=='AM' && $value['id']==$exactLine){
                                $count9++;
                              } elseif ($time['0']=='10' && $format['1']=='AM' && $value['id']==$exactLine){
                                $count10++;
                              } elseif ($time['0']=='11' && $format['1']=='AM' && $value['id']==$exactLine) {
                                $count11++;
                              } elseif ($time['0']=='12' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count12++;
                              } elseif ($time['0']=='1' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count13++;
                              } elseif ($time['0']=='2' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count14++;
                              } elseif ($time['0']=='3' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count15++;
                              } elseif ($time['0']=='4' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count16++;
                              } elseif ($time['0']=='5' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count17++;
                              } elseif ($time['0']=='6' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count18++;
                              } elseif ($time['0']=='7' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count19++;
                              } elseif ($time['0']=='8' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count20++;
                              } elseif ($time['0']=='9' && $format['1']=='PM' && $value['id']==$exactLine) {
                                $count21++;
                              }
                            }
                            $totOutputQty = $count7 + $count8 + $count9 + $count10 + $count11 + $count12 + $count13 + $count14 + $count15 + $count16 + $count17 + $count18 + $count19 + $count20 + $count21;
                            echo $count7;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count8;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count9;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count10;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count11;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count12;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count13;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count14;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count15;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count16;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count17;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count18;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count19;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count20;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $count21;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo $totOutputQty;
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            echo date('d-m-Y');
                            ?>
                          </td>
                          <td style="color:black;" class="text-center">
                            <?php
                            // echo date('d-m-Y');
                            ?>
                          </td>

                        </tr>
                      <?php } ?>
                      </tbody>
                  <!-- <tfoot>
                      <tr  class="btn-gradient-02">
                        <th>ID</th>
                        <th>QR Code</th>
                        <th>Line No</th>
                        <th>Style</th>
                        <th>P.O.</th>
                        <th>Color</th>
                        <th>Serial</th>
                        <th>Country</th>
                        <th>Size</th>
                        <th>Cut No.</th>
                        <th>Bundle</th>
                        <th>Tod</th>
                        <th>Shipment</th>
                        <th>Shade/Pattern</th>
                        <th>Strinkage</th>
                        <th>Creation Date</th>
                        <th>Creation Time</th>

                      </tr>
                  </tfoot> -->

                  </table>
               </div>
            </div>
          </div>
      </div>

              <script>
                // $(document).ready(function(){
                //      var dataTable=$('#example').DataTable({
                //          "processing": true,
                //          "serverSide":true,
                //          "ajax":{
                //              url:"pages/swoutput/fetch_hourly_report.php",
                //              type:"post"
                //          },
                //           dom: 'lBfrtip',
                //           "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                //           buttons: [
                //               'copy', 'csv', 'excel', 'pdf', 'print'
                //           ]
                //      });
                //  });
              </script>
