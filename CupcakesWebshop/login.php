<?php 
session_start();
include("propel_init.php");
?>

<?php 

$username = $_POST["username"];
$password = md5($_POST["password"]);

$user = UserQuery::create()->findOneByUsername($username);
if($user!= null && $user->getPassword() == $password)
{
	$_SESSION["userid"] = $user->getUserId();
	$_SESSION["username"] = $user->getUsername();
	/* Redirect to a different page in the current directory that was requested */
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	if($_SERVER['PHP_SELF']=="CupcakesWebshop/main.php"){
		$extra = 'main.php';
	}
	else{
		$extra = 'checkout.php?action=checkout';
	}
	header("Location: http://$host$uri/$extra");
	exit;
}
else
{
	echo "Benutzername und/oder Passwort waren falsch. <a href=\"main.php\">zur&uuml;ck</a>";
}

?>
