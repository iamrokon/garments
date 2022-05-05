<?php require_once '../../DB/item/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/supplier/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/cut_number/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/shade/select.php'; ?>
<?php require_once '../../DB/section/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/update.php'; ?>


<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../excel/Classes/PHPExcel.php';






//$user_id = $_SESSION['id'];
$trinhouse_id = $_GET['id'];
$selectSize = new select_size();
$size_list =  $selectSize->select_all();

$selectItem = new select_item();
$item_list =  $selectItem->select_all();
 while ($item = mysqli_fetch_assoc($item_list))
 {
   $items[] = $item;
}

$selectLine = new select_line();
$line_list =  $selectLine->select_all();

$selectPO = new select_po();
$po_list =  $selectPO->select_all();

$selectStyle = new select_style();
$style_list =  $selectStyle->select_all();

$selectSupplier = new select_supplier();
$supplier_list =  $selectSupplier->select_all();

$selectBuyer = new select_buyer();
$buyer_list =  $selectBuyer->select_all();

$selectColor = new select_color();
$color_list =  $selectColor->select_all();

$selectShade = new select_shade();
$shade_list =  $selectShade->select_all();

$selectSection = new select_section();
$section_list =  $selectSection->select_all();

$selectCountry = new select_country();
$country_list =  $selectCountry->select_all();

$selectCuttingProduction = new select_cproduction();
$cut_pro_result = $selectCuttingProduction->select_with_id($trinhouse_id);
$cut_pro_details = mysqli_fetch_assoc($cut_pro_result);

$selectTrimsInhouse = new select_trims_inhouse();
$trinhouse_info_by_id = $selectTrimsInhouse->select_with_id($trinhouse_id);
$trinhouse_result = $selectTrimsInhouse->select_child_with_id($trinhouse_id);
$trinhouse_by_id = mysqli_fetch_assoc($trinhouse_info_by_id);

$cut_pro_child_list = $selectCuttingProduction->select_child_with_id($trinhouse_id);
$num_rows = mysqli_num_rows($cut_pro_child_list)/5;

$rows[] = null;

while($row = $cut_pro_child_list->fetch_row()) {
  $rows[] = $row;
}


while ($trinhouse_details_in = mysqli_fetch_assoc($trinhouse_result)){
  $trinhouse_details_info[] = $trinhouse_details_in;
}

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
	             ->setCellValue('G1', "Starling Denims Limited")
                ->setCellValue('G2', "DHANIA, NAYERHAT, ASHULIA, SAVAR, DHAKA")
							  ->setCellValue('G3', "Trims Inhouse Result");
							  // ->setCellValue('A4', "Style     :")
							  // ->setCellValue('B4', "rok")
							  // ->setCellValue('H4', "DATE:")
							  // ->setCellValue('I4', "17/7");
							 // ->setCellValue('H4', "Color : ".$order_details['color_name'])
							 // ->setCellValue('H5', "Color : ".$order_details['total_quantity']);
               // ->setCellValue('A2', $order_details['po_number'])
               // ->setCellValue('D2', $order_details['color_name'])
               //->setCellValue('G1', $order_details['total_quantity']);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getStyle('K6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('M6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('R6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('T6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('U6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('V6')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('W6')->getAlignment()->setWrapText(true);

  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A6', "SL NO")
            	->setCellValue('B6', "Challan No")
              ->setCellValue('C6', "Issue Date")
              ->setCellValue('D6', "Item Name")
              ->setCellValue('E6', "Line No.")
              ->setCellValue('F6', "Style Name")
              ->setCellValue('G6', "PO Number")
              ->setCellValue('H6', "PCD")
              ->setCellValue('I6', "TOD From")
              ->setCellValue('J6', "TOD To")
              ->setCellValue('K6', "Country Name")
              ->setCellValue('L6', "Supplier")
              ->setCellValue('M6', "Item Color")
              ->setCellValue('N6', "Size")
              ->setCellValue('O6', "Shade")
              ->setCellValue('P6', "Ref No.")
              ->setCellValue('Q6', "Unit Type")
              ->setCellValue('R6', "Cons")
              ->setCellValue('S6', "Actual Quantity")
              ->setCellValue('T6', "Required Quantity")
              ->setCellValue('U6', "Receive Quantity")
              ->setCellValue('V6', "Total Issue\rQuantity")
              ->setCellValue('W6', "Balance Quantity")
              ->setCellValue('X6', "Remarks");

