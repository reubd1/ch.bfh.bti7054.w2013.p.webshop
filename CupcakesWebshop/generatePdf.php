<?php
/**
 * This file contains functions to generate a PDF with the order details
 *
 * @version    1.0
 * @author     Original Author <reubd1@bfh.ch>
 */
include('pdf_template.php');

function generatePdf($name, $street, $zip, $city, $country, $cardtype, $items, $orderid,$total, $show){

	$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
	$pdf->AddPage();
	$pdf->addCompany( "Flying Cupcakes",
			"Addresse\n" .
			"1234 Ort\n".
			"Schweiz\n", "tpl/img/logo.gif");

	$timestamp = time();
	$datum = date("d.m.Y",$timestamp);

	$pdf->addDate($datum);
	$pdf->addOrder($orderid);
	$pdf->addClientAdresse($name."\n".$street."\n".$zip." ".$city."\n".$country);
	$pdf->addReglement("Invoice");
	$datum = date('d.m.Y', strtotime("+30 days"));
	$pdf->addExpiry($datum);
	$cols=array( "Name"    => 78,
			"Price/Piece"  => 23,
			"Quantity"     => 22,
			"Price"      => 26);
	$pdf->addCols( $cols);
	$cols=array( "Name"    => "L",
			"Price/Piece"  => "L",
			"Quantity"     => "C",
			"Price"      => "R");
	$pdf->addLineFormat($cols);

	$y    = 109;


	foreach ($items as $arr){
		$item = $arr['item'];
		$price = $item->getPrice()*$arr['qty'];

		$line = array( "Name"    => $item->getName(),
				"Price/Piece"  => $item->getPrice(),
				"Quantity"     => $arr['qty'],
				"Price"      => $price);
		$size = $pdf->addLine( $y, $line );
		$y   += $size + 2;
	}
	$y   += $size + 2;
	$line = array( "Name"    => "--------",
				"Price/Piece"  => "--------",
				"Quantity"     => "--------",
				"Price"      => "--------");
	$size = $pdf->addLine( $y, $line );
	$y   += $size + 2;
	$line = array( "Name"    => "Total",
				"Price/Piece"  => "",
				"Quantity"     => "",
				"Price"      => $total);
	$size = $pdf->addLine( $y, $line );
	ob_end_clean();
	return $pdf;
}
?>
