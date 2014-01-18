<?php 
/**
 * This file checks the checkoutform with regex and saves all order details and adrress in the database.
 * additionally the function generatePDF will be called to create a PDF if the user clicks on the Link
 *
 * @version    1.0
 * @author     Original Author <reubd1@bfh.ch>
 */
include("ShoppingCart.inc.php");
include("CartItem.inc.php");
include 'functions.php';
include('generatePdf.php');

function died($error) {
	// error if validation is wrong
	echo "We are very sorry, but there were error(s) found with the form you submitted. ";
	echo "These errors appear below.<br /><br />";
	echo $error."<br /><br />";
	echo "Please go back and fix these errors.<br /><br />";
	die();
}

if(isset($_POST)){
	foreach ($_POST as $key => $val) {
		if($val != "Submit")
			$_SESSION["$key"] = $val;
	}
}

// validation expected data exists
if(!isset($_SESSION['name']) ||
!isset($_SESSION['street']) ||
!isset($_SESSION['zip']) ||
!isset($_SESSION['city']) ||
!isset($_SESSION['country'])||
!isset($_SESSION['cardid']) ||
!isset($_SESSION['cardtype']) ||
!isset($_SESSION['cardnumber']) ||
!isset($_SESSION['expirydate'])) {
	died('We are sorry, but there appears to be a problem with the form you submitted.');
}

$name = $_SESSION['name']; // required
$street = $_SESSION['street']; // required
$zip = $_SESSION['zip']; // required
$city = $_SESSION['city']; //  required
$country = $_SESSION['country']; // required
$cardid = $_SESSION['cardid']; // required
$cardtype = $_SESSION['cardtype']; // required
$cardnumber = $_SESSION['cardnumber']; //  required
$expirydate = $_SESSION	['expirydate']; // required

$error_message = "";

$string_exp = "/^[A-Za-z .'-]+$/";
if(!preg_match($string_exp,$name)) {
	$error_message .= 'The Name you entered does not appear to be valid.<br />';
}
if(!preg_match($string_exp,$city)) {
	$error_message .= 'The City you entered does not appear to be valid.<br />';
}
if(!preg_match($string_exp,$country)) {
	$error_message .= 'The Country you entered does not appear to be valid.<br />';
}
if(strlen($zip) < 4) {
	$error_message .= 'The ZIP you entered do not appear to be valid.<br />';
}
if(strlen($error_message) > 0) {
	died($error_message);
}

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}


$userid = $_SESSION["userid"];
$cart = $_SESSION["cart"];
$items = $cart->getItems();
$total = $cart->getTotalPrice();

if (isset($_GET['run'])) $linkchoice=$_GET['run'];
else $linkchoice='';

$show = false;

//check if the user choosed save or pdf to view the pdf
switch($linkchoice){

	case 'save' :
		save();
		break;

	case 'pdf' :
		$pdf = generatePdf($name, $street, $zip, $city, $country, $cardtype, $items, $oid, $total, $show );
		$pdf->Output($filename, "I");
		break;

	default :
		echo 'no run';

}

/*
 * save the orderdetails like shippingaddress, billing, order and custom or normal items
 * and save them with the call of save();
 */
function save(){
	global $userid;
	global $cart;
	global $items;

	$sa = new ShippingAddress();
	$sa->setName($name);
	$sa->setStreet($street);
	$sa->setZip($zip);
	$sa->setCity($city);
	$sa->setCountry($country);
	$sa->setUserId($userid);
	$sa->save();
	$shippingid = $sa->getShippingId();

	$bill = new Billing();
	$bill->setUserId($userid);
	$bill->setCardId($cardid);
	$bill->setCardType($cardtype);
	$bill->setCardNumber($cardnumber);
	$bill->setExpireDate($expirydate);
	$bill->save();
	$billid = $bill->getBillingId();

	$total =  $cart->getTotalPrice();
	$order = new Orders();
	$order->setTotal($total);
	$order->setUserId($userid);
	$order->setShippingId($shippingid);
	$order->setBillingId($billid);
	$date = new DateTime();
	$order->setOrderDate($date->getTimestamp());
	$order->save();
	$oid = $order->getOrderId();

	foreach ($items as $arr){
		$oi = new OrderItems();
		$ci = new CustomItem();
		$item = $arr['item'];
		if($item->getCake() != null){
			$ci->setName($item->getName());
			$ci->setOrderId($oid);
			$ci->setCakeId($item->getCake());
			$ci->setToppingId($item->getTopping());
			$ci->setDecoId($item->getDeco());
			$ci->save();
		}
		else{
			$oi->setOrderId($oid);
			$oi->setItemId($item->getId());
			$oi->setAmount($arr['qty']);
			$oi->save();
		}
	}
	/*
	 $pdf = generatePdf($name, $street, $zip, $city, $country, $cardtype, $items, $oid, $show );
	$filename = "Rechnung.pdf";
	$doc = $pdf->Output($filename, "S");


	$email_message .= "Name: ".clean_string($name)."\n";
	$email_message .= "Street: ".clean_string($street)."\n";
	$email_message .= "ZIP: ".clean_string($zip)."\n";
	$email_message .= "City: ".clean_string($city)."\n";
	$email_message .= "Country: ".clean_string($country)."\n";



	$from = "dominik@example.com";
	$email_to = "dominik@example.com";
	$email_subject = "Cupcake Order from the flying cupcakes";


	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;

	$attachment = chunk_split(base64_encode($doc));

	// main header
	$headers  = "From: ".$from.$eol;
	$headers .= "MIME-Version: 1.0".$eol;
	$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

	// no more headers after this, we start the body! //

	$body = "--".$separator.$eol;
	$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
	$body .= "This is a MIME encoded message.".$eol;

	// message
	$body .= "--".$separator.$eol;
	$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
	$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$body .= $email_message.$eol;

	// attachment
	$body .= "--".$separator.$eol;
	$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
	$body .= "Content-Transfer-Encoding: base64".$eol;
	$body .= "Content-Disposition: attachment".$eol.$eol;
	$body .= $attachment.$eol;
	$body .= "--".$separator."--";

	// send message
	mail($email_to, $email_subject, $body, $headers);

	//@mail($email_to, $email_subject, $email_message, $headers);


	*/
}



?>

<p>
	Thank you for your order.<br> An email with details of the order has
	been sent to you.<br> Click <a href="?run=pdf">here</a> if you want to
	see a PDF of your Order.<br> <br> Click <a href="main.php">here</a> to
	return to the Webshop.
</p>

