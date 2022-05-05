<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../excel/Classes/PHPExcel.php';
require_once '../../DB/order/select.php';
require_once '../../DB/cproduction/select.php';

//get order id
$order_id = $_GET['id'];

//select order details
$selectOrder = new select_order();
$order_result = $selectOrder->select_with_id($order_id);
$order_details = mysqli_fetch_assoc($order_result);

$selectCProduction = new select_cproduction();
//select country list with order id
$orderedCountryList = $selectOrder->select_oder_country_with_id($order_id);

//select child of order details
$order_child_result_size = $selectOrder->select_child_with_id($order_id);
$order_child_result_quantity = $selectOrder->select_child_with_id($order_id);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

               $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FF0000'),
                    'size'  => 15,
                    'name'  => 'Verdana'
                ));


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Q3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('T3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('U3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('V3')->getAlignment()->setWrapText(true);

$count = 3;
// $j=1;
// $pre_tod[] = 0;
// $totalColQuantity[] = 0;
// $grandTotal[] = 0;
// $k = 0;
$total_row = mysqli_num_rows($orderedCountryList);
// echo "<pre>";
// print_r($total_row);
// echo "</pre>";
while ($countryInfo = mysqli_fetch_assoc($orderedCountryList)) {
	$all_countries[] = $countryInfo;
}





	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('G1', "Order to Shipment Status");

  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A3', "Style Name")
            	->setCellValue('B3', "Season")
              ->setCellValue('C3', "PO. NO.")
              ->setCellValue('D3', "Color")
              ->setCellValue('E3', "TOD")
              ->setCellValue('F3', "Shipment Date")
              ->setCellValue('G3', "Country")
              ->setCellValue('H3', "Order Qty")
              ->setCellValue('I3', "Cutting Plan Qty")
              ->setCellValue('J3', "Cutting Production Qty")
              ->setCellValue('K3', "Input Issue Qty")
              ->setCellValue('L3', "Sewing Output Qty")
              ->setCellValue('M3', "Wash Send Qty")
              ->setCellValue('N3', "Wash Received Qty")
              ->setCellValue('O3', "Finishing Input Qty")
              ->setCellValue('P3', "Finishing Output/Pack Qty")
              ->setCellValue('Q3', "Pack Balance")
              ->setCellValue('R3', "Shipment Qty")
              ->setCellValue('S3', "Shipment Short Excess")
              ->setCellValue('T3', "Finishing Input Balance")
              ->setCellValue('U3', "Wash Balance")
              ->setCellValue('V3', "Sewing Balance")
              ->setCellValue('W3', "Cutoff")
              ->setCellValue('X3', "Week")
              ->setCellValue('Y3', "Remarks");



$size_id_list=0;
foreach ($orderedCountryList as $country) {

  $order_child_size_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
  $order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
  $total = 0;

  $count++;

  //$order_child_size_country = $selectOrder->select_child_with_order_and_country_without_p($order_id,$country['country_id']);
  //$order_child_quantity_country = $selectOrder->select_child_with_order_and_country_without_p($order_id,$country['country_id']);
  $row_number = mysqli_num_rows($order_child_size_country) + 3;

	// if( $pre_tod[$j-1] != $country['tod'] && $k!=0){
  //
	// 	$objPHPExcel->setActiveSheetIndex(0)
	//             	->setCellValue('D'.$count, "Total");
	// 	$sizeCountA = 4;
	// 	foreach ($totalColQuantity as $totalColQuantityValue) {
	// 		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalColQuantityValue);
	// 						$sizeCountA++;
	// 	 }
	// 	for($i=0;$i<$k;$i++){
	// 		$totalColQuantity[$i] = 0;
	// 	}
	// 	$count++;
	// }
	//$pre_tod[$j] = $country['tod'];
  $total_order_quantity = 0;
  while ($row = mysqli_fetch_assoc($order_child_quantity_country))
  {
    $total_order_quantity += $row['quantity'];
  }
  mysqli_free_result($order_child_quantity_country);

  $order_child_quantity_country2 = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
  $total_cutting_plan_quantity = 0;
  while ($row = mysqli_fetch_assoc($order_child_quantity_country2))
  {
    $quantity = ceil((($order_details['cutting_plan']*$row['quantity'])/100)+$row['quantity']);
    $total_cutting_plan_quantity += $quantity;
  }

  while ($row = mysqli_fetch_assoc($order_child_size_country)){
      if($size_id_list == 0){
        $order_size_id = $selectCProduction->select_size_id($row['size']);
        $size_id[] = mysqli_fetch_assoc($order_size_id);
      }
    }
    $size_id_list = 1;
  $cut_pro_qty = 0;
  foreach ($size_id as  $size_info)
  {
     $total_size_quantity = 0;
     $cut_pro_info = $selectCProduction->select_cut_pro_info_by_po($order_details['po'],$size_info['id'],$country['country_id']);
     foreach ($cut_pro_info as  $row)
     {
       $total_size_quantity += $row['total_quantity'];
     }
     $cut_pro_qty += $total_size_quantity;
  }

	$iissueTotal = 0;
		foreach ($size_id as  $size_info)
		{
			 $total_iissue_quantity_by_size = 0;
			 $cut_pro_info2 = $selectCProduction->select_iissue_scan_qty_by_po($order_details['po'],$size_info['id'],$country['country_id']);
			 foreach ($cut_pro_info2 as  $row)
			 {
				 $total_iissue_quantity_by_size += $row['total_scan_quantity'];
			 }
			 $iissueTotal += $total_iissue_quantity_by_size;

		}

  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$count, $order_details['style_name'])
              ->setCellValue('B'.$count, "")
              ->setCellValue('C'.$count, $order_details['po_number'])
              ->setCellValue('D'.$count, $order_details['color_name'])
              ->setCellValue('E'.$count, $country['tod'])
              ->setCellValue('F'.$count, date("d-M-y", strtotime($country['shipment'])))
            	->setCellValue('G'.$count, $country['country_name'])
            	->setCellValue('H'.$count, $total_order_quantity)
            	->setCellValue('I'.$count, $total_cutting_plan_quantity)
              ->setCellValue('J'.$count, $cut_pro_qty)
              ->setCellValue('K'.$count, $iissueTotal);

}

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0);

$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Order Shipment Status');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$file_name = $order_details['po_number'];
//$file_name = $order_details['style_name']."-".$order_details['po_number'];

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($file_name.".xlsx");

echo '<html><a href="'.$file_name.'.xlsx">download</a></html>';
?>
