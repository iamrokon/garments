<?php require_once '../../../layout/rootURL.php';?>
<?php require_once '../../../DB/cproduction/select.php'; ?>

<?php
       require('fpdf17/fpdf.php');

       $pdf = new FPDF('P','mm','A4');
       $pdf->AddPage();
       $pdf->SetFont('Arial','B',5);


        $write=new easyTable($pdf, 1, 'width:150; align:L; font-style:B; font-size:15;font-family:times;');
        $write->easyCell('Evolution of a table');
        $write->printRow();
        $write->endTable(5);

       //########################################################

        $tableB=new easyTable($pdf, 5, 'width:100; align:L{LC}; font-color:#0066ff');

        $tableB->easyCell("Cell 1A A\n B\n C\n D\n E\n F\n", 'rowspan:5;');
        $tableB->easyCell("Cell 1BC BB", 'rowspan:2; colspan:2; valign:B');
        $tableB->easyCell("Cell 1D 1");
        $tableB->easyCell("Cell 1D 1", '');
        $tableB->printRow();

        $tableB->easyCell("Cell 2D 1\n 2\n 3\n");
        $tableB->easyCell("Cell 2D 1\n 2\n 3\n", 'rowspan:3;');
        $tableB->printRow();

        $tableB->easyCell("Cell 10 ");
        $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:3;');
        $tableB->easyCell("Cell 12 1\n 2\n 3\n 4\n 5\n", 'rowspan:2;');
        $tableB->printRow();

        $tableB->easyCell("Cell 12 ", '');
        $tableB->printRow();

        $tableB->easyCell("Cell 10 A");
        $tableB->easyCell("Cell 12 1");
        $tableB->easyCell("Cell 12 1");
        $tableB->printRow();

        $tableB->endTable(10);


       $pdf->Output();

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

               ?>
               <!-- <div class="column">
                  <div>
                  <img style="height:120px;width:90px;" src="<?php /* echo $baseUrl.'pages/cproduction/qr/'.$PNG_WEB_DIR.basename($filename); ?>" />
                 </div>

                  <div>
                  <text style="margin-left:20px;font-size:12px;"><?php echo $bundle_part;?></text>
                 </div>
              </div> -->

              <!-- <div class="column" style="margin-top:10px;">
                <text style="margin-left:0px;font-size:10px;">Bundle:<?php echo "  ".$bundle_no;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Style:<?php echo "  ".$style;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Buyer:<?php echo "  ".$buyer;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Color:<?php echo "  ".$color;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Po:<?php echo "  ".$po;?></text><br>
                <text style="margin-left:0px;font-size:10px;">CNo:<?php echo "  ".$cut_number;?></text><br>
                <text style="margin-left:0px;font-size:10px;">SR:<?php echo "  ".$from_id." - ".$to_id;?></text><br>
                <text style="margin-left:0px;font-size:10px;">QTY:<?php echo "  ".$quantity;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Size:<?php echo "  ".$ticket_size; */ ?></text><br>
             </div> -->

            <?php
           	  }


             }
            }
            ?>

<script>


</script>
