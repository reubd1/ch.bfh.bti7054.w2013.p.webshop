<?php
class ShoppingCart {
	private $items = array();

	public function isEmpty() {
		return (empty($this->items));
	}

	public function countItems() {
		if(!$this->isEmpty())
			return count($this->items);
		else
			return 0;
	}

	public function getItems(){
		if(!$this->isEmpty())
			return $this->items;
		else
			return 0;
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

	public function updateItem(CartItem $item, $qty) {
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

			if(!isset($_SESSION["userid"])){
				echo"<form action=\"login.html\" method=\"post\">";
				
			}
			else{
				echo"<form action=\"checkout.php?action=checkout\" method=\"post\">";
			}

			echo"<div style=\"margin:0px auto; width:700px;\" >
					<table border=\"0\" cellpadding=\"5px\" cellspacing=\"1px\" style=\"font-family:Verdana, Geneva, sans-serif; font-size:11px; background-color:#E1E1E1\" width=\"100%\">
					<tr bgcolor=\"#FFFFFF\" style=\"font-weight:bold\"><td>Name</td><td>Price</td><td>Quantity</td><td>Total</td><td>Delete</td></tr>";

			$total = 0;
			foreach ($this->items as $arr){
				$item = $arr['item'];
				$price = $item->getPrice()*$arr['qty'];

				echo"<tr bgcolor=\"#FFFFFF\"><td>".$item->getName()."</td><td>".$item->getPrice()."</td><td><input type=\"text\" name=".$item->getId()." value=".$arr['qty']." maxlength=\"3\" size=\"2\"/></td><td>".$price."</td><td><a href=$_SERVER[PHP_SELF]?action=remove&id=".$item->getId().">x</a></td></tr>";
			}

			echo"<tr><td><b>Order Total: ".$this->getTotalPrice()."</b></td><td colspan=\"5\" align=\"right\"><a href=\"$_SERVER[PHP_SELF]?action=empty\" onclick=\"return confirm('Are you sure?');\">Clear Cart</a>&nbsp;&nbsp;&nbsp;";

			if(!isset($_SESSION["userid"])){
			echo "<a href=\"#login-box\" class=\"login-window\">Login / Sign In</a></td></tr></table></div></form>";
			}
			else{
			echo "<input type=\"submit\" value=\"Checkout\" /></td></tr></table></div></form>";
			}
			
		}
	}
}
?>
