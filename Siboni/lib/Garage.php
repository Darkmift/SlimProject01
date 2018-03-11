<?php

class Garage {
	private $name;
	private $color;
	private $production_year;
	private $count;

	function __construct($name, $color, $production_year, $count) {
		$this->name = $name;
		$this->color = $color;
		$this->production_year = $production_year;
		$this->count = $count;
	}
	public function getName() {
		return $this->name;
	}
	public function getCount() {
		return $this->count;
	}

	public function getAbout() {
		return
			"The car is {$this->getName()}, and the count is {$this->getCount()}";
	}

	public function save() {
		$stmt = DB::getConnection()->prepare("
			INSERT INTO cars (name, color, production_year)
			VALUES (?, ?, STR_TO_DATE(?, '%Y'))
		");
		$stmt->bind_param('sss', $this->name, $this->color, $this->productionDate);
		$stmt->execute();
		return $stmt;
	}
	public function update($id) {
		$stmt = DB::getConnection()->prepare("
			UPDATE cars SET `name` = ? , `color` = ? , `production_year` = ? WHERE `id` = ?
		");
		$stmt->bind_param('ssss', $this->name, $this->color, $this->productionDate, $id);
		$stmt->execute();
		return $stmt;
	}
	public function delete($id) {
		$stmt = DB::getConnection()->prepare("
			DELETE FROM cars WHERE `ID` = ?
		");
		$stmt->bind_param('s', $id);
		$stmt->execute();
		return $stmt;
	}

	public static function getAll($table) {
		return DB::getConnection()->query("
			SELECT name, color, production_year
			FROM $table
			LIMIT 300
		")->fetch_all(MYSQLI_ASSOC);
	}
}