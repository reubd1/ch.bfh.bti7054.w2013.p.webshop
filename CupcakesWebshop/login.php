<?php 
/**
 * Checks login credentials with db entry of the requested user and save to session
 *
 * @version    1.0
 * @author     Original Author <reubd1@bfh.ch>
 */
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
	echo "Benutzername und/oder Passwort waren falsch / Username or Password wrong <a href=\"main.php\">zur&uuml;ck/back</a>";
}

?>
