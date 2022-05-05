<?php require_once '../../../DB/cproduction/select.php'; ?>
<?php
       require('fpdf17/fpdf.php');

       $pdf = new FPDF('L','mm',array(70,35));

       $cut_pro_id = $_GET['cut_pro_id'];
       $ticket = $_GET['ticket'];


       try{
         $print_number = $_GET['print_number'];
       } catch (Exception $err){
         $print_number = 5;
       }

       //select cproduction details
       $selectCproduction = new select_cproduction();
       $cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
       $cproduction_details = mysqli_fetch_assoc($cproduction_result);

       //select child of cproduction bundles
       $cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);

       $cproduction_process_result = $selectCproduction->select_bundle_process_with_production_id($cut_pro_id);


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
             while ($row_p = mysqli_fetch_assoc($cproduction_process_result))
          	 {
               $bundle_no = $row['bundle_no'];
               $style = $cproduction_details['style_name'];
               $buyer = $cproduction_details['buyer_name'];
               $color = $cproduction_details['color_name'];
               $po = $cproduction_details['po_number'];
               $cut_number = $cproduction_details['cut_number'];
               $shade_name = $cproduction_details['shade_name'];

               $bundle_tkt_code = $row['b_tkt_code'];

               $bundle_part = $row_p['process_name'];
               $bundle_part_id = $row_p['id'];

               $ticket_size = $row['ticket_size'];
               $from_id = $row['from_id'];
               $to_id = $row['to_id'];
               $quantity = $row['quantity'];

               // $qrString = 'bundle='.$bundle_no.','.
               //             'size='.$ticket_size.','.
               //             'style='.$style.','.
               //             'buyer='.$buyer.','.
               //             'color='.$color.','.
               //             'po='.$po.','.
               //             'cut_no='.$cut_number.','.
               //             'shade='.$shade_name.'';

               $qrString = $bundle_tkt_code."-".$bundle_part_id;


        	     $errorCorrectionLevel = 'M';
               $matrixPointSize = min(max((int)4, 1), 10);

               $filename = $PNG_TEMP_DIR.'test'.md5($qrString.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
               QRcode::png($qrString, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

               for($k=0; $k<$print_number; $k++){

                $pdf->AddPage();
                $pdf->SetFont('Arial','B',7);
                $pdf->Image($filename,2,2,20,30);

                $pdf->Text(8,33,$bundle_part);

                $pdf->Text(25,5,'Bundle :');
                $pdf->Text(40,5,'Buyer:');
                $pdf->Text(25,9,'Style:');
                $pdf->Text(25,13,'Color:');
                $pdf->Text(25,17,'PO:');
                $pdf->Text(25,21,'Cut No:');
                $pdf->Text(25,25,'SR :');
                // $pdf->Text(25,33,'SR To:');
                $pdf->Text(25,29,'QTY:');
                $pdf->Text(25,33,'Size:');

                $pdf->Text(37,5,$bundle_no);
                $pdf->Text(49,5,$buyer);
                $pdf->Text(37,9,$style);
                $pdf->Text(37,13,$color);
                $pdf->Text(37,17,$po);
                $pdf->Text(37,21,$cut_number);
                $pdf->Text(37,25,$from_id." to ".$to_id);
                //$pdf->Text(37,33,$to_id);
                $pdf->Text(37,29,$quantity);
                $pdf->Text(37,33,$ticket_size);
                }
           	  }
            }
                  $pdf->Output();
            ?>

<script>

function printDiv(){
		//Get the HTML of div
            var divElements = document.getElementById('qr').innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
              "<html><head><title></title></head><body>" +
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
		}


</script>