$count = 7;


	$i = 1;
	foreach ($trinhouse_details_info as $trinhouse_details){

  $count++;

$item_name = "";
	foreach ($items as $row)
	{
			if($trinhouse_details['item_name'] == $row['id'])
			{
				$item_name = $row['name'];
			}
	}
	$line_number = "";
	while ($line = mysqli_fetch_assoc($line_list))
			{
				$lines[] = $line;
			}
				foreach ($lines as $row)
				{
				if($trinhouse_details['line_number'] == $row['id'])
				{
					$line_number = $row['name'];
			 }
 }
 $style_name = "";
 while ($style = mysqli_fetch_assoc($style_list))
 	{
 		$styles[] = $style;
 	}
 					foreach ($styles as $row)
 					{
 		if($trinhouse_details['style_name'] == $row['id'])
 		{
 			$style_name = $row['style_name'];
 		 }
 }
 $po_num = "";
 while ($po = mysqli_fetch_assoc($po_list))
		 {
					 $pos[] = $po;
				 }
								 foreach ($pos as $row)
								 {
			 if($trinhouse_details['po_number'] == $row['id'])
			 {
				 $po_num = $row['po_num'];
			}
}
$supplier = "";
while ($supplier = mysqli_fetch_assoc($supplier_list))
{
	$suppliers[] = $supplier;
}
foreach ($suppliers as $row)
{
		if($trinhouse_details['supplier'] == $row['id'])
		{
			$supplier = $row['name'];
	 }
}
$item_color = "";
while ($color = mysqli_fetch_assoc($color_list))
	{
		$colors[] = $color;
	}
	foreach ($colors as $row)
	{
		if($trinhouse_details['item_color'] == $row['id'])
		{
			$item_color = $row['name'];
		 }
}

  $objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A'.$count, $count-7)
            	->setCellValue('B'.$count, $trinhouse_details['challan'])
              ->setCellValue('C'.$count, $trinhouse_details['issue_date'])
              ->setCellValue('D'.$count, $item_name)
              ->setCellValue('E'.$count, $line_number)
              ->setCellValue('F'.$count, $style_name)
              ->setCellValue('G'.$count, $po_num)
              ->setCellValue('H'.$count, $supplier)
              ->setCellValue('I'.$count, $trinhouse_details['tod_from'])
              ->setCellValue('J'.$count, $trinhouse_details['tod_to'])
              ->setCellValue('K'.$count, $trinhouse_details['country'])
              ->setCellValue('L'.$count, $supplier)
              ->setCellValue('M'.$count, $item_color)
              ->setCellValue('N'.$count, $trinhouse_details['size'])
              ->setCellValue('O'.$count, $trinhouse_details['shade'])
              ->setCellValue('P'.$count, $trinhouse_details['ref_no'])
              ->setCellValue('Q'.$count, $trinhouse_details['unit_type'])
              ->setCellValue('R'.$count, $trinhouse_details['cons'])
              ->setCellValue('S'.$count, $trinhouse_details['actual_quantity'])
              ->setCellValue('T'.$count, $trinhouse_details['required_quantity'])
              ->setCellValue('U'.$count, $trinhouse_details['receive_quantity'])
              ->setCellValue('V'.$count, $trinhouse_details['total_issue_quantity'])
              ->setCellValue('W'.$count, $trinhouse_details['balance_quantity'])
              ->setCellValue('X'.$count, $trinhouse_details['remarks']);

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

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($item_name.".xlsx");

echo '<html><a href="'.$item_name.'.xlsx">download</a></html>';
?>
