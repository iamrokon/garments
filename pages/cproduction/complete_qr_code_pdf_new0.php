<?php
       require('../../fpdf17/fpdf.php');
       require('../../fpdf17/exfpdf.php');
       require('../../fpdf17/easyTable.php');
       require_once '../../DB/cproduction/select.php';
       require_once '../../DB/size/select.php';
       require_once '../../DB/line/select.php';

       $selectSize = new select_size();
       $size_list =  $selectSize->select_all_qr();

       $selectLine = new select_line();
       while ($row = mysqli_fetch_assoc($size_list)){
         $all_size[] = $row;
       }

          $pdf = new FPDF('P','mm',array(72,36));

          $id = $_GET['id'];
          $x= 0;

          $total_c_p_val = 0;

          $selectCProduction = new select_cproduction();
          $cProductionResult = $selectCProduction->select_with_id_qr_again($id);
          // foreach ($cProductionResult as $cProductionResultInfo) {
          //   echo '<pre/>';
          //   print_r($cProductionResultInfo);
          // }
          // exit();

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
            // echo '<pre/>';
            // print_r($row);
             $maxId = $row['qr_code'];
             $bundle = 0;
             //$cProductionChild = $selectCProduction->select_child_with_id2_qr($row['id'],$row['style']);
             //$bundleTotalNumber = mysqli_num_rows($cProductionChild);



             //while ($row_c = mysqli_fetch_assoc($cProductionChild)){

              // $todOfCuttingProduction = $selectCProduction->select_tod_complete_qr_code2_qr(
              //                           $row['po'],
              //                           $row['country_id']
              //                           );
              // $orderQtyByCountryPO = $selectCProduction->select_order_qty_by_po_country_new(
              //                        $row['po'],
              //                        $row['country_id']
              //                        );
              //$getOrderQtyByPO = $selectCProduction->select_order_qty_by_po($row['po']);

               //$getData = mysqli_fetch_assoc($todOfCuttingProduction);
               //$getOrderQty = mysqli_fetch_assoc($orderQtyByCountryPO);
               //$orderQtyByPO = mysqli_fetch_assoc($getOrderQtyByPO);
               //$tod = $getData['tod'];
               // echo '<pre>';
               // print_r($tod);
               // echo '</pre>';
               $bundle++;

               for($i = 0; $i< $row['quantity']; $i++){
                $linesName = "";

               $maxId++;
               $page_number++;
               $childLineNameInfo = "";
               // $childLineName = $selectCProduction->select_line_name_by_child_id_qr($row['b_id']);
               //
               // while ($row2 = mysqli_fetch_assoc($childLineName))
               // {
                 $childLineNameInfo = $row['line_name'];

               //}
               $country_codes = explode(",",$row['country_code']);


               $ticket_size = "";
               foreach ($all_size as $row_size)
               {
                  if($row['ticket_size'] == $row_size['id']){
                    $final_size = $row_size['size_num'];
                    foreach ($country_codes as $country_code) {
                      $code_no = explode("-",$country_code);
                      if($code_no[0] == $row_size['size_num']){
                        $final_size = $country_code;
                      }
                    }
                    if($row_size['inseam']){
                      $ticket_size = $final_size."/".$row_size['inseam'];
                    }else {
                      $ticket_size = $final_size;
                    }
                  }
               }

               $lineId = $selectCProduction->select_line_name_qr($row['po'],$row['cut_num']);
               $errorCorrectionLevel = 'M';
               $matrixPointSize = min(max((int)4, 1), 10);

               $filename = $PNG_TEMP_DIR.'test'.md5(strtoupper(base_convert($maxId,10,36)).'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

                while ($row4 = mysqli_fetch_assoc($lineId))
                          {
                            $serial = explode("-",$row4['serial']);
                            $serial_from = $serial['0'];
                            $serial_to = $serial['1'];
                            if($page_number>=$serial_from && $page_number<=$serial_to){
                              $line = $row4['line'];

                              $lineNameInfo =  $selectLine->select_with_id_qr($line);
                              $line_name = mysqli_fetch_assoc($lineNameInfo);
                              $linesName = $line_name['name'];
                              // echo '<pre/>';
                              // print_r($linesName);

                              if(!$childLineNameInfo){
                                if($linesName){
                                  $linesName;
                                  //$linesSpace = 1;
                                }
                              }
                            }
                            // else{
                            //   $linesName = "";
                            // }
                          }
                          if($childLineNameInfo){
                           $linesName = $childLineNameInfo;
                            //$linesSpace = 1;
                          }
              if($linesName==""){
                $linesName=".";
              }

              // echo '<pre/>';
              // print_r($linesName);
              //
              // $qrdata= 'ID:'.base_convert($maxId,10,36).', Line:'.$linesName.', Style:' .$row['style_name'].
              // ', PO:'.$row['po_number'].', Color:'.$row['color_name'].', Cut_Num:' .$row['cut_number'].', Size:'.$ticket_size.', Country:' .$row['country_name'].'!';
              //
              //  QRcode::png($qrdata, $filename, $errorCorrectionLevel,
              //   $matrixPointSize,2);

              $qrdata= 'ID:'.base_convert($maxId,10,36).', Line:'.$linesName.', Style:' .$row['style_name'].
              ', PO:'.$row['po_number'].', Color:'.$row['color_name'].', Cut_Num:' .$row['cut_number'].', Size:'.$ticket_size.', Country:' .$row['country_name'].'!';

                 QRcode::png($qrdata, $filename, $errorCorrectionLevel,
                  $matrixPointSize,2);

                          $pdf->AddPage();
                          $pdf->Rect(0,6,41,63+$linesSpace);
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Image($filename,6,45.6+$linesSpace,23,23);
                          $pdf->Text(17,4,$page_number);
                          // $pdf->Text(13,9,$linesName);
                          $pdf->Text(1,11.5+$linesSpace,'Style:');
                          if($row['country_name'] == "CN"){
                          $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(1,15+$linesSpace,'PO:');
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Text(1,18.5+$linesSpace,'Color:');
                          $pdf->Text(17,22+$linesSpace,'Cut:');
                          $pdf->Text(1,22+$linesSpace,'Size:');
                          $pdf->Text(1,25.5+$linesSpace,'Bun:');
                          $pdf->Text(17,25.5+$linesSpace,'SL:');
                          $pdf->Text(1,29+$linesSpace,'QTY:');
                          $pdf->Text(1,32.5+$linesSpace,'Sh:');
                          $pdf->Text(17,32.5+$linesSpace,'Ptn:');
                          $pdf->Text(1,36+$linesSpace,'Srin:');
                          $pdf->Text(1,39.5+$linesSpace,'Tod:');
                          if($row['country_name'] == "CN"){
                          $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(1,43+$linesSpace,'Country:');
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Text(12,47.5,strtoupper(base_convert($maxId,10,36)));

                          $pdf->Text(13,9,$linesName);
                          $pdf->SetFont('Arial','B',6);
                          $pdf->Text(9,11.5+$linesSpace,$row['style_name']);
                          $pdf->SetFont('Arial','B',7);
                          if($row['country_name'] == "CN"){
                            $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(10,15+$linesSpace,$row['po_number']);
                          $pdf->SetFont('Arial','B',5);
                          $pdf->Text(10,18.5+$linesSpace,$row['color_name']);
                          $pdf->SetFont('Arial','B',7);

                          $pdf->Text(24,22+$linesSpace,$row['cut_number'].",");
                          if((substr($ticket_size,-1) == "p") || (substr($ticket_size,-1) == "P")){
                            $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(9,22+$linesSpace,$ticket_size);
                          $pdf->SetFont('Arial','B',7);
                          $pdf->Text(9,25.5+$linesSpace,$bundle.",");

                          $serial = $row['to_id']-$row['from_id'];

                          $pdf->Text(24,25.5+$linesSpace,$row['from_id']."-".$row['to_id']."(".$serial.")");
                          $pdf->Text(9,29+$linesSpace,$page_number."=".$row['total_quantity_bundle'].",");
                          $pdf->Text(9,32.5+$linesSpace,$row['shade_name'].",");
                          $pdf->Text(24,32.5+$linesSpace,$row['pattern']);

                          $pdf->Text(9,36+$linesSpace,"L=".$row['length_wrap'].","."W=".$row['width_weft']);
                          if($row['tods']){
                            $pdf->Text(9,39.5+$linesSpace,date("d-M-y", strtotime($row['tods'])));
                          }
                          else {
                            $pdf->Text(9,39.5+$linesSpace,"");
                          }
                          if($row['total_quantity']){
                            if($row['country_name'] == "CN"){
                            $pdf->SetFont('Arial','B',10.5);
                            $pdf->Text(16.5,43+$linesSpace,$row['country_name']);
                            $pdf->SetFont('Arial','B',7);
                            $pdf->Text(22,43+$linesSpace,"=".$row['total_quantity']."(".$row['po_total_quantity'].")");
                            }else {
                            $pdf->Text(13,43+$linesSpace,$row['country_name']."=".$row['total_quantity']."(".$row['po_total_quantity'].")");
                            }
                          }
                          else {
                            if($row['country_name'] == "CN"){
                            $pdf->SetFont('Arial','B',10.5);
                            $pdf->Text(16.5,43+$linesSpace,$row['country_name']);
                            }else {
                              $pdf->Text(13,43+$linesSpace,$row['country_name']);
                            }
                          }
                     }

                 //}
             }
//exit();
                  $pdf->Output();
            ?>


<script type="text/javascript">

</script>
