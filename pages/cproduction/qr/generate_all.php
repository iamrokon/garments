<?php
       require('fpdf17/fpdf.php');
       require('fpdf17/exfpdf.php');
       require('fpdf17/easyTable.php');
       require_once '../../../DB/cproduction/select.php';

       $pdf=new exFPDF('L','mm','A4');
       $pdf->AddPage();
       $pdf->SetFont('Arial','',2);

       $x=$pdf->GetX();
       $y=$pdf->GetY()-9;
       $pdf->SetAutoPageBreak(false);

       // echo '<pre>';
       //  print_r($y);
       //  echo  '</pre>';


       $count = 0;
       $countAgain = 0;
       $test = 0;
       $page_number = 0;

       $cut_pro_id = $_GET['cut_pro_id'];

       //select cproduction details
       $selectCproduction = new select_cproduction();
       $cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
       $cproduction_details = mysqli_fetch_assoc($cproduction_result);

       $bundle_per_tkt = $cproduction_details['bundle_no'];
       $bundleNo = 0;

       //select child of cproduction bundles
       $cproduction_child_result = $selectCproduction->select_child_with_id($cut_pro_id);

      //set it to writable location, a place for temp generated PNG files
      $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

      //html PNG location prefix
       $PNG_WEB_DIR = 'temp/';

       include "qrlib.php";

       //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR))
           mkdir($PNG_TEMP_DIR);

           $filename = $PNG_TEMP_DIR.'test.png';

           $cproduction_process_result = $selectCproduction->select_bundle_process_with_production_id($cut_pro_id);
           while ($row_p = mysqli_fetch_assoc($cproduction_process_result))
           {
             // echo '<pre>';
             //  print_r($page_number);
             //  echo  '</pre>';

             // $pdf->Text(145,7,$page_number);
             // $pdf->SetFont('','',7);
             //   $page_number++;

           $cproduction_child_result = $selectCproduction->select_child_with_id($cut_pro_id);
        	 while ($row = mysqli_fetch_assoc($cproduction_child_result))
        	 {



                $bundleNo ++;

                $countAgain ++;

                $bundle_no = $row['bundle_no'];
                $style = $cproduction_details['style_name'];
                $buyer = $cproduction_details['buyer_name'];
                $color = $cproduction_details['color_name'];
                $po = $cproduction_details['po_number'];
                $cut_number = $cproduction_details['cut_number'];
                $shade_name = $row['shade_name'];
                $pattern = $row['pattern'];

                $bundle_tkt_code = dechex($row['id']);

                $bundle_part = $row_p['process_name'];
                $bundle_part_id = $row_p['id'];

                 if($row['label'] != null && $row['label'] != '0')
                {
                  $ticket_size = $row['ticket_size'].'-'.$row['label'];
                }else{
                  $ticket_size = $row['ticket_size'];
                }
                $from_id = $row['from_id'];
                $to_id = $row['to_id'];
                $quantity = $row['quantity'];

                $qrString = $bundle_tkt_code."-".$bundle_part_id;

                $errorCorrectionLevel = 'M';
                $matrixPointSize = min(max((int)4, 1), 10);

                $filename = $PNG_TEMP_DIR.'test'.md5($qrString.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                QRcode::png($qrString, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

                if($countAgain == 19) {
                  $pdf->AddPage();
                  $test = 0;
                  $countAgain = 0;
                }

                if($countAgain == 0) $countAgain ++;



                if($bundleNo == $bundle_per_tkt){

                  if($countAgain % 3 == 1)
                  {
                    $pdf->SetY($y+(36*($test)));
                    $table=new easyTable($pdf, 5, 'width:84; align:M{MC};split-row:true;border:TBRL; font-size:5;font-style:B;');

                    $table->endTable(5);


                    $pdf->SetY($y+(36*$test));






                    $table=new easyTable($pdf, 5, 'width:84; align:R{RC};split-row:true;border:TBRL; font-size:5;font-style:B;');

                    $table->endTable(5);
                    $countAgain += 2;

                  }else if($countAgain % 3 == 2)
                  {
                    $pdf->SetY($y+(36*$test));
                    $table=new easyTable($pdf, 5, 'width:84; align:R{RC};split-row:true;border:TBRL; font-size:5;font-style:B;');

                    $table->endTable(5);
                    $countAgain += 1;

                  }

                  $bundleNo = 0;

                }


                $pdf->SetY($y+(36*$test));

                if($countAgain%3 == 1){
                $table=new easyTable($pdf, 5, 'width:84; align:L{LC};split-row:true;border:TBRL; font-size:5;font-style:B;');

                $table->easyCell('','img:../qr/temp/'.basename($filename).', w25, h30;rowspan:5;');
                $table->easyCell("Bundle ".$bundle_no,'align:L;font-size:6');
                $table->easyCell($bundle_part,'align:{C};font-size:6');
                $table->easyCell($style, 'colspan:2;font-size:6;');
                $table->printRow();

                $table->easyCell('Buyer');
                $table->easyCell($buyer,'align:L;font-size:6');
                $table->easyCell('Color','font-size:6');
                $table->easyCell($color,'align:L;font-size:5');
                $table->printRow();

                $table->easyCell('Shade grp','font-size:6');
                $table->easyCell($shade_name,'align:L;font-size:6');
                $table->easyCell('PO','font-size:6');
                $table->easyCell($po,'align:{L};font-size:6;');
                $table->printRow();

                $table->easyCell('Cut No','font-size:6');
                $table->easyCell($cut_number,'align:L;font-size:6');
                $table->easyCell('Pattern','font-size:6');
                $table->easyCell($pattern,'align:L;font-size:6');
                $table->printRow();

                $table->easyCell('Size','font-size:6');
                $table->easyCell($ticket_size,'align:L;font-size:6');
                $table->easyCell('Quantity','font-size:6');
                $table->easyCell($quantity,'align:L;font-size:6');
                $table->printRow();

                $table->easyCell($qrString,'align:C;font-size:6');
                $table->easyCell('Sr from','align:L;font-size:6');
                $table->easyCell($from_id,'align:L;font-size:6');
                $table->easyCell('Sr to','font-size:6');
                $table->easyCell($to_id,'align:L;font-size:6');
                $table->printRow();

                $table->endTable(5);
                }else if($countAgain%3 == 2){
                 $table=new easyTable($pdf, 5, 'width:84; align:M{MC};split-row:true;border:TBRL; font-size:5;font-style:B;');

                 $table->easyCell('','img:../qr/temp/'.basename($filename).', w25, h30;rowspan:5;');
                 $table->easyCell("Bundle ".$bundle_no,'align:L;font-size:6');
                 $table->easyCell($bundle_part,'align:{C};font-size:6');
                 $table->easyCell($style, 'colspan:2;font-size:6;');
                 $table->printRow();

                 $table->easyCell('Buyer','font-size:6');
                 $table->easyCell($buyer,'align:L;font-size:6');
                 $table->easyCell('Color','font-size:6');
                 $table->easyCell($color,'align:L;font-size:5');
                 $table->printRow();

                 $table->easyCell('Shade grp','font-size:6');
                 $table->easyCell($shade_name,'align:L;font-size:6');
                 $table->easyCell('PO','font-size:6');
                 $table->easyCell($po,'align:{L};font-size:6;');
                 $table->printRow();

                 $table->easyCell('Cut No','font-size:6');
                 $table->easyCell($cut_number,'align:L;font-size:6');
                 $table->easyCell('Pattern','font-size:6');
                 $table->easyCell($pattern,'align:L;font-size:6');
                 $table->printRow();

                 $table->easyCell('Size','font-size:6');
                 $table->easyCell($ticket_size,'align:L;font-size:6');
                 $table->easyCell('Quantity','font-size:6');
                 $table->easyCell($quantity,'align:L;font-size:6');
                 $table->printRow();

                 $table->easyCell($qrString,'align:C;font-size:6');
                 $table->easyCell('Sr from','align:L;font-size:6');
                 $table->easyCell($from_id,'align:L;font-size:6');
                 $table->easyCell('Sr to','font-size:6');
                 $table->easyCell($to_id,'align:L;font-size:6');
                 $table->printRow();

                 $table->endTable(5);
                }else if($countAgain%3 == 0){
                $table=new easyTable($pdf, 5, 'width:84; align:R{RC};split-row:true;border:TBRL; font-size:5;font-style:B;');

                $table->easyCell('','img:../qr/temp/'.basename($filename).', w25, h30;rowspan:5;');
                $table->easyCell("Bundle ".$bundle_no,'align:L;font-size:6');
                $table->easyCell($bundle_part,'align:{C};font-size:6');
                $table->easyCell($style, 'colspan:2;font-size:6;');
                $table->printRow();

                $table->easyCell('Buyer','align:L;font-size:6');
                $table->easyCell($buyer,'align:L;font-size:6');
                $table->easyCell('Color','align:L;font-size:6');
                $table->easyCell($color,'align:L;font-size:5');
                $table->printRow();

                $table->easyCell('Shade grp','align:L;font-size:6');
                $table->easyCell($shade_name,'align:L;font-size:6');
                $table->easyCell('PO','align:L;font-size:6');
                $table->easyCell($po,'align:{L};font-size:6;');
                $table->printRow();

                $table->easyCell('Cut No','align:L;font-size:6;');
                $table->easyCell($cut_number,'align:L;font-size:6;');
                $table->easyCell('Pattern','align:L;font-size:6;');
                $table->easyCell($pattern,'align:L;font-size:6;');
                $table->printRow();

                $table->easyCell('Size','align:L;font-size:6;');
                $table->easyCell($ticket_size,'align:L;font-size:6;');
                $table->easyCell('Quantity','font-size:6');
                $table->easyCell($quantity,'align:L;font-size:6;');
                $table->printRow();

                $table->easyCell($qrString,'align:C;font-size:6;');
                $table->easyCell('Sr from','align:L;font-size:6;');
                $table->easyCell($from_id,'align:L;font-size:6;');
                $table->easyCell('Sr to','align:L;font-size:6;');
                $table->easyCell($to_id,'align:L;font-size:6;');
                $table->printRow();

                $table->endTable(5);

                $test ++;
              }

               $count++;

           	  }
             }
             //exit();
             $pdf->Output();
            ?>

<script>


</script>
