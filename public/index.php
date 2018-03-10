<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../../Car_Emporium/index.php';

$settings = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];


$app = new \Slim\App;
$container = $app->getContainer();
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('views');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};
////
$app->get('/product/vehicle/{name}', function (Request $request, Response $response, array $args) {
    $name_url = $args['name'];
    $db = Database::getInstance();
    $output = $db->db_fetch(Vehicle::read_SqlParams($name_url), 'SELECT');
    return $response->getBody()->write("{$output}");
});
////
$app->post(
        '/product/class_type/{class_type}'
        . '/name={Obj_property_name}'
        . '&type={Obj_property_type}'
        . '&price={Obj_property_price}'
        . '&date_sold={Obj_property_date_sold}'
        . '&licensePlate={Obj_property_licensePlate}', function ($request, $response, array $args) {
    $class_type = $args['class_type'];
    $name = $args['Obj_property_name'];
    $type = $args['Obj_property_type'];
    $price = $args['Obj_property_price'];
    $date_sold = $args['Obj_property_date_sold'];
    $licensePlate = $args['Obj_property_licensePlate'];

    //////
    $factory = new Product_Factory;
    $someVehicle = $factory->create(array($class_type, $name, $type, $price, $date_sold, $licensePlate));
    $db = Database::getInstance();
    $injectarray = $someVehicle->create_SqlParams();
    $db->db_insert($injectarray[0], $injectarray[1], $someVehicle->addToInsertSQLArray());
    //////
    $last_id = $db->db_fetch(Vehicle::return_id_SqlParams($name), 'SELECT_ID');
    return $response->getBody()->write("the new ID is {$last_id}");
});
////
$app->run();























//$app->get('/{name}', function (Request $request, Response $response, array $args) {
//    $name_url = $args['name'];
//    return $response->getBody()->write("Hello {$name_url} TESTING");
//});