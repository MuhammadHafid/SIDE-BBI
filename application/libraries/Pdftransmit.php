<?php

include_once APPPATH . '/third_party/fpdf/fpdf.php';

class Pdftransmit extends fpdf{

	function Header()
	{

	}

	function Footer()
	{
	//Position at 1.5 cm from bottom

		$this->SetY(-15);

	//Arial italic 8
		$this->SetFont('Arial','I',8);
	//Page number
		$this->Cell(0,10,'Halaman ke- '.$this->PageNo(),0,0,'R');
	}

}
?>