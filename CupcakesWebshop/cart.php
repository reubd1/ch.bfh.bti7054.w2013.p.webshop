<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>My Shopping Cart</title>
</head>
<body>
<h1>Cart</h1>
<?php
include("ShoppingCart.inc.php");
include("Item.inc.php");
session_start();
if (!isset($_SESSION["cart"]))
$_SESSION["cart"] = new ShoppingCart;
if (isset($_GET["item"]) && isset($_GET["id"]))
$_SESSION["cart"]->addItem($_GET["item"],$_GET["id"]);

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
?>
<?php
if (isset($_SESSION["cart"])){
 $_SESSION["cart"]->display(); 
}
?>
<hr />
<p><a href="main.php">Go buy more delicious cupcakes</a></p>
</body>
</html>
