 <?php class XmlTranslation {
var $xml;
function loadTranslationFile($file) {
if(is_file($file)) {
if($this->xml = simplexml_load_file($file)) {
return true;
}
} else {
echo "Die Datei konnte nicht geladen werden!";
break;
}
}
function getText($lang,$txt_id) {
if($this->xml != "") {
$path = "/lan/language[@id=\"$lang\"]/loctext[@id=\"$txt_id\"]";
$res = $this->xml->xpath($path);
return $res[0]->text;
} else {
echo "Bitte laden Sie zuerst eine Übersetzungsdatei!";
}
}
function loadText($lang,$txt_id) {
if($this->xml != "") {
$path = "/lan/language[@id=\"$lang\"]/loctext[@id=\"$txt_id\"]";
$res = $this->xml->xpath($path);
$translation = $res[0]->text;
} else {
echo "Bitte laden Sie zuerst eine Übersetzungsdatei!";
}
return $translation;
}
function loadLangArray($lang) {
if($this->xml != "") {
$translations = array();
$path = "/language[@id=\"$lang\"]";
$res = $this->xml->xpath($path);
} else {
echo "Bitte laden Sie zuerst eine Übersetzungsdatei!";
}
return $res;
}
}

?>
