<?php
$pdf = new Pdf('P',PDF_UNIT,PDF_PAGE_FORMAT, 'UTF-8', false);


$pdf = new PDF();
$pdf->AddPage();

for($i=1;$i<=300;$i++)
    $pdf->Cell(0,5,"Line $i",0,1);
$pdf->Output();