<?php
/**
 * This is the entry point of the webshop
 *
 * @version    1.0
 * @author     Original Author <reubd1@bfh.ch>
 */
include("ShoppingCart.inc.php");
include("CartItem.inc.php");
include "functions.php";
require_once("vendor/twitteroauth/twitteroauth.php"); //Path to twitteroauth library


if (isset($_GET["item"]) && isset($_GET["id"]) && isset($_POST['quantity']))
	$_SESSION["cart"]->addItem(new CartItem($_GET["id"], $_GET["item"], $_GET["price"], 0, 0, 0), $_POST['quantity']);

$tpl->assign("username", $_SESSION["username"]);

if (!empty($_GET["action"])){
	if($_GET["action"]=="add"){
		$tpl->assign("add", true);
	}
}
else{
	$tpl->assign("add", false);
}


$tpl->assign("items",items());

/*
 * the following lines are used for authentication with twitter API
 */
$twitteruser = "sprinkles";
$notweets = 5;
$consumerkey = "VagINpZQJrCVdDMmfZZWA";
$consumersecret = "lSQk81CbgnKJ2vexwlZ4ixvgN5VQ3FNaUpjfpOwnnb0";
$accesstoken = "2264901158-h5kZ7bSGugt7X6thuVKojLmcn0OehTqSeC8Oqjm";
$accesstokensecret = "WUVbhtcPKuanxHLU6NUaXZA3UM1Rd0kNJOCHNXodsmZKr";

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

//get tweets of requested twitter user by REST Webservice call
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
$tpl->assign("tweets", $tweets);

menu();




/*
 * get input value of ajax search, search string on database and display the results
 */
if ($_POST["suche"]){
		// Mysql Abfrage mit den Notwendigen Parameter
		$items = ItemQuery::create()
		->where('Item.Name LIKE ?', '%'.mysql_real_escape_string(utf8_decode($_POST["suche"])).'%')
		->find();

		if(count($items)>0){
			foreach ($items as $result) {
					

				$display_url = "main.php?catid=".utf8_encode($result->getCategoryId());
				echo"<div class=\"show\" align=\"left\">
				<span class=\"name\"><a href='$display_url'>".utf8_encode($result->getName())."</a></span>
						</div>";
					
			}
		}
		else
		{
			echo "<div class=\"show\" align=\"left\">
					<span class=\"name\">No result found !</span></div>";
		}
}






$html = $tpl->draw( 'main', $return_string = true );

// and then draw the output
echo $html;





?>



