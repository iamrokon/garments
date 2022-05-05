<?php
require('fpdf17/fpdf.php');
require('fpdf17/exfpdf.php');
require('fpdf17/easyTable.php');

//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

//html PNG location prefix
 $PNG_WEB_DIR = 'temp/';

 include "qrlib.php";

 //ofcourse we need rights to create temp dir
  if (!file_exists($PNG_TEMP_DIR))
  mkdir($PNG_TEMP_DIR);

     $filename = $PNG_TEMP_DIR.'test.png';

$pdf=new exFPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',2);

$errorCorrectionLevel = 'M';
$matrixPointSize = min(max((int)4, 1), 10);

$filename = $PNG_TEMP_DIR.'test'.md5($qrString.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
QRcode::png($qrString, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

$table=new easyTable($pdf, 3, 'width:100;');

 $table->easyCell('', 'img:../qr/temp/'.basename($filename).', w10, h10;rowspan:2; valign:T');
 $table->easyCell('Text 2', 'bgcolor:#b3ccff; rowspan:2');
 $table->easyCell('Text 3');
 $table->printRow();

 $table->rowStyle('min-height:20');
 $table->easyCell('Text 4', 'bgcolor:#3377ff; rowspan:2');
 $table->printRow();

 $table->easyCell('Text 5', 'bgcolor:#99bbff;colspan:2');
 $table->printRow();

 $table->endTable();

 $pdf->Output();
?>
