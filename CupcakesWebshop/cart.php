<?php
include("ShoppingCart.inc.php");
include("CartItem.inc.php");
include 'functions.php';


if (isset($_GET["item"]) && isset($_GET["id"]))
	$_SESSION["cart"]->addItem($_GET["item"],$_GET["id"]);

if(isset($_SESSION['username'])){
	$tpl->assign('username', $_SESSION['username']);
}

if(isset($_GET['action'])){
	$action = $_GET['action']; //the action from the URL
	switch($action) {
		case "remove":
			$_SESSION["cart"]->removeItem($_GET["id"]);
			break;
		case "empty":
			unset($_SESSION['cart']); //unset the whole cart, i.e. empty the cart.
			break;
	}
}

//displays the menu(defined in functions.php)
menu();

$html = $tpl->draw( 'main', $return_string = true );
// and then draw the output
echo $html;
?>

