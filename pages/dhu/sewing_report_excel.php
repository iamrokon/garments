<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../excel/Classes/PHPExcel.php';
require_once '../../DB/dhu/select.php';

//get order id
$sewing_dhu_report_id = $_GET['id'];

//select order details
$ob = new select_dhu();
$sewing_dhu_report_result = $ob->select_sewing_dhu_report_details($sewing_dhu_report_id);
$sewing_dhu_report_by_id = $ob->select_sewing_dhu_report_by_id($sewing_dhu_report_id);

while ($sewing_dhu_report_info = mysqli_fetch_assoc($sewing_dhu_report_by_id)) {
	$style_name = $sewing_dhu_report_info['style_name'];
	$date = $sewing_dhu_report_info['date'];
	// echo '<pre>';
  // print_r($sewing_dhu_report_info);
  // echo  '</pre>';
}

//select country list with order id
//$orderedCountryList = $selectOrder->select_oder_country_with_id($order_id);

//select child of order details
// $order_child_result_size = $selectOrder->select_child_with_id($order_id);
// $order_child_result_quantity = $selectOrder->select_child_with_id($order_id);

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


	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('C1', "Starling Denims Limited")
                ->setCellValue('C2', "DHANIA, NAYERHAT, ASHULIA, SAVAR, DHAKA")
							  ->setCellValue('C3', "Process Wise Defects Percentage (SEWING)")
							  ->setCellValue('A4', "Style     :")
							  ->setCellValue('B4', $style_name)
							  ->setCellValue('H4', "DATE:")
							  ->setCellValue('I4', $date);
							 // ->setCellValue('H4', "Color : ".$order_details['color_name'])
							 // ->setCellValue('H5', "Color : ".$order_details['total_quantity']);
               // ->setCellValue('A2', $order_details['po_number'])
               // ->setCellValue('D2', $order_details['color_name'])
               //->setCellValue('G1', $order_details['total_quantity']);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(18);

  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A6', "SL NO")
            	->setCellValue('B6', "DEFECTS NAME")
              ->setCellValue('C6', "FRONT")
              ->setCellValue('D6', "BACK")
              ->setCellValue('E6', "WAIST BAND")
              ->setCellValue('F6', "OUTPUT TOP SIDE")
              ->setCellValue('G6', "TOTAL")
              ->setCellValue('H6', "PROCESS WISE %")
              ->setCellValue('I6', "");

$count = 6;
//while ($country = mysqli_fetch_assoc($orderedCountryList)) {
while ($sewing_dhu_report_details = mysqli_fetch_assoc($sewing_dhu_report_result)) {

	//$style_name = $sewing_dhu_report_details['style_name'];
  $count++;
  //$order_child_size_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
  //$order_child_quantity_country = $selectOrder->select_child_with_order_and_country($order_id,$country['country_id']);
  //$row_number = mysqli_num_rows($order_child_size_country) + 7;

  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A'.$count, $count-7)
            	->setCellValue('B'.$count, $sewing_dhu_report_details['rejection'])
              ->setCellValue('C'.$count, $sewing_dhu_report_details['front'])
              ->setCellValue('D'.$count,$sewing_dhu_report_details['back'])
              ->setCellValue('E'.$count, $sewing_dhu_report_details['waist_band'])
              ->setCellValue('F'.$count, $sewing_dhu_report_details['output_top_side'])
              ->setCellValue('G'.$count, $sewing_dhu_report_details['total'])
              ->setCellValue('H'.$count, $sewing_dhu_report_details['process_percent'])
              ->setCellValue('I'.$count, $sewing_dhu_report_details['fixed_value']);

// $sizeCount = 4;
// while ($size = mysqli_fetch_assoc($order_child_size_country)) {
//
//    $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValue(base_convert((10+$sizeCount), 10, 36)."7", $size['size']);
//
//    $sizeCount++;
//  }
//
//   $objPHPExcel->setActiveSheetIndex(0)
//               ->setCellValue(base_convert((10+$sizeCount), 10, 36)."7", "Total");
//
//   $sizeCountA = 4;
//   $totalQuantity = 0;
//   while ($row = mysqli_fetch_assoc($order_child_quantity_country)){
//
//        $objPHPExcel->setActiveSheetIndex(0)
//                   ->setCellValue(base_convert((10+$sizeCountA), 10, 36)."".$count, $row['quantity']);
//
//               $sizeCountA++;
//               $totalQuantity += $row['quantity'];
//      }
//
//      $objPHPExcel->setActiveSheetIndex(0)
//                  ->setCellValue(base_convert((10+$sizeCountA), 10, 36)."".$count, $totalQuantity);

}
// echo '<pre>';
// print_r($style_name);
// echo  '</pre>';

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

//$file_name = $order_details['style_name']."-".$order_details['po_number'];

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($style_name.".xlsx");

echo '<html><a href="'.$style_name.'.xlsx">download</a></html>';
?>
