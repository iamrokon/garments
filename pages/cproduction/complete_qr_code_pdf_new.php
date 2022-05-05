<?php
       require('../../fpdf17/fpdf.php');
       require('../../fpdf17/exfpdf.php');
       require('../../fpdf17/easyTable.php');
       require_once '../../DB/cproduction/select.php';
       require_once '../../DB/size/select.php';
       require_once '../../DB/line/select.php';

       $page_number = 0;
       $selectSize = new select_size();
       $size_list =  $selectSize->select_all_qr();

       $selectLine = new select_line();
       while ($row = mysqli_fetch_assoc($size_list)){
         $all_size[] = $row;
       }

          $pdf = new FPDF('P','mm',array(84,36));

          $id = $_GET['id'];
          $x= 0;

          $total_c_p_val = 0;

          $selectCProduction = new select_cproduction();
          $cProductionResult = $selectCProduction->select_with_id_qr_again($id);

          $j=0;
          $prefix = "";
          $next = 0;

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
          $all_data = array();
          while ($cProductionResultInfo = mysqli_fetch_assoc($cProductionResult))
          {
            $all_data[] = $cProductionResultInfo;
            $maxId = $cProductionResultInfo['qr_code'];
          }
          $bundle = 0;
          foreach ($all_data as $row)
          {

               $bundle++;

               for($i = 0; $i< $row['quantity']; $i++){
                $linesName = ".";

               $maxId++;
               $page_number++;
               $childLineNameInfo = "";

                 $childLineNameInfo = $row['line_name'];

               $country_codes = explode(",",$row['country_code']);


               $ticket_size = "";
               foreach ($all_size as $row_size)
               {
                  if($row['ticket_size'] == $row_size['id']){
                    $final_size = $row_size['size_num'];
                    $size_without_code = $row_size['size_num'];
                    foreach ($country_codes as $country_code) {
                      $code_no = explode("-",$country_code);
                      if($code_no[0] == $row_size['size_num']){
                        $final_size = $country_code;
                      }
                    }
                    if($row_size['inseam']){
                      $ticket_size = $final_size."/".$row_size['inseam'];
                      $ticket_size_without_code = $size_without_code."/".$row_size['inseam'];
                    }else {
                      $ticket_size = $final_size;
                      $ticket_size_without_code = $size_without_code;
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
                    $linesName = $row4['line_name'];

                    // $lineNameInfo =  $selectLine->select_with_id_qr($line);
                    // $line_name = mysqli_fetch_assoc($lineNameInfo);
                    // $linesName = $line_name['name'];

                    if(!$childLineNameInfo){
                      if($linesName){
                        $linesName;
                      }
                    }
                  }

                }
              if($childLineNameInfo){
               $linesName = $childLineNameInfo;
              }
              // if($linesName==""){
              //   $linesName=".";
              // }

              $qrdata= 'ID:'.base_convert($maxId,10,36).', Line:'.$linesName.', Style:' .$row['style_name'].
              ', PO:'.$row['po_number'].', Color:'.$row['color_name'].', Cut_Num:' .$row['cut_number'].', Size:'.$ticket_size_without_code.', Country:' .$row['country_name'].'!';

                 QRcode::png($qrdata, $filename, $errorCorrectionLevel,
                  $matrixPointSize,2);

                          $pdf->AddPage();
                          $pdf->Rect(0,18,41,63+$linesSpace);
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Image($filename,6,57.6+$linesSpace,23,23);
                          $pdf->Text(17,16,$page_number);
                          $pdf->Text(1,23.5+$linesSpace,'Style:');
                          if($row['country_name'] == "CN"){
                          $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(1,27+$linesSpace,'PO:');
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Text(1,30.5+$linesSpace,'Color:');
                          $pdf->Text(20,34+$linesSpace,'Cut:');
                          $pdf->Text(1,34+$linesSpace,'Size:');
                          $pdf->Text(1,37.5+$linesSpace,'Bun:');
                          $pdf->Text(17,37.5+$linesSpace,'SL:');
                          $pdf->Text(1,41+$linesSpace,'QTY:');
                          $pdf->Text(1,44.5+$linesSpace,'Sh:');
                          $pdf->Text(17,44.5+$linesSpace,'Ptn:');
                          $pdf->Text(1,48+$linesSpace,'Srin:');
                          $pdf->Text(1,51.5+$linesSpace,'Tod:');
                          if($row['country_name'] == "CN"){
                          $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(1,55+$linesSpace,'Country:');
                          $pdf->SetFont('Arial','B',8);
                          $pdf->Text(12,59.5,strtoupper(base_convert($maxId,10,36)));

                          $pdf->Text(13,21,$linesName);
                          $pdf->SetFont('Arial','B',6);
                          $pdf->Text(9,23.5+$linesSpace,$row['style_name']);
                          $pdf->SetFont('Arial','B',7);
                          if($row['country_name'] == "CN"){
                            $pdf->SetFont('Arial','B',10.5);
                          }
                          $pdf->Text(10,27+$linesSpace,$row['po_number']);
                          $pdf->SetFont('Arial','B',5);
                          $pdf->Text(10,30.5+$linesSpace,$row['color_name']);
                          $pdf->SetFont('Arial','B',7);

                          $pdf->Text(27,34+$linesSpace,$row['cut_number'].",");
                          // if((substr($ticket_size,-1) == "p") || (substr($ticket_size,-1) == "P")){
                          //   $pdf->SetFont('Arial','B',10.5);
                          // }
                          $pdf->SetFont('Arial','B',10);
                          if((substr($ticket_size,-1) == "p") || (substr($ticket_size,-1) == "P")){
                            $pdf->SetFont('Arial','B',10.5);
                          }
                          elseif((substr($ticket_size,-1) == "6")){
                            $pdf->Text(9,32+$linesSpace,"-----");
                          }
                          elseif((substr($ticket_size,-1) == "9")){
                            $pdf->Text(9,35.5+$linesSpace,"-----");
                          }
                          $pdf->Text(9,34+$linesSpace,$ticket_size);
                          $pdf->SetFont('Arial','B',7);
                          $pdf->Text(9,37.5+$linesSpace,$bundle.",");

                          $serial = $row['to_id']-$row['from_id'];

                          $pdf->Text(24,37.5+$linesSpace,$row['from_id']."-".$row['to_id']."(".$serial.")");
                          $pdf->Text(9,41+$linesSpace,$page_number."=".$row['total_quantity_bundle'].",");
                          $pdf->Text(9,44.5+$linesSpace,$row['shade_name'].",");
                          $pdf->Text(24,44.5+$linesSpace,$row['pattern']);

                          $pdf->Text(9,48+$linesSpace,"L=".$row['length_wrap'].","."W=".$row['width_weft']);
                          if($row['tods']){
                            $pdf->Text(9,51.5+$linesSpace,date("d-M-y", strtotime($row['tods'])));
                          }
                          else {
                            $pdf->Text(9,51.5+$linesSpace,"");
                          }
                          if($row['total_quantity']){
                            if($row['country_name'] == "CN"){
                            $pdf->SetFont('Arial','B',10.5);
                            $pdf->Text(16.5,55+$linesSpace,$row['country_name']);
                            $pdf->SetFont('Arial','B',7);
                            $pdf->Text(22,55+$linesSpace,"=".$row['total_quantity']."(".$row['po_total_quantity'].")");
                            }else {
                            $pdf->Text(13,55+$linesSpace,$row['country_name']."=".$row['total_quantity']."(".$row['po_total_quantity'].")");
                            }
                          }
                          else {
                            if($row['country_name'] == "CN"){
                            $pdf->SetFont('Arial','B',10.5);
                            $pdf->Text(16.5,55+$linesSpace,$row['country_name']);
                            }else {
                              $pdf->Text(13,55+$linesSpace,$row['country_name']);
                            }
                          }
                     }
             }
                  $pdf->Output();
            ?>


<script type="text/javascript">

</script>
