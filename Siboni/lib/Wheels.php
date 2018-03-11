<?php
require 'Garage.php';

class Wheel extends Garage {
	private $size;

	function __construct($size, $name, $production_year, $count) {
		parent::__construct($name, $production_year, $count, $color = 'Black');

		$this->size = $size;
		$this->name = $name;
		$this->production_year = $production_year;
		$this->count = $count;
		$this->color = $color;

	}

	public function getAbout() {
		return $this->size . " " . $this->name . " " . $this->production_year . " " . $this->count . " " . $this->color;
	}
}

//$michlen = new Wheel(25, 'Michlen', 2018, 50);
//var_dump($michlen->getAbout());