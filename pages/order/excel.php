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


$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(18);

$count = 7;
$j=1;
$pre_tod[] = 0;
$totalColQuantity[] = 0;
$grandTotal[] = 0;
$k = 0;
$total_row = mysqli_num_rows($orderedCountryList);
// echo "<pre>";
// print_r($total_row);
// echo "</pre>";
while ($countryInfo = mysqli_fetch_assoc($orderedCountryList)) {
	$all_countries[] = $countryInfo;
}

foreach ($all_countries as $country) {
	$order_child_size_without_p_exist = $selectOrder->select_child_with_order_and_country_without_p($order_id,$country['country_id']);
}
$size_without_p_exist = "";
while ($size = mysqli_fetch_assoc($order_child_size_without_p_exist)) {
	$size_without_p_exist = $size;
}
if($size_without_p_exist){
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('G1', "Starling Denims Limited")
               ->setCellValue('H2', $order_details['style_name'])
							 ->setCellValue('H3', "PO-".$order_details['po_number'])
							 ->setCellValue('H4', "Color : ".$order_details['color_name'])
							 ->setCellValue('H5', "Quantity : ".$order_details['total_quantity']);
}

if($size_without_p_exist){
  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A7', "Country")
              ->setCellValue('B7', "TOD")
              ->setCellValue('C7', "CUT OFF")
              ->setCellValue('D7', "SHIPMENT");
}


foreach ($all_countries as $country) {

	if($size_without_p_exist){
  $count++;
}

  $order_child_size_country = $selectOrder->select_child_with_order_and_country_without_p($order_id,$country['country_id']);
  $order_child_quantity_country = $selectOrder->select_child_with_order_and_country_without_p($order_id,$country['country_id']);
  $row_number = mysqli_num_rows($order_child_size_country) + 7;

	if( $pre_tod[$j-1] != $country['tod'] && $k!=0){

		if($size_without_p_exist){
		$objPHPExcel->setActiveSheetIndex(0)
	            	->setCellValue('D'.$count, "Total");
		}
		$sizeCountA = 4;
		foreach ($totalColQuantity as $totalColQuantityValue) {
			if($size_without_p_exist){
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalColQuantityValue);
							$sizeCountA++;
						}
		 }
		for($i=0;$i<$k;$i++){
			$totalColQuantity[$i] = 0;
		}
		$count++;
	}
	$pre_tod[$j] = $country['tod'];

	if($size_without_p_exist){
  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A'.$count, $country['country_name'])
              ->setCellValue('B'.$count, date("d-M-y", strtotime($country['tod'])))
              ->setCellValue('C'.$count, $country['cut_off'])
              ->setCellValue('D'.$count, date("d-M-y", strtotime($country['shipment'])));
}
$sizeCount = 4;
while ($size = mysqli_fetch_assoc($order_child_size_country)) {
	$lastchar = substr($size['size'], -1);
	if($lastchar != 'p' && $lastchar != 'P'){
	 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCount, 7, $size['size']);
	}
   $sizeCount++;
 }

 if($size_without_p_exist){
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCount, 7, "Total");
}

  $sizeCountA = 4;
  $totalQuantity = 0;
	$k = 0;
  while ($row = mysqli_fetch_assoc($order_child_quantity_country)){

			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $row['quantity']);

              $sizeCountA++;
              $totalQuantity += $row['quantity'];
							if($count == 8){
	              $totalColQuantity[$k] = $row['quantity'];
								$grandTotal[$k] = $row['quantity'];
							}
							else {
	              $totalColQuantity[$k] += $row['quantity'];
								$grandTotal[$k] += $row['quantity'];
							}
							$k++;
     }

	if($totalQuantity){

		if($size_without_p_exist){
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalQuantity);
		 }
	}

$j++;
}
if($j==$total_row+1){
 	$count++;

	if($size_without_p_exist){
	$objPHPExcel->setActiveSheetIndex(0)
							 ->setCellValue('D'.$count, "Total");
						 }
	 $sizeCountA = 4;
	 foreach ($totalColQuantity as $totalColQuantityValue) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalColQuantityValue);
						 $sizeCountA++;
		}
 	$count++;

	if($size_without_p_exist){
	$objPHPExcel->setActiveSheetIndex(0)
							 ->setCellValue('D'.$count, "Grand Total");
						 }
	 $sizeCountA = 4;
	 foreach ($grandTotal as $grandTotalValue) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $grandTotalValue);
						 $sizeCountA++;
	}
}


$objPHPExcel->getActiveSheet()->getStyle('G'.($count+2))->getFont()->setSize(18);

