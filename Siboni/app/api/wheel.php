<?php
//get list of wheels
$app->get('/api/wheel/{name}', function ($request, $response, array $args) {

	$wheels = Garage::getAll('wheels');

	return $this->view->render($response, 'home.html', [
		'wheels' => $wheels,
		'name_view_param' => $args['name'],
	]);
});
