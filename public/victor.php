<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require '../../Car_Emporium/index.php';

$settings = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

$app = new \Slim\App($settings);

$container = $app->getContainer();
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('views');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $cars = Garage::getAll();
    var_dump($cars);

    return $this->view->render($response, 'home.html', [
                'cars' => $cars,
                'name_view_param' => $args['name']
    ]);
});

$app->post('/car/{car_name}/count/{car_count}/production_year/{production_year}/color/{color}', function ($request, $response, array $args) {
    $car_name = $args['car_name'];
    $car_count = $args['car_count'];
    $car_production_year = $args['production_year'];
    $car_color = $args['color'];

    $car = new Garage(ucfirst($car_name), $car_color, $car_production_year, $car_count);
    $last_id = $car->save();

    return $response->getBody()->write("the new ID is {$last_id}");
});
$app->run();
