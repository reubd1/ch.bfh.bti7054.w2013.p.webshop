
<?php
include("ShoppingCart.inc.php");
include("CartItem.inc.php");
include "functions.php";



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


require_once("vendor/twitteroauth/twitteroauth.php"); //Path to twitteroauth library

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

$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
$tpl->assign("tweets", $tweets);

menu();




if(isset($_POST['search']) && $_POST['search'] != '')
{
	$kws = $_POST['search'];

	// Build Query
	$items = ItemQuery::create()
	->where('Item.Name LIKE ?', '%'.$kws.'%')
	->find();

	// Check If We Have Results
	if (isset($items)) {
		$i = 0;
		if(count($items)>0){
			echo "<ul>";
			foreach ($items as $result) {
					

				$display_url = "main.php?catid=".$result->getCategoryId();
				echo"<div class=\"show\" align=\"left\">
				<span class=\"name\"><a href='$display_url'>".$result->getName()."</a></span>
						</div>";
					
			}
		}
		else
		{
			echo "<div class=\"show\" align=\"left\">
					<span class=\"name\">No result found !</span></div>";
		}
	}
}





$html = $tpl->draw( 'main', $return_string = true );

// and then draw the output
echo $html;





?>



