<?php
require('fpdf.php');
include("../config/db.php");

$kikoba_id = $_GET['kikoba'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'KIKOBA MONTHLY REPORT',0,1,'C');

$data = $conn->query("
 SELECT u.full_name, c.amount, c.month, c.year
 FROM contributions c
 JOIN members m ON c.member_id=m.id
 JOIN users u ON m.user_id=u.id
 WHERE c.kikoba_id=$kikoba_id
");

$pdf->SetFont('Arial','',10);
while($row=$data->fetch_assoc()){
    $pdf->Cell(0,8,
      $row['full_name']." - ".$row['amount']." (".$row['month']."/".$row['year'].")",
      0,1
    );
}

$pdf->Output();