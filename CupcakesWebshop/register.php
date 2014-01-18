<?php 
/**
 * check the registration entries and create new entry if entries are valid
 *
 * @version    1.0
 * @author     Original Author <reubd1@bfh.ch>
 */
include("propel_init.php");

$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];
$mail = $_POST["emailcheck"];

// validate Full Name
if (!eregi('^([a-zA-Z0-9_\-\.])+@(([0-2]?[0-5]?[0-5]\.[0-2]?[0-5]?[0-5]\.[0-2]?[0-5]?[0-5]\.[0-2]?[0-5]?[0-5])|((([a-zA-Z0-9\-])+\.)+([a-zA-Z\-])+))$',$mail))
{
	echo "Bitte geben Sie einen korrekten Benutzernamen an / please enter a valid username";
	exit;
}


//check if pw not empty
if($password != $password2 OR $username == "" OR $password == "")
{
	echo "Eingabefehler. Bitte alle Felder korekt ausf&uuml;llen / Input error, please check your input <a href=\"register.html\">Zurück / back</a>";
	exit;
}
$password = md5($password);





$result = UserQuery::create()->findOneByUsername($username);

if($result == null)
{
	//save the new user on database
	$user = new User();
	$user->setUsername($username);
	$user->setPassword($password);
	$user->setEmail($mail);
	$user->save();

	$result = UserQuery::create()->findOneByUsername($username);

	if($result != null)
	{
		echo "Benutzername <b>$username</b> wurde erstellt / User created <a href=\"login.html\">Login</a>";
	}
	else
	{
		echo "Fehler beim Speichern des Benutzernames / User could not be created <a href=\"register.html\">Zurück / Back</a>";
	}


}

else
{
	echo "Benutzername schon vorhanden / User already exists <a href=\"register.html\">Zurück / Back</a>";
}
?>
