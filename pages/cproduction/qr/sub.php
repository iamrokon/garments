<?php
require('fpdf17/fpdf.php');

$pdf = new FPDF('L','mm',array(65,35));

$pdf->AddPage();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(60,3,'Statement',0,1,'R');

$pdf->Output();
?>