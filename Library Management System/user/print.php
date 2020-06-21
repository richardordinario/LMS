<?php
include("../connection.php");
if(isset($_POST["sub"])) {
$id = $_POST["id"];
$query = mysqli_query($connection,"SELECT * FROM student WHERE id = '$id' ");
while($row=mysqli_fetch_assoc($query)){
	$fname= $row["fname"];
	$mi= $row["mi"];
	$lname= $row["lname"];
	$gender =$row["gender"];
	$bdate= $row["bdate"];
	$library = $row["libraryid"];
	$glevel = $row["ylevel"];
	$add = $row["address"];
	$section = $row["section"];
	$l_id = $row["libraryid"];
	$s_id = $row["studentid"];
	$image = $row["img"];
	$name = $fname . " " . $mi . " " . $lname;
}
	
require("../fpdf181/fpdf.php");
class PDF extends FPDF
{
// Page header
	function Header()
	{
	    // Logo
	    $this->Image('../image/logo.png',10,6,30);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Move to the right
	    $this->Cell(30);
	    // Title
	    $this->Cell(0,10,'Arellano University',0,0,'');

	    // Line break
	    $this->SetFont('Arial','',10);
	    $this->Ln(6);
	    $this->Cell(30);

	    $this->Cell(1,10,'Doroteo Jose cor. Teodoro Alonzo Street Santa Cruz',0,0,'');

	    $this->SetFont('Arial','',10);
	    $this->Ln(5);
	    $this->Cell(30);

	    $this->Cell(1,10,'Manila Philippines',0,0,'');
	    // Line break
	    $this->Ln(10);
	}
	function ChapterTitle()
	{
	    // Arial 12
	    $this->SetFont('Arial','B',12);
	    $this->SetTextColor(0,128,0);
	    // Background color
	    //$this->SetFillColor(200,220,255);
	    // Title
	    $this->Cell(40);
	    $this->Cell(0,6,"LIBRARY CARD",0,1,'');
	    //$this->Cell(0,6,"{$library}",0,1,'');
	    // Line break
	    //$this->Ln(50);
	}

	// Page footer

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Ln(8);
$pdf->SetTextColor(0,0,0);
$pdf->ChapterTitle();
$pdf->Image("$image",10,40,30,30);
//---------
$pdf->cell(35);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,10,'Student Id:',0,0,'');
$pdf->Ln(0);
$pdf->cell(45);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(10);
$pdf->Cell(0,10,"{$s_id}",0,0,'');

//-------------------------
$pdf->Ln(6);
$pdf->cell(35);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,10,'Name',0,0,'');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(40);
$pdf->Cell(0,10,"{$name}",0,0,'');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(35);
$pdf->Cell(0,10,'Gender                             Birthdate',0,0,'');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(40);
$pdf->Cell(0,10,"{$gender}                            {$bdate}",0,0,'');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(35);
$pdf->Cell(0,10,'Grade Level                     Section',0,0,'');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(40);
$pdf->Cell(0,10,"{$glevel}                        {$section}",0,0,'');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(35);
$pdf->Cell(0,10,'Address',0,0,'');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(40);
$pdf->Cell(0,10,"{$add}",0,0,'');
//------------

$pdf->Ln(-12);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,10,'L.N. :',0,0,'');
$pdf->Ln(0);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->cell(10);
$pdf->Cell(0,10,"{$l_id}",0,0,'');

//-------------

$pdf->Output();
}
?>