foreach ($all_countries as $country) {
	$order_child_size_country2_exist = $selectOrder->select_child_with_order_and_country_with_p($order_id,$country['country_id']);
}
$size_exist = "";
while ($size = mysqli_fetch_assoc($order_child_size_country2_exist)) {
	$size_exist = $size;
}
if($size_exist){

$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('G'.($count+2), "Starling Denims Limited")
						->setCellValue('H'.($count+3), $order_details['style_name'])
						->setCellValue('H'.($count+4), "PO-".$order_details['po_number'])
						->setCellValue('H'.($count+5), "Color : ".$order_details['color_name'])
						->setCellValue('H'.($count+6), "Color : ".$order_details['total_quantity']);
}
$totalColQuantity2[] = 0;
$grandTotal2[] = 0;
$m = 0;
$count = $count+8;
$previous_count = $count;
if($size_exist){
$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$previous_count, "Country")
						->setCellValue('B'.$previous_count, "TOD")
						->setCellValue('C'.$previous_count, "CUT OFF")
						->setCellValue('D'.$previous_count, "SHIPMENT");
}


foreach ($all_countries as $country) {

  $count++;

  $order_child_size_country2 = $selectOrder->select_child_with_order_and_country_with_p($order_id,$country['country_id']);
  $order_child_quantity_country2 = $selectOrder->select_child_with_order_and_country_with_p($order_id,$country['country_id']);
  $row_number = mysqli_num_rows($order_child_size_country) + mysqli_num_rows($order_child_size_country2) + 7;

	if( $pre_tod[$j-1] != $country['tod'] && $m!=0){
if($size_exist){
		$objPHPExcel->setActiveSheetIndex(0)
	            	->setCellValue('D'.$count, "Total");
}
		$sizeCountA = 4;
		foreach ($totalColQuantity2 as $totalColQuantityValue) {
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalColQuantityValue);
							$sizeCountA++;
		 }
		for($i=0;$i<$k;$i++){
			$totalColQuantity2[$i] = 0;
		}
		$count++;
	}
	$pre_tod[$j] = $country['tod'];

	if($size_exist){
  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A'.$count, $country['country_name'])
              ->setCellValue('B'.$count, date("d-M-y", strtotime($country['tod'])))
              ->setCellValue('C'.$count, $country['cut_off'])
              ->setCellValue('D'.$count, date("d-M-y", strtotime($country['shipment'])));
}
$sizeCount = 4;
while ($size = mysqli_fetch_assoc($order_child_size_country2)) {
	$lastchar = substr($size['size'], -1);
	//if(!($lastchar != 'p' && $lastchar != 'P')){
	 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCount, $previous_count, $size['size']);
	//}
   $sizeCount++;
 }
if($size_exist){
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCount, $previous_count, "Total");
}

  $sizeCountA = 4;
  $totalQuantity = 0;
	$m = 0;
  while ($row = mysqli_fetch_assoc($order_child_quantity_country2)){

			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $row['quantity']);

              $sizeCountA++;
              $totalQuantity += $row['quantity'];
							if($count == $previous_count+1){
	              $totalColQuantity2[$m] = $row['quantity'];
								$grandTotal2[$m] = $row['quantity'];
							}
							else {
	              $totalColQuantity2[$m] += $row['quantity'];
								$grandTotal2[$m] += $row['quantity'];
							}
							$m++;
     }

	if($totalQuantity){
			 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalQuantity);
	}

$j++;
}








if($j==$total_row*2+1){
 	$count++;
	if($size_exist){
	$objPHPExcel->setActiveSheetIndex(0)
							 ->setCellValue('D'.$count, "Total");
						 }
	 $sizeCountA = 4;
	 foreach ($totalColQuantity2 as $totalColQuantityValue) {
		 if($size_exist){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $totalColQuantityValue);
						 $sizeCountA++;
					 }
		}
 	$count++;
	if($size_exist){
	$objPHPExcel->setActiveSheetIndex(0)
							 ->setCellValue('D'.$count, "Grand Total");
	}
	 $sizeCountA = 4;
	 foreach ($grandTotal2 as $grandTotalValue) {
		 if($size_exist){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($sizeCountA, $count, $grandTotalValue);
						 $sizeCountA++;
					 }
	}
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
$objPHPExcel->getActiveSheet()->setTitle('Bundle Ticket');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$file_name = $order_details['po_number'];
//$file_name = $order_details['style_name']."-".$order_details['po_number'];

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($file_name.".xlsx");

echo '<html><a href="'.$file_name.'.xlsx">download</a></html>';
?>
