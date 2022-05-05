<?php
       require('fpdf17/fpdf.php');
       require('fpdf17/exfpdf.php');
       require('fpdf17/easyTable.php');
       require_once '../../../DB/cproduction/select.php';

       $pdf=new exFPDF('L','mm','A4');
       $pdf->AddPage();
       $pdf->SetFont('Arial','',2);

       $x=$pdf->GetX();
       $y=$pdf->GetY()-3;
       $pdf->SetAutoPageBreak(false);
       $count = 0;
       $countAgain = 0;
       $test = 0;

       $cut_pro_id = $_GET['cut_pro_id'];
       $ticket = $_GET['ticket'];

       try{
         $print_number = $_GET['print_number'];
       } catch (Exception $err){
         $print_number = 1;
       }

       if($print_number == 0 || $print_number == "")
       {
         $print_number = 1;
       }
$bundle_id = array();
       //select cproduction details
       $selectCproduction = new select_cproduction();
       $cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
       $cproduction_details = mysqli_fetch_assoc($cproduction_result);

       //select child of cproduction bundles
       $cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);
       $cproduction_previous__child_result = $selectCproduction->select_previous_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);
       $count_zero = 0;
        foreach ($cproduction_previous__child_result as $cproduction_previous_child_result_info) {
          if($cproduction_previous_child_result_info['quantity'] == 0 ){
            $count_zero++ ;
          }
          // echo '<pre>';
          // print_r($cproduction_previous_child_result_info);
          // echo '</pre>';
        }
      //   echo '<pre>';
      //   print_r($count_zero);
      //   echo '</pre>';
      // exit();
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

             if($countAgain % 3 == 1)
             {
               $pdf->SetY($y+(35*($test)));
               $table=new easyTable($pdf, 5, 'width:84; align:M{MC};split-row:true;border:TBRL; font-size:5.5;font-style:B;');

               $table->endTable(10);


               $pdf->SetY($y+(35*$test));
               $table=new easyTable($pdf, 5, 'width:84; align:R{RC};split-row:true;border:TBRL; font-size:5.5;font-style:B;');

               $table->endTable(10);
               $test ++;
               $countAgain += 2;

             }
             if($countAgain % 3 == 2)
             {
               $pdf->SetY($y+(35*$test));
               $table=new easyTable($pdf, 5, 'width:84; align:R{RC};split-row:true;border:TBRL; font-size:5.5;font-style:B;');

               $table->endTable(10);
               $test ++;
               $countAgain += 1;

             }

             $cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);

             $inseam = "";
        	 while ($row = mysqli_fetch_assoc($cproduction_child_result))
        	 {
             // if($row['quantity'] == 0 ){
             //   $count_zero++ ;
             // }
             // if (!in_array($row['id'], $bundle_id)){
             // $bundle_id[] = $row['id'];
             //   if($row['quantity'] == 0 ){
             //     $count_zero++ ;
             //   }
             // }

               if($row['quantity'] > 0){
                 for($i=1;$i<=$print_number;$i++){

                 $countAgain ++;
                 $bundle_no = $row['bundle_no']-$count_zero;
                 //$bundle_no = $row['bundle_no'];
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

                 if($row['inseam']){
                     if(!$inseam){
                       $inseam = $row['inseam'];
                     }
                 }

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

                 $pdf->SetY($y+(35*$test));

                 if($countAgain%3 == 1){
                 $table=new easyTable($pdf, 5, 'width:84; align:L{LC};split-row:true;border:TBRL; font-size:5.5;font-style:B;');

                 $table->easyCell('','img:../qr/temp/'.basename($filename).', w25, h30;rowspan:5;');
                 $table->easyCell("Bundle ".$bundle_no,'align:L;font-size:5;');
                 $table->easyCell($bundle_part,'align:{C};font-size:5;');
                 $table->easyCell($style, 'colspan:2;font-size:5;');
                 $table->printRow();

                 $table->easyCell('Buyer','font-size:5;');
                 $table->easyCell($buyer,'align:L;font-size:5;');
                 $table->easyCell('Color','font-size:5;');
                 if($inseam){
                   $table->easyCell($color.' In:'.$inseam,'align:L;font-size:3.5');
                 }else{
                   $table->easyCell($color,'align:L;font-size:3.5');
                 }
                 $table->printRow();

                 $table->easyCell('Shade grp','font-size:5;');
                 $table->easyCell($shade_name,'align:L;font-size:5;');
                 $table->easyCell('PO','font-size:5;');
                 $table->easyCell($po,'align:{L};font-size:5;');
                 $table->printRow();

                 $table->easyCell('Cut No','font-size:5;');
                 $table->easyCell($cut_number,'align:L;font-size:5;');
                 $table->easyCell('Pattern','font-size:5;');
                 $table->easyCell($pattern,'align:L;font-size:5;');
                 $table->printRow();

                 $table->easyCell('Size','font-size:6;');
                 $table->easyCell($ticket_size,'align:L;font-size:6;');
                 $table->easyCell('Quantity','font-size:6;');
                 $table->easyCell($quantity,'align:L;font-size:6;');
                 $table->printRow();

                 $table->easyCell($qrString,'align:C;');
                 $table->easyCell('Sr from','align:L;font-size:6;');
                 $table->easyCell($from_id,'align:L;font-size:6;');
                 $table->easyCell('Sr to','font-size:6;');
                 $table->easyCell($to_id,'align:L;font-size:6;');
                 $table->printRow();

                 $table->endTable(10);
                 }else if($countAgain%3 == 2){
                  $table=new easyTable($pdf, 5, 'width:84; align:M{MC};split-row:true;border:TBRL; font-size:5.5;font-style:B;');

                  $table->easyCell('','img:../qr/temp/'.basename($filename).', w25, h30;rowspan:5;');
                  $table->easyCell("Bundle ".$bundle_no,'align:L;font-size:5;');
                  $table->easyCell($bundle_part,'align:{C};font-size:5;');
                  $table->easyCell($style, 'colspan:2;font-size:5;');
                  $table->printRow();

                  $table->easyCell('Buyer','font-size:5;');
                  $table->easyCell($buyer,'align:L;font-size:5;');
                  $table->easyCell('Color','font-size:5;');
                  if($inseam){
                    $table->easyCell($color.' In:'.$inseam,'align:L;font-size:3.5');
                  }else{
                    $table->easyCell($color,'align:L;font-size:3.5');
                  }
                  $table->printRow();

                  $table->easyCell('Shade grp','font-size:5;');
                  $table->easyCell($shade_name,'align:L;font-size:5;');
                  $table->easyCell('PO','font-size:5;');
                  $table->easyCell($po,'align:{L};font-size:5;');
                  $table->printRow();

                  $table->easyCell('Cut No','font-size:5;');
                  $table->easyCell($cut_number,'align:L;font-size:5;');
                  $table->easyCell('Pattern','font-size:5;');
                  $table->easyCell($pattern,'align:L;font-size:5;');
                  $table->printRow();

                  $table->easyCell('Size','font-size:6;');
                  $table->easyCell($ticket_size,'align:L;font-size:6;');
                  $table->easyCell('Quantity','font-size:6;');
                  $table->easyCell($quantity,'align:L;font-size:6;');
                  $table->printRow();

                  $table->easyCell($qrString,'align:C;');
                  $table->easyCell('Sr from','align:L;font-size:6;');
                  $table->easyCell($from_id,'align:L;font-size:6;');
                  $table->easyCell('Sr to','font-size:6;');
                  $table->easyCell($to_id,'align:L;font-size:6;');
                  $table->printRow();

                  $table->endTable(10);
                 }else if($countAgain%3 == 0){
                 $table=new easyTable($pdf, 5, 'width:84; align:R{RC};split-row:true;border:TBRL; font-size:5.5;font-style:B;');

                 $table->easyCell('','img:../qr/temp/'.basename($filename).', w25, h30;rowspan:5;');
                 $table->easyCell("Bundle ".$bundle_no,'align:L;font-size:5;');
                 $table->easyCell($bundle_part,'align:{C};font-size:5;');
                 $table->easyCell($style, 'colspan:2;font-size:5;');
                 $table->printRow();

                 $table->easyCell('Buyer','align:L;font-size:5;');
                 $table->easyCell($buyer,'align:L;font-size:5;');
                 $table->easyCell('Color','align:L;font-size:5;');
                 if($inseam){
                   $table->easyCell($color.' In:'.$inseam,'align:L;font-size:3.5');
                 }else{
                   $table->easyCell($color,'align:L;font-size:3.5');
                 }
                 $table->printRow();

                 $table->easyCell('Shade grp','align:L;font-size:5;');
                 $table->easyCell($shade_name,'align:L;font-size:5;');
                 $table->easyCell('PO','align:L;font-size:5;');
                 $table->easyCell($po,'align:{L};font-size:5;');
                 $table->printRow();

                 $table->easyCell('Cut No','align:L;font-size:5;');
                 $table->easyCell($cut_number,'align:L;font-size:5;');
                 $table->easyCell('Pattern','align:L;font-size:5;');
                 $table->easyCell($pattern,'align:L;font-size:5;');
                 $table->printRow();

                 $table->easyCell('Size','align:L;font-size:6;');
                 $table->easyCell($ticket_size,'align:L;font-size:6;');
                 $table->easyCell('Quantity','font-size:6;');
                 $table->easyCell($quantity,'align:L;font-size:6;');
                 $table->printRow();

                 $table->easyCell($qrString,'align:C;font-size:5;');
                 $table->easyCell('Sr from','align:L;font-size:6;');
                 $table->easyCell($from_id,'align:L;font-size:6;');
                 $table->easyCell('Sr to','align:L;font-size:6;');
                 $table->easyCell($to_id,'align:L;font-size:6;');
                 $table->printRow();

                 $table->endTable(10);

                 $test ++;
                 }

                 $count++;
                 }
               }

           	  }
             }
             //
             // echo '<pre>';
             // print_r($count_zero);
             // echo '</pre>';

             $pdf->Output();
            ?>

<script>


</script>
