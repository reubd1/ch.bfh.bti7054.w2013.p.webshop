<?php

include("propel_init.php");
include 'XmlTranslation.php';
//include the RainTPL class
include "inc/rain.tpl.class.php";

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "tpl/" );
raintpl::configure("cache_dir", "tmp/" );

//initialize a Rain TPL object
$tpl = new RainTPL;

session_start();

//if no cart is in the session, create a new one
if (!isset($_SESSION["cart"]))
	$_SESSION["cart"] = new ShoppingCart;

//assign the cart in the session to the html template
$tpl->assign("cart", $_SESSION["cart"]);


//Get Language by cookie, default Language is EN
if ( !isset( $_POST['lang'] ) ) {
	if ( isset( $_COOKIE['lang'] ) ) {
		$lang = $_COOKIE['lang'];
	} else { $lang = 'EN';
	}
}
//if language is choosen, set language cookie
else {
	$lang = (string)$_POST['lang'];
	setcookie( 'lang', $lang, time() + 60*60*24*30 );
}
$tpl->assign("lang", $lang);


// Create new Instance of XmlTranslation to get XML language values
$language = new XmlTranslation();
//load xmlfile
$language->loadTranslationFile("lang.xml");
//get language tokens
$custom = $language->getText($lang,"MENU_CUSTOM");
$cartmenu = $language->getText($lang,"MENU_CART");
$search = $language->getText($lang,"SEARCH");
$cartprice = $language->getText($lang,"CART_PRICE");
$cartbutton = $language->getText($lang,"CART_BUTTON");


//assign language tokens to template
$tpl->assign("custom", $custom);
$tpl->assign("cartmenu", $cartmenu);
$tpl->assign("search", $search);
$tpl->assign("cartprice", $cartprice);
$tpl->assign("cartbutton", $cartbutton);


function get_param($name, $default) {
	if (isset($_GET[$name])) return urldecode($_GET[$name]);
	else return $default;
}

function add_param($url, $name, $value, $sep="&") {
	$new_url = $url.$sep.$name."=".urlencode($value);
	return $new_url;
}

//this function assigns an array of all categories to the template to display them as menu points
function menu(){
	
	global $tpl;

	//get all categories(DB Classes generated with Propel)
	$categories = CategoryQuery::create()->find();
	$category = new Category();

	$catarr = array();
	foreach($categories as $category){
		$url = "main.php";
		$url = add_param($url, "catid", $category->getCategoryId(), "?");
		$catarr[$url]= $category;

	}

	$tpl->assign("cat", $catarr);
}

//this function gets all items of a choosen category
function items() {
	$id = get_param("catid", "1");

	//get items by categoryId(DB Classes generated with Propel)
	$items = ItemQuery::create()->filterByCategoryId($id);
	$item = new Item();

	$itemarr = array();
	foreach($items as $item){
		$url = "main.php";
		$productId = $item->getItemId();

		$url = add_param($url, "id", $productId, "?");
		$url = add_param($url, "item", $item->getName());
		$url = add_param($url, "price", $item->getPrice());
		$url = add_param($url, "action", "add");

		$itemarr[$url]= $item;
	}
	return $itemarr;
}
?>
