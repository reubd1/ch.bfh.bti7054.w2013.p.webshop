<?php
class ShoppingCart {
private $items = array();

public function isEmpty() {
    return (empty($this->items));
}

public function addItem($item, $qty) {
// Need the item id:
    $id = $item->getId();
    // Add or update:
    if (isset($this->items[$id])) {
        $this->updateItem($item, $this->items[$id]['qty'] + $qty);
    } else {
        $this->items[$id] = array('item' => $item, 'qty' => $qty);
    }
}

public function updateItem(Item $item, $qty) {
    // Need the unique item id:
    $id = $item->getId();
    // Delete or update accordingly:
    if ($qty === 0) {
        $this->removeItem($item);
    } elseif ( ($qty > 0) && ($qty != $this->items[$id]['qty'])) {
        $this->items[$id]['qty'] = $qty;
    }
}

public function removeItem($id) {
    if (isset($this->items[$id])) {
            unset($this->items[$id]);
    }
}

public function getTotalPrice(){
$totalPrice = 0;
foreach ($this->items as $arr){
	$item = $arr['item'];
	$totalPrice += $item->getPrice()*$arr['qty'];
}

return $totalPrice;
}

public function display() {
//check if cart exists and there are entries
if ($this->isEmpty()) {
	echo '<p>Your cart is empty.</p>';
} else {

	echo "<table border=\"1\">";
	echo "<tr><th>Item</th><th>Unit price</th><th>No. of units</th><th>Subtotal</th><th>delete</th></tr>";
	$total = 0;

	foreach ($this->items as $arr){
	$item = $arr['item'];
	$price = $item->getPrice()*$arr['qty'];
	echo "<tr><td>".$item->getName()."</td><td>".$item->getPrice()."</td><td>".$arr['qty']."</td><td>".$price."</td><td><a href=$_SERVER[PHP_SELF]?action=remove&id=".$item->getId().">X</a></td></tr>";
}
echo "</table>";

 //show the empty cart link - which links to this page, but with an action of empty. A simple bit of javascript in the onlick event of the link asks the user for confirmation
  echo "<table>";  
echo "<p><strong> Total Preis:"; 
echo $this->getTotalPrice();
echo "</strong></p>";  
echo "<tr>";
    echo "<td colspan=\"3\" align=\"right\"><a href=\"$_SERVER[PHP_SELF]?action=empty\" onclick=\"return confirm('Are you sure?');\">Empty Cart</a></td>";
    echo "</tr>"; 
    echo "</table>";

}
}
}
?>
