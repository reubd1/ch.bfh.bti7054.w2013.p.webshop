<?php
//Start the session
session_start();
?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title></title>
  <style>
    .black_overlay{
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
    .white_content {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: 50%;
        padding: 16px;
        border: 16px solid orange;
        background-color: white;
        z-index:1002;
        overflow: auto;
    }
</style>
</head>
<body>
<?php
include("ShoppingCart.inc.php");
include("Item.inc.php");
session_start();
if (!isset($_SESSION["cart"]))
$_SESSION["cart"] = new ShoppingCart;

if (isset($_GET["item"]) && isset($_GET["id"]) && isset($_POST['quantity']))
$_SESSION["cart"]->addItem(new Item($_GET["id"], $_GET["item"], $_GET["price"]), $_POST['quantity']);

?>
</body>
</html>
