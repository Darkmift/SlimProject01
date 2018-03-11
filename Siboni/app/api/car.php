<?php

//get list of cars
$app->get('/api/car/{name}', function ($request, $response, array $args) {
	$cars = Garage::getAll('cars');
	//var_dump($cars);

	return $this->view->render($response, 'home.html', [
		'cars' => $cars,
		'name_view_param' => $args['name'],
	]);
});

//select car
$app->get('/car/pick/id/{id}', function ($request, $response, array $args) {

	$car_id = $args['id'];

	$result = DB::getConnection()->query("
			SELECT name, color, production_year
			FROM cars
			WHERE id = '$car_id'
		");
	$data = $result->fetch_all(MYSQLI_ASSOC);

	if (isset($data) && $data != []) {

		$json = json_encode($data);

		$response->withHeader(' Content-Type', ' application/json ');
		$response->getBody()->write("$json");

	} else {

		http_response_code(204);
	}
});

//new car
$app->post('/car/{car_name}/count/{car_count}/production_year/{production_year}/color/{color}', function ($request, $response, array $args) {
	$car_name = $args['car_name'];
	$car_count = $args['car_count'];
	$car_production_year = $args['production_year'];
	$car_color = $args['color'];

	$car = new Garage(ucfirst($car_name), $car_color, $car_production_year, $car_count);
	$car->save();

	http_response_code(204);
});

//delete
$app->get('/car/delete/id/{id}', function ($request, $response, array $args) {

	$car_id = $args['id'];

	Garage::delete($car_id);

	return $response->getBody()->write("the car with ID {$car_id} deleted successfully");
});

//update
//need postman > body > x-xxx-form
$app->put('/car/update', function ($request, $response) {

	$car_name = $request->getParsedBody()['car_name'];
	$car_count = $request->getParsedBody()['car_count'];
	$car_production_year = $request->getParsedBody()['production_year'];
	$car_color = $request->getParsedBody()['color'];
	$car_id = $request->getParsedBody()['id'];

	$car = new Garage(ucfirst($car_name), $car_color, $car_production_year, $car_count);
	$car->update($car_id);

	return $response->getBody()->write("the car with ID {$car_id} updates successfully");
});
$app->run();
