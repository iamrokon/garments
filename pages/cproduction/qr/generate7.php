<?php require_once '../../../layout/rootURL.php';?>
<?php require_once '../../../DB/cproduction/select.php'; ?>

<?php
       require('fpdf17/fpdf.php');
       require('fpdf17/exfpdf.php');
       require('fpdf17/easyTable.php');

       $pdf=new exFPDF('L','mm','A4');
       $pdf->AddPage();
       $pdf->SetFont('Arial','',2);

       $x=$pdf->GetX();
       $y=$pdf->GetY();
       $count = 0;

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

       //select cproduction details
       $selectCproduction = new select_cproduction();
       $cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
       $cproduction_details = mysqli_fetch_assoc($cproduction_result);

       //select child of cproduction bundles
       $cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);

       ?>

      <?php

      //set it to writable location, a place for temp generated PNG files
      $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

      //html PNG location prefix
       $PNG_WEB_DIR = 'temp/';

       include "qrlib.php";

       //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

        $filename = $PNG_TEMP_DIR.'test.png';

        	 while ($row = mysqli_fetch_assoc($cproduction_child_result))
        	 {
             $cproduction_process_result = $selectCproduction->select_bundle_process_with_production_id($cut_pro_id);
             while ($row_p = mysqli_fetch_assoc($cproduction_process_result))
          	 {
               for($i=1;$i<=$print_number;$i++){

               $bundle_no = $row['bundle_no'];
               $style = $cproduction_details['style_name'];
               $buyer = $cproduction_details['buyer_name'];
               $color = $cproduction_details['color_name'];
               $po = $cproduction_details['po_number'];
               $cut_number = $cproduction_details['cut_number'];
               $shade_name = $cproduction_details['shade_name'];

               $bundle_tkt_code = dechex($row['id']);

               $bundle_part = $row_p['process_name'];
               $bundle_part_id = $row_p['id'];

               $ticket_size = $row['ticket_size'];
               $from_id = $row['from_id'];
               $to_id = $row['to_id'];
               $quantity = $row['quantity'];

               $qrString = $bundle_tkt_code."-".$bundle_part_id;


        	     $errorCorrectionLevel = 'M';
               $matrixPointSize = min(max((int)4, 1), 10);

               $filename = $PNG_TEMP_DIR.'test'.md5($qrString.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
               QRcode::png($qrString, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

               if($count == 6) {
                 $pdf->AddPage();
                 $count = 0;
               }

               $pdf->SetY($y+(29*$count));
               $table=new easyTable($pdf, 6, 'width:100; align:L{LC};border:TBRL; font-size:6.5');

               $table->rowStyle('min-height:.4;');
               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1', 'colspan:2; bgcolor:#FF66AA');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->endTable(10);


               $pdf->SetY($y+(29*$count));
               $table=new easyTable($pdf, 6, 'width:100;border:TBRL; font-size:6.5');

               $table->rowStyle('min-height:.6;');
               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1', 'colspan:2; bgcolor:#FF66AA');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->endTable(10);


               $pdf->SetY($y+(29*$count));
               $table=new easyTable($pdf, 6, 'width:100;align:R{RC}; border:TBRL; font-size:6.5;');

               $table->rowStyle('min-height:.6;');
               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1', 'colspan:2; bgcolor:#FF66AA');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->easyCell('Text 1');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->easyCell('Text 1');
               $table->easyCell('Text 2','align:{C}');
               $table->printRow();

               $table->endTable(10);

               $count++;



               $pdf->Output();
           	  }
             }
            }
            ?>

<script>


</script>
