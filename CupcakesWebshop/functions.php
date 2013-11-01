<?php
function get_param($name, $default) {
	if (isset($_GET[$name])) return urldecode($_GET[$name]);
	else return $default;
}
function add_param($url, $name, $value, $sep="&") {
	$new_url = $url.$sep.$name."=".urlencode($value);
	return $new_url;
}
function menu() {

global $navi;
$i=0;
$lan = get_param("lan", "de");
foreach($navi as $entry){ 
	$url = $_SERVER['PHP_SELF'];
$url = add_param($url, "id", $i, "?");
$url = add_param($url, "lan", $lan);
	if($i == get_param("id", 0)){
printf("<li><a href=\"$url\" class=\"active\">%s</a></li>", 
                $entry[$lan]); 
}
else{
    printf("<li><a href=\"$url\">%s</a></li>", 
                $entry[$lan]); 
}
$i++;
} 
}
function content() {
	global $navi;
	global $products_de;
	global $products_en;
	$lan = get_param("lan", "de");
	$id = get_param("id", "0");
	echo "<h1>".$navi[$lan]."</h1>";
$products = $products_de[$id];
if($lan == "en"){
$products = $products_en[$id];
}

foreach($products as $prod){
	printf("<li><img src=\"%s\"><h3>\"%s\"</h3><p>\"%s\"</p></li>", $prod["img"], $prod["name"], $prod["desc"]);
}
}
function language() {
	$url = $_SERVER['PHP_SELF'];
	$url = add_param($url, "id", get_param("id", 0), "?");
	echo "<a href=\"".add_param($url,"lan","de")."\">DE</a> ";
	echo "<a href=\"".add_param($url,"lan","en")."\">EN</a> ";
}
$text = array("de"=>"Seite", "en"=>"Page");
$navi = array( 
    "saison"  =>array("de"=>"Saisonal","en"=>"seasonal",), 
    "wedding" => array("de"=>"Hochzeit","en"=>"wedding",), 
    "birthday" => array("de"=>"Geburtstag","en"=>"birthday",), 
    "homecreations" => array("de"=>"Heimkreationen","en"=>"homecreations",), 
    "selfcreate" => array("de"=>"selber kreieren","en"=>"create your own",) 
);
$products_de = array( 
   "0"  =>array(
		"0"=>array("img"=>"images/saison1.bmp","name"=>"saison1", "desc"=>"beschreibung 1"), 
		"1"=>array("img"=>"images/saison2.bmp","name"=>"saison2", "desc"=>"beschreibung 1"), 
		"2"=>array("img"=>"images/saison3.bmp","name"=>"saison3", "desc"=>"beschreibung 1") 
	),
    "1" =>array(
		"0"=>array("img"=>"images/hochzeit1.bmp","name"=>"hochzeit1", "desc"=>"beschreibung 1"), 
		"1"=>array("img"=>"images/hochzeit2.bmp","name"=>"hochzeit2", "desc"=>"beschreibung 1"), 
		"2"=>array("img"=>"images/hochzeit3.bmp","name"=>"hochzeit3", "desc"=>"beschreibung 1") 
	),
    "2" =>array(
		"0"=>array("img"=>"images/geburi1.bmp","name"=>"geburtstag1", "desc"=>"beschreibung 1"), 
		"1"=>array("img"=>"images/geburi2.bmp","name"=>"geburtstag2", "desc"=>"beschreibung 1"), 
		"2"=>array("img"=>"images/geburi3.bmp","name"=>"geburtstag3", "desc"=>"beschreibung 1") 
	),
    "3" =>array(
		"0"=>array("img"=>"images/creation1.bmp","name"=>"hauskreation1", "desc"=>"beschreibung 1"), 
		"1"=>array("img"=>"images/creation2.bmp","name"=>"hauskreation2", "desc"=>"beschreibung 1"), 
		"2"=>array("img"=>"images/creation3.bmp","name"=>"hauskreation3", "desc"=>"beschreibung 1")
	)
);
$products_en = array( 
   "0"  =>array(
		"0"=>array("img"=>"images/saison1.bmp","name"=>"saison1", "desc"=>"description 1"), 
		"1"=>array("img"=>"images/saison2.bmp","name"=>"saison2", "desc"=>"description 1"), 
		"2"=>array("img"=>"images/saison3.bmp","name"=>"saison3", "desc"=>"description 1") 
	),
    "1" =>array(
		"0"=>array("img"=>"images/hochzeit1.bmp","name"=>"wedding1", "desc"=>"description 1"), 
		"1"=>array("img"=>"images/hochzeit2.bmp","name"=>"wedding2", "desc"=>"description 1"), 
		"2"=>array("img"=>"images/hochzeit3.bmp","name"=>"wedding3", "desc"=>"description 1") 
	),
    "2" =>array(
		"0"=>array("img"=>"images/geburi1.bmp","name"=>"birthday1", "desc"=>"description 1"), 
		"1"=>array("img"=>"images/geburi2.bmp","name"=>"birthday2", "desc"=>"description 1"), 
		"2"=>array("img"=>"images/geburi3.bmp","name"=>"birthday3", "desc"=>"description 1") 
	),
    "3" =>array(
		"0"=>array("img"=>"images/creation1.bmp","name"=>"birthday1", "desc"=>"description 1"), 
		"1"=>array("img"=>"images/creation2.bmp","name"=>"birthday2", "desc"=>"description 1"), 
		"2"=>array("img"=>"images/creation3.bmp","name"=>"birthday3", "desc"=>"description 1")
	)
);

?>
