<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/excel/Classes/PHPExcel.php';

require_once '../../DB/cproduction/select.php';

require_once '../../DB/size/select.php';

$selectSize = new select_size();
$size_list =  $selectSize->select_all();

while ($row = mysqli_fetch_assoc($size_list)){
  $all_size[] = $row;
}

$cut_pro_id = $_GET['id'];

$selectCuttingProduction = new select_cproduction();
$cut_pro_result = $selectCuttingProduction->select_with_id($cut_pro_id);
$cut_pro_details = mysqli_fetch_assoc($cut_pro_result);

$cuttingProductionProcessList = $selectCuttingProduction->select_bundle_process_with_production_id($cut_pro_id);

$cut_pro_child_list = $selectCuttingProduction->select_child_with_id($cut_pro_id);
$num_rows = mysqli_num_rows($cut_pro_child_list)/$cut_pro_details['bundle_no'];

$rows[] = null;
// for($i=0;$i<=20;$i++){
//   for($j=0;$j<=21;$j++){
//     $rows[$i][$j] = 0;
//   }
// }
$x = 0;
while($row = $cut_pro_child_list->fetch_row()) {
  $rows[] = $row;
  $x++;
}
// echo '<pre>';
// print_r($rows);
// echo '</pre>';
$tktStart = 0;
$date = date("d-M-Y");
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
	             ->setCellValue('A1', "Date")
	             ->setCellValue('A3', "Buyer")
	             ->setCellValue('A4', "PO")

	             ->setCellValue('A5', "Cut No.")
				 // ->setCellValue('B8', "Cut No.")
				 // ->setCellValue('I8', "Cut No.")

	             ->setCellValue('B1', $date)
	             ->setCellValue('B3', $cut_pro_details['buyer_name'])

	             ->setCellValue('B4', $cut_pro_details['po_number'])
				 // ->setCellValue('D8', $cut_pro_details['po_number'])
				 // ->setCellValue('K8', $cut_pro_details['po_number'])

	             ->setCellValue('B5', $cut_pro_details['cut_number'])
				 // ->setCellValue('C8', $cut_pro_details['cut_number'])
				 // ->setCellValue('J8', $cut_pro_details['cut_number'])

	 					   ->setCellValue('D3', "Style Name")
	             ->setCellValue('D4', "Total Pcs")
	             ->setCellValue('D5', "Lay")

               ->setCellValue('E1', "Cutting Bundling Sheet")
               ->setCellValue('F2', "Sterling Denims Ltd")

	 					   ->setCellValue('F3', $cut_pro_details['style_name'])
						   // ->setCellValue('E8', $cut_pro_details['style_name'])
						   // ->setCellValue('L8', $cut_pro_details['style_name'])

	             ->setCellValue('F4', $cut_pro_details['total_pcs'])
	             ->setCellValue('F5', $cut_pro_details['lay'])

	 		         ->setCellValue('I3', "Section")

	             ->setCellValue('I4', "Color")

               ->setCellValue('I5', "Pattern")

	 						 ->setCellValue('J3', $cut_pro_details['section_name'])

	             ->setCellValue('J4', $cut_pro_details['color_name'])
				 // ->setCellValue('F8', $cut_pro_details['color_name'])
				 // ->setCellValue('M8', $cut_pro_details['color_name'])

               ->setCellValue('J5', $cut_pro_details['onepattern']);


      //$objPHPExcel->getActiveSheet()->getStyle("F1:G1")->getFont()->setSize(18);

      $serial = 1;
      $bundleNo=0;
