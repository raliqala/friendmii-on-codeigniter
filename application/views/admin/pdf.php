<?php 
require "";
/**
 
 */
class myPDF extends FPDF
{
	
	function header(){
     $this->Image('dfff',10,6);
     $this->SetFont('Arial','8',14);
     $this->Cell(276,5,'USER DOCUMENTS',0,0,'C');
     $this->Ln();
     $this->SetFont('Times','',12);
     $this->Cell(276,10,'hjkl',0,0,'C');
     $this->Ln(20);
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable(){
		$this->SetFont('Times','8',12);
		$this->Cell(20,10,'ID',1,0,'C');
	}
	
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->Output();