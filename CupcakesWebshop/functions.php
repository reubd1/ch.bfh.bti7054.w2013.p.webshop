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
	$url = $entry[$url];
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

	$url = "editorMain.php";
$url = add_param($url, "id", $i, "?");
$url = add_param($url, "lan", $lan);
$editor = array("de"=>"selber kreieren","en"=>"create your own"); 
printf("<li><a href=\"$url\">%s</a></li>", 
                $editor[$lan]); 
}
function tabmenu() {

global $tabnavi;
$i=5;
$lan = get_param("lan", "de");
foreach($tabnavi as $entry){ 
	$url = "editorMain.php";
$url = add_param($url, "id", $i, "?");
$url = add_param($url, "lan", $lan);
	if($i == get_param("id", 0)){
printf("<li class='active'><a href=\"$url\"><span>%s</span></a></li>", 
                $entry[$lan]); 
}
else{
    printf("<li><a href=\"$url\"><span>%s</span></a></li>", 
                $entry[$lan]); 
}
$i++;
}
}

function products() {
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
$url = "main.php";
$productId = $prod["id"];
$url = add_param($url, "id", $productId, "?");
$url = add_param($url, "lan", $lan);
$url = add_param($url, "item", $prod["name"]);
$url = add_param($url, "price", $prod["price"]);
	printf("<li><img src=\"%s\"><h3>\"%s\"</h3><p>\"%s\"</p></li>", $prod["img"], $prod["name"], $prod["desc"]);
	printf("<ul><li><form action=$url method=\"post\">
	<br><table><tr><td><input type=\"text\" name=\"quantity\" size=\"5\" value=\"1\" /></td>
	<td><input type=\"submit\" value=\"Add to Cart\" /></td></tr>
	</table>
	</form></li></ul>");
if (!empty($_POST)){
printf("<script type=\"text/javascript\">document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'</script>
    <div id=\"light\" class=\"white_content\">The product has been sucessfully added to your cart<br><a href = \"cart.php\" onclick = \"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'\">go to cart</a><br><br>
<a href = \"main.php\" onclick = \"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'\">go back to Products</a></div>
    <div id=\"fade\" class=\"black_overlay\"></div>");
}
}
}
function language() {
	$url = $_SERVER['PHP_SELF'];
	$url = add_param($url, "id", get_param("id", 0), "?");
	echo "<a href=\"".add_param($url,"lan","de")."\">DE</a> ";
	echo "<a href=\"".add_param($url,"lan","en")."\">EN</a> ";
}

function nextPage(){
	$url = $_SERVER['PHP_SELF'];
	$url = add_param($url, "id", get_param("id", 4)+1, "?");
	echo $url;

}
$text = array("de"=>"Seite", "en"=>"Page");
$navi = array(
    "saison"  =>array("de"=>"Saisonal","en"=>"seasonal"), 
    "wedding" => array("de"=>"Hochzeit","en"=>"wedding"), 
    "birthday" => array("de"=>"Geburtstag","en"=>"birthday"), 
    "homecreations" => array("de"=>"Heimkreationen","en"=>"homecreations")
);
$tabnavi = array(
    "cake"  =>array("de"=>"Cake","en"=>"cake", "url"=>"editorMain.php"), 
    "frosting" => array("de"=>"Frosting","en"=>"frosting", "url"=>"editorFrosting.php"), 
    "deco" => array("de"=>"Deko","en"=>"decoration",  "url"=>"editorDeko.php"), 
    "overview" => array("de"=>"&Uuml;bersicht","en"=>"overview",  "url"=>"editorOverview.php")
);
$products_de = array(
   "0"  =>array(
		"0"=>array("id"=>"0", "img"=>"images/saison1.bmp","name"=>"saison1", "desc"=>"beschreibung 1","price"=>5), 
		"1"=>array("id"=>"1", "img"=>"images/saison2.bmp","name"=>"saison2", "desc"=>"beschreibung 1","price"=>5), 
		"2"=>array("id"=>"2", "img"=>"images/saison3.bmp","name"=>"saison3", "desc"=>"beschreibung 1","price"=>5) 
	),
    "1" =>array(
		"0"=>array("id"=>"10", "img"=>"images/hochzeit1.bmp","name"=>"hochzeit1", "desc"=>"beschreibung 1","price"=>5), 
		"1"=>array("id"=>"11", "img"=>"images/hochzeit2.bmp","name"=>"hochzeit2", "desc"=>"beschreibung 1","price"=>5), 
		"2"=>array("id"=>"12", "img"=>"images/hochzeit3.bmp","name"=>"hochzeit3", "desc"=>"beschreibung 1","price"=>5) 
	),
    "2" =>array(
		"0"=>array("id"=>"20", "img"=>"images/geburi1.bmp","name"=>"geburtstag1", "desc"=>"beschreibung 1","price"=>5), 
		"1"=>array("id"=>"21", "img"=>"images/geburi2.bmp","name"=>"geburtstag2", "desc"=>"beschreibung 1","price"=>5), 
		"2"=>array("id"=>"22", "img"=>"images/geburi3.bmp","name"=>"geburtstag3", "desc"=>"beschreibung 1","price"=>5) 
	),
    "3" =>array(
		"0"=>array("id"=>"30","img"=>"images/creation1.bmp","name"=>"hauskreation1", "desc"=>"beschreibung 1","price"=>5), 
		"1"=>array("id"=>"31","img"=>"images/creation2.bmp","name"=>"hauskreation2", "desc"=>"beschreibung 1","price"=>5), 
		"2"=>array("id"=>"32","img"=>"images/creation3.bmp","name"=>"hauskreation3", "desc"=>"beschreibung 1","price"=>5)
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