for($i = 1; $i<=$cut_pro_details['total_pcs']; $i++)
	{
  		$bundleNo = (($i-1)*$cut_pro_details['bundle_no']) + 1;

    $sizeLabel = "";
    $inseam = "";
    foreach ($all_size as $row)
    {
      if($bundleNo<=$x){
        if($rows[$bundleNo][19] == $row['id']){
          if($row['inseam']){
            if($rows[$bundleNo][20] != '0'){
              $sizeLabel = $row['size_num']."-".$rows[$bundleNo][20];
              if(!$inseam){
                $inseam = $row['inseam'];
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K4', "In:".$inseam);
              }
            } else {
              $sizeLabel = $row['size_num'];
              if(!$inseam){
                $inseam = $row['inseam'];
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K4', "In:".$inseam);
              }
            }
            // $sizeLabel = $row['size_num']."/".$row['inseam'];
          }else {
            if($rows[$bundleNo][20] != '0'){
              $sizeLabel = $row['size_num']."-".$rows[$bundleNo][20];
            } else {
              $sizeLabel = $row['size_num'];
            }
            //$sizeLabel = $row['size_num'];
          }
        }
      }
    }
    // $label = "";
    // if($rows[$bundleNo][20] != '0')
    // {
    //   $label = $rows[$bundleNo][20];
    // }
    if($i%2 == 0){
    // Add some data
    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('H'.$tktStart, "Tkt ".$i)
        ->setCellValue('H'.($tktStart+1), "No.")

        ->setCellValue('I'.($tktStart-1), "Cut No.")
        ->setCellValue('I'.$tktStart, "Size")
        ->setCellValue('I'.($tktStart+1), "From")

        ->setCellValue('J'.($tktStart-1), $cut_pro_details['cut_number'])
        ->setCellValue('J'.$tktStart, $sizeLabel)
        ->setCellValue('J'.($tktStart+1), "To")

        ->setCellValue('K'.($tktStart-1), $cut_pro_details['po_number'])
        ->setCellValue('K'.$tktStart, "")
        ->setCellValue('K'.($tktStart+1), "Qty.")

        ->setCellValue('L'.($tktStart-1), $cut_pro_details['style_name'])
        ->setCellValue('L'.$tktStart, "")
        ->setCellValue('L'.($tktStart+1), "Shade")

        ->setCellValue('M'.($tktStart-1), $cut_pro_details['color_name'])
        ->setCellValue('M'.$tktStart, "")
        ->setCellValue('M'.($tktStart+1), "Country");

    $objPHPExcel->getActiveSheet()->getStyle("H".$tktStart.":J".$tktStart)->getFont()->setSize(12)->setBold( true );
    $objPHPExcel->getActiveSheet()->getStyle("H".($tktStart-1).":M".($tktStart-1))->getFont()->setSize(12)->setBold( true );
    // $objPHPExcel->getActiveSheet()->getStyle("I".$tktStart)->getFont()->setSize(12)->setBold( true );
    // $objPHPExcel->getActiveSheet()->getStyle("J".$tktStart)->getFont()->setSize(12)->setBold( true );

     for($k = 1; $k<=$cut_pro_details['bundle_no']; $k++)
     {
       if($bundleNo<=$x){
         if($rows[$bundleNo+($k-1)][6]){
           $objPHPExcel->setActiveSheetIndex(0)
  						->setCellValue('H'.($tktStart+1+$k), $serial)

  						->setCellValue('I'.($tktStart+1+$k), $rows[$bundleNo+($k-1)][4])

  						->setCellValue('J'.($tktStart+1+$k), $rows[$bundleNo+($k-1)][5])
  						->setCellValue('K'.($tktStart+1+$k), $rows[$bundleNo+($k-1)][6])

  						->setCellValue('L'.($tktStart+1+$k), $rows[$bundleNo+($k-1)][18])

  						->setCellValue('M'.($tktStart+1+$k), $rows[$bundleNo+($k-1)][17]);
              $serial++;
            }
        }
      }

	 } else {

        if($tktStart == 0) $tktStart = 9;
        else {
          $tktStart += ($cut_pro_details['bundle_no']+4);
        }

				$objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$tktStart, "Tkt ".$i)
              ->setCellValue('A'.($tktStart+1), "No.")

              ->setCellValue('B'.($tktStart-1), "Cut No.")
              ->setCellValue('B'.$tktStart, "Size")
              ->setCellValue('B'.($tktStart+1), "From")

              ->setCellValue('C'.($tktStart-1), $cut_pro_details['cut_number'])
              ->setCellValue('C'.$tktStart, $sizeLabel)
              ->setCellValue('C'.($tktStart+1), "To")

              ->setCellValue('D'.($tktStart-1), $cut_pro_details['po_number'])
              ->setCellValue('D'.$tktStart, "")
              ->setCellValue('D'.($tktStart+1), "Qty.")

              ->setCellValue('E'.($tktStart-1), $cut_pro_details['style_name'])
              ->setCellValue('E'.$tktStart, "")
              ->setCellValue('E'.($tktStart+1), "Shade")

              ->setCellValue('F'.($tktStart-1), $cut_pro_details['color_name'])
              ->setCellValue('F'.$tktStart, "")
              ->setCellValue('F'.($tktStart+1), "Country");

          $objPHPExcel->getActiveSheet()->getStyle("A".$tktStart.":C".$tktStart)->getFont()->setSize(12)->setBold( true );
          $objPHPExcel->getActiveSheet()->getStyle("A".($tktStart-1).":F".($tktStart-1))->getFont()->setSize(12)->setBold( true );

		for($k = 1; $k<=$cut_pro_details['bundle_no']; $k++)
		{
      if($rows[$bundleNo+($k-1)][6]){

		    $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.(($tktStart+1)+$k), $serial)

								->setCellValue('B'.(($tktStart+1)+$k), $rows[$bundleNo+($k-1)][4])

								->setCellValue('C'.(($tktStart+1)+$k), $rows[$bundleNo+($k-1)][5])
								->setCellValue('D'.(($tktStart+1)+$k), $rows[$bundleNo+($k-1)][6])

								->setCellValue('E'.(($tktStart+1)+$k), $rows[$bundleNo+($k-1)][18])

								->setCellValue('F'.(($tktStart+1)+$k), $rows[$bundleNo+($k-1)][17]);

                $serial++;
	          	}
            }
					}
		}

 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);

 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);

 $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
 $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);


$objPHPExcel->getActiveSheet()->getStyle("E1:F1")->getFont()->setSize(18);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

$objPHPExcel->getActiveSheet()->getStyle('A:M')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF');

// $objPHPExcel->getActiveSheet()->getStyle('O:P')->getFill()
//             ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
//             ->getStartColor()->setARGB('FFFFFF');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('N1', "Parts No")
            ->setCellValue('O1', "Name");

            $countProcess = 1;

while($row = mysqli_fetch_assoc($cuttingProductionProcessList)){
      $countProcess++;

      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('N'.$countProcess, $countProcess-1)
                  ->setCellValue('O'.$countProcess, $row['process_name']);
}



    $objPHPExcel->getActiveSheet()->getStyle('A1:N5')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFFFF');

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

$file_name = "Bundle_Ticket_Sheet-".$cut_pro_details['style_name']
            ."-".$cut_pro_details['po_number']
            ."-cut-".$cut_pro_details['cut_number'];

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($file_name.".xlsx");

echo '<html><a href="'.$file_name.'.xlsx">download</a></html>';
?>
