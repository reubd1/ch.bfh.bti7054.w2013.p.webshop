<html><body>
<?php
// Example 1
$names=array("Bob", "Alice", "John", "Herbert");
sort($names); echo "SORT: "; print_r($names); echo "<br>";
// Example 2
rsort($names); echo "RSORT: "; print_r($names); echo "<br>";
// Example 3
function length_test($s1, $s2) {
return strlen($s1) > strlen($s2);
}
usort($names, "length_test");
echo "USORT: "; print_r($names); echo "<br>";
// Example 4
$names = array("Bob"=>"Marley","Alice"=>"Wonderland",
"John"=>"McEnroe","Herbert"=>"Groenemeyer");
asort($names); echo "ASORT: "; print_r($names); echo "<br>";
// Example 5
ksort($names); echo "KSORT: "; print_r($names); echo "<br>";
?>
</body></html>
