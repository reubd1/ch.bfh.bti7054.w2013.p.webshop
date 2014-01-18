<?php
/**
 * This file is used for the checkout process and updates the quantity of items
 *
 * @version    1.0
 * @author     Original Author <reubd1@bfh.ch>
 */
include("ShoppingCart.inc.php");
include("CartItem.inc.php");
include 'functions.php';

$cart = $_SESSION["cart"];

$items = $cart->getItems();

foreach ($items as $arr){
	$item = $arr['item'];
	if(isset($_POST[$item->getId()])){
		$arr['qty'] = $_POST[$item->getId()];
	}
}
menu();
$html = $tpl->draw( 'main', $return_string = true );
// and then draw the output
echo $html;

?>
