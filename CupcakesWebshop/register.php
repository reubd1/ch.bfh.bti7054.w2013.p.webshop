<?php 
include("propel_init.php");

$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];
$mail = $_POST["emailcheck"];

// Full Name
if (!eregi('^([a-zA-Z0-9_\-\.])+@(([0-2]?[0-5]?[0-5]\.[0-2]?[0-5]?[0-5]\.[0-2]?[0-5]?[0-5]\.[0-2]?[0-5]?[0-5])|((([a-zA-Z0-9\-])+\.)+([a-zA-Z\-])+))$',$mail))
{
	echo "Bitte geben Sie eine korrekte Mailadresse an.";
	exit;
}



if($password != $password2 OR $username == "" OR $password == "")
{
	echo "Eingabefehler. Bitte alle Felder korekt ausf&uuml;llen. <a href=\"register.html\">Zurück</a>";
	exit;
}
$password = md5($password);





$result = UserQuery::create()->findOneByUsername($username);

if($result == null)
{
	$user = new User();
	$user->setUsername($username);
	$user->setPassword($password);
	$user->setEmail($mail);
	$user->save();

	$result = UserQuery::create()->findOneByUsername($username);

	if($result != null)
	{
		echo "Benutzername <b>$username</b> wurde erstellt. <a href=\"login.html\">Login</a>";
	}
	else
	{
		echo "Fehler beim Speichern des Benutzernames. <a href=\"register.html\">Zurück</a>";
	}


}

else
{
	echo "Benutzername schon vorhanden. <a href=\"register.html\">Zurück</a>";
}
?>
