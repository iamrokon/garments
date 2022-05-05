<?php
       require('../../fpdf17/fpdf.php');
       require('../../fpdf17/exfpdf.php');
       require('../../fpdf17/easyTable.php');
       require_once '../../DB/cproduction/select.php';
       require_once '../../DB/size/select.php';
       require_once '../../DB/line/select.php';



       $selectSize = new select_size();
       $size_list =  $selectSize->select_all();

       $selectLine = new select_line();
       while ($row = mysqli_fetch_assoc($size_list)){
         $all_size[] = $row;
       }

          $pdf = new FPDF('P','mm',array(69,36));

          $id = $_GET['id'];
          $x= 0;

          $total_c_p_val = 0;
          $linesName = "";

          $selectCProduction = new select_cproduction();
          //$cProductionValues = $selectCProduction->select_all_lower_id_values($id);

          $lineName = $selectCProduction->select_line_name_by_id($id);

          // while ($info = mysqli_fetch_assoc($cProductionValues)) {
          //           $total_c_p_val = $total_c_p_val + $info['cutting_production'];
          // }

          // print "<pre>";
          // print_r($total_c_p_val);
          // print "</pre>";

          while ($row = mysqli_fetch_assoc($lineName))
          {
            $lineNameInfo = $row['line_name'];
          }
          $cProductionResult = $selectCProduction->select_with_id($id);

          // if($total_c_p_val){
          //     $maxId = $total_c_p_val;
          // }
          // else {
          //   $maxId = 0;
          // }
          $j=0;
          $prefix = "";
          $next = 0;
          $page_number = 0;

          $linesSpace = 1.5;

          //set it to writable location, a place for temp generated PNG files
          $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

          //html PNG location prefix
          $PNG_WEB_DIR = 'temp/';

          include "qr/qrlib.php";

          //ofcourse we need rights to create temp dir
          if (!file_exists($PNG_TEMP_DIR))
          mkdir($PNG_TEMP_DIR);

          $filename = $PNG_TEMP_DIR.'test.png';
          while ($row = mysqli_fetch_assoc($cProductionResult))
          {
             $maxId = $row['qr_code'];
             $bundle = 0;
             $cProductionChild = $selectCProduction->select_child_with_id2($row['id'],$row['style']);
             $bundleTotalNumber = mysqli_num_rows($cProductionChild);




             while ($row_c = mysqli_fetch_assoc($cProductionChild)){

               // $todOfCuttingProduction = $selectCProduction->select_tod_complete_qr_code(
               //                                                                            $id,
               //                                                                            $row_c['id']
               //                                                                          );
              $todOfCuttingProduction = $selectCProduction->select_tod_complete_qr_code2(
                                                                                         $row['po'],
                                                                                         $row_c['country_id']
                                                                                       );
              $orderQtyByCountryPO = $selectCProduction->select_order_qty_by_po_country(
                                                                                         $row['po'],
                                                                                         $row_c['country_id']
                                                                                       );
              $getOrderQtyByPO = $selectCProduction->select_order_qty_by_po($row['po']);

               $getData = mysqli_fetch_assoc($todOfCuttingProduction);
               $getOrderQty = mysqli_fetch_assoc($orderQtyByCountryPO);
               $orderQtyByPO = mysqli_fetch_assoc($getOrderQtyByPO);
               $tod = $getData['tod'];
               // echo '<pre>';
               // print_r($tod);
               // echo '</pre>';
               $bundle++;

               for($i = 0; $i< $row_c['quantity']; $i++){

               $maxId++;
               $page_number++;
               $childLineNameInfo = "";
               $childLineName = $selectCProduction->select_line_name_by_child_id($row_c['id']);
               while ($row2 = mysqli_fetch_assoc($childLineName))
               {
                 $childLineNameInfo = $row2['line_name'];

               }
               foreach ($all_size as $row_size)
                {
                  if($row_c['ticket_size'] == $row_size['id']){
                    if($row_size['inseam']){
                      $ticket_size = $row_size['size_num']."/".$row_size['inseam'];
                    }else {
                      $ticket_size = $row_size['size_num'];
                    }
                  }
                }

               $lineId = $selectCProduction->select_line_name($row['po'],$row['cut_num']);
               $errorCorrectionLevel = 'M';
               $matrixPointSize = min(max((int)4, 1), 10);

               $filename = $PNG_TEMP_DIR.'test'.md5(strtoupper(base_convert($maxId,10,36)).'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
               QRcode::png(base_convert($maxId,10,36), $filename, $errorCorrectionLevel, $matrixPointSize, 2);


                          $pdf->AddPage();
                          $pdf->Rect(0,6,41,60+$linesSpace);
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Image($filename,1,43+$linesSpace,22,22);
                          $pdf->Text(17,4,$page_number);
                          $pdf->Text(22,56,strtoupper(base_convert($maxId,10,36)));

                          //$pdf->Text(1,13,'Line :');
                          $pdf->Text(1,11.5+$linesSpace,'Style:');
                          $pdf->Text(1,15+$linesSpace,'PO:');
                          $pdf->Text(1,18.5+$linesSpace,'Color:');
                          $pdf->Text(1,22+$linesSpace,'Cut:');
                          $pdf->Text(17,22+$linesSpace,'Size:');
                          $pdf->Text(1,25.5+$linesSpace,'Bun:');
                          $pdf->Text(17,25.5+$linesSpace,'SL:');
                          $pdf->Text(1,29+$linesSpace,'QTY:');
                          $pdf->Text(1,32.5+$linesSpace,'Sh:');
                          $pdf->Text(17,32.5+$linesSpace,'Ptn:');
                          $pdf->Text(1,36+$linesSpace,'Srin:');
                          $pdf->Text(1,39.5+$linesSpace,'Tod:');
                          $pdf->Text(1,43+$linesSpace,'Country:');

                          while ($row4 = mysqli_fetch_assoc($lineId))
                          {
                            $serial = explode("-",$row4['serial']);
                            $serial_from = $serial['0'];
                            $serial_to = $serial['1'];
                            if($page_number>=$serial_from && $page_number<=$serial_to){
                              $line = $row4['line'];

                              $lineNameInfo =  $selectLine->select_with_id($line);
                              $line_name = mysqli_fetch_assoc($lineNameInfo);
                              $linesName = $line_name['name'];

                              if(!$childLineNameInfo){
                                if($linesName){
                                  $pdf->Text(13,9,$linesName);
                                  //$linesSpace = 1;
                                }
                              }
                            }
                            else{
                              $linesName = "";
                            }
                          }
                          if($childLineNameInfo){
                            $pdf->Text(13,9,$childLineNameInfo);
                            //$linesSpace = 1;
                          }
                          //$pdf->Text(15,13,$linesName);
                          $pdf->SetFont('Arial','B',6);
                          $pdf->Text(9,11.5+$linesSpace,$row['style_name']);
                          $pdf->SetFont('Arial','B',7);
                          $pdf->Text(10,15+$linesSpace,$row['po_number']);
                          $pdf->SetFont('Arial','B',5);
                          $pdf->Text(10,18.5+$linesSpace,$row['color_name']);
                          $pdf->SetFont('Arial','B',7);
                          $pdf->Text(9,22+$linesSpace,$row['cut_number'].",");
                          $pdf->Text(24,22+$linesSpace,$ticket_size);
                          $pdf->Text(9,25.5+$linesSpace,$bundle.",");

                          $serial = $row_c['to_id']-$row_c['from_id'];


                          $pdf->Text(24,25.5+$linesSpace,$row_c['from_id']."-".$row_c['to_id']."(".$serial.")");
                          $pdf->Text(9,29+$linesSpace,$page_number."=".$row_c['total_quantity_bundle'].",");
                          $pdf->Text(9,32.5+$linesSpace,$row_c['shade_name'].",");
                          $pdf->Text(24,32.5+$linesSpace,$row_c['pattern']);





                          // $servername  = 'localhost';
                          // $username  = 'root';
                          // $password = '';
                          // $dbname = 'sdlsoftware_fabric';
                          // $conn = new mysqli($servername,$username,$password,$dbname);
                          // if ($conn->connect_error) {
                          //    die("Connection failed: " . $conn->connect_error);
                          // }
                          // $sql = "SELECT * FROM tbl_shrinkkage_pattern";
                          // $length_wrap = "";
                          // $width_weft = "";
                          // $results = $conn->query($sql);
                          //  foreach ($results as $rowss) {
                          //    $style_name = $rowss['style_name'];
                          //    $sql = "SELECT pro_group_name FROM tbl_product_group WHERE id='$style_name'";
                          //    $result2 = $conn->query($sql);
                          //    $style_names = mysqli_fetch_assoc($result2);
                          //
                          //    if($row['style_name'] == $style_names['pro_group_name']){
                          //      $length_wrap = $rowss['length_wrap'];
                          //      $width_weft = $rowss['width_weft'];
                          //      break;
                          //    }
                          //  }





                          $pdf->Text(9,36+$linesSpace,"L=".$row_c['length_wrap'].","."W=".$row_c['width_weft']);
                          if($tod){
                            $pdf->Text(9,39.5+$linesSpace,date("d-M-y", strtotime($tod)));
                          }
                          else {
                            $pdf->Text(9,39.5+$linesSpace,"");
                          }
                          if($getOrderQty['total_quantity']){
                            $pdf->Text(13,43+$linesSpace,$row_c['country_name']."=".$getOrderQty['total_quantity']."(".$orderQtyByPO['total_quantity'].")");
                          }
                          else {
                            $pdf->Text(13,43+$linesSpace,$row_c['country_name']);
                          }
                     }

                 }
             }

                   $pdf->Output();
            ?>
