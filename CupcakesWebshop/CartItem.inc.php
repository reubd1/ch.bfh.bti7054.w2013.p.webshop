<?php
class CartItem {
	protected $name;
	protected $price;
	protected $id;
	protected $cake;
	protected $topping;
	protected $deco;


	public function __construct($id, $name, $price, $cake, $topping, $deco) {
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->cake = $cake;
		$this->topping = $topping;
		$this->deco = $deco;
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getCake() {
		return $this->cake;
	}

	public function getTopping() {
		return $this->topping;
	}

	public function getDeco() {
		return $this->deco;
	}
}
?>
