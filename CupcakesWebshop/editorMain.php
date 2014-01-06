<?php
include("ShoppingCart.inc.php");
include("CartItem.inc.php");
include 'functions.php';
session_start();
if (!isset($_SESSION["cart"]))
	$_SESSION["cart"] = new ShoppingCart;
else
	$tpl->assign("cart", $_SESSION["cart"]);


if (!empty($_GET["action"])){
	if($_GET["action"]=="addcustom"){
		$tpl->assign("addcustom", true);
	}
}
else{
	$tpl->assign("addcustom", false);
}

if($_POST)
{
	$name = $_POST['item'];
	$quantity = $_POST['quantity'];

	// Full Name
	if (eregi('^[A-Za-z0-9 ]{3,20}$',$name))
	{
		$valid_name=$name;
	}
	else
	{
		$error_name='Enter valid Name.';
		$tpl->assign("error_name", $error_name);
	}
	// Quantity
	if (eregi('^(100|[1-9][0-9]?)$',$quantity))
	{
		$valid_quantity=$quantity;
	}
	else
	{
		$error_quantity='Please only digits between 1-100';
		$tpl->assign("error_quantity", $error_quantity);
	}

	//check if name and quality entries are correct
	if((strlen($valid_name)>0)&&(strlen($valid_quantity)>0))
	{
		if (isset($_POST["item"]) && isset($_POST["cake"]) && isset($_POST["topping"]) && isset($_POST["deco"]) && isset($_POST['quantity'])){
			//if everything is set correct, put the custom cake to the cart. uniqid(custom) creates an unique id with prefix 'custom'
			$_SESSION["cart"]->addItem(new CartItem(uniqid(custom), $_POST["item"], $_POST["price"], $_POST["cake"], $_POST["topping"], $_POST["deco"]), $_POST['quantity']);
		}
		else{
			$error_general = "Please check all required radiobuttons";
			$tpl->assign("error_general", $error_general);
		}
	}
	else{
	}
}


$cakes = CakeQuery::create()->find();
$cake = new Cake();

$cakearr = array();
foreach($cakes as $cake){
	$cakearr[]= $cake;
}
$tpl->assign("cake", $cakearr);

$toppings = ToppingQuery::create()->find();
$topping = new Topping();

$toppingarr = array();
foreach($toppings as $topping){
	$toppingarr[]= $topping;
}
$tpl->assign("topping", $toppingarr);

$decorations = DecorationQuery::create()->find();
$decoration = new Decoration();

$decorationarr = array();
foreach($decorations as $decoration){
	$decorationarr[]= $decoration;
}
$tpl->assign("decoration", $decorationarr);

menu();

$html = $tpl->draw( 'main', $return_string = true );
// and then draw the output
echo $html;

?>



