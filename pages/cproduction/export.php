<?php
       require('../../fpdf17/fpdf.php');
       require('../../fpdf17/exfpdf.php');
       require('../../fpdf17/easyTable.php');
       require_once '../../DB/order/select.php';

       //get order id
       $order_id = $_GET['id'];

       //select order details
       $selectOrder = new select_order();
       $order_result = $selectOrder->select_with_id($order_id);
       $order_details = mysqli_fetch_assoc($order_result);

       //select country list with order id
       $orderedCountryList = $selectOrder->select_oder_country_with_id($order_id);

       //select child of order details
       $order_child_result_size = $selectOrder->select_child_with_id($order_id);
       $order_child_result_quantity = $selectOrder->select_child_with_id($order_id);


       $pdf=new exFPDF('L','mm','A4');
       $pdf->AddPage();
       $pdf->SetFont('Arial','',2);

       $x=$pdf->GetX();
       $y=$pdf->GetY();
       $count = 0;

       while ($country = mysqli_fetch_assoc($orderedCountryList)) {

         $order_child_size_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
         $order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
         $row_number = mysqli_num_rows($order_child_size_country) + 7;

          if($count == 20){
            $pdf->AddPage();
            $count = 1;
          }

         if($count == 0){

           $table = new easyTable($pdf, $row_number, 'width:600; align:L{LC};split-row:true;border:TBRL; font-size:8;font-style:B;');
           $table->easyCell("Country",'align:L;colspan:2;');
           $table->easyCell("TOD",'');
           $table->easyCell("CUT OFF",'align:L;');
           $table->easyCell("Shipment",'');

           while ($row = mysqli_fetch_assoc($order_child_size_country)){
           $table->easyCell($row['size'],'align:L');
           }

           $table->easyCell("Total",'align:L;colspan:2;');
           $table->easyCell("Remarks",'align:L;colspan:2;');

           $table->printRow();
         }

         $count ++;

         $table->easyCell($country['country_name'],'align:L;colspan:2;');
         $table->easyCell($country['tod'],'');
         $table->easyCell($country['cut_off'],'align:L;');
         $table->easyCell($country['shipment'],'align:L;');

         $totalQuantity = 0;
         while ($row = mysqli_fetch_assoc($order_child_quantity_country)){
         $table->easyCell($row['quantity'],'align:L');
         $totalQuantity += $row['quantity'];
         }

         $table->easyCell($totalQuantity,'align:L;colspan:2;');
         $table->easyCell("",'align:L;colspan:2;');

         $table->printRow();

       }

       $table->endTable(10);
       $pdf->Output();

?>